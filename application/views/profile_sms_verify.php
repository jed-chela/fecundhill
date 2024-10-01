<?php
$this->load->view("template/profile_headlinks");
?>

<?php
$this->load->view("template/profile_nav");
?>

<?php
$this->load->view("template/slider_empty");
?>

<?php

$my_info = $this->Personal->myPersonalInfo();
if ($my_info === false) {
  
  $this->Personal->createMyPersonalInfo();
  $my_info = $this->Personal->myPersonalInfo();
}

$user_id = $this->Users->getUserID();
$phone_verify = $this->Users->getPhoneVerify($user_id);

//  print_r($my_info);

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
  <section class="module module-padding-top-off">
    <div class="container">
      <div class="row">

        <div class="col-sm-12 col-sm-offset-0 mb-sm-40">
          <h4 class="font-alt">VERIFY YOUR ACCOUNT VIA SMS OTP</h4>
          <hr class="divider-w mb-10">
        </div>

        <?php
        if (isset($form_error)) {
          if ($form_error != "") {
            echo $form_error;
          }
        }
        ?>

        <?php
        if ($phone_verify === false) {
          // Enter Your Phone Number Form
        ?>

          <form class="form" method="POST">

            <div class="form-group">
              <label for="phone">Enter Your Phone Number without spaces</label>
              <input class="form-control no-textupper" id="phone" type="phone" name="phone" placeholder="08089123456" value="" />
            </div>

            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='send_otp' value="Send SMS OTP">Send SMS OTP</button>
            </div>

          </form>

        <?php 
        } else if($phone_verify[0]["verify"] == 2) {
          // Verification Successful
        ?>

          <h3><i class="text-success fa fa-check"></i> Your Account Has been Successfully Verified via SMS on <?= $phone_verify[0]["phone"] ?></h3>
        
        <?php 
        } else {
          // Enter the OTP that was received
        ?>

          <form class="form" method="POST">

            <div class="form-group">
              <label>Enter the OTP that was sent to <?php echo $phone_verify[0]["phone"]; ?></label>
              <input class="form-control no-textupper" id="otpcode" type="text" name="otpcode" placeholder="Enter the OTP here" value="" />
            </div>
            
            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='confirm_otp' value="Confirm">Confirm</button>
            </div>

          </form>

          <form class="form" method="POST">
            <div class="form-group">
              <label for="phone">Did not get the sms? Use a different Phone Number</label>
              <input class="form-control no-textupper" id="phone" type="phone" name="phone" placeholder="08089123456" value="" />
            </div>

            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='send_otp' value="Send SMS OTP">Send SMS OTP</button>
            </div>
          </form>

        <?php
          // Profile Enabled for Editing by User
        }

        ?>

      </div>
    </div>
  </section>



  <?php
  $this->load->view("template/footer");
  ?>
  <?php
  $this->load->view("template/footlinks");
  ?>