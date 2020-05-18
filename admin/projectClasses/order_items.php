<?php
require_once("conn_function.php");
require_once("sql.php");

class orderItemsClass{
var $m_Order_items;

		//constructor
		 function orderItemsClass()
		 {
		 	$this->m_Order_items=array('pkorderitem_id'=>"",'oi_product_id'=>"",'oi_product_type'=>"",'product_filled'=>"",'oi_desc'=>"",  'fkorder_id'=>"");
		 }
		  
		//ADD or create
		function createorderItems($vars)  {
			$id='pkorderitem_id';
				$sql = "pkorderitem_id "; 
				$sql .=InsertSQL($vars,$id);
				$result = getconn($sql);
				return $result;
		}
		
		//UPDATE
		function updateorderItems($vars){
				$id='pkorderitem_id';
				$sql="UPDATE tblorderitems SET ";
				$sql.=UpdateSQL($vars,$id);
				$sql .=" where ".$id."=".$vars[$id];
				$result = getconn($sql);
				return $result; 
		 }
		 
		//getAllInspection
		function getAllorderItems()  {
		
				$sql="Select * from tblorderitems";  
				$result=getconn($sql);
				return $result;
		}
		
		function getOrderItemById($id)  {
				$sql="Select * from tblorderitems WHERE pkorderitem_id=".$id;
				$result=getconn($sql);  
				return $result;  		
		}
		function getOrderItem()
		{
			return $this->m_Order_items;
		}

}
?>