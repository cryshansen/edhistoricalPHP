<script>
/*ABQIAAAAr-VkLAVeby8KYZyn0ivvehRXgQnCq54mXVNfkMmE8zIvrQOivBSwnKQRFuTwm1rpAj9fbCf5jtenOQ*/
/**************************************TESTING Owner Retrieval***********************************/
function showOwner(ownerid)
{ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var url="../admin/apps/landmark/getowner.php"
	url=url+"?fkowner_id="+ownerid 
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChangedForOwner
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
function stateChangedForOwner() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtOwner").innerHTML=xmlHttp.responseText 
	} 
}
//STATE CHANGE FOR  ASSOCIATIONS TO PLAQUES / LANDMARKS / AWARDS
function stateChangedForAssociation() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtAssoc").innerHTML=xmlHttp.responseText 
	} 
}
//FUNCTION TO REMOVE IMAGE ASSOCIATION WITH LANDMARK

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
	
	xmlHttp.onreadystatechange=stateChangedForAssociation
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}


/************************************************ Creates the HTTP OBJECT FOR AJAX HANDLING  **************************/

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		//Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

</script>
<?php

	$m_landmark = new controllerClass();
	$landmark_vars=$m_landmark->getLandmark();
		if(isset($_POST['submit_app']))
		{
			$post_vars=$_POST;
			//print_r($post_vars);
			$post_vars['image_name']=$_FILES['image_name']['name'];
			$post_vars['image_directory']="../images/gallery/";

			if($post_vars['pklandmark_id'] =='new'){
				//upload image
				if($post_vars['image_name'] !=""){
					saveImage();
				}
				$result2=$m_landmark->checkLandname($post_vars['land_name']);
				$row=mysql_fetch_array($result2);
				if($row !=0){
					?>
						<p>Your Landmark Already Exists. Please <a href="index.php?page=landmark&id=<?php echo $row['pklandmark_id']; ?>">edit the landmark.</a> </p>
<?php				
				 }else{
						$result2=$m_landmark->createLandmark($post_vars);	
					}
			}else{
				if($post_vars['image_name'] !=""){
					saveImage();
				}
				$result=$m_landmark->updateLandmark($post_vars);	
			}
			if($result){
			?>
				<p>Your Landmark has been<?php if($post_vars['pklandmark_id'] =='new') echo " Added"; else echo " Updated";?>. If you would like to see a listing click <a href="index.php?page=landmark_listing">here</a>.</p>
<?php
			}
		
		}else{
			if(isset($_GET['id']))
			{
				$results = $m_landmark->getLandmarkById($_GET['id']);
				while($row=mysql_fetch_array($results))
				{
					
					displayLandmark($row);
				}
				
			}else{
			
				displayLandmark($landmark_vars);
			}
		}

/* ------------------------------------------- Display Landmark ------------------------------------------*/
function displayLandmark($vars)
{


?>
		<form name="landmark" method="post" enctype="multipart/form-data" action="" ><!--index.php?action=applicant-->
			<fieldset>
					<legend>Landmark</legend>
							<table>
									<tr>
										<td>Site Name:<br />
										<input type="text" name="land_name" value="<?php echo $vars['land_name']; ?>" /></td>
										<td>Address:<br />
										<input type="text" name="street_address" value="<?php echo $vars['street_address']; ?>" /></td></tr>
										<tr>
										<td colspan="2">Longitude: <br />
                                    <input type="text"  name="dLg" value="<?php if ($vars['longitude'] =="") echo -113; else echo -floor(-$vars['longitude']);?>" size="2" maxlength="3">deg 
                                        <input type="text"  name="mLg" value="<?php if ($vars['longitude'] =="") echo 0; else echo floor((-$vars['longitude']-113)*60);?>" size="2" maxlength="3">min 
                                        <input type="text"  name="sLg" value="<?php echo floor(((-$vars['longitude'] - floor(-$vars['longitude']))*60 - floor((-$vars['longitude'] - floor(-$vars['longitude']))*60))*60);?>" size="2" maxlength="3" >sec 
                                        
                                       </td>
									</tr>
                                    <tr>
										<td colspan="3">Latitude: <br />&nbsp;
                                        <input type="text"   name="dLt" value="<?php if ($vars['latitude'] =="") echo 53; else echo floor($vars['latitude']);?>" size="2" maxlength="3" >deg &nbsp;
                                        <input type="text"   name="mLt" value="<?php echo floor(($vars['latitude'] - floor($vars['latitude']))*60);?>" size="2" maxlength="3" >min &nbsp;
                                        <input type="text"   name="sLt" value="<?php echo floor((($vars['latitude'] - floor($vars['latitude']))*60 - floor(($vars['latitude'] - floor($vars['latitude']))*60))*60);?>" size="2">sec &nbsp;</td></tr>


									<tr>
										<td colspan="3">Descriptive Location:<br /><input type="text" name="location" size="70" value="<?php echo $vars['location']; ?>" /></td>
										
									 </tr>
                                     <tr valign="top"><td colspan="2">Neighbourhood: <br />
											<select name="fkneighbor_id">
												<option>Choose a Neighbourhood...</option>
											<?php
												displayNeighbourhood($vars['fkneighbor_id']);
											?>
											</select><br /></td>
                                     </tr>
									<tr valign="top">
										<td colspan="2">Landmark Description:<br />
										<textarea name="land_description" cols="40" rows="6"><?php echo $vars['land_description']; ?></textarea></td>
										<td valign="top">
										Classification:<br /><input type="text" name="classification" value="<?php echo $vars['classification']; ?>" />							
											<br />Designation:<br />
										<input type="text" name="designation" value="<?php echo $vars['designation']; ?> "  />
										<br />Year Built:<br />
										<input type="text" name="landmark_age" value="<?php echo $vars['landmark_age'];?>"  />

										</td>
									</tr>
									<tr>
										<td colspan="2">Landmark Comments:<br />
										<textarea name="land_comments" cols="40" rows="6"><?php echo $vars['land_comments']; ?></textarea></td>
										<td valign="top">Architect:<br />
										<input type="text" name="architect" value="<?php echo $vars['architect'];?>"  />
</td>
									
									</tr>
								<tr>
									<th colspan="3" align="left">Upload an Image: </th>
									</tr>
									<tr>
										<td>Title:<br /><input type="text" name="image_title" value="" /></td>
										<td>Photographer: <br /><input type="" name="image_source" value="" /></td>
										<td>Copyright: <br /><input type="text" name="image_permission" value="" /></td>
							<!-- note Fred, the locaation and file directory are things we handle in the back ground via coding -->
						
									</tr>
									<tr>
										<td colspan="3">Caption:<br /><input type="text" name="image_location" value="" size="45"  /></td>
									</tr>

									<tr>
										<td colspan="3">Upload  Detail Image:<br /><input type="hidden" name="MAX_FILE_SIZE" value="100000000" /> 
											<input name="image_name" type="file" id="image_name" /> </td>
								</tr>
								<?php	if($vars['pklandmark_id'] !=""){ getImagesByLandId($vars['pklandmark_id']); } ?>
								<tr>
	            					<td colspan="3"><div id='txtAssoc'></div></td>
								</tr>
								
								</table>
								<table>
									<tr><th colspan="3">Owners</th></tr>
									<tr>
										<td>Owner Lookup: <br />
											<?php displayOwners($vars['fkowner_id']); ?></td>
									</tr>
									<tr>
										<td colspan="3">
											<div id='txtOwner'></div>
										</td>
									</tr>
									<tr>
										<td colspan="3">Existing Owner:
											<?php if( $vars['fkowner_id'] !="")  displayOwnerContent($vars['fkowner_id']); else echo "None";  ?>
										</td>
									</tr>
								
								</table>
								</fieldset>
							<input type="hidden" name="pklandmark_id" value="<?php if ($vars['pklandmark_id']=='') echo 'new'; else echo $vars['pklandmark_id']; ?>" />	
							<input class="btton" type="submit" value="Submit" name="submit_app" />
							</form>
<?php
}
/* ------------------------------------------- Display Neighbourhood ------------------------------------------*/

	function displayNeighbourhood($fkneighbor_id)
	{
			$m_landmark = new controllerClass();
			$results=$m_landmark->getAllNeighbourhoods();

	?>
											
				<?php
				while($row=mysql_fetch_array($results))
				{
				?>
		
					<option value="<?php echo $row['id']; ?>"<?php if($row['id'] == $fkneighbor_id) echo "selected"; ?>><?php echo $row['name']; ?></option>
				<?php 
				}
				?>
	

	
<?php
	}
/* ------------------------------------------- Display Owner ------------------------------------------*/
	
	function displayOwners($fkowner_id)
	{
			$m_owner = new controllerClass();
			$results=$m_owner->getAllOwner();

	?>
				<select name="fkowner_id" onchange='showOwner(this.value)'>
				<?php
				while($row=mysql_fetch_array($results))
				{
				?>
		
						<option value="<?php echo $row['pkowner_id']; ?>"<?php if($row['pkowner_id'] == $fkowner_id) echo "selected"; ?>><?php echo $row['owner_name']; ?></option>
				<?php 
				}
				?>
											</select>
<?php
	
	}

/* ------------------------------------------- Display Owner Content ------------------------------------------*/
	
	function displayOwnerContent($fkowner_id)
	{
			$m_owner = new controllerClass();
			$owner = $m_owner->getOwnerById($fkowner_id);

	?>
				<table>
					<tr>
						<th>Owner Name</th>
						<th>Phone</th>
						<th>FOIP</th>
					</tr>
				<?php
				while($row=mysql_fetch_array($owner))
				{
				?>
					<tr>
						<td><?php echo $row['owner_name']; ?></td>
						<td><?php echo $row['owner_phone_bus']; ?> </td>
						<td><?php echo $row['foip'];?> </td>
					</tr>
		
				<?php 
				}
				?>
				</table>
<?php
	
	}

/* -----------------------------------------	Display Images	----------------------------------------------*/
function getImagesByLandId($pkland_id)
{

	$m_images = new controllerClass();
	$results=$m_images->getImagesByLandmarkId($pkland_id);
	if($results){?>
	<table class="img_checks">
			<tr valign="top">
<?php
		$rowcount=mysql_num_rows($results);
		while($row = mysql_fetch_array($results))
		{
			if($i%3==0 && $i!=0)
			{
				echo "				</tr>\n";
				echo "				<tr valign=\"top\">\n";
			}
		
		?>			

			<td width="33%" valign="top" align="left">
				<a href="<?php echo $row['image_directory'].$row['image_name']?>" rel="lightbox" title="<?php echo stripslashes($row['image_title']); ?>">
				<img src="<?php echo trim($row['image_directory'])."/small/".trim($row['image_name']); ?>" alt="<?php echo stripslashes($row['image_title']); ?>"></a><br clear="all" />
				<strong><?php echo stripslashes($row['image_title']); ?></strong><br />

			Remove:
			<input  type="checkbox" onclick="removeLandmark(this.value)" value="<?php echo $pkland_id."-".$row['pkimage_id'];?>" /></td>
			$i++;
<?php 	} ?>
	</tr>
	</table>
<?php
	}

}


?>
