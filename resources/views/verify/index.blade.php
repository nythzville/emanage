@extends('layouts.pages')

@section('content')
	<div class="container main-wrap">
		<div class="row main-content">
			<div class="col-md-8 left-sidebar" >
				<div class="content-seperator">
					@if($VERIFIED)
					<span class="page-verify-domain-name"><span style="font-weight: bold">{{ $domain->domain_name }}</span> <span class="label label-success">is a certified site</span></span>
					@else
					<span class="page-verify-domain-name"><span style="font-weight: bold">{{ $domain->domain_name }}</span> <span class="label label-danger">is NOT verified</span></span>
					@endif
				</div>
				@if($VERIFIED)
				<div class="content-seperator">
					<div class="row">
						<div class="col-sm-6" >
							<p>No malware found.</p>
							<p>No malicious links found.</p>
							<p>No phishing detected.</p>
						</div>

						<div class="col-sm-6" >
							laptop here
						</div>
					</div> <!-- /row -->
				</div>
				<div class="content-seperator">
					<div class="row">
						<div class="col-sm-4" >
							<a class="" href="{{ BASE_URL }}/">
						        <img src="{{ BASE_URL }}/images/logo-shield-small.png" class="img-responsive" />
						    </a>
						</div>

						<div class="col-sm-8" >
							This site is tested and certified to be secure by the world's largest dedicated security company. Make sure you're browsing the safe web. Choose certified sites and stay safe online.
						</div>
					</div> <!-- /row -->
				</div>
				@endif


				<div class="content-seperator">
					<div class="row">
						<div class="col-xs-12">
							<div class="l7">
								ABOUT THIS SITE
							</div>
							<p>{{ $domain->domain_description ? $domain->domain_description : 'none' }}</p>
						</div>

						<div class="col-xs-6">
							<div class="l7">
								ADDRESS
							</div>
							<p>{{ $domain->domain_address ? $domain->domain_address : 'none' }}</p>
						</div>

						<div class="col-xs-6">
							<div class="l7">
								SUPPORT EMAIL
							</div>
							<p>{{ $domain->domain_support_email ? $domain->domain_support_email : 'none' }}</p>
						</div>

						<div class="col-xs-6">
							<div class="l7">
								WEBSITE
							</div>
							<p>{{ $domain->domain_website ? $domain->domain_website : 'none' }}</p>
						</div>

						<div class="col-xs-6">
							<div class="l7">
								CATEGORIES
							</div>
							<p>{{ $domain->category->category_name ? $domain->category->category_name : 'none' }}</p>
						</div>

						<div class="col-xs-6">
							<div class="l7">
								CERTIFIED UNTIL
							</div>
							<p>{{ $domain->category->subscription_ends_at ? strtotime($domain->category->subscription_ends_at) > time() ? $domain->category->subscription_ends_at: 'Expired' : 'Expired' }}</p>
						</div>


					</div> <!-- /row -->
				</div>
			</div>
			<div class="col-md-4 right-sidebar">
				<div class="box-content">
					<div class="img">
						<img src="{{ BASE_URL }}/images/vp-safe-browsing-guy.png" class="img-responsive" />
					</div>
					<div class="content">
					Avoid phishing, malware, and other online dangers. Our free Chrome extension shows you which sites are safe and which to avoid. 
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection