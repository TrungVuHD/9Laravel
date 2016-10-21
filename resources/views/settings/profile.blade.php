@extends('layouts.app-no-sidebar')

@section('content')
	<div class="row settings-page profile-page">
		<div class="col-sm-6">
			@include('includes.settings-sidebar')
		</div>
		<div class="col-sm-18">
			<h1>Profile</h1>
			<form action="{{ url('settings/profile') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="avatarInputLabel" for="avatarInput">Avatar</label>
					<img class="profile-avatar-img" src="{{ url('img/avatars/'.$user->avatar_image) }}" alt="">
					<input type="file" id="avatarInput" name="avatar_image">
				</div>
				<div class="form-group">
					<label for="yourNameInput">Your name</label>
					<input type="text" class="form-control" id="yourNameInput" name="name" value="{{ $user->name or '' }}" placeholder="Your name">
				</div>				
				<div class="form-group">
					<label for="gender-input">Gender</label>
					<select name="gender" id="gender-input" class="form-control">
						<option value="0">Male</option>
						<option @if(isset($user->gender) && $user->gender == 1) selected @endif value="1">Female</option>
					</select>
				</div>
				<div class="form-group">
					<label>Birthday</label>
					<div class="row">
						<div class="col-sm-12">
							<input type="number" name="birthday_year" class="form-control" placeholder="YYYY" value="{{ $user->birthday_year or '' }}">
						</div>
						<div class="col-sm-6">
							<input type="number" name="birthday_month" class="form-control" placeholder="MM" value="{{ $user->birthday_month or '' }}">
						</div>
						<div class="col-sm-6">
							<input type="number" name="birthday_day" class="form-control" placeholder="DD" value="{{ $user->birthday_day or '' }}">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="country-input">Country</label>
					<select name="country" id="country-input" class="form-control">
						@foreach($countries as $country)
							
							@if(isset($user->country) && $user->country == $country)
							<option selected >{{ $country }}</option>
							@else 
							<option>{{ $country }}</option>
							@endif
						@endforeach
					</select>
				    <p class="help-block">Tell us where you're from so we can provide better service for you.</p>
				</div>
				<div class="form-group">
					<label for="yourDescriptionInput">Tell people who you are</label>
					<textarea name="description" class="form-control" id="yourDescriptionInput">{{ $user->description or '' }}</textarea>
				</div>
				<div class="form-group">
					<label>Social Networks</label>
				</div>
				{{ $user->socialAccounts }}
				<div class="social-wrapper row">
					<div class="connection col-sm-12">
						Facebook 
					</div>
					<div class="col-sm-12">
						<div class="btn btn primary" data-network="fb">Connect Now</div>
						<a href="#" data-network="fb" class="disconnect">Disconnect</a>
					</div>
				</div>
				
				<div class="social-wrapper row">
					<div class="connection col-sm-12">
						Google+ 
					</div>
					<div class="col-sm-12">
						<div class="btn btn primary" data-network="fb">Connect Now</div>
						<a href="#" data-network="fb" class="disconnect">Disconnect</a>
					</div>
				</div>
				

				<button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
	</div>
@endsection