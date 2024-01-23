@extends('layouts.login')
@section('login')
<div class="card-body login-card-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{{ asset('template/index3.html') }}" method="post">
      <div class="input-group mb-3">
        <input type="email" class="form-control" placeholder="Email">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Password">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-4  ml-auto">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <p class="mb-0">
      <a href="/register" class="text-center">Register a new membership</a>
    </p>
  </div>
@endsection