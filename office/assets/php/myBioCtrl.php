<?php

//$author_text = 'Our Authors are our assets.';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM author_details WHERE author_id = '" .$id. "' ";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_array();
        $author_id = $row['author_id'];			
        $author_name = $row['author_name'];		
        $author_bio = $row['author_bio'];	
        $author_photo = $row['author_photo'];        
    }
    
}
?>