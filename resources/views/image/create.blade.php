@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">New Post</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('image.save') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="image_path" id="image_path_label" class="col-md-4 col-form-label text-md-end">Image</label>
                            <div class="col-md-8">
                                <input id="image_path" type="file" name="image_path" class="form-control" required/>

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
                                <textarea id="description" name="description" class="form-control" required></textarea>

                                @if($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <input type="submit" class="btn btn-primary" value="Post">
                        
                            </div>
                        </div>

                    </form>
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection