@extends('layouts.app-no-sidebar')

@section('content')
	<div class="row settings-page profile-page">
		<div class="col-sm-6">
			@include('includes.settings-sidebar')
		</div>
		<div class="col-sm-18">
			<h1>Categories
				
				<a href="{{ url('categories/create') }}" class="btn-primary btn pull-right">Add New</a>
			</h1>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Image</th>
						<th>Title</th>
						<th>Published</th>
						<th>Show in Menu</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($categories as $cat)
					<tr>
						<td>
							<a target="_blank" href="{{ url($cat->slug) }}">
								<img class="category-main-image" src="{{ url($cat->image) }}" alt="">
							</a>
						</td>
						<td>
							<a target="_blank" href="{{ url($cat->slug) }}">
								{{ $cat->title }}
							</a>
						</td>
						<td>{{ $cat->published == 1 ? "Yes" : "No" }}</td>
						<td>{{ $cat->show_in_menu == 1 ? "Yes" : "No" }}</td>
						<td>
							<a href="{{ url('categories/'.$cat->id.'/edit') }}" class="btn btn-primary">Edit</a>
							<form class="delete-form" action="{{ url('categories/'.$cat->id) }}" method="post">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								<button submit class="btn btn-danger">Delete</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{{ $categories->links() }}

		</div>
	</div>
@endsection