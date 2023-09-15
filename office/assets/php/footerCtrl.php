<?php

$about_us = "We are trying to increase the Reader. Book Lovers";

//Social Media
$socials = [
    "instagram" => "https://www.instagram.com/glocalcharcha/",
    "twitter" => "https://twitter.com/GloCalCharcha",
    "facebook" => "https://www.facebook.com/charcha.glocal",
    "linkedin" => "",
    "pinterest" => "",
    "dribbble" => "",
];

//Get popular post
$recent_posts = array();

$sql5 = "SELECT category_list.category_id, category_list.category_name, category_list.category_slug, author_details.author_id, author_details.author_name, post_manager.post_id, post_manager.post_title, post_manager.post_description, post_manager.post_image, post_manager.post_video, post_manager.post_tags, post_manager.activity_status, post_manager.created_on FROM post_manager JOIN category_list ON category_list.category_id = post_manager.category_id JOIN author_details ON author_details.author_id = post_manager.author_id WHERE author_details.author_status = 'active' AND category_list.activity_status = 'active' AND  post_manager.activity_status = 'active' ORDER BY post_manager.created_on DESC LIMIT 3 ";
$result5 = $mysqli->query($sql5);

if ($result5->num_rows > 0) {
    while($row5 = $result5->fetch_array()){
        $post_id5 = $row5['post_id'];		
        $post_title5 = $row5['post_title'];	
        $post_image5 = $row5['post_image'];		
        $created_on5 = $row5['created_on'];	

        $recent_post = new stdClass();			
        $recent_post->post_id = $post_id5;
        $recent_post->post_title = $post_title5;
        $recent_post->post_image = $post_image5;
        $recent_post->created_on = $created_on5;

        array_push($recent_posts, $recent_post);
    }
}

?>