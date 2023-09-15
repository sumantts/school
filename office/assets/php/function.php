<?php	
	include 'sql_conn.php';

	$fn = '';

	if(isset($_POST["fn"])){
		$fn = $_POST["fn"];
	}
	
	//Save Review function
	if($fn == 'saveReview'){
		$return_result = array();
		$review_details = json_encode($_POST["review_details"]);
		$post_id = $_POST["post_id"];
		$parent_cr_id = $_POST["parent_cr_id"];

		$status = true;	
        
        $sql = "INSERT INTO cstomer_review (parent_cr_id, post_id, review_detail) VALUES ('" .$parent_cr_id. "', '" .$post_id. "', '" .$review_details. "')";
        $result = $mysqli->query($sql);
        $quotation_id = $mysqli->insert_id;

        if ($quotation_id > 0) {
            $status = true;
        } else {
            $status = false;
        }
        $mysqli->close();

		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function saveReview

    ?>