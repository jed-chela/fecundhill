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
          <h4 class="font-alt">FINANCE</h4>
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

            // Create A New Listing

                /* 
                
                Service/Product Title
                Service/Product Details
                Price
                Location
                Listing Level: Fecundhill/Premium(VIP)/Regular
                Contact Phone number

                */
                ?>

              <div class='col-sm-12 mb-sm-12'>
                <div class="col-lg-12">
                  <a href="<?php echo base_url(); ?>profile/finance_section_hire_purchase" class="btn btn-primary btn-xs">
                    Back
                  </a>
                </div>
              </div>

              <hr class="divider-w mb-10">
              <h2 class='col-sm-12'><b>HIRE PURCHASE NEW LISTING</b></h2>
              <div class='col-sm-12'>
                <div class='col-sm-12'>
                  <form method="post" enctype="multipart/form-data">

                    <div class="row mb-10">
                      <?php
                            if (isset($new_listing_error)) {
                              if ($new_listing_error != "") {
                                echo $new_listing_error;
                              }
                            }
                            ?>
                    </div>
                    <div class="row">
                      <div class="form-group hidden">
                        <label>Category</label>
                        <select class="form-control" name="listing_category" required>
                          
                            <option value="3" selected >Finance</option>
                        
                        </select>
                      </div>
                      <div class="form-group mb-10">
                        <label for="msg_subject">Service/Product Title</label>
                        <input class="form-control no-textupper" type="text" name="listing_title" required >
                      </div>
                      <div class="form-group mb-10">
                        <label for="msg_subject">Details</label>
                        <textarea class="form-control no-textupper" name="listing_details" rows=4 required ></textarea>
                      </div>
                      <div class="form-group mb-10">
                        <label for="msg_subject">Price (Optional. Will be shown as Negotiable if omitted)</label>
                        <input class="form-control no-textupper" type="number" name="listing_price" >
                      </div>
                      <div class="form-group">
                        <input class="" id="listing_negotiable" type="checkbox" name="listing_negotiable" value=1 />
                        <label for="listing_negotiable">Price is Negotiable</label>
                      </div>
                      <div class="form-group">
                        <label>Payment Plan</label>
                        <select class="form-control" name="listing_extra" required>
                            <option value="" >- Select -</option>
                            <option value="Daily" >Daily</option>
                            <option value="Weekly" >Weekly</option>
                            <option value="Monthly" >Monthly</option>
                        
                        </select>
                      </div>
                      <div class="form-group mb-10 hidden">
                        <label>Location Country</label>
                        <?php $data_state['selected_value'] = "";
                              $countries_data = $this->load->view("includes/nationality", $data_state, true); ?>
                        <select class="form-control" name="listing_country">
                          <?php echo $countries_data; ?>
                        </select>
                      </div>
                      <div class="form-group mb-10">
                        <label>Location State</label>
                        <?php $data_state['selected_value'] = "";
                              $states_data = $this->load->view("includes/states", $data_state, true); ?>
                        <select class="form-control" name="listing_location" required>
                          <?php echo $states_data; ?>
                        </select>
                      </div>
                      <div class="form-group mb-10">
                        <label>Location Details</label>
                        <input class="form-control no-textupper" type="text" name="listing_location_details" id="msg_subject" required >
                      </div>
                      <div class="form-group mb-10">
                        <label for="msg_body">Contact Phone Number</label>
                        <input class="form-control no-textupper" type="text" name="listing_phone" required >
                      </div>
                      
                      <div class="form-group mb-10">
                        <label for="referral_code">Referral Code (Optional)</label>
                        <input class="form-control" type="text" name="referral_code" id="referral_code" style="text-transform: none;" >
                      </div>

                      <div class="form-group mb-10">
                        <label for="file_upload">Upload Photos (Max File Size of 2MB each. Please Note that Files larger than 2MB won't be uploaded and attached to the message)</label>

                        <input type="file" class="form-control" name="file_upload[]" id="file_upload" accept=".png,.jpg,.jpeg" multiple required>
                      </div>
                      
                      <div class="form-group">
                        <input type="submit" name="new_listing_submit" class="btn btn-primary" disabled>
                      </div>
                      
                    </div>
                    
                  </form>
                </div>
              </div>
              <hr class="divider-w mb-10">
              
        <?php
          // Verify Account Check
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