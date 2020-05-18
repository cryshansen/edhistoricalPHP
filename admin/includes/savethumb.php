<?php
	function createThumbnail( $fileSrc, $thumbDest, $thumb_width = 180, $thumb_height = 180 )
	{
		$ext = strtolower( substr($fileSrc, strrpos($fileSrc, ".")) );
	
		if( $ext == ".png" )
		{
			$base_img = ImageCreateFromPNG($fileSrc);
		}
		else if( ($ext == ".jpeg") || ($ext == ".jpg") )
		{
			$base_img = ImageCreateFromJPEG($fileSrc);
		}
		// If the image is broken, skip it?
		if ( !$base_img)
			return false;
	
	
		// Get image sizes from the image object we just created
		$img_width = imagesx($base_img);
		$img_height = imagesy($base_img);
	
	
		// Work out which way it needs to be resized
		$img_width_per  = $thumb_width / $img_width;
		$img_height_per = $thumb_height / $img_height;
	
		if ($img_width_per <= $img_height_per)
		{
			$thumb_width = $thumb_width;
			$thumb_height = intval($img_height * $img_width_per);
		}
		else
		{
			$thumb_width = intval($img_width * $img_height_per);
			$thumb_height = $thumb_height;
		}
	
		$thumb_img = ImageCreateTrueColor($thumb_width, $thumb_height);
	
		ImageCopyResampled($thumb_img, $base_img, 0, 0, 0, 0, $thumb_width, $thumb_height, $img_width, $img_height);
	
	
		if( $ext == ".png" )
		{
			ImagePNG($thumb_img, $thumbDest);
		}
		else if( ($ext == ".jpeg") || ($ext == ".jpg") )
		{
			ImageJPEG($thumb_img, $thumbDest);
		}
	
		// Clean up our images
		ImageDestroy($base_img);
		ImageDestroy($thumb_img);
	
		return true;
	}	
		//_________________________________________________________________________________
 function saveImage()
	{
		
		echo "came in here";
		//global $full_path; 
		$placeholder = "../images/gallery/"; //$full_path.'/images/large/';
		$thumb_placeholder = '../images/gallery/small/';
		//$id = $_POST['id'];
		//print_r($_POST);
		// handle upload first
	   $thefile = $_FILES['image_name'];   
	   if (is_uploaded_file($_FILES['image_name']['tmp_name']))
	   {	
		   if ($thefile['error'] == UPLOAD_ERR_OK)
		   {
				//echo $placeholder.$thefile['name'];
				//$name = rand(1, 9999).$thefile['name'];
				//$_POST['image_large'] = $name;
				//$_POST['image_thumb'] = $name;
				//move_uploaded_file($thefile['tmp_name'], $placeholder.$name);
				//$this->createThumbnail ($placeholder.$name,$thumb_placeholder.$name);
					move_uploaded_file($thefile['tmp_name'], $placeholder.$thefile['name']);
					createThumbnail ($placeholder.$thefile['name'],$placeholder.$thefile['name'], 600, 600);
					createThumbnail ($placeholder.$thefile['name'],$thumb_placeholder.$thefile['name'],  120, 120);
		   }
	   } else{ unset($_POST['image_name']);	}
	  
	 }

	
	
?>