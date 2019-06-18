@extends('templates.mail')

@section('content')
    <h1>Resetting password email</h1>
    <div class="top">
        <p>You are receiving this email because we received a password reset
            request for your account.</p>
        <p>To reset password for account: <span class="bold">{{$user->email}}</span></p>
        <p>Click the link below:</p>
        <a class="button" href="{{$resettingUrl}}" target="_blank">Reset Password!</a>
        <p>If you did not request a password reset, no further action is required.</p>
    </div>
    @yield('portal')
@endsection
