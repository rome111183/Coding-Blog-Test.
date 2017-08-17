@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Article Category List</div>
                <div class="panel-body">
                    @if(Session::has('flash_message'))
                        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
                    @endif
                    @if ($errors->has('id'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('id') }}</strong>
                        </div>
                    @endif

                    @foreach($articlecategory as $category)
                        <h3>ID: {{ $category->id }}</h3>
                        <p>Category Name: {{ $category->name}}</p>
                        <p>
                            <a href="{{ route('articlecategory.edit', $category->id) }}" class="btn btn-primary">Edit Article Category</a>
                        </p>
                        @if(Auth::user()->role==1)
                        <p>
                            {!! Form::open([
                                'method' => 'destroy',
                                'route' => ['articlecategory.delete'],
                                'onsubmit' => "return confirm('Are you sure you want to delete this article category?');"
                            ]) !!}
                                {{ Form::hidden('id', $category->id) }}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </p>
                        @endif
                        <hr>
                    @endforeach
                    {{ $articlecategory->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
