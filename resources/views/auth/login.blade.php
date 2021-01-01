<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login</title>

  <!-- Favicons -->
  <link href="{{asset('assets')}}/img/favicon.png" rel="icon">
  <link href="{{asset('assets')}}/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="{{asset('assets')}}/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="{{asset('assets')}}/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="{{asset('assets')}}/css/style.css" rel="stylesheet">
  <link href="{{asset('assets')}}/css/style-responsive.css" rel="stylesheet">

  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
  <div id="login-page">
    <div class="container">
      <form class="form-login" method="post" action="{{route('login')}}">
        <h2 class="form-login-heading">Login</h2>
        <div class="login-wrap">
          <input type="email" name="email" class="form-control" placeholder="Email" autofocus required>
          <br>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <label class="checkbox"></label>
          <button class="btn btn-theme btn-block" id="loginBtn" type="submit"><i class="fa fa-lock"></i> Login</button>
            <div class="print-error-msg-login">
                <ul  style="color: red"></ul>
            </div>

          <hr>
          <a href="{{route('register')}}">Create An Account?</a>
      </form>
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="{{asset('assets')}}/lib/jquery/jquery.min.js"></script>
  <script src="{{asset('assets')}}/lib/bootstrap/js/bootstrap.min.js"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="{{asset('assets')}}/lib/jquery.backstretch.min.js"></script>
  <script>
    $.backstretch("{{asset('assets')}}/img/login-bg.jpg", {
      speed: 500
    });

    $(document).ready(function() {
        $("#loginBtn").click(function(e) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            e.preventDefault();
            var email = $("input[name='email']").val();
            var password = $("input[name='password']").val();

            $.ajax({
                url: '{{ route('login') }}',
                type: 'POST',
                data: {
                    email: email,
                    password: password
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        //alert(data.success);
                        document.location.href = data.success;
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });

        });

        function printErrorMsg(msg) {
            $(".print-error-msg-login").find("ul").html('');
            $(".print-error-msg-login").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg-login").find("ul").append('<li>' + value + '</li>');
            });
        }
    });
  </script>
</body>

</html>
