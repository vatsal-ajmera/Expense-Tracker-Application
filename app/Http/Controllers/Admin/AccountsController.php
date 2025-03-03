<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AccountsController extends Controller
{
    private $gaurd;
    public $meta_data;
    private $redirect_after_login;
    private $auth_user;
    public function __construct() 
    {
        $this->gaurd = view()->shared('auth_gaurd');
        $this->meta_data = [
            'title' => 'Bank Accounts',
            'description' => 'Manage Bank Accounts',
            'keywords' => 'Bank Accounts',
        ];
        $this->redirect_after_login = '/accounts';
        $this->auth_user = auth()->guard($this->gaurd)->user();
    }
    public function index(Request $request){
        return view('bank-account.index',['meta_data' => $this->meta_data, 'account_type' => Account::getAccountType()]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $data = Account::where('user_id', $this->auth_user->id);

            if ($request->has('type') && !empty($request->type)) {
                $data->where('type', $request->type);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('type', function($account) {
                    return Account::getAccountType()[$account->type];
                })
                ->addColumn('action', function($account){
                    return '<a class="me-3" href="'.route('accounts.edit', $account->id).'">
                                <img src="'.editIcon().'" alt="img">
                            </a>
                            <a class="confirm-text" href="'.route('accounts.delete', $account->id).'">
                                <img src="'.deleteIcon() .'" alt="img">
                            </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(){
        $meta_data = [
            'title' => 'Bank Accounts',
            'description' => 'Create Bank Accounts',
            'keywords' => 'Create Bank Accounts',
        ];
        $account_types = Account::getAccountType();
        return view('bank-account.save',['meta_data' => $meta_data, 'account_types' => $account_types]);
    }
    
    public function save(Request $request){
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'type' => 'required',
            'limit' => 'required',
        ]);

        if (! empty($request->edit_id)) {
            $account = Account::find($request->edit_id);
        } else {
            $account = new Account();
            $account->user_id = $this->auth_user->id;
        }
        $account->name = $request->name;
        $account->type = $request->type;
        $account->number = $request->number;
        $account->limit = $request->limit;
        $account->save();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Account saved successfully');
    }

    public function edit($id){
        $meta_data = [
            'title' => 'Bank Accounts',
            'description' => 'Edit Bank Accounts',
            'keywords' => 'Edit Bank Accounts',
        ];
        $account_types = Account::getAccountType();
        $account = Account::find($id);
        return view('bank-account.save',['meta_data' => $meta_data, 'account' => $account, 'account_types' => $account_types]);
    }

    public function delete($id){
        $account = Account::find($id)->delete();
        $data = [
            'redirect' => $this->redirect_after_login,
        ];
        return $this->send_response($data, 'Account deleted successfully');
    }
}
