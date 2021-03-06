@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('theme/plugins/alertify/themes/alertify.core.css') }}">
<link rel="stylesheet" href="{{ asset('theme/plugins/alertify/themes/alertify.bootstrap.css') }}">
@stop

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
                    @permission('post-category-add-new-data')
                    <div class="float-right">
                        <a href="{{ route('post-category.create') }}" class="btn btn-sm bg-gradient-success">Add New</a>
                    </div>
                    @endpermission
                </div>
            </div>
            @foreach(['danger', 'success'] as $msg)
                @if (Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('alert-' . $msg) }}
                    </div>
                @endif
            @endforeach
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Search</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php
                                $name = app('request')->get('name');
                            @endphp
                            <form action={{ route('post-category') }} method="GET">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $name }}" placeholder="Name">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatables" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Parent</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $key => $item)
                                    <tr>
                                        <td class="text-center">{{ $categories->firstItem() + $key }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->slug }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ isset($item->parentCategory->name) ? $item->parentCategory->name : '' }}</td>
                                        <td class="text-center">
                                            @if (\Laratrust::isAbleTo('post-category-edit-data'))
                                            <a href="{{ route('post-category.edit', ['category' => $item->id]) }}" class="btn btn-xs bg-gradient-info" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                            </a>
                                            @endif

                                            @if (\Laratrust::isAbleTo('post-category-destroy-data'))
                                            <a href="javascript:void(0)" class="btn btn-xs bg-gradient-danger" onclick="Delete('{{ $item->id }}','{{ $item->name }}')" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div style="margin-top: 15px">
                                {{
                                    $categories->appends([
                                        'name'=> $name,
                                    ])->links()
                                }}
                            </div>
                        </div>
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
<script src="{{ asset('theme/plugins/alertify/lib/alertify.min.js')}}"></script>
<script>
    $(function() {
        $("body").tooltip({
            selector: '[data-toggle="tooltip"]'
        });
    });

    function Delete(id, name) {
        alertify.confirm("Are you sure want to delete " + "'"+ name +"'", function (e) {
            if (e) {
                $.get(window.location.href + '/' + id + '/destroy', function(data) {
                    var obj = jQuery.parseJSON(JSON.stringify(data));

                    if (obj.status == 'success') {
                        alertify.alert(obj.message, function(e) {
                            window.location.reload();
                        });
                    } else {
                        alertify.alert(obj.message);
                    }
                });
            }
        });
    }
</script>
@stop
