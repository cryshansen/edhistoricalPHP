<h3>Forgot Password</h3>

<?php
	$m_user= new controllerClass();
		//set variables
		//$user_vars= array('pkLog_In'=>"",'fkUser_Group_ID'=>"" ,'txtUser_First_Name'=>"",  'txtUser_Last_Name'=>"", 'txtUser_Login_ID'=>"",'txtUser_Password'=>"",'email'=>"");

		if(isset($_POST['create'])){
			//check if user exists
			$email=$_POST['email'];
			$results=$m_user->check_UserByEmail($email);
			$rowcount=mysql_num_rows($results);
			if($rowcount > 0){
				
				 while ($row = mysql_fetch_array($results) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))<?php5
				  { 
				  	print_r($row);
					//generate a new password
					$n_password=generatePassword();
					//echo $n_password;
					$username=$row['user_name'];
					//update user with new password
					//$result=$m_user->updateUserPassword($n_password);
					//send out email with password
					sendEmail($username,$n_password);
			?>
					<p>Your temporary password has been sent to your email. Please authorise.</p>
			
<?php				}
			}else{
				echo "<p style='color:red;'>Sorry no users match the email address: '".$email ."'. <br /> Please contact your administrator.</p>";
			}	
		}else{
			displayUser();
		}
		
/*---------------------------------------	DISPLAY USER 	-----------------------------------------*/
function displayUser()
{
?>
	<p> Please enter your email address to generate a new password:</p>
	<form name='form'  action='index.php?page=user_forgot_password' method='post' onsubmit='javascript: return validate();'>
		<fieldset>
		<legend><strong>Forgot Password </strong></legend>
	 		<table>
				<tr><td>Email:</td>
	 				<td><input type='text' name='email' value="" size="50" /></td></tr>
				</tr>
	 		</table>	
	</fieldset>
	<input  class='btton' name='create' type='submit' value='submit' />
	<br />
</form>
<?php
}

//____________________________________________________________________//

function generatePassword($length=6, $strength=0) {
    $vowels = 'aieouy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1) {
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength & 2) {
        $vowels .= "AEUY";
    }
    if ($strength & 4) {
        $consonants .= '23456789';
    }
    if ($strength & 8) {
        $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}
function sendEmail($username,$n_password){
			$destination = $_POST['email'];
			$subject = "Edmonton Heritage Board forgotten password";
			$message = "Here is your forgotten username and password.\n";
			$message.= "User name: {$username}\n";
			$message.= "Password: {$n_password}\n";
			$message.="\nIf you have any questions, please don't hesitate to contact us at 780-442-5311 or cms.archives@edmonton.ca";
			$header = "From: cms.archives@edmonton.ca";
			mail ($destination, $subject, $message, $header);
}

?>
		

