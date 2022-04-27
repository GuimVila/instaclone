@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">Edit Post</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="image_id" value="{{ $image->id }}" />

                        <div class="form-group row mb-3">
                            <label for="image_path" id="image_path_label" class="col-md-4 col-form-label text-md-end">Image</label>
                            <div class="col-md-8">
                            @if($image->user->image)
                            <div class="container-avatar">
                                    <img src="{{ route('image.file',['filename' => $image->image_path]) }}" class="avatar"/>
                                </div>   
                            @endif
                                <input id="image_path" type="file" name="image_path" class="form-control"/>

                                @if($errors->has('image_path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image_path') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="description" id="description_label" class="col-md-4 col-form-label text-md-end">Description</label>
                            <div class="col-md-8">
                         
                                <textarea id="description" name="description" class="form-control" required>{{ $image->description }}</textarea>

                                @if($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <input type="submit" class="btn btn-primary" value="Edit Post">
                        
                            </div>
                        </div>

                    </form>
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection