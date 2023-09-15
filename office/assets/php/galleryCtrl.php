<?php

$albums = array();
$sql = "SELECT * FROM photo_gallery";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_array()){
        $id = $row['id'];			
        $photo_name = $row['photo_name'];		
        $tag_name = $row['tag_name'];

        $album = new stdClass();			
        $album->id = $id;			
        $album->photo_name = $photo_name;
        $album->tag_name = $tag_name;

        array_push($albums, $album);
    }
}
//$mysqli->close();
?>