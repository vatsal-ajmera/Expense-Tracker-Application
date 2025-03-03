<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
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
        return view('expense.index',['meta_data' => $this->meta_data]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $data = Expense::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($expense){
                    return '<a class="me-3" href="'.route('expense.edit', $expense->id).'">
                                <img src="'.editIcon().'" alt="img">
                            </a>
                            <a class="confirm-text" href="'.route('expense.delete', $expense->id).'">
                                <img src="'.deleteIcon() .'" alt="img">
                            </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(){
        $meta_data = [
            'title' => 'Expense',
            'description' => 'Create Expense',
            'keywords' => 'Create Expense',
        ];        
        return view('expense.save',['meta_data' => $meta_data]);
    }
    
    public function save(Request $request){
        $request->validate([
            'text' => 'required',
        ]);

        if (! empty($request->edit_id)) {
            $category = Expense::find($request->edit_id);
        } else {
            $category = new Expense();
        }
        $category->text = $request->text;
        $category->save();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Expense saved successfully');
    }

    public function edit($id){
        $meta_data = [
            'title' => 'Expense',
            'description' => 'Edit Expense',
            'keywords' => 'Edit Expense',
        ];
        $category = Expense::find($id);
        return view('expense-category.save',['meta_data' => $meta_data, 'category' => $category]);
    }

    public function delete($id){
        $category = Expense::find($id)->delete();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Expense deleted successfully');
    }
}
