<?php

//Get popular post
$popu_posts = array();

$sql4 = "SELECT * FROM post_manager ORDER BY post_id DESC LIMIT 0, 50";
$result4 = $mysqli->query($sql4);

if ($result4->num_rows > 0) {
    while($row4 = $result4->fetch_array()){
        $post_id = $row4['post_id'];		
        $post_title = $row4['post_title'];		
        $post_description = $row4['post_description'];		
        $created_on = $row4['created_on'];	

        $pop_post = new stdClass();			
        $pop_post->post_id = $post_id;
        $pop_post->post_title = $post_title;
        $pop_post->post_description = $post_description;
        $pop_post->created_on = $created_on;

        array_push($popu_posts, $pop_post);
    }
}




?>