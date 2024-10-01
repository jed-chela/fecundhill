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

            // View Listings
            $partner_account = $this->Partner->getAccount($this->Users->getUserID());
            if ($partner_account !== false) {

              if ($partner_account['enabled'] == 0) {
                echo '<p class="text-success col-sm-11 col-sm-offset-1"><b>You Have Requested for A Partner Account. Fecundhill Admin will review your request and make a decision shortly.</b></p>';
              } else if ($partner_account['enabled'] == 2) {
                echo '<p class="text-danger col-sm-11 col-sm-offset-1"><b>Your Request has been REJECTED by Fecundhill Admin</b></p>';
              } else if ($partner_account['enabled'] == 1) {
                echo '<p class="text-danger col-sm-11 col-sm-offset-1"><b>Please note that all listings you post will be subject to review by Fecundhill Admin before they are displayed on the website</b></p>';

                $listing = $this->Listing->getListing($listing_id);

                ?>

              <hr class="divider-w mb-10">
              <div class='col-sm-12 mb-sm-12'>

                <div class="row">
                  <div class="col-sm-12">
                    <a href="<?php echo base_url(); ?>profile/listings" style="text-decoration: none; color:blue;">Back to Listings</a>
                    <?php
                          if ($listing !== false) {

                            $author = $this->Partner->getPartnerAccount($listing['partner_id']);
                            if ($author !== false) {
                              $author_label = $author["business_name"];
                            }else{
                              $author_label = $this->Personal->userName($listing['user_id']);
                            }

                            $service_label = "Real Estate";
                            if ($listing['category'] == 2) {
                              $service_label = "Transport";
                            }
                            if ($listing['category'] == 3) {
                              $service_label = "Hire Purchase";
                            }

                            $attachment_count_label = "None";
                            $attachments = $this->Listing->getListingPhotos($listing['id']);
                            if ($attachments !== false) {
                              $attachment_count_label = count($attachments);
                            }

                            $price_label = $listing["price"];
                            if ($price_label < 1) {
                              $price_label = "Contact for Price";
                            }else{
                              $price_label = "₦" . number_format($price_label);
                            }
                            if ($listing["negotiable"] == 1) {
                              $price_label = "Negotiable";
                            }

                            $payment_plan = $listing["extra"];
                            if ($payment_plan != "") {
                              $payment_plan = "Payment Plan: ".$payment_plan;
                            }

                            $o = "";
                            $o .= "<div class='fec_listing col-sm-12'>";
                              $o .= "<div class='fec_row_left col-sm-8'>";
                                if($attachments !== false){
                                  $o .= "<img src='" . base_url() . "uploads/listings/" . $attachments[0]['file_name'] . "' onclick='$(\".fec_gal0\").click()' />";
                                }
                              $o .= "</div>";
                              $o .= "<div class='fec_row_right col-sm-4'>";
                                $o .= "<h5> Date: " . getfulldateinfo_Type1($listing['time_updated']) . "</h5>";
                                $o .= "<div>Category: " . $service_label . "</div>";
                                $o .= "<h4>" . $listing['title'] . "</h4>";
                                $o .= "<h4>" . $price_label . "</h4>";
                                if($payment_plan != ""){
                                  $o .= "<h4>" . $payment_plan . "</h4>";
                                }
                                if ($attachment_count_label == "None") {
                                  $o .= "<div></div>";
                                } else {
                                  $o .= "<div><b>Photo(s): </b></div>";
                                  foreach ($attachments as $dex => $attached) {
                                    $o .= "<div class='fec_gal' style='float:left;margin:2px;'>";
                                    $o .= "<b><a href='" . base_url() . "uploads/listings/" . $attached['file_name'] . "' class='lightbox fec_gal".$dex."' aria-haspopup'dialog' data-lightbox-gallery='mygallery' title='".($dex + 1)."/".count($attachments)."' >";
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
          }
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