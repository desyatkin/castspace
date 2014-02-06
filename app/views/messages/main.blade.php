@extends('layouts.main')

@section('content')
<div class="row row-fluid">
	<div class="col-md-3">
		@include('subnavigation')
	</div>
	<div class="col-md-9">
		@yield('messages_content')
	</div>
</div>

@endsection