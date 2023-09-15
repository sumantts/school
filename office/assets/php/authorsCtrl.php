<?php

$author_text = 'Our Authors are our assets.';

$authors = array();
$sql = "SELECT * FROM author_details WHERE author_status = 'active' ";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_array()){
        $author_id = $row['author_id'];			
        $author_name = $row['author_name'];		
        $author_bio = $row['author_bio'];	
        $author_photo = $row['author_photo'];
        $facebook_link = $row['facebook_link'];
        $linkedin_link = $row['linkedin_link'];
        $instagram_link = $row['instagram_link'];

        $author = new stdClass();			
        $author->author_id = $author_id;			
        $author->author_name = $author_name;
        $author->author_bio = $author_bio;
        $author->author_photo = $author_photo;
        $author->facebook_link = $facebook_link;
        $author->linkedin_link = $linkedin_link;
        $author->instagram_link = $instagram_link;

        array_push($authors, $author);
    }
}

?>