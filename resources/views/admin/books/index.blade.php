@extends('admin.layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
            <li class="nav-item">
                <a class="nav-link active" href="{!! url()->current() !!}"><i
                        class="fa fa-list mr-2"></i>{{trans('lang.books')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{!! route('admin.books.create') !!}"><i
                        class="fa fa-plus mr-2"></i>{{trans('lang.book')}} {{trans('lang.create')}}</a>
            </li>
            @include('admin.layouts.right_toolbar', compact('dataTable'))
        </ul>
    </div>
    <div class="card-body">
        @include('admin.books.table')
        <div class="clearfix"></div>
    </div>
</div>
</div>
@endsection
