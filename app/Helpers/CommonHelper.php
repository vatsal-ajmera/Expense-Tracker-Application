<?php
use Illuminate\Support\Facades\Auth;

function getRouteName()
{
    return ucfirst(str_replace('.', ' ', \Request::route()->getName()));
}

function getAuthUser() {
    return auth()->guard(view()->shared('auth_gaurd'))->user();
}