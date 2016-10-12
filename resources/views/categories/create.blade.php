@extends('layouts.app-no-sidebar')

@section('content')
	<div class="row settings-page profile-page">
		<div class="col-sm-6">
			@include('includes.settings-sidebar')
		</div>
		<div class="col-sm-18">
			<h1>
				Create Category
			</h1>
			<form action="@if(isset($category)) {{ url('categories/'.$category->id) }} @else {{ url('categories') }} @endif" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				
				@if( isset($category) )
					{{ method_field('PUT') }}
				@endif

				<div class="form-group">
					<label class="avatarInputLabel" for="avatarInput">Avatar</label>
					@if( isset($category) )
					<img class="profile-avatar-img" src="{{ url('img/categories/'.$category->image) }}" alt="">
					@endif 
					<input type="file" name="image" id="avatarInput">
				</div>
				<div class="form-group">
					<label for="titleInput">Title</label>
					<input name="title" type="text" class="form-control" id="titleInput" placeholder="Title" value="{{ $category->title or "" }}">
				</div>				
				<div class="form-group">
					<label for="descriptionTextarea">Description</label>
					<textarea name="description" class="form-control" id="descriptionTextarea" placeholder="Description">{{ $category->description or "" }}</textarea>
				</div>
				<div class="form-group">
					<label>Published</label>
					<div>
						<label>
							<input name="published" type="radio" value="1" @if( !isset($category->published) ) checked="checked" @endif @if( isset($category->published) && $category->published == 1 ) checked="checked" @endif> Yes 
						</label>
						<label>
							<input name="published" type="radio" value="0" @if( isset($category->published) && $category->published == 0 ) checked="checked" @endif> No
						</label>
					</div>
				</div>				
				<div class="form-group">
					<label>Show In Menu</label>
					<div>
						<label>
							<input name="show_in_menu" type="radio" value="1" @if( !isset($category->show_in_menu) ) checked="checked" @endif @if( isset($category->show_in_menu) && $category->show_in_menu == 1 ) checked="checked" @endif > Yes 
						</label>
						<label>
							<input name="show_in_menu" type="radio" value="0" @if( isset($category->show_in_menu) && $category->show_in_menu == 0 ) checked="checked" @endif> No
						</label>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
@endsection