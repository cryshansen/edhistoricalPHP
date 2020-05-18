<script>
function ShowBio()
{
	document.getElementById("bio").style.display = '';
}
function toggle_it(itemID){
// Toggle visibility between none and inline
	if ((document.getElementById(itemID).style.display == 'none'))
	{
		document.getElementById(itemID).style.display = '';
	} else {
		document.getElementById(itemID).style.display = 'none';
	}
}
function showNominator(aid)
{ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var url="../admin/apps/application/getapplicant.php"
	url=url+"?fkapplicant_id="+aid 
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChangedForApplicant
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
function stateChangedForApplicant() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtOwner").innerHTML=xmlHttp.responseText 
	} 
}
function onload(){
	if(document.getElementById(itemID) =='award'){
		document.getElementById('myRow1').style.display = '';
	}
}

</script>

<?php
	$m_application = new controllerClass();
	$app_pre_vars = $m_application->getApplication();
	$history_vars =$m_application->getApplicationHistory();
	$applicant_vars = $m_application->getApplicant();
	$application_validation = array('pkapplication_id', 1, 'primary key', 'site_name', 5, 'site/award name', 'app_lname', 5, 'contact last name',
	'phone_bus', 103, 'phone (bus)', 'phone_res', 103, 'phone (res)', 'app_fax', 103, 'fax', 'app_email', 104, 'email address', 
	'application_type', 5, 'type', 'app_date', 5, 'data', 'fkapplicant_id', 102, 'applicant', 'fkapplication_status_id', 102, 'status', 
	'fkhistorical_id', 102, 'historical event');	

	
	
		if(isset($_POST['submit_app']))
			{
				//call insert function
				$post_vars=$_POST;
				$post_vars['phone_bus']= deconstructPhone($post_vars['phone_bus']);
				$post_vars['phone_res']=deconstructPhone($post_vars['phone_res']);
				$post_vars['app_fax']=deconstructPhone($post_vars['app_fax']);
				if($post_vars['pkapplication_id'] =='new'){
					//echo "adding new";
					if (validateData($application_validation, $post_vars)) { 
						$result=$m_application->createApplication( $post_vars);
					} else { 				// otherwise 
						// validation error, display form, data and error message 
?> 
				<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php						
						displayApplication($post_vars);
					} 

				}else{
					//echo "updating"; 
					if (validateData($application_validation, $post_vars)) { 
						$result=$m_application->updateApplication( $post_vars);
					} else { 				// otherwise 
						// validation error, display form, data and error message
?> 
				<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php 
						displayApplication($post_vars);
					} 

				}

				if($result){
				?>
				
					<p>Your Application has been<?php if($post_vars['pkapplication_id'] =='new') echo " Added"; else echo "Updated";?>. If you would like to see a listing click <a href="index.php?page=application_listing">here</a>.</p>
<?php				
				}
			
			}else{			
						if(isset($_GET['pid']))
						{
							//display individual
							$result=$m_application->getApplicantById($_GET['pid']);
							while ($row = mysql_fetch_array($result))
							{								
								//call display function()
								$row = array_merge($app_pre_vars,$row);
								$row =array_merge($history_vars,$row);
								$row['phone_bus']= displayPhone($row['phone_bus']);
								$row['phone_res']=displayPhone($row['phone_res']);
								$row['app_fax']=displayPhone($row['app_fax']);

								displayApplication($row);
							
							}
						}else if(isset($_GET['id'])){
							$result=$m_application->getApplicationById($_GET['id']);
							while ($row = mysql_fetch_array($result))
							{	
								$row['phone_bus']= displayPhone($row['phone_bus']);
								$row['phone_res']=displayPhone($row['phone_res']);
								$row['app_fax']=displayPhone($row['app_fax']);
								displayApplication($row);
							
							}

						
						}else{
							//get all variables set to ""
							$applicant_vars = array_merge($app_pre_vars,$applicant_vars);
							$applicant_vars =array_merge($history_vars,$applicant_vars);
							//call dislay function() with empty parameters
							displayApplication($applicant_vars);
						}

			}//closing outerelse
	/*------------------------------------------------	Diplay Applicant	---------------------------------------------------*/
			function displayApplication($vars)
			{
				?>
				<div class="print">
						<form  style="text-align:right" name="print" method="post" action="" >
							<input class="btton" type="submit" value="Print" onClick="window.print()" name="print" />
						</form>
						<form name="applicant" method="post" action="" ><!--index.php?action=applicant-->
							<input type="hidden" name="pkapplication_id" value="<?php if ($vars['pkapplication_id']=='') echo 'new'; else echo $vars['pkapplication_id']; ?>" />			
							<input type="hidden" name="fkapplicant_id" value="<?php echo $vars['fkapplicant_id']; ?>" />	
							<fieldset>
							<legend>Site / Building or Award Nominee</legend>
								<table>
																<tr>
								<td>Site or Award Name:<br />
									<input type="text" name="site_name" value="<?php echo $vars['site_name']; ?>" /></td>
									<td>Contact First Name:<br />
									<input type="text" name='app_fname' value="<?php echo $vars['app_fname']; ?>" /></td>
									<td>Contact Last Name:<br />
									<input type="text" name='app_lname' value="<?php echo $vars['app_lname']; ?>" /></td>
								</tr>
								<tr>      						
									<td>Phone Number:<br />
									<input type="text" name='phone_bus' value="<?php echo $vars['phone_bus']; ?>" /></td>
									<td>Home Phone:<br />
									<input type="text" name='phone_res' value="<?php echo $vars['phone_res']; ?>" /></td>
									<td>Fax:<br />
									<input type="text" name='app_fax' value="<?php echo $vars['app_fax']; ?>" /></td>
								</tr>
								<tr>					
									<td><div>Date:<br />
									<input onclick='ds_sh(this);' name='app_date' readonly='readonly' style='cursor: text' value="<?php echo $vars['app_date'] ?>"/></div>
									</td>
									<td colspan="2">Email:<br />
										<input type="text" name='app_email' value="<?php echo $vars['app_email']; ?>" size="45"/> </td>
								</tr>
								<tr><td colspan="3">Address:<br />
         						 <input type="text" name='app_address' value="<?php echo $vars['app_address']; ?>" size="72" /></td>
								<tr>
									<td colspan="2">Application Description:
									<textarea name="app_description" cols="40" rows="6"><?php echo $vars['app_description']; ?></textarea></td>
									<td>
										Application Type:<br />
									<input type="radio"  name='application_type' value="Plaque" 
									<?php	if($vars['application_type']=="") echo 'checked'; elseif($vars['application_type']=='Plaque') echo 'checked'; ?> onClick="toggle_it('myRow1')"  />Plaque
									<input onload  type="radio"  name='application_type' value="Award" 
									<?php	 if($vars['application_type']=='Award') echo 'checked id="award" '; ?> onClick="toggle_it('myRow1')" />Award
										<br />
										
                                        <?php
										if($vars['application_type']=='Award'){ echo '<script>onload();</script>';}
										 displayApplicationStatus($vars['fkapplication_status_id']); 
										 displayHistoricalEvent($vars['fkhistorical_id']); ?>
									</td>
								</tr>
								<tr>
									<td colspan="2"><div id="myRow1" style="display: none;"> Biography: (for Awards only)<br />
									<textarea name="app_biography" cols="40" rows="6"><?php echo $vars['app_biography']; ?></textarea></div></td>
									<td></td>
								</tr>

								<tr>
									<td colspan="2">Support Documents:<br />
									<textarea name="supporting_material" cols="40" rows="6"><?php echo $vars['supporting_material']; ?></textarea></td>

								</tr>
								<tr>
									<td colspan="2">Leave Comments:<br />
									<textarea name="hist_comments" cols="40" rows="6"><?php if($vars['pkapplication_id'] !='') displayHistoryComments($vars['pkapplication_id']); ?></textarea></td>
								</tr>
								</table>
							<table>
								<tr><th colspan="3">Nominator</th></tr>
								<tr>
									<td>Nominator Lookup:<br />
											<?php displayNominator($vars['fkapplicant_id']); ?></td>
									</tr>
									<tr>
										<td colspan="3">
											<div id='txtOwner'></div>
										</td>
									</tr>
									<tr>
										<td colspan="3">Existing Nominator:
											<?php if($vars['fkapplicant_id'] !="") displayNominatorContent($vars['fkapplicant_id']); elseif($vars['pkapplicant_id'] !="")  displayNominatorContent($vars['pkapplicant_id']); else echo "None";  ?>
										</td>
									</tr>
							</table>
							</fieldset>

							<input class="btton" type="submit" value="Submit" name="submit_app" />
						</form>
						</div>
						
						
<?php						


				}
		
/*--------------------------------  DISPLAY APPLICATION STATUS --------------------------------------*/
		function displayApplicationStatus($id)
		{		
		?>Application Status<br />
			<select name="fkapplication_status_id">
				<option value="">Choose a Status...</option>
<?php
			
			$m_application_status = new applicationClass();
			$result=$m_application_status->getApplicationStatus();
			while($row = mysql_fetch_array($result)){
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
/*--------------------------------	HISTORICAL EVENT -------------------------------------------------*/
function displayHistoricalEvent($id)
{
  		?>	Historical Event<br />
			
			<select name="fkhistorical_id">
				<option value="">Choose an Event...</option>

<?php			
			$m_application_status = new applicationClass();
			$result=$m_application_status->getHistoricalEvent();
			while($row = mysql_fetch_array($result)){
		?>
			
				<option value="<?php echo $row['id']; ?>"
			<?php	 if($id == $row['id']) echo "selected" ?> ><?php echo $row['name']; ?></option>
<?php			
			}
			?>
			</select>
		

<?php

}
/*--------------------------------	APPLICATION COMMENTS -------------------------------------------------*/
function displayHistoryComments($id)
{

			
			$m_history_comments = new applicationHistoryClass();
			$result=$m_history_comments->getHistoricalComments($id);
			if($result){
				while($row = mysql_fetch_array($result)){
				 echo $row['hist_comments']; 
				}
			}

}
	
/* ------------------------------------------- Display Nominator ------------------------------------------*/
	
	function displayNominator($fkapplicant_id)
	{
			$m_owner = new controllerClass();
			$results=$m_owner->getAllApplicant();

	?>
				<select name="fkapplicant_id" onchange='showNominator(this.value)'>
				<?php
				while($row=mysql_fetch_array($results))
				{
				?>
		
						<option value="<?php echo $row['pkapplicant_id']; ?>"<?php if($row['pkapplicant_id'] == $fkapplicant_id) echo "selected"; ?>><?php echo $row['contact_fname']. " ".$row['contact_lname']; ?></option>
				<?php 
				}
				?>
											</select>
<?php
	
	}
	/* ------------------------------------------- Display Nominator Content ------------------------------------------*/
	
	function displayNominatorContent($fkowner_id)
	{
			$m_owner = new controllerClass();
			$owner = $m_owner->getApplicantById($fkowner_id);

	?>
				<table>
					<tr>
						<th>Nominator Name</th>
						<th>Phone</th>
						<th>FOIP</th>
					</tr>
				<?php
				while($row=mysql_fetch_array($owner))
				{
				?>
					<tr>
						<td><?php echo $row['contact_fname']. " ".$row['contact_lname']; ?></td>
						<td><?php echo displayPhone($row['phone']); ?> </td>
						<td><?php echo $row['foip'];?> </td>
					</tr>
		
				<?php 
				}
				?>
				</table>
<?php
	
	}

			
?>



