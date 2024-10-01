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
          <h4 class="font-alt"><?= $booking_type ?> BOOKING REQUESTS</h4>
          <hr class="divider-w mb-10">
          <?php
          if (isset($request_service_form_error)) {
            if ($request_service_form_error != "") {
              echo $request_service_form_error;
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

            $booking_requests = $this->Listing->getAllBookingRequestsByType($booking_type);

            ?>


          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>

            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-border checkout-table dataTable table-responsive">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Client</th>
                      <th>Departure</th>
                      <th>Destination</th>
                      <th>Trip</th>
                      <th>Passengers</th>
                      <th>Dep. Time</th>
                      <th>Ret. Time</th>
                      <th>Luggage</th>
                      <th>Health</th>
                      <th>Date</th>
                      <th>.</th>
                      <th>..</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $o = "";
                      if ($booking_requests !== false) {
                        foreach ($booking_requests as $index => $booking_req) {

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

                            $o .= "<tr>";
                            $o .= "<td>" . ($index + 1) . "</td>";
                            $o .= "<td>" . $user_label . "</td>";
                            $o .= "<td>" . $booking_req['departure'] . "</td>";
                            $o .= "<td>" . $booking_req['destination'] . "</td>";
                            $o .= "<td>" . $booking_req['trip_type'] . ($booking_req['duration'] ? " (".$booking_req['duration'].")" : "" ) . "</td>";
                            $o .= "<td>" . $booking_req['passengers'] . "</td>";
                            
                            $o .= "<td title='" . getfulldateinfo_Type1($booking_req['departure_time']) . "'>" . getfulldateinfo_Type1($booking_req['departure_time']) . "</td>";

                            $return_time = $booking_req['return_time'];
                            if($return_time != "0000-00-00 00:00:00"){
                              $return_time = getfulldateinfo_Type1($booking_req['return_time']);
                            }else{
                              $return_time = "";
                            }

                            $o .= "<td title='" . $return_time . "'>" . $return_time . "</td>";

                            $o .= "<td>" . $booking_req['luggage'] . "</td>";
                            $o .= "<td>" . $booking_req['health'] . "</td>";

                            $o .= "<td title='" . getfulldateinfo_Type1($booking_req['time_updated']) . "'>" . date("d/m/Y", strtotime($booking_req['time_updated'])) . "</td>";

                            $approval_label = ($booking_req["approval"] == 0)? "Pending" : "Declined";
                            if($booking_req["approval"] == 1){$approval_label = "Approved"; }
                            if($booking_req["approval"] == 3){$approval_label = "Completed"; }

                            $o .= "<td>".$approval_label."</td>";

                            $o .= "<td>";
                            $o .= "<a href='".base_url()."admin/view_profile/".$booking_req['user_id']."' target='_blank' class='btn btn-xs btn-default' title='View Profile'><i class='fa fa-eye'></i></a> ";

                            $o .= "<a href='".base_url()."admin/booking_edit/".$booking_req['id']."' target='_blank' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-edit'></i></a> ";

                            $o .= "<form method='post' style='display:inline;' >";
                            $o .= "<input type='hidden' name='booking_id' value='" . $booking_req['id'] . "' />";
                            if (($booking_req["approval"] == 0) || ($booking_req["approval"] == 2))
                              $o .= "<button type='submit' name='booking_approve_but' title='Approve Request' value='Approve' class='btn btn-xs btn-default btn-success' ><i class='fa fa-check' ></i></button> ";
                            if (($booking_req["approval"] == 0) || ($booking_req["approval"] == 1) || ($booking_req["approval"] == 3))
                              $o .= "<button type='submit' name='booking_reject_but' title='Decline Request' value='Decline' class='btn btn-xs btn-default btn-danger' ><i class='fa fa-warning' ></i></button>";
                            if (($booking_req["approval"] == 1)){
                              $o .= "<button type='submit' name='booking_complete_but' title='Completed' value='Completed' class='btn btn-xs btn-default btn-info' ><i class='fa fa-check' ></i></button>";
                            }
                            else{
                              $o .= "<button type='submit' name='booking_complete_but' title='Completed' value='Completed' disabled class='btn btn-xs btn-default btn-info' ><i class='fa fa-check' ></i></button>";
                            }
                            $o .= "</form>";
                            $o .= "</td>";
                            $o .= "</tr>";
                          
                        }
                      }

                      echo $o;
                      ?>

                  </tbody>
                </table>
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