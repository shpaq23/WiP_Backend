@extends('templates.mail')

@section('content')

    <h1>Activation email</h1>
    <div class="top">
        <p>To activate account: <span class="bold">{{$user->email}}</span></p>
        <p>Click the link below:</p>
        <a href="{{$activationUrl}}" class="button" target="_blank">Activate!</a>
    </div>
    @yield('portal')
@endsection
