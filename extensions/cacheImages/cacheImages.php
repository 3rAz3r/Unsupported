<?php
/**
 * This template is used to generate cache images. Running it will process the entire gallery,
 * supplying an album name (ex: loadAlbums.php?album=newalbum) will only process the album named.
 * Passing clear=on will purge the designated cache before generating cache images
 * @package core
 */
// force UTF-8 Ø
define('OFFSET_PATH', 3);
require_once("../../zp-core/admin-globals.php");
require_once("../../zp-core/template-functions.php");


if (isset($_REQUEST['album'])) {
	$localrights = ALBUM_RIGHTS;
} else {
	$localrights = NULL;
}
admin_securityChecks($localrights, $return = currentRelativeURL(__FILE__));

XSRFdefender('cache_images');
$_zp_gallery = new Gallery();

function loadAlbum($album) {
	global $_zp_current_album, $_zp_current_image, $_zp_gallery;
	$subalbums = $album->getAlbums();
	$started = false;
	$tcount = $count = 0;
	foreach ($subalbums as $folder) {
		$subalbum = new Album($_zp_gallery, $folder);
		if (!$subalbum->isDynamic()) {
			$tcount = $tcount + loadAlbum($subalbum);
		}
	}
	$theme = $_zp_gallery->getCurrentTheme();
	$id = 0;
	$parent = getUrAlbum($album);
	$albumtheme = $parent->getAlbumTheme();
	if (!empty($albumtheme)) {
		$theme = $albumtheme;
		$id = $parent->id;
	}
	loadLocalOptions($id,$theme);
	$_zp_current_album = $album;
	if ($album->getNumImages() > 0) {
		echo "<br />" . $album->name . ' ';
		while (next_image(true)) {
			$thumb = getImageThumb();
			if (strpos($thumb, 'i.php?') === false) {
				$thumb = NULL;
			}
			if (isImagePhoto($_zp_current_image)) {
				$image = getDefaultSizedImage();
				if (strpos($image, 'i.php?') === false) {
					$image = NULL;
				}
			} else {
				$image = NULL;
				if ($_zp_current_image->objectsThumb == NULL) {
					$thumb = NULL;
				}
			}
			if (!empty($thumb) || !empty($image)) {
				if (!$count) {
					$started = true;
					echo "{ ";
				} else {
					echo ' | ';
				}
			}
			if (!empty($thumb)) echo '<img src="' . $thumb . '" height="8" width="8" /> ';
			if (!empty($image)) echo ' <img src="' . $image . '" height="20" width="20" />';
			if (!empty($thumb) || !empty($image)) echo "\n";
			$count++;
		}
		if ($started) echo ' } ';
		printf(ngettext('[%u image]','[%u images]',$count),$count);
		echo "<br />\n";
	}
	return $count + $tcount;
}
if (isset($_GET['album'])) {
	$alb = sanitize($_GET['album']);
} else if (isset($_POST['album'])) {
	$alb = sanitize(urldecode($_POST['album']));
} else {
	$alb = '';
}
if ($alb) {
	$folder = sanitize_path($alb);
	$object = $folder;
	$tab = 'edit';
	$album = new Album(NULL, $folder);
	if (!$album->isMyItem(ALBUM_RIGHTS)) {
		if (!zp_apply_filter('admin_managed_albums_access',false, $return)) {
			header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin.php');
			exit();
		}
	}
} else {
	$object = '<em>'.gettext('Gallery').'</em>';
	$tab = gettext('utilities');
}


printAdminHeader($tab,gettext('pre-cache'));
echo "\n</head>";
echo "\n<body>";

printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs();
echo "\n" . '<div id="content">';
zp_apply_filter('admin_note','cache', '');
$clear = sprintf(gettext('Refreshing cache for %s'), $object);
$count = 0;


if ($alb) {
	$r = '/admin-edit.php?page=edit&album='.$alb;
	echo "\n<h2>".$clear."</h2>";
	$album = new Album(NULL, $folder);
	$count =loadAlbum($album);
} else {
	$r = '/admin.php';
	echo "\n<h2>".$clear."</h2>";
	$albums = $_zp_gallery->getAlbums();
	shuffle($albums);
	foreach ($albums as $folder) {
		$album = new Album($_zp_gallery, $folder);
		if (!$album->isDynamic()) {
			$count = $count + loadAlbum($album);
		}
	}
}
echo "\n" . "<br />".sprintf(gettext("Finished: Total of %u images."), $count);

?>
<p class="buttons">
	<a title="<?php echo gettext('Back to the album list'); ?>" href="<?php echo WEBPATH.'/'.ZENFOLDER.$r; ?>">
	<img	src="<?php echo FULLWEBPATH.'/'.ZENFOLDER; ?>/images/arrow_left_blue_round.png" alt="" />
	<strong><?php echo gettext("Back"); ?></strong>
	</a>
</p>
<?php
echo "\n" . '</div>';
echo "\n" . '</div>';

printAdminFooter();

echo "\n</body>";
echo "\n</head>";
?>
