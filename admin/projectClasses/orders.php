<?php
require_once("conn_function.php");
require_once("sql.php");
require_once("order_items.php");

//there are more comments after this line
class OrderClass 
{ //the opening chicken lip :o
	
	
	var $m_Order;
	
	//begin the function coding
	function OrderClass()
	{//these are the variables being passed to the table
		$this->m_Order = array('pkorder_id'=>"", 'order_comments'=>"", 'order_po'=>"", 'order_date'=>"", 'fkorder_type'=>"",'order_filled'=>"", 'fkplaque_id'=>"", 'fkvendor_id'=>"");

	}
	
	
	//create the order
		
	function createOrder($vars)
	{
		
		$m_order_item= new orderItemsClass();
		$order_vars =  array_intersect_key($post_vars,$m_Order);
		$order_item_vars =  array_intersect_key($post_vars,$m_order_item);
		if($order_item_vars['pkorderitem_id'] =='new'){
			$results=$m_order_item->createorderItems($order_item_vars);
		}else{
			$results=$m_order_item->updateorderItems($order_item_vars);
		}
					if($results){
			//return last value
				if($order_vars['pkorder_id'] =='new'){
					$order_id=$m_order_item->getLastOrderId();
					echo "The Order Id is: " .$order_id;
					$order_item_vars['fkorder_item_id'] = $order_item_id;
					$id='pkorder_id';
					//insert into application
					$sql =" Insert into tblorder";
					$sql .=InsertSQL($order_vars,$id);
					//echo $sql;
					$result = getconn($sql);
					if(($result)&& ($hist_vars['hist_comments']!='')){
						$application_id=$this->getLastApplicationId();
						echo "The application ID is:".$application_id;
						$m_history= new applicationHIstoryClass();
						$m_history->addHistoryComments($hist_vars['hist_comments'],$application_id);
					}

				}else{
					//set the applicant foreign key in array
					$application_vars['fkapplicant_id'] = $applicant_vars['pkapplicant_id'];
					
					$id='pkapplication_id';
					//insert into application
					$sql =" Insert into  tblapplication";
					$sql .=InsertSQL($application_vars,$id);
					echo $sql;
					$result = getconn($sql);
					if(($result)&& ($hist_vars['hist_comments']!='')){
						$application_id=$this->getLastApplicationId();
						$m_history= new applicationHIstoryClass();
						$m_history->addHistoryComments($hist_vars['hist_comments'],$application_id);
					}
				}
			}else{
				$result='nogood';
			}
		
		//define the array key for primary key		
		$id='pkorder_id';		
		//create initial sql call		
		$sql = "INSERT INTO tblorder "; 		
		//concatenate and call sql function from sql.php pass in the vars from post and the id defined above.		
		$sql .=InsertSQL($vars,$id);		
		// call getconn function defined in conn_function .php your mysql database 
		$result = getconn($sql);		
		//return the success or failure		
		return $result;	
	}
	
	//start the updateorder for the order updating
	function updateOrder($vars)
	{
		//define the array key for primary key		
		$id='pkOrder_id';		
		//create initial sql call to do the order updating	
		$sql = "Update tblorder SET "; 		
		//concatenate and call sql function from sql.php pass in the vars from post and the id defined above.		
		$sql .=UpdateSQL($vars,$id);
		// make sure the the pkOrder_id sent in the array matches the id in the table
		$sql .= " where ".$id."=".$vars[$id];
		//use the echo to view the values being passed to the table
		echo $sql;
		// call getconn function defined in conn_function .php your mysql database 		
		$result = getconn($sql);		
		//return the success or failure		
		return $result;
	}
	
	function getAllOrders()
	{
		//start the query
		$sql="Select * from tblorder";
		//collect the results of the query
		$result=getconn($sql);
		//send the results to display
		return $results;
	}

	//Get the order by order id
	function GetOrderByOrderId($id)
	{
		//make the select call to the table
		$sql="Select * from tblorder where pkorder_id =".$id;
		//collect the results from the query
		$result=getconn($sql);
		//send the results to the display page
		return $result;
	}
	//getter
	function getOrder()
	{
		return $this->m_Order;
	}
	
} //the closing chicken lip :o
?>