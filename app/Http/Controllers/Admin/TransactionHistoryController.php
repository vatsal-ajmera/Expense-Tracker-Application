<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TransactionHistoryController extends Controller
{
    private $gaurd;
    public $meta_data;
    public $auth_user;
    public function __construct()
    {
        $this->gaurd = view()->shared('auth_gaurd');
        $this->auth_user = auth()->guard($this->gaurd);
        $this->meta_data = [
            'title' => 'Translation History',
            'description' => 'Translation History Manager',
            'keywords' => 'Translation History',
        ];
    }

    public function index(Request $request)
    {
        $response_data = [
            'meta_data' => $this->meta_data,
            'accounts' => Account::all(),
            'categories' => ExpenseCategory::all()
        ];
        return view('transaction.index', $response_data);
    }

    public function getRecords(Request $request)
    {   

        if ($request->ajax()) {
            $gross_debits = 0;
            $gross_credits = 0;

            $expenseQuery = Expense::select([
                'expenses.id',
                'expenses.text',
                'expenses.amount',
                'expenses.expense_date as date',
                'accounts.name as account_name',
                'expense_categories.category_name',
                DB::raw('"Debit" as type')
            ])
            ->leftJoin('accounts', 'expenses.account_id', '=', 'accounts.id')
            ->leftJoin('expense_categories', 'expenses.category_type_id', '=', 'expense_categories.id')
            ->orderBy('expenses.expense_date', 'desc');

            // Apply filters for expenses
            if ($request->filled('account_id')) {
                $expenseQuery->where('expenses.account_id', $request->account_id);
            }

            if ($request->filled('category_id')) {
                $expenseQuery->where('expenses.category_type_id', $request->category_id);
            }
            if ($request->filled('trans_type') && $request->trans_type === 'Credit') {
                $expenseQuery->whereRaw('0 = 1');
            }

            if ($request->filled('date')) {
                $expenseQuery->whereDate('expenses.expense_date', Carbon::parse($request->date)->format('Y-m-d'));
            }

            // Compute total debits efficiently
            $gross_debits = (clone $expenseQuery)->sum('expenses.amount');

            // Income Query Optimization
            $incomeQuery = Income::select([
                'incomes.id',
                'incomes.notes as text',
                'incomes.amount',
                'incomes.date as expense_date as date',
                'accounts.name as account_name',
                DB::raw('"Credit" as category_name'),
                DB::raw('"Credit" as type')
            ])
            ->leftJoin('accounts', 'incomes.account_id', '=', 'accounts.id')
            ->orderBy('incomes.date', 'desc');

            // Apply filters for incomes
            if ($request->filled('account_id')) {
                $incomeQuery->where('incomes.account_id', $request->account_id);
            }

            if ($request->filled('date')) {
                $incomeQuery->whereDate('incomes.date', Carbon::parse($request->date)->format('Y-m-d'));
            }
            if ($request->filled('trans_type') && $request->trans_type === 'Debit') {
                $incomeQuery->whereRaw('0 = 1');    
            }

            // Compute total credits efficiently
            $gross_credits = (clone $incomeQuery)->sum('incomes.amount');

            // Combine Both Queries Using UNION
            $combinedQuery = $expenseQuery->unionAll($incomeQuery);

            return DataTables::of(DB::table(DB::raw("({$combinedQuery->toSql()}) as transactions"))
                ->mergeBindings($combinedQuery->getQuery()))
                ->editColumn('amount', fn($row) => formateNumber($row->amount))
                ->editColumn('date', fn($row) => Carbon::parse($row->date)->format('Y-m-d'))
                ->addColumn('type', function ($row) {
                    return $row->type == 'Debit' 
                        ? '<span class="badges bg-lightred">Debit</span>' 
                        : '<span class="badges bg-lightgreen">Credit</span>';
                })
                ->rawColumns(['type'])
                ->addIndexColumn()
                ->with([
                    'gross_debits' => $gross_debits,
                    'gross_credits' => $gross_credits,
                ])
                ->make(true);
        }
    }
}
