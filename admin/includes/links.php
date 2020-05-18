
<?php 
if($folder=='')$folder=$page;
   ?>

    <ul id="navlist">
      <li id="active"><a href="index.php?page=application_listing" id="current">Applications</a>
      <?php
	   if(($folder=='application')||($folder=='nominator')){ ?>
	  	<ul id="subnavlist">
			<li id="subactive"><a id="subcurrent" href="index.php?page=nominator">Add Nominator</a></li>
			<li><a href="index.php?page=nominator_listing">Nominator Listing</a></li>
			<li id="subactive"><a id="subcurrent" href="index.php?page=application">Add Application</a></li>			
			<li><a href="index.php?page=application_listing">Application Listing</a></li>
		</ul>
        <?php
		} 
		?>
	  </li>
	  <li><a href="index.php?page=plaque_listing">Plaques</a>
      <?php
	   if(($folder=='plaque') || ($folder=='maintenance')){
		   ?>

	  	<ul id="subnavlist">
			<li id="subactive"><a id="subcurrent" href="index.php?page=plaque">Add Plaque</a></li>
			<li><a href="index.php?page=plaque_listing">Plaque Listing</a></li>
<!--			<li><a href="index.php?page=maintenance_listing">Maintenance Listing</a></li>
-->			<li><a href="index.php?page=maintenance_inspection_listing">Inspection Listing</a></li>
			<li><a href="index.php?page=maintenance_installation_listing">Installation Listing</a></li>
			<li><a href="index.php?page=maintenance_restoration_listing">Restoration Listing</a></li>
		
		</ul>
        <?php
		} 
		?>

	  </li>
	  <li><a href="index.php?page=award_listing">Awards</a>
      <?php
	  	   if($folder=='award'){
		?>

	  	<ul id="subnavlist">
			<li id="subactive"><a id="subcurrent" href="index.php?page=award">Add Award</a></li>
			<li><a href="index.php?page=award_listing">Award Listing</a></li>
<!-- 		<li><a href="index.php?page=award_maintenance_listing">Maintenance Listing</a></li>
 -->
		</ul>
        <?php
		} 
		?>

	  </li>
	  <li><a href="index.php?page=image_listing">Images</a>
      <?php
	  if(($folder=='image')){
	?>
	  	 <ul id="subnavlist">
			<li><a href="index.php?page=image">Add Image</a></li>
			<li><a href="index.php?page=image_add_bulk">Add Image Sets</a></li>
			<li><a href="index.php?page=image_listing">Image Listing</a></li>
		</ul>
        <?php
		} 
		?>

	  </li>
	  <li><a href="index.php?page=landmark_listing">Landmarks</a>
      <?php
	   if(($folder=='landmark') || ($folder=='owner')){
		   ?>
	  	<ul id="subnavlist">
			<li><a href="index.php?page=landmark">Add Landmark</a></li>
			<li><a href="index.php?page=landmark_listing">Landmark Listing</a></li>
			<li><a href="index.php?page=owner">Add Owner</a></li>
			<li><a href="index.php?page=owner_listing">Owner Listing</a></li>
		</ul>
        <?php
		} 
		?>

	  </li>
	  <li><a href="index.php?page=order_listing">Orders</a>
      <?php
	  if(($folder=='order') ||($folder=='vendor')){
		  ?>
	  	<ul id="subnavlist">
			<li id="subactive"><a id="subcurrent" href="index.php?page=order">Add Order</a></li>
			<li><a href="index.php?page=order_listing">Order Listing</a></li>
			<li><a href="index.php?page=vendor">Add Vendor</a></li>
			<li><a href="index.php?page=vendor_listing">Vendor Listing</a></li>
		</ul>
        <?php
		} ?>
	  </li>
      <li><a href="index.php?page=user_listing">Administration</a>
	  	<?php   if(($folder=='user') || ($folder=='tablemanager')){?>
	  	<ul id="subnavlist">
			<li id="subactive"><a id="subcurrent" href="index.php?page=user">Add User</a></li>
			<li><a href="index.php?page=user_listing">User Listing</a></li>
			<li><a href="index.php?page=user_change_password">Change Password</a></li>
			<li><a href="index.php?page=tablemanager_listing">Table Listing</a></li>
		</ul>
        <?php
			} 
			?>
	  </li>
      <li><a href="index.php?page=report_application_status">Reports</a>
	   <?php
       if ($folder=='report'){
		   ?>
	  	<ul id="subnavlist">
			<li id="subactive"><a id="subcurrent" href="index.php?page=report_application_status">Application Status</a></li>
			<li><a href="index.php?page=report_plaque_listing">Plaque Details</a></li>
			<li><a href="index.php?page=report_award_listing">Award Details</a></li>
<!--			<li><a href="index.php?page=report_mfg_status">Manufacturing Status</a></li>
-->		</ul> 
        <?php
		} ?> 
	  </li>
	</ul>
<br clear="all" />
