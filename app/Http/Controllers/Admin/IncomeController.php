<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class IncomeController extends Controller
{
    private $gaurd;
    public $meta_data;
    private $redirect_after_login;
    private $auth_user;
    public function __construct() 
    {
        $this->gaurd = view()->shared('auth_gaurd');
        $this->meta_data = [
            'title' => 'Income',
            'description' => 'Manage Income',
            'keywords' => 'Income',
        ];
        $this->redirect_after_login = '/income';
        $this->auth_user = auth()->guard($this->gaurd)->user();
    }
    public function index(Request $request){
        return view('income.index',['meta_data' => $this->meta_data]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $data = Income::query();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('account_name', function($income) {
                    return $income->account->name;
                })
                ->addColumn('amount', function($income) {
                    return formateNumber($income->amount);
                })
                ->addColumn('date', function($income) {
                    return formateDate($income->date);
                })
                ->addColumn('action', function($income){
                    return '<a class="me-3" href="'.route('income.edit', $income->id).'">
                                <img src="'.editIcon().'" alt="img">
                            </a>
                            <a class="confirm-text" href="'.route('income.delete', $income->id).'">
                                <img src="'.deleteIcon() .'" alt="img">
                            </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(){
        $meta_data = [
            'title' => 'Income',
            'description' => 'Add Income',
            'keywords' => 'Add Income',
        ];      
        $accounts = Account::all();  
        return view('Income.save',['meta_data' => $meta_data, 'accounts' => $accounts]);
    }
    
    public function save(Request $request){
        $request->validate([
            'date' => 'required',
            'amount' => 'required',
        ]);

        if (! empty($request->edit_id)) {
            $income = Income::find($request->edit_id);
        } else {
            $income = new Income();
        }
        $income->account_id = $request->account_id;
        $income->notes = $request->notes;
        $income->date = Carbon::parse($request->date)->format('Y-m-d') ?? $income->expense_date;
        $income->amount = $request->amount;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $timestamp = now()->timestamp;
            $filename = $timestamp . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/income', $filename, 'public');
            $income->attachment = $filename;
        }
        $income->save();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Income saved successfully');
    }

    public function edit($id){
        $meta_data = [
            'title' => 'Income',
            'description' => 'Edit Income',
            'keywords' => 'Edit Income',
        ];
        $income = Income::find($id);
        $accounts = Account::all();
        return view('income.save',['meta_data' => $meta_data, 'income' => $income, 'accounts' => $accounts]);
    }

    public function delete($id){
        $category = Income::find($id)->delete();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Income deleted successfully');
    }
}
