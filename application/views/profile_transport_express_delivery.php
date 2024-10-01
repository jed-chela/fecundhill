<?php
$this->load->view("template/profile_headlinks");
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui-timepicker-addon.css">

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

          <h4 class='col-sm-12'><b> Express Delivery</b></h4>
          

          <div class='col-sm-11'>
            <div class='col-sm-10 mb-sm-8'>
              <form method="post" enctype="multipart/form-data">

                <div class="row mb-10">
                  <?php
                    if (isset($express_form_error)) {
                      if ($express_form_error != "") {
                        echo $express_form_error;
                      }
                    }
                    ?>
       
                </div>
                <div class="row">
                  <div class="text-danger">
                    <!-- User Instructions -->
                  </div>
                  
                  <div class="form-group mb-10">
                    <label for="parcel_description">Parcel Description</label>
                    <input class="form-control" type="text" name="parcel_description" id="parcel_description" required style="text-transform: none;" required>
                  </div>
                  <div class="form-group mb-10">
                    <label for="pickup_location">Pickup Location</label>
                    <input class="form-control" type="text" name="pickup_location" id="pickup_location" value="" style="text-transform: none;" required>
                  </div>
                  <div class="form-group mb-10">
                    <label for="pickup_datetime">Pickup Date / Time</label>
                    <input class="form-control" type="text" name="pickup_datetime" id="pickup_datetime" value="" style="text-transform: none;" readonly required>
                  </div>
                  <div class="form-group mb-10">
                    <label for="delivery_location">Delivery Location</label>
                    <input class="form-control" type="text" name="delivery_location" id="delivery_location" value="" style="text-transform: none;" required>
                  </div>
                  <div class="form-group mb-10 text-danger">
                    <h5><b>I accept the following terms and conditions:</b></h5>
                    <ol>
                      <li>Government issued ID may be required</li>
                      <li>The Parcel should be ready for delivery within 15min and picked Immediately</li>
                      <li>General terms and conditions of carriage apply</li>
                      
                    </ol>
                    <label for='terms_agree'>Click to accept</label> <input class="" type="checkbox" name="terms_agree" id="terms_agree" value="Express Delivery Terms" required> 
                  </div>

                  <div class="form-group">
                    <input type="submit" name="express_form_submit" class="btn btn-primary" disabled>
                  </div>

                </div>

              </form>
            </div>
          </div>
          <hr class="divider-w mb-10">

        <?php

        }
        ?>

        <div class='col-sm-12 mb-sm-12'>
          <br/>
          <hr class="divider-w mb-40">
        </div>

        <h4 class='col-sm-12'><b> Recent Pickups and Deliveries</b></h4>
        
        <?php 
          $recent = $this->ExpressDelivery->read($this->Users->getUserID(), 5);

          foreach ($recent as $key => $value) {
            $tracking_str = "<span class='label label-warning'>Pending</span>";
            if($value["tracking_status"] == 2){
              $tracking_str = "<span class='label label-success'>Completed</span>";
            }else if($value["tracking_status"] == 3){
              $tracking_str = "<span class='label label-info'>Accepted (Payment Not Confirmed)</span>";
            }else if($value["tracking_status"] == 4){
              $tracking_str = "<span class='label label-primary'>Ongoing (Payment Confirmed)</span>";
            }else if($value["tracking_status"] == 5){
              $tracking_str = "<span class='label label-danger'>Declined</span>";
            }else if($value["tracking_status"] == 6){
              $tracking_str = "<span class='label label-danger'>Canceled</span>";
            }
            echo "<div class='col-lg-12 pseudo-row-holder' >";
              echo "<row class='row pseudo-row'>";
                echo "<div class='col-md-1'>".($key+1);
                echo "</div>";
                echo "<div class='col-md-2'>".$value["description"];
                echo "</div>";
                echo "<div class='col-md-2'>".$value["pickup_location"];
                echo "</div>";
                echo "<div class='col-md-2'>".$value["delivery_location"];
                echo "</div>";
                echo "<div class='col-md-2'>".$value["pickup_datetime"];
                echo "</div>";
                echo "<div class='col-md-2'>".$tracking_str;
                echo "</div>";
              echo "</row>";
            echo "</div>";

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

  <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/typeahead/jquery.typeahead.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/timepicker/jquery.timepicker.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery-ui-timepicker-addon.js"></script>

  <script type="text/javascript">
    
    $( document ).ready(function() {
      $('#pickup_datetime').datetimepicker({
        timeInput: true,
        timeFormat: "hh:mm tt"
      });
    /*  $('#return_time').datetimepicker({
        timeInput: true,
        timeFormat: "hh:mm tt"
      }); */
    });

  </script>