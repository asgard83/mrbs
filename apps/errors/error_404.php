<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="msapplication-tap-highlight" content="no">
	<meta name="description" content="Meeting Booking Room">
	<meta name="keywords" content="e-SARPRAS, MRBS, Meeting Booking Room">
	<link href="<?= base_url(); ?>public/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>
<style>
html,
body {
	height: 100%;
}
html {
	display: table;
	margin: auto;
}
body {
	display: table-cell;
	vertical-align: middle;
}
</style>
<body class="cyan">
	<div id="error-page">
		<div class="row">
		  <div class="col s12">
			<div class="browser-window">
			  <div class="top-bar">
				<div class="circles">
				  <div id="close-circle" class="circle"></div>
				  <div id="minimize-circle" class="circle"></div>
				  <div id="maximize-circle" class="circle"></div>
				</div>
			  </div>
			  <div class="content">
				<div class="row">
				  <div id="site-layout-example-top" class="col s12">
					<p class="flat-text-logo center white-text caption-uppercase">Sorry but we couldn’t find this page :(</p>
				  </div>
				  <div id="site-layout-example-right" class="col s12 m12 l12">
					<div class="row center">
					  <h1 class="text-long-shadow col s12">404</h1>
					</div>
					<div class="row center">
					  <p class="center white-text col s12">It seems that this page doesn’t exist.</p>
					  <p class="center s12"><button onclick="goBack()" class="btn waves-effect waves-light">Back</button> <a href="index.html" class="btn waves-effect waves-light">Homepage</a>
						</p><p>
						</p>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
</body>
</html>