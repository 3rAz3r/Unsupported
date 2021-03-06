<?php /*
	setOption('thumb_size', 776, false);
	setOption('thumb_crop_width', 776, false);
	setOption('thumb_crop_height', 456, false);*/
	//setOption('image_use_side', 'width', false);
?>
<!DOCTYPE html>
<html>
    <head>
		<?php zp_apply_filter('theme_head'); ?>
        <title><?php echo getBareGalleryTitle(); ?> | <?php echo getBareAlbumTitle();?> | <?php echo getBareImageTitle();?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/css/text.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/css/1200_15_col.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/css/theme.css" type="text/css" media="screen" />
    </head>
    <body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div class="container_15">
			<div id="header" class="grid_15">
				<?php if (function_exists('printLanguageSelector')) { echo '<div class="languages grid_5">'; printLanguageSelector(true); echo '</div>'; } ?>
				<?php printLoginZone();	?>
				<h1><?php echo getBareGalleryTitle(); ?></h1>
			</div>
			<div class="clear"></div>
			<div id="menu">
				<div id="m_bread" class="grid_8">
						<a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo getGalleryTitle(); ?>"><?php echo getGalleryTitle(); ?></a>
						<?php printParentBreadcrumb('', '', ''); ?>
						<a href="<?php echo html_encode(getAlbumLinkURL()); ?>"><?php echo getAlbumTitle(); ?></a>
						<span class="current"><?php echo getImageTitle(); ?></span>
				</div>
				<?php printMenu(); ?>
			</div>
			<div class="clear"></div>
			<div id="content">
				<div class="desc grid_5">
					<h2 class="suffix_1"><?php echo getImageTitle(); ?></h2>
					<div class="date"><?php echo getImageDate('%d/%d/%Y'); ?></div>
					<?php if (function_exists('printRating')) { echo '<div id="star_rating_images">'; printRating(); echo '</div>'; } ?>
					<div class="comment"><?php echo getImageDesc(); ?></div>
					<div class="data">
						<?php if(getImageCustomData()){ ?><div><label><?php echo gettext('Custom data:'); ?> </label><?php echo getImageCustomData();?></div><?php } ?>
						<?php if(getImageLocation()){ ?><div><label><?php echo gettext('Location:'); ?> </label><?php echo getImageLocation();?></div><?php } ?>
						<?php if(getImageCity()){ ?><div><label><?php echo gettext('City:'); ?> </label><?php echo getImageCity();?></div><?php } ?>
						<?php if(getImageState()){ ?><div><label><?php echo gettext('State:'); ?> </label><?php echo getImageState();?></div><?php } ?>
						<?php if(getImageCountry()){ ?><div><label><?php echo gettext('Country:'); ?> </label><?php echo getImageCountry();?></div><?php } ?>
						<?php if(getImageData('credit')){ ?><div><label><?php echo gettext('Credit:'); ?> </label><?php echo getImageData('credit');?></div><?php } ?>
						<?php if(getImageData('copyright')){ ?><div><label><?php echo gettext('Copyright:'); ?> </label><?php echo getImageData('copyright');?></div><?php } ?>
						<?php printImageMetaData(); ?>
					</div>
				</div>
				<div class="image suffix_5">
					<?php $linkImage = getFullImageURL(); ?>
					<?php 
						if(!empty($linkImage)) {
							echo '<a href="'.getFullImageURL().'" alt="'.getImageTitle().'">';
						}
						
						$iL = isLandscape();
						if($iL) {
							setOption('image_size', 776, false);
						} else {
							setOption('image_size', 456, false);
						}
						setOption('image_use_side', 'longest', false);
						printDefaultSizedImage(getImageTitle());
						
						if(!empty($linkImage)) {
							echo '</a>';
						}
					?>
				</div>
				<div class="clear"></div>
				<?php printPageListWithNav("&laquo; ".gettext("prev"), gettext("next")." &raquo;", false, true, 'pagelist', null, true, 5); ?>
				<div class="clear"></div>
			</div>
			<div id="footer" class="grid_15">
				<?php printFooter(); ?>
			</div>
		</div>
		<?php zp_apply_filter('theme_body_close'); ?>
    </body>
</html>
