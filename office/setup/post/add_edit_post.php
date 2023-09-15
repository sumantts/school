<?php 

if(!$_SESSION["login_id"]){
    header("location:?p=signin");
}
    include('common/head.php'); 
	//include('assets/php/sql_conn.php');

    //Get All Category Name
    $return_array = array();
    $status = true;
    $categories = array();

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
            
            array_push($categories, $data);
            $slno++;
        }
    } else {
        $status = false;
    }

    //Get All Author name
    $authors = array();

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
            
            array_push($authors, $data);
            $slno++;
        }
    } else {
        $status = false;
    }
    
    
    if(isset($_GET['pi'])){
        $post_id = $_GET['pi'];

        if($post_id > 0){
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
        }else{
            $post_id = 0;
            $category_id = 0;
            $author_id = 0;
            $activity_status = 1;
            $post_title = '';
            $post_description = '';
            $post_tags = '';
            $post_image = '';
            $post_video = '';
        }
    }//end if

    //Update data    
    if(isset($_POST["submitForm"]))
    {
        $post_id = $_POST["post_id"];
        $category_id = $_POST["category_id"];
        $author_id = $_POST["author_id"];
        $post_title = $_POST["post_title"];
        $post_description = mysqli_real_escape_string($mysqli, $_POST["post_description"]);	
        $post_image = $_POST["post_image_data"];
        $post_video = $_POST["post_video"];
        $post_tags = $_POST["post_tags"];
        $activity_status = $_POST["activity_status"];

        if($post_id > 0){
            $status = true;
            $sql = "UPDATE post_manager SET category_id = '" .$category_id. "', author_id = '" .$author_id. "', post_title = '" .$post_title. "', post_description = '" .$post_description. "', post_image = '" .$post_image. "', post_video = '" .$post_video. "', post_tags = '" .$post_tags. "', activity_status = '" .$activity_status. "' WHERE post_id = '" .$post_id. "' ";
            $result = $mysqli->query($sql);
            header("location:?p=add_edit_post&gr=setup&pi=$post_id");

        }else{
            $sql = "INSERT INTO post_manager (`category_id`, `author_id`, `post_title`, `post_description`, `post_image`, `post_video`, `post_tags`, `activity_status`) VALUES ('" .$category_id. "', '" .$author_id. "', '" .$post_title. "', '" .$post_description. "', '" .$post_image. "', '" .$post_video. "', '" .$post_tags. "', '" .$activity_status. "')";

            $result = $mysqli->query($sql);
            $insert_id = $mysqli->insert_id;
            if($insert_id > 0){
                $status = true;
                header("location:?p=add_edit_post&gr=setup&pi=$insert_id");
            }else{
                $return_result['error_message'] = 'Photo size is soo large';
                $status = false;
            }		
        }
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
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                    <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                    <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                                    <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                                    <li><a href="#!" data-toggle="modal" data-target="#exampleModalLong"><i class="feather icon-file-plus"></i> add new</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;" id="orgFormAlert">
							<strong>Success!</strong> Your Data saved successfully.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>

                        <form class="needs-validation" name="myForm" id="myForm" action="" method="post">
                            <div class="form-row">                                    
                                <div class="col-md-4 mb-3">
                                    <label for="category_id">Category*</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option value="0">Select</option>
                                        <?php
                                        if(sizeof($categories) > 0){
                                            for($i = 0; $i < sizeof($categories); $i++){
                                                ?>
                                                <option value="<?=$categories[$i]->category_id?>" data-category_slug="<?=$categories[$i]->category_slug?>" <?php if($category_id == $categories[$i]->category_id){?> selected="selected" <?php } ?>><?=$categories[$i]->category_name?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>                                    
                                    <div class="invalid-feedback">
                                        Please select Category.
                                    </div>
                                </div>    

                                <div class="col-md-4 mb-3">
                                    <label for="author_id">Author*</label>
                                    <select class="form-control" name="author_id" id="author_id">
                                        <option value="0">Select</option>
                                        <?php
                                        if(sizeof($authors) > 0){
                                            for($i = 0; $i < sizeof($authors); $i++){
                                                ?>
                                                <option value="<?=$authors[$i]->author_id?>" <?php if($author_id == $authors[$i]->author_id){?> selected="selected" <?php } ?>><?=$authors[$i]->author_name?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>                                    
                                    <div class="invalid-feedback">
                                        Please select Author.
                                    </div>
                                </div> 
                                
                                <div class="col-md-4 mb-3">
                                    <label for="activity_status">Activity Status*</label>
                                    <select class="form-control" name="activity_status" id="activity_status">
                                        <option value="active" <?php if($activity_status == 'active'){?> selected="selected" <?php } ?>>Active</option>
                                        <option value="inactive" <?php if($activity_status == 'inactive'){?> selected="selected" <?php } ?>>Inactive</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>                                    
                                    <div class="invalid-feedback">
                                        Please Select Activity Status.
                                    </div>
                                </div> 
                            </div> 
                        
                            <div class="form-row">  
                                <div class="col-md-12 mb-3">
                                    <label for="post_title">Title*</label>
                                    <input type="text" class="form-control" id="post_title" name="post_title" value="<?=$post_title?>" required >
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>                                    
                                    <div class="invalid-feedback">
                                        Please provide Title.
                                    </div>
                                </div> 

                                <div class="col-md-12 mb-3">
                                    <label for="author_bio">Description*</label>
                                    <!-- <input type="text" class="form-control" id="author_bio" placeholder="Group Description" value="" required> -->
                                    <textarea class="form-control" id="post_description" name="post_description" ><?=$post_description?></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>                                    
                                    <div class="invalid-feedback">
                                        Please provide Biography.
                                    </div>
                                </div> 

                                <div class="col-md-12 mb-3">
                                    <label for="post_tags">Tags*</label>
                                    <!-- <input type="text" class="form-control" id="author_bio" placeholder="Group Description" value="" required> -->
                                    <textarea class="form-control" id="post_tags" name="post_tags" ><?=$post_tags?></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>                                    
                                    <div class="invalid-feedback">
                                        Please provide Biography.
                                    </div>
                                </div> 
                            </div> 
                        
                            <div class="form-row">                                     
                                <div class="col-md-6 mb-2 mt-4">
                                    <input type="file" accept="image/*" class="custom-file-input" id="post_image" aria-describedby="post_image"  onchange="savePhoto()">
                                    <label class="custom-file-label" for="validatedCustomFile">Choose image...</label>
                                    <small id="post_imageError" class="form-text text-danger"> </small>
                                    <img src="<?=$post_image?>" id="image" width="200">
                                    <textarea name="post_image_data" id="post_image_data" style="display: none;"><?=$post_image?></textarea>
                                </div> 

                                <div class="col-md-6 mb-2 mt-4">
                                    <!-- <label for="post_title">Youtube Video Link</label> -->
                                    <input type="text" class="form-control" id="post_video" name="post_video" value="<?=$post_video?>" placeholder="Youtube Embeded Link" >
                                    <a href="<?=$post_video?>" target="_blank" id="post_video_link" style="display: none">Watch on YouTube</a>
                                    <span><s>https://www.youtube.com/watch?v=</s><strong>_aJI36GtHi4</strong></span>
                                </div>  
                            </div> 
                            <input type="hidden" id="post_id" name="post_id" value="<?=$post_id?>">
                            
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
        selector: '#post_description',
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
    
    <script src="setup/post/function.js"></script>