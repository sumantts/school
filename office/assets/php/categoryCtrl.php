<?php

$categories_data = array();

$sql = "SELECT category_list.category_id, category_list.category_name, category_list.category_slug, author_details.author_id, author_details.author_name, author_details.author_bio, author_details.author_photo, post_manager.post_id, post_manager.post_title, post_manager.post_description, post_manager.post_image, post_manager.post_video, post_manager.post_tags, post_manager.activity_status, post_manager.created_on FROM post_manager JOIN category_list ON category_list.category_id = post_manager.category_id JOIN author_details ON author_details.author_id = post_manager.author_id WHERE author_details.author_status = 'active' AND category_list.activity_status = 'active' AND  post_manager.activity_status = 'active' ";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_array()){
        $post_id = $row['post_id'];			
        $category_name = $row['category_name'];		
        $author_name = $row['author_name'];		
        $post_title = $row['post_title'];		
        $post_description = $row['post_description'];	
        $post_image = $row['post_image'];	
        $post_video = $row['post_video'];		
        $post_tags = $row['post_tags'];		
        $created_on = $row['created_on'];		
        $activity_status = $row['activity_status'];		
        $author_name = $row['author_name'];		
        $post_description1 = substr($post_description, 0, 100);

        $post = new stdClass();			
        $post->post_id = $post_id;			
        $post->category_name = $category_name;
        $post->author_name = $author_name;
        $post->post_title = $post_title;
        $post->post_description = $post_description1;
        $post->post_image = $post_image;
        $post->post_video = $post_video;
        $post->post_tags = $post_tags;
        $post->created_on = date('jS. F, Y', strtotime($created_on));

        array_push($categories_data, $post);
    }
}

//Get All Category Name
$return_array = array();
$status = true;
$categories = array();

function getCategoryCoun($category_id, $mysqli){
    $sql = "SELECT * FROM post_manager WHERE category_id = '" .$category_id. "' ";
    $result = $mysqli->query($sql);
    $num_rows = $result->num_rows;

    return $num_rows;
}//end 

$sql = "SELECT * FROM category_list WHERE activity_status = 'active' ORDER BY category_name ASC";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $status = true;
    $slno = 1;
    while($row = $result->fetch_array()){
        $category_id = $row['category_id'];	
        $category_name = $row['category_name'];			
        $category_slug = $row['category_slug'];
        $data = new stdClass();

        $data->category_id = $category_id;
        $data->category_name = $category_name;
        $data->category_slug = $category_slug;
        $data->category_post_count = getCategoryCoun($category_id, $mysqli);
        
        array_push($categories, $data);
        $slno++;
    }
} else {
    $status = false;
}

//Get popular post
$popu_posts = array();

$sql4 = "SELECT category_list.category_id, category_list.category_name, category_list.category_slug, author_details.author_id, author_details.author_name, post_manager.post_id, post_manager.post_title, post_manager.post_description, post_manager.post_image, post_manager.post_video, post_manager.post_tags, post_manager.activity_status, post_manager.created_on FROM post_manager JOIN category_list ON category_list.category_id = post_manager.category_id JOIN author_details ON author_details.author_id = post_manager.author_id WHERE author_details.author_status = 'active' AND category_list.activity_status = 'active' AND  post_manager.activity_status = 'active' ORDER BY RAND() LIMIT 3 ";
$result4 = $mysqli->query($sql4);

if ($result4->num_rows > 0) {
    while($row4 = $result4->fetch_array()){
        $post_id4 = $row4['post_id'];		
        $post_title4 = $row4['post_title'];	
        $post_image4 = $row4['post_image'];		
        $created_on4 = $row4['created_on'];	

        $pop_post = new stdClass();			
        $pop_post->post_id = $post_id4;
        $pop_post->post_title = $post_title4;
        $pop_post->post_image = $post_image4;
        $pop_post->created_on = $created_on4;

        array_push($popu_posts, $pop_post);
    }
}

//Get all tags
$all_tags = array();
$filtered_tags = array();

$sql2 = "SELECT category_list.category_id, category_list.category_name, category_list.category_slug, author_details.author_id, author_details.author_name, post_manager.post_id, post_manager.post_title, post_manager.post_description, post_manager.post_image, post_manager.post_video, post_manager.post_tags, post_manager.activity_status, post_manager.created_on FROM post_manager JOIN category_list ON category_list.category_id = post_manager.category_id JOIN author_details ON author_details.author_id = post_manager.author_id WHERE author_details.author_status = 'active' AND category_list.activity_status = 'active' AND  post_manager.activity_status = 'active' AND category_list.category_slug = '".$p."'";
$result2 = $mysqli->query($sql2);

if ($result2->num_rows > 0) {
    while($row2 = $result2->fetch_array()){
        $post_id = $row2['post_id'];		
        $post_tags = $row2['post_tags'];		
        $category_slug_1 = $row2['category_slug'];		
        
        if($post_tags != ''){
            $single_tag = new stdClass();
            $single_tag->post_id = $post_id;
            $single_tag->tag_name = $post_tags;
            $single_tag->category_slug = $category_slug_1;
            array_push($all_tags, $single_tag);
        }
    }
}

if(sizeof($all_tags) > 0){
    for($x = 0; $x < sizeof($all_tags); $x++){
        $post_id = $all_tags[$x]->post_id;
        $tag_name = $all_tags[$x]->tag_name;
        $category_slug = $all_tags[$x]->category_slug;

        $tag_array = explode(",", $tag_name);
        foreach($tag_array as $val){
            $filtered_tag = new stdClass();
            //echo ' '.$val;
            $filtered_tag->post_id = $post_id;
            $filtered_tag->category_slug = $category_slug;
            $filtered_tag->post_tag_n = $val;
            array_push($filtered_tags, $filtered_tag);
        }
        //echo $tag_name;
    }//end for
}//end if


?>