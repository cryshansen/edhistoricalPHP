
<?php
	$m_installation = new controllerClass();
	$installation_vars=$m_installation->getInstallation(); 
	$installation_validation = array('plqinst_date', 5, 'Date', 'plqinst_comments', 5, 'Comments', 'fkvendor_id', 2, 'Vendor'); 
		
		if(isset($_POST['submit_app']))
			{
				//call insert function
				$post_vars=$_POST;
				echo "<== instal 0 ==>"; 
				print_r($post_vars); 
				echo "<== instal 0 ==>"; 				
				if($post_vars['pkplaqueinstallation_id'] =='new'){
					echo "adding ..."; 
					// validate data 
					if(validateData($installation_validation, $post_vars)) { 
						// data is valid, create installation record 
						$result=$m_installation->createInstallation($post_vars);
						//$result=$m_installation->updatePlaque($post_vars);
						if($result) { 
?> 
							<p> Your Installation has been added.  If you would like to see a listing click <a href="index.php?page=plaque_listing">here</a>.</p> 
<?php 
						} 
					} else { 
						// validation error 
?>
						<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php
						displayInstallation($post_vars); 
					} 
				} else {
					echo "updating ...";
					// validate data 
					if(validateData($installation_validation, $post_vars)) { 
						// data is valid, update installation record 
						$result=$m_installation->updateInstallation($post_vars);
						//$result=$m_installation->updatePlaque($post_vars);
						if($result) { 
?> 
							<p> Your Installation has been updated.  If you would like to see a listing click <a href="index.php?page=plaque_listing">here</a>.</p> 
<?php 
						} 
					} else { 
						// validation error 
?>
						<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php
						displayInstallation($post_vars); 
					} 
				}
			}else{		
				if(isset($_GET['id']))
				{
					//CHANGE THE PLAQUE GETINSTALLATION CALL TO ALSO GATHER THE INFO FOR THE PLAQUE INSTALLATION REQUIRED FIELD IF NOT IN SELECT STATEMENT ALREADY
					//display individual
					$result=$m_installation->getPlaqueByID($_GET['id']);	
					while ($row = mysql_fetch_array($result))
					{
						$result=$m_installation->getinspectionbydatebyplaqueid($_GET['id']);
						if(mysql_num_rows($result)>0){
							while($row2= mysql_fetch_array($result))
							{
								//if plaque has an inscription display it else create new inscription
								//call the getinspectionbydatebyplaqueid($id);
								//call display function()
								$row = array_merge($row,$row2);
								//print_r($row);
								displayInstallation($row);
							}
						}else{
							//you want to display the plaque info but empty data for the inscription
							$row = array_merge($row,$m_installation->getInstallation());
							displayInstallation($row);
						}
					}
				}else{
					//APPEND PLAQUE REQUIRED TO ARRAY
					$installation_vars=array_merge($installation_vars,$m_installation->getPlaque());
					print_r($installation_vars);
					//call dislay function() with empty parameters
					displayInstallation($installation_vars);
				}
		}//closing outerelse

			
	/*------------------------------------------------	Diplay Installation  ---------------------------------------------------*/
			function displayInstallation($vars)
			{
		
		?>
		<p> Plaque Name: <?php echo $vars['plq_recipient']; ?></p>

	
						<form name="applicant" method="post" action="" ><!--index.php?action=applicant-->
							<fieldset>
							<legend>Plaque Installation</legend>
								<table>
									<tr>
									<td><div>Installation Date:<br />
									<input onclick='ds_sh(this);' name='plqinst_date' readonly='readonly' style='cursor: text' value="<?php echo $vars['plqinst_date']; ?>"/></div></td>

									<td>Installation Required: <br />
										<input type="radio" name="plq_instal_reqd" value="Y" 
                                        <?php if ($vars['plq_instal_reqd']=='Y') echo 'checked'; ?>/>Yes
										<input type="radio" name="plq_instal_reqd" value="N" 
                                        <?php if ($vars['plq_instal_reqd']=='N') echo 'checked'; ?>/>No<br />

									
									</td>
									<td>Done By:<br />
										<select name="fkvendor_id">
											<option value="">Choose a Vendor...</option>
                                   			<?php displayVendors($vars['fkvendor_id']); ?>		
										</select>								
									</td>
								</tr>
								<tr>
									<td colspan="2">Installation Comments<br />
									<textarea name="plqinst_comments" cols="40" rows="6"><?php echo $vars['plqinst_comments']; ?></textarea></td>
									<td>
									</td>
								</tr>
							</table>								
							</fieldset>
                            <input type="hidden" name="pkplaqueinstallation_id" value="<?php if ($vars['pkplaqueinstallation_id']=='') echo 'new'; else echo $vars['pkplaqueinstallation_id']; ?>" />
                            <input type="hidden" name="pkplaque_id" value="<?php echo $vars['pkplaque_id'] ?>" />
                            <input type="hidden" name="fkplaque_id" value="<?php echo $vars['pkplaque_id'] ?>" />
							<input class="btton" type="submit" value="Submit" name="submit_app" />
							</form>
<?php	
			}
/*--------------------------------  DISPLAY vendors --------------------------------------*/
function displayVendors($id)
{			
			$m_installation = new controllerClass();
			$result=$m_installation->getAllvendors();
			while($row = mysql_fetch_array($result)){
		?>
			
				<option value="<?php echo $row['pkvendor_id']; ?>"<?php if($id == $row['pkvendor_id']) echo "selected";?>><?php echo $row['vendor_name']; ?></option>
<?php			
			}
		
}
?>