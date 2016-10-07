@extends('layouts.app')

@section('content')
	<div class="row settings-page">
		<div class="col-sm-6">
			@include('includes.settings-sidebar')
		</div>
		<div class="col-sm-18">
			<h1>Account</h1>
			<form>
				<div class="form-group">
					<label for="exampleInputEmail1">Username</label>
					<input name="username" type="text" class="form-control" id="exampleInputEmail1" placeholder="Username">
				</div>				
				<div class="form-group">
					<label for="exampleInputEmail2">Email</label>
					<input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email">
				</div>
				<div class="form-group">
					<label>Show NSFW Posts</label>
					<div>
						<label>
							<input name="show-nsfw" type="radio" value="1" checked="checked" > Yes 
						</label>
						<label>
							<input name="show-nsfw" type="radio" value="0" > No
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="checkbox-field">Upvote</label>
					<div>
						<input name="upvote" type="checkbox" id="checkbox-field"> Hide my upvotes in profile
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
				<a class="delete-my-account" href="">Delete my account</a>
			</form>
		</div>
	</div>
@endsection