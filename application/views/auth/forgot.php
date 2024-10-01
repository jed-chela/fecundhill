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
          <h4 class="font-alt">Forgot Password</h4>
          <hr class="divider-w mb-10">
          <?php
          if (isset($forgot_error)) {
            if ($forgot_error != "") {
              echo $forgot_error;
            }
          }
          ?>
          <form class="form" method="POST">
            <label>Please enter your email address to reset your password: </label>
            <div class="form-group">
              <input class="form-control no-textupper" id="email" type="text" name="email" placeholder="Email" />
            </div>
            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='forgot_but' value="Send Password Reset Link">Send Password Reset Link</button>
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