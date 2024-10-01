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
          <h4 class="font-alt">LISTINGS</h4>
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

            $listings = $this->Listing->getAllListingsArray();

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
                          <th>Author</th>
                          <th>Photos</th>
                          <th>Status</th>
                          <th>Date</th>
                          <?php   /*   <th>Opened</th>  */ ?>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                              $o = "";
                              if ($listings !== false) {
                                foreach ($listings as $index => $listing) {

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

                                  $publish_status = "<span class='label label-default'>Pending</span>";
                                  if($listing["publish_status"] == 1){
                                    $publish_status = "<span class='label label-primary'>Published</span>";
                                  }else if($listing["publish_status"] == 2){
                                    $publish_status = "<span class='label label-danger'>Rejected</span>";
                                  }


                                  $o .= "<tr>";
                                  $o .= "<td>" . ($index + 1) . "</td>";
                                  $o .= "<td>" . $service_label . "</td>";
                                  $o .= "<td>" . $listing['title'] . "</td>";
                                  $o .= "<td>" . $author_label . "</td>";
                                  $o .= "<td>" . $attachment_count_label . "</td>";
                                  $o .= "<td>" . $publish_status . "</td>";
                                  $o .= "<td title='" . getfulldateinfo_Type1($listing['time_updated']) . "'>" . date("d/m/Y", strtotime($listing['time_updated'])) . "</td>";
                                  $o .= "<td>";
                                  $o .= "<a href='" . base_url() . "admin/listing_view/" . $listing['id'] . "' class='btn btn-xs btn-default' >View</a> ";
                                  $o .= "<form method='post' style='display:inline;' >";
                                    $o .= "<input type='hidden' name='listing_id' value='".$listing['id']."' />" ;
                                    if( ($listing["publish_status"] == 0) || ($listing["publish_status"] == 2) )
                                    $o .= "<button type='submit' name='listing_pub_but' value='Publish Listing' class='btn btn-xs btn-default btn-primary' >Publish</button> ";
                                    if( ($listing["publish_status"] == 0) || ($listing["publish_status"] == 1) )
                                    $o .= "<button type='submit' name='listing_rej_but' value='Publish Listing' class='btn btn-xs btn-default btn-danger' >Reject</button>";
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