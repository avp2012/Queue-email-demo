@extends('layouts.master')

@section('content')
  <div class="content-wrapper">
    @include('layouts.breadcrumb')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if(session()->has('message.level'))
          <div class="alert alert-{{ session('message.level') }}" role="alert">
            {{ session('message.content') }}
          </div>
        @endif
        <div class="row">
          <div class="col-7"></div>
          <div class="col-5 mb-2 text-right">
            <button type="button" class="btn btn-danger" onclick="MultipleDelete('multiple-posts-delete','posts_table')"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete Selected</button>
            <a href="{{ route('posts.create') }}" class="btn btn-info"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Create Post</a>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Posts List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="posts_table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class="select_all">
                      <label class="container_chk ">
                        <input type="checkbox" >
                        <span class="checkmark"></span>
                      </label>
                    </th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
@section('script')
  <script type="text/javascript">
    var base_url = "{{ url('/') }}";
    var csrftoken = "{{ csrf_token() }}";
  </script>
@endsection
@endsection
