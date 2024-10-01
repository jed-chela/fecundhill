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
          <h4 class="font-alt">DRIVER SIGNUP REQUESTS</h4>
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

            $driver_signup_requests = $this->Listing->getAllDriverSignupRequests();

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
                      <th>Town</th>
                      <th>Years</th>
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
                      if ($driver_signup_requests !== false) {
                        foreach ($driver_signup_requests as $index => $req) {

                            $user_label = $this->Personal->userName($req['user_id']);

                            $author = $this->Partner->getPartnerAccount($this->Partner->getPartnerID($req['user_id']));
                            if ($author !== false) {
                              $author_label = $author["business_name"];
                            }
                            
                            $author_label = $user_label;

                            $attachment_count_label = "None";
                            $attachments = $this->Listing->getDriverSignupFiles($req['id']);
                            if ($attachments !== false) {
                              $attachment_count_label = count($attachments);
                            }


                            $o .= "<tr>";
                              $o .= "<td>" . ($index + 1) . "</td>";
                              $o .= "<td>" . $author_label . "</td>";
                              $o .= "<td>" . $req['driver_town'] . "</td>";
                              $o .= "<td>" . $req['driver_years'] . "</td>";
                              $o .= "<td>" . "<a href='".base_url()."admin/view_profile/".$req['user_id']."' target='_blank' class='btn btn-xs btn-default' title='View'><i class='fa fa-eye'></i></a> </td>";
                              $o .= "<td>";
                                foreach($attachments as $file){
                                  $file_name = $file['file_name'];
                                  $file_name_arr = explode("_",$file_name);
                                  $file_category = firstLetterToCaps($file_name_arr[1]);
                                  $o .= "<a href='".base_url()."uploads/driver/".$file['file_name']."' target='_blank' class='btn btn-lg btn-warning btn-thin' title='View ".$file_category."'><i class='fa fa-file-pdf-o'></i></a>&nbsp;";
                                }
                                
                              $o .= "</td>";
                              $o .= "<td title='" . getfulldateinfo_Type1($req['time_updated']) . "'>" . date("d/m/Y", strtotime($req['time_updated'])) . "</td>";
                              $o .= "<td>";
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