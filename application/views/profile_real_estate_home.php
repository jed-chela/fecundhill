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
          <h4 class="font-alt">REAL ESTATE</h4>
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



[8:31 PM, 9/15/2019] Ogboi Perfect: Details needed for Real estate partner account profile 

Personal details.
Contact details.
Means of identification.
Certification details.
》Notification of request for pictures of projects handled sent from their account to Fecundhill for speedy action
[8:32 PM, 9/15/2019] Ogboi Perfect: 》Services request without creating appropriate profile before applications (request should not be seen)?

》 notification of All services request on admin dash board 

》There should be restrictions in editing core personal details (such as name) without request/notification to admin
[8:37 PM, 9/15/2019] Ogboi Perfect: Good evening Sir. Please look into the above (but Not limited to them) for necessary recommendation and action.

*/
            ?>


      <div class='col-sm-12'>
        <p class="text-success"><b> <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>profile/published_listings/1">View Property Listings</a></b></p>
      </div>
<!--
      <div class='col-sm-12'>
        <p class="text-success"><b> <a class="btn btn-success btn-lg" href="<?php echo base_url(); ?>profile/new_special_message/real_estate">Send a Service Request</a></b></p>
      </div>  -->

<?php
//  $this->load->view("profile_new_partner_form", array("my_info" => $my_info, "request_partner_form_error" => $request_partner_form_error));
?>

          <?php

            $partner_account = $this->Partner->getAccount($this->Users->getUserID());
/*            if ($partner_account !== false) {   */
              ?>

            <div class='col-sm-12'>
    <!--          <h4>Real Estate Partner Account</h4> -->
              <?php
    /*              if ($partner_account['enabled'] == 0) {
                    echo '<p class="text-success"><b>You Have Requested for A Partner Account. Fecundhill Admin will review your request and make a decision shortly.</b></p>';
                  } else if ($partner_account['enabled'] == 2) {
                    echo '<p class="text-danger"><b>Your Request has been REJECTED by Fecundhill Admin</b></p>';
                  } else if ($partner_account['enabled'] == 1) {
                    if ($partner_account['category'] == "Real Estate") {
                      echo '<p class="text-success"><b>Your Real Estate Partner Account is now Enabled.'; */

//      echo '<br>Please note that all listings you post will be subject to review by Fecundhill Admin before they are displayed on the website</b></p>';
      /*              } else {
                      echo '<p class="text-danger"><b>Your Partner Account is Not in the Real Estate Category</b></p>';
                    }
                  } */
                  ?>
            </div>
          <?php
//            } else {
              ?>


<?php
//  $this->load->view("profile_new_partner_form", array("my_info" => $my_info, "request_partner_form_error" => $request_partner_form_error));
?>

           
    <?php
//      }
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

    <?php
//      $partner_account = $this->Partner->getAccount($this->Users->getUserID());
//      if ($partner_account !== false) {
    ?>

      <div class='col-sm-12'>
        <p class="text-success"><b> <a class="btn btn-info btn-lg" href="<?php echo base_url(); ?>profile/new_listing">Create a Property Listing</a></b></p>
      </div>
<!--
      <div class='col-sm-12'>
        <p class="text-success"><b> <a class="btn btn-default btn-lg" href="<?php echo base_url(); ?>profile/listings">View My Listings</a></b></p>
      </div>    -->


    <?php
//      }
    ?>

    <?php

    }
    ?>


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