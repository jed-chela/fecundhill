<?php
$this->load->view("template/profile_headlinks");
?>

<?php
$this->load->view("template/profile_nav");
?>

<?php
$this->load->view("template/slider_empty");
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui-timepicker-addon.css">


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
          <h4 class="font-alt">EDIT BOOKING REQUEST</h4>
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
            // Booking
            $booking_req = $this->Listing->getBooking($booking_id);
          ?>

          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>

            <div class="row">
              <div class="col-sm-12">
                <form method="post" enctype="multipart/form-data">
                <ul>
                    <?php

                      $o = "";
                      if ($booking_req !== false) {

                            $user_label = $this->Personal->userName($booking_req['user_id']);

                            $author = $this->Partner->getPartnerAccount($this->Partner->getPartnerID($booking_req['user_id']));
                            if ($author !== false) {
                              $author_label = $author["business_name"];
                            }

                            $author_label = $user_label;

                            $service_label = firstLetterToCaps($booking_req['type']);

                        /*    $attachment_count_label = "None";
                            $attachments = $this->Listing->getBookingPhotos($booking_req['id']);
                            if ($attachments !== false) {
                              $attachment_count_label = count($attachments);
                            }   */

                            $o .= "<li><span class='col-sm-2'>Client: </span>" . $user_label . "</li>";
                            $o .= "<li><span class='col-sm-2'>Departure: </span>" . $booking_req['departure'] . "</li>";
                            $o .= "<li><span class='col-sm-2'>Destination: </span>" . $booking_req['destination'] . "</li>";
                            $o .= "<li><span class='col-sm-2'>Trip: </span>" . $booking_req['trip_type'] . "</li>";
                            $o .= "<li><span class='col-sm-2'>Duration (for Charter only): </span>" . $booking_req['duration'] . "</li>";
                            $o .= "<li><span class='col-sm-2'>No of Passengers: </span>" . $booking_req['passengers'] . "</li>";
                            
                            $o .= "<li title='" . getfulldateinfo_Type1($booking_req['departure_time']) . "'><span class='col-sm-2'>Departure Time: </span>" . getfulldateinfo_Type1($booking_req['departure_time']) . "</li>";

                            $return_time = $booking_req['return_time'];
                            if($return_time != "0000-00-00 00:00:00"){
                              $return_time = getfulldateinfo_Type1($booking_req['return_time']);
                            }else{
                              $return_time = "";
                            }

                            $o .= "<li title='" . $return_time . "'><span class='col-sm-2'>Return Time: </span>" . $return_time . "</li>";

                            $o .= "<li><span class='col-sm-2'>Luggage Info: </span>" . $booking_req['luggage'] . "</li>";
                            $o .= "<li><span class='col-sm-2'>Health Info: </span>" . $booking_req['health'] . "</li>";

                            $o .= "<li title='" . getfulldateinfo_Type1($booking_req['time_updated']) . "'><span class='col-sm-2'>Booking Date: </span>" . date("d/m/Y", strtotime($booking_req['time_updated'])) . "</li>";

                            $approval_label = ($booking_req["approval"] == 0)? "Pending" : "Declined";
                            if($booking_req["approval"] == 1){$approval_label = "Approved"; }

                            $o .= "<li><span class='col-sm-2'>Approval Status: </span>".$approval_label."</li>";

                      }

                      echo $o;
                      ?>

                  </ul>

                  <div class="form-group mb-10">
                    <input class="form-control" type="hidden" name="booking_id" value="<?= $booking_id ?>" readonly required>
                  </div>
                  <div class="form-group mb-10">
                    <label for="departure_time">Preferred Date / time of departure</label>
                    <input class="form-control" type="text" name="departure_time" id="departure_time" value="" style="text-transform: none;" readonly required>
                  </div>
                  <div class="form-group mb-10">
                    <label for="return_time">Preferred Date / time of return</label>
                    <input class="form-control" type="text" name="return_time" id="return_time" value="" style="text-transform: none;" readonly >
                  </div>

                  <div class="form-group">
                    <input type="submit" name="booking_edit_but" class="btn btn-primary">
                  </div>

                </form>
              </div>
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
    });

  </script>