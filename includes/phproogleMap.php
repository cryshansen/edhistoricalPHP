



<?php

class phproogleMap {

/*
 * @The google api key
 */
private $apiKey;

/*
 * @the map zoom level
 */
private $mapZoom = 8;

/*
 * @The width of the map div
 */
private $mapWidth = 350;

/*
 * @The height of the map div
 */
private $mapHeight = 300;

/*
 * @The map center
 */
private $mapCenter;

/*
 * The array of map types
 */
private $googleMapTypes;

/*
 * @The map type
 */
private $mapType = 'normal';

/*
 * @The array of marker points
 */
private $markerPoints = array();

/*
 * @The array of marker addresses
 */
private $markerAddresses = array();

/*
 * @The maps controls
 */
private $googleMapControls = array();

/*
 * @The ID of the map div
 */
private $mapDivID;

/*
 * The constructor
 *
 * @param apiKey
 *
 * @access public
 *
 * @return void
 *
 */
public function __construct($apiKey=null)
{
    $this->apiKey = is_null( $apiKey ) ? '' : $apiKey;
    /*** set the map types ***/
    $this->setGoogleMapTypes();
}


/*
 *
 * @setter
 *
 * @access public
 *
 */
public function __set( $name, $value )
{
    switch ($name)
    {
        case 'apiKey':
        if(!is_string($value))
        {
            throw new Exception( $name, $value, 'string' );
        }
        $this->$name = $value;
        break;

        case 'mapZoom':
        if(filter_var($value, FILTER_VALIDATE_INT, array("options" => array("min_range"=>0, "max_range"=>19))) == false )
        {
        throw new Exception("$name is out of range");
        }
        $this->$name = $value;
        break;

        case 'mapWidth':
        if( filter_var($value, FILTER_VALIDATE_INT, array("options" => array("min_range"=>100, "max_range"=>900))) == false )
        {
            throw new Exception("$name is out of range for" );
        }
        $this->$name = $value;
        break;

        case 'mapHeight':
        if( filter_var($value, FILTER_VALIDATE_INT, array("options" => array("min_range"=>100, "max_range"=>900))) == false )
        {
            throw new Exception("$name is out of range for" );
        }
        $this->$name = $value;
        break;

        case 'mapType':
        if(!array_key_exists($value, $this->googleMapTypes) )
        {
            throw new Exception("$name is not a valid map type");
        }
        $this->$name = $value;
        break;

        case 'mapDivID':
        if( !is_string($value) )
        {
            throw new Exception( "$name is not a valid ID" );
        }
        $this->$name = $value;
        break;

        case 'mapCenter':
        if( !is_array($value) )
        {
            throw new Exception( "$name is not a valid array" );
        }
        $this->$name = $value;
        break;

        default:
        throw new Exception ( "Invalid Parameter $name" );
    }
}


/*
 *
 * @getter
 *
 * @access public
 *
 */
public function __get( $name )
{
    switch ( $name )
    {
        case 'apiKey':
        return $this->apiKey;
        break;

        case 'mapZoom':
        return $this->mapZoom;
        break;

        case 'mapWidth':
        return $this->mapWidth;
        break;

        case 'mapHeight':
        return $this->mapHeight;
        break;

        case 'mapType':
        return $this->mapType;
        break;

        case 'mapDivID':
        return $this->mapDivID;
        break;

        case 'mapCenter';
        return $this->mapCenter;
        break;
    }
    /*** if we are here, throw an excepton ***/
    throw new Exception( "$name is invalid");
}


/*
 *
 * @isset
 *
 * @access public
 *
 */
public function __isset( $name )
{
    switch ( $name )
    {
        case 'apiKey':
        $this->apiKey = $name;
        break;

        case 'mapZoom':
        $this->mapZoom = $name;
        break;

        case 'mapWidth':
        $this->mapWidth = $name;
        break;

        case 'mapHeight':
        $this->mapHeight = $name;
        break;

        case 'mapType':
        $this->mapType = $name;
        break;

        case 'mapDivID':
        $this->mapDivID = $name;
        break;

        case 'mapCenter';
        $this->mapCenter = $name;
        break;

    default:
    return false;
    }
}


/*
 *
 * @Set the map types
 *
 * @access private
 *
 * @return void
 *
 */
private function setGoogleMapTypes()
{
    $this->googleMapTypes = array('physical'=>'G_PHYSICAL_MAP', 'normal'=>'G_NORMAL_MAP', 'satellite'=>'G_SATELLITE_MAP', 'hybrid'=>'G_HYBRID_MAP' );
}

/*
 *
 * @add to the array of google maps controls
 *
 * @access public
 *
 * @return void
 *
 */
public function addGoogleMapControl($control)
{
    $n = sizeof( $this->googleMapControls );
    $this->googleMapControls[] = $control;
}
/*
 *
 * @get pinpoint marker by address
 *
 * @access public
 *
 * @param string $address
 *
 * @param string $html
 *
 * @return void
 *
 */
public function addMarkerAddress($address, $html)
{
    $s = sizeof( $this->markerAddresses );
    $this->markerAddresses[$s]['address'] = $address;
    $this->markerAddresses[$s]['html']    = $html;
}



/*
 *
 * @get pinpoint mark by latitude or longitude
 *
 * @access public
 *
 * @param string $lat
 *
 * @param string $long
 *
 * @param string $html
 *
 * @return void
 *
 */
public function addMarker($lat, $long, $html)
{
    $pointer = sizeof( $this->markerPoints );
    $this->markerPoints[$pointer]['lat']  = $lat;
    $this->markerPoints[$pointer]['long'] = $long;
    $this->markerPoints[$pointer]['html'] = $html;
}


/*
 *
 * @The javascript for google to connect
 *
 * @access public
 *
 * @return string
 *
 */
public function googleJS()
{
    return '<script src="http://maps.google.com/maps?file=api&v=2&key='.$this->apiKey.'" type="text/javascript"></script>'."\n";
}

private function noJavascript()
{
    return '<noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
    However, it seems JavaScript is either disabled or not supported by your browser. 
    To view Google Maps, enable JavaScript by changing your browser options, and then 
    try again.
    </noscript>';
}


public function drawMap()
{
    $js = '<div id="'.$this->mapDivID.'" style="width: '.$this->mapWidth.'px; height: '.$this->mapHeight.'px"></div>';
    $js .= $this->noJavascript();

    $js .= '
    <script type="text/javascript">
    //<![CDATA[
    
    if (GBrowserIsCompatible()) { 

    geocoder = new GClientGeocoder();

      function createMarker(point,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }

    // Display the map, with some controls and set the initial location 
    var map = new GMap2(document.getElementById("'.$this->mapDivID.'"));'."\n";

    /*** set the map controls here ***/
    if(sizeof($this->googleMapControls) > 0 )
    {
        foreach( $this->googleMapControls as $control )
        {
            $js .= 'map.addControl(new '.$control.'());'."\n";
        }
    }
    /*** set the map center, zooom, and type ***/
    list($lat, $long) = $this->mapCenter;
    $js .='map.setCenter(new GLatLng('.$lat.','.$long.'), '.$this->mapZoom.', '.$this->googleMapTypes[$this->mapType].');'."\n\n";
   

        if(sizeof( $this->markerAddresses ) > 0 )
        {
                foreach( $this->markerAddresses as $add )
                {
                        $base_url = "http://maps.google.com/maps/geo?output=xml" . "&key=" . $this->apiKey;
                        $request_url = file_get_contents($base_url . "&q=" . urlencode($add['address']));
                        $xml = simplexml_load_string($request_url);
                        $status = $xml->Response->Status->code;
                        $point = $xml->Response->Placemark->Point->coordinates;
            list($long, $lat, $d) = explode( ',', $point );
                        $js .= 'var point = new GLatLng('.$lat.','.$long.');'."\n";
                        $js .= "var marker = createMarker(point,'".$add['html']."')"."\n";
                        $js .= 'map.addOverlay(marker);'."\n\n";
                }
        }

 
    /*** set the markers here ***/
     foreach( $this->markerPoints as $data )
    {
        $js .= 'var point = new GLatLng('.$data['lat'].','.$data['long'].');'."\n";
        $js .= "var marker = createMarker(point,'".$data['html']."')"."\n";
        $js .= 'map.addOverlay(marker);'."\n\n";
    }
    $js.='
    GMap.prototype.centerAndZoomOnBounds = function(bounds) {
    // make 10% bigger so all markers show completely
    var span = new GSize((bounds.maxX - bounds.minX) * 1.1, (bounds.maxY - bounds.minY)*1.1);
    var center = new GPoint(bounds.minX + span.width / 2., bounds.minY + span.height / 2.);

    var newZoom = this.spec.getLowestZoomLevel(center, span, this.viewSize);
      if (this.getZoomLevel() != newZoom) {
        this.centerAndZoom(center, newZoom);
      } else {
        this.recenterOrPanToLatLng(center);
      }
    }
    
    // display a warning if the browser was not compatible
    } else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

    //]]>
    </script>';

   return $js;

}

}/*** end of class ***/


try
{
    /*** a new phproogle instance ***/
    $map = new phproogleMap();

    /*** the google api key ***/
    $map->apiKey = 'YOUR_GOOGLE_API_KEY';

    /*** zoom is 0 - 19 ***/
    $map->mapZoom    = 10;

    /*** the map width ***/
    $map->mapWidth   = 500;

    /*** the map height ***/
    $map->mapHeight  = 400;

    /*** set the map type ***/
    $map->mapType = 'normal';

    /*** set the map center ***/
    //$map->mapCenter = array(-33.862828, 151.216974);

    /*** add some markers with latitude and longitude  ***/
    $map->addMarker(-33.858362, 151.214876, '<h2>Sydney Opera House</h2><p>For those with culture</p>');
    $map->addMarker(-33.862828,151.216974, '<h3>Royal Botanic Gardens</h2><a href="http://phpro.org">A link here</a>');


    /*** add some controls ***/
    $map->addGoogleMapControl('GMapTypeControl');
    $map->addGoogleMapControl('GSmallMapControl');
    $map->addGoogleMapControl('GOverviewMapControl');

    /*** add some marker addresses ***/
    $map->addMarkerAddress('2 Pitt St Sydney NSW Australia', '<h2>Head Office</h2>');
    $map->addMarkerAddress('122 Pitt St Sydney NSW Australia', '<h2>The Factory</h2>');

    /*** set the map div id ***/
    $map->mapDivID = 'map';
}
catch( Exception $e )
{
    echo $e->getMessage();
}
?>
