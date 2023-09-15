<?php
    
    $sql = "SELECT * FROM home_page";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $status = true;	
        $row = $result->fetch_array();
        $home_id = $row['home_id'];		
        $hom_title = $row['hom_title'];			
        $hom_description = $row['hom_description'];		
        $hom_bottom_left_img_old = $row['hom_bottom_left_img'];
        $hom_middle_img_old = $row['hom_middle_img'];	
        $hom_top_right_img_old = $row['hom_top_right_img'];	
    }
?>