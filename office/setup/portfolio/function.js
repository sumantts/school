
function validateForm(){
    $serviceName = $('#serviceName').val().replace(/^\s+|\s+$/gm,'');
    $serviceDescription = $('#serviceDescription').val().replace(/^\s+|\s+$/gm,'');
    $status = true;

    if($serviceName == ''){
        $status = false;
        $('#serviceName').removeClass('is-valid');
        $('#serviceName').addClass('is-invalid');
    }else{
        $status = true;
        $('#serviceName').removeClass('is-invalid');
        $('#serviceName').addClass('is-valid');
    }

    if($serviceDescription == ''){
        $status = false;
        $('#serviceDescription').removeClass('is-valid');
        $('#serviceDescription').addClass('is-invalid');
    }else{
        $status = true;
        $('#serviceDescription').removeClass('is-invalid');
        $('#serviceDescription').addClass('is-valid');
    }    

    $('#submitForm_spinner').hide();
    $('#submitForm_spinner_text').hide();
    $('#submitForm_text').show();

    return $status;
}//en validate form

function clearForm(){
    $('#serviceName').val('');
    $('#serviceName').removeClass('is-valid');
    $('#serviceName').removeClass('is-invalid');

    $('#serviceDescription').val('');
    $('#serviceDescription').removeClass('is-valid');
    $('#serviceDescription').removeClass('is-invalid');
    $('#service_id').val('0');

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
            $service_id = $('#service_id').val();
            $servicesPhoto = localStorage.getItem('image');

            $.ajax({
                method: "POST",
                url: "setup/portfolio/function.php",
                data: { fn: "saveServices", service_id: $service_id, serviceName: $serviceName, serviceDescription: $serviceDescription, servicesPhoto: $servicesPhoto }
            })
            .done(function( res ) {
                //console.log(res);
                $res1 = JSON.parse(res);
                if($res1.status == true){
                    $('#orgFormAlert1').css("display", "block");
                    $('.toast-right').toast('show');
                    //$('#liveToast').toast('show');
                    clearForm();
                    localStorage.setItem('image', '');
                    $('#exampleModalLong').modal('hide');
                    populateDataTable();
                }else{
                    
                }
            });//end ajax
        }

    }, 500)    
})

function editService($service_id){
    $('#exampleModalLong').modal('show');
    $.ajax({
        method: "POST",
        url: "setup/portfolio/function.php",
        data: { fn: "getServiceData", service_id: $service_id }
    })
    .done(function( res ) {
        //console.log(res);
        $res1 = JSON.parse(res);
        if($res1.status == true){
            $('#serviceName').val($res1.name);
            $('#serviceDescription').val($res1.description);            
            let img = document.getElementById('image');
            img.src = $res1.services_photo;
            localStorage.setItem("image", $res1.services_photo);
            $('#service_id').val($service_id);
        }
    });//end ajax

}

//Delete function	
function deleteService($service_id){
    if (confirm('Are you sure to delete the Service?')) {
        $.ajax({
            method: "POST",
            url: "setup/portfolio/function.php",
            data: { fn: "deleteService", service_id: $service_id }
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
        localStorage.setItem("image", reader.result);
    }, false);

    if (imgPath) {
        reader.readAsDataURL(imgPath);
    }

    //To display image again
    setTimeout(function(){
    let img = document.getElementById('image');
    img.src = localStorage.getItem('image');
    }, 250);
}


function populateDataTable(){
    $('#example').dataTable().fnClearTable();
    $('#example').dataTable().fnDestroy();

    $('#example').DataTable({ 
        responsive: true,
        serverMethod: 'GET',
        ajax: {'url': 'setup/portfolio/function.php?fn=getServices' },
        dom: 'Bltfrtip',
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