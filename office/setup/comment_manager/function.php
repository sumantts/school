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
		
		$published = $_POST["published"];
		$cr_id = $_POST["cr_id"];
		
		try {
			if($cr_id > 0){
				$status = true;
				$sql = "UPDATE cstomer_review SET published = '" .$published. "' WHERE cr_id = '" .$cr_id. "' ";
				$result = $mysqli->query($sql);
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
		$sql = "SELECT post_manager.post_id, post_manager.post_title, cstomer_review.cr_id, cstomer_review.parent_cr_id, cstomer_review.review_detail, cstomer_review.created_at, cstomer_review.published FROM cstomer_review JOIN post_manager ON cstomer_review.post_id = post_manager.post_id";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$status = true;
			$slno = 1;
			while($row = $result->fetch_array()){
				$post_id = $row['post_id'];		
				$post_title = $row['post_title'];	
				$cr_id = $row['cr_id'];		
				$parent_cr_id = $row['parent_cr_id'];		
				$review_detail = json_decode($row['review_detail']);	
				$name = $review_detail->name;	
				$email = $review_detail->email;	
				$message = $review_detail->message;
				$created_at = $row['created_at'];	
				$published = $row['published'];	

				$data[0] = $slno;
				$data[1] = $post_title;
				$data[2] = $name."<br>".$email;
				$data[3] = $message;
				$data[4] =  ucfirst($published);
				$data[5] = "<a href='javascript: void(0)' data-cr_id='.$cr_id.'><i class='fa fa-edit' aria-hidden='true' onclick='editTableData(".$cr_id.")'></i></a> <a href='javascript: void(0)' data-cr_id='.$cr_id.'> <i class='fa fa-trash' aria-hidden='true' onclick='deleteTableData(".$cr_id.")'></i></a>";

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
		$cr_id = $_POST['cr_id'];

		$sql = "SELECT post_manager.post_id, post_manager.post_title, cstomer_review.cr_id, cstomer_review.parent_cr_id, cstomer_review.review_detail, cstomer_review.created_at, cstomer_review.published FROM cstomer_review JOIN post_manager ON cstomer_review.post_id = post_manager.post_id WHERE cstomer_review.cr_id = '" .$cr_id. "' ";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$status = true;	
			$row = $result->fetch_array();

			$post_id = $row['post_id'];		
			$post_title = $row['post_title'];	
			$cr_id = $row['cr_id'];		
			$parent_cr_id = $row['parent_cr_id'];		
			$review_detail = json_decode($row['review_detail']);	
			$name = $review_detail->name;	
			$email = $review_detail->email;	
			$message = $review_detail->message;
			$created_at = $row['created_at'];	
			$published = $row['published'];	
		} else {
			$status = false;
		}
		//$mysqli->close();

		$return_array['post_id'] = $post_id;		
		$return_array['post_title'] = $post_title;		
		$return_array['cr_id'] = $cr_id;
		$return_array['parent_cr_id'] = $parent_cr_id;
		$return_array['name'] = $name;
		$return_array['email'] = $email;		
		$return_array['message'] = $message;		
		$return_array['created_at'] = $created_at;		
		$return_array['published'] = $published;

		$return_array['status'] = $status;
    	echo json_encode($return_array);
	}//function end

	//Delete function
	if($fn == 'deleteTableData'){
		$return_result = array();
		$cr_id = $_POST["cr_id"];
		$status = true;	

		$sql = "DELETE FROM cstomer_review WHERE cr_id = '".$cr_id."'";
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