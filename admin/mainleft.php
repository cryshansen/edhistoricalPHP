<div class="mainleft">
	<div class="innerleft">
<?php
global $results;
global $result;
global $page;
global $folder;
if(isset($_SESSION['username'])){
	if(empty($_GET['page'])){
		include('start_page.php');
	}else{ 
		$page=$_GET['page'];
		$place_underscore=stripos($page,"_"); 
		$folder=substr($page,0,$place_underscore);
			if($folder==''){
				$page_name="apps/".$page."/".$page.".php";
			}else{
				$page_name="apps/".$folder."/".$page.".php";
			}
?>

			<h3> <?php echo ucwords(str_replace('_', ' ', $page)); ?> </h3>
<?php
			include($page_name);
	}
}elseif(isset($_GET['page'])== 'user_forgot_password'){	
include('user_forgot_password.php');
}else{
	include('start_page.php');
}
?>

	</div>
	<br clear="all" />
</div>