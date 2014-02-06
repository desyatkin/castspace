@extends('layouts.main')

@section('content')
<div class="row row-fluid">
	<div class="col-md-3">
		@include('subnavigation')
	</div>
	<div class="col-md-6">
		@yield('profiles_content')
	</div>
	<div class="col-md-3">
		@include('profiles.search')
	</div>
</div>
@endsection