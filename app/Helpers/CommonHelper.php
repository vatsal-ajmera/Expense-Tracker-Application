<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function getRouteName()
{
    return ucfirst(str_replace('.', ' ', \Request::route()->getName()));
}

function getAuthUser() {
    return auth()->guard(view()->shared('auth_gaurd'))->user();
}
function getAppLanguages() {
    return view()->shared('app_languages');
}
function getCountryFlag($country_code) {
    return url('assets/img/flags/' . $country_code . '.png');
}

function formateNumber($number) {
    return number_format($number, 2, '.', '');
}
function formateDate($date) {
    $date = Carbon::parse($date);
    return $date->isoFormat('D MMM YYYY');
}