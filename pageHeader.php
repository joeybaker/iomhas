<!doctype html>
<html lang="en" class="no-js">
<head>
  <meta charset="utf-8">

  <!-- www.phpied.com/conditional-comments-block-downloads/ -->
  <!--[if IE]><![endif]-->

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php echo "".$title ?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!--  Mobile Viewport Fix
        j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag 
  device-width : Occupy full width of the screen in its current orientation
  initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
  maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width
  -->
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">


  <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="<?php echo "$topdir"; ?>favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo "$topdir"; ?>apple-touch-icon.png">


  <!-- CSS : implied media="all" -->
  <link rel="stylesheet" href="<?php echo "$topdir"; ?>css/style.css?v=1">

  <!-- For the less-enabled mobile browsers like Opera Mini -->
  <link rel="stylesheet" media="handheld" href="<?php echo "$topdir"; ?>css/handheld.css?v=1">

 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="<?php echo "$topdir"; ?>js/modernizr-1.5.min.js"></script>


	<!-- css for thickbox -->
	<link rel="stylesheet" href="<?php echo "$topdir"; ?>css/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />
	
	
	
	  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="<?php echo "$topdir" ?>js/jquery-1.4.2.min.js"><\/script>')</script>


  <script src="<?php echo "$topdir" ?>js/plugins.js?v=1"></script>
	<!--   <script src="<?php echo "$topdir" ?>js/script.js?v=1"></script> -->
	
		<!-- jquery plugins -->
		<script src="<?php echo "$topdir" ?>js/jquery.masonry.min.js"></script>
		<script src="<?php echo "$topdir" ?>js/jquery.fancybox-1.3.1.pack.js"></script>
		
	
	<!-- masonary -->
	<script>
	    ($(window).load(function(){
	        $('#main').masonry({
	            columnWidth: 1, 
	            itemSelector: 'img',
	        });
			
	    }))();
	    
	</script>
</head>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->

  <div id="container">
    <header>
		<h1><?php echo $title; ?></h1>
		<nav role="navigation">
			<ul id="pageNav" class="nav">
				<li><a href="#<?php echo $featuredClass; ?>" class="<?php echo $featuredClass; ?>">featured</a></li>
				<li><a href="#all" class="all">all</a></li>
			</ul>
			
		</nav>
		<div class="clearfix"></div>
    </header>
    
    <div id="mainWrap">
    <div id="main">