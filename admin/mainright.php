<div class="mainright">
	<div id="r_content">
	<?php
		if(isset($_SESSION['username'])){
				include('includes/links.php');
		}else{
	?>
		
			<p> The Edmonton Historical Board Award and Plaque System offers detailed mapping of the application process.</p>
			<br />
			<br />
			<hr />
			<p>For more information:</p>
			<table>
				<tr><td colspan="2">Prince of Wales Armouries Heritage Centre<br />
						<p>Located South of Royal Alexandra Hospital, just West of Victoria School of Performing and Visual Arts</p></td>
				</tr>
			
				<tr><td></td>
					<td>10440 108 Avenue<br />
				 	Edmonton AB  T5H 3Z9</td>
				</tr>
				<tr><td>Hours:</td>
					<td>Mon, Tues, Thurs, and Fri: 8:30am-4:30pm Wed: 8:30am-8pm</td>
				</tr>
				<tr><td>Telephone </td>	
					<td>In Edmonton: 311<br />
						Outside Edmonton: 780-442-5311<br />
						Fax 	780-496-8732<br />
						Email 	cms.archives@edmonton.ca</td>
				</tr>
			</table>

	<?php	
		}
	?>
	</div>
</div>
