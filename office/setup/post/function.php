<?php
	include('../../assets/php/sql_conn.php');
	$fn = '';
    
	if(isset($_GET["fn"])){
	    $fn = $_GET["fn"];
	}else if(isset($_POST["fn"])){
	    $fn = $_POST["fn"];
	}

	//Save function start
	if($fn == 'saveFormData'){
		$return_result = array();
		$status = true;
		
		$myFormData = $_POST["myFormData"];
		$post_image = $_POST["post_image"];
		$post_id = 0;	
		$category_id = 0;
		$author_id = 0;
		$activity_status = '';
		$post_title = '';
		$post_description = '';
		$post_video = '';
		$post_tags = '';
		
		$myFormData1 = json_decode($myFormData);

		for($i = 0; $i < sizeof($myFormData1); $i++){
			if($myFormData1[$i]->name == 'post_id'){
				$post_id = $myFormData1[$i]->value;
			}
			if($myFormData1[$i]->name == 'category_id'){
				$category_id = $myFormData1[$i]->value;
			}
			if($myFormData1[$i]->name == 'author_id'){
				$author_id = $myFormData1[$i]->value;
			}
			if($myFormData1[$i]->name == 'activity_status'){
				$activity_status = $myFormData1[$i]->value;
			}
			if($myFormData1[$i]->name == 'post_title'){
				$post_title = $myFormData1[$i]->value;
			}
			if($myFormData1[$i]->name == 'post_description'){
				$post_description = $myFormData1[$i]->value;
			}
			if($myFormData1[$i]->name == 'post_video'){
				$post_video = $myFormData1[$i]->value;
			}
			if($myFormData1[$i]->name == 'post_tags'){
				$post_tags = $myFormData1[$i]->value;
			}
		}//end for
		
		try {
			if($post_id > 0){
				$status = true;
				$sql = "UPDATE post_manager SET category_id = '" .$category_id. "', author_id = '" .$author_id. "', post_title = '" .$post_title. "', post_description = '" .$post_description. "', post_image = '" .$post_image. "', post_video = '" .$post_video. "', post_tags = '" .$post_tags. "', activity_status = '" .$activity_status. "' WHERE post_id = '" .$post_id. "' ";
				$result = $mysqli->query($sql);
			}else{
				$sql = "INSERT INTO post_manager (`category_id`, `author_id`, `post_title`, `post_description`, `post_image`, `post_video`, `post_tags`, `activity_status`) VALUES ('" .$category_id. "', '" .$author_id. "', '" .$post_title. "', '" .$post_description. "', '" .$post_image. "', '" .$post_video. "', '" .$post_tags. "', '" .$activity_status. "')";

				$result = $mysqli->query($sql);
				$insert_id = $mysqli->insert_id;
				if($insert_id > 0){
					$status = true;
				}else{
					$return_result['error_message'] = 'Photo size is soo large';
					$status = false;
				}		
			}	
		} catch (PDOException $e) {
			die("Error occurred:" . $e->getMessage());
		}
		$return_result['status'] = $status;
		sleep(2);
		echo json_encode($return_result);
	}//Save function end	

	//function start
	if($fn == 'getTableData'){
		$return_array = array();
		$status = true;
		$mainData = array();
		$author_bio1 = '';
		$sql = "SELECT category_list.category_id, category_list.category_name, category_list.category_slug, author_details.author_id, author_details.author_name, post_manager.post_id, post_manager.post_title, post_manager.post_description, post_manager.post_image, post_manager.post_video, post_manager.post_tags, post_manager.activity_status, post_manager.created_on FROM post_manager JOIN category_list ON category_list.category_id = post_manager.category_id JOIN author_details ON author_details.author_id = post_manager.author_id";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$status = true;
			$slno = 1;
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

				if(strpos($post_description, "A") == true){
					$post_description1 = substr($post_description, 0, 100) . '...'; //English 100 //Bengali 300
				}else{
					$post_description2 = substr($post_description, 0, 300); //English 100 //Bengali 300
					$post_description1 = substr($post_description2, 0, -2) . '...';
				}


				$data[0] = $slno;
				$data[1] = $category_name;
				$data[2] = $author_name;
				$data[3] = $post_title;
				$data[4] = "<img src='".$post_image."' id='saved_image' width='100' >";
				if($post_video != ''){
					$l = 'https://www.youtube.com/watch?v='.$post_video;
				$data[5] = "<a href='".$l."' target='_blank'>Watch on YouTube</a>"; //$post_video;
				}else{
					$data[5] = "";
				}
				$data[6] = date('d-M-Y', strtotime($created_on));
				$data[7] =  ucfirst($activity_status);
				$data[8] = "<a href='?p=add_edit_post&gr=setup&pi=".$post_id."' data-center_id='1'><i class='fa fa-edit' aria-hidden='true' onclick='editTableData(".$post_id.")'></i></a><a href='javascript: void(0)' data-center_id='1'> <i class='fa fa-trash' aria-hidden='true' onclick='deleteTableData(".$post_id.")'></i></a>";

				array_push($mainData, $data);
				$slno++;
			}
		} else {
			$status = false;
		}
		//$mysqli->close();

		$return_array['data'] = $mainData;
    	echo json_encode($return_array);
	}//function end	

	//function start
	if($fn == 'getFormEditData'){
		$return_array = array();
		$status = true;
		$mainData = array();
		$post_id = $_POST['post_id'];

		$sql = "SELECT category_list.category_id, category_list.category_name, category_list.category_slug, author_details.author_id, author_details.author_name, post_manager.post_id, post_manager.post_title, post_manager.post_description, post_manager.post_image, post_manager.post_video, post_manager.post_tags, post_manager.activity_status, post_manager.created_on FROM post_manager JOIN category_list ON category_list.category_id = post_manager.category_id JOIN author_details ON author_details.author_id = post_manager.author_id WHERE post_manager.post_id = '" .$post_id. "'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$status = true;	
			$row = $result->fetch_array();
			$post_id = $row['post_id'];			
			$category_id = $row['category_id'];		
			$author_id = $row['author_id'];
			$activity_status = $row['activity_status'];	
			$post_title = $row['post_title'];	
			$post_description = $row['post_description'];	
			$post_tags = $row['post_tags'];	
			$post_video = $row['post_video'];	

			if($row['post_image'] != ''){
				$post_image = $row['post_image'];	
			}else{
				$post_image = '';
			}
		} else {
			$status = false;
		}
		//$mysqli->close();

		$return_array['post_id'] = $post_id;
		$return_array['category_id'] = $category_id;
		$return_array['author_id'] = $author_id;
		$return_array['activity_status'] = $activity_status;		
		$return_array['post_title'] = $post_title;		
		$return_array['post_description'] = $post_description;		
		$return_array['post_tags'] = $post_tags;		
		$return_array['post_video'] = $post_video;		
		$return_array['post_image'] = $post_image;

		$return_array['status'] = $status;
    	echo json_encode($return_array);
	}//function end

	//Delete function
	if($fn == 'deleteTableData'){
		$return_result = array();
		$post_id = $_POST["post_id"];
		$status = true;	

		$sql = "DELETE FROM post_manager WHERE post_id = '".$post_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function deleteItem

	//Get Category name
	if($fn == 'getAllCategoryName'){
		$return_array = array();
		$status = true;
		$mainData = array();

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
				
				array_push($mainData, $data);
				$slno++;
			}
		} else {
			$status = false;
		}
		//$mysqli->close();

		$return_array['status'] = $status;
		$return_array['data'] = $mainData;
    	echo json_encode($return_array);
	}//function end	

	//Get Authors name
	if($fn == 'getAllAuthorsyName'){
		$return_array = array();
		$status = true;
		$mainData = array();

		$sql = "SELECT * FROM author_details WHERE author_status = 'active' ORDER BY author_name ASC";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$status = true;
			$slno = 1;
			while($row = $result->fetch_array()){
				$author_id = $row['author_id'];	
				$author_name = $row['author_name'];	
				$data = new stdClass();

				$data->author_id = $author_id;
				$data->author_name = $author_name;
				
				array_push($mainData, $data);
				$slno++;
			}
		} else {
			$status = false;
		}
		//$mysqli->close();

		$return_array['status'] = $status;
		$return_array['data'] = $mainData;
    	echo json_encode($return_array);
	}//function end	

?>