@extends('admin.layouts.app')
@push('css_lib')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{!! route('admin.permissions.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.permission_table')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! route('admin.permissions.create') !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.permission_create')}}</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{!! route('admin.roles.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.role_table')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{!! route('admin.roles.edit', $role->id) !!}"><i class="fa fa-pencil mr-2"></i>{{trans('lang.role_edit')}}</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            {!! Form::model($role, ['route' => ['admin.roles.update', $role->id], 'method' => 'patch']) !!}
            <div class="row">
                @include('admin.roles.fields')
            </div>
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
    </div>
    </div>
@endsection
@push('scripts_lib')
    <!-- iCheck -->
    <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
    <!-- select2 -->
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <!-- AdminLTE admin demo (This is only for demo purposes) -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
@endpush
