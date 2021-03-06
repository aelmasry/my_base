@extends('admin.layouts.app')


@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{{ trans('lang.translate') }}</span>
        <small>{{ trans('lang.site_texts') }}.</small>
        <small><a href="{{ url('admin/languages') }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('lang.back_to_all') }} <span>test</span></a></small>
	  </h2>
	</section>
@endsection

@section('content')
<!-- Default box -->
  <div class="box">
  	<div class="box-header with-border">
	  <h3 class="box-title float-right pr-1">
		<small>
			 &nbsp; {{ trans('lang.switch_to') }}: &nbsp;
			<select name="language_switch" id="language_switch">
				@foreach ($languages as $lang)
				<option value="{{ url("admin/languages/texts/{$lang->abbr}") }}" {{ $currentLang == $lang->abbr ? 'selected' : ''}}>{{ $lang->name }}</option>
				@endforeach
			</select>
		</small>
	  </h3>
	</div>
    <div class="box-body">
		<ul class="nav nav-tabs">
			@foreach ($langFiles as $file)
			<li class="nav-item">
				<a class="nav-link {{ $file['active'] ? 'active' : '' }}" href="{{ $file['url'] }}">{{ $file['name'] }}</a>
			</li>
			@endforeach
		</ul>
		<section class="tab-content p-3 lang-inputs">
		@if (!empty($fileArray))
			<form
				method="post"
				id="lang-form"
				class="form-horizontal"
				data-required="{{ trans('lang.fields_required') }}"
		  		action="{{ url("admin/languages/texts/{$currentLang}/{$currentFile}") }}"
		  		>
				{!! csrf_field() !!}
				<div class="form-group row">
					<div class="col-sm-2">
						<h5>{{ trans('lang.key') }}</h5>
					</div>
					<div class="hidden-sm hidden-xs col-md-5">
						<h5>{{ trans('lang.language_text', ['language_name' => $browsingLangObj->name]) }}</h5>
					</div>
					<div class="col-sm-10 col-md-5">
						<h5>{{ trans('lang.language_translation', ['language_name' => $currentLangObj->name]) }}</h5>
					</div>
				</div>
				{!! $langfile->displayInputs($fileArray) !!}
				<hr>
				<div class="text-center">
					<button type="submit" class="btn btn-success submit">{{ trans('lang.save') }}</button>
				</div>
				</form>
				@else
					<em>{{ trans('lang.empty_file') }}</em>
				@endif
			</section>
    </div><!-- /.card-body -->
    	<p><small>{!! trans('lang.rules_text') !!}</small></p>
  </div><!-- /.card -->
@endsection

@push('scripts')
	<script>
		jQuery(document).ready(function($) {
			$("#language_switch").change(function() {
				window.location.href = $(this).val();
			})
		});
	</script>
@endpush
