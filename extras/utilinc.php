<?php
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
	
	function get_countryname_from_ip($user_ip)
	{
		global $gekko_db;
    	$sql  = "SELECT * FROM country_info WHERE inet_aton('$user_ip') >= ip_from AND inet_aton('$user_ip') <= ip_to";
		$gekko_db->query($sql);
		$items  = $gekko_db->get_result_as_array();
		if ($items) return $items[0]['COUNTRY_NAME']; else return false;
	}
	
	function get_blogitems_by_virtualfilename($name)
	{
		global $gekko_db;
		$sql = "SELECT content_items.id,title, content_items.summary, content_items.date_created, content_items.date_available, content_items.date_expiry FROM content_items INNER JOIN content_categories ON content_items.category_id = content_categories.id WHERE content_categories.virtual_filename='{$name}' AND content_categories.id = content_items.category_id ORDER BY DATE_AVAILABLE DESC";
		$gekko_db->query($sql);
		$items  = $gekko_db->get_result_as_array();
		if ($items) return $items; else return false;
	
	}
	
	function get_blogcategorytitle_by_virtualfilename($vname)
	{
		global $gekko_db;
		$sql = "SELECT name from content_categories where virtual_filename='{$vname}'";
		$gekko_db->query($sql);
		$items  = $gekko_db->get_result_as_array();
		if ($items) return $items[0]['name']; else return false;
	}
	

	function get_singlepage_by_virtualfilename($name)
	{
		global $gekko_db;
		
		$sql = "SELECT id,title, summary FROM content_items where virtual_filename='{$name}'";
		$gekko_db->query($sql);
		$items  = $gekko_db->get_result_as_array();
		if ($items) return $items[0]; else return false;
	
	}
	function verify_email_dns($email){
	
		// This will split the email into its front
		// and back (the domain) portions
		global $site_template;
		
		if ($email== '') return false;
		if ($_SERVER['SERVER_NAME']==$site_template) return  $email;
		
		list($name, $domain) = split('@',$email);
	
		if(!checkdnsrr($domain,'MX')){
	
			// No MX record found
			return false;
	
		} else {
	
			// MX record found, return email
			return $email;
	
		}
	}
	
	//_________________________________________________________________________//
	function getVarFromPOST($array)
	{
			return array_intersect_key($_POST,$array);
	}
	//_________________________________________________________________________//    	
	function redirect_to($url)
	{
		ob_end_clean();
		ob_start();
		header("Location: {$url}");
	}	
	
	//_________________________________________________________________________//
	function createDataArray(/*..... */) 
	// Creates array key
	{
		$arg_list = func_get_args();
		$my_array = array();
		foreach ($arg_list as $arg) $my_array[$arg]=NULL;
		return $my_array;
	}
	//_________________________________________________________________________//
	function createNewInsertData($var_array)
    { // Omits the ID for INSERT INTO SQL statement (autonumbering)
		return array_slice($var_array,1,sizeof($var_array)-1);
    }
	//_________________________________________________________________________//
	function sanitizeString($value)
	{
		if (get_magic_quotes_gpc()) $value = stripslashes($value);
		if (!is_numeric($value)) $value = "'" . mysql_real_escape_string($value) . "'";
		return $value;
	}
	//_________________________________________________________________________//
	function InsertSQL($array)
	{
		$string = '(';
		$keys = array_keys($array);
		foreach($keys as $key)
		{
			$string.= $key.', ';
		}
		$string = substr($string,0,strlen($string)-2); // take out the last comma
		$string.= ') VALUES (';
		foreach($keys as $key)
		{
			$string.= sanitizeString($array[$key]).', ';
		}
		$string = substr($string,0,strlen($string)-2); // take out the last comma
		$string.= ')';
		return $string;
	}
	//_________________________________________________________________________//
	function UpdateSQL($array)
	{
		$string = '';
		$keys = array_keys($array);
		foreach($keys as $key)
		{
			if ($key != 'id') $string.= $key.'='.sanitizeString($array[$key]).', ';
		}
		$string = substr($string,0,strlen($string)-2); // take out the last comma
		return $string;
	}
//____________________________________________________________________//
	
	function includemodule($s)
	{
		include($s);
	}
//____________________________________________________________________//

function generatePassword($length=6, $strength=0) {
    $vowels = 'aieouy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1) {
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength & 2) {
        $vowels .= "AEUY";
    }
    if ($strength & 4) {
        $consonants .= '23456789';
    }
    if ($strength & 8) {
        $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}

//____________________________________________________________________//


if ( !function_exists('json_decode') ){
    function json_decode($content, $assoc=false){
                require_once 'Services/JSON.php';
                if ( $assoc ){
                    $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        } else {
                    $json = new Services_JSON;
                }
        return $json->decode($content);
    }
}

if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}

	
?>
