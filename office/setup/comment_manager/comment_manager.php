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
                        <!-- <div class="card-header-right">
                            <div class="btn-group card-option">
                            <a href="?p=add_edit_post&gr=setup&pi=0" class="btn btn-primary mb-2 float-right" >Create New</a>
                            </div>
                        </div> -->
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
                                        <th>Post Title</th>
                                        <th>Name<br>Email</th>
                                        <th>Message</th>
                                        <th>Publish<br>Comment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Post Title</th>
                                        <th>Name<br>Email</th>
                                        <th>Message</th>
                                        <th>Publish<br> Comment</th>
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
                                    <div class="col-md-6 mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" readonly>
                                    </div> 

                                    <div class="col-md-6 mb-3">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" name="email" id="email" readonly>
                                    </div> 
                                </div> 
                            
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="author_bio">Message</label>
                                        <textarea class="form-control" id="message" name="message" value="" required style="min-height:300px;" readonly></textarea>
                                    </div>  
                                </div> 
                                                           
                                <div class="form-row">                                   
                                    <div class="col-md-6 mb-3">
                                        <label for="published">Publist Comment</label>
                                        <select class="form-control" name="published" id="published">
                                            <option value="no">NO</option>
                                            <option value="yes">YES</option>
                                        </select>
                                        <input type="hidden" name="cr_id" id="cr_id">
                                    </div> 
                                </div> 

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                            <button class="btn  btn-primary" type="button" id="submitForm">
                                <span class="spinner-border spinner-border-sm" role="status" style="display: none;" id="submitForm_spinner"></span>
                                <span class="load-text" style="display: none;" id="submitForm_spinner_text">Loading...</span>
                                <span class="btn-text" id="submitForm_text">Update</span>
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
    
    <script src="setup/comment_manager/function.js"></script>