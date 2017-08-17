@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Article List</div>
                <div class="panel-body">
                    @if(Session::has('flash_message'))
                        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
                    @endif
                    @if ($errors->has('id'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('id') }}</strong>
                        </div>
                    @endif

                    @foreach($articles as $article)
                        <h3>ID: {{ $article->id }}</h3>
                        <p>Title: {{ $article->title}}</p>
                        <p>Slug: {{ $article->slug}}</p>
                        <p>
                            <a href="{{ route('article.edit', $article->id) }}" class="btn btn-primary">Edit Article</a>
                        </p>
                        @if(Auth::user()->role==1)
                        <p>
                            {!! Form::open([
                                'method' => 'destroy',
                                'route' => ['article.delete'],
                                'onsubmit' => "return confirm('Are you sure you want to delete this article?');"
                            ]) !!}
                                {{ Form::hidden('id', $article->id) }}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </p>
                        @endif
                        <hr>
                    @endforeach
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
