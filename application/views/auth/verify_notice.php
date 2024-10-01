<?php
$this->load->view("template/profile_headlinks");
?>

<?php
$this->load->view("template/profile_nav");
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
        <div class="col-sm-12 col-sm-offset-1 mb-sm-40">
          <h4 class="font-alt">EMAIL NOT YET VERIFIED</h4>
          <hr class="divider-w mb-10">
          <?php
            $verify_account_status = $this->Users->getVerifyAccountInfoByID($this->Users->getUserID());

            if ($verify_account_status['status'] == 9) {
              echo "<p>You need to verify your email address to enable your account! An email was sent to <b>" . $verify_account_status['email'] . "</b> inbox when you registered. The email contains the verification link. Check your spam folder also, just in case. </p>";
            }
          ?>
          <p>Please Verify Your Email Address with the Verification Link that was sent to your inbox after you Registered! You may contact the website administrator to resolve this issue.</p>
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