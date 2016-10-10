@extends('layouts.app-no-sidebar')

@section('content')
	<div class="row settings-page profile-page">
		<div class="col-sm-6">
			@include('includes.settings-sidebar')
		</div>
		<div class="col-sm-18">
			<h1>Profile</h1>
			<form>
				<div class="form-group">
					<label class="avatarInputLabel" for="avatarInput">Avatar</label>
					<img class="profile-avatar-img" src="https://avatars-cdn.9gag.com/avatar/default_82_100_v0.jpg" alt="">
					<input type="file" id="avatarInput">
				</div>
				<div class="form-group">
					<label for="yourNameInput">Your name</label>
					<input type="text" class="form-control" id="yourNameInput" name="name" placeholder="Your name">
				</div>				
				<div class="form-group">
					<label for="gender-input">Gender</label>
					<select name="gender" id="gender-input" class="form-control">
						<option value="0">Male</option>
						<option value="1">Female</option>
					</select>
				</div>
				<div class="form-group">
					<label>Birthday</label>
					<div class="row">
						<div class="col-sm-12">
							<input type="text" name="year" class="form-control" placeholder="YYYY">
						</div>
						<div class="col-sm-6">
							<input type="text" name="month" class="form-control" placeholder="MM">
						</div>
						<div class="col-sm-6">
							<input type="text" name="month" class="form-control" placeholder="DD">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="country-input">Country</label>
					<select name="country" id="country-input" class="form-control">
						@foreach($countries as $country)
							<option>{{ $country }}</option>
						@endforeach
					</select>
				    <p class="help-block">Tell us where you're from so we can provide better service for you.</p>
				</div>
				<div class="form-group">
					<label for="yourDescriptionInput">Tell people who you are</label>
					<textarea name="description" class="form-control" id="yourDescriptionInput"></textarea>
				</div>
				<div class="form-group">
					<label>Social Networks</label>
				</div>

				<button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
	</div>
@endsection