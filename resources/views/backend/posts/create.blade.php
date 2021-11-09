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
                <h3 class="card-title">Create Post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title">
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Category<span class="text-danger"> *</span></label>
                        <select class="form-control select2" name="category" style="width: 100%;">
                          <option value="">Select Category</option>
                          <option value="environment">Environment</option>
                          <option value="celebrity">Celebrity</option>
                          <option value="animals">Animals</option>
                          <option value="politics">Politics</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                      </div>
                      <div class="col-md-4">
                        <label for="file">Image</label>
                        <input type="file" name="image" class="form-control" id="customFile" onchange="readURL(this);">
                      </div>
                      <div class="col-md-2">
                        <label for=""></label>
                        <div id="show_img"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="content">Content<span class="text-danger"> *</span></label>
                    <textarea class="form-control" name="content" rows="3" placeholder="Enter Content..."></textarea>
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-right">
                  <a href="{{ route('posts.index') }}" class="btn btn-default">Cancel</a>
                  <button type="submit" class="btn btn-success">Save</button>
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
