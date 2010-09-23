<?php
	$featuredClass = 'featured';
?>
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
		<?php
		
			$thumbs = glob("photos/*-thumb\.*");
						
			for ($i=0; $i<count($thumbs); $i++) {
				$num = $thumbs[$i];
				$featch = strpos($num, $featuredClass);
				echo '<a href="photos/';
					if ($i<10) echo '0';
					echo $i;
					if ($featch != false) echo '-' .$featuredClass;
				echo '.jpg" class="fancybox';
					if ($featch != false) echo ' ' .$featuredClass;
				echo '" rel="fancy-group"><img ';
				echo 'src="'.$num.'" alt=""/></a>';
			}

		?>
    </div> <!-- /#main -->
    </div><!-- /#mainWrap -->
    
    <footer>

    </footer>
  </div> <!--! end of #container -->


  <!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="<?php echo "$topdir" ?>js/jquery-1.4.2.min.js"><\/script>')</script>


  <script src="<?php echo "$topdir" ?>js/plugins.js?v=1"></script>
<!--   <script src="<?php echo "$topdir" ?>js/script.js?v=1"></script> -->

	<!-- jquery plugins -->
	<script src="<?php echo "$topdir" ?>js/jquery.masonry.min.js"></script>
	<script src="<?php echo "$topdir" ?>js/jquery.infinitescroll.js"></script>
	<script src="<?php echo "$topdir" ?>js/jquery.fancybox-1.3.1.pack.js"></script>
	

<!-- masonary -->
<script>
	$(".fancybox").fancybox({
		'speedIn'		:	200, 
		'speedOut'		:	400, 
		'overlayOpacity':	.9,
		'overlayColor'	:	'#888',
		'padding'		: 	0
	});

    ($(window).load(function(){
    	var speed = 500;

        $('#main').masonry({
            columnWidth: 10, 
            itemSelector: 'img:not(.invis)',
            animate: true,
		    animationOptions: {
		        duration: speed,
		        queue: false
		    }
        });
		
		//TODO: infinitescroll not implemented yet.
		//it's possible that only loading 
        $('#primary').infinitescroll({
            navSelector  : "#page_nav",    // selector for the paged navigation 
            nextSelector : "#page_nav a",    // selector for the NEXT link (to page 2)
            itemSelector : ".box",       // selector for all items you'll retrieve
            loadingImg : 'img/loader.gif',
            donetext  : "No more pages to load.",
            debug: true,
            errorCallback: function() { 
                // fade out the error message after 2 seconds
                $('#infscr-loading').animate({opacity: .8},2000).fadeOut('normal');     
            }
        },
            // call masonry as a callback.
            function() { $('#main').masonry({ appendedContent: $(this) }); }
        );
        
        //TODO: toggling between featured and all should be one button.
        //BUG: selecting featured does not resort via masonry.
        $('#pageNav a').click(function(){
		    var colorClass = '.' + $(this).attr('class');
		    
		    if(colorClass=='.all') {
		        // show all hidden boxes
		        $('#main').children('.invis')
		            .toggleClass('invis').animate({opacity: 1},{ duration: speed });
		    } else {    
		        // hide visible boxes 
		        $('#main').children().not(colorClass).not('.invis')
		            .toggleClass('invis').animate({opacity: 0},{ duration: speed });
		        // show hidden boxes
		        $('#main').children(colorClass+'.invis')
		            .toggleClass('invis').animate({opacity: 1},{ duration: speed });
		    }
		    $('#main').masonry();
		
		    return false;
		});

    }))();
    
</script>
	

  <!--[if lt IE 7 ]>
    <script src="js/dd_belatedpng.js?v=1"></script>
  <![endif]-->


  <!-- yui profiler and profileviewer - remove for production -->
  <script src="<?php echo "$topdir" ?>js/profiling/yahoo-profiling.min.js?v=1"></script>
  <script src="<?php echo "$topdir" ?>js/profiling/config.js?v=1"></script>
  <!-- end profiling code -->


  <!-- asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet 
       change the UA-XXXXX-X to be your site's ID -->
  <script>
   var _gaq = [['_setAccount', 'UA-4816437-5'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = '//www.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
  </script>
  
</body>
</html>