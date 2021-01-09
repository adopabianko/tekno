@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Role</h1>
                </div>
                <div class="col-sm-6">
                    @permission('role-add-new-data')
                    <div class="float-right">
                        <a href="{{ route('role.create') }}" class="btn btn-sm bg-gradient-success">Add New</a>
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
                                $displayName = app('request')->get('display_name');
                            @endphp
                            <form action={{ route('role') }} method="GET">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $name }}" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Display Name</label>
                                            <input type="text" name="display_name" class="form-control" value="{{ $displayName }}" placeholder="Display Name">
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
                                        <th>Display Name</th>
                                        <th>Description</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $key => $item)
                                    <tr>
                                        <td class="text-center">{{ $roles->firstItem() + $key }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->display_name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td class="text-center">
                                            @if (\Laratrust::isAbleTo('role-edit-data'))
                                                <a href="{{ route('role.edit', ['role' => $item->id]) }}" class="btn btn-xs bg-gradient-info" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            @if (\Laratrust::isAbleTo('role-access-management'))
                                                <a href="{{ route('role.access-management', ['role' => $item->id]) }}" class="btn btn-xs bg-gradient-secondary" data-toggle="tooltip" data-placement="top" title="Access Management">
                                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div style="margin-top: 15px">
                                {{
                                    $roles->appends([
                                        'name' => $name,
                                        'display_name' => $displayName
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
<script>
    $(function() {
        $("body").tooltip({
            selector: '[data-toggle="tooltip"]'
        });
    })
</script>
@stop
