@extends('layouts.app-no-sidebar')

@section('content')
    <div class="row settings-page">
        <div class="col-sm-6">
            @include('includes.settings-sidebar')
        </div>
        <div class="col-sm-18">
            <h1>Password</h1>
            <form action="{{ url('settings/password') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputEmail1">Old Password</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" name="old_password" placeholder="Old Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="new_password" placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword2">Re-type Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword2" name="repeat_new_password" placeholder="Re-type Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
