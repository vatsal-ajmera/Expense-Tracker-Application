<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('dashboard.index',['meta_data' => $this->meta_data, 'auth_user' => $auth_user]);
    }
}
