<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ BASE_URL }}/dashboard/images/icon.png">

    <title>PinoyTime - Mavericks Employee Management System</title>
    <!-- <title>{{ isset($page_title) ? $page_title:'' }}</title> -->

    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="/common/bootstrap/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ BASE_URL }}/dashboard/css/theme.css">

    <link rel="stylesheet" href="{{ BASE_URL }}/dashboard/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="{{ BASE_URL }}/dashboard/css/style.css">

    <link rel="stylesheet" href="{{ BASE_URL }}/dashboard/css/styledashboard.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="skin-black">
  @include('includes.dashboard.header')
  
  @if( Auth::user()->account_type == 'normal')
    @include('includes.dashboard.employee.mainmenu')
  @else
    @include('includes.dashboard.mainmenu')
  @endif

  <aside class="right-side clearfix" @if(isset($birthday_counter))
  id="contents"
  @endif
  >
    @yield('content')
  </aside>

  @include('includes.dashboard.footer')