@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="{{ route('post-category') }}" class="btn btn-sm bg-gradient-secondary">Back</a>
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
                            <h3 class="card-title">Edit Category</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="post-category-form" method="POST" action="{{ route('post-category.update', ['category' => $category]) }}">

                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label> <label class="text-danger">*</label>
                                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" id="name" placeholder="Enter Name" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label> <label class="text-danger">*</label>
                                    <textarea name="description" class="form-control" id="description" placeholder="Enter Description" cols="30" rows="5">{{ $category->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="parent">Parent</label>
                                    <select name="parent" class="form-control" id="name">
                                        <option selected value="0">Choose</option>
                                        @foreach($parent as $item)
                                            @if($category->id !== $item->id)
                                                @php $selected = $category->parent == $item->id ? 'selected' : '' @endphp
                                                <option {{ $selected }} value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
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
<script>
    $(function() {
        $('#post-category-form').validate({
            rules: {
                name: {
                    required: true,
                },
                description: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter a name",
                },
                description: {
                    required: "Please enter a description",
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
    });
</script>
@stop
