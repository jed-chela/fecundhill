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
          <h4 class="font-alt">REQUESTS TO ACQUIRE LISTINGS</h4>
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

            $listing_requests = $this->Listing->getAllListingRequests();

            ?>


          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>

            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-border checkout-table dataTable table-responsive">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Category</th>
                      <th>Title</th>
                      <th>Request By</th>
                      <th>Author</th>
                      <th>Photos</th>
                      <th>Date</th>
                      <?php   /*   <th>Opened</th>  */ ?>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $o = "";
                      if ($listing_requests !== false) {
                        foreach ($listing_requests as $index => $listing_req) {

                          $listing = $this->Listing->getListing($listing_req['listing_id']);
                          if ($listing !== false) {

                            $user_label = $this->Personal->userName($listing_req['user_id']);

                            $author = $this->Partner->getPartnerAccount($listing['partner_id']);
                            if ($author !== false) {
                              $author_label = $author["business_name"];
                            }

                            $service_label = "Real Estate";
                            if ($listing['category'] == 2) {
                              $service_label = "Transport";
                            }

                            $attachment_count_label = "None";
                            $attachments = $this->Listing->getListingPhotos($listing['id']);
                            if ($attachments !== false) {
                              $attachment_count_label = count($attachments);
                            }


                            $o .= "<tr>";
                            $o .= "<td>" . ($index + 1) . "</td>";
                            $o .= "<td>" . $service_label . "</td>";
                            $o .= "<td>" . $listing['title'] . "</td>";
                            $o .= "<td>" . $user_label . "</td>";
                            $o .= "<td>" . $author_label . "</td>";
                            $o .= "<td>" . $attachment_count_label . "</td>";
                            $o .= "<td title='" . getfulldateinfo_Type1($listing_req['time_updated']) . "'>" . date("d/m/Y", strtotime($listing_req['time_updated'])) . "</td>";
                            $o .= "<td>";
                            $o .= "<a href='" . base_url() . "admin/listing_view/" . $listing['id'] . "' target='_blank' class='btn btn-xs btn-default' >View</a> ";
                            $o .= "<a href='" . base_url() . "admin/contact_info/" . $listing_req['user_id'] . "' target='_blank' class='btn btn-xs btn-success' >Contact</a> ";
                            $o .= "<form method='post' style='display:inline;' >";
                            $o .= "<input type='hidden' name='listing_request_id' value='" . $listing_req['id'] . "' />";
                            if (($listing_req["approval"] == 0) || ($listing_req["approval"] == 2))
                              $o .= "<button type='submit' name='approve_request_but' value='Approve Request' class='btn btn-xs btn-default btn-primary' >Approve</button> ";
                            if (($listing_req["approval"] == 0) || ($listing_req["approval"] == 1))
                              $o .= "<button type='submit' name='decline_request_but' value='Decline Request' class='btn btn-xs btn-default btn-danger' >Decline</button>";
                            $o .= "</form>";
                            $o .= "</td>";
                            $o .= "</tr>";
                          } else {
                            // Listing Not found
                          }
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