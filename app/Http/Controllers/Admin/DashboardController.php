<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $gaurd;
    public $meta_data;
    public function __construct() 
    {
        $this->gaurd = view()->shared('auth_gaurd');
        $this->meta_data = [
            'title' => __('message.dashboard.page_title'),
            'description' => 'Admin Dashboard',
            'keywords' => 'Admin Dashboard',
        ];
    }
    public function index(){
        $auth_user = auth()->guard($this->gaurd);

        $start_of_month = Carbon::now()->startOfMonth();
        $end_of_month = Carbon::now()->endOfMonth();
        $period_income = Income::whereBetween('date', [$start_of_month, $end_of_month])->sum('amount');
        $period_expenses = Expense::whereBetween('expense_date', [$start_of_month, $end_of_month])->sum('amount');

        $lowest_category = Expense::with(['category:id,category_name'])
        ->select('category_type_id', DB::raw('SUM(amount) as total_amount'))
        ->whereBetween('expense_date', [$start_of_month, $end_of_month])
        ->groupBy('category_type_id')
        ->orderBy('total_amount', 'asc')
        ->first()
        ->toArray();

        $highest_category = Expense::with(['category:id,category_name'])
        ->select('category_type_id', DB::raw('SUM(amount) as total_amount'))
        ->whereBetween('expense_date', [$start_of_month, $end_of_month])
        ->groupBy('category_type_id')
        ->orderBy('total_amount', 'desc')
        ->first()
        ->toArray();

        $category_expenses = ExpenseCategory::select('expense_categories.category_name', DB::raw('CAST(SUM(expenses.amount) AS DOUBLE) as total'))
            ->leftJoin('expenses', 'expense_categories.id', '=', 'expenses.category_type_id')
            ->groupBy('expense_categories.id', 'expense_categories.category_name')
            ->whereBetween('expenses.expense_date', [$start_of_month, $end_of_month])
            ->get();

        $recent_transations = Expense::select('id', 'text', 'amount', 'account_id', 'category_type_id')
            ->with([
                'category:id,category_name',
                'account:id,name'
            ])
            ->whereBetween('expense_date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
            ->get();
            
        $response_data = [
            'meta_data' => $this->meta_data, 
            'auth_user' => $auth_user,
            'category_expenses' => json_encode($category_expenses->pluck('category_name')),
            'category_total' => json_encode($category_expenses->pluck('total')),
            'period_income' => (double)formateNumber($period_income),
            'period_expenses' => (double)formateNumber($period_expenses),
            'lowest_category_name' => $lowest_category['category']['category_name'],
            'lowest_category_amount' => (double)formateNumber($lowest_category['total_amount']),
            'highest_category_name' => $highest_category['category']['category_name'],
            'highest_category_amount' => (double)formateNumber($highest_category['total_amount']),
            'recent_transations' => $recent_transations,
        ];
        return view('dashboard.index', $response_data);
    }
}
