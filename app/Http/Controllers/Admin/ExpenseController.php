<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    private $gaurd;
    public $meta_data;
    private $redirect_after_login;
    private $auth_user;
    public function __construct() 
    {
        $this->gaurd = view()->shared('auth_gaurd');
        $this->meta_data = [
            'title' => 'Expense',
            'description' => 'Manage Expense',
            'keywords' => 'Expense',
        ];
        $this->redirect_after_login = '/expense';
        $this->auth_user = auth()->guard($this->gaurd)->user();
    }
    public function index(Request $request){
        $response_data = [
            'meta_data' => $this->meta_data,
            'accounts' => Account::all(),
            'categories' => ExpenseCategory::all()
        ];
        return view('expense.index', $response_data);
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
                $data->whereBetween('expense_date', [$request->expense_date . ' 00:00:00', $request->expense_date. ' 11:59:59']);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('account_name', function($expense) {
                    return $expense->account->name;
                })
                ->addColumn('category_name', function($expense) {
                    return $expense->category->category_name;
                })
                ->addColumn('amount', function($expense) {
                    return formateNumber($expense->amount);
                })
                ->addColumn('expense_date', function($expense) {
                    return formateDate($expense->expense_date);
                })
                ->addColumn('status', function($expense) {
                    return $expense->status == Expense::STATUS_PAID
                        ? '<span class="badges bg-lightgreen">Paid</span>'
                        : '<span class="badges bg-lightred">Unpaid</span>';
                }) 
                ->addColumn('action', function($expense){
                    return '<a class="me-3" href="'.route('expense.edit', $expense->id).'">
                                <img src="'.editIcon().'" alt="img">
                            </a>
                            <a class="confirm-text" href="'.route('expense.delete', $expense->id).'">
                                <img src="'.deleteIcon() .'" alt="img">
                            </a>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function create(){
        $meta_data = [
            'title' => 'Expense',
            'description' => 'Add Expense',
            'keywords' => 'Add Expense',
        ];
        $accounts = Account::all();
        $categories = ExpenseCategory::all();
        $response_data = [
            'meta_data' => $meta_data, 
            'accounts' => $accounts, 
            'categories' => $categories
        ];
        return view('expense.bulk_add', $response_data);
    }
    
    public function save(Request $request){
        $request->validate([
            'expense_date' => 'required',
            'account_name' => 'required|array',
            'expense_note' => 'required|array',
            'amount' => 'required|array',
            'expense_category' => 'required|array',
            'status' => 'required|array',
        ]);
        $data = $request;
        $save_array = [];
        $total_expense = [];
        foreach ($data['account_name'] as $key => $value) {
            $save_array[$key]['user_id'] = $this->auth_user->id;
            $save_array[$key]['account_id'] = $value;
            $save_array[$key]['category_type_id'] = $data['expense_category'][$key];
            $save_array[$key]['text'] = $data['expense_note'][$key];
            $save_array[$key]['amount'] = $data['amount'][$key];
            $save_array[$key]['expense_date'] = Carbon::createFromFormat('d-m-Y', $data['expense_date'])->format('Y-m-d');
            $save_array[$key]['status'] = $data['status'][$key];

            if (!isset($total_expense[$value])) {
                $total_expense[$value] = 0;
            }
            $total_expense[$value] += $data['amount'][$key];
        }
        $status = Expense::insert($save_array);
        if ($status == TRUE) {
            foreach ($total_expense as $account_id => $amount) {
                $account = Account::find($account_id);
                if ($account) {
                    $account->availble_limit -= $amount;
                    $account->save();
                }
            }
            $data = ['redirect' => $this->redirect_after_login];
            return $this->send_response($data, 'Expense saved successfully');
        } else {
            return $this->send_error_response($data, 'Someting failed', 500, []);
        }
        
    }

    public function update(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|exists:expenses,id',
            'expense_date' => 'required',
            'account_name' => 'required',
            'expense_note' => 'required',
            'amount' => 'required',
            'expense_category' => 'required',
            'status' => 'required',
        ]);

        $expense_edit = Expense::find($request->edit_id);
        $expense_edit->account_id = $request->account_name;
        $expense_edit->category_type_id = $request->expense_category;
        $expense_edit->text = $request->expense_note;
        $expense_edit->description = $request->description ?? '';
        $expense_edit->amount = $request->amount;
        $expense_edit->status = $request->status;
        $expense_edit->expense_date = Carbon::parse($request->expense_date) ?? $expense_edit->expense_date;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $timestamp = now()->timestamp;
            $filename = $timestamp . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/expense', $filename, 'public');
            $expense_edit->attachment = $filename;
        }
        $expense_edit->save();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Expense Category saved successfully');
    }

    public function edit($id){
        $meta_data = [
            'title' => 'Expense',
            'description' => 'Edit Expense',
            'keywords' => 'Edit Expense',
        ];
        $expense = Expense::find($id);
        $accounts = Account::all();
        $categories = ExpenseCategory::all();
        $response = [
            'meta_data' => $meta_data, 
            'expense' => $expense,
            'accounts' => $accounts,
            'categories' => $categories,
        ];
        return view('expense.save',$response);
    }

    public function delete($id){
        $category = Expense::find($id)->delete();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Expense deleted successfully');
    }
}
