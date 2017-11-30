<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet"    href="{{ asset('back-end/js/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet"    href="{{ asset('back-end/css/style-login.css') }}">
    <script type="text/javascript" src="{{ asset('back-end/js/dashboard/jquery.min.js') }}"></script>
</head>

    <body cz-shortcut-listen="true">
        <div class="wrapper">
            <div class="login-box">

                <div class="message-erorr">

                    @if(Session::get('worringemail'))
                        <div class="alert-box success">
                            <p>Your email not found!</p>
                        </div>
                    @endif

                    @if($errors->has('email') || $errors->has('password'))
                        <p> {{ $errors->first('email') }}
                        @if($errors->has('email')) <br> @endif
                    {{ $errors->first('password') }}</p>
                    @endif

                        @if(Session::get('login_attempt'))
                            <div class="alert-box success">
                                <p>Tool many login attempts. Please try again <span  id="timer"></span> secounds!</p>
                            </div>

                            <script type="text/javascript">
                                var count=60;
                                var counter=setInterval(timer, 1000); //1000 will  run it every 1 second

                                function timer()
                                {

                                    count=count-1;
                                    if (count <= 0)
                                    {
                                        clearInterval(counter);
                                        //counter ended, do something here

                                        if(count == 0){

                                            $.ajax({
                                                type: "GET",
                                                url: "{{route('login.CheckLoginAttempts')}}",
                                                data: {ip: "<?php echo $_SERVER['REMOTE_ADDR']; ?>",email:" {{Session::get('myemail')}} " },

                                                dataType:"html",
                                                success: function(data){
                                                    console.log(data);
                                                }
                                            });
                                        }
                                        return;
                                    }
                                    document.getElementById("timer").innerHTML=count-1;
                                    //Do code for showing the number of seconds here
                                }
                            </script>
                        @endif

                </div>

                <form role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>Your Email</label>
                        <input placeholder="Email" id="email" class="form-control" name="email" value="{{ old('email') }}" type="email">
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>Password</label>
                        <input placeholder="Password" id="password" class="form-control" name="password" type="password">
                    </div>

                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} value="1">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>Remember Me </label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                        </div>
                    </div>

                    <a href="{{ route('password.request') }}">Forget Your Password?</a><br>
                </form>
            </div>
        </div>

    </body>
</html>
