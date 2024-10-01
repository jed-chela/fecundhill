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
          <h2 class="font-alt">ABOUT FECUNDHILL REAL ESTATE</h2>
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

              <h3>Real Estate</h3>
              <p class="align-left">

                Fecundhill guides investors in safely navigating the waters of real estate to ensure a maximum return on investment. Our hallmarks in quality assurance, commitment to specifications, and delivery on schedule are a testament to our vision, mission, and core values. 

              <div class="form-group">
                <a href="<?php echo base_url(); ?>auth/login" class="btn btn-round btn-b">Request</a>
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