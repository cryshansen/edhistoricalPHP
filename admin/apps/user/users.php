 

<?php

		//set variables
		$user_vars=array('pkuser_id' =>"",  'fkuser_group_id'=>"",'user_first_name'=>"" , 'user_last_name'=>"",'user_name'=>"",'user_password'=>"",'email'=>"");
		$user_validation_create = array('pkuser_id', 1, 'primary key', 'user_last_name', 5, 'User Last Name', 'user_password', 5, 'Password', 'user_name', 5, 'User Name', 'email', 4, 'Email Address', 'fkuser_group_id', 2, 'Access');
		$user_validation_update = array('pkuser_id', 1, 'primary key', 'user_last_name', 5, 'User Last Name', 'user_name', 5, 'User Name', 'email', 4, 'Email Address', 'fkuser_group_id', 2, 'Access');

		$m_user = new controllerClass();
		$auth_array = array(1=> 'managers',2=> 'operators',3=> 'administrators' );

		if(isset($_POST['submit_app'])){
		
			if($_POST['pkuser_id'] !='new')
			{
				if (validateData($user_validation_update, $_POST)) { 

					$result=$m_user->updateUser($_POST);
					echo "<script>javascript:redirect('index.php?page=user_listing');</script>\n";
				}else { 
				// validation error, display form, data and error message 
?> 
				<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
					displayUser($_POST); 
					
<?php			}
			}else{
				if (validateData($user_validation_create, $_POST)) { 
					callcreate($m_user);
				}else { 
				// validation error, display form, data and error message 
?> 
				<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php					displayUser($_POST); 
				}
			}
		}else{
		
			if(isset($_GET['id'])){
				$result=$m_user->getUserById($_GET['id']);
				if($result){
						while($row= mysql_fetch_array($result)){
							displayUser($row);
						}
				}
			}else{
				displayUser($user_vars);
			
		
		}
		
		}
		
/*---------------------------------------	DISPLAY USER 	-----------------------------------------*/
function displayUser($vars)
{
?>
	<form name='form'  action='index.php?page=user' method='post' onsubmit='javascript: return validate();'>
		<fieldset>
		<legend><strong>User Account </strong></legend>
	 		<table>
	 			<tr><td>First Name:</td>
	 				<td><input name='user_first_name' type='text' size='20' value="<?php echo $vars['user_first_name']; ?>" /></td></tr>
	 			<tr><td>Last Name:</td>
	 				<td><input name='user_last_name' type='text' size='20' value="<?php echo $vars['user_last_name']; ?>" /></td></tr>
	 			<tr><td>Username:</td>
	 				<td><input type='text' name='user_name' value="<?php echo $vars['user_name']; ?>" /></td></tr>
<?php			
				if($vars['pkuser_id'] =='')
				{
				?>
	 			<tr><td>Password:</td>
	 				<td><input type="password"  name='user_password' value="<?php echo $vars['user_password']; ?>" /></td>
				</tr>
<?php				 
				}
				?>
				<tr><td>Email:</td>
	 				<td><input type='text' name='email' value="<?php echo $vars['email']; ?>" size="50" /></td></tr>

	 			<tr><td>Access:</td>
					<td>
				<?php
								 displayUserGroup($vars['fkuser_group_id']); 
				?>
	 				</td>
				</tr>
	 		</table>	
	</fieldset>
	<input type="hidden" name="pkuser_id" value="<?php if ($vars['pkuser_id'] != '') echo $vars['pkuser_id']; else echo 'new'; ?>"  />
	<input  class='btton' name='submit_app' type='submit' value='submit' />
	<br />
</form>
<?php
}

function displayUserGroup($id)
{
?>
			<select name="fkuser_group_id">
				<option value="">Choose an Access Level...</option>

<?php			
			$m_user_access = new userClass();
			$result=$m_user_access->getUserGroup();
			while($row = mysql_fetch_array($result)){
		?>
			
				<option value="<?php echo $row['id']; ?>"
                <?php
				 if($id == $row['id']) echo "selected";?>> <?php echo $row['name']; ?></option>
<?php			
			}
			?>
			</select>
<?php		
}
function callcreate($m_user)
{
//check for existing contact name/username
	$results=$m_user->check_Username($_POST['user_name']);
	$row = mysql_fetch_array($results);
	if($row !=''){
				echo "Username".$_POST['user_name']." already exists! Please select another.";

	}else{
		//insert into db. 
		$results=$m_user->user_create($_POST);
		if($results){
			 echo "<script>javascript:redirect('index.php?page=user_listing');</script>\n";
		 }else{
		 
			echo"DB Failure contact your administrator.";
		 }

		
	}

}
?>
		
