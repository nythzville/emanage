<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ BASE_URL }}/dashboard/favicon.ico">
    <script src="/front/js/jquery.js" type="text/javascript"></script>
    <title>{{ isset($page_title) ? $page_title:'Employee Management System' }}</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="front/bootstrap/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <script src="/dashboard/scripts/modernizr.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/front/css/style.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    @include('includes.front.mainmenu')
    <!-- Main content -->
    <section class="content">
        @yield('content')
    </section><!-- /.content -->

    <footer>
        “Never put off till tomorrow what you can do today.” <br>–Thomas Jefferson
    </footer>

    <!-- add new calendar event modal -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="/front/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/front/js/my-jquery.js" type="text/javascript"></script>

  </body>
</html>