@extends( 'projects.main' )

@section( 'projects_content' )

<div class="row">
	
	{{-- Аватар --}}
	<div class="col-md-5">
		<img src="/images/userPhoto/noImage.jpg" width="200" class="img-rounded">
	</div>

	<div class="col-md-7">
		<h3>{{ $project->projectname }}</h3>

		<table class="table table-striped">

			{{-- Страна --}}
			<tr>
				<td>Страна</td>
				<td>{{ $project->country }}</td>
			</tr>


			{{-- Город --}}
			<tr>
				<td>Город</td>
				<td>{{ $project->city}}</td>
			</tr>


			{{-- Категория --}}
			<tr>
				<td>Категория</td>
				<td>{{ $project->category->category }}</td>
			</tr>


			{{-- Подкатегория --}}
			<tr>
				<td>Подкатегория</td>
				<td>{{ $project->subcategory->category }}</td>
			</tr>


			{{-- Компания/физ.лицо --}}
			<tr>
				<td>Компания/физ. лицо</td>
				<td>{{ $project->is_compnay }}</td>
			</tr>


			{{-- Контактное имя --}}
			<tr>
				<td>Контактное имя</td>
				<td>{{ $project->contact_name }}</td>
			</tr>


			{{-- Контактный телефон --}}
			<tr>
				<td>контактный телефон</td>
				<td>{{ $project->phone }}</td>
			</tr>


			{{-- О проекте --}}
			<tr>
				<td>О проекте</td>
				<td>{{ $project->about_project }}</td>
			</tr>


			{{-- Веб сайт --}}
			<tr>
				<td>Веб сайт</td>
				<td>{{ $project->site }}</td>
			</tr>

		</table>
	</div>

</div>

@include( 'messages.message_modal' )

@endsection