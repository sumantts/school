<?php

if(!$_SESSION["login_id"]){
    header("location:?p=signin");
}
 include('common/head.php'); ?>

<style>
    table td {
        word-break: break-word;
        vertical-align: top;
        white-space: normal !important;
    }
</style>

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
            <!-- [ sample-table ] start -->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <h5> <?=$title?> </h5>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                            <a href="?p=add_edit_post&gr=setup&pi=0" class="btn btn-primary mb-2 float-right" >Create New</a>
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
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Video</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Video</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>                       

                    </div>
                </div>
            </div>

            <!-- Modal start -->
            <div id="exampleModalLong" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><?=$title?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate id="myForm" name="myForm">
                                <div class="form-row">                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="category_id">Category*</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="0">Select</option>
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
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
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
                                        <input type="text" class="form-control" id="post_title" name="post_title" value="" required >
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
                                        <textarea class="form-control" id="post_description" name="post_description" value="" required style="min-height:300px;"></textarea>
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
                                        <textarea class="form-control" id="post_tags" name="post_tags" value=""></textarea>
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
                                        <img src="" id="image" width="200">
                                    </div> 

                                    <div class="col-md-6 mb-2 mt-4">
                                        <!-- <label for="post_title">Youtube Video Link</label> -->
                                        <input type="url" class="form-control" id="post_video" name="post_video" value="" placeholder="Youtube Video Link" pattern="https://.*" >
                                        <a href="" target="_blank" id="post_video_link" style="display: none">Watch on YouTube</a>
                                    </div>  
                                </div> 
                                <input type="hidden" id="post_id" name="post_id" value="0">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                            <button class="btn  btn-primary" type="button" id="submitForm">
                                <span class="spinner-border spinner-border-sm" role="status" style="display: none;" id="submitForm_spinner"></span>
                                <span class="load-text" style="display: none;" id="submitForm_spinner_text">Loading...</span>
                                <span class="btn-text" id="submitForm_text">Save Changes</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal end -->

            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
	<?php include('common/footer.php'); ?>
    
    <script src="setup/post/function.js"></script>