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
          <h4 class="font-alt">CREATE A PROPERTY LISTING</h4>
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
            $partner_account = $this->Partner->getAccount($this->Users->getUserID());
            if ($partner_account !== false) {

              if ($partner_account['enabled'] == 0) {
                echo '<p class="text-success col-sm-11 col-sm-offset-1"><b>You Have Requested for A Partner Account. Fecundhill Admin will review your request and make a decision shortly.</b></p>';
              } else if ($partner_account['enabled'] == 2) {
                echo '<p class="text-danger col-sm-11 col-sm-offset-1"><b>Your Request has been REJECTED by Fecundhill Admin</b></p>';
              } else if ($partner_account['enabled'] == 1) {
                echo '<p class="text-danger col-sm-11 col-sm-offset-1"><b>Please note that all listings you post will be subject to review by Fecundhill Admin before they are displayed on the website</b></p>';

                /* 
                
                Service/Product Title
                Service/Product Details
                Price
                Location
                Listing Level: Fecundhill/Premium(VIP)/Regular
                Contact Phone number

                */
                ?>

              <hr class="divider-w mb-10">
              <h4 class='col-sm-12 col-sm-offset-1 mb-sm-10'>Create a Property Listing Form</h4>
              <div class='col-sm-11 col-sm-offset-2 mb-sm-9'>
                <div class='col-sm-10 mb-sm-8'>
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
                      <div class="form-group" hidden>
                        <label>Category</label>
                        <select class="form-control" name="listing_category" required>
                          <?php
                            if ($partner_account['category'] == "Real Estate") {
                          ?>
                            <option value="1">Real Estate</option>
                          <?php
                            }
                          ?>
                          <?php
                            if ($partner_account['category'] == "Transport") {
                          ?>
                            <option value="2">Transport</option>
                          <?php
                            }
                          ?>
                          
                          
                        </select>
                      </div>
                      <div class="form-group mb-10">
                        <label for="msg_subject">Description</label>
                        <input class="form-control no-textupper" type="text" name="listing_title" required >
                      </div>
                      <div class="form-group mb-10">
                        <label for="msg_subject">Features</label>
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
                      <div class="form-group mb-10 hidden">
                        <label>Location Country</label>
                        <?php 
                          $data_state['selected_value'] = "";
                          //    echo $this->load->view("includes/nationality", $data_state); 
                        ?>
                        <select class="form-control" name="listing_country">
                          <option value="Nigeria">Nigeria</option>
                        </select>
                      </div>
                      <div class="form-group mb-10">
                        <label>Location State</label>
                        <?php 
                          $data_state['selected_value'] = "";
                          $states_opt = $this->load->view("includes/states", $data_state, true); 
                        ?>
                        <select class="form-control" name="listing_location" required>
                          <?php echo $states_opt; ?>
                        </select>
                      </div>
                      <div class="form-group mb-10">
                        <label>Location Details (Optional)</label>
                        <input class="form-control no-textupper" type="text" name="listing_location_details" id="msg_subject" >
                      </div>
                      <div class="form-group mb-10">
                        <label for="msg_body">Contact Phone Number</label>
                        <input class="form-control no-textupper" type="text" name="listing_phone" required >
                      </div>
                      <div class="form-group mb-10">
                        <label for="file_upload">Upload Photos (Max File Size of 2MB each. Please Note that Files larger than 2MB won't be uploaded and attached to the message)</label>

                        <input type="file" class="form-control" name="file_upload[]" id="file_upload" accept=".png,.jpg,.jpeg" multiple>
                      </div>
                      
                      <div class="form-group">
                        <input type="submit" name="new_listing_submit" class="btn btn-primary">
                      </div>
                      
                    </div>
                    
                  </form>
                </div>
              </div>
              <hr class="divider-w mb-10">
              
          <?php
                // Partner Account Enabled Check
              }
            }else{
              echo '<p class="text-danger col-sm-11 col-sm-offset-1"><b>You do NOT have a Partner Account. Only Partners can create Listings</b></p>';
            }
          ?>
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