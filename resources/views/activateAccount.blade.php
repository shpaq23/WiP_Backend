@extends('templates.mail')

@section('content')
    <h3>This is activation email</h3>
    <p>To activate account: <span class="bold">{{$user->email}}</span></p>
    <p>Click the link below:</p>
    <p>{{$activationUrl}}</p>
    @yield('portal')
@endsection
