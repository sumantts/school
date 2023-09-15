

    <!-- Header Start -->
    <?php 
      include('common/mini_header.php');
      include('office/assets/php/galleryCtrl.php'); 
    ?>
    <!-- Header End -->

    <!-- Gallery Start -->
    <div class="container-fluid pt-5 pb-3">
      <div class="container">
        <div class="text-center pb-2">
          <p class="section-title px-5">
            <span class="px-2">Our Gallery</span>
          </p>
          <h1 class="mb-4">Our Kids School Gallery</h1>
        </div>
        <div class="row">
          <div class="col-12 text-center mb-2">
          <?php if(sizeof($albums) > 0){?>
            <ul class="list-inline mb-4" id="portfolio-flters">
              <li class="btn btn-outline-primary m-1 active" data-filter="*">
                All
              </li>
              <?php for($i = 0; $i < sizeof($albums); $i++){
                $tag_name1 = str_replace(" ", "_", $albums[$i]->tag_name);
              ?>
                <li class="btn btn-outline-primary m-1" data-filter=".<?=$tag_name1?>"><?=$albums[$i]->tag_name?></li>
              <?php } ?> 
              <!-- <li class="btn btn-outline-primary m-1" data-filter=".first">
                Playing
              </li>
              <li class="btn btn-outline-primary m-1" data-filter=".second">
                Drawing
              </li>
              <li class="btn btn-outline-primary m-1" data-filter=".third">
                Reading
              </li> -->
            </ul>
          <?php } ?>
          </div>
        </div>
        <div class="row portfolio-container">
          <?php 
            if(sizeof($albums) > 0){
            for($j = 0; $j < sizeof($albums); $j++){
            $tag_name2 = str_replace(" ", "_", $albums[$j]->tag_name);
            $tag_name = $albums[$j]->tag_name;
            $photo_image = explode('|', $albums[$j]->photo_name);
            $count = sizeof($photo_image);
            foreach($photo_image as $key => $value)
            {            
            ?>
            <div class="col-lg-3 col-sm-6 col-12 <?=$tag_name2?> gallery-item isotope-item"><img class="img-fluid w-100" src="studio/assets/images/gallery/<?=$tag_name2?>/<?=$value?>" alt="" data-glightbox="title: <?=$tag_name?>; description: <?=$tag_name?>" /></div>

            <div class="col-lg-4 col-md-6 mb-4 portfolio-item <?=$tag_name2?>">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="office/assets/images/gallery/<?=$tag_name2?>/<?=$value?>" alt="" />
              <div
                class="portfolio-btn bg-primary d-flex align-items-center justify-content-center"
              >
                <a href="office/assets/images/gallery/<?=$tag_name2?>/<?=$value?>" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div>

          <?php } } }?>

          <!-- <div class="col-lg-4 col-md-6 mb-4 portfolio-item first">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="img/portfolio-1.jpg" alt="" />
              <div
                class="portfolio-btn bg-primary d-flex align-items-center justify-content-center"
              >
                <a href="img/portfolio-1.jpg" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4 portfolio-item second">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="img/portfolio-2.jpg" alt="" />
              <div
                class="portfolio-btn bg-primary d-flex align-items-center justify-content-center"
              >
                <a href="img/portfolio-2.jpg" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4 portfolio-item third">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="img/portfolio-3.jpg" alt="" />
              <div
                class="portfolio-btn bg-primary d-flex align-items-center justify-content-center"
              >
                <a href="img/portfolio-3.jpg" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4 portfolio-item first">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="img/portfolio-4.jpg" alt="" />
              <div
                class="portfolio-btn bg-primary d-flex align-items-center justify-content-center"
              >
                <a href="img/portfolio-4.jpg" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4 portfolio-item second">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="img/portfolio-5.jpg" alt="" />
              <div
                class="portfolio-btn bg-primary d-flex align-items-center justify-content-center"
              >
                <a href="img/portfolio-5.jpg" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4 portfolio-item third">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="img/portfolio-6.jpg" alt="" />
              <div
                class="portfolio-btn bg-primary d-flex align-items-center justify-content-center"
              >
                <a href="img/portfolio-6.jpg" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div> -->

        </div>
      </div>
    </div>
    <!-- Gallery End -->