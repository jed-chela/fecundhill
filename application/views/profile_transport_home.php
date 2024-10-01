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
if ($my_info !== false) {
  if (($my_info["surname"] == "") || ($my_info["firstname"] == "") || ($my_info["phone"] == "")) {
    $my_info = false;
  }
}
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
        </div>
        <?php
        // Check if Account has been verified
        $verify_account_status = $this->Users->getVerifyAccountInfoByID($this->Users->getUserID());

        if ($verify_account_status['status'] == 9) {
          echo "<p>You need to verify your email address to enable your account! An email was sent to " . $verify_account_status['email'] . " inbox when you registered. The email contains the verification link. Check your spam folder also, just in case. </p>";
        } else {

          ?>

          <?php
            $this->load->view("template/dashboard_nav");
            ?>

          <p class="text-danger"><br /><b>Kindly keep your profile information updated to enable us serve you better and faster</b></p>

          <?php
            // Request for a Partner Account under a Category
            /* 

*/
            ?>

      
      <?php /* Large Nav Buttons */ ?>

<!--      <div class='col-sm-12 hidden x-none'>
        
    <?php /*    <p class="text-success"><b> <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>profile/transport_booking/flight">Book a Flight</a></b></p>  */ ?>
        <p class="text-success"><b> <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>profile/express_delivery">Express Delivery</a></b></p>

      </div>    -->

      <div class='col-sm-12'>
        
        <p class="text-success"><b> <a class="btn btn-success btn-lg" href="<?php echo base_url(); ?>profile/transport_booking/ride">Book an Executive Ride</a></b></p>

      </div>
<?php /*
      <div class='col-sm-12'>
        
        <p class="text-success"><b> <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>profile/transport_driver_form">Signup to be a Driver</a></b></p>

      </div>
*/ ?>
      <div class='col-sm-12'>
        
        <p class="text-success"><b> <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>profile/transport_vehicle_form">Executive Ride-Hailing Partnership Signup</a></b></p>

      </div>

       
          <?php
/* 
            $partner_account = $this->Partner->getAccount($this->Users->getUserID());
            if ($partner_account !== false) {
              ?>

            <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
              <h4>Transport Partner Account</h4>
              <?php
                  if ($partner_account['enabled'] == 0) {
                    echo '<p class="text-success"><b>You Have Requested for A Partner Account. Fecundhill Admin will review your request and make a decision shortly.</b></p>';
                  } else if ($partner_account['enabled'] == 2) {
                    echo '<p class="text-danger"><b>Your Request has been REJECTED by Fecundhill Admin</b></p>';
                  } else if ($partner_account['enabled'] == 1) {
                    if ($partner_account['category'] == "Transport") {
                      echo '<p class="text-success"><b>Your Transport Partner Account is now Enabled. 
                    <br>Please note that all listings you post will be subject to review by Fecundhill Admin before they are displayed on the website</b></p>';
                    } else {
                      echo '<p class="text-danger"><b>Your Partner Account is Not in the Transport Category</b></p>';
                    }
                  }
                  ?>
            </div>
          <?php
            } else {
              ?>
              
            <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
              <form class="form" method="POST" style="overflow: hidden;">
                <h4>New Partner Account Request Form</h4>
                <?php
                    if (isset($request_partner_form_error)) {
                      if ($request_partner_form_error != "") {
                        echo $request_partner_form_error;
                      }
                    }
                    ?>
                <?php
                    if ($my_info !== false) {
                      ?>
                  <div class='col-sm-10 mb-sm-10' style="border: 1px solid #DDD;">
                    <div class="form-group">
                      <label>Business Name</label>
                      <input class="form-control no-textupper" type="text" name="business_name" placeholder="Business Name" value="" required />
                    </div>
                    <div class="form-group">
                      <label>Owner Name</label>
                      <input class="form-control no-textupper" type="text" name="owner_name" placeholder="Owner Name" value="" required />
                    </div>
                    <div class="form-group">
                      <label>Functional Email Address</label>
                      <input class="form-control no-textupper" type="text" name="email" value="" required />
                    </div>
                    <div class="form-group">
                      <label>Functional Phone Number</label>
                      <input class="form-control no-textupper" type="text" name="phone" value="" required />
                    </div>
                    <div class="form-group">
                      <label>Business Address</label>
                      <textarea name="address" class="form-control no-textupper" value="" required></textarea>
                    </div>
                    <div class="form-group">
                      <label>Country</label>
                      <select class="form-control" name="country" required>
                        <?php $data_nat['selected_value'] = "";
                              echo $this->load->view("includes/nationality", $data_nat); ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>State</label>
                      <select class="form-control" name="state" required>
                        <?php $data_state['selected_value'] = "";
                              echo $this->load->view("includes/states", $data_state); ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>City/Town</label>
                      <input class="form-control no-textupper" type="text" name="city" value="" required />
                    </div>
                    <div class="form-group">
                      <label>Description of the Business Services</label>
                      <textarea name="description" class="form-control no-textupper" value="" required></textarea>
                    </div>
                    <div class="form-group">
                      <label>Category of Interest to Partner with Fecundhill</label>
                      <select class="form-control" name="category" required>
                        <option>Transport</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Major Sector/Industry that your business operates in</label>
                      <select class="form-control" name="industry" required>
                        <option value="">-- Select One --</option>
                        <option>Other</option>
                        <option>Aerospace</option>
                        <option>Agriculture</option>
                        <option>Arms</option>
                        <option>Automotive</option>
                        <option>Broadcasting</option>
                        <option>Chemical</option>
                        <option>Computer</option>
                        <option>Construction</option>
                        <option>Defense</option>
                        <option>Education</option>
                        <option>Electrical power</option>
                        <option>Electronics</option>
                        <option>Energy</option>
                        <option>Entertainment</option>
                        <option>Film</option>
                        <option>Financial services</option>
                        <option>Fishing</option>
                        <option>Food</option>
                        <option>Health care</option>
                        <option>Hospitality</option>
                        <option>Information</option>
                        <option>Insurance</option>
                        <option>Internet</option>
                        <option>Mass media</option>
                        <option>Mining</option>
                        <option>Music</option>
                        <option>News Media</option>
                        <option>Petroleum</option>
                        <option>Pharmaceutical</option>
                        <option>Publishing</option>
                        <option>Pulp and paper</option>
                        <option>Shipbuilding</option>
                        <option>Software</option>
                        <option>Steel</option>
                        <option>Telecommunications</option>
                        <option>Textile</option>
                        <option>Timber</option>
                        <option>Tobacco</option>
                        <option>Transport</option>
                        <option>Water</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Select your means of Identification &nbsp; &nbsp; &nbsp; </label>
                      National ID Card: <input class="" id="identificationnid" type="radio" name="identification" value="National ID Card" />
                      &nbsp; National Driver's License: <input class="" id="identificationndl" type="radio" name="identification" value="National Drivers License" />
                      &nbsp; International Passport: <input class="" id="identificationip" type="radio" name="identification" value="International Passport" />
                      &nbsp; Staff ID Card: <input class="" id="identificationsid" type="radio" name="identification" value="Staff ID Card" />
                      &nbsp; Other: <input class="" id="identificationoth" type="radio" name="identification" value="Other" />
                    </div>

                    <div class="form-group">
                      <label>Mention Your Relevant Certification if Any</label>
                      <textarea name="certification" class="form-control no-textupper" value="" maxlength="500" required></textarea>
                    </div>

                    <div class="form-group">
                      <label>Do you have a Lockup shop?</label>
                      <select class="form-control" name="lockup_shop" required>
                        <option>No</option>
                        <option>Yes</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Which bank account type do you operate for your business?</label>
                      <select class="form-control" name="bank_account_type" required>
                        <option value="">--Select One--</option>
                        <option>Current Account</option>
                        <option>Savings Account</option>
                        <option>Corporate Account</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Do you have a functional bank cheque book for the account?</label>
                      <select class="form-control" name="cheque_book" required>
                        <option value="">--Select One--</option>
                        <option>Yes</option>
                        <option>No</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <input class="" id="partner_confirm" type="checkbox" name="partner_confirm" value="" required />
                      <label for="partner_confirm">I have cross-checked and ensured that the values entered above are accurate and reliable! </label>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-round btn-b" type="submit" name='request_partner_but' value="Send Request">Send Request</button>
                    </div>
                  </div>
                <?php
                    } else {
                      echo "<p class='text-danger'> Edit/Update your profile information such as <b>Surname</b> and <b>First Name</b> and <b>Phone Number (1)</b> to access this feature.</p>";
                    }
                    ?>
              </form>
              <hr />
            </div>
      </div>
    <?php
      }
      ?>

    <?php
      // Create a New Listing

      /* 
                Name 
                Email 
                Phone number 
                Required services


                Service/Product Title
                Service/Product Details
                Price
                Location
                Listing Level: Fecundhill/Premium(VIP)/Regular


                Specifications:
                  Property Type: Duplex House
                  New Property: No
                  Total Rooms: 5
                  Bedrooms: 5
                  Bathrooms: 5
                  Furnishing: Unfurnished
                  Parking Space: Yes
                  Broker Fee: Yes

              */

      ?>


    <?php /*
      $partner_account = $this->Partner->getAccount($this->Users->getUserID());
      if ($partner_account !== false) {
        ?>
      <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>

        
        <h4>Create a Listing</h4>
        <p class="text-success"><b> <a class="btn btn-info" href="<?php echo base_url(); ?>profile/new_listing">Create a New Listing</a></b></p>

        <h4>View all my Listings</h4>
        <p class="text-success"><b> <a class="btn btn-default" href="<?php echo base_url(); ?>profile/listings">View My Listings</a></b></p>

      <?php
        } */
        ?>

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



  <script type="text/javascript">
    computeFigures = function() {
      var amount = Number($("#loan_amount").val());

      if ((amount != "")) {
        if (typeof amount == "number") {

          $("#loan_amount").val(amount);

        }

        if (isNaN(amount)) {

          $("#loan_amount").val("0");

        }

        amount = Number($("#loan_amount").val())

        if (amount > 0) {
          // Compute Interest

        }
      }
    }

    $(function() {

      computeFigures();

      $("body").on("keyup", "#loan_amount", function() {
        computeFigures();
      })
      $("body").on("click", "#loan_amount", function() {
        computeFigures();
      })
    });


    function escapeHtml(unsafe) {
      return $('<div />').text(unsafe).html();
    }

    function unescapeHtml(safe) {
      return $('<div />').html(safe).text();
    }
  </script>