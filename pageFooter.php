    </div> <!-- /#main -->
    </div><!-- /#mainWrap -->
    
    <footer>

    </footer>
  </div> <!--! end of #container -->
	

  <!--[if lt IE 7 ]>
    <script src="js/dd_belatedpng.js?v=1"></script>
  <![endif]-->
  
  <script type="text/javascript">
		$(".fancybox").fancybox({
			'speedIn'		:	200, 
			'speedOut'		:	400, 
			'overlayOpacity':	.9,
			'overlayColor'	:	'#888',
			'padding'		: 	0
		});
  </script>


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