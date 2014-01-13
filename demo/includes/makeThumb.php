<?php

function getThumb($imageFolder, $SN) {

	$img = $SN.".jpg";
	$thumbFolder = "thumbs/";
	$thumbnail_width = 100;
	$thumbnail_height = 100;
	$file_label = "thumb";
	$defaultImage = "default.jpg";
	

	if (!file_exists($imageFolder . $img)) { // if there is no source picture, then abort and return the default image
		//echo "no image found, using ".$defaultImage;
		//return $defaultImage;
		$img = $defaultImage;
	}
	
	$img_destination = "$imageFolder" . "$thumbFolder" . $file_label . '_' . "$img";
	
	// If there is a source image, we proceed with resizing:
	$arr_image_details = getimagesize($imageFolder . $img );
	$original_width = $arr_image_details[0];
	$original_height = $arr_image_details[1];
	
	if ($original_width > $original_height) {
		$new_width = $thumbnail_width;
		$new_height = intval($original_height * $new_width / $original_width);
	} else {
		$new_height = $thumbnail_height;
		$new_width = intval($original_width * $new_height / $original_height);
	}
	
	// centering
	$dest_x = intval(($thumbnail_width - $new_width) / 2);
	$dest_y = intval(($thumbnail_height - $new_height) / 2);
	
	// determining image type
	if ($arr_image_details[2] == 1) {
		$imgt = "ImageGIF";
		$imgcreatefrom = "ImageCreateFromGIF";
        }
        if ($arr_image_details[2] == 2) {
        	$imgt = "ImageJPEG";
        	$imgcreatefrom = "ImageCreateFromJPEG";
        }
        if ($arr_image_details[2] == 3) {
        	$imgt = "ImagePNG";
        	$imgcreatefrom = "ImageCreateFromPNG";
        }
        
        if ($imgt) { // finally, if we have all required info, we generate a new thumbnail image
        	$old_image = $imgcreatefrom("$imageFolder" . "$img");
        	$new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        	imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        	$imgt($new_image, $img_destination);
        	return $img_destination;
        } else {
        	return $defaultImage;
        }
}

?>
