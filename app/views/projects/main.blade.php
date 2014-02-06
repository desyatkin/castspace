@extends('layouts.main')

@section('content')
<div class="row row-fluid">
	<div class="col-md-3">
		@include('subnavigation')
	</div>
	<div class="col-md-6">
		@yield('projects_content')
	</div>
	<div class="col-md-3">
		@include('projects.search')
	</div>
</div>
@endsection