<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Session;

class LanguageController extends Controller
{
    public function changeAppLanguage($lang)
    {
        Session::put('locale', $lang);
        return redirect()->back();
    }
}
