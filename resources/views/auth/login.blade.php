@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="login login-v1">
        <!-- begin login-container -->
        <div class="login-container">
            <!-- begin login-header -->
            <div class="login-header">
                <div class="brand">
                     <b>Authentication</b>
                    <small>LaraVue App</small>
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
            </div>
            <!-- end login-header -->
            <!-- begin login-body -->
            <div class="login-body">
                <!-- begin login-content -->
                <div class="login-content">
                    <form action="{{ route('login') }}" method="POST" class="margin-bottom-0">
                        @csrf
                        <div class="form-group m-b-20">

                            <input id="email" type="email" placeholder="your email" class="form-control underline form-control-sm  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group m-b-20">
                            <input id="password" type="password" placeholder="your password" class="form-control underline form-control-sm  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="checkbox checkbox-css m-b-20">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>

                        <div class="login-buttons">
                            <button type="submit" class="btn btn-primary btn-block btn-md">Sign me in</button>
                        </div>
                    </form>
                    @if (Route::has('password.request'))
                        <div class="mt-20">
                            <p>&nbsp;</p>
                            Forgot password? Click
                            <a class="" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                             to reset.
                        </div>

                    @endif
                </div>
                <!-- end login-content -->
            </div>
            <!-- end login-body -->
        </div>
        <!-- end login-container -->
    </div>
</div>
@endsection
