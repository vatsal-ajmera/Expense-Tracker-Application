<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class SpendAnalyticsController extends Controller
{
    private $gaurd;
    public $meta_data;
    public $auth_user;
    public function __construct()
    {
        $this->gaurd = view()->shared('auth_gaurd');
        $this->auth_user = auth()->guard($this->gaurd);
        $this->meta_data = [
            'title' => 'Analytics',
            'description' => 'Analytics Manager',
            'keywords' => 'Analytics',
        ];
    }

    public function index(Request $request)
    {
        $start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_date = Carbon::now()->format('Y-m-d');
        $categories = ExpenseCategory::pluck('category_name', 'id');
        $expenses = Expense::whereBetween('expense_date', [$start_date, $end_date])
            ->selectRaw('category_type_id, expense_date, SUM(amount) as total_amount')
            ->groupBy('category_type_id', 'expense_date')
            ->orderBy('expense_date')
            ->get();

        // Generate an array of days from start of the month to today
        $dates = collect(range(1, Carbon::now()->day))->map(fn ($day) => Carbon::now()->startOfMonth()->addDays($day - 1)->format('Y-m-d'));

        // Initialize dataset with empty values
        $formatted_data = [];
        foreach ($categories as $categoryId => $category_name) {
            $formatted_data[$category_name] = array_fill(0, count($dates), 0);
        }
        // Fill dataset with actual values
        foreach ($expenses as $expense) {
            $date_index = $dates->search(Carbon::parse($expense->expense_date)->format('Y-m-d'));
            if ($date_index !== FALSE) {
                $formatted_data[$categories[$expense->category_type_id]][$date_index] = (int) $expense->total_amount;
            }
        }
        $series = [];
        foreach ($formatted_data as $category_name => $data) {
            $series[] = [
                'name' => $category_name,
                'data' => $data
            ];
        }

        $account_expense = Account::leftJoin('expenses', function ($join) use ($start_date, $end_date) {
            $join->on('accounts.id', '=', 'expenses.account_id')
                ->whereBetween('expenses.expense_date', [$start_date, $end_date]);
        })
            ->select('accounts.id', 'accounts.name')
            ->selectRaw('COALESCE(SUM(expenses.amount), 0) as total_amount')
            ->groupBy('accounts.id', 'accounts.name')
            ->get()
            ->toArray();

        $category_expense = ExpenseCategory::leftJoin('expenses', function ($join) use ($start_date, $end_date) {
            $join->on('expense_categories.id', '=', 'expenses.category_type_id')
                ->whereBetween('expenses.expense_date', [$start_date, $end_date]);
        })
            ->select('expense_categories.id', 'expense_categories.category_name')
            ->selectRaw('COALESCE(SUM(expenses.amount), 0) as total_amount')
            ->groupBy('expense_categories.id', 'expense_categories.category_name')
            ->get()
            ->toArray();

        $response_date = [
            'meta_data' => $this->meta_data,
            'series' => json_encode($series),
            'dates' => json_encode($dates->toArray()),
            'account_expense' => $account_expense,
            'categories' => json_encode(collect($category_expense)->pluck('category_name')->toArray()),
            'category_expense' => json_encode(collect($category_expense)->pluck('total_amount')->toArray()),
        ];
        return view('analytics.index', $response_date);
    }

    public function filterChartData(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;
        $month = $request->month ?? Carbon::now()->month;

        $start_date = Carbon::create($year, $month, 1)->startOfMonth()->format('Y-m-d');
        $end_date = Carbon::create($year, $month, 1)->endOfMonth()->format('Y-m-d');

        $categories = ExpenseCategory::pluck('category_name', 'id');

        $expenses = Expense::whereBetween('expense_date', [$start_date, $end_date])
            ->selectRaw('category_type_id, expense_date, SUM(amount) as total_amount')
            ->groupBy('category_type_id', 'expense_date')
            ->orderBy('expense_date')
            ->get();

        $dates = collect(range(1, Carbon::create($year, $month)->daysInMonth))
            ->map(fn ($day) => Carbon::create($year, $month, $day)->format('Y-m-d'));

        $formatted_data = [];
        foreach ($categories as $categoryId => $category_name) {
            $formatted_data[$category_name] = array_fill(0, count($dates), 0);
        }

        foreach ($expenses as $expense) {
            $date_index = $dates->search(Carbon::parse($expense->expense_date)->format('Y-m-d'));
            if ($date_index !== FALSE) {
                $formatted_data[$categories[$expense->category_type_id]][$date_index] = (int) $expense->total_amount;
            }
        }

        // Format series data
        $series = [];
        foreach ($formatted_data as $category_name => $data) {
            $series[] = [
                'name' => $category_name,
                'data' => $data
            ];
        }

        $account_expense = Account::leftJoin('expenses', function ($join) use ($start_date, $end_date) {
            $join->on('accounts.id', '=', 'expenses.account_id')
                ->whereBetween('expenses.expense_date', [$start_date, $end_date]);
        })
            ->select('accounts.id', 'accounts.name')
            ->selectRaw('COALESCE(SUM(expenses.amount), 0) as total_amount')
            ->groupBy('accounts.id', 'accounts.name')
            ->get()
            ->toArray();

        $category_expense = ExpenseCategory::leftJoin('expenses', function ($join) use ($start_date, $end_date) {
            $join->on('expense_categories.id', '=', 'expenses.category_type_id')
                ->whereBetween('expenses.expense_date', [$start_date, $end_date]);
        })
            ->select('expense_categories.id', 'expense_categories.category_name')
            ->selectRaw('COALESCE(SUM(expenses.amount), 0) as total_amount')
            ->groupBy('expense_categories.id', 'expense_categories.category_name')
            ->get()
            ->toArray();

        $account_expense_data = view('analytics.render_data', compact('account_expense'))->render();
        return response()->json([
            'series' => json_encode($series),
            'dates' => json_encode($dates->toArray()),
            'account_expense' => $account_expense_data,
            'categories' => json_encode(collect($category_expense)->pluck('category_name')->toArray()),
            'category_expense' => json_encode(collect($category_expense)->pluck('total_amount')->toArray()),
        ]);
    }

}
