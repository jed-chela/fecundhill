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
          <h4 class="font-alt"><?= $booking_type ?> EXPRESS DELIVERY REQUESTS</h4>
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

            $delivery_requests = $this->ExpressDelivery->read();

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
                      <th>Description</th>
                      <th>Pickup Date/Time</th>
                      <th>Pickup at</th>
                      <th>Deliver to</th>
                      <th>Tracking Status</th>
                      <th>Date Added</th>
                      <th>.</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $o = "";
                      if ($delivery_requests !== false) {
                        foreach ($delivery_requests as $index => $delivery_req) {

                            $user_label = $this->Personal->userName($delivery_req['user_id']);

                            $author = $this->Partner->getPartnerAccount($this->Partner->getPartnerID($delivery_req['user_id']));
                            if ($author !== false) {
                              $author_label = $author["business_name"];
                            }

                            $author_label = $user_label;

                        /*    $attachment_count_label = "None";
                            $attachments = $this->Listing->getBookingPhotos($delivery_req['id']);
                            if ($attachments !== false) {
                              $attachment_count_label = count($attachments);
                            }   */

                            $pickup_datetime = $delivery_req['pickup_datetime'];
                            if($pickup_datetime != "0000-00-00 00:00:00"){
                              $pickup_datetime = getfulldateinfo_Type1($delivery_req['pickup_datetime']);
                            }else{
                              $pickup_datetime = "";
                            }

                            $tracking_status_label = "<span class='label label-warning'>Pending</span>";
                            if($delivery_req["tracking_status"] == 2){
                              $tracking_status_label = "<span class='label label-success'>Completed</span>";
                            }else if($delivery_req["tracking_status"] == 3){
                              $tracking_status_label = "<span class='label label-info'>Accepted (Payment Not Confirmed)</span>";
                            }else if($delivery_req["tracking_status"] == 4){
                              $tracking_status_label = "<span class='label label-primary'>Ongoing (Payment Confirmed)</span>";
                            }else if($delivery_req["tracking_status"] == 5){
                              $tracking_status_label = "<span class='label label-danger'>Declined</span>";
                            }else if($delivery_req["tracking_status"] == 6){
                              $tracking_status_label = "<span class='label label-danger'>Canceled</span>";
                            }

                            $o .= "<tr>";
                            $o .= "<td>" . ($index + 1) . "</td>";
                            $o .= "<td>" . $user_label . "</td>";
                            $o .= "<td>" . $delivery_req['description'] . "</td>";
                            $o .= "<td title='" . $pickup_datetime . "'>" . $pickup_datetime . "</td>";
                            $o .= "<td>" . $delivery_req['pickup_location'] . "</td>";
                            $o .= "<td>" . $delivery_req['delivery_location'] . "</td>";
                            $o .= "<td>" . $tracking_status_label . "</td>";

                            $o .= "<td title='" . getfulldateinfo_Type1($delivery_req['time_updated']) . "'>" . date("d/m/Y", strtotime($delivery_req['time_updated'])) . "</td>";
                            
                            $o .= "<td style='line-height:28px;'>";
                  
                            if ($delivery_req["tracking_status"] != 1){
                              $o .= "<form method='post' style='display:inline;' >";
                                  $o .= "<button type='submit' name='express_delivery_status_but' value='Button' class='btn btn-xs btn-default btn-warning' > Pending </button> ";
                                $o .= "<input type='hidden' name='delivery_id' value='" . $delivery_req['id'] . "' />";
                                $o .= "<input type='hidden' name='tracking_status' value='1' />";
                              $o .= "</form>";

                            }
                            
                            if (($delivery_req["tracking_status"] != 3)){
                              $o .= "<form method='post' style='display:inline;' >";
                                $o .= "<button type='submit' name='express_delivery_status_but' value='Button' class='btn btn-xs btn-default btn-info' > Accepted (Payment Not Confirmed)</button> ";
                                $o .= "<input type='hidden' name='delivery_id' value='" . $delivery_req['id'] . "' />";
                                $o .= "<input type='hidden' name='tracking_status' value='3' />";
                              $o .= "</form>";

                            }
                            if (($delivery_req["tracking_status"] != 4)){
                              $o .= "<form method='post' style='display:inline;' >";
                                $o .= "<button type='submit' name='express_delivery_status_but' value='Button' class='btn btn-xs btn-default btn-primary' > Ongoing (Payment Confirmed) </button> ";
                                $o .= "<input type='hidden' name='delivery_id' value='" . $delivery_req['id'] . "' />";
                                $o .= "<input type='hidden' name='tracking_status' value='4' />";
                              $o .= "</form>";

                            }
                            if (($delivery_req["tracking_status"] != 5)){
                              $o .= "<form method='post' style='display:inline;' >";
                                $o .= "<button type='submit' name='express_delivery_status_but' value='Button' class='btn btn-xs btn-default btn-danger' > Declined </button> ";
                                $o .= "<input type='hidden' name='delivery_id' value='" . $delivery_req['id'] . "' />";
                                $o .= "<input type='hidden' name='tracking_status' value='5' />";
                              $o .= "</form>";

                            }
                            if (($delivery_req["tracking_status"] != 6)){
                              $o .= "<form method='post' style='display:inline;' >";
                                $o .= "<button type='submit' name='express_delivery_status_but' value='Button' class='btn btn-xs btn-default btn-danger' > Canceled </button> ";
                                $o .= "<input type='hidden' name='delivery_id' value='" . $delivery_req['id'] . "' />";
                                $o .= "<input type='hidden' name='tracking_status' value='6' />";
                              $o .= "</form>";

                            }

                            if ($delivery_req["tracking_status"] != 2){
                              $o .= "<form method='post' style='display:inline;' >";
                                $o .= "<button type='submit' name='express_delivery_status_but' value='Button' class='btn btn-xs btn-default btn-success' > Completed </button> ";
                                $o .= "<input type='hidden' name='delivery_id' value='" . $delivery_req['id'] . "' />";
                                $o .= "<input type='hidden' name='tracking_status' value='2' />";
                              $o .= "</form>";

                            }
                            
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