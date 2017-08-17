@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">User List</div>
                <div class="panel-body">
                    @if(Session::has('flash_message'))
                        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
                    @endif
                    @if ($errors->has('id'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('id') }}</strong>
                        </div>
                    @endif

                    @foreach($users as $user)
                        <h3>ID: {{ $user->id }}</h3>
                        <p>First Name: {{ $user->first_name}}</p>
                        <p>Last Name: {{ $user->last_name}}</p>
                        <p>Role: {{ $roles[$user->role] }}</p>
                        <p>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                        </p>
                        @if(Auth::user()->role==1 && Auth::user()->id!=$user->id)
                        <p>
                            {!! Form::open([
                                'method' => 'destroy',
                                'route' => ['user.delete'],
                                'onsubmit' => "return confirm('Are you sure you want to delete this user?');"
                            ]) !!}
                                {{ Form::hidden('id', $user->id) }}
                                {!! Form::submit('Delete?', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </p>
                        @endif
                        <hr>
                    @endforeach
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
