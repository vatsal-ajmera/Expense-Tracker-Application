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
            if (!empty($request->trans_type) && $request->trans_type == 'credit') {
                $expenses = collect([]); // Empty collection instead of empty array
            } else {
                $expenses = Expense::orderBy('expense_date', 'desc');
        
                if ($request->has('account_id') && !empty($request->account_id)) {
                    $expenses->where('account_id', $request->account_id);
                }
        
                if ($request->has('category_id') && !empty($request->category_id)) {
                    $expenses->where('category_type_id', $request->category_id);
                }
        
                if ($request->has('date') && !empty($request->date)) {
                    $parse_date = Carbon::parse($request->date)->format('Y-m-d H:i:s');
                    $expenses->where('expense_date', $parse_date);
                }
        
                $expenses = $expenses->get()->map(function ($expense) {
                    return [
                        'text' => $expense->text,
                        'account_name' => $expense->account->name,
                        'category_name' => $expense->category->category_name,
                        'amount' => formateNumber($expense->amount),
                        'date' => Carbon::parse($expense->expense_date)->format('Y-m-d'),
                        'type' => '<span class="badges bg-lightred">Debit</span>',
                    ];
                });
            }
        
            // Handle incomes
            if (($request->has('category_id') && !empty($request->category_id)) || (!empty($request->trans_type) && $request->trans_type == 'debit')) {
                $incomes = collect([]); // Empty collection instead of empty array
            } else {
                $incomes = Income::orderBy('date', 'desc');
        
                if ($request->has('account_id') && !empty($request->account_id)) {
                    $incomes->where('account_id', $request->account_id);
                }
        
                if ($request->has('date') && !empty($request->date)) {
                    $parse_date = Carbon::parse($request->date)->format('Y-m-d H:i:s');
                    $incomes->where('date', $parse_date);
                }
        
                $incomes = $incomes->get()->map(function ($income) {
                    return [
                        'text' => $income->notes,
                        'account_name' => $income->account->name,
                        'category_name' => 'Credit',
                        'amount' => formateNumber($income->amount),
                        'date' => Carbon::parse($income->date)->format('Y-m-d'),
                        'type' => '<span class="badges bg-lightgreen">Credit</span>',
                    ];
                });
            }
        
            // Merge collections and sort by date
            $mergedData = $expenses->merge($incomes)->sortByDesc('date');
        
            return DataTables::of($mergedData)
                ->addIndexColumn()
                ->rawColumns(['type'])
                ->make(TRUE);
        }
    }
}
