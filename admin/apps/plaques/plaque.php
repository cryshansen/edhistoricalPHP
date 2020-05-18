 <script>
function showLandmark(ownerid)
{ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var url="../admin/apps/plaque/getlandmark.php"
	url=url+"?fklandmark_id="+ownerid 
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
//FUNCTION TO REMOVE IMAGE ASSOCIATION WITH PLAQUE

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
<?php

//need an image 
//need inscription get in call
$m_plaque = new controllerClass();
$plaque_vars=$m_plaque->getPlaque();
$plaque_vars = array_merge($plaque_vars,$m_plaque->getInscription()); 

 
		if(isset($_POST['submit_app']))
		{	
			$post_vars=$_POST;
			//print_r($post_vars);
			$post_vars['image_name']=$_FILES['image_name']['name'];
			$post_vars['image_directory']="../images/gallery/";

			if($post_vars['pkplaque_id'] == "new")
			{
				//echo "Adding new";
				//upload image
				if($post_vars['image_name'] !=""){
					saveImage();
				}
				//saveimage
				//need to deal with pkid for plaque and image
				$result=$m_plaque->createPlaque($post_vars);
				
			
			}else{
				if($post_vars['image_name'] !=""){
					saveImage();
				}
					$result=$m_plaque->updatePlaque($post_vars);
			}
			if($result)
			{ ?>
				<p>Your Plaque has been <?php if($post_vars['pkplaque_id'] == "new") echo "added"; else echo "updated"; ?>. Please view the Plaque listing <a href="index.php?page=plaque_listing"> here. </a>
<?php		}
		
		}else{
			
				if(isset($_GET['aid'])){
					$result=$m_plaque->getApplicationById($_GET['aid']);
					while ($row = mysql_fetch_array($result))
					{
						//call display function()
						//append aplication id and sitename to vars
						?>
						<p> Application Name: <?php  echo $row['site_name']; ?></p>
						<?php
						$row = array_merge($row,$plaque_vars);
						$row['fkapplication_id'] = $row['pkapplication_id'];
						$row['plq_recipient']=$row['site_name'];
						displayPlaque($row);
					}								

				
				}elseif(isset($_GET['id']))
						{
							//display individual
							$result=$m_plaque->getPlaqueById($_GET['id']);
							while ($row = mysql_fetch_array($result))
							{			
								//call display function()
								displayPlaque($row);
							
							}
						}else{
						
							//call dislay function() with empty parameters
							displayPlaque($plaque_vars);
						}
		}
 
 /* -----------------------------------------	Display Plaque		----------------------------------------------*/
 function displayPlaque($vars)
 {
 	
 ?>
					<form name="plaque" method="post" enctype="multipart/form-data" action="" ><!--index.php?action=applicant-->
						<fieldset>
						<legend>Plaque</legend>
							<table>
								<input type="hidden" name="pkplaque_id" value="<?php if ($vars['pkplaque_id']=='') echo 'new'; else echo $vars['pkplaque_id']; ?>" />			
								<input type="hidden" name="fkapplication_id" value="<?php echo $vars['fkapplication_id']; ?>" />																	
								<tr>	
									<td colspan="3">Plaque Recipient <br />
									<input type="text" name="plq_recipient" <?php if(array_key_exists('site_name',$vars)){ echo "readonly='readonly'";} ?> value="<?php echo $vars['plq_recipient']; ?>" /></td>
								</tr>
								<tr>
									<td>Size:<br />
										<input type="text" name="plq_size" value="<?php echo $vars['plq_size']; ?>" /></td>
										<td>Material:<br />
										<input type="text" name="plq_material" value="<?php echo $vars['plq_material']; ?>" />
										</td>
										 <td>Plaque Style:<br />
										<input type="text" name="plq_style" value="<?php echo $vars['plq_style']; ?>" />
										
									</td>
								</tr>
								<tr>
                                    <td colspan="2">Longitude:<br  />
									
                                    <input type="text"  name="dLg" value="<?php if ($vars['plq_longitude'] =="") echo -113; else echo -floor(-$vars['plq_longitude']);?>" size="2" maxlength="3">deg 
                                        <input type="text"  name="mLg" value="<?php if ($vars['plq_longitude'] =="") echo 0; else echo floor((-$vars['plq_longitude']-113)*60);?>" size="2" maxlength="3">min 
                                        <input type="text"  name="sLg" value="<?php echo floor(((-$vars['plq_longitude'] - floor(-$vars['plq_longitude']))*60 - floor((-$vars['plq_longitude'] - floor(-$vars['plq_longitude']))*60))*60);?>" size="2" maxlength="3" >sec 
										<td valign="top">Plaque Type:<br />
										<?php displayPlaqueType($vars['fkplaquetypeid']); ?></td>
                                    </tr>
									<tr>
									<td colspan="2">Latitude<br />
                                        <input type="text"   name="dLt" value="<?php if ($vars['plq_latitude'] =="") echo 53; else echo floor($vars['plq_latitude']);?>" size="2" maxlength="3" >deg &nbsp;
                                        <input type="text"   name="mLt" value="<?php echo floor(($vars['plq_latitude'] - floor($vars['plq_latitude']))*60);?>" size="2" maxlength="3" >min &nbsp;
                                        <input type="text"   name="sLt" value="<?php echo floor((($vars['plq_latitude'] - floor($vars['plq_latitude']))*60 - floor(($vars['plq_latitude'] - floor($vars['plq_latitude']))*60))*60);?>" size="2">sec &nbsp;</td></tr>
                                <tr>
                                	<td colspan="3">Location <br />
                                    <input type="text" name="plq_location" value="<?php echo $vars['plq_location']; ?>"  size="70"/></td>
								</tr>								
								<tr>
									<td colspan="2">Plaque Description:<br />
									<textarea name="plq_desc" cols="40" rows="6"><?php echo $vars['plq_desc']; ?></textarea></td>
									<td valign="top">Inauguration Date:<br />
									<div>
									<input onclick='ds_sh(this);' name='plq_inaug_date' readonly='readonly' style='cursor: text' value="<?php echo $vars['plq_inaug_date']; ?>"/></div>
									</td>
								</tr>
								<tr>
									<td colspan="2">Inscription:<br />
									<textarea name="plq_inscription" cols="40" rows="6"><?php echo $vars['plq_inscription'] ?></textarea></td>
									<td valign="top">Inscription Date:<br />
									<div><input onclick='ds_sh(this);' name="plqinsc_date" readonly='readonly' style='cursor: text' value="<?php echo $vars['plqinsc_date']; ?>"/></div>
							</td>
							</tr>
							<tr>
									<td colspan="2" valign="top">Inscription Comments:<br />
									<textarea name="plqinsc_comments" cols="40" rows="6"><?php if($vars['pkplaque_id'] !=""){ getInscriptionComments($vars['pkplaque_id']);} ?></textarea></td>
									<td valign="top">Inscription Required: <br />
										<input type="radio" name="plq_inscript_reqd" value="Y" 
                                        <?php if ($vars['plq_inscript_reqd']=='Y') echo 'checked'; ?>/>Yes
										<input type="radio" name="plq_inscript_reqd" value="N"
                                        <?php if ($vars['plq_inscript_reqd']=='N') echo 'checked'; if($vars['plq_inscript_reqd']=="") echo 'checked';?> />No<br />
										Installation Required: <br />
										<input type="radio" name="plq_instal_reqd" value="Y" 
                                        <?php if ($vars['plq_instal_reqd']=='Y') echo 'checked'; ?>/>Yes
										<input type="radio" name="plq_instal_reqd" value="N" 
                                        <?php if ($vars['plq_instal_reqd']=='N') echo 'checked'; if($vars['plq_instal_reqd']=="") echo 'checked'; ?>/>No<br />
										Inspection Required: <br />
										<input type="radio" name="plq_inspect_reqd" value="Y" 
                                        <?php if ($vars['plq_inspect_reqd']=='Y') echo 'checked';  ?>/>Yes
										<input type="radio" name="plq_inspect_reqd" value="N" 
                                        <?php if ($vars['plq_inspect_reqd']=='N') echo 'checked'; if($vars['plq_inspect_reqd']=="") echo 'checked'; ?>/>No<br />
										Restoration Required: <br />
										<input type="radio" name="plq_restore_reqd" value="Y" 
                                        <?php if ($vars['plq_restore_reqd']=='Y') echo 'checked'; ?>/>Yes
										<input type="radio" name="plq_restore_reqd" value="N" 
                                        <?php if ($vars['plq_restore_reqd']=='N') echo 'checked'; if($vars['plq_restore_reqd']=="") echo 'checked'; ?>/>No<br />
                                        Order Required:<br />
                                        <input type="radio" name="plq_order_reqd" value="Y" 
                                         <?php if ($vars['plq_order_reqd']=='Y') echo 'checked'; ?>/>Yes
                                        <input type="radio" name="plq_order_reqd" value="N"
                                        <?php if ($vars['plq_order_reqd']=='N') echo 'checked'; if($vars['plq_order_reqd']=="") echo 'checked'; ?> />No<br />
                                        
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
								<?php	if($vars['pkplaque_id'] !=""){ getImagesByPlaqueId($vars['pkplaque_id'],$vars['primary_img']); } ?>
								<tr>
	            					<td colspan="3"><div id='txtAssoc'></div></td>
								</tr>

								</table>
								<table>
									<tr>
										<th colspan="3" align="left">Landmark: </th>
									</tr>
									<tr>
										<td colspan="3"> 
										<?php
											// must get id from associate table to compare
										if($vars['pkplaque_id'] !=""){ getLandmarkListing($vars['pkplaque_id']);}else {getLandmarkListing($id=1);} ?></td>
									</tr>
									<tr>
										<td colspan="3">
											<div id="txtOwner"></div>
										</td>
									</tr>
								</table>
							</fieldset>
							<input class="btton" type="submit" value="Submit" name="submit_app" />
							</form>
<?php
} 
 /* -----------------------------------------	Display PlaqueType		----------------------------------------------*/

function displayPlaqueType($id)
{
require_once("projectClasses/controller.php");
$m_plaquetype = new controllerClass();
$results=$m_plaquetype->getPlaqueType();
?>
							<select name="fkplaquetypeid">
                            	<option value="">Choose a Plaque Type...</option>
        <?php
 			while($row = mysql_fetch_array($results)){
		?>
			
								<option value="<?php echo $row['id']; ?>"
                <?php
				 if($id == $row['id']) echo "selected";?>><?php echo $row['name']; ?></option>
<?php			
			}
			?>                           
							</select>
<?php
}
 /* -----------------------------------------	Display Inscription		----------------------------------------------*/
function getInscriptionComments($pkplaque_id)
{
	$m_inscription = new controllerClass();
	$results=$m_inscription->GetInscriptionCommentsByPlaqueId($pkplaque_id);
	if($results){
		while($row = mysql_fetch_array($results))
		{
			 echo $row['plqinsc_comments'];

		}
	}


}

/* -----------------------------------------	Display Images	----------------------------------------------*/
function getImagesByPlaqueId($pkplaque_id,$prim)
{

	$m_images = new controllerClass();
	$results=$m_images->getImagesByPlaqueId($pkplaque_id);
	if($results){?>
	<table class="img_checks">
			<tr valign="top">
<?php
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
				<img align="left" src="<?php echo trim($row['image_directory'])."/small/".trim($row['image_name']); ?>" alt="<?php echo stripslashes($row['image_title']); ?>"></a><br clear="all" />
			<strong><?php echo stripslashes($row['image_title']); ?></strong><br />
			Primary:
			<input  type="checkbox" name="primary_img"  value="<?php echo $row['pkimage_id']; ?>" <?php if($prim == $row['pkimage_id']) echo 'checked="checked"';?> />
			
			Remove:
			<input  type="checkbox" onclick="removePlaque(this.value)" value="<?php echo $pkplaque_id."-".$row['pkimage_id'];?>" /></td>
<?php			$i++;
 	} ?>
	</tr>
	</table>
<?php
	}

}
/* -----------------------------------------	Display Landmarks		----------------------------------------------*/
function getLandmarkListing($fkplaque_id)
{
	$m_landmark = new controllerClass();
	$results=$m_landmark->getAllLandmark();
	if($results){
				$result2=$m_landmark->getLandmarkfromPlaque($fkplaque_id);
				$row2= mysql_fetch_array($result2);
		?>
							<select name="fklandmark_id" onchange="showLandmark(this.value)">
                            	<option value="">Choose a Landmark...</option>
        <?php
 			while($row = mysql_fetch_array($results))
			{
		?>
			
								<option value="<?php echo $row['pklandmark_id']; ?>" <?php if($row2['fklandmark_id'] == $row['pklandmark_id'])  echo "selected";?>><?php echo $row['land_name']; ?></option>
				 
			<?php		 
				
				
			}
		?>                           
							</select>
<?php
	}
}

?>