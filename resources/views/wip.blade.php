@extends('activateAccount')
@section('portal')
    <h2>User details:</h2>
    <div class="portal">
        <p>First name: <span class="bold">{{$user->first_name}}</span></p>
        <p>Last name: <span class="bold">{{$user->last_name}}</span></p>
        @if ($user->description)
            <p>Description: </p>
            <p>{{$user->description}}</p>
        @endif
        <p>Position: <span class="bold">{{$positionMapper[$user->position]['name']}}</span></p>
        @if ($user->position !== 'admin')
            <p>{{$positionMapper[$user->position]['specialization_field_1']}}: <span class="bold">{{$user->specialization_field_1}}</span></p>
            <p>{{$positionMapper[$user->position]['specialization_field_2']}}: <span class="bold">{{$user->specialization_field_2}}</span></p>
            <p>{{$positionMapper[$user->position]['checkbox']}}: <span class="bold">{{$user->checkbox? 'Yes' : 'No'}}</span></p>
        @endif
    </div>
@endsection
