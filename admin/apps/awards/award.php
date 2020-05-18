<script>
//STATE CHANGE FOR  ASSOCIATIONS TO PLAQUES / LANDMARKS / AWARDS
function stateChangedForAssociation() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtAssoc").innerHTML=xmlHttp.responseText 
	} 
}
//FUNCTION TO REMOVE IMAGE ASSOCIATION WITH AWARD

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
	alert(url);
	xmlHttp.onreadystatechange=stateChangedForAssociation
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
	uncheckField();
}


function uncheckField()
{
//alert("Im in here");
	document.award.primary_img.checked=false;
}

</script>
 	
<?php
$m_award= new controllerClass();
$award_vars = $m_award->getAward();

		if(isset($_POST['submit_app']))
		{	
			$post_vars=$_POST;
			$post_vars['image_name']=$_FILES['image_name']['name'];
			$post_vars['image_directory']="../images/gallery/";
			if(!array_key_exists('primary_img',$post_vars))
			{
				$post_vars['primary_img']=0;
			}
			if($post_vars['pkaward_id'] == "new")
			{
				echo "Adding new";
				//upload image
				if($post_vars['image_name'] !=""){
					saveImage();
				}
				//saveimage
				//need to deal with pkid for award and image
				//$result=$m_plaque->createImage($post_vars);
				$result=$m_award->createaward($post_vars);
			
			}else{
				echo "Updating record";
				if($post_vars['image_name'] !=""){
					saveImage();
				}
				$result=$m_award->updateaward($post_vars);
			}
			if($result)
			{
			?>
			<p>Your Award has been added. Please view the listing <a href="index.php?page=award_listing"> here. </a>
<?php		
			}
		
		}else{
				
				if(isset($_GET['aid'])){
					$result=$m_award->getApplicationById($_GET['aid']);
					while ($row = mysql_fetch_array($result))
					{
						//call display function()
						//append aplication id and sitename to vars
						?>
						<p> Application Name: <?php  echo $row['site_name']; ?></p>
						<?php
						$row = array_merge($row,$award_vars);
						$row['fkapplication_id'] = $row['pkapplication_id'];
						$row['awd_recipient']=$row['site_name'];
						displayAward($row);
					}	
				}elseif(isset($_GET['id']))
				{
					//call function to get the award
					$result=$m_award->getAwardById($_GET['id']);
					while($row=mysql_fetch_array($result)){
						displayAward($row);
					}
				}else{
					displayAward($award_vars);
				}
		}
		




/* -------------------------------------- 		DISPLAY AWARD FUNCTION 		----------------------------------------------------*/
function displayAward($vars)
{
?>	
						<form name="award" method="post" enctype="multipart/form-data" action="" ><!--index.php?action=applicant-->
							<fieldset>
							<legend>Award</legend>
								<table>
									<input type="hidden" name="pkaward_id" value="<?php if ($vars['pkaward_id']=='') echo 'new'; else echo $vars['pkaward_id']; ?>" />			
									<input type="hidden" name="fkapplication_id" value="<?php echo $vars['fkapplication_id']; ?>" />																	
							<tr>
								<td colspan="3">Award Recipient <br /><input type="text" name="awd_recipient" <?php if(array_key_exists('site_name',$vars)){ echo "readonly='readonly'";} ?> value="<?php echo $vars['awd_recipient']; ?>" /></td>
							</tr>		
							<tr>
								<td>Size:<br />
									<input type="text" name="awd_size" value="<?php echo $vars['awd_size']; ?>" /></td>
									<td>Material:<br />
                                    <input type="text" name="awd_material" value="<?php echo $vars['awd_material']; ?>" />
									</td>
									<td>Award Style:<br />
                                    <input type="text" name="awd_style" value="<?php echo $vars['awd_style']; ?>" />
										
									</td>
								</tr>
								<tr>
									<td colspan="3">Location<br /><input type="text" name="awd_location" size="50" maxlength="255" value="<?php echo $vars['awd_location']; ?>" /></td>
								
								</tr>
								<tr>
									<td colspan="2">Award Description:<br />
									<textarea name="awd_desc" cols="40" rows="6"><?php echo $vars['awd_desc']; ?></textarea></td>
									<td valign="top">Inauguration Date:<br />
									<div>
									<input onclick='ds_sh(this);' name='awd_inaug_date' readonly='readonly' style='cursor: text' value="<?php echo $vars['awd_inaug_date']; ?>"/></div>
									</td>
								</tr>
								<tr>
									<td colspan="2" valign="top">Inscription:<br />
									<textarea name="awdinscrip_content" cols="40" rows="6"><?php echo $vars['awdinscrip_content']; ?></textarea></td>
							<td valign="top">Inscription Date:<br />
							<div><input onclick='ds_sh(this);' name="awdinsc_date" readonly='readonly' style='cursor: text' value="<?php echo $vars['awdinsc_date']; ?>"/></div>
							</td>
						</tr>
						<tr>
							<td colspan="2">Inscription Comments:
								<textarea name="awdinsc_comments" cols="40" rows="6"><?php if($vars['pkaward_id'] !=""){getInscriptionComments($vars['pkaward_id']);} ?></textarea>
							</td>

									<td valign="top">Inscription Required: <br />
										<input type="radio" name="awd_inscript_reqd" value="Y" <?php if ($vars['awd_inscript_reqd']=='Y') echo "checked"; ?> />Yes
										<input type="radio" name="awd_inscript_reqd" value="N" <?php if ($vars['awd_inscript_reqd']=='N') echo "checked"; if($vars['awd_inscript_reqd']=='') echo "checked"; ?>/>No<br />
										Order Required:<br />
                                        <input type="radio" name="awd_order_reqd" value="Y" <?php if ($vars['awd_order_reqd']=='Y') echo 'checked'; ?>/>Yes
                                        <input type="radio" name="awd_order_reqd" value="N" <?php if ($vars['awd_order_reqd']=='N') echo 'checked'; if ($vars['awd_order_reqd']=="")   echo "checked"; ?>/>No<br />
									</td>
								</tr>
								<tr style="text-align:left;"><th colspan="3">Image:</th>
								</tr>
									<tr>
										<td>Title:<br /><input type="text" name="image_title" value="" /></td>
										<td>Photographer: <br /><input type="" name="image_source" value="" /></td>
										<td>Copyright: <br /><input type="text" name="image_permission" value="" /></td>						
									</tr>
									<tr>
										<td colspan="3">Caption:<br /><input type="text" name="image_location" value="" size="45"  /></td>
									</tr>
									<tr>
										<td colspan="3">Upload  Detail Image:<br /><input type="hidden" name="MAX_FILE_SIZE" value="100000000" /> 
											<input name="image_name" type="file" id="image_name" /> </td>
								</tr>
								<?php	if($vars['pkaward_id'] !=""){ getImagesByAwardId($vars['pkaward_id'],$vars['primary_img']); } ?>
								<tr>
	            					<td colspan="3"><div id='txtAssoc'></div></td>
								</tr>

								</table>
							</fieldset>
							<input class="btton" type="submit" value="Submit" name="submit_app" />
							</form>
<?php
}
									
 /* ----------------------------------	Display Inscription	Comments	----------------------------------------------*/
	
function getInscriptionComments($award_id)
{
	require_once("projectClasses/controller.php");
	$m_inscription = new controllerClass();
	$results=$m_inscription->getInscriptionCommentsByAwardId($award_id);
	if($results !=""){
		while($row = mysql_fetch_array($results))
		{  
			echo trim($row['awdinsc_comments']);
		}
	}

}

/* -----------------------------------------	Display Images	----------------------------------------------*/
function getImagesByAwardId($pkaward_id,$prim)
{

	$m_images = new controllerClass();
	$results=$m_images->getImagesByAwardId($pkaward_id);
	if($results){?>
	<table class="img_checks">
			<tr valign="top">
<?php	$i=0;
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
			<img  src="<?php echo trim($row['image_directory'])."small/".trim($row['image_name']); ?>" alt="<?php echo stripslashes($row['image_title']); ?>" /></a><br clear="all" />
			<strong><?php echo stripslashes($row['image_title']); ?></strong><br />
			Primary:
			<input  type="checkbox" name="primary_img"  value="<?php echo  $row['pkimage_id']; ?>" <?php if($prim == $row['pkimage_id']) echo 'checked="checked"';?> />

			Remove:
			<input  type="checkbox" onclick="removeAward(this.value)" value="<?php echo $pkaward_id."-".$row['pkimage_id'];?>" /></td>

<?php 	
			$i++;
		} ?>
	</tr>
	</table>
<?php
	}

}




	
?>



