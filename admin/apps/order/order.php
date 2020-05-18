<p> Plaque / Award Name: <?php echo "Al Rashid Mosque"; ?></p>

		
	<form name="applicant" method="post" action="" ><!--index.php?action=applicant-->
				<fieldset>
				<legend>Order</legend>
					<table>
						<td>
						<div>Date:<br />
						<input onclick='ds_sh(this);' name='app_date' readonly='readonly' style='cursor: text' value=""/></div>
						</td>

						<td>
						</td>
						<td>type:<br />
							<select name="">
								<option>choose a type...</option>
								<option value="" selected="selected">Manufacturing</option>
								<option value="">Printing</option> 
								<option value="">Retoration</option> 
								<option value="">Installation</option> 
								<option value="">Inspection</option>
							</select>
						  </td>
					</tr>
					<tr>
						<td colspan="2">Comments:<br />
						<textarea name="" cols="40" rows="6"></textarea></td>
						<td>
						<div><br />
						</div></td>
					</tr>
				</table>						
				<table>
					<th colspan="3" align="left">Vendor:</th>
					<tr>
						<td>
							<select name="">
								<option>choose a vendor...</option>
								<option value="" selected="selected">Joe's Plaques Manufacturing</option>
								<option value="">Capital Plaques Manufacturing</option> 
							</select>

						</td>
					</tr>
					<tr>
						<td>Address:<br /> 89 Hill Street </td>
						<td>Contact Name:<br /> George Strait &nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>Phone:<br /> 780-567-3454</td>
					</tr>
				</table>
					
				</fieldset>
					<input class="btton" type="submit" value="Submit" name="submit_app" />
			</form>
