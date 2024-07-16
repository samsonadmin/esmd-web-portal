<?php

header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Accept-Encoding: gzip;q=0,deflate,sdch');
header('Content-type: application/json');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');

// Path to the text file
$file_path = "zoning.json";

// Load the contents of the file into a variable
$file_contents = file_get_contents($file_path);

// Output the contents of the file


include 'global-functions.php';
include 'cms_auth.php';

if ($_SESSION['access'] !== "admin")
{
  $error = array (
    "success" => "false",
    "error" => "not login, please login again"
  ) ;
  echo json_encode($error);
  die;
}

$debug = false;
if ( isset($_REQUEST['debug']))
{
    $debug = true;
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    if($debug)  echo "DEBUG MODE = ON\n\n";

}

// Define the callback function
function convertToFloat($value) {
    $value = (float) $value;
}

if (isset($_POST['serial_no']) and isset($_POST['zone_name']) and isset($_POST['zone_color']) )
{

    $is_delete_action = false;
    if (isset($_POST['action']))
        if ($_POST['action'] == 'delete' )
            $is_delete_action = true;


    $serial_no = preg_replace("/[^a-zA-Z0-9\-\_]/", "", $_POST['serial_no']);
    $zone_name = preg_replace("/[^a-zA-Z0-9\_]/", "", $_POST['zone_name']);
    $zone_color = mb_strtoupper($_POST['zone_color']);

    $points = array();
    if ( isset ( $_POST['points']))
        $points = $_POST['points'];

    // Apply the callback function to each element of the array
    array_walk($points, 'convertToFloat');
    if($debug) print_r($points);

    if ( $zone_name == "" )
    {
        echo json_encode( array( "error" => "zone name empty!"  ));  
        die;
    }

    // Decode the JSON string into a PHP object
    $zone_data = json_decode($file_contents, true);

    //print_r($zone_data);

    $array_serial_no = array_column($zone_data, 'serial_no');
    //print_r($array_serial_no);

    $found_serial_no = array_search($serial_no, $array_serial_no);

    

    // Check if the serial_no exists in the array
    if ( $found_serial_no !== false) 
    {
        if($debug)  echo "serial: ${serial_no} is found \n";
        

        $inner_array_zone_name = array_column($zone_data[$found_serial_no]['zones'], 'name');
        $found_inner_zone_name = array_search($zone_name, $inner_array_zone_name);

        if($debug)  print_r($inner_array_zone_name);

        if ( $found_inner_zone_name !== false)
        {

            if($debug)  echo "zone_name: ${zone_name} is found \n";
        
            if ($is_delete_action)
            {
                array_splice($zone_data[$found_serial_no]['zones'], $found_inner_zone_name);
                echo json_encode( array( "success" => "zone :". $zone_name . " delete"  ));
            }
            elseif( count($points) )
            {
                $zone_data[$found_serial_no]['zones'][$found_inner_zone_name]['points'] = $points;
                echo json_encode( array( "success" => "zone :". $zone_name . " points updated"  ));
            } 
            else
            {
                echo json_encode( array( "error" => "zone name repeated"  ));  
                die;    
            }

        }
        else
        {
            if($debug)  echo "zone_name: ${zone_name} is NOT found \n";

            if ($is_delete_action)
            {            
                echo json_encode( array( "error" => "zone name not found!"  ));  
                die;  
            }            
            else
            {
                $zone_data[$found_serial_no]['zones'][] = array(
                    'name' => $zone_name,
                    'color' => array("#FFAF8770", "#FF8B72", $zone_color),
                    'points' => $points             
                );

                echo json_encode( array( "success" => "zone: ".$zone_name . " points updated."  ));  
            }
        }

        //print_r($zone_data);

    } else {


        if($debug)  echo "serial is not found";
        // Append the new serial_no and zone to the array
        
        if ($is_delete_action) 
        {
            echo json_encode( array( "error" => "serial no found!"  ));  
            die;    
        }
        else
        {
            $zone_data[] = array(
                "serial_no" => $serial_no,
                "zones" => array(
                    array(
                        'name' => $zone_name,
                        'color' => array("#FFAF8770", "#FF8B72", $zone_color),
                        'points' => array()
                    )
                )
            );

            echo json_encode( array( "success" => "zone: ".$zone_name . " created."  ));  
        }


        
    }

    if($debug)  print_r($zone_data);

    file_put_contents($file_path, json_encode($zone_data, JSON_PRETTY_PRINT) ) ;

    
    die;

}
else
{


    echo $file_contents;
}
?>