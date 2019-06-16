@extends('templates.mail')

@section('content')
    <h3>This is resetting password email</h3>
    <p>You are receiving this email because we received a password reset<br>
        request for your account.</p>
    <p>To reset password for account: <span class="bold">{{$user->email}}</span></p>
    <p>Click the link below:</p>
    <p>{{$resettingUrl}}</p>
    <p>If you did not request a password reset, no further action is required.</p>
    @yield('portal')
@endsection
