<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
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
            $data = Expense::orderBy('expense_date', 'desc');

            if ($request->has('account_id') && !empty($request->account_id)) {
                $data->where('account_id', $request->account_id);
            }

            if ($request->has('category_id') && !empty($request->category_id)) {
                $data->where('category_type_id', $request->category_id);
            }

            if ($request->has('expense_date') && !empty($request->expense_date)) {
                $parse_date = Carbon::parse($request->expense_date)->format('Y-m-d H:i:s');
                $data->where('expense_date', $parse_date);
            }

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('account_name', function ($expense) {
                    return $expense->account->name;
                })
                ->filterColumn('account_name', function ($query, $keyword) {
                    $query->whereHas('account', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%{$keyword}%");
                    });
                })

                ->addColumn('category_name', function ($expense) {
                    return $expense->category->category_name;
                })
                ->filterColumn('category_name', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->where('category_name', $keyword);
                    });
                })

                ->addColumn('amount', function ($expense) {
                    return formateNumber($expense->amount);
                })
                ->filterColumn('amount', function ($query, $keyword) {
                    $query->where('amount', $keyword);
                })

                
                ->addColumn('status', function ($expense) {
                    return $expense->status == Expense::STATUS_PAID
                        ? '<span class="badges bg-lightgreen">Paid</span>'
                        : '<span class="badges bg-lightred">Unpaid</span>';
                })

                ->addColumn('action', function ($expense) {
                    return '<a class="me-3" href="'.route('expense.edit', $expense->id).'">
                                <img src="'.editIcon().'" alt="img">
                            </a>
                            <a class="confirm-text" href="'.route('expense.delete', $expense->id).'">
                                <img src="'.deleteIcon().'" alt="img">
                            </a>';
                })
                ->rawColumns(['action', 'status'])
                ->make(TRUE);
        }
    }
}
