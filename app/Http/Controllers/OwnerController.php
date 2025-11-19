<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class OwnerController extends Controller
{
    // 1. Dashboard Owner
    public function dashboard()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        // Daily sales summary
        $dailySales = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total_amount');
            
        $dailyTransactions = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        // Weekly sales data for chart (last 7 days)
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $sales = Transaction::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('total_amount');
            $weeklyData[] = [
                'date' => $date->format('M d'),
                'sales' => $sales
            ];
        }

        // Monthly comparison
        $thisMonth = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->where('status', 'completed')
            ->sum('total_amount');
            
        $lastMonth = Transaction::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->where('status', 'completed')
            ->sum('total_amount');

        // Low stock items (assuming we have stock field in menus table)
        $lowStockItems = Menu::where('stock', '<=', 10)->get();

        // Popular items this month
        $popularItems = TransactionItem::select('menu_name', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('transaction', function($query) {
                $query->where('status', 'completed')
                      ->whereMonth('created_at', Carbon::now()->month);
            })
            ->groupBy('menu_name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return view('pages.owner.dashboard', compact(
            'dailySales', 
            'dailyTransactions', 
            'weeklyData', 
            'thisMonth', 
            'lastMonth',
            'lowStockItems',
            'popularItems'
        ));
    }

    // 2. Manajemen Menu
    public function manajemenMenu()
    {
        $menus = Menu::orderBy('created_at', 'desc')->paginate(10);
        return view('pages.owner.manajemen-menu', compact('menus'));
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:Makanan,Minuman,Snack',
            'stock' => 'required|integer|min:0',
        ]);

        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'stock' => $request->stock,
            'is_available' => true,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function updateMenu(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:Makanan,Minuman,Snack',
            'stock' => 'required|integer|min:0',
            'is_available' => 'boolean',
        ]);

        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'stock' => $request->stock,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->back()->with('success', 'Menu berhasil diperbarui!');
    }

    public function deleteMenu(Menu $menu)
    {
        $menu->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    // 3. Laporan Penjualan
    public function laporanPenjualan(Request $request)
    {
        $period = $request->get('period', 'daily');
        $startDate = null;
        $endDate = null;
        
        // Set dates based on period type
        switch ($period) {
            case 'daily':
                $dailyDate = $request->get('daily_date', Carbon::today()->format('Y-m-d'));
                $startDate = Carbon::parse($dailyDate);
                $endDate = Carbon::parse($dailyDate);
                break;
                
            case 'weekly':
                $month = $request->get('weekly_month', Carbon::now()->month);
                $week = $request->get('weekly_week', 1);
                $year = Carbon::now()->year;
                
                // Calculate start and end date for the specific week
                $firstDayOfMonth = Carbon::create($year, $month, 1);
                $startOfWeek = $firstDayOfMonth->copy()->addWeeks($week - 1)->startOfWeek();
                $endOfWeek = $startOfWeek->copy()->endOfWeek();
                
                // Make sure we don't go outside the selected month
                $endOfMonth = $firstDayOfMonth->copy()->endOfMonth();
                if ($startOfWeek->month != $month) {
                    $startOfWeek = $firstDayOfMonth->copy();
                }
                if ($endOfWeek > $endOfMonth) {
                    $endOfWeek = $endOfMonth;
                }
                
                $startDate = $startOfWeek;
                $endDate = $endOfWeek;
                break;
                
            case 'monthly':
                $month = $request->get('monthly_month', Carbon::now()->month);
                $year = $request->get('monthly_year', Carbon::now()->year);
                
                $startDate = Carbon::create($year, $month, 1);
                $endDate = $startDate->copy()->endOfMonth();
                break;
                
            case 'custom':
                $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : Carbon::today();
                $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : Carbon::today();
                break;
        }

        // Get transactions within date range
        $transactions = Transaction::with(['user', 'items.menu'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate summary statistics
        $totalSales = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();
        $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;

        // Prepare chart data based on period
        $chartData = $this->prepareChartData($transactions, $period, $startDate, $endDate);

        return view('pages.owner.laporan-penjualan', compact(
            'transactions',
            'totalSales', 
            'totalTransactions', 
            'averageTransaction',
            'chartData',
            'period',
            'startDate',
            'endDate'
        ));
    }

    private function prepareChartData($transactions, $period, $startDate, $endDate)
    {
        $chartData = [];
        
        switch ($period) {
            case 'daily':
                // Hourly breakdown for daily view
                for ($hour = 0; $hour < 24; $hour++) {
                    $hourlyTransactions = $transactions->filter(function ($transaction) use ($hour) {
                        return $transaction->created_at->hour == $hour;
                    });
                    
                    $chartData[] = [
                        'label' => sprintf('%02d:00', $hour),
                        'value' => $hourlyTransactions->sum('total_amount')
                    ];
                }
                break;
                
            case 'weekly':
                // Daily breakdown for weekly view
                $current = $startDate->copy();
                while ($current <= $endDate) {
                    $dayTransactions = $transactions->filter(function ($transaction) use ($current) {
                        return $transaction->created_at->toDateString() == $current->toDateString();
                    });
                    
                    $chartData[] = [
                        'label' => $current->format('D, j M'),
                        'value' => $dayTransactions->sum('total_amount')
                    ];
                    
                    $current->addDay();
                }
                break;
                
            case 'monthly':
                // Weekly breakdown for monthly view
                $current = $startDate->copy()->startOfWeek();
                $weekNumber = 1;
                
                while ($current <= $endDate) {
                    $weekEnd = $current->copy()->endOfWeek();
                    if ($weekEnd > $endDate) {
                        $weekEnd = $endDate;
                    }
                    
                    $weekTransactions = $transactions->filter(function ($transaction) use ($current, $weekEnd) {
                        return $transaction->created_at >= $current && $transaction->created_at <= $weekEnd;
                    });
                    
                    $chartData[] = [
                        'label' => 'Week ' . $weekNumber,
                        'value' => $weekTransactions->sum('total_amount')
                    ];
                    
                    $current->addWeek();
                    $weekNumber++;
                }
                break;
                
            case 'custom':
                // Daily breakdown for custom period
                $current = $startDate->copy();
                while ($current <= $endDate) {
                    $dayTransactions = $transactions->filter(function ($transaction) use ($current) {
                        return $transaction->created_at->toDateString() == $current->toDateString();
                    });
                    
                    $chartData[] = [
                        'label' => $current->format('j M'),
                        'value' => $dayTransactions->sum('total_amount')
                    ];
                    
                    $current->addDay();
                }
                break;
        }
        
        return $chartData;
    }

    public function exportPDF(Request $request)
    {
        $data = $this->getSalesReportData($request);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.sales-pdf', $data);
        
        $filename = 'laporan-penjualan-' . $data['startDate']->format('Y-m-d') . '-to-' . $data['endDate']->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getSalesReportData($request);
        
        $filename = 'laporan-penjualan-' . $data['startDate']->format('Y-m-d') . '-to-' . $data['endDate']->format('Y-m-d') . '.xlsx';
        
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SalesReportExport($data), $filename);
    }

    private function getSalesReportData(Request $request)
    {
        $period = $request->get('period', 'daily');
        $startDate = null;
        $endDate = null;
        
        // Set dates based on period type (same logic as laporanPenjualan)
        switch ($period) {
            case 'daily':
                $dailyDate = $request->get('daily_date', Carbon::today()->format('Y-m-d'));
                $startDate = Carbon::parse($dailyDate);
                $endDate = Carbon::parse($dailyDate);
                break;
                
            case 'weekly':
                $month = $request->get('weekly_month', Carbon::now()->month);
                $week = $request->get('weekly_week', 1);
                $year = Carbon::now()->year;
                
                $firstDayOfMonth = Carbon::create($year, $month, 1);
                $startOfWeek = $firstDayOfMonth->copy()->addWeeks($week - 1)->startOfWeek();
                $endOfWeek = $startOfWeek->copy()->endOfWeek();
                
                $endOfMonth = $firstDayOfMonth->copy()->endOfMonth();
                if ($startOfWeek->month != $month) {
                    $startOfWeek = $firstDayOfMonth->copy();
                }
                if ($endOfWeek > $endOfMonth) {
                    $endOfWeek = $endOfMonth;
                }
                
                $startDate = $startOfWeek;
                $endDate = $endOfWeek;
                break;
                
            case 'monthly':
                $month = $request->get('monthly_month', Carbon::now()->month);
                $year = $request->get('monthly_year', Carbon::now()->year);
                
                $startDate = Carbon::create($year, $month, 1);
                $endDate = $startDate->copy()->endOfMonth();
                break;
                
            case 'custom':
                $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : Carbon::today();
                $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : Carbon::today();
                break;
        }

        $transactions = Transaction::with(['user', 'items.menu'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSales = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();
        $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
        $chartData = $this->prepareChartData($transactions, $period, $startDate, $endDate);

        return compact(
            'transactions',
            'totalSales',
            'totalTransactions',
            'averageTransaction',
            'chartData',
            'period',
            'startDate',
            'endDate'
        );
    }

    // 4. Riwayat Transaksi (sama seperti kasir tapi bisa lihat semua)
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

        return view('pages.owner.riwayat-transaksi', compact('transactions', 'totalRevenue'));
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

    // 5. Manajemen Pengguna
    public function manajemenPengguna()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('pages.owner.manajemen-pengguna', compact('users'));
    }

    public function storeUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'required|in:owner,kasir',
            ]);

            User::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['username'] . '@warung.tm', // dummy email
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
            ]);

            return response()->json(['success' => true, 'message' => 'Pengguna berhasil ditambahkan!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $user = User::findOrFail($userId);
            
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'role' => 'required|in:owner,kasir',
                'password' => 'nullable|string|min:6',
            ]);

            $updateData = [
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'role' => $validatedData['role'],
            ];

            if (!empty($validatedData['password'])) {
                $updateData['password'] = Hash::make($validatedData['password']);
            }

            $user->update($updateData);

            return response()->json(['success' => true, 'message' => 'Pengguna berhasil diperbarui!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $user = User::findOrFail($userId);
            
            if ($user->id === auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus akun sendiri!']);
            }

            $user->delete();
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
