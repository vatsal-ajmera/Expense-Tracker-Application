@extends('email.master')
@section('content')
    <table align="left" width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <p>Hello,</p>
                <p>Tixstock has received a request to reset your password. If you did not do it, ignore this email.</p>
                <p>Otherwise, please click the following link to set a new password for your account:</p>
                <p><a href="{{ route('auth.reset.password.get', $reset_password_link) }}">Reset Your Password</a></p>
            </td>
        </tr>
    </table>
@endsection
