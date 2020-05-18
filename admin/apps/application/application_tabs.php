<!--<h3>Welcome to the Edmonton Historical Boards Admin Site - <?php // echo $page; ?></h3>
--><script>
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
function hide_show_div(item) {
	//set up number range = 1 - 4
	i=1;
	for(i=1; i<5; i++)
	{
		if(i==item)
		{
			obj=document.getElementById(i);
			obj.style.display="block";
		}else{
			
			obj=document.getElementById(i);
			obj.style.display="none";
		}
	}
	//compare item to range and step through 
	//if item = number then echo display block set others to display none
	/*obj=document.getElementById(item);
	if (obj.style.display=="none") {
	obj.style.display="block";
	} else {
	obj.style.display="none";
	}*/
}

</script>

<?php
require_once("projectClasses/controller.php");
	$m_application = new controllerClass();
	$app_pre_vars = $m_application->getApplication();
	$history_vars =$m_application->getApplicationHistory();
	$applicant_vars = $m_application->getApplicant();
	
	
		if(isset($_POST['submit_app']))
			{
				//call insert function
				$post_vars=$_POST;
				if($post_vars['pkapplication_id'] =='new'){
					echo "adding new";
					$result=$m_application->createApplication( $post_vars);
				}else{
					echo "updating"; 
					print_r($_POST);
					$result=$m_application->updateApplication( $post_vars);
				}

				if($result){
				?>
				
					<p>Your Application has been Added. If you would like to see a listing click <a href="index.php?page=application_listing">here</a>.</p>
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
								displayApplication($row);
							
							}
						}else if(isset($_GET['id'])){
							$result=$m_application->getApplicationById($_GET['id']);
							while ($row = mysql_fetch_array($result))
							{								
								//call display function()
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
				//vars is an array	
				//print_r($vars);	
				?>
					<h3>Application Form</h3>
							
                                <ul id="tabs">
                                    <li><a href="javascript:hide_show_div('1')">Nominee</a></li>
                                    <li><a href="javascript:hide_show_div('2')">Description Content</a></li>
                                    <li><a href="javascript:hide_show_div('3')">Documents and Comments</a></li>
                                    <li><a href="javascript:hide_show_div('4')">Nominator</a></li>
                                </ul>
						<form style="text-align:right" name="print" method="post" action="" >
							<input class="btton" type="submit" value="Print" onClick="window.print()" name="print" />
						</form>
						<form name="applicant" method="post" action="" ><!--index.php?action=applicant-->
							<input type="hidden" name="pkapplication_id" value="<?php if ($vars['pkapplication_id']=='') echo 'new'; else echo $vars['pkapplication_id']; ?>" />			
							<input type="hidden" name="fkapplicant_id" value="<?php echo $vars['fkapplicant_id']; ?>" />	
							<div  id="1" style="display:'';">
								<table>
								<tr>
								<td>Site or Award Name:<br />
									<input type="text" name="site_name" value="<?php echo $vars['site_name']; ?>" /></td>
									<td>Contact First Name:<br />
									<input type="text" name='app_fname' value="<?php echo $vars['app_fname']; ?>" /></td>
									<td>Contact Last Name:<br />
									<input type="text" name='app_lname' value="<?php echo $vars['app_lname']; ?>" /></td>
								</tr>
								<tr><td>Address:<br />
									<input type="text" name='app_address' value="<?php echo $vars['app_address']; ?>" /></td>
									<td>Phone Number:<br />
									<input type="text" name='phone_bus' value="<?php echo $vars['phone_bus']; ?>" /></td>
									<td>Home Phone:<br />
									<input type="text" name='phone_res' value="<?php echo $vars['phone_res']; ?>" /></td>
								</tr>
								<tr>
									<td>Fax:<br />
									<input type="text" name='app_fax' value="<?php echo $vars['app_fax']; ?>" /></td>
									<td>Email:<br />
										<input type="text" name='app_email' value="<?php echo $vars['app_email']; ?>" /> 
									<td><div>Date:<br />
									<input onclick='ds_sh(this);' name='app_date' readonly='readonly' style='cursor: text' value="<?php echo $vars['app_date'] ?>"/></div>
									</td>
								</tr>
								</table>
								</div>
								<div class="left_div" id="2" style="display:none;">
								<table>
								<tr>
									<td colspan="2">Application Description:
									<textarea name="app_description" cols="40" rows="6"><?php echo $vars['app_description']; ?></textarea></td>
									<td>
										Application Type:<br />
									<input type="radio"  name='application_type' value="Plaque" 
									<?php	 if($vars['application_type']=='Plaque') echo 'checked'; ?> onClick="toggle_it('myRow1')"  />Plaque
									<input type="radio"  name='application_type' value="Award" 
									<?php	 if($vars['application_type']=='Award') echo 'checked'; ?> onClick="toggle_it('myRow1')" />Award
										<br />
                                        <?php
										 displayApplicationStatus($vars['fkapplication_status_id']); 
										 displayHistoricalEvent($vars['fkhistorical_id']); ?>
									</td>
								</tr>
								<tr>
									<td colspan="2"><div id="myRow1" style="display: none;"> Biography: (for Awards only)<br />
									<textarea name="app_biography" cols="40" rows="6"><?php echo $vars['app_biography']; ?></textarea></div></td>
									<td></td>
								</tr>
								</table>
								</div>
								<div class="left_div" id="3" style="display:none;">
								<table>
								<tr>
									<td colspan="2">Support Documents:<br />
									<textarea name="supporting_material" cols="40" rows="6"><?php echo $vars['supporting_material']; ?></textarea></td>
									<td></td>

								</tr>
								<tr>
									<td colspan="2">Leave Comments:<br />
									<textarea name="hist_comments" cols="40" rows="6"></textarea></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="3"><?php if($vars['pkapplication_id'] !='') displayHistoryComments($vars['pkapplication_id']); ?></td>
								</tr>
								</table>
								</div>
							
						<div class="left_div" id="4" style="display:none;">
							<table>
								<tr>
									<td>Organization Name:<br />
									<input type="text" name='organization_name' value="<?php echo $vars['organization_name']; ?>" /></td>
									<td>Organization Type:<br />
									<input type="radio"  name='app_type' value="Individual" 
									<?php	 if($vars['app_type']=='Individual') echo 'checked'; ?>  />Individual
									<input type="radio"  name='app_type' value="Organization" 
									<?php	 if($vars['app_type']=='Organization') echo 'checked'; ?> />Organization</td>
								</tr>

								<tr>
									<td>Contact First Name:<br />
									<input type="text" name='contact_fname' value="<?php echo $vars['contact_fname']; ?>" /></td>
									<td>Contact Last Name:<br />
									<input type="text" name='contact_lname' value="<?php echo $vars['contact_lname']; ?>" /></td>
								</tr>
								<tr><td>Address:<br />
									<input type="text" name='address' value="<?php echo $vars['address']; ?>" /></td>
									<td>Phone Number:<br />
									<input type="text" name='phone' value="<?php echo $vars['phone']; ?>" /></td>
								</tr>
								<tr>
									<td>Secondary Phone:<br />
									<input type="text" name='phone2' value="<?php echo $vars['phone2']; ?>" /></td>
									<td>Fax:<br />
									<input type="text" name='fax' value="<?php echo $vars['fax']; ?>" /></td>
								</tr>
								<tr><td>Email:<br />
										<input type="text" name='email' value="<?php echo $vars['email']; ?>" /> 
									</td>
								<td >FOIP Waiver Signed:<br />
									<input type="radio"  name='foip' value="Y"
									<?php	 if($vars['foip']=='Y') echo 'checked'; ?>  />Yes
									<input type="radio"  name='foip' value="n" 
									<?php	 if($vars['foip']=='n') echo 'checked'; ?>	/>No
									<input type="hidden" name="pkapplicant_id" value="<?php if ($vars['pkapplicant_id']=='') echo 'new'; else echo $vars['pkapplicant_id']; ?>" /></td>
								</tr>
								<tr><td colspan="2"></td></tr>
							</table>
                            <input class="btton" type="submit" value="Submit" name="submit_app" />
							</div>
						</form>
<?php						
				}
		
		/*--------------------------------  DISPLAY APPLICATION STATUS --------------------------------------*/
		function displayApplicationStatus($id)
		{		
		?>Application Status<br />
			<select name="fkapplication_status_ID">
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
?>	
	<ul>
<?php
			
			$m_history_comments = new applicationHistoryClass();
			$result=$m_history_comments->getHistoricalComments($id);
			while($row = mysql_fetch_array($result)){
		?>
		<li><?php echo $row['history_date']; ?> <br /><?php echo $row['hist_comments']; ?>
		</li>
<?php
		
			}
		?>
	</ul>
<?php

}
			
?>



