<?php
	$m_applicant = new controllerClass();
	$applicant_vars=$m_applicant->getApplicant();
	$applicant_validation=array('pkapplicant_id', 1, 'primary key', 'contact_lname', 5, 'last name', 'app_type', 5, 'type', 
		'phone', 3, 'phone', 'phone2', 103, 'second phone', 'fax', 103, 'fax', 'email', 104, 'email address', 'foip', 5, 'waiver');	


			if(isset($_POST['submit_app']))
			{
				//call insert function
				$post_vars=$_POST;
				$post_vars['phone']= deconstructPhone($post_vars['phone']);
				$post_vars['phone2']=deconstructPhone($post_vars['phone2']);
				$post_vars['fax']=deconstructPhone($post_vars['fax']);
				if($post_vars['app_type']=='')$post_vars['app_type']='Individual';
				if($post_vars['pkapplicant_id'] =='new'){
					if (validateData($applicant_validation, $post_vars)) { 
						echo "adding new";
						$result=$m_applicant->createApplicant($post_vars);
					}else{
?> 
						<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 						
<?php					displayApplicant($post_vars); 
					}
				}else{
					if (validateData($applicant_validation, $post_vars)) { 
						//echo "update";

						$result=$m_applicant->updateApplicant($post_vars);
					}else{
?> 
						<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 						
<?php					displayApplicant($post_vars); 
					}
				
				}
				if($result){
				?>
				
					<p>Your Applicant has been<?php if($post_vars['pkapplicant_id'] =='new') echo " Added."; else echo " Updated."; ?> If you would like to see a listing click <a href="index.php?page=nominator_listing">here</a>.</p>
<?php				
				}

			
			}else{			
						if(isset($_GET['id']))
						{
							//display individual
							$result=$m_applicant->getApplicantById($_GET['id']);
							while ($row = mysql_fetch_array($result))
							{								
								//phone function
								//strip the phone number first three digits
								$row['phone']= displayPhone($row['phone']);
								$row['phone2']=displayPhone($row['phone2']);
								$row['fax']=displayPhone($row['fax']);
								//call display function()
								displayApplicant($row);
							
							}
						}else{
						
							//call dislay function() with empty parameters
							displayApplicant($applicant_vars);
						}

			}//closing outerelse
/*------------------------------------------------	Diplay Applicant		---------------------------------------------------*/
			function displayApplicant($vars)
			{

			
		?>
						<form name="applicant" method="post" action="" >
						<fieldset>			
						<legend>Nominator </legend>
  <table>
    <tr></tr>
    <td>Organization Type:<br /> <input type="radio"  name='app_type' value="Individual" 
									<?php	 if($vars['app_type']=='Individual' or ($vars['app_type']) =='') echo 'checked'; ?>  />
      Individual 
      <input type="radio"  name='app_type' value="Organization" 
										 if($vars['app_type']=='organization')<?php echo 'checked'; ?> />
      Organization</td>
    </tr>
    <tr> 
      <td colspan="3">Organization Name:<br /> <input type="text" name='organization_name' value="<?php echo $vars['organization_name']; ?>" size="63" /></td>
    </tr>
    <tr> 
      <td>Contact First Name:<br /> <input type="text" name='contact_fname' value="<?php echo $vars['contact_fname']; ?>" /></td>
      <td>Contact Last Name:<br /> <input type="text" name='contact_lname' value="<?php echo $vars['contact_lname']; ?>" /></td>
    </tr>
    <tr>
      <td>Address:<br /> <input type="text" name='address' value="<?php echo $vars['address']; ?>" /></td>
      <td>Phone Number:<br /> <input type="text" name='phone' value="<?php echo $vars['phone']; ?>" /></td>
    </tr>
    <tr> 
      <td>Secondary Phone:<br /> <input type="text" name='phone2' value="<?php echo $vars['phone2']; ?>" /></td>
      <td>Fax:<br /> <input type="text" name='fax' value="<?php echo $vars['fax']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="3">Email:<br /> 
	  <input type="text" name='email' value="<?php echo $vars['email']; ?>" size="56" /> 
      </td>
      <tr>
	  <td>
	  FOIP Waiver Signed:<br /> <input type="radio"  name='foip' value="Y"
									<?php if($vars['foip']=='Y') echo 'checked'; ?>  />
        Yes 
        <input type="radio"  name='foip' value="N" 
					<?php	 if($vars['foip']=='N'){ echo 'checked';} if($vars['foip']=='') echo 'checked'; ?>	/>
        No </td></tr>
    </tr>
    <tr>
      <td colspan="2"></td>
    </tr>
  </table>
  </fieldset>
							<input type="hidden" name="pkapplicant_id" value="<?php if ($vars['pkapplicant_id']=='') echo 'new'; else echo $vars['pkapplicant_id']; ?>" />
							<input class="btton" type="submit" value="Submit" name="submit_app" />
							</form>
<?php
			}
?>
