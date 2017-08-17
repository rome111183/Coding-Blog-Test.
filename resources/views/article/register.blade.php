@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register new Article</div>
                <div class="panel-body">
                    {!! Form::model('', [
                        'method' => 'POST',
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal',
                        'role' =>'form',
                        'route' => ['article.create']
                    ]) !!}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Slug</label>

                            <div class="col-md-6">
                                <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug') }}">

                                @if ($errors->has('slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('contents') ? ' has-error' : '' }}">
                            <label for="contents" class="col-md-4 control-label">Contents</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="5" id="contents" name="contents">{{ old('contents') }}</textarea>

                                @if ($errors->has('contents'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contents') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group{{ $errors->has('image_path') ? ' has-error' : '' }}">
                            <label for="image_path" class="col-md-4 control-label">image_path</label>

                            <div class="col-md-6">
                                <input id="image_path" type="file" class="form-control" name="image_path" value="{{ old('image_path') }}">

                                @if ($errors->has('image_path'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image_path') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('article_category_id') ? ' has-error' : '' }}">
                            <label for="article_category_id" class="col-md-4 control-label">article_category_id</label>

                            <div class="col-md-6">
                                {{ Form::select('article_category_id', $categories, old('article_category_id'), ['class' => 'control']) }}

                                @if ($errors->has('article_category_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('article_category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{ Form::hidden('updated_user_id', Auth::user()->id, [ 'id' => 'updated_user_id' ]) }}
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Create
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    CKEDITOR.replace( 'contents' );
</script>
@endsection
