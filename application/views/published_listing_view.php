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
          <h4 class="font-alt">VIEW LISTING</h4>
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
        $user_id 	= $this->Users->getUserID();
        $verify_account_status = $this->Users->getVerifyAccountInfoByID($this->Users->getUserID());

        if ($verify_account_status['status'] == 9) {
          echo "<p>You need to verify your email address to enable your account! An email was sent to " . $verify_account_status['email'] . " inbox when you registered. The email contains the verification link. Check your spam folder also, just in case. </p>";
        } else {
          ?>

          <?php

            // View Published Listing
            
                $listing = $this->Listing->getListing($listing_id);

                ?>

              <hr class="divider-w mb-10">
              <div class='col-sm-12 mb-sm-12'>

                <div class="row">
                  <div class="col-sm-12">
                    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" style="text-decoration: none; color:blue;">Back to Listings</a>
                    <?php
                          if ($listing !== false) {

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

                            $price_label = $listing["price"];
                            if ($price_label < 1) {
                        //      $price_label = "Contact for Price";
                                $price_label = "";
                            } else {
                              $price_label = "₦" . number_format($price_label);
                            }
                            if ($listing["negotiable"] == 1) {
                              $price_label = "Negotiable";
                            }

                            $o = "";
                            $o .= "<div class='fec_listing col-sm-12'>";
                            $o .= "<div class='fec_row_left col-sm-8'>";
                            if ($attachments !== false) {
                              $o .= "<img src='" . base_url() . "uploads/listings/" . $attachments[0]['file_name'] . "' onclick='$(\".fec_gal0\").click()' />";
                            }
                            $o .= "</div>";
                            $o .= "<div class='fec_row_right col-sm-4'>";
                            $o .= "<h5> Date: " . getfulldateinfo_Type1($listing['time_updated']) . "</h5>";
                            $o .= "<div>Category: " . $service_label . "</div>";
                            $o .= "<h4>" . $listing['title'] . "</h4>";
                            $o .= "<h4>" . $price_label . "</h4>";

                            $check = $this->Listing->getListingRequest($listing['id'], $user_id, 1);
                            if($check === false){
                              $o .= "<div class='col-xs-12'><form method='post'>";
                                $o .= "<input type='hidden' value='" . $listing['id'] . "' name='listing_id' />";
                                $o .= "<button class='btn btn-success btn-lg' name='service_request_but' value='Request'>Buy/Request</button>";
                              $o .= "</form></div>";
                            }else{
                              $o .= "<div class='col-xs-12'>";
                                
                                if($check['approval'] == 0){
                                  $o .= "<button class='btn btn-primary btn-lg' disabled >";
                                  $o .= "Request Submitted</button>";
                                }else if($check['approval'] == 1){
                                  $o .= "<button class='btn btn-success btn-lg' disabled >";
                                  $o .= "Request Approved</button>";
                                }else if($check['approval'] == 2){
                                  $o .= "<button class='btn btn-warning btn-lg' disabled >";
                                  $o .= "Request Declined</button>";
                                }
                                
                              $o .= "</div>";
                            }
                            if ($attachment_count_label == "None") {
                              $o .= "<div></div>";
                            } else {
                              $o .= "<div><b>Photo(s): </b></div>";
                              foreach ($attachments as $dex => $attached) {
                                $o .= "<div class='fec_gal' style='float:left;margin:2px;'>";
                                $o .= "<b><a href='" . base_url() . "uploads/listings/" . $attached['file_name'] . "' class='lightbox fec_gal" . $dex . "' aria-haspopup'dialog' data-lightbox-gallery='mygallery' title='" . ($dex + 1) . "/" . count($attachments) . "' >";
                                $o .= "<img src='" . base_url() . "uploads/listings/" . $attached['file_name'] . "' />";
                                $o .= "</a></b>";
                                $o .= "</div>";
                              }
                            }
                            $o .= "</div>";
                            $o .= "</div>";
                          }

                          echo $o;
                          ?>

                  </div>
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

  <!-- TopBox Javascript -->
  <script src="<?php echo base_url(); ?>assets/js/topbox-master/src/js/topbox.js"></script>

  <!-- Initiate the TopBox plugin -->
  <script>
    $(document).ready(function() {
      $('.lightbox').topbox({
        skin: 'darkroom',
        afterShowLightbox: function(lightbox) {

        },
        backgroundBlur: false
      });

      // Extra - Trigger a TopBox via a page anchor
      if (window.location.hash) {
        var hashValue = location.hash.replace(/^#/, '');
        $("." + hashValue).click();
      }

    });
  </script>