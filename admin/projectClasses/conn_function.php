<?php 
global $results;
 function getConn($sql)
      {
        
		//Home
		 $dbh = mysql_connect( "localhost", "root", "root" );
		 //school
		//$dbh = mysql_connect( "localhost", "root", "root" );
		 mysql_select_db( "edmhistorical" ) or die ( mysql_error() . "\n" );
		 $results = mysql_query( $sql, $dbh );
		 return $results;
		  
      }
	  
?>

		