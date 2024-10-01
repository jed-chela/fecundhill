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
  <section class="module-small bg-dark-60" data-background="assets/images/section-4.jpg">

  </section>
  <section class="module module-padding-top-off">
    <div class="container">
      <div class="row">
        <div class="col-sm-5 col-sm-offset-1 mb-sm-40">
          <h4 class="font-alt">EMAIL ADDRESS VERIFIED SUCCESSFULLY</h4>
          <hr class="divider-w mb-10">
          <p>Your Email Address has been successfully verified!</p>
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