<?php
	$m_inscription = new controllerClass();
	$awardinscription_vars=$m_inscription->getAward();

			if(isset($_POST['submit_app']))
			{
				//call insert function
				$post_vars=$_POST;
				print_r( $post_vars);
				if($post_vars['pkaward_id'] =='new'){
					echo "adding new";
					//YOU WILLL HAVE TO GET THE AWARD REQUIRED FIELD VALUE IN THE AWARD CLASS OUT AND UPDATE THE AWARD RECORD
					$result=$m_inscription->updateaward($post_vars);
				}else{
					echo "update";
					//YOU WILLL HAVE TO GET THE AWARD REQUIRED FIELD VALUE IN THE AWARD CLASS OUT AND UPDATE THE AWARD RECORD
					$result=$m_inscription->updateaward($post_vars);
				
				}
				if($result){
				?>			
					<p>Enter an award inscription in the text area below and then press submit when finished.</p>
<?php			}			
			
		}else{
						if(isset($_GET['id']))
						{
							//CHANGE THE AWARD GETINSCRIPTION CALL TO ALSO GATHER THE INFO FOR THE AWARD REQUIRED FIELD IF NOT IN SELECT STATEMENT ALREADY
							//display individual
							$result=$m_inscription->getAwardByID($_GET['id']);
							
							while ($row = mysql_fetch_array($result))
							{								
								//call display function()
								displayInscription($row);
							
							}
						}else{
							//APPEND AWARD REQUIRED TO ARRAY
							$awardinscription_vars=array_merge($awardinscription_vars,$m_inscription->getAward());
							//print_r($plaqueinscription_vars);
							//call dislay function() with empty parameters						
							displayInscription($awardinscription_vars);
						}

			}//closing outerelse
/*------------------------------------------------	Diplay Inscription	---------------------------------------------------*/
			function displayInscription($vars)
			{

		?>
		<p>Award Name:<?php echo $vars['awd_recipient']; ?></p>
<form name="award_inscription" method="post" action="" >
							<fieldset>
							<legend>Award Inscription</legend>
							<table>
							  <tr>
							    <td><div>Inscription Date:<br />
							      <input onclick='ds_sh(this);' name='awdinsc_date' readonly='readonly' style='cursor: text' value="<?php echo $vars['awdinsc_date']; ?>"/>						  
							      </div></td>
						      </tr>
							  <tr>
							    <td colspan="2" valign="top">Inscription:<br />
							      <textarea name="awdinscrip_content" cols="40" rows="6"><?php echo $vars['awdinscrip_content']; ?></textarea></td>
							    <td valign="top">Inscription Required: <br />
							      <input type="radio" name="awd_inscript_reqd" value="Y" <?php if ($vars['awd_inscript_reqd']=='Y') echo "checked"; ?> />
							      Yes
							      <input type="radio" name="awd_inscript_reqd" value="N" <?php if ($vars['awd_inscript_reqd']=='N') echo "checked"; ?>/>
							      No<br />
							      Order Required:<br />
							      <input type="radio" name="awd_order_reqd" value="Y" <?php if ($vars['awd_order_reqd']=='Y') echo 'checked'; ?>/>
							      Yes
							      <input type="radio" name="awd_order_reqd" value="N" <?php if ($vars['awd_order_reqd']=='N') echo 'checked'; ?> />
							      No<br /></td>
						      </tr>
  <td colspan="2">Inscription Comments:<br />
    <textarea name="awdinsc_comments" cols="40" rows="6"></textarea>
    <ul>
      <?php getAwardInscriptionComments($vars['pkaward_id']); ?>
    </ul></td>
  </tr>
							  </table>
</fieldset>
							<input type="hidden" name="pkaward_id" value="1"  />
							<input class="btton" type="submit" value="Submit" name="submit_app" />
							</form>
                        
                        
<?php
			
			}
			 /* -----------------------------------------	Display Inscription		----------------------------------------------*/
function getAwardInscriptionComments($pkaward_id)
{
	$m_inscription = new controllerClass();
	$results=$m_inscription->getInscriptionCommentsByAwardId($pkaward_id);
	if($results){
		while($row = mysql_fetch_array($results))
		{	
			?>
			<li><?php echo $row['awdcomment_date']; ?><br /><?php echo $row['awdinsc_comments']; ?></li>

			<?php
		}
	}


}			
?>
