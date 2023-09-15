$('#onMyModal').on('click', function(){
    clearForm();
    $('#exampleModalLong').modal('show');
})

function validateForm(){
    $author_name = $('#author_name').val().replace(/^\s+|\s+$/gm,'');
    $author_bio = $('#author_bio').val().replace(/^\s+|\s+$/gm,'');
    $status = true;

    if($author_name == ''){
        $status = false;
        $('#author_name').removeClass('is-valid');
        $('#author_name').addClass('is-invalid');
    }else{
        $status = true;
        $('#author_name').removeClass('is-invalid');
        $('#author_name').addClass('is-valid');
    }

    if($author_bio == ''){
        $status = false;
        $('#author_bio').removeClass('is-valid');
        $('#author_bio').addClass('is-invalid');
    }else{
        $status = true;
        $('#author_bio').removeClass('is-invalid');
        $('#author_bio').addClass('is-valid');
    }    

    $('#submitForm_spinner').hide();
    $('#submitForm_spinner_text').hide();
    $('#submitForm_text').show();

    return $status;
}//en validate form

function clearForm(){
    $('#author_name').val('');
    $('#author_name').removeClass('is-valid');
    $('#author_name').removeClass('is-invalid');

    $('#author_bio').val('');
    $('#author_bio').removeClass('is-valid');
    $('#author_bio').removeClass('is-invalid');
    $('#author_id').val('0');           
    let img = document.getElementById('image');
    img.src = '';

}//end 

$(".form-control").blur(function(){
    $('#orgFormAlert').css("display", "none");
    $formVallidStatus = validateForm();
});

$('#submitForm').click(function(){
    $('#submitForm_spinner').show();
    $('#submitForm_spinner_text').show();
    $('#submitForm_text').hide();
    setTimeout(function(){
        $formVallidStatus = validateForm();

        if($formVallidStatus == true){
            $author_id = $('#author_id').val();
            $author_photo = localStorage.getItem('author_photo');
            $author_status = $('#author_status').val();

            $.ajax({
                method: "POST",
                url: "setup/authors/function.php",
                data: { fn: "saveFormData", author_id: $author_id, author_name: $author_name, author_bio: $author_bio, author_photo: $author_photo, author_status: $author_status }
            })
            .done(function( res ) {
                //console.log(res);
                $res1 = JSON.parse(res);
                if($res1.status == true){
                    $('#orgFormAlert1').css("display", "block");
                    $('.toast-right').toast('show');
                    //$('#liveToast').toast('show');
                    clearForm();
                    localStorage.setItem('author_photo', '');
                    $('#exampleModalLong').modal('hide');
                    populateDataTable();
                }else{
                    
                }
            });//end ajax
        }

    }, 500)    
})

function editTableData($author_id){
    $('#exampleModalLong').modal('show');
    $.ajax({
        method: "POST",
        url: "setup/authors/function.php",
        data: { fn: "getFormEditData", author_id: $author_id }
    })
    .done(function( res ) {
        //console.log(res);
        $res1 = JSON.parse(res);
        if($res1.status == true){
            $('#author_name').val($res1.author_name);
            $('#author_bio').val($res1.author_bio);            
            let img = document.getElementById('image');
            img.src = $res1.author_photo;
            localStorage.setItem("author_photo", $res1.author_photo);
            $('#author_status').val($res1.author_status).trigger('change');  
            $('#author_id').val($author_id);
        }
    });//end ajax

}

//Delete function	
function deleteTableData($author_id){
    if (confirm('Are you sure to delete the Service?')) {
        $.ajax({
            method: "POST",
            url: "setup/authors/function.php",
            data: { fn: "deleteTableData", author_id: $author_id }
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
        localStorage.setItem("author_photo", reader.result);
    }, false);

    if (imgPath) {
        reader.readAsDataURL(imgPath);
    }

    //To display image again
    setTimeout(function(){
    let img = document.getElementById('image');
    img.src = localStorage.getItem('author_photo');
    }, 250);
}


function populateDataTable(){
    $('#example').dataTable().fnClearTable();
    $('#example').dataTable().fnDestroy();

    $('#example').DataTable({ 
        columnDefs: [{ width: 40, targets: 0 }, { width: 400, targets: 1 }, { width: 50, targets: 3 }],
        responsive: true,
        serverMethod: 'GET',
        ajax: {'url': 'setup/authors/function.php?fn=getTableData' },
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

$(document).ready(function () {
    populateDataTable()
});