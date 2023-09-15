<?php
	include('assets/php/sql_conn.php');	
	
	if(isset($_GET["p"])){
		$p = $_GET["p"];
	}else{
		$p = '';
	}
	
	if(isset($_GET["gr"])){
		$gr = $_GET["gr"];
	}else{
		$gr = '';
	}

	switch($p){
		case 'signin':
        $title = "Signin";
		include('signin/signin.php');
		break;

		case 'signup':
        $title = "Signup";
		include('signup/signup.php');
		break;
		
		case 'dashboard':
		$title = "Dashboard";
		include('dashboard/dashboard.php');		
		break;

		//SETUP		
		case 'home_page':
			$title = "Home Page";
			include('setup/home_page/home_page.php');		
		break;

		case 'category_manager':
			$title = "Category Manager";
			include('setup/category_manager/category_manager.php');		
		break;

		case 'portfolio':
			$title = "Portfolio Management";
			include('setup/portfolio/portfolio.php');		
		break;	

		case 'gallery':
			$title = "Gallery Management";
			include('setup/gallery/gallery.php');		
		break;	

		case 'authors':
			$title = "Authors Profile";
			include('setup/authors/authors.php');		
		break;

		case 'post':
			$title = "Create a Post";
			include('setup/post/post.php');		
		break;

		case 'add_edit_post':
			$title = "Create/Update a Post";
			include('setup/post/add_edit_post.php');		
		break;

		case 'comment_manager':
			$title = "Comment Manager";
			include('setup/comment_manager/comment_manager.php');		
		break;
						
		default:
		include('signin/signin.php');
	}
    

?>