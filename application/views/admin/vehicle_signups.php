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
          <h4 class="font-alt">VEHICLE SIGNUP REQUESTS</h4>
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
            // Messages and Notifications

            $exclude_rejected = true;
            $vehicle_signup_requests = $this->Listing->getAllVehicleSignupRequests($exclude_rejected);

            ?>


          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>

            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-border checkout-table dataTable table-responsive">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>City</th>
                      <th>Brand</th>
                      <th>Model</th>
                      <th>Model Year</th>
                      <th>Color</th>
                      <th>Passenger Capacity</th>
                      <th>Plate</th>
                      <th>Profile</th>
                      <th>Documents</th>
                      <th>Date</th>
                      <?php   /*   <th>Opened</th>  */ ?>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $o = "";
                      if ($vehicle_signup_requests !== false) {
                        foreach ($vehicle_signup_requests as $index => $req) {

                            $user_label = $this->Personal->userName($req['user_id']);

                            $author = $this->Partner->getPartnerAccount($this->Partner->getPartnerID($req['user_id']));
                            if ($author !== false) {
                              $author_label = $author["business_name"];
                            }

                            $author_label = $user_label;

                            $attachment_count_label = "None";
                            $attachments = $this->Listing->getVehicleSignupFiles($req['id']);
                            if ($attachments !== false) {
                              $attachment_count_label = count($attachments);
                            }
                            
                            
                            $o .= "<tr>";
                              $o .= "<td>" . ($index + 1) . "</td>";
                              $o .= "<td>" . $author_label . "</td>";
                              $o .= "<td>" . $req['vehicle_town'] . "</td>";
                              $o .= "<td>" . $req['vehicle_brand'] . "</td>";
                              $o .= "<td>" . $req['vehicle_model'] . "</td>";
                              $o .= "<td>" . $req['vehicle_model_year'] . "</td>";
                              $o .= "<td>" . $req['vehicle_color'] . "</td>";
                              $o .= "<td>" . $req['vehicle_passengers'] . "</td>";
                              $o .= "<td>" . $req['vehicle_plate'] . "</td>";
                              $o .= "<td>" . "<a href='".base_url()."admin/view_profile/".$req['user_id']."' target='_blank' class='btn btn-xs btn-default' title='View'><i class='fa fa-eye'></i></a> </td>";
                              $o .= "<td>";
                                foreach($attachments as $file){
                                  $file_name = $file['file_name'];
                                  $file_name_arr = explode("_",$file_name);
                                  $file_category = firstLetterToCaps($file_name_arr[2]);
                                  $o .= "<a href='".base_url()."uploads/vehicle/".$file['file_name']."' target='_blank' class='btn btn-lg btn-warning btn-thin' title='View ".$file_category."'><i class='fa fa-file-pdf-o'></i></a>&nbsp;";
                                }
                                
                              $o .= "</td>";
                              $o .= "<td title='" . getfulldateinfo_Type1($req['time_updated']) . "'>" . date("d/m/Y", strtotime($req['time_updated'])) . "</td>";


                              $approval_label = "<span class='label label-default'>Under Review</span>";
                              if($req["status"] == 1){$approval_label = "<span class='label label-success'>Approved</span>"; }
                              if($req["status"] == 2){$approval_label = "<span class='label label-danger'>Rejected</span>"; }
                              if($req["status"] == 3){$approval_label = "<span class='label label-warning'>Suspended</span>"; }

                              $o .= "<td>".$approval_label."</td>";

                              $o .= "<td>";
                              $o .= "<a href='".base_url()."admin/view_profile/".$req['user_id']."' target='_blank' class='btn btn-xs btn-default' title='View Profile'><i class='fa fa-eye'></i></a> ";

                              $o .= "<form method='post' style='display:inline;' >";
                                $o .= "<input type='hidden' name='vehicle_req_id' value='" . $req['id'] . "' />";
                                if (($req["status"] == 0) || ($req["status"] == 2) || ($req["status"] == 3) ){
                                  $o .= "<button type='submit' name='approve_request_but' title='Approve Request' value='Approve' class='btn btn-xs btn-default btn-success' ><i class='fa fa-check' ></i></button> ";
                                }
                                if (($req["status"] == 0) || ($req["status"] == 3)){
                                  $o .= "<button type='submit' name='decline_request_but' title='Reject Request' value='Reject' class='btn btn-xs btn-default btn-danger' ><i class='fa fa-warning' ></i></button>";
                                }
                                if (($req["status"] == 1)){
                                  $o .= "<button type='submit' name='suspend_request_but' title='Suspend' value='Suspended' class='btn btn-xs btn-default btn-warning' ><i class='fa fa-close' ></i></button>";
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