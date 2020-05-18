<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php
$lat=53.5472222;
$long=-112.505555;
//		$value= $dLt + $mLt/60 + $sLt/3600;
//		echo "Value is:".$value.$dLt;
//		//return $value;
//		
//		$value= -$dLg + $mLg/60 + $sLg/3600;
//		echo "Value is:".$value;
		//return -$value;
 # You have decimal degrees (-73.9874°) instead of degrees, minutes, and seconds (-73° 59’ 14.64")
  # The whole units of degrees will remain the same (-73.9874° longitude, start with 73°)
  # Multiply the decimal by 60 (0.9874 * 60 = 59.244)
  # The whole number becomes the minutes (59’)
  # Take the remaining decimal and multiply by 60. (0.244 * 60 = 14.64)
  # The resulting number becomes the seconds (14.64"). Seconds can remain as a decimal.
  # Take your three sets of numbers and put them together, using the symbols for degrees (°), minutes (’), and seconds (") (-73° 59’ 14.64" longitude)



# The whole units of degrees will remain the same (-73.9874° longitude, start with 73°)
$deg=substr($long,0,4);
echo "The Degree is:".$deg;	
  # Multiply the decimal by 60 (0.9874 * 60 = 59.244)	
$min = substr($long,4);
echo "The Min is:".$min;
$min = $min * 60;
echo "The Min is:".$min;
$sec = substr($min,2);

//$min * 60;
  # The whole number becomes the minutes (59’)
$min = floor($min);
echo "The Min is:".$min;

# Take the remaining decimal and multiply by 60. (0.244 * 60 = 14.64)
echo "The seconds are:".$sec;

$sec=$sec *60;
 # The resulting number becomes the seconds (14.64"). Seconds can remain as a decimal.
echo "The seconds are:" . $sec;



?>
 <input type="text"  name="dLg" value="<?php echo $deg; ?>" size="3" maxlength="3">deg 
 <input type="text"  name="mLg" value="<?php echo $min; ?>" size="2" maxlength="3">min 
 <input type="text"  name="sLg" value="<?php echo $sec; ?>" size="5" maxlength="5" >sec
 <?php
 $latdeg=substr($lat,0,2);
 echo "The LatDegree is:".$latdeg;	

 $latmin = substr($lat,2);
 echo "The LatMin is:".$latmin;
$latmin = $latmin * 60;
echo "The LatMin is:".$latmin;
$latsec = substr($latmin,2);
$latmin=floor($latmin);
echo "The LatMin is:".$latmin;
echo "The lat seconds are:".$latsec;

$latsec=$latsec *60;
echo "The latseconds are:" . $latsec;?>
 <input type="text"  name="dLt" value="<?php echo $latdeg; ?>" size="3" maxlength="3">deg 
 <input type="text"  name="mLt" value="<?php echo $latmin; ?>" size="2" maxlength="3">min 
 <input type="text"  name="sLt" value="<?php echo $latsec; ?>" size="5" maxlength="5" >sec



</body>
</html>
