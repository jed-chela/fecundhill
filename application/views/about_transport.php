<?php
$this->load->view("template/headlinks");
?>

<?php
$this->load->view("template/nav");
?>
<?php
$this->load->view("template/slider_empty");
?>

<div class="main">
  <section class="module-extra-small bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="callout-text font-alt">
            <h4 style="margin-bottom: 0px;">&nbsp;</h4>
            <p style="margin-bottom: 0px;">&nbsp;</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="module module-padding-top-off" style="padding-bottom:10px;">
    <div class="container">
      <div class="row">

        <div class="col-sm-12 col-sm-offset-0 mb-sm-40">
          <h2 class="font-alt">ABOUT FECUNDHILL TRANSPORT</h2>
          <hr class="divider-w mb-10">
        </div>


      </div>
    </div>
  </section>
  <section class="module pt-0 pb-0" id="about">
    <div class="row position-relative m-0">
      <div class="col-xs-12">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">

            <div class="module-subtitle  ">
              
              <h3>Executive Ride-Hailing</h3>

              <p class="align-center">
                Ride with Fecundhill to experience comfort, flexibility, and style that assure the best value delivery.

              </p>

              <div class="form-group">
                <a href="<?php echo base_url(); ?>auth/login" class="btn btn-round btn-b">Request</a>
              </div>

              <h3>Executive Ride Partnership</h3>

              <p class="align-center">
                Enjoy both leisure and income when you place your vehicle on our platform for ride-hailing services.
              </p>
              <div class="form-group">
                <a href="<?php echo base_url(); ?>auth/login" class="btn btn-round btn-b">Sign Up</a>
              </div>
              
            </div>
          </div>
        </div>
      </div>
  </section>


  <?php
  $this->load->view("template/footer");
  ?>
  <?php
  $this->load->view("template/footlinks");
  ?>