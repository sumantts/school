<?php 
if(!$_SESSION["login_id"]){
    header("location:?p=signin");
}
    include('common/head.php'); 
    $error_messages = '';
    $success_messages = '';
    
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
    } else {
        $home_id = 0;
        $hom_title = '';
        $hom_description = '';
        $hom_bottom_left_img_old = '';
        $hom_middle_img_old = '';
        $hom_top_right_img_old = '';
    }

    //Update data    
    if(isset($_POST["submitForm"]))
    {
        $home_id = $_POST["home_id"];
        $hom_title = $_POST["hom_title"];
        $hom_description = mysqli_real_escape_string($mysqli, $_POST["hom_description"]);	
        $hom_bottom_left_img = $_FILES["hom_bottom_left_img"];
        $hom_middle_img = $_FILES["hom_middle_img"];
        $hom_top_right_img = $_FILES["hom_top_right_img"];
        $target_dir = "assets/images/home_page/";

        if($home_id > 0){
            $status = true;
            $sql = "UPDATE home_page SET hom_title = '" .$hom_title. "', hom_description = '" .$hom_description. "' WHERE home_id = '" .$home_id. "' ";
            $result = $mysqli->query($sql);
        }else{
            $sql = "INSERT INTO home_page (`hom_title`, `hom_description`) VALUES ('" .$hom_title. "', '" .$hom_description. "')";

            $result = $mysqli->query($sql);
            $home_id = $mysqli->insert_id;
            if($home_id > 0){
                $status = true;                
            }else{
                $return_result['error_message'] = 'Photo size is soo large';
                $status = false;
            }		
        }

        if(basename($_FILES["hom_bottom_left_img"]["name"]) != ''){
            $target_file = $target_dir . basename($_FILES["hom_bottom_left_img"]["name"]);
            $hom_bottom_left_img = basename($_FILES["hom_bottom_left_img"]["name"]);
            $hom_bottom_left_img_old = $_POST["hom_bottom_left_img_old"];
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["hom_bottom_left_img"]["tmp_name"]);
            if($check !== false) {
                $success_messages .= "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $error_messages .= "File is not an image.";
                $uploadOk = 0;
            }
            
            // Check if file already exists
            /*if (file_exists($target_file)) {
                $error_messages .= " Sorry, file already exists.";
                $uploadOk = 0;
            }*/
            
            // Check file size
            if ($_FILES["hom_bottom_left_img"]["size"] > 500000) {
                $error_messages .= " Sorry, your file is too large.";
                $uploadOk = 0;
            }
            //$success_messages .= " The file Size: ".$_FILES["hom_bottom_left_img"]["size"]; //The file Size: 124933
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                $error_messages .= " Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $error_messages .= " Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                $unlink_file_path = $target_dir . $hom_bottom_left_img_old;
                if (file_exists($unlink_file_path)) {
                    unlink($unlink_file_path);
                }

              if (move_uploaded_file($_FILES["hom_bottom_left_img"]["tmp_name"], $target_file)) {
                $success_messages .= " The file ". htmlspecialchars( basename( $_FILES["hom_bottom_left_img"]["name"])). " has been uploaded.";
                $sql2 = "UPDATE home_page SET hom_bottom_left_img = '" .$hom_bottom_left_img. "' WHERE home_id = '" .$home_id. "' ";
                $mysqli->query($sql2);

              } else {
                $error_messages .= " Sorry, there was an error uploading your file.";
              }
            }

        }//end 1st image upload if

        if(basename($_FILES["hom_middle_img"]["name"]) != ''){
            $target_file = $target_dir . basename($_FILES["hom_middle_img"]["name"]);
            $hom_middle_img = basename($_FILES["hom_middle_img"]["name"]);
            $hom_middle_img_old = $_POST["hom_middle_img_old"];
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["hom_middle_img"]["tmp_name"]);
            if($check !== false) {
                $success_messages .= "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $error_messages .= "File is not an image.";
                $uploadOk = 0;
            }
            
            // Check if file already exists
            /*if (file_exists($target_file)) {
                $error_messages .= " Sorry, file already exists.";
                $uploadOk = 0;
            }*/
            
            // Check file size
            if ($_FILES["hom_middle_img"]["size"] > 500000) {
                $error_messages .= " Sorry, your file is too large.";
                $uploadOk = 0;
            }
            //$success_messages .= " The file Size: ".$_FILES["hom_middle_img"]["size"]; //The file Size: 124933
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                $error_messages .= " Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $error_messages .= " Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                $unlink_file_path = $target_dir . $hom_middle_img_old;
                if (file_exists($unlink_file_path)) {
                    unlink($unlink_file_path);
                }

              if (move_uploaded_file($_FILES["hom_middle_img"]["tmp_name"], $target_file)) {
                $success_messages .= " The file ". htmlspecialchars( basename( $_FILES["hom_middle_img"]["name"])). " has been uploaded.";

                $sql2 = "UPDATE home_page SET hom_middle_img = '" .$hom_middle_img. "' WHERE home_id = '" .$home_id. "' ";
                $mysqli->query($sql2);

              } else {
                $error_messages .= " Sorry, there was an error uploading your file.";
              }
            }

        }//end 2nd image upload if

        if(basename($_FILES["hom_top_right_img"]["name"]) != ''){
            $target_file = $target_dir . basename($_FILES["hom_top_right_img"]["name"]);
            $hom_top_right_img = basename($_FILES["hom_top_right_img"]["name"]);
            $hom_top_right_img_old = $_POST["hom_top_right_img_old"];
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["hom_top_right_img"]["tmp_name"]);
            if($check !== false) {
                $success_messages .= "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $error_messages .= "File is not an image.";
                $uploadOk = 0;
            }
            
            // Check if file already exists
            /*if (file_exists($target_file)) {
                $error_messages .= " Sorry, file already exists.";
                $uploadOk = 0;
            }*/
            
            // Check file size
            if ($_FILES["hom_top_right_img"]["size"] > 500000) {
                $error_messages .= " Sorry, your file is too large.";
                $uploadOk = 0;
            }
            //$success_messages .= " The file Size: ".$_FILES["hom_top_right_img"]["size"]; //The file Size: 124933
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                $error_messages .= " Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $error_messages .= " Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                $unlink_file_path = $target_dir . $hom_top_right_img_old;
                if (file_exists($unlink_file_path)) {
                    unlink($unlink_file_path);
                }
                
                if (move_uploaded_file($_FILES["hom_top_right_img"]["tmp_name"], $target_file)) {
                $success_messages .= " The file ". htmlspecialchars( basename( $_FILES["hom_top_right_img"]["name"])). " has been uploaded.";

                $sql2 = "UPDATE home_page SET hom_top_right_img = '" .$hom_top_right_img. "' WHERE home_id = '" .$home_id. "' ";
                $mysqli->query($sql2);

              } else {
                $error_messages .= " Sorry, there was an error uploading your file.";
              }
            }

        }//end 3rd image upload if

        //sleep(3);
        header("location:?p=home_page&gr=setup");
    }
?>


<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->	
	<?php include('common/nav.php'); ?>
	<!-- [ navigation menu ] end -->

	<!-- [ Header ] start -->
	<?php include('common/top_bar.php'); ?>
	<!-- [ Header ] end -->
	
	

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10"><?=$title?></h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#!"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!"><?=$title?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <h5> <?=$title?> </h5>
                        <div class="card-header-right">                            
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <?php if($success_messages != ''){?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="orgFormAlert">
                            <strong>Success!</strong><?=$success_messages?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
                        <?php } ?>

                        <?php if($error_messages != ''){?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="orgFormAlert1">
							<strong>Error!</strong> <?=$error_messages?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
                        <?php } ?>

                        <form class="needs-validation" name="myForm" id="myForm" action="" method="post" enctype="multipart/form-data">                        
                            <div class="form-row">  
                                <div class="col-md-12 mb-3">
                                    <label for="hom_title">Title*</label>
                                    <input type="text" class="form-control" id="hom_title" name="hom_title" value="<?=$hom_title?>" required >
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>                                    
                                    <div class="invalid-feedback">
                                        Please provide Title.
                                    </div>
                                </div> 

                                <div class="col-md-12 mb-3">
                                    <label for="hom_description">Description*</label>
                                    <textarea class="form-control" id="hom_description" name="hom_description" ><?=$hom_description?></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>                                    
                                    <div class="invalid-feedback">
                                        Please provide Biography.
                                    </div>
                                </div> 
                            </div> 
                        
                            <div class="form-row">                                     
                                <div class="col-md-4 mb-2 mt-4">
                                    <input type="file" accept="image/*" class="custom-file-input" name="hom_bottom_left_img" id="hom_bottom_left_img" aria-describedby="hom_bottom_left_img" onchange="_savePhoto()">
                                    <input type="hidden" name="hom_bottom_left_img_old" id="hom_bottom_left_img_old" value="<?=$hom_bottom_left_img_old?>">
                                    <label class="custom-file-label" for="validatedCustomFile">Bottom Left Image...</label>
                                    <small id="hom_bottom_left_imgError" class="form-text text-danger"> </small>
                                    <img src="assets/images/home_page/<?=$hom_bottom_left_img_old?>" id="image" width="200">                                    
                                </div>  
                                                                    
                                <div class="col-md-4 mb-2 mt-4">
                                    <input type="file" accept="image/*" class="custom-file-input" name="hom_middle_img" id="hom_middle_img" aria-describedby="hom_middle_img"  onchange="_savePhoto()">
                                    <input type="hidden" name="hom_middle_img_old" id="hom_middle_img_old" value="<?=$hom_middle_img_old?>">
                                    <label class="custom-file-label" for="validatedCustomFile">Middle Image...</label>
                                    <small id="hom_middle_imgError" class="form-text text-danger"> </small>
                                    <img src="assets/images/home_page/<?=$hom_middle_img_old?>" id="image2" width="200">                                    
                                </div>  
                                                                    
                                <div class="col-md-4 mb-2 mt-4">
                                    <input type="file" accept="image/*" class="custom-file-input" name="hom_top_right_img" id="hom_top_right_img" aria-describedby="hom_top_right_img"  onchange="_savePhoto()">
                                    <input type="hidden" name="hom_top_right_img_old" id="hom_top_right_img_old" value="<?=$hom_top_right_img_old?>">
                                    <label class="custom-file-label" for="validatedCustomFile">Top Right Image...</label>
                                    <small id="hom_top_right_imgError" class="form-text text-danger"> </small>
                                    <img src="assets/images/home_page/<?=$hom_top_right_img_old?>" id="image3" width="200">                                    
                                </div>  
                            </div> 
                            <input type="hidden" id="home_id" name="home_id" value="<?=$home_id?>">
                            
                            <input type="submit" class="btn  btn-primary" name="submitForm" id="submitForm" />
                        </form>
                    </div>
                          
                    <!-- Toast Message -->
                    <div style="position:absolute; top:40px; right: 40px">
                        <div class="toast hide toast-right" role="alert" aria-live="assertive" data-delay="3000" aria-atomic="true">
                            <div class="toast-header">
                                <img src="assets/images/<?=$ico?>" alt="" class="img-fluid m-r-5" style="width:20px;">
                                <strong class="mr-auto"><?=$p_name?></strong>
                                <small class="text-muted">11 mins ago</small>
                                <button type="button" class="m-l-5 mb-1 mt-1 close" data-dismiss="toast" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="toast-body">
                            Success! Form data saved successfully.
                            </div>
                        </div>
                    </div>                             
                    <!-- Toast Message -->

                </div>
            </div>

            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
	<?php include('common/footer.php'); ?>
    

    <script type="text/javascript">
    tinymce.init({
        selector: '#hom_description',
        width: 900,
        height: 400,
        plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'table emoticons template paste help'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
        'forecolor backcolor emoticons | help',
        menu: {
        favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
        },
        menubar: 'favs file edit view insert format tools table help',
        content_css: 'css/content.css'
    });
    </script>
    
    <script src="setup/home_page/function.js"></script>