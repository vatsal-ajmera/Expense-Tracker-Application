<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $redirect_after_login;
    private $gaurd;
    public $meta_data;
    public $auth_user;
    public function __construct()
    {

        $this->redirect_after_login = '/profile';
        $this->gaurd = view()->shared('auth_gaurd');
        $this->auth_user = auth()->guard($this->gaurd)->user();
        $this->meta_data = [
            'title' => 'Profile',
            'description' => 'User Profile ',
            'keywords' => 'User Profile',
        ];
    }

    public function index(){
        
        return view('profile.index',['meta_data' => $this->meta_data, 'auth_user' => $this->auth_user]);
    }

    public function saveAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $timestamp = now()->timestamp;
            $filename = $timestamp . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/profile', $filename, 'public');

            $this->auth_user->avatar = $filename; 
            $this->auth_user->save();
        }
        $data = [
            'redirect' => route('profile.get'),
        ];
        return $this->send_response($data, 'Profile updated successfully');
    }

    public function saveProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $this->auth_user->name = $request->name; 
        $this->auth_user->last_name = $request->last_name; 
        $this->auth_user->last_name = $request->last_name; 
        $this->auth_user->phone = $request->phone; 
        $this->auth_user->email = $request->email; 
        if (!empty($request->password)) {
            $this->auth_user->password = $request->password; 
        }
        $this->auth_user->save();
        $data = [
            'redirect' => route('profile.get'),
        ];
        return $this->send_response($data, 'Profile updated successfully');
    }
}
