@extends('layouts.app')

@section('css')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('theme/plugins/summernote/summernote-bs4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('theme/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Post</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="{{ route('post') }}" class="btn btn-sm bg-gradient-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Post</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="tag-form" method="POST" action="{{ route('post.update', ['post' => $post]) }}" enctype="multipart/form-data">

                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label> <label class="text-danger">*</label>
                                    <input type="text" name="title" value="{{ $post->title }}" class="form-control" id="title" placeholder="Enter Title">
                                </div>
                                <div class="form-group">
                                    <label for="content">Content</label> <label class="text-danger">*</label>
                                    <textarea name="content" id="summernote">{{ $post->content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="cover">Cover</label> <label class="text-danger">*</label><br>
                                    <img id="img-preview" class="hidden" src="{{ asset("storage/posts/{$post->cover}") }}" style="max-width: 150px"/><br>
                                    <input type="file" name="cover" id="post-cover" placeholder="Title"><br>
                                    <label class="text-danger">Maximum file size 2MB, allowed file types png jpg</label>
                                </div>
                                <div class="form-group">
                                    <label for="category">Category</label> <label class="text-danger">*</label>
                                    <select name="category_id" class="form-control" id="category" data-placeholder="Choose" data-dropdown-css-class="select2-purple">
                                        @foreach($categories as $item)
                                            @php $selected = $item->id == $post->category_id ? 'selected' : '' @endphp
                                            <option {{ $selected }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tag">Tag</label>
                                    <select name="tags[]" class="form-control" id="tag" multiple="multiple" data-placeholder="Choose" data-dropdown-css-class="select2-purple">
                                        @foreach($tags as $item)
                                            <option {{ in_array($item->id, $tagData) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="title">
                                        <option {{ $post->status == 1 ? 'selected' : '' }} value="1" selected>Draft</option>
                                        <option {{ $post->status == 2 ? 'selected' : '' }} value="2">Publish</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn bg-gradient-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop

@section('js')
<!-- jquery-validation -->
<script src="{{ asset('theme/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('theme/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('theme/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('theme/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#category').select2();
        $('#tag').select2();

        // Summernote
        $('#summernote').summernote({
            height: 400
        })

        $('#post-form').validate({
            rules: {
                title: {
                    required: true,
                },
                content: {
                    required: true,
                },
                cover: {
                    required: true,
                },
                category: {
                    required: true,
                },
            },
            messages: {
                title: {
                    required: "Please enter a title",
                },
                content: {
                    required: "Please enter a content",
                },
                cover: {
                    required: "Please enter a cover",
                },
                category: {
                    required: "Please enter a category",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $("#img-preview").removeClass("hidden");
                    $("#img-preview").attr("src", e.target.result);
                }

                reader.readAsDataURL(input.files[0]) // convert to base64 sting
            }
        }

        $("#post-cover").change(function() {
            readURL(this);
        })
    });
</script>
@stop
