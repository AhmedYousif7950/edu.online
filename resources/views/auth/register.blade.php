<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>

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
        <form class="form-login" method="post" action="{{route('register')}}">
            <h2 class="form-login-heading">Register</h2>
            <div class="login-wrap">
                <input type="text" name="first_name" class="form-control" placeholder="First Name" autofocus required>
                <br>
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required >
                <br>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <br>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-theme btn-block" id="registerBtn" type="submit"><i class="fa fa-lock"></i> Register</button>
                <div class="print-error-msg-register">
                    <ul  style="color: red"></ul>
                </div>
                <hr>
                <a href="{{route('login')}}">Already Have An Account?</a>

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
        $("#registerBtn").click(function(e) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            e.preventDefault();
            var first_name = $("input[name='first_name']").val();
            var last_name = $("input[name='last_name']").val();
            var email = $("input[name='email']").val();
            var password = $("input[name='password']").val();

            $.ajax({
                url: '{{ route('register') }}',
                type: 'POST',
                data: {
                    first_name: first_name,
                    last_name: last_name,
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
            $(".print-error-msg-register").find("ul").html('');
            $(".print-error-msg-register").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg-register").find("ul").append('<li>' + value + '</li>');
            });
        }
    });

</script>
</body>

</html>
