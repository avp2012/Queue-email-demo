@extends('layouts.master')

@section('content')
  <div class="content-wrapper">
    @include('layouts.breadcrumb')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('posts.update',$post->id) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PATCH') }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="{{ old('title',$post->title)}}">
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Category<span class="text-danger"> *</span></label>
                        <select class="form-control select2" name="category" style="width: 100%;">
                          <option value="">Select Category</option>
                          <option value="environment" {{ (old('category',$post->category) == "environment") ? "selected" : "" }}>Environment</option>
                          <option value="celebrity" {{ (old('category',$post->category) == "celebrity") ? "selected" : "" }}>Celebrity</option>
                          <option value="animals" {{ (old('category',$post->category) == "animals") ? "selected" : "" }}>Animals</option>
                          <option value="politics" {{ (old('category',$post->category) == "politics") ? "selected" : "" }}>Politics</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                      </div>
                      <div class="col-md-6">
                        <label for="file">Image</label>
                        <div class="custom-file">
                          <input type="file" name="image" class="custom-file-input" id="customFile">
                          <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="content">Content<span class="text-danger"> *</span></label>
                    <textarea class="form-control" name="content" rows="3" placeholder="Enter Content...">{{ old('content',$post->content) }}</textarea>
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-right">
                  <a href="{{ route('posts.index') }}" class="btn btn-default">Cancel</a>
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
