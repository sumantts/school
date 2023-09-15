<?php
//Services	
$services_text = 'We are providing below services.';

$portfollios = array();
$sql = "SELECT * FROM service_manager";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_array()){
        $service_id = $row['service_id'];			
        $name = $row['name'];		
        $description = $row['description'];	
        $services_photo = $row['services_photo'];

        $service = new stdClass();			
        $service->service_id = $service_id;			
        $service->name = $name;
        $service->description = $description;
        $service->services_photo = $services_photo;

        array_push($portfollios, $service);
    }
}
//$mysqli->close();
?>