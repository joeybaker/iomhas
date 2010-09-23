<?php 
//inital variables. We'll use these throughout.
/*
 * Variables we're inheriting:
 * $title
 * $Description
 * $topdir
*/

	$photos = glob("photos/*\.*"); //get all the images.
	$photosPerPage = 18; //set the number of photos per page
	$photoCount = count($photos); //the total number of photos we have to work with.
	$pageCount = ceil($photoCount/$photosPerPage); //the number of pages we'll need to create. Pages are created for faster load times, and with infinitescroll.js, we're able to load them on the same page.
	$currentPhotoCounter = 0; //let it be known: we start on photo "0" (since we're reading from the $photos array)
	
	$adminEmail = 'joey@byjoeybaker.com'; //set the admin's email to by used for payment!
	$fb_app_id = '150537168304818'; //set your facebook app id
	
	$featuredClass = 'featured'; //the phrase to use for photos that will be featured (made larger on the page).
	$featuredW = 427; //columns are 108px, so the featured width will be 4 columns - 5px for the gutter
	$featuredH = $featuredW * 1.8;
	$defaultW = 211; //columns are 108px, so the default width will be 2 columns - 5px for a gutter.
	$defaultH = $defaultW * 1.8;
	$maxW = 1075;
	include($topdir. 'simpleimage.php');
	
	//gets the current path
	$currentpath = 'http://'.$_SERVER[HTTP_HOST] . dirname($_SERVER['PHP_SELF']);
	
	
	//if the number of photos is less than the number of photos per page, reduce the number of photos per page.
	if ($photoCount < $photosPerPage) $photosPerPage = $photoCount;
?>



<!doctype html>
<html lang="en" class="no-js" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
<head>
	<meta charset="utf-8">
	
	<!-- www.phpied.com/conditional-comments-block-downloads/ -->
	<!--[if IE]><![endif]-->
	
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
	   Remove this if you use the .htaccess -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
<!-- Title and meta properties	 -->
	<title><?php echo $title;?></title>
	<meta name="description" content="<?php echo $Description; ?>">
	<meta name="author" content="">
	<meta property="og:title" content="<?php echo $title;?>"/>
    <meta property="og:type" content="album"/>
    <meta property="og:url" content="<?php echo $currentpath; ?>"/>
    <meta property="og:image" content="http://<?php echo $_SERVER[HTTP_HOST]; ?>/img/loader.gif"/> <!-- TODO: actually use an album image -->
    <meta property="og:site_name" content="<?php echo $_SERVER[HTTP_HOST]; ?>"/>
	<meta property="fb:app_id" content="<?php echo $fb_app_id; ?>"/>
    <meta property="og:description" content="<?php echo $Description; ?>"/>

  

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
  	<div id="beta">This is only a beta site. Please, mind the gaps.</div>
    <header>
		<h1><?php echo $title; ?></h1>
		<h2><?php echo $Description; ?></h2>
		<nav role="navigation">
<!--

	Navigation currently doens't play nice with infinite scroll, so we'll disable it for now.
			<ul id="topNav" class="nav">
				<li><a href="#<?php echo $featuredClass; ?>" class="<?php echo $featuredClass; ?>">featured</a></li>
				<li><a href="#all" class="all">all</a></li>
			</ul>
			
-->
			<a id="homeLink" href="<?php echo $topdir; ?>">&#x21D0; back</a>
		</nav>
		<div class="clearfix"></div>
    </header>
    
    <div id="mainWrap">
    <div id="main">
		<?php
// HELPER FUNCITONS			
			
			
			// returns the image size as an array using the standard php functions. Call it by assigning it to a variable.
			// e.g. $imgsize = getSize('full path to photo');
			// after calling it, you can use the resulting array:
			// [0] = width; [1] = height; [2] = file type; [3] = html of the width and height
			function getSize($photo) {
				$imginfo = getimagesize($photo);
				return $imginfo;
			}
			
			//returns the path of the current photo being acted upon in the loop
   			function getCurrentPhoto($currentPhotoCounter){
   				global $photos;
   				$currentPhoto = $photos[$currentPhotoCounter]; //get the photo.
   				return $currentPhoto;
   			}
   			
   			
   			// determines if the photo is a featured photo by checking to see if the word "featured" is in the file name.
   			// TODO: this should instead rely on IPTC data of 4 stars or more.
   			function is_featured($photo) {
   				global $featuredClass;
   				$featch = strpos($photo, $featuredClass); //returns false if the doesn't have the featured class in it's file name. This allows us to test to see if the photo is featured or not.
				($featch !== false) ? $featch = true : $featch = false;
				return $featch;
   			}
   			
   			//detect if the image is a panorama
   			function is_pano($photo) {
   				$imgsize = getSize($photo);
   				$imgsize[0] > $imgsize[1] * 3 ? $pano = true : $pano = false;
   				
   				return $pano;
   			}
   			
   			//write a file to let us know that we've generated the thumbs and pages so we don't do it again. (huge performance boost)
   			function set_generated($generated) {
   				if ($generated) {
	   				$genname = fopen("generated", 'w') or die("can't open file");
		   				$write = "Last generated at " . date(r) . "\n" ;
		   				fwrite($genname, $write);
	   				fclose($genname);
	   			}
   			}
   			
   			//detect if we've already generated the content.
   			function is_generated() {
				//check to see if we've already created the file that lets us know we've generated the content.
				file_exists('generated') ? $gen = true : $gen = false;
	   			
   				return $gen;
   			}
   			
   			//get the image info. 
   			function get_image_iptc($photo, $arg) {
   				$img = getimagesize($photo, $info);
   				$iptc = iptcparse ($info["APP13"]); 
   				
   				switch ($arg) {
   					case "caption"	: $output = $iptc["2#120"][0]; break;
   					case "keywords"	: $output = $iptc["2#025"][0]; break;
   					case "title"	: $output = $iptc["2#105"][0]; break;
   					//useful for debugging
   					//case "all"	: print_r(array_keys($iptc)); print_r(array_values($iptc)); break;
   					case null 		: $output = null;
   					default 		: $output = null;
   				}
   				
   				return htmlentities($output);
   			}
   			
   			//returns the path of the thumbnail of the photo passed.
   			function get_thumb_path ($photo) {
   				global $currentpath;
   				$finfo = pathinfo($photo);
				$thumbPath = $currentpath . '/photos/thumbs/'. $finfo['filename'] . '-thumb.' . $finfo['extension'];
   				return $thumbPath;
   			}
   			
			//detects if the url contains a permalink.
			//If so it will return the image number of the permalink.
			//If the URL does not contain a permalink, it will return false.
			function is_permalink () {
				$permalink = $_GET[img];
				
				if ($permalink == null || $permalink == '' || !is_numeric($permalink)) return false;
				else return $permalink;
			}
			
			function is_generate_url () {
				$genurl = $_GET[gen];
				
				if ($genurl != 'true') return false;
				elseif ($genurl == 'true') return true;
			}
   			
   			//Used to grab the first featured image and set it as the album photo.
   			/*
function get_album_image($files) {
   				for ($i=0;$i<count($files);$i++) {
   					if (is_featured($files[$i])) $output = $files[$i];
   					else break 1;
   				}
   				
   				return $output;
   			}
*/

   			
   			
//CONTENT GENERATION FUNCITONS
			
			// This function generates thumbnails.
			// TODO: this currently generates thumbs each time the page is loaded. This is very slow and needs to be corrected.
			function createThumb($photo) {
				global $featuredW;
				global $featuredH;
				global $defaultW;
				global $defaultH;
				global $maxW;
				
				//if the image is featured, use the featured size. If not, use defaults.
				if (is_featured($photo)) {
					$w = $featuredW;
					$h = $featuredH;
				}
				else {
					$w = $defaultW;
					$h = $defaultH;
				}
				
				//get the parts of the photo file name so we can rename it.
				$ext = pathinfo($photo, PATHINFO_EXTENSION);
				$pnm = pathinfo($photo, PATHINFO_FILENAME);
				$thumbPath = 'photos/thumbs/' .$pnm . '-thumb.' . $ext;
				$imgsize = getSize($photo);

				//this uses the simpleimage.php include to set the new size.
				$image = new SimpleImage();
					$image->load($photo);
					//detect if the image is a panorama. If it is, we'll set the width of the thumbnail to the orignal width, but won't exceed 1080px wide.
					if (is_pano($photo)) {
						$imgsize[0] >= $maxW ? $image->resizeToWidth($maxW) : $image->resizeToWidth($imgsize[0]);
					}
					//resize the thumbnail by the larger dimension. (portrait & landscape photos will get different sizes.
					else $w >= $h ? $image->resizeToHeight($h) : $image->resizeToWidth($w);
			    if (!file_exists('photos/thumbs/')) mkdir('photos/thumbs', 0755);
			    $image->save($thumbPath);
   			}
   			
   			//this function generates static html pages for permalink purposes.
   			//it needs to be called with in the DO EVERYTHING to get access to the $currentPhotoCounter
   			function createPermalinks ($currentPhotoCounter) {
   				global $title;
   				global $fb_app_id;
   				global $currentpath;
   				
   				if (!file_exists('l/')) mkdir('l/', 0755);

   				$num = $currentPhotoCounter + 1;   			
   				$pagename = "img" .$num. ".html";
   				$RpageURI = 'l/' .$pagename;
   				$pageURI = $currentpath .'/'. $RpageURI;
   				$permalinkURL = $currentpath . '?img=' . $num;
   				
				$fname = fopen($RpageURI, 'w') or die("can't open file");
					//write the header
					$beginHTML = '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraph.org/schema/">';
					$beginHTML .= "\n <head> \n";
						fwrite($fname, $beginHTML);
					//write the title
					$imgtitle = $title. ' img' .$num;
					$titleHTML = '<title>' .$imgtitle. '</title>' . "\n";
						fwrite($fname, $titleHTML);
					//write the meta
					$metaHTML = '<meta property="og:title" content="'.$imgtitle.'"/>'."\n";
					$metaHTML .= '<meta property="og:site_name" content="'.$_SERVER[SERVER_NAME].'"/>'."\n";
					$metaHTML .= '<meta property="og:type" content="album"/>'."\n";
					$metaHTML .= '<meta property="og:url" content="'.$pageURI.'"/>'."\n";
					$metaHTML .= '<meta property="og:image" content="'.get_thumb_path(getCurrentPhoto($currentPhotoCounter)).'"/>'."\n";
					//$metaHTML .= '<meta property="fb:admins" content="5513221"/>'."\n";
					$metaHTML .= '<meta property="fb:app_id" content="'.$fb_app_id.'"/>'."\n";
						fwrite($fname, $metaHTML);
					$redirectHTML = '<meta http-equiv="refresh" content="0;url='.$permalinkURL.'">' . "\n";
						fwrite ($fname, $redirectHTML);
					//write the foooter
					$endHTML = '</head><body></body></html>';
						fwrite($fname, $endHTML);
				fclose($fname);
   			
   			}
   			
   			
   			//this function will return the full html for a thumbnail image. You should wrap it in a link.
   			function showThumb($photo) {
				$thumbPath = get_thumb_path($photo);
				$imgsize = getSize($thumbPath);
				$output = '<img src="' .urldecode($thumbPath). '" alt="'.get_image_iptc($photo, "caption").'" title="'.get_image_iptc($photo, "caption").'" ' .$imgsize[3].' />';
					
				return $output;
   			}
			
			//Function to display the next photo.
			//Returns a string, so to use this you must echo the function.
			//e.g. echo showPhotoToString("photo to show");
			function showPhotoToString($currentPhoto) {
				global $featuredClass;
				global $currentpath;
				global $currentPhotoCounter;
				$num = $currentPhotoCounter + 1;
				
				//write out the html
				$output = '<a href="' . $currentpath .'/'. $currentPhoto . '" class="fancybox';
					if (is_featured($currentPhoto)) $output .= ' '.$featuredClass;
					$output .= '" rel="fancy-group" id="img'.$num.'">'.showThumb($currentPhoto).'</a>' ."\n\t\t";
				return $output;
			}
			
			
//DO EVERTHING. (world domination to come)
			
			//display the photos for the index page.
			//first check to see if the page has already genrated the thumbs, if not, then we'll do that.
			if (!is_generated() || is_generate_url()) {
				while ($currentPhotoCounter<$photosPerPage) {
					$currentPhoto = getCurrentPhoto($currentPhotoCounter);
					createThumb($currentPhoto);
					echo showPhotoToString($currentPhoto);
					createPermalinks ($currentPhotoCounter);
					$currentPhotoCounter++;
				}
			}
			//if we've already generated the the thumbs, then don't do it again.
			else {
				while ($currentPhotoCounter<$photosPerPage) {
					$currentPhoto = getCurrentPhoto($currentPhotoCounter);
					echo showPhotoToString($currentPhoto);
					$currentPhotoCounter++;
				}
			}
			
			//if there's more pages, display the nav link
			if ($pageCount > 1) {
				echo '<p id="pageNav"><a id="next" href="page2.php">next page</a></p>'."\n";
				
				//this creates pages for infinite scroll. We start on page 2 because the index is page 1. We'll first check to make sure we haven't done this before.
				if (!is_generated() || is_generate_url()) {
					for ($currentPage=2; $currentPage<=$pageCount; $currentPage++) { 					//create a new page and overwrite any content previously written there.
						$pagename = "page" .$currentPage. ".php";
						$fname = fopen($pagename, 'w') or die("can't open file");
							//write the header
							$beginHTML = '<?php  $topdir = "../"; include("' .$topdir. 'pageHeader.php"); ?>' . "\n";
							fwrite($fname, $beginHTML);
							//write out all the photos.
							for ($i=0; $i<$photosPerPage; $i++) {
								$currentPhoto = getCurrentPhoto($currentPhotoCounter);
								createThumb($currentPhoto);
								$display = showPhotoToString($currentPhoto);
								createPermalinks ($currentPhotoCounter);
								$currentPhotoCounter++;				
								fwrite($fname, $display);
								if ($currentPhotoCounter == ($photoCount-1)) break; //ensure that don't create photos that aren't there.
							}
							//create the nav link
							$nextPage = $currentPage + 1;
								$navLinkString = '<p id="pageNav"><a id="next" href="page' .$nextPage.'.php">next page</a></p>';
								fwrite($fname, $navLinkString);
							//if this is the last page, let us know that
							if ($currentPage == $pageCount){
								$endText = '<h3 id="endText">No more photos!</h3>';
								fwrite($fname, $endText);
							}
							//write the foooter
							$endHTML = '<?php include("' .$topdir. 'pageFooter.php");  ?>';
								fwrite($fname, $endHTML);
						fclose($fname);
					}
				}
			}
			
			//When we're done generated all the content, we'll call the function say so. This should prevent us from regenerating the content Ð giving us a huge performance boost.
			set_generated(true);
			//now that we've generated all the thumbs, we'll make sure that the array to hold them actually É holds them.
			$thumbs = glob("photos/thumbs/*\.*");

						
			//TODO: move the code to create more pages to the bottom of the page (below js) to make the first page load faster. (wait until the code is locked in before doing so, to make editing easier.)
		?>
    </div> <!-- /#main -->
    </div><!-- /#mainWrap -->
    
    <footer>

    </footer>
    
    
  </div> <!--! end of #container -->


  <!-- Javascript at the bottom for fast page loading -->

	<div id="fb-root"></div><!-- required for Facebook API -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="<?php echo "$topdir" ?>js/jquery-1.4.2.min.js"><\/script>')</script>


  <script src="<?php echo "$topdir" ?>js/plugins.js?v=1"></script>
<!--   <script src="<?php echo "$topdir" ?>js/script.js?v=1"></script> -->

	<!-- jquery plugins -->
	<script src="<?= $topdir ?>js/jquery.masonry.min.js"></script>
	<script src="<?= $topdir ?>js/jquery.infinitescroll.min.js"></script>
	<script src="<?= $topdir ?>js/jquery.fancybox-1.3.1.pack.js"></script>
<!-- 	<script src="<?= $topdir ?>js/jquery.pageslide.min.js"></script> -->

	<!-- Other Javascript	 -->
	<script src="<?= $topdir ?>js/simpleCart.min.js"></script>
	

<!-- masonary and fancybox get called-->
<script type="text/javascript">

	//Facebook API call
	window.fbAsyncInit = function() {
	FB.init({appId: '150537168304818', status: true, cookie: true,
	         xfbml: true});
	};
	(function() {
	var e = document.createElement('script'); e.async = true;
	e.src = document.location.protocol +
	  '//connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e);
	}());
	
	
	
	//adds the caption to fancybox	
	function formatTitle(title, currentArray, currentIndex, currentOpts) {
		var
			link = '<?= $currentpath ?>/l/img' +(currentIndex + 1)+ '.html'
			encodeLink= escape(link)
		;
		
		return '<div id="img-caption"><p>' + (title && title.length ? '<strong>' + title + '</strong>' : '' ) + '</p><fb:like href="' + link + '" colorscheme="dark" id="fblike"></fb:like><span> Image ' + (currentIndex + 1) + ' of ' + currentArray.length + '</span></div>' + simpleCartHTML();
	}
	
	//add button for pageslide
	function formatSlideButton () {
		return '<a href="<?= $topdir ?>page-slideout.php" id="slide-left">slide me</a>';
	}
	
	//add simpleCart
	function simpleCartHTML () {
	
		return '<div class="simpleCart_shelfItem"><h2 class="item_name"> This Photo </h2><select class="item_size"> <option value="Small"> Small </option><option value="Medium"> Medium </option><option value="Large"> Large </option></select>	<input type="text" value="1" class="item_Quantity"><br /><span class="item_price">$35.99</span><a class="item_add" href="javascript:;">Add to Cart</a></div>';
	}
	
	//Add additional stuff around fancybox. This is all Facebook widgets right now.
	function fancyboxAppend () {
		var area = '#fancybox-overlay';
		
		$(area).append($('#fblike'));
		$(area).append($('#fbcomments'));
		//$(area).append($('#slide-left'));
		$(area).append($('.simpleCart_shelfItem'));
		fbRender(area);
		setTimeout( function () { $('#fblike').fadeIn();}, 100);
		//$('#fbcomments').show();
	}
	
	//called when fancybox either transitions or closes, used to remove added elements.
	function fancyboxRemove () {
		$('#fblike').remove();
		$('#fbcomments').remove();
		//$('#slide-left').remove();
		$('.simpleCart_shelfItem').remove();
	}
	
	//renders XFBML after the page load for fancybox
	function fbRender(area) {
	   FB.XFBML.parse(document.getElementById(area));
	}



//Main jQuery funcitons are called here.
//These are functions that must load before the page loads.
$(function(){
  
  var
  	$wall = $('#main')
  	item = '.fancybox:not(.invis)'
  ;


  $wall.masonry({
    columnWidth: 108, 
    itemSelector: item,
  });
  
  	//setup fancybox
	$(item).fancybox({
		'speedIn'		:	200, 
		'speedOut'		:	400, 
		'overlayOpacity':	.9,
		'overlayColor'	:	'#222',
		'padding'		: 	0,
		'margin'		:	60,
		'titlePosition' : 'outside',
		'titleFormat'	: formatTitle,
		'centerOnScroll': true,
		'autoScale'		: true,
		'onComplete'	: fancyboxAppend,
		'onStart'		: fancyboxRemove
	});
  
  $wall.infinitescroll({
    navSelector  : '#pageNav',  // selector for the paged navigation 
    nextSelector : '#next',  // selector for the NEXT link (to page 2)
    itemSelector : item,     // selector for all items you'll retrieve
    loadingText	 : "<em>Loading more photos&hellip;</em>",
    loadingImg : '<?php echo "$topdir" ?>img/loader.gif',
    donetext  : 'No more photos to load.',
    bufferPx     : 1200,
    debug: false,
    errorCallback: function() { 
      // fade out the error message after 2 seconds
      $('#infscr-loading').animate({opacity: .8},2000).fadeOut('normal');   
    }
  },
    // call masonry and fancybox as a callback
	function( newElements ){
	    $wall.masonry({ appendedContent: $(newElements) });
	    $(item).fancybox({
			'speedIn'		:	200, 
			'speedOut'		:	400, 
			'overlayOpacity':	.9,
			'overlayColor'	:	'#222',
			'padding'		: 	0,
			'margin'		:	60,
			'titlePosition' : 'outside',
			'titleFormat'	: formatTitle,
			'centerOnScroll': true,
			'autoScale'		: true,
			'onComplete'	: fancyboxAppend,
			'onStart'		: fancyboxRemove
		});

	}
  );
});



//Force infinite scroll to load at least once.
$(document).ready(function() {
	
	//trigger infinitescroll
	//for(i=0;i<=<?php echo $pageCount;?>;i++){
		$(document).trigger('retrieve.infscr');
	//}
	
	//beta notice
	setTimeout(function(){
			$('#beta').slideUp('slow');
		},
		3000
	);
	
	//The following code deals with permalinks
	<?php 
	if (is_permalink()) { ?>
		$("#img<?php echo is_permalink();?>").trigger('click');
	<?php } ?>
	
	//Setup filtering. Disabled because it doesn't play nicely with infinite scroll.
	$('#topNav a').click(function(){
	  var
	  	colorClass = '.' + $(this).attr('class')
	  	speed = 500
	  	$wall = $('#container').find('#main')
	  	item = '.fancybox:not(.invis)'
	  ;
	
	  if(colorClass=='.all') {
	    // show all hidden boxes
	    $wall.children('.invis')
	      .toggleClass('invis').fadeIn(speed);
	  } else {  
	    // hide visible boxes 
	    $wall.children().not(colorClass).not('.invis')
	      .toggleClass('invis').fadeOut(speed);
	    // show hidden boxes
	    $wall.children(colorClass+'.invis')
	      .toggleClass('invis').fadeIn(speed);
	  }
	  $wall.masonry();
	
	  return false;
	});

	//pageslide calls
//	  $("#slide-left").pageSlide({ width: "350px", direction: "left" });
//    $("#slide-right").pageSlide({ width: "350px", direction: "right" });
//    $("#slide-modal").pageSlide({ width: "350px", direction: "left", modal: true });
		
});



	//set simpleCart options
	simpleCart.email = "<?= $adminEmail ?>";
	simpleCart.shippingFlatRate = 10.00;
	

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