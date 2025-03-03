<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExpenseCategoryController extends Controller
{
    private $gaurd;
    public $meta_data;
    private $redirect_after_login;
    private $auth_user;
    public function __construct() 
    {
        $this->gaurd = view()->shared('auth_gaurd');
        $this->meta_data = [
            'title' => 'Expense Category',
            'description' => 'Manage Expense Category',
            'keywords' => 'Expense Category',
        ];
        $this->redirect_after_login = '/category';
        $this->auth_user = auth()->guard($this->gaurd)->user();
    }
    public function index(Request $request){
        return view('expense-category.index',['meta_data' => $this->meta_data]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $data = ExpenseCategory::query();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($category){
                    return '<a class="me-3" href="'.route('category.edit', $category->id).'">
                                <img src="'.editIcon().'" alt="img">
                            </a>
                            <a class="confirm-text" href="'.route('category.delete', $category->id).'">
                                <img src="'.deleteIcon() .'" alt="img">
                            </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(){
        $meta_data = [
            'title' => 'Expense Category',
            'description' => 'Create Expense Category',
            'keywords' => 'Create Expense Category',
        ];        
        return view('expense-category.save',['meta_data' => $meta_data]);
    }
    
    public function save(Request $request){
        $request->validate([
            'category_name' => 'required',
        ]);

        if (! empty($request->edit_id)) {
            $category = ExpenseCategory::find($request->edit_id);
        } else {
            $category = new ExpenseCategory();
        }
        $category->category_name = $request->category_name;
        $category->save();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Expense Category saved successfully');
    }

    public function edit($id){
        $meta_data = [
            'title' => 'Expense Category',
            'description' => 'Edit Expense Category',
            'keywords' => 'Edit Expense Category',
        ];
        $category = ExpenseCategory::find($id);
        return view('expense-category.save',['meta_data' => $meta_data, 'category' => $category]);
    }

    public function delete($id){
        $category = ExpenseCategory::find($id)->delete();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Expense Category deleted successfully');
    }
}
