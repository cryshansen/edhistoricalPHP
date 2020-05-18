<?php
	$m_inscription = new controllerClass();
	$plaqueinscription_vars=$m_inscription->getInscription();
	$valid_data=array('plqinsc_date',5, 'Inscription Date','plq_inscription',5, 'Inscription');
			if(isset($_POST['submit_app']))
			{
				//call insert function
				$post_vars=$_POST;
				print_r( $post_vars);
				if(validateData($valid_data, $post_vars)) { 

					if($post_vars['pkplaqueinscription_id'] =='new'){
						echo "adding new";
						$result=$m_inscription->updateplaque($post_vars);
					}else{
						echo "update";
						$result=$m_inscription->updatePlaque($post_vars);
					
					}
					if($result){
					?>
				
						<p>Your Inscription has been <?php if($post_vars['pkplaqueinscription_id'] =='new') echo "added";else echo "updated";?>. Please view the Plaque listing <a href="index.php?page=plaque_listing"> here.</p>
	<?php			}
				}else{
?>
						<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php
						displayInscription($post_vars); 
				}			
			
		}else{
						if(isset($_GET['id']))
						{
							//display individual
							$result=$m_inscription->getPlaqueByID($_GET['id']);
							
							while ($row = mysql_fetch_array($result))
							{								
								//call display function()
								displayInscription($row);
							
							}
						}else{
							$plaqueinscription_vars=array_merge($plaqueinscription_vars,$m_inscription->getPlaque());
							//call dislay function() with empty parameters						
							displayInscription($plaqueinscription_vars);
						}

			}//closing outerelse
/*------------------------------------------------	Diplay Inscription	---------------------------------------------------*/
			function displayInscription($vars)
			{

		?>
		<p> Plaque Name: <?php echo $vars['plq_recipient']; ?></p>

						<form name="plaque_inscription" method="post" action="" ><!--index.php?action=applicant-->
							<fieldset>
							<legend>Plaque Inscription</legend>
							<table>
								<tr>
									<td>Inscription Date:<br />
									<div><input onclick='ds_sh(this);' name="plqinsc_date" readonly='readonly' style='cursor: text' value="<?php if($vars['plqinsc_date'] =='0000-00-00') echo ""; else echo $vars['plqinsc_date']; ?>"/></div></td>
									<td>Inscription Required: <br />
										<input type="radio" name="plq_inscript_reqd" value="Y" <?php if ($vars['plq_inscript_reqd']=='Y') echo 'checked'; ?>/>Yes
										<input type="radio" name="plq_inscript_reqd" value="N" <?php if ($vars['plq_inscript_reqd']=='N') echo 'checked'; ?> />No<br />
									</td>	
									<td></td>							
								</tr>
								<tr>
									<td colspan="2">Inscription Text:<br />
								    <textarea name="plq_inscription" cols="40" rows="6"><?php echo $vars['plq_inscription']; ?></textarea></td>
								</tr>
                                <tr>
									<td colspan="2">Inscription Comments:<br />
								    <textarea name="plqinsc_comments" cols="40" rows="6"><?php if($vars['pkplaque_id'] !=""){ getInscriptionComments($vars['pkplaque_id']);} ?></textarea></td>
								</tr>
							</table>								
							</fieldset>
							<input type="hidden" name="pkplaque_id" value="<?php echo $vars['pkplaque_id']; ?>"  />
							<input class="btton" type="submit" value="Submit" name="submit_app" />
							</form>
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

?>