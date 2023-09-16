
<body>
    <div class="container-fluid bg-light position-relative shadow">
      <nav
        class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5"
      >
        <a
          href="?p=home"
          class="navbar-brand font-weight-bold text-secondary"
          style="font-size: 30px"
        >
          <!-- <i class="flaticon-043-teddy-bear"></i> -->
          <img src="img/logo.jpg" style="width: 75px;">
          <span class="text-primary"><?=$p_name?></span>
        </a>
        <button
          type="button"
          class="navbar-toggler"
          data-toggle="collapse"
          data-target="#navbarCollapse"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse justify-content-between"
          id="navbarCollapse"
        >
          <div class="navbar-nav font-weight-bold mx-auto py-0">
          <a href="?p=home" class="nav-item nav-link <?php if($p == 'home' || $p == ''){?>active<?php } ?>">Home</a>
            <a href="?p=about" class="nav-item nav-link <?php if($p == 'about'){?>active<?php } ?>">Academics</a>
            <a href="?p=classes" class="nav-item nav-link <?php if($p == 'classes'){?>active<?php } ?>">Admission</a>
            <a href="?p=notice" class="nav-item nav-link <?php if($p == 'notice'){?>active<?php } ?>">Notice Board</a>
            <a href="?p=gallery" class="nav-item nav-link <?php if($p == 'gallery'){?>active<?php } ?>">Gallery</a>
            <a href="?p=teachers" class="nav-item nav-link <?php if($p == 'teachers'){?>active<?php } ?>">Job/Vacancy</a>

            <!-- <a href="?p=home" class="nav-item nav-link <?php if($p == 'home' || $p == ''){?>active<?php } ?>">Home</a>
            <a href="?p=about" class="nav-item nav-link <?php if($p == 'about'){?>active<?php } ?>">About</a>
            <a href="?p=classes" class="nav-item nav-link <?php if($p == 'classes'){?>active<?php } ?>">Classes</a>
            <a href="?p=teachers" class="nav-item nav-link <?php if($p == 'teachers'){?>active<?php } ?>">Teachers</a>
            <a href="?p=gallery" class="nav-item nav-link <?php if($p == 'gallery'){?>active<?php } ?>">Gallery</a>
            <a href="?p=contact_us" class="nav-item nav-link <?php if($p == 'contact_us'){?>active<?php } ?>">Contact</a> -->
          </div>
          <a href="javascript: void(0);" class="btn btn-primary px-4">Email Login</a>
        </div>
      </nav>
    </div>

    <!-- 
      Website 1 - School:
a) Home Page
b) Academics
c) Admission
d) Notice Board
e) Photo Gallery
f) Job/Vacancy

-->