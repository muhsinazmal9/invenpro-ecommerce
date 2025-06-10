<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\DashboardService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {

    }

    public function __invoke(Request $request): View
    {
        $data = [
            'totalCustomer' => $this->getTotalCustomerCount(),
            'newOrder' => $this->getNewOrderCount(),
            'totalIncome' => $this->getTotalIncomeCount(),
            'salesRevenues' => $this->salesRevenueData($request),
            'orderCount' => $this->orderCount($request),
        ];
        App::setLocale('en');
        return view('backend.dashboard.index', $data);
    }

    private function getTotalCustomerCount(): int
    {

        return DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'user')
            ->count();
    }

    private function getNewOrderCount(): int
    {
        return DB::table('orders')
            ->whereDate('created_at', today())->count();
    }

    private function getTotalIncomeCount(): float
    {
        return DB::table('transactions')->where('status', Transaction::STATUS['success'])->sum('amount');
    }

    public function getTopProduct(Request $request): JsonResponse
    {
        $product = $this->dashboardService->getTopProduct($request);

        if ($product->getData()->success) {
            return response()->json($product->getData()->data);
        }

        return response()->json([]);

    }
    private function salesRevenueData(Request $request): array
    {
        $query = Transaction::query()
            ->where('status', Transaction::STATUS['success']);
    
        if ($request->sale_statistics_type == 'monthly' || $request->sale_statistics_type == null) {
            $data = array_fill_keys(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 0);
    
            $monthlyData = $query->selectRaw('COUNT(*) as count, MONTH(created_at) as month')
                ->groupByRaw('MONTH(created_at)')
                ->get();
    
            foreach ($monthlyData as $row) {
                $monthName = date('M', mktime(0, 0, 0, $row->month, 1));
                $data[$monthName] = $row->count;
            }
    
        } elseif ($request->sale_statistics_type == 'yearly') {
            $data = [];
    
            $yearlyData = $query->selectRaw('COUNT(*) as count, YEAR(created_at) as year')
                ->groupByRaw('YEAR(created_at)')
                ->get();
    
            foreach ($yearlyData as $row) {
                $data[$row->year] = $row->count;
            }
    
        } elseif ($request->sale_statistics_type == 'weekly') {
            // Initialize week days with zero counts
            $data = array_fill_keys(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], 0);
    
            // Fetch weekly sales count in one query
            $weeklyData = $query->selectRaw('COUNT(*) as count, DAYOFWEEK(created_at) as weekday')
                ->groupByRaw('DAYOFWEEK(created_at)')
                ->get();
    
            foreach ($weeklyData as $row) {
                $dayName = date('D', strtotime("Sunday +{$row->weekday} days"));
                $data[$dayName] = $row->count;
            }
        }
    
        return $data;
    }
    
    public function getTodaysTransactionsList(Request $request)
    {

        $transaction = $this->dashboardService->getTodaysTransactionsList($request);

        if ($transaction->getData()->success) {
            return response()->json($transaction->getData()->data);
        }

        return response()->json([]);

    }

    public function getProductReview(Request $request): JsonResponse
    {
        $productReviews = $this->dashboardService->getProductReview($request);

        if ($productReviews->getData()->success) {
            return response()->json($productReviews->getData()->data);
        }

        return response()->json([]);

    }
    private function orderCount(Request $request)
    {
        $query = Order::query()
            ->where('order_status', Order::ORDER_STATUS['delivered']);
    
        if ($request->order_statistics_type === 'monthly' || $request->order_statistics_type === null) {
            $data = array_fill_keys(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 0);
    
            $monthlyData = $query->selectRaw('COUNT(*) as count, MONTH(created_at) as month')
                ->groupByRaw('MONTH(created_at)')
                ->orderByRaw('MONTH(created_at)')
                ->get();
    
            foreach ($monthlyData as $row) {
                $monthName = date('M', mktime(0, 0, 0, $row->month, 1));
                $data[$monthName] = (int) $row->count;
            }
    
        } elseif ($request->order_statistics_type === 'yearly') {
            $data = [];
    
            $yearlyData = $query->selectRaw('COUNT(*) as count, YEAR(created_at) as year')
                ->groupByRaw('YEAR(created_at)')
                ->orderByRaw('YEAR(created_at)')
                ->get();
    
            foreach ($yearlyData as $row) {
                $data[(int) $row->year] = (int) $row->count;
            }
    
        } elseif ($request->order_statistics_type === 'weekly') {
            $data = array_fill_keys(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], 0);
    
            $weeklyData = $query->selectRaw('COUNT(*) as count, DAYOFWEEK(created_at) as weekday')
                ->groupByRaw('DAYOFWEEK(created_at)')
                ->orderByRaw('DAYOFWEEK(created_at)')
                ->get();
    
            foreach ($weeklyData as $row) {
                $dayName = date('D', strtotime("Sunday +{$row->weekday} days"));
                $data[$dayName] = (int) $row->count;
            }
        }
    
        return $data;
    }
    
    

    public function getUserActivity(Request $request): JsonResponse
    {
        $userActivity = $this->dashboardService->getUserActivity($request);

        if ($userActivity->getData()->success) {
            return response()->json($userActivity->getData()->data);
        }

        return response()->json([]);
    }

    public function getAllUsers(Request $request)
    {
        $query = User::query()->where('id', '!=', auth()->id());

        if ($searchItem = $request->searchItem) {
            $query->where(function ($query) use ($searchItem) {
                $query->where('fname', 'like', "%{$searchItem}%")
                    ->orWhere('lname', 'like', "%{$searchItem}%")
                    ->orWhere('email', 'like', "%{$searchItem}%");
            });
        }

        return $query->paginate(
            $request->perPage ?? 20,
            ['*'],
            'page',
            $request->page
        );
    }
}
