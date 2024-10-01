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
          <h4 class="font-alt">Reset Password</h4>
          <hr class="divider-w mb-10">
          <?php
          if (isset($reset_error)) {
            if ($reset_error != "") {
              echo $reset_error;
            }
          }
          ?>
<?php /*          <form class="form" method="POST" action="<?php echo base_url(); ?>auth/handle_reset_password">  */ ?>
          <form class="form" method="POST" >
              <label>Please enter your new password: </label>
              <div class="form-group">
                <input class="form-control no-textupper" id="password" type="password" name="password" placeholder="Password" minlength="6" />
              </div>
              <div class="form-group">
                <input class="form-control no-textupper" id="re-password" type="password" name="password2" placeholder="Re-enter Password" />
              </div>
              <div class="form-group">
                <button class="btn btn-round btn-b" type="submit" name='reset_but' value="Send Password Reset Link">Reset</button>
              </div>
            </form>
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