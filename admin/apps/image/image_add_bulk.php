<?php
	$m_imageBulk = new controllerClass();
	$imageBulk_var=$m_imageBulk->getImage();

?>				


<p>Here you can add Images in bulk. Please prepare your images by creating detail Images. All images should be in jpg or png web format and named {filename}.jpg or {filename}.png for detail images. </p>


<?php
	
  	$imageBulk_var['image_title']= 'Title';
  	$imageBulk_var['image_source']='Photographer';
  	$imageBulk_var['image_permission']='Copyright &copy; Edmonton Historical Board';
  	$imageBulk_var['image_location']="Caption";
  	$imageBulk_var['image_directory']="../images/gallery/";
	$imageBulk_var['image_name']="";// Actual image name

$upload_folder = "upload_images/";	

//handles the save button click
if(isset($_REQUEST['bt_save']))
{
	$counter = 0;
	// Open a known directory, and proceed to read its contents
	if (is_dir($upload_folder)) 
	{
		if ($dir = opendir($upload_folder)) 
		{
			//read all files in directory where files were uploaded
			while (($file = readdir($dir)) !== false)
			{	
				 if(!is_dir($file))
   				 {
					$destination_path = $upload_folder . $file;
					if (file_exists( $destination_path))
					{
						$imageBulk_var['image_name'] = $file;
						//check for duplicate accession numbers
						$result = $m_imageBulk->image_name_check($imageBulk_var['image_name']);  
						//if image already in the image table display error message
						if ($result)//mysql_num_rows($result) > 0
						{
							echo "							Image_name <b>".$imageBulk_var['image_name']."</b> already taken. Record has not been inserted.\n";
						}
						//insert file into database
						else
						{			
							$extension= strrpos($imageBulk_var['image_name'], ".");
							$len=strlen($imageBulk_var['image_name']);
							$trimit=$extension-$len;
							$imageBulk_var['image_title'] = substr($imageBulk_var['image_name'], 0, $trimit);
							$result=$m_imageBulk->createImage($imageBulk_var);							
						if ($result == 1)
							{
								//setting the folder paths for the detailed image
								$upload = $upload_folder . $imageBulk_var['image_name'];
								$destination = $imageBulk_var['image_directory'] . $imageBulk_var['image_name'];
								//moved the image from the upload_image directory to the image directory																					

								if (copy($upload, $destination))
								{		
									$thumb_placeholder = '../images/gallery/small/';
									createThumbnail ($desitnation,$destination, 600, 600);
									createThumbnail ($destination,$thumb_placeholder.$imageBulk_var['image_name'],  120, 120);

									//if successful delete the image from the upload_image directory
									if (unlink($upload))
									{
										echo "									".$imageBulk_var['image_name'] . " has been moved.<br />"; 
									}
									else
									{
										echo "								image wasn't deleted.\n";
									}
								}
								$counter++;
							}
						}	
					}
				}
			}  
	  		closedir($dir);
		}
		echo "								<br /><br />".$counter." files had been added to your database\n";
		echo "								<br /><br />To see a listing of all added images <a href='index.php?page=image_listing&name=Title'>click Here</a>\n";
	}
	else
	{
		echo "								The image upload folder ".$imageBulk_var['image_directory']." was not found.\n";
	}
}
else
{
?>

	<h4>Instructions for adding multiple images into the database:</h4>
	<p>1. FTP all images to the uploading directory (admin/upload_images folder). 
	<p>2. Press FILL DATABASE &nbsp;&nbsp;&nbsp;
		<form method='post' action='index.php?page=image_add_bulk' enctype='multipart/form-data'>
			<input type="submit" value="FILL DATABASE" name="bt_save" />
		</form></p>
	<p>3. Click Image Listing under images on the menu to see all files inserted into the database.</p>

<?php
}
?>