<script>

function getDropDown(itemID)
{ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var url="../admin/apps/image/getListing.php"
	url=url+"?listId="+itemID 
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChangedForListing
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
function stateChangedForListing() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtListing").innerHTML=xmlHttp.responseText 
	} 
}
function stateChangedForAssociation() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtAssoc").innerHTML=xmlHttp.responseText 
	} 
}

function removeLandmark($id)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var mySplitResult = $id.split("-");
	var url="../admin/apps/image/removeAssociation.php"
	url=url+"?pid="+mySplitResult[0]
	url = url+"&imgid="+mySplitResult[1]
	url=url+"&name=Land"
	url=url+"&sid="+Math.random()
	if(confirmSubmit()){
	xmlHttp.onreadystatechange=stateChangedForAssociation
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
	}
}
function removeAward($id)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var mySplitResult = $id.split("-");
	var url="../admin/apps/image/removeAssociation.php"
	url=url+"?pid="+mySplitResult[0]
	url = url+"&imgid="+mySplitResult[1]
	url=url+"&name=Award"
	url=url+"&sid="+Math.random()
	if(confirmSubmit()){
	xmlHttp.onreadystatechange=stateChangedForAssociation
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
	}


}

function removePlaque($id)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var mySplitResult = $id.split("-");
	var url="../admin/apps/image/removeAssociation.php"
	url=url+"?pid="+mySplitResult[0]
	url = url+"&imgid="+mySplitResult[1]
	url=url+"&name=Plaque"
	url=url+"&sid="+Math.random()
	if(confirmSubmit()){
	xmlHttp.onreadystatechange=stateChangedForAssociation
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
	}


}

</script>
<p>Here you can upload an image into the image directory for a plaque, landmark, or an award.</p>
<?php
$m_image= new controllerClass();
$image_vars = $m_image->getimage();

/*------------------------------ THIS IS YOUR SAVE BUTTON PORTION LIKE VB  BTN_SAVE(E ARGS BLAH BLAH)   ----------------------------*/
	if(isset($_POST['submit_app']))
		{	
			$post_vars=$_POST;
			print_r($_POST);
			if($_FILES['image_name']['name']!=""){
				$post_vars['image_name']=$_FILES['image_name']['name'];
			}
			$placeholder = "../images/gallery/";
			$post_vars['image_directory']=$placeholder;
			//echo $placeholder.$thefile['name'];
			//$name = rand(1, 9999).$thefile['name'];
			if($post_vars['pkimage_id'] == "new")
			{
				if($_FILES['image_name']['name']!="")
				{
					saveImage();
					$result=$m_image->createImage($post_vars);
				}
				
			
			}else{
				if($_FILES['image_name']['name']!="")
				{
					saveImage();
				}
				$result=$m_image->updateImage($post_vars);
			}
			if($result)
			{ ?>
<p>Your Image has been added. Please view the listing <a href="index.php?page=image_listing"> here. </a>
<?php		}

		
/*------------------------------ THIS IS YOUR PAGE LOAD LIKE VB  PAGE_LOAD(E ARGS BLAH BLAH)   ----------------------------*/
				
		}else{
			if(isset($_GET['id']))
			{
				$result=$m_image->getImageById($_GET['id']);
				$row = mysql_fetch_array($result);
				displayimage($row);

			}else{
			displayimage($image_vars);
			}
		}
/*-------------------------------------- 		DISPLAY image FUNCTION	PLAIN FUNCTION LIKE YOU WOULD CREATE IN VB	--------------------------------*/
function displayimage($vars)
//$this->m_images=array( 'pkimage_id'=>"",'image_name'=>"",'image_source'=>"",'image_permission'=>"",'image_location'=>"",  'image_directory'=>""
{
	?>
<form name="images" method="post" enctype="multipart/form-data"  action="" >
<fieldset>
<legend>Images</legend>
<table>
			<tr>
				<td>Title:<br /><input type="text" name="image_title" value="<?php echo $vars['image_title'];?>" /></td>
				<td>Photographer: <br /><input type="" name="image_source" value="<?php echo $vars['image_source'];?>" /></td>
				<td>Copyright: <br /><input type="text" name="image_permission" value="<?php echo $vars['image_permission'];?>" /></td>
	<!-- note Fred, the locaation and file directory are things we handle in the back ground via coding -->

			</tr>
			<tr>
				<td>Catalogue Number:<br /><input type="text" name="cat_num" value="<?php echo $vars['cat_num'];?>" /></td>
			</tr>
			<tr>
				<td colspan="3">Caption:<br /><input type="text" name="image_location" value="<?php echo $vars['image_location'];?>" size="45"  /></td>
			</tr>
			<?php if ($vars['pkimage_id']!=''){?>
			<tr>
				<td colspan="3"><a href="<?php echo $vars['image_directory'].$vars['image_name']?>" rel="lightbox" title="<?php echo stripslashes($row['image_title']); ?>">
					<img src="<?php echo $vars['image_directory']."/small/".$vars['image_name']?>" alt="<?php echo $vars['image_title'];?>" /></a></td>
				</tr>
<?php			}
				
				?>
				<tr>
				<th colspan="3">Image Relates to:</th></tr>
				<tr>
					<td colspan="3"><?php if ($vars['pkimage_id'] !='') getRelationships($vars['pkimage_id'],$vars['primary']); ?></td>
				</tr>
				<tr><th colspan="3">Add Image To:</th></tr>
                <tr>
                	<td>Plaque <input type="radio" name="AddTo" value="Plaque" onClick="getDropDown(this.value);" /></td>
                    <td>Award <input type="radio" name="AddTo" value="Award" onClick="getDropDown(this.value);" /></td>
                    <td>Landmark <input type="radio" name="AddTo" value="Landmark" onClick="getDropDown(this.value);" /></td>
                </tr>
			<tr>
            <td colspan="3"><div id='txtListing'></div></td>
            </tr>
			<tr>
				<td colspan="3">Upload  Detail Image:<br /><input type="hidden" name="MAX_FILE_SIZE" value="100000000" /> 
					<input name="image_name" type="file" id="image_name" /> </td>
			</tr>
            
</table>
</fieldset>
							<input type="hidden" name="pkimage_id" value="<?php if ($vars['pkimage_id']=='') echo 'new'; else echo $vars['pkimage_id']; ?>" /><input type="hidden" name="image_old" value="<?php echo $vars['image_name']; ?>"  />
							<input class="btton" type="submit" value="Submit" name="submit_app" />
</form>
<?php
}
/*----------------------------------	Relationships --------------------------------------*/
function getRelationships($img_id,$prim)
{?>
	<table>
	<tr>
<?php
	$m_image = new controllerClass();
	$i=0;
	$result = $m_image->getRelationshipPlaque($img_id);
	//this returns one row always must set up a call to assoc table then call plaque info on front end.
	$rowcount=mysql_num_rows($result);
	if($rowcount !="")
	{	?>
<?php
		while($row2 = mysql_fetch_array($result))
		{	
		
			$result2=$m_image->getPlaqueByID($row2['fkplaque_id']);
			$rowcount=mysql_num_rows($result2);
			if($rowcount >0)
			{?>
				<tr><td colspan="3">Plaques:</td></tr>
<?php			
				while($row = mysql_fetch_array($result2))
				{
	
					if($i%3==0 && $i!=0)
					{
						echo "				</tr>\n";
						echo "				<tr valign=\"top\">\n";
					}
				?>
					<td><?php echo $row['plq_recipient']; ?>: <br />Remove<input type="checkbox" onclick="removePlaque(this.value)" value="<?php echo $row['pkplaque_id']."-".$img_id;?>" /><br /><!--Primary:
				<input  type="checkbox" name="primary"  value="Y" <?php // if ($prim =='Y') echo "checked"; ?>/>--></td>
		<?php  
				$i++;
				}
			}
		}
	?>
	</tr>
<?php
	}
	
	$result = $m_image->getRelationshipAward($img_id);
		//this returns one row always must set up a call to assoc table then call plaque info on front end.

	$rowcount=mysql_num_rows($result);
	if($rowcount >0)
	{
	?>
<?php
		while($row2=mysql_fetch_array($result))
		{
			$result2=$m_image->getAwardByID($row2['fkaward_id']);
			$rowcount=mysql_num_rows($result2);
			if($rowcount >0)
			{?>
				<tr><td colspan="3">Awards:</td></tr>
<?php
				while($row = mysql_fetch_array($result2))
				{
	
				if($i%3==0 && $i!=0)
				{
					echo "				</tr>\n";
					echo "				<tr valign=\"top\">\n";
				}
			?>
				<td><?php echo $row['awd_recipient']; ?>: Remove <input type="checkbox"  onclick="removeAward(this.value)" value="<?php echo $row['pkaward_id']."-".$img_id;?>" /> </td>
	<?php  	}
			}

		}
	?>
	</tr>
<?php
	}//else{ echo "No Awards are associated with this image.";}
	$result = $m_image->getRelationshipLand($img_id);
	//this returns one row always must set up a call to assoc table then call plaque info on front end.
	$rowcount=mysql_num_rows($result);
	if($rowcount !="")
	{
	?>
<?php
		while($row2=mysql_fetch_array($result))
		{
			$result2=$m_image->getLandmarkByID($row2['fklandmark_id']);
			$rowcount=mysql_num_rows($result2);
			if($rowcount >0)
			{?>
				<tr><td colspan="3">Landmarks:</td></tr>
<?php
			
				while($row = mysql_fetch_array($result2))
				{
		
					if($i%3==0 && $i!=0)
					{
						echo "				</tr>\n";
						echo "				<tr valign=\"top\">\n";
					}
				?>
					<td><?php echo $row['land_name']; ?>: Remove <input type="checkbox" onclick="removeLandmark(this.value)" value="<?php echo $row['pklandmark_id']."-".$img_id;?>" /></td>
	<?php		}
			}
	  }
	?>
	</tr>
<?php
	
	}
?>
<tr>
	<td colspan="3"><div id='txtAssoc'></div></td>
</tr>
	</table>
<?php

}
?>
