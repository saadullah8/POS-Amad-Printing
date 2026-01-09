<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function daily(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');

        $orders = Order::whereDate('created_at', $date)->orderBy('id', 'desc')->get();

        $totalSale = (float) $orders->sum('total');
        $totalOrders = $orders->count();

        $cashCount = Order::whereDate('created_at', $date)->where('payment_method', 'cash')->count();
        $onlineCount = Order::whereDate('created_at', $date)->where('payment_method', 'online')->count();

        return view('admin.reports.daily', [
            'heading' => 'Daily Report',
            'title'   => 'Daily Report',
            'active'  => 'reports',
            'orders'  => $orders,
            'totalSale' => $totalSale,
            'totalOrders' => $totalOrders,
            'cashCount' => $cashCount,
            'onlineCount' => $onlineCount,
        ]);
    }

    public function weekly(Request $request)
    {
        $from = $request->from ?? now()->subDays(6)->format('Y-m-d');
        $to   = $request->to   ?? now()->format('Y-m-d');

        $orders = Order::whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get();

        $totalSale = (float) $orders->sum('total');
        $totalOrders = $orders->count();

        // day-wise summary
        $rows = Order::select(
            DB::raw("DATE(created_at) as date"),
            DB::raw("COUNT(*) as orders"),
            DB::raw("SUM(total) as sale")
        )
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy(DB::raw("DATE(created_at)"), 'asc')
            ->get();

        $days = $rows->map(fn($r) => [
            'date' => $r->date,
            'orders' => (int)$r->orders,
            'sale' => (float)$r->sale
        ])->toArray();

        return view('admin.reports.weekly', [
            'heading' => 'Weekly Report',
            'title'   => 'Weekly Report',
            'active'  => 'reports',
            'totalSale' => $totalSale,
            'totalOrders' => $totalOrders,
            'days' => $days,
        ]);
    }

    public function monthly(Request $request)
    {
        $month = $request->month ?? date('Y-m'); // YYYY-MM

        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));

        $orders = Order::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('id', 'desc')
            ->get();

        $totalSale = (float) $orders->sum('total');
        $totalOrders = $orders->count();

        // top service (optional)
        $top = OrderItem::select('service_id', DB::raw('SUM(qty) as qty_sum'))
            ->whereHas('order', function ($q) use ($start, $end) {
                $q->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end);
            })
            ->groupBy('service_id')
            ->orderByDesc('qty_sum')
            ->with('service')
            ->first();

        $topService = $top && $top->service ? $top->service->name : '-';

        return view('admin.reports.monthly', [
            'heading' => 'Monthly Report',
            'title'   => 'Monthly Report',
            'active'  => 'reports',
            'orders'  => $orders,
            'totalSale' => $totalSale,
            'totalOrders' => $totalOrders,
            'topService' => $topService,
        ]);
    }

    public function yearly(Request $request)
    {
        $year = $request->year ?? date('Y');

        $start = $year . '-01-01';
        $end   = $year . '-12-31';

        $orders = Order::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->get();

        $totalSale = (float) $orders->sum('total');
        $totalOrders = $orders->count();

        // month-wise summary
        $rows = Order::select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw("COUNT(*) as orders"),
            DB::raw("SUM(total) as sale")
        )
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy(DB::raw("MONTH(created_at)"), 'asc')
            ->get();

        $months = $rows->map(fn($r) => [
            'month' => (int)$r->month,
            'orders' => (int)$r->orders,
            'sale' => (float)$r->sale
        ])->toArray();

        return view('admin.reports.yearly', [
            'heading' => 'Yearly Report',
            'title'   => 'Yearly Report',
            'active'  => 'reports',
            'year'    => $year,
            'totalSale' => $totalSale,
            'totalOrders' => $totalOrders,
            'months' => $months,
        ]);
    }
}
