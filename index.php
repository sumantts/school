<?php 
  include 'office/assets/php/sql_conn.php';

  $title = 'Home';
	if(isset($_GET["p"])){
		$p = $_GET["p"];
	}else{
		$p = '';
	}

  include('common/header.php'); 
  
  ?>

  
  <!-- Navbar Start -->
  <?php include('common/nav.php'); ?>
  <!-- Navbar End -->

  <!-- Body Start -->
  <?php 
  switch($p){
    case 'home':
    $title = "Home";
    include('pages/home.php');
    break;
  
    case 'about':
    $title = "About Us";
    include('pages/about.php');
    break;
  
    case 'academics':
    $title = "Academics";
    include('pages/academics.php');
    break;
  
    case 'admission':
    $title = "Admission";
    include('pages/admission.php');
    break;
  
    case 'gallery':
    $title = "Gallery";
    include('pages/gallery.php');
    break;
  
    case 'contact_us':
    $title = "Contact Us";
    include('pages/contact_us.php');
    break;
  
    case 'notice':
    $title = "Notice Board";
    include('pages/notice.php');
    break;
  
    case 'job_vacancy':
    $title = "Job Vacancy";
    include('pages/job_vacancy.php');
    break;
    
    default:
    include('pages/home.php');
  }
  ?>
  <!-- Body End -->

  <!-- Footer Start -->
  <?php include('common/footer.php'); ?>
