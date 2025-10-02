<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $userId = auth()->id();
        
        // Statistics for today
        $todayTransactions = Transaction::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->where('status', 'completed');
            
        $todayCount = $todayTransactions->count();
        $todayTotal = $todayTransactions->sum('total_amount');
        $todayItems = $todayTransactions->sum('total_items');
        
        // Recent transactions
        $recentTransactions = Transaction::with('items.menu')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Popular items today
        $popularItems = TransactionItem::select('menu_name', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('transaction', function($query) use ($userId, $today) {
                $query->where('user_id', $userId)
                      ->whereDate('created_at', $today)
                      ->where('status', 'completed');
            })
            ->groupBy('menu_name')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        return view('pages.kasir.dashboard', compact(
            'todayCount', 
            'todayTotal', 
            'todayItems', 
            'recentTransactions',
            'popularItems'
        ));
    }

    public function transaksi()
    {
        $menus = Menu::where('is_available', true)->get()->groupBy('category');
        return view('pages.kasir.transaksi', compact('menus'));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,digital',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Calculate totals
            $totalAmount = 0;
            $totalItems = 0;
            $items = [];

            foreach ($request->items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);
                $quantity = $item['quantity'];
                $subtotal = $menu->price * $quantity;

                $items[] = [
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'menu_price' => $menu->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'notes' => $item['notes'] ?? null
                ];

                $totalAmount += $subtotal;
                $totalItems += $quantity;
            }

            // Create transaction
            $transaction = Transaction::create([
                'transaction_code' => Transaction::generateTransactionCode(),
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'total_items' => $totalItems,
                'payment_method' => $request->payment_method,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->paid_amount - $totalAmount,
                'status' => 'completed',
                'notes' => $request->notes
            ]);

            // Create transaction items
            foreach ($items as $item) {
                $item['transaction_id'] = $transaction->id;
                TransactionItem::create($item);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'transaction' => $transaction->load('items')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function riwayatTransaksi(Request $request)
    {
        $query = Transaction::with(['items.menu', 'user'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('transaction_code', 'like', "%{$search}%");
        }

        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->paginate(15);

        // Calculate summary statistics for filtered results
        $summaryQuery = Transaction::where('user_id', auth()->id());
        
        if ($request->has('search') && $request->search) {
            $summaryQuery->where('transaction_code', 'like', "%{$request->search}%");
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $summaryQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $summaryQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $totalRevenue = $summaryQuery->sum('total_amount');

        return view('pages.kasir.riwayat-transaksi', compact('transactions', 'totalRevenue'));
    }

    public function transactionDetail($id)
    {
        try {
            $transaction = Transaction::with(['items.menu', 'user'])
                ->where('id', $id)
                ->where('user_id', auth()->id()) // Ensure kasir can only see their own transactions
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'transaction' => $transaction
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }
    }
}
