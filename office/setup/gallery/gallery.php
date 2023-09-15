<?php 

if(!$_SESSION["login_id"]){
    header("location:?p=signin");
}
    include('common/head.php'); 
    $error_messages = '';
    $success_messages = '';

    if(isset($_POST["sub"]))
    {
        $photonames = $_FILES["photos"]["name"];
        $tag_name = $_POST["tag_name"];
        $photo_description = $_POST["photo_description"];
        $tag_name1 = str_replace(" ","_",$tag_name);
        mkdir("assets/images/gallery/".$tag_name1);
        $newfilepath = "assets/images/gallery/$tag_name1/";
        $photo_stream = implode('|',$photonames);
        $sql = "INSERT INTO photo_gallery (photo_name, tag_name) VALUES ('" .$photo_stream. "', '" .$tag_name. "')";
        mysqli_query($mysqli, $sql);
        for($i = 0; $_FILES["photos"]["name"][$i] == true; $i++)
        {
            
            $photoName = $_FILES["photos"]["name"][$i];
            $photoSize = $_FILES["photos"]["size"][$i];	
            $tem_path = $_FILES["photos"]["tmp_name"][$i];
            move_uploaded_file($tem_path,"$newfilepath/$photoName");
        }
        header("location:?p=gallery&gr=setup");
    }else{
        $tag_name = '';
        $photo_description = '';
    }

    
    //Delete gallery
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $getsql = "SELECT tag_name FROM photo_gallery WHERE id = '" .$id. "'";
        $getres = mysqli_query($mysqli, $getsql);
        $getrow = mysqli_fetch_array($getres);
        $tag_name = $getrow["tag_name"];
        $tag_name1 = str_replace(" ","_",$tag_name);
        $delpath = "assets/images/gallery/".$tag_name1;
        $files = glob($delpath.'/*');
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }
        
        rmdir("assets/images/gallery/".$tag_name1);
        
        mysqli_query($mysqli, "DELETE FROM photo_gallery WHERE id =".$id);
        header("location:?p=gallery&gr=setup&del=ok");
    }//end
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
                        <h5> Add/Update Gallery</h5>
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
                                <div class="col-md-4 mb-3">
                                    <label for="album_name">Album Name*</label>
                                    <input type="text" class="form-control" id="tag_name" name="tag_name" value="<?=$tag_name?>" /> 
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>                                    
                                    <div class="invalid-feedback">
                                        Please provide Title.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2 mt-4">
                                    <input type="file" accept="image/*" class="custom-file-input" name="photos[]" multiple id="gallery_photo" aria-describedby="gallery_photo" >                                    
                                    <label class="custom-file-label" for="validatedCustomFile">Choose Images...</label>                                                                   
                                </div>   

                                <div class="col-md-4 mb-2 mt-4">                           
                                    <input type="submit" class="btn  btn-primary" name="sub" id="submitForm" />                                 
                                </div>   
                            </div> 
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
                
                <div class="card">

                    <div class="card-header">
                        <h5> Gallery Table</h5>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;" id="orgFormAlert">
							<strong>Success!</strong> Your Data Deleted successfully.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;" id="orgFormAlert1">
							<strong>Success!</strong> Your Data saved successfully.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>

                        
                        <div class="table-responsive">
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Tag Name</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $fetch_fotu = "SELECT * FROM photo_gallery";
                                    $res_fotu = mysqli_query($mysqli, $fetch_fotu);
                                    while($row_fotu = mysqli_fetch_object($res_fotu))
                                    {
                                    $i++;
                                    
                                    ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$row_fotu->tag_name?></td>
                                            
                                        <td>
                                            <?php
                                            $tag_name1 = str_replace(" ","_",$row_fotu->tag_name);
                                            $photo_image = explode('|',$row_fotu->photo_name);
                                            $count = sizeof($photo_image);
                                            foreach($photo_image as $key => $value)
                                            {
                                            
                                            ?>
                                                <div style="background:#000; width:50px; height:50px; text-align:center; float:left; margin-right:5px;">
                                                <img src="assets/images/gallery/<?=$tag_name1?>/<?php echo $value; ?>" width="50px;" height="50px;" style="padding:5px;" />
                                                </div>
                                                
                                            <?php 
                                            } 
                                            ?>
                                            
                                        </td>
                                        <td>           
                                            <a title="Delete" href="javascript:void(0)" onclick="if(confirm('Are you Sure to delete the Album')){window.location.href='?p=gallery&gr=setup&id=<?=$row_fotu->id?>'}">
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                            </a>
                                        </td>

                                    </tr>
	                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>                      

                    </div>
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
    
    <!-- <script src="setup/gallery/function.js"></script> -->