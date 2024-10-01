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
          <h4 class="font-alt">USER REFERRAL CODES</h4>
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

            $users = $this->Users->getAllUsers();

          ?>


          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>

            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-border checkout-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Email</th>
                      <th>Referral Code</th>
                      <th>Title</th>
                      <th>Surname</th>
                      <th>First Name</th>
                      <th>Othernames</th>
                      <th>Date Joined</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $o = "";
                      if ($users !== false) {
                        foreach ($users as $index => $user) {

                          $title          = "";
                          $surname        = "";
                          $firstname      = "";
                          $othername      = "";
                          $referral_code  = "";

                          $profile_info = $this->Personal->personalInfo($user['id']);
                          if ($profile_info !== false) {
                            $title        = $profile_info["title"];
                            $surname      = $profile_info["surname"];
                            $firstname   = $profile_info["firstname"];
                            $othername    = $profile_info["othername"];
                          }

                          $referral_code_info = $this->Referrals->getReferralCode($user['id']);
                          if ($referral_code_info !== false) {
                            $referral_code        = $referral_code_info;
                          }else{
                            // Create Referral Code for User
                            $this->Referrals->createReferralCode($user['id']);
                            $referral_code_info = $this->Referrals->getReferralCode($user['id']);
                            $referral_code      = $referral_code_info;
                          }

                          $sub_admin_status = $this->Users->getSubAdminAccess($user['id']);

                          $my_info = $profile_info;
                          if ($my_info !== false) {
                            if (($my_info["surname"] == "") || ($my_info["firstname"] == "") || ($my_info["phone"] == "")) {
                              $my_info = false;
                            }
                          }

                          $o .= "<tr>";
                          $o .= "<td>" . ($index + 1) . "</td>";
                          $o .= "<td>" . $user['email'] . "</td>";
                          $o .= "<td><b>" . $referral_code . "</b></td>";
                          $o .= "<td>" . $title . "</td>";
                          $o .= "<td>" . $surname . "</td>";
                          $o .= "<td>" . $firstname . "</td>";
                          $o .= "<td>" . $othername . "</td>";
                          $o .= "<td title='" . getfulldateinfo_Type1($user['time_created']) . "'>" . date("d/m/Y", strtotime($user['time_created'])) . "</td>";
                          $o .= "<td>";
                          if($my_info !== false){
                            $o .= "<a href='" . base_url() . "admin/view_profile/" . $user["id"] . "' target='_blank' class='btn btn-xs btn-default' title='View' ><i class='fa fa-eye'></i></a> ";
                          }else{
                            $o .= "<button class='btn btn-xs btn-default' disabled >No Profile Info Yet</button> ";
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