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

          
          <?php
            if($param == "ride"){
          ?>
            <h4 class='col-sm-12'><b> Ride Booking Form</b></h4>

            <p class="col-sm-12">Pre-booking your ride will ensure a better experience.
              <br/>Please send a message if you'd like to reschedule your ride booking.</p>
          <?php
            }else if($param == "flight"){
          ?>
            <h4 class='col-sm-12'><b> Flight Booking Form</b></h4>
          <?php
            }
          ?>

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
                    <!-- User Instructions -->
                  </div>
                  <?php
                    if($param == "ride"){
                  ?>
                    <div class="form-group mb-10 hidden">
                      <label for="type">Ride</label>
                      <select class="form-control" name="type" id="type" required style="text-transform: none;" required>
                        <option value="ride" selected >Ride</option>
                      </select>
                    </div>
                  <?php
                    }else if($param == "flight"){
                  ?>
                    <div class="form-group mb-10 hidden">
                      <label for="type">Flight</label>
                      <select class="form-control" name="type" id="type" required style="text-transform: none;" required>
                        <option value="flight" selected >Flight</option>
                      </select>
                    </div>
                  <?php
                    }
                  ?>
                  
                  <div class="form-group mb-10">
                    <label for="">Trip Type</label>
                    <div class="col-sm-12 radio_button_holder">
            <span> One-way Trip: </span><input class="trip_type" type="radio" name="trip_type" id="" value="One way" required>
            <span> Round Trip: </span><input class="trip_type" type="radio" name="trip_type" id="" value="Round Trip" required>
            <span> Multi-destination Trip: </span><input class="trip_type" type="radio" name="trip_type" id="" value="Charter" required>
                    </div>
                  </div>
                  <div class="form-group mb-10">
                    <label for="departure">Departure City</label>
                    <input class="form-control" type="text" name="departure" id="departure" required style="text-transform: none;" required>
                  </div>
                  <div class="form-group mb-10">
                    <label for="destination">Pick-up Location  ➖️  Stop locations ➖️ Drop-off location (Landmarks)</label>
                    <input class="form-control" type="text" name="destination" id="destination" value="" style="text-transform: none;" required>
                  </div>
                  
          <?php /*        <div class="form-group mb-10 charter-only" style="display: none;">
                    <label for="duration">Duration (for Charter only)</label>
                    <input class="form-control" type="text" name="duration" id="duration" value="" style="text-transform: none;" required>
                  </div>  */ ?>
                  <div class="form-group mb-10">
                    <label for="passengers">Passenger seating capacity (4 or 6)</label>
                    <input class="form-control" type="number" name="passengers" id="passengers" value="" style="text-transform: none;" required>
                  </div>
                  <div class="form-group mb-10">
                    <label for="departure_time">Preferred Date and Time of departure</label>
                    <input class="form-control" type="text" name="departure_time" id="departure_time" value="" style="text-transform: none;" readonly required>
                  </div>
                  <div class="form-group mb-10">
                    <label for="return_time">Preferred standby termination date and time</label>
                    <input class="form-control" type="text" name="return_time" id="return_time" value="" style="text-transform: none;" readonly >
                  </div>
                  <div class="form-group mb-10 hidden x-none">
                    <label for="luggage">Luggage description</label>
                    <textarea maxlength="500" class="form-control" type="text" name="luggage" id="luggage" value="" style="text-transform: none;"></textarea>
                  </div>
                  <div class="form-group mb-10 hidden x-none">
                    <label for="health">Health Condition (if any)</label>
                    <textarea maxlength="500" class="form-control" type="text" name="health" id="health" value="" style="text-transform: none;" ></textarea>
                  </div>
                  <div class="form-group mb-10">
                    <label for="referral_code">Referral Code (Optional)</label>
                    <input class="form-control" type="text" name="referral_code" id="referral_code" style="text-transform: none;" >
                  </div>
                  <div class="form-group mb-10 text-danger">
                    <h5><b>I agree to the following terms and conditions:</b></h5>
                    <?php
                      if($param == "ride"){
                    ?>
                    <ol>
                      <li>Luggage would be limited to the vehicle’s luggage compartment. Luggage should not wiegh more than 100kg in total</li>
                      <li>An extra charge would be assessed for delays beyond departure time, standby, and detours if requested. </li>
                      <li>Ensure personal effects and luggage are not forgotten.</li>
                      <li>The ride would be halted when deemed unsafe to continue and, on a route, not motorable.</li>
                    </ol>
                    <?php
                      }else if($param == "flight"){
                    ?>
                    <ol>
                      <li>General Conditions of Carriage for Passengers and Baggage (flight ticket) apply</li>
                    </ol>
                    <?php
                      }
                    ?>
                    I agree &nbsp;<input class="" type="checkbox" name="terms_agree" id="terms_agree" value="Round Trip" required>
                  </div>

                  <div class="form-group">
                    <input type="submit" name="booking_form_submit" class="btn btn-primary">
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

  <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/typeahead/jquery.typeahead.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/timepicker/jquery.timepicker.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery-ui-timepicker-addon.js"></script>

  <script type="text/javascript">
    
$( document ).ready(function() {
  $('#departure_time').datetimepicker({
    timeInput: true,
    timeFormat: "hh:mm tt"
  });
  $('#return_time').datetimepicker({
    timeInput: true,
    timeFormat: "hh:mm tt"
  });


  // Trip type toggle
  $("body").on("click",".trip_type",function(){
    if($(this).val() == "Charter"){
      console.log("Charter Selected");
  //    $(".charter-only").css("display","block");
      $(".charter-only").fadeIn();
    }else{
      console.log("Charter NOT Selected");
  //    $(".charter-only").css("display","none");
      $(".charter-only").fadeOut();
    }
  })





});

  </script>