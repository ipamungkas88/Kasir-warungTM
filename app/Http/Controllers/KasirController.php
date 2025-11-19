<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KasirController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
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
            'payment_method' => 'required|in:cash,qris,digital',
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
            ->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search) {
            $query->where('transaction_code', 'like', "%{$request->search}%");
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->paginate(15);
        
        // Add total_items calculation for each transaction
        $transactions->getCollection()->transform(function ($transaction) {
            $transaction->total_items = $transaction->items->sum('quantity');
            // Ensure transaction_code exists
            if (!$transaction->transaction_code) {
                $transaction->transaction_code = 'TRX-' . $transaction->id;
            }
            return $transaction;
        });
        
        $totalRevenue = Transaction::with(['items.menu', 'user'])
            ->when($request->has('search') && $request->search, function ($q) use ($request) {
                $q->where('transaction_code', 'like', "%{$request->search}%");
            })
            ->when($request->has('date_from') && $request->date_from, function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->has('date_to') && $request->date_to, function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->sum('total_amount');

        return view('pages.kasir.riwayat-transaksi', compact('transactions', 'totalRevenue'));
    }

    public function transactionDetail($id)
    {
        try {
            $transaction = Transaction::with(['items.menu', 'user'])->findOrFail($id);
            
            // Calculate additional data
            $totalItems = $transaction->items->sum('quantity');
            $transaction->total_items = $totalItems;
            
            // Format response with calculated fields
            $responseData = [
                'id' => $transaction->id,
                'transaction_code' => $transaction->transaction_code ?? 'TRX-' . $transaction->id,
                'created_at' => $transaction->created_at,
                'total_amount' => $transaction->total_amount,
                'paid_amount' => $transaction->paid_amount ?? $transaction->total_amount,
                'change_amount' => ($transaction->paid_amount ?? $transaction->total_amount) - $transaction->total_amount,
                'payment_method' => $transaction->payment_method,
                'status' => $transaction->status,
                'notes' => $transaction->notes,
                'total_items' => $totalItems,
                'user' => [
                    'id' => $transaction->user->id,
                    'name' => $transaction->user->name,
                    'username' => $transaction->user->username,
                    'role' => $transaction->user->role
                ],
                'items' => $transaction->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'subtotal' => $item->quantity * $item->price,
                        'menu' => [
                            'id' => $item->menu->id,
                            'name' => $item->menu->name,
                            'price' => $item->menu->price
                        ]
                    ];
                })
            ];
            
            return response()->json([
                'success' => true,
                'transaction' => $responseData
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Transaction detail error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan atau terjadi kesalahan.',
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function createPaymentToken(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Calculate totals and prepare items
            $totalAmount = 0;
            $totalItems = 0;
            $items = [];
            $itemDetails = [];

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

                // Prepare item details for Midtrans
                $itemDetails[] = [
                    'id' => $menu->id,
                    'price' => $menu->price,
                    'quantity' => $quantity,
                    'name' => $menu->name,
                ];

                $totalAmount += $subtotal;
                $totalItems += $quantity;
            }

            // Generate unique order ID
            $orderId = 'ORDER-' . time() . '-' . auth()->id();

            // Create transaction with pending status
            $transaction = Transaction::create([
                'transaction_code' => Transaction::generateTransactionCode(),
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'total_items' => $totalItems,
                'payment_method' => 'qris',
                'payment_status' => 'pending',
                'midtrans_order_id' => $orderId,
                'paid_amount' => 0,
                'change_amount' => 0,
                'status' => 'pending',
                'notes' => $request->notes
            ]);

            // Create transaction items
            foreach ($items as $item) {
                $item['transaction_id'] = $transaction->id;
                TransactionItem::create($item);
            }

            // Prepare Midtrans transaction details
            $transactionDetails = [
                'order_id' => $orderId,
                'gross_amount' => $totalAmount,
            ];

            $customerDetails = [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email ?? 'customer@warungtm.com',
                'phone' => '08123456789', // You might want to add this to user table
            ];

            // Create Snap token
            $snapToken = $this->midtransService->createSnapToken($transactionDetails, $customerDetails, $itemDetails);

            // Update transaction with payment token
            $transaction->update(['payment_token' => $snapToken]);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'transaction' => $transaction
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function midtransCallback(Request $request)
    {
        try {
            $orderId = $request->order_id;
            $statusCode = $request->status_code;
            $grossAmount = $request->gross_amount;
            
            // Verify signature hash (optional but recommended for security)
            $serverKey = config('midtrans.server_key');
            $signatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($request->signature_key && $signatureKey !== $request->signature_key) {
                return response()->json(['message' => 'Invalid signature'], 401);
            }

            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status ?? null;

            \Log::info('Midtrans Callback', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'status_code' => $statusCode
            ]);

            // Find transaction by midtrans order ID
            $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Update transaction status based on Midtrans response
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $transaction->update([
                    'payment_status' => 'paid',
                    'status' => 'completed',
                    'paid_amount' => $grossAmount,
                ]);
            } elseif ($transactionStatus == 'pending') {
                $transaction->update([
                    'payment_status' => 'pending',
                ]);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $transaction->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                ]);
            }

            return response()->json(['message' => 'Callback processed successfully']);

        } catch (\Exception $e) {
            \Log::error('Midtrans Callback Error', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);
            return response()->json(['message' => 'Error processing callback: ' . $e->getMessage()], 500);
        }
    }

    public function checkPaymentStatus($orderId)
    {
        try {
            $transaction = Transaction::where('midtrans_order_id', $orderId)->first();
            
            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found'
                ], 404);
            }

            // Check status from Midtrans
            $status = $this->midtransService->getTransactionStatus($orderId);
            
            // Update local transaction status based on Midtrans response
            $statusData = is_object($status) ? (array) $status : $status;
            $transactionStatus = $statusData['transaction_status'] ?? null;
            $grossAmount = $statusData['gross_amount'] ?? 0;
            
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $transaction->update([
                    'payment_status' => 'paid',
                    'status' => 'completed',
                    'paid_amount' => $grossAmount,
                ]);
            } elseif ($transactionStatus == 'pending') {
                $transaction->update([
                    'payment_status' => 'pending',
                ]);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $transaction->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                ]);
            }

            return response()->json([
                'success' => true,
                'transaction' => $transaction->fresh(),
                'midtrans_status' => $status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking payment status: ' . $e->getMessage()
            ], 500);
        }
    }
}
