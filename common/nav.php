
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
          <span class="text-primary" style="font-size: 28px;">এ.টি.এস পাবলিক স্কুল<br><small style="float: right; margin-top: -20px;  font-size: 18px; padding-right: 25px;">বাংলা মাধ্যম কো-এডুকেশনাল</small></span>

          
          <!-- <span class="text-primary" style="font-size: 14px;">বাংলা মাধ্যম কো - এডুকেশনাল </span> -->
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
            <a href="?p=vision" class="nav-item nav-link <?php if($p == 'vision'){?>active<?php } ?>">Vision</a>
            <a href="?p=admission" class="nav-item nav-link <?php if($p == 'admission'){?>active<?php } ?>">Admission</a>
            <a href="?p=facilities" class="nav-item nav-link <?php if($p == 'facilities'){?>active<?php } ?>">Facilities</a>
            <a href="?p=fees" class="nav-item nav-link <?php if($p == 'fees'){?>active<?php } ?>">Fees</a>
            <a href="?p=rules" class="nav-item nav-link <?php if($p == 'rules'){?>active<?php } ?>">Rules</a>
            <a href="?p=job_vacancy" class="nav-item nav-link <?php if($p == 'job_vacancy'){?>active<?php } ?>">Job Vacancy</a>
          </div>
          <a href="https://webmail.atspschool.in/" target="_blank" class="btn btn-primary px-4">Email Login</a>
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