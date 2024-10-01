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
          <h4 class="font-alt">REFERRALS</h4>
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

            $referrals = $this->Referrals->getAllReferrals();

          ?>


          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>

            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-border checkout-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>New User Email</th>
                      <th>New User Name</th>
                      <th>Referral Code Used</th>
                      <th>Service</th>
                      <th>Referred By</th>
                      <th>Date Used</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $o = "";
                      if ($referrals !== false) {
                        foreach ($referrals as $index => $referral) {

                          $email          = "";
                          $title          = "";
                          $surname        = "";
                          $firstname      = "";
                          $othername      = "";
                          $referral_code  = $referral["code"];
                          $service        = $referral["service"];

                          $profile_info = $this->Personal->personalInfo($referral['user_id']);
                          if ($profile_info !== false) {
                            
                            $email        = $this->Users->getUserEmail($referral['user_id']);
                            $title        = $profile_info["title"];
                            $surname      = $profile_info["surname"];
                            $firstname    = $profile_info["firstname"];
                            $othername    = $profile_info["othername"];
                          }

                          $reffered_by = "";

                          $referral_code_user_info = $this->Referrals->getReferralCodeUser($referral['code']);
                          if ($referral_code_user_info !== false) {
                            $referral_code_user_id        = $referral_code_user_info['user_id'];
                            $referrer_profile_info = $this->Personal->personalInfo($referral_code_user_id);
                            if ($referrer_profile_info !== false) {
                              $referrer_title         = $referrer_profile_info["title"];
                              $referrer_surname       = $referrer_profile_info["surname"];
                              $referrer_firstname     = $referrer_profile_info["firstname"];
                              $referrer_othername     = $referrer_profile_info["othername"];

                              $reffered_by = $referrer_title." ".$referrer_surname." ".$referrer_firstname." ".$referrer_othername;
                            }

                          }

                          $sub_admin_status = $this->Users->getSubAdminAccess($referral['id']);

                          $my_info = $profile_info;
                          if ($my_info !== false) {
                            if (($my_info["surname"] == "") || ($my_info["firstname"] == "") || ($my_info["phone"] == "")) {
                              $my_info = false;
                            }
                          }

                          $o .= "<tr>";
                          $o .= "<td>" . ($index + 1) . "</td>";
                          $o .= "<td>" . $email . "</td>";
                          $o .= "<td>" . $title." ".$surname." ".$firstname." ".$othername . "</td>";
                          $o .= "<td><b>" . $referral_code . "</b></td>";
                          $o .= "<td><b>" . $service . "</b></td>";
                          $o .= "<td>" . $reffered_by . "</td>";
                          $o .= "<td title='" . getfulldateinfo_Type1($referral['time_created']) . "'>" . date("d/m/Y", strtotime($referral['time_created'])) . "</td>";
                          $o .= "<td>";
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