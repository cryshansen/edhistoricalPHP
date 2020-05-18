
<!--7(%|{G{G5ztn

The user projectteam now has the password 7(%|{G{G5ztn.
--><?php
	require_once("projectClasses/users.php");
	
		//set variables
		
		$m_user = new userClass();
		$auth_array = array(1=> 'managers',2=> 'operators',3=> 'administrators' );

	if (isset($_POST['logout'])){
		//echo" you are here!";
		session_destroy();
		echo "<script>redirect('index.php');</script>\n";
	}
	
	if(isset($_POST['login'])){

		$password = $_REQUEST['pass'];			
		$username=$_REQUEST['username'];
		if (($username !='username...') and ($password !='password...'))
		{
			echo "True";
			$password = $_POST['pass'];			
			$username=$_POST['username'];
			echo "Username is:".$username;
			$results=$m_user->get_Password($username);
			if($results){
				
			  while ($row = mysql_fetch_array($results) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))<?php5
			  {
				$row_password=$row['user_password'];
				//echo "Made it here";
				if($row_password = md5($password)){

					$_SESSION['username'] = $username;
					$_SESSION['pass']  = md5($password);
					$_SESSION['auth'] = $row['fkUser_Group_ID'];
					$_SESSION['uid'] = $row['pkuser_id'];
					echo  $_SESSION['auth'];
					//$valid_user=true;
					echo "Successful password. Redirecting to front page. Please wait....";
					//redirect to front page
					echo "<script>redirect('index.php');</script>\n";
				}else{
					$msg = ''; 
					echo "Login incorrect! Please re enter your username/login.";
					$valid_user=false;
				}
			  
			  }
			 }else{
			 	$msg = 'No Results found! Please create a username by selecting the create user button or re submit your username/login';
				//outputLogin();
				$valid_user=false;
			 }
				
		}else{
			$msg = ''; 
			echo "Login incorrect! Please re enter your username/login.";
			$valid_user=false;
		}
		//session_write_close(); Is this necessary?
	}

	


//_________________________________________________________________________//
	function SEFLink($str)
	{
		$result1 =  str_replace('index.php','index',$str);	
		$result1 =  str_replace('?','/',$result1);
		$result1 =  str_replace('=','/',$result1);
		$result1 =  str_replace('&','/',$result1);

		return $result1.'/';
			//http://www.quest-solutions.ca/index.php?page=webpages&menucat=3&id=1&action=displaypage&side=1

			//http://www.quest-solutions.ca/index/page/webpages/menucat/3/id/1/action/displaypage/side/1/
	}
	

?>
