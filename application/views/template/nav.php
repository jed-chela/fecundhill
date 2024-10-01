<nav class="navbar navbar-custom navbar-fixed-top navbar-transparent" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php
      if (isset($logo_color)) {
        if ($logo_color == "white") {
          echo "<a class='navbar-brand' href='" . base_url() . "'><img src='" . base_url() . "assets/images/logo220x100a.png' /></a>";
        } else {
          echo "<a class='navbar-brand' href='" . base_url() . "'>Fecundhill</a>";
        }
      } else {
        echo "<a class='navbar-brand' href='" . base_url() . "'><img src='" . base_url() . "assets/images/logo220x100b.png' /></a>";
      }
      ?>

    </div>
    <div class="collapse navbar-collapse" id="custom-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class=""><a class="" href="<?php echo base_url(); ?>">Home</a></li>
        <li class="dropdown"><a class="dropdown-toggle" href="<?php echo base_url(); ?>about" data-toggle="dropdown">About</a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url(); ?>about">Who We Are</a></li>
            <li><a href="<?php echo base_url(); ?>about#vision_mission">Mission & Vision</a></li>
            <li><a href="<?php echo base_url(); ?>about#management">Management</a></li>
            <!--    <li><a href="<?php echo base_url(); ?>about#partners">Partners</a></li>   
            <li><a href="<?php echo base_url(); ?>about#testimonials">Testimonials</a></li>   -->
          </ul>
        </li>

        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Services</a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url(); ?>welcome/about_finance">Finance</a></li>
            <li><a href="<?php echo base_url(); ?>welcome/about_real_estate">Real Estate</a></li>
            <li><a href="<?php echo base_url(); ?>welcome/about_transport">Transport</a></li>
          </ul>
        </li>

        <?php /*
        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Services</a>
          <ul class="dropdown-menu">
            <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Finance</a>
              <ul class="dropdown-menu">
                <li><a href="about1.html">Savings</a></li>
                <li><a href="about2.html">Loans</a></li>
                <li><a href="about3.html">Fecundvest</a></li>
              </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Civil Engineering</a>
              <ul class="dropdown-menu">
                <li><a href="service1.html">Real Estate Listings</a></li>
                <li><a href="service2.html">Civil Engineering Services Listings</a></li>
              </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Assisted Transport</a>
              <ul class="dropdown-menu">
                <li><a href="pricing1.html">Car Hire</a></li>
                <li><a href="pricing2.html">Truck Hire</a></li>
                <li><a href="pricing2.html">Transport Services Listings</a></li>
              </ul>
            </li>

          </ul>
        </li>
*/ ?>
        <li><a href="<?php echo base_url(); ?>auth/login">Login</a></li>
        <li><a href="<?php echo base_url(); ?>auth/login#register">Register</a></li>
        <!--        <li><a href="faq.html">FAQ</a></li> -->
      </ul>

    </div>
  </div>
</nav>