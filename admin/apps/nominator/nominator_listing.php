<p>This listing has been designed to assist you to do a search for Nominators associated with the Edmonton Historical Board. You can search by location, or you can search according to keywords or use both and then click on "View Listing" button.</p>

<?php
	require_once('projectClasses/controller.php');
	$m_applicant = new controllerClass();
	$keywd="";
	$url="index.php?page=nominator_listing";
	if(isset($_GET['pgid']))
	{
		$currpg = $_GET['pgid'];
		
	}else{
		$currpg ="";
	}
	if(isset($_GET['keywd'])){
		$keywd=$_GET['keywd'];
	}else{
		$keywd="";
	}

?>
		<form action="" method="post">
	<table>
		<tr><?php //displayApplicationStatus(); ?>
			<td>Keyword:<br />
			<input name="keywd" type="text" value=""></td>
			<td><br /><input class="btton" name="list_submit" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
		<tr><td><a href="index.php?page=nominator_listing">View All listings</a></td>
		</tr>	
	</table>
    </form>
<?php
		
        if(isset($_POST['list_submit'])){
			if(isset($_POST['keywd'])){	$url.="&keywd=".$_POST['keywd'];}
			$result=$m_applicant->getApplicantByCriteria($_POST,$currpg,$url);
			if ($result !=0)
			{	
				//$rowcount=mysql_num_rows($result);
				//echo $rowcount;
				displayListing($result);
			}else{
				?>
				<p>Your query resulted in 0 rows returned.</p>
<?php			}
		}elseif($keywd !=""){
				$url.="&keywd=".$keywd;
				$array=array('keywd'=>$keywd);
				$result=$m_applicant->getApplicantByCriteria($array,$currpg,$url);
				displayListing($result);
		}else{
			$result=$m_applicant->getAllApplicants($currpg,$url);
			$rowcount=mysql_num_rows($result);
			//echo $rowcount;
			displayListing($result);
		}

function DisplayListing($result){
        ?>        
		<table>
		<tr><th>Nominator</th><th>Application Name</th><th>FOIP</th><th colspan="2">Actions</th></tr>
<?php		
		while ($row = mysql_fetch_array($result))
		{
				$m_applicant = new controllerClass();
				$applications=$m_applicant->getApplicationByNominator($row['pkapplicant_id']);

		?>
			<tr>	    
				<td>
					<?php echo $row['contact_fname']; ?>	&nbsp;&nbsp; <?php echo $row['contact_lname']; ?></a></td>
				<td></td>	 
				<td align="center"><?php echo strtoupper($row['foip']);?></td>
				<td><form name="edit_app" method="post" action="index.php?page=nominator&amp;id=<?php echo $row['pkapplicant_id'];?>"> 
					<input class="btton" type="submit" value="Edit" />
				</form></td>
				<td><form name="create_plaque" method="post" action="index.php?page=application&amp;pid=<?php echo $row['pkapplicant_id'];?>">
					<input class="btton" type="submit"  value="Create Application" />
				</form></td>

			</tr>
	
			<!----------------------------- FOR EACH NOMINATOR GET THE APPLICATIONS THEY'VE PUT IN	 --------------------->	
<?php			if($applications){
					while ($row2 = mysql_fetch_array($applications))
					{
	
	?>
					<tr>
						<td></td>
						<td><?php if (array_key_exists('site_name',$row2)) echo $row2['site_name']; ?></td>	 
						<td align="center"><?php echo strtoupper($row['foip']);?></td>
						<td><form name="edit_app" method="post" action="index.php?page=nominator&amp;id=<?php echo $row['pkapplicant_id'];?>"> 
							<input class="btton" type="submit" value="Edit" />
						</form></td>
						<td><form name="create_plaque" method="post" action="index.php?page=application&amp;id=<?php echo $row2['pkapplication_id'];?>">
							<input class="btton" type="submit"  value="Edit Application" />
						</form></td>
	
					</tr>
<?php				}
				}
		
		}
		?>
		</table>
<?php
}
/*--------------------------------  DISPLAY APPLICATION STATUS --------------------------------------*/
		function displayApplicationStatus()
		{		
		?>	
			<td>Application Status <br />
			<select name="fkapplication_status_ID">
				<option value="">Choose a Status...</option>

<?php			
			$m_application_status = new applicationClass();
			$result=$m_application_status->getApplicationStatus();
			while($row = mysql_fetch_array($result)){
		?>
			
				<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php			
			}
			?>
			</select>
			</td>
<?php
		}
?><html xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882"><head>
<!--[if gte mso 9]><xml>
<mso:CustomDocumentProperties>
<mso:AddDocumentEventProcessedId msdt:dt="string">6402eba2-9ea1-4c65-a5f6-6396eb44cf28</mso:AddDocumentEventProcessedId>
</mso:CustomDocumentProperties>
</xml><![endif]-->
</head>