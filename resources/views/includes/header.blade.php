{{-- Facebook Page Plugin --}}
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=1444746089151772";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
{{-- END Facebook Page Login --}}

<header id="header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-lg-2 logo ">
				<a href="/"><h1 id="logo">Race IT</h1></a>
			</div>
			<div class="col-sm-9 col-lg-7 head-nav">
				<div class="mobile-logo2">
					<h1><a href="/">Race IT</a></h1>
				</div>
				<!-- subnav -->
				<div class="subnav">
					<div class="uc text">
						<p class="questions">New! <a href="#" target="_blank">Race IT Stories</a></p>
						<div class="head-social">
							<h4>Follow Us</h4>
							<ul>
								<li><a class="facebook" href="#" target="_blank">Facebook</a></li>
								<li><a class="twitter" href="#" target="_blank">Twitter</a></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end subnav -->
				<!-- Head Nav -->
				<a class="toggleMenu" href="#">
					<img src="/images/toggle-icon.png" border="0" class="toggle-icon">
				</a>
				<nav class="clearfix">
					<ul class="topMenu menu">
						<li><a href="/about" class="parent hover">About Us</a>
							<ul>
								<li><a href="#">What Makes Us Different</a></li>
								<li><a href="#">Team</a></li>
								<li><a href="#">Careers</a></li>
								<li><a href="/contact-us">Contact Us</a></li>
								<li><a href="#">News</a></li>
								<li><a href="#">Newsletters</a></li>
							</ul>
						</li>
						<li><a href="#" class="parent hover">Event Organizers</a>
							<ul>
								<li><a href="{{ BASE_URL }}/events">Events</a></li>
								<li><a href="#">Why Choose Us?</a></li>
								<li><a href="#">Our Services</a></li>
								<li><a href="#">Stories</a></li>
								<li><a href="#">Registration Refund</a></li>
								<li><a href="#">Demo Sign-up</a></li>
							</ul>
						</li>
						@if( Auth::check() )
						<li><a href="{{ BASE_URL }}/event/add">Create An Event</a></li>
						@else
						<li><a href="{{ BASE_URL }}/events">Find Events</a></li>
						@endif
						<li><a href="#">Take a Tour</a></li>
						<li><a href="#">Help</a></li>
					</ul>
				 <!-- Navigation -->
				</nav>
			</div>
			<div class="col-xs-12 col-md-3 visible-lg account-box">
				<div class="account-mobile">
					<div class="account-options">
						<div id="ctl00_Top_loginContainer" class="loginMiniFormContainer"></div>
						@if( Auth::check() )
							<p style="color:#fff;text-transform:capitalize;">Welcome <strong>{{Auth::user()->user_firstname}}</strong></p>
				           	<a href="/event" id="ctl00_Top_logLinkMiniForm" class="btn btn-sm btn-primary" style="font-weight:bold;">DASHBOARD</a>
				           	<a href="/logout" id="ctl00_Top_logLinkMiniForm" class="btn btn-sm logout" style="font-weight:bold;">LOGOUT</a>
				        @else
				        	<p style="color:#fff;text-transform:capitalize;">Welcome <strong>Guest</strong></p>
				           	<a href="/login" id="ctl00_Top_logLinkMiniForm" class="login">Login</a>
							<a href="/signup" id="ctl00_Top_createLinkMiniForm" class="create">Create An Account</a>
				        @endif
					</div>
				</div>
					<div class="search-event-drop">

					</div>
				</div>
			</div>

		</div>
	</div>
</header>