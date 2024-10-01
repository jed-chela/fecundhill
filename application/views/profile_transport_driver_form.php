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
          <h4 class="font-alt">TRANSPORT</h4>
          <hr class="divider-w mb-10">
          <?php
          if (isset($form_error)) {
            if ($form_error != "") {
              echo $form_error;
            }
          }
          ?>
        </div>

        <?php
        // Check if Account has been verified
        $verify_account_status = $this->Users->getVerifyAccountInfoByID($this->Users->getUserID());

        if ($verify_account_status['status'] == 9) {
          echo "<p>You need to verify your email address to enable your account! An email was sent to " . $verify_account_status['email'] . " inbox when you registered. The email contains the verification link. Check your spam folder also, just in case. </p>";
        } else {
          ?>
          <?php
            // Check if Account has Super Admin or Sub Admin Access
            ?>

          <?php

            // Messages and Notifications

            ?>

          <div class='col-sm-12 mb-sm-12'>
            <div class="col-lg-12">
              <a href="<?php echo base_url(); ?>profile/transport_home" class="btn btn-primary btn-xs">
                Back
              </a>
            </div>
          </div>

          <div class='col-sm-12 mb-sm-12'>
            <br/>
            <hr class="divider-w mb-40">
          </div>

          <h4 class='col-sm-12'><b> Driver Signup Form</b></h4>
          <div class='col-sm-11'>
            <div class='col-sm-10 mb-sm-8'>
              <form method="post" enctype="multipart/form-data">

                <div class="row mb-10">
                  <?php
                    if (isset($direct_message_error)) {
                      if ($direct_message_error != "") {
                        echo $direct_message_error;
                      }
                    }
                    ?>
       
                </div>
                <div class="row">
                  <div class="text-danger">
                    <div><b>The following are required:</b></div>
                    <div>1. 27 years of age or older</div>
                    <div>2. Minimum of 3 years driving Experience </div>
                    <div>3. Pass criminal background checks </div>
                    <div>4. Decent and friendly </div>
                  </div>
                  <div class="form-group mb-10">
                    <label for="driver_town">Intended Town / City of Operation</label>
                    <input class="form-control" type="text" name="driver_town" id="driver_town" required style="text-transform: none;" required>
                  </div>
                  <div class="form-group mb-10">
                    <label for="driver_years">Driving Experience (Years)</label>
                    <input class="form-control" type="number" name="driver_years" id="driver_years" value="" style="text-transform: none;" required>
                  </div>
                  
<div class="form-group mb-10">
  <label for="file_upload1">Upload Passport Photograph (Max File Size of 2MB each)(.jpg, .jpeg, .png, or .pdf only)</label>
  <input type="file" class="form-control" name="file_passport[]" id="file_upload1" accept=".pdf,image/*" required >
</div>

<div class="form-group mb-10">
  <label for="file_upload2">Upload Utility Bill (Max File Size of 2MB each)(.jpg, .jpeg, .png, or .pdf only)</label>
  <input type="file" class="form-control" name="file_utility[]" id="file_upload2" accept=".pdf,image/*" required >
</div>

<div class="form-group mb-10">
  <label for="file_upload3">Upload Valid National ID (Max File Size of 2MB each)(.jpg, .jpeg, .png, or .pdf only)</label>
  <input type="file" class="form-control" name="file_nid[]" id="file_upload3" accept=".pdf,image/*" required >
</div>

<div class="form-group mb-10">
  <label for="file_upload4">Upload Valid Driver's License (Max File Size of 2MB each)(.jpg, .jpeg, .png, or .pdf only)</label>
  <input type="file" class="form-control" name="file_dlicense[]" id="file_upload4" accept=".pdf,image/*" required >
</div>

                  <div class="form-group">
                    <input type="submit" name="driver_form_submit" class="btn btn-primary">
                  </div>

                </div>

              </form>
            </div>
          </div>
          <hr class="divider-w mb-10">

        <?php

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

  <script src="<?php echo base_url(); ?>assets/js/typeahead/jquery.typeahead.min.js"></script>

  