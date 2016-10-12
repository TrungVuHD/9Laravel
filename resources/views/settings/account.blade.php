@extends('layouts.app-no-sidebar')

@section('content')
	<div class="row settings-page">
		<div class="col-sm-6">
			@include('includes.settings-sidebar')
		</div>
		<div class="col-sm-18">
			<h1>Account</h1>
			<form action="{{ url('/settings/account') }}" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="exampleInputEmail1">Username</label>
					<input name="username" type="text" class="form-control" id="exampleInputEmail1" value="{{ $user->username or '' }}" placeholder="Username">
				</div>				
				<div class="form-group">
					<label for="exampleInputEmail2">Email</label>
					<input type="email" name="email" class="form-control" id="exampleInputEmail2" placeholder="Email" value="{{ $user->email or '' }}">
				</div>
				<div class="form-group">
					<label>Show NSFW Posts</label>
					<div>
						<label>
							<input name="show_nsfw" type="radio" value="1" @if(isset($user->show_nsfw) && $user->show_nsfw == 1) checked="checked" @elseif(!isset($user->show_nsfw)) checked="checked" @endif;  > Yes 
						</label>
						<label>
							<input name="show_nsfw" type="radio" value="0" @if(isset($user->show_nsfw) && $user->show_nsfw == 0) checked="checked" @endif > No
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="checkbox-field">Upvote</label>
					<div>
						<input @if(isset($user->show_upvote) && $user->show_upvote == 'on') checked="checked" @endif name="show_upvote" type="checkbox" id="checkbox-field"> Hide my upvotes in profile
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
			<form action="{{ url('settings/account') }}" method="POST">
				{{ csrf_field() }}
				{{ method_field('DELETE') }}

				<button type="submit" class="btn btn-danger delete-my-account">Delete my account</button>
			</form>
		</div>
	</div>
@endsection