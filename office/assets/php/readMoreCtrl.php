<?php

$posts_adda = array();
$pi = $_GET['pi'];

$sql = "SELECT category_list.category_id, category_list.category_name, category_list.category_slug, author_details.author_id, author_details.author_name, author_details.author_bio, author_details.author_photo, author_details.facebook_link, author_details.linkedin_link, author_details.instagram_link, post_manager.post_id, post_manager.post_title, post_manager.post_description, post_manager.post_image, post_manager.post_video, post_manager.post_tags, post_manager.activity_status, post_manager.created_on FROM post_manager JOIN category_list ON category_list.category_id = post_manager.category_id JOIN author_details ON author_details.author_id = post_manager.author_id WHERE author_details.author_status = 'active' AND category_list.activity_status = 'active' AND  post_manager.activity_status = 'active' AND post_manager.post_id = $pi ";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_array();
    $post_id = $row['post_id'];			
    $category_name = $row['category_name'];				
    $category_slug1 = $row['category_slug'];		
    $author_id = $row['author_id'];				
    $author_name = $row['author_name'];			
    $author_bio = $row['author_bio'];			
    $author_photo = $row['author_photo'];			
    $facebook_link = $row['facebook_link'];			
    $linkedin_link = $row['linkedin_link'];			
    $instagram_link = $row['instagram_link'];	
    $post_title = $row['post_title'];		
    $post_description = $row['post_description'];	
    $post_image = $row['post_image'];	
    $post_video = $row['post_video'];		
    $post_tags = $row['post_tags'];		
    $created_on = date('jS. F, Y', strtotime($row['created_on']));		
    $activity_status = $row['activity_status'];	   
    
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

$sql4 = "SELECT category_list.category_id, category_list.category_name, category_list.category_slug, author_details.author_id, author_details.author_name, post_manager.post_id, post_manager.post_title, post_manager.post_description, post_manager.post_image, post_manager.post_video, post_manager.post_tags, post_manager.activity_status, post_manager.created_on FROM post_manager JOIN category_list ON category_list.category_id = post_manager.category_id JOIN author_details ON author_details.author_id = post_manager.author_id WHERE author_details.author_status = 'active' AND category_list.activity_status = 'active' AND  post_manager.activity_status = 'active' AND category_list.category_slug = '".$category_slug1."' ORDER BY RAND() LIMIT 3 ";
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

$sql2 = "SELECT category_list.category_id, category_list.category_name, category_list.category_slug, author_details.author_id, author_details.author_name, post_manager.post_id, post_manager.post_title, post_manager.post_description, post_manager.post_image, post_manager.post_video, post_manager.post_tags, post_manager.activity_status, post_manager.created_on FROM post_manager JOIN category_list ON category_list.category_id = post_manager.category_id JOIN author_details ON author_details.author_id = post_manager.author_id WHERE author_details.author_status = 'active' AND category_list.activity_status = 'active' AND  post_manager.activity_status = 'active' AND category_list.category_slug = '".$category_slug1."'";
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

//Customer comments
$comments = array();

$sql_comment = "SELECT post_manager.post_id, post_manager.post_title, cstomer_review.cr_id, cstomer_review.parent_cr_id, cstomer_review.review_detail, cstomer_review.created_at, cstomer_review.published FROM cstomer_review JOIN post_manager ON cstomer_review.post_id = post_manager.post_id WHERE cstomer_review.parent_cr_id = '0' AND cstomer_review.published = 'yes' AND cstomer_review.post_id = '" .$pi. "'";
$result_comment = $mysqli->query($sql_comment);

if ($result_comment->num_rows > 0) {
    while($row_comment = $result_comment->fetch_array()){
        $post_id = $row_comment['post_id'];		
        $post_title = $row_comment['post_title'];	
        $cr_id = $row_comment['cr_id'];		
        $parent_cr_id = $row_comment['parent_cr_id'];		
        $review_detail = json_decode($row_comment['review_detail']);	
        $name = $review_detail->name;	
        $email = $review_detail->email;	
        $message = $review_detail->message;
        $created_at = $row_comment['created_at'];
        
        $comment = new stdClass();
        $comment->post_id = $post_id;
        $comment->cr_id = $cr_id;
        $comment->parent_cr_id = $parent_cr_id;
        $comment->name = $name;
        $comment->email = $email;
        $comment->message = $message;
        $comment->created_at = $created_at;

        array_push($comments, $comment);
    }
}

//check child comments
function checkChildComments($post_id, $cr_id, $mysqli){
    $comments = array();

    $sql_comment = "SELECT post_manager.post_id, post_manager.post_title, cstomer_review.cr_id, cstomer_review.parent_cr_id, cstomer_review.review_detail, cstomer_review.created_at, cstomer_review.published FROM cstomer_review JOIN post_manager ON cstomer_review.post_id = post_manager.post_id WHERE cstomer_review.parent_cr_id = '".$cr_id."' AND cstomer_review.published = 'yes' AND cstomer_review.post_id = '" .$post_id. "'";
    $result_comment = $mysqli->query($sql_comment);
    
    if ($result_comment->num_rows > 0) {
        while($row_comment = $result_comment->fetch_array()){
            $post_id = $row_comment['post_id'];		
            $post_title = $row_comment['post_title'];	
            $cr_id = $row_comment['cr_id'];		
            $parent_cr_id = $row_comment['parent_cr_id'];		
            $review_detail = json_decode($row_comment['review_detail']);	
            $name = $review_detail->name;	
            $email = $review_detail->email;	
            $message = $review_detail->message;
            $created_at = $row_comment['created_at'];
            
            $comment = new stdClass();
            $comment->post_id = $post_id;
            $comment->cr_id = $cr_id;
            $comment->parent_cr_id = $parent_cr_id;
            $comment->name = $name;
            $comment->email = $email;
            $comment->message = $message;
            $comment->created_at = $created_at;
    
            array_push($comments, $comment);
        }
    }

    return json_encode($comments);
}//end fun

?>