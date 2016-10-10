@extends('layouts.app-no-sidebar')

@section('content')
	<div class="row settings-page profile-page">
		<div class="col-sm-6">
			@include('includes.settings-sidebar')
		</div>
		<div class="col-sm-18">
			<h1>Categories</h1>
			<table class="table">
				<thead></thead>
					<tr>
						<th>
							Id
						</th>
					</tr>
					<tr>
						<th>Image</th>
					</tr>
					<tr>
						<th>
							Title
						</th>
					</tr>
					<tr>
						<th>Published</th>
					</tr>
					<tr>
						<th>Show in Menu</th>
					</tr>
				<tbody></tbody>
			</table>

		</div>
	</div>
@endsection