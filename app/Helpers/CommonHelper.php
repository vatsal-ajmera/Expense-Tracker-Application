<?php
use Illuminate\Support\Facades\Auth;

function getRouteName()
{
    return ucfirst(str_replace('.', ' ', \Request::route()->getName()));
}

function getAuthUser() {
    return Auth::user();

}