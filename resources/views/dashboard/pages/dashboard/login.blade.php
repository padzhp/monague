@extends('dashboard.layout.login')
@section('content')
                    <div class="row">
					<div class="login-panel panel panel-default">
                        <div class="login-logo"></div>
                        <div class="panel-body">
                            <form method="POST" action="{{ url('login') }}">
                                <fieldset>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                            <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                        </div>                                        
                                         @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="checkbox form-check text-center marginbottom-20">
                                        <label  class="form-check-label">
                                            <input type="checkbox" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <!--<a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>-->
                                    <button type="submit" class="margintop-20 btn btn-lg btn-yellow btn-block btn-primary">
                                        Login
                                    </button>                                   
                                    
                                    {{ csrf_field() }}
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    </div>
@stop