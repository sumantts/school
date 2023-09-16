

    <!-- Header Start -->
    <?php 
    include('common/mini_header.php'); 
    include('office/assets/php/noticeCtrl.php');
    
    ?>
    <!-- Header End -->

    <!-- Notice Start -->    
    <div class="container-fluid py-5">
      <div class="container">
        <div class="row align-items-center">
          
          <div class="col-lg-12">
            <p class="section-title pr-5">
              <span class="pr-2">Recent Published Notice</span>
            </p>
            <?php 
                if(sizeof($popu_posts) > 0){
                for($i = 0; $i < sizeof($popu_posts); $i++){    
            ?>    
            <h1 class="mb-4"><?=$i+1?>. <?=$popu_posts[$i]->post_title?></h1>
            <h5 > Published: <?=date('jS. F, Y', strtotime($popu_posts[$i]->created_on))?></h5>
            <p><?=$popu_posts[$i]->post_description?></p> 

            

            <?php }
            } else{ ?>   
                <h1 class="mb-4">No Notice Available</h1>            
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <!-- Notice End -->