<?php if (!defined('WEBPATH')) die(); 
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
<head>
	<title><?php if(!isset($ishomepage)) { echo getBarePageTitle() . " | "; } ?> <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php printZenpageRSSHeaderLink("News","", "Zenpage news", ""); ?>
	<?php zp_apply_filter('theme_head'); ?>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

	<div id="header">
			<h1><?php printGalleryTitle(); ?></h1>
			<?php if (getOption('Allow_search')) {  printSearchForm("","search","",gettext("Search gallery")); } ?>
		</div>
				
<div id="content">

	<div id="breadcrumb">
	<h2><a href="<?php echo getGalleryIndexURL(false); ?>"><?php echo gettext("Home"); ?></a><?php if(!isset($ishomepage)) { printZenpageItemsBreadcrumb(" &raquo; ",""); } ?><strong><?php if(!isset($ishomepage)) { printPageTitle(" &raquo; "); } ?></strong>
	</h2>
	</div>
    
	<div id="sidebar">
		<?php include("sidebar-left.php"); ?>
	</div><!-- sidebar-left -->
    
<div id="content-right">
<div align="center"> <?php if (function_exists('zenFBLike')) { zenFBLike(); } ?></div>
<h2><?php // printPageTitle(); ?></h2>
<?php 
printPageContent(); 
printCodeblock(1); 
printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); 
?>
<br style="clear:both;" /><br />
<?php
if (function_exists('printRating')) { printRating(); }
?>

<?php if (function_exists('zenFBComments')) { zenFBComments(); } ?>

	</div><!-- content right-->
		
	<div id="fb-bar">
		<?php include("rightbar.php"); ?>
	</div><!-- fb-bar -->


	<div id="footer">
	<?php include("footer.php"); ?>
	</div>

</div><!-- content -->

</div><!-- main -->
<?php
printAdminToolbox();
zp_apply_filter('theme_body_close');
?>
</body>
</html>