<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // Date Range Filter
        $range = $request->get('range', '7');
        $from  = $request->get('from');
        $to    = $request->get('to');

        if ($range === 'today') {
            $startDate = Carbon::today();
            $endDate   = Carbon::today()->endOfDay();
        } elseif ($from && $to) {
            $startDate = Carbon::parse($from)->startOfDay();
            $endDate   = Carbon::parse($to)->endOfDay();
            $range     = 'custom';
        } elseif ($from) {
            $startDate = Carbon::parse($from)->startOfDay();
            $endDate   = Carbon::now()->endOfDay();
            $range     = 'custom';
        } else {
            $days      = (int) $range ?: 7;
            $startDate = Carbon::now()->subDays($days)->startOfDay();
            $endDate   = Carbon::now()->endOfDay();
        }

        $prevStart = (clone $startDate)->subDays($startDate->diffInDays($endDate) + 1);
        $prevEnd   = (clone $startDate)->subSecond();

        // Core Stats (all-time)
        $totalUsers    = User::count();
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalRevenue  = Order::where('status', 'delivered')
            ->selectRaw('SUM(price * qty) as total')
            ->value('total') ?? 0;

        // Period Stats with growth vs previous period
        $periodOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $prevOrders   = Order::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $orderGrowth  = $prevOrders > 0
            ? round((($periodOrders - $prevOrders) / $prevOrders) * 100, 1) : 0;

        $periodRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'delivered')
            ->selectRaw('SUM(price * qty) as total')
            ->value('total') ?? 0;
        $prevRevenue = Order::whereBetween('created_at', [$prevStart, $prevEnd])
            ->where('status', 'delivered')
            ->selectRaw('SUM(price * qty) as total')
            ->value('total') ?? 0;
        $revenueGrowth = $prevRevenue > 0
            ? round((($periodRevenue - $prevRevenue) / $prevRevenue) * 100, 1) : 0;

        $periodUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $prevUsers   = User::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $userGrowth  = $prevUsers > 0
            ? round((($periodUsers - $prevUsers) / $prevUsers) * 100, 1) : 0;

        // Order Statuses
        $pending    = Order::where('status', 'pending')->count();
        $processing = Order::where('status', 'processing')->count();
        $shipping   = Order::where('status', 'shipping')->count();
        $delivered  = Order::where('status', 'delivered')->count();

        // Category Chart
        $categories   = Category::withCount('products')->get();
        $allcatNames  = $categories->pluck('name');
        $productcount = $categories->pluck('products_count');

        // Sales Trend
        $salesChart = Order::selectRaw('DATE(created_at) as date, SUM(price * qty) as total')
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Customer Acquisition
        $acquisitionChart = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // AOV Trend
        $aovChart = Order::selectRaw('DATE(created_at) as date, AVG(price * qty) as avg_value')
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Top Selling Products
        $topProducts = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(orders.qty) as units_sold'),
                DB::raw('SUM(orders.price * orders.qty) as revenue')
            )
            ->where('orders.status', 'delivered')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        // Repeat vs New Customers
        $repeatCustomers = Order::select('user_id')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get()->count();

        $newCustomers = Order::select('user_id')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) = 1')
            ->get()->count();

        // Geographic Breakdown
        $geoData = Order::selectRaw("TRIM(SUBSTRING_INDEX(address, ',', 1)) as city, COUNT(*) as count")
            ->whereNotNull('address')
            ->where('address', '!=', '')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('city')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        // Reviews Summary
        $avgRating     = Review::avg('rating') ?? 0;
        $totalReviews  = Review::count();
        $ratingDist    = Review::selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderByDesc('rating')
            ->get();
        $recentReviews = Review::with('user', 'product')
            ->latest()
            ->take(3)
            ->get();

        // Audit Log
        $auditOrders = Order::with('user')->latest()->take(5)->get()->map(function ($o) {
            return (object)[
                'description' => 'Order #' . $o->id . ' by ' . ($o->name ?? optional($o->user)->name ?? 'Guest') . ' [' . ucfirst($o->status) . ']',
                'created_at'  => $o->created_at,
            ];
        });
        $auditUsers = User::latest()->take(3)->get()->map(function ($u) {
            return (object)[
                'description' => 'New user registered: ' . $u->name,
                'created_at'  => $u->created_at,
            ];
        });
        $auditLog = $auditOrders->merge($auditUsers)
            ->sortByDesc('created_at')
            ->take(8)
            ->values();

        // Recent Orders
        $recentOrders = Order::with('user')->latest()->take(7)->get();

        // Low Stock
        $lowStock = Product::where('stock', '<', 5)->orderBy('stock')->get();

        // Admin Tasks
        $adminTasks = [];
        if ($pending > 0) {
            $adminTasks[] = [
                'label' => "Review {$pending} pending orders",
                'type'  => 'warning',
                'link'  => route('order.index', ['status' => 'pending']),
            ];
        }
        if ($lowStock->count() > 0) {
            $adminTasks[] = [
                'label' => "{$lowStock->count()} items need restocking",
                'type'  => 'danger',
                'link'  => route('product.index'),
            ];
        }
        if ($totalReviews > 0) {
            $adminTasks[] = [
                'label' => "Check latest customer reviews",
                'type'  => 'info',
                'link'  => '#reviews',
            ];
        }

        // Delivery Rate & Avg Order Value
        $deliveryRate  = $totalOrders > 0 ? round(($delivered / $totalOrders) * 100, 1) : 0;
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;

        // Payment Method Breakdown
        $paymentMethods = Order::selectRaw('payment_method, COUNT(*) as count')
            ->whereNotNull('payment_method')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('payment_method')
            ->orderByDesc('count')
            ->get();

        return view('dashboard', compact(
            'totalUsers', 'totalProducts', 'totalOrders', 'totalRevenue',
            'orderGrowth', 'revenueGrowth', 'userGrowth',
            'periodOrders', 'periodRevenue', 'periodUsers',
            'pending', 'processing', 'shipping', 'delivered',
            'allcatNames', 'productcount',
            'salesChart', 'acquisitionChart', 'aovChart',
            'topProducts',
            'repeatCustomers', 'newCustomers',
            'geoData',
            'avgRating', 'totalReviews', 'ratingDist', 'recentReviews',
            'auditLog', 'adminTasks',
            'recentOrders', 'lowStock',
            'deliveryRate', 'avgOrderValue',
            'paymentMethods',
            'range', 'from', 'to', 'startDate', 'endDate'
        ));
    }

    // Export CSV
    public function exportCsv(Request $request)
    {
        $orders = Order::with('user')->latest()->get();

        $filename = 'dashboard_orders_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $fh = fopen('php://output', 'w');
            fputcsv($fh, ['Order ID', 'Customer Name', 'Phone', 'Address', 'Price', 'Qty', 'Total', 'Status', 'Payment', 'Date']);
            foreach ($orders as $o) {
                fputcsv($fh, [
                    '#' . $o->id,
                    $o->name ?? optional($o->user)->name ?? 'Guest',
                    $o->phone ?? '',
                    $o->address ?? '',
                    $o->price,
                    $o->qty,
                    $o->price * $o->qty,
                    $o->status,
                    $o->payment_method ?? '',
                    $o->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($fh);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function search(Request $request)
    {
        $term = $request->q;

        // PRODUCTS
        $products = Product::where('name', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%")
            ->select('id', 'name', 'price', 'stock')
            ->take(5)
            ->get();

        // ORDERS
        $orders = Order::with('user')
            ->where('id', 'like', "%{$term}%")
            ->orWhere('name', 'like', "%{$term}%")
            ->take(5)
            ->get();

        // USERS
        $users = User::where('name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->take(5)
            ->get();

        return response()->json([
            'products' => $products,
            'orders'   => $orders,
            'users'    => $users,
        ]);
    }
}
