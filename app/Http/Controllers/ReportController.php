<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Exports\TransactionExport;
use App\Models\Order;
use App\Services\ReportService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(
        private ReportService $reportService
    ) {

    }

    public function salesIndex(): View
    {

        $orders = Order::query()->where('order_status', Order::ORDER_STATUS['delivered']);

        return view('backend.reports.sales', [
            'totalOrders' => $orders->count(),
            'totalSales' => $orders->sum('grand_total'),
            'todaysSales' => $orders->whereDate('created_at', today())->sum('grand_total'),

        ]);
    }

    public function getSalesList(Request $request): JsonResponse
    {
        $salesReport = $this->reportService->getSalesList($request);

        if ($salesReport->getData()->success) {
            return response()->json($salesReport->getData()->data);
        }

        return response()->json([]);
    }

    public function exportSales(Request $request, $type)
    {
        if ($type == 'pdf') {
            return Excel::download(new OrderExport(), 'sales.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }

        if ($type == 'csv') {
            return Excel::download(new OrderExport(), 'sales.csv', \Maatwebsite\Excel\Excel::CSV);
        }

        if ($type == 'xlsx') {
            return Excel::download(new OrderExport(), 'sales.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }

        return redirect()->back();
    }

    public function transactionIndex(): View
    {

        $orders = Order::query()->where('order_status', Order::ORDER_STATUS['delivered']);

        return view('backend.reports.transaction', [
            'totalOrders' => $orders->count(),
            'totalSales' => $orders->sum('grand_total'),
            'todaysSales' => $orders->whereDate('created_at', today())->sum('grand_total'),

        ]);
    }

    public function getTransactionList(Request $request): JsonResponse
    {
        $transactionReport = $this->reportService->getTransactionList($request);

        if ($transactionReport->getData()->success) {
            return response()->json($transactionReport->getData()->data);
        }

        return response()->json([]);
    }

    public function exportTransaction(Request $request, $type)
    {

        $status = $request->status == 'success' ? 3 : '';

        if ($type == 'pdf') {
            return Excel::download(new TransactionExport($status), 'transactions.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }

        if ($type == 'csv') {
            return Excel::download(new TransactionExport($status), 'transactions.csv', \Maatwebsite\Excel\Excel::CSV);
        }

        if ($type == 'xlsx') {
            return Excel::download(new TransactionExport($status), 'transactions.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }

        return redirect()->back();
    }
}
