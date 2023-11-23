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
  
    case 'vision':
    $title = "Vision";
    include('pages/vision.php');
    break;
  
    case 'admission':
    $title = "Admission";
    include('pages/admission.php');
    break;
  
    case 'facilities':
    $title = "Facilities";
    include('pages/facilities.php');
    break;
  
    case 'fees':
    $title = "Fees";
    include('pages/fees.php');
    break;
  
    case 'rules':
    $title = "Rules";
    include('pages/rules.php');
    break;
  
    case 'job_vacancy':
    $title = "Job Vacancy";
    include('pages/job_vacancy.php');
    break;
  
    case 'admission_result':
    $title = "Admission Result";
    include('pages/admission_result.php');
    break;
    
    default:
    include('pages/home.php');
  }
  ?>
  <!-- Body End -->

  <!-- Footer Start -->
  <?php include('common/footer.php'); ?>
