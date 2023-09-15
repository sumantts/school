// $('#onMyModal').on('click', function(){
//     clearForm();
//     $('#exampleModalLong').modal('show');
// })

function validateForm(){
    $category_id = $('#category_id').val();
    $author_id = $('#author_id').val();
    $post_title = $('#post_title').val().replace(/^\s+|\s+$/gm,'');
    $post_description = $('#post_description').val();
    $status = true;

    if($category_id == '0'){
        $status = false;
        $('#category_id').removeClass('is-valid');
        $('#category_id').addClass('is-invalid');
    }else{
        $('#category_id').removeClass('is-invalid');
        $('#category_id').addClass('is-valid');
    }

    if($author_id == '0'){
        $status = false;
        $('#author_id').removeClass('is-valid');
        $('#author_id').addClass('is-invalid');
    }else{
        $('#author_id').removeClass('is-invalid');
        $('#author_id').addClass('is-valid');
    }   

    if($post_title == ''){
        $status = false;
        $('#post_title').removeClass('is-valid');
        $('#post_title').addClass('is-invalid');
    }else{
        $('#post_title').removeClass('is-invalid');
        $('#post_title').addClass('is-valid');
    }     

    // if($post_description == ''){
    //     $status = false;
    //     $('#post_description').removeClass('is-valid');
    //     $('#post_description').addClass('is-invalid');
    // }else{
    //     $('#post_description').removeClass('is-invalid');
    //     $('#post_description').addClass('is-valid');
    // }    

    $('#submitForm_spinner').hide();
    $('#submitForm_spinner_text').hide();
    $('#submitForm_text').show();

    return $status;
}//en validate form

// function clearForm(){
//     $('#myForm').trigger("reset");

//     let img = document.getElementById('image');
//     img.src = '';
// }//end 

// $(".form-control").blur(function(){
//     $('#orgFormAlert').css("display", "none");
//     $formVallidStatus = validateForm();
// });

$('#submitForm').click(function(){
    $('#submitForm_spinner').show();
    $('#submitForm_spinner_text').show();
    $('#submitForm_text').hide();
    setTimeout(function(){
        $formVallidStatus = true;//validateForm();

        if($formVallidStatus == true){
            $published = $('#published').val();
            $cr_id = $('#cr_id').val();

            $.ajax({
                method: "POST",
                url: "setup/comment_manager/function.php",
                data: { fn: "saveFormData", published: $published, cr_id: $cr_id }
            })
            .done(function( res ) {
                //console.log(res);
                $res1 = JSON.parse(res);
                if($res1.status == true){
                    alert('Comment publish status updated');
                    populateDataTable();
                }else{
                    
                }                
                $('#submitForm_spinner').hide();
                $('#submitForm_spinner_text').hide();
                $('#submitForm_text').show();
            });//end ajax
        }

    }, 500)    
})

function editTableData($cr_id){
    $('#myForm')[0].reset();
    $("#post_video_link").hide();

    $.ajax({
        method: "POST",
        url: "setup/comment_manager/function.php",
        data: { fn: "getFormEditData", cr_id: $cr_id }
    })
    .done(function( res ) {
        //console.log(res);
        $res1 = JSON.parse(res);
        if($res1.status == true){

            $('#exampleModalLongTitle').html($res1.post_title);  
            $('#name').val($res1.name);  
            $('#email').val($res1.email); 
            $('#message').val($res1.message);
            $('#published').val($res1.published).trigger('change');   
            $('#cr_id').val($res1.cr_id);

            $('#exampleModalLong').modal('show');
        }
    });//end ajax

}

//Delete function	
function deleteTableData($cr_id){
    if (confirm('Are you sure to delete the data?')) {
        $.ajax({
            method: "POST",
            url: "setup/comment_manager/function.php",
            data: { fn: "deleteTableData", cr_id: $cr_id }
        })
        .done(function( res ) {
            //console.log(res);
            $res1 = JSON.parse(res);
            if($res1.status == true){
                $('#orgFormAlert').show();
                populateDataTable();
            }
        });//end ajax
    }		
}//end delete

//Image upload
function savePhoto(){
    const imgPath = document.querySelector('input[type=file]').files[0];
    const reader = new FileReader();

    reader.addEventListener("load", function () {
        // convert image file to base64 string and save to localStorage
        localStorage.setItem("post_image", reader.result);
        $('#post_image_data').val(reader.result);
    }, false);

    if (imgPath) {
        reader.readAsDataURL(imgPath);
    }

    //To display image again
    setTimeout(function(){
    let img = document.getElementById('image');
    img.src = localStorage.getItem('post_image');
    }, 250);
}


function populateDataTable(){
    $('#example').dataTable().fnClearTable();
    $('#example').dataTable().fnDestroy();

    $('#example').DataTable({ 
        columnDefs: [{ width: 300, targets: 3 }, { width: 100, targets: 5 }],
        responsive: true,
        serverMethod: 'GET',
        ajax: {'url': 'setup/comment_manager/function.php?fn=getTableData' },
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Print'
            },
        ],
        order: [[0, 'desc']],

    });
}//end fun

function configureCategoryDropDown(){
    $.ajax({
        method: "POST",
        url: "setup/comment_manager/function.php",
        data: { fn: "getAllCategoryName" }
    })
    .done(function( res ) {
        $res1 = JSON.parse(res);
        //console.log(JSON.stringify($res1));
        if($res1.status == true){
            $rows = $res1.data;

            if($rows.length > 0){
                $('#category_id').html('');
                $option_category_id = "<option value='0'>Select</option>";

                for($i = 0; $i < $rows.length; $i++){
                    $option_category_id += "<option data-category_slug='"+$rows[$i].category_slug+"' value='"+$rows[$i].category_id+"'>"+$rows[$i].category_name+"</option>";                    
                }//end for
                
                $('#category_id').html($option_category_id);
            }//end if
        }        
    });//end ajax
}//end

function configureAuthorDropDown(){
    $.ajax({
        method: "POST",
        url: "setup/comment_manager/function.php",
        data: { fn: "getAllAuthorsyName" }
    })
    .done(function( res ) {
        $res1 = JSON.parse(res);
        //console.log(JSON.stringify($res1));
        if($res1.status == true){
            $rows = $res1.data;

            if($rows.length > 0){
                $('#author_id').html('');
                $option_author_id = "<option value='0'>Select</option>";

                for($i = 0; $i < $rows.length; $i++){
                    $option_author_id += "<option value='"+$rows[$i].author_id+"'>"+$rows[$i].author_name+"</option>";                    
                }//end for
                
                $('#author_id').html($option_author_id);
            }//end if
        }        
    });//end ajax
}//end

$(document).ready(function () {
    populateDataTable();
    //configureCategoryDropDown();
    //configureAuthorDropDown();
});