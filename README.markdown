###  íomhás

## CHANGELOG:

#0.2
* v0.9 -August 10th, 2010 - Initial release of HTML5 Boilerplate
* permalinks created as separate html files
* basic Facebook functionality added

## LICENSE:

The Unlicense (aka: public domain) http://unlicense.org

## INSTALLATION:

# Requirements
* PHP 5
* PHP shortcuts enabled (enable writing of <?= $var ?> instead of <?php echo $var ?>)
* No database required

## TODO
* build a login option (clickpass?)
** enable admins to upload photos
** enable admins to change display settings
** enable caption editing
* enable filtering
* enable photo title
* enable photo credit if multiple authors
* build a homepage
* enable set URL to permalink on click.
* create a 'shopping cart'
* build a URL that will re-generate the page.
* build a fancybox-style indicator that the page is generating.
* use media querys to not rely on masonry for mobile

## IDEAS
* make thumb size relative to window size

##KNOWN ISSUES
* If you have third party cookies disabled in Firefox, Facebook Like buttons do not work. This is a Facebook problem, and there's nothing we can do about it.
* If the window is too large, infinitescroll will not fire. This has been partly addressed by forcing it to fire once on page load, but very likely it should be set to fire everytime there is no scroll bar.