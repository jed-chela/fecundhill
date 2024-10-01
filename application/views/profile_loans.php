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
          <h4 class="font-alt">My Loans</h4>
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

         <hr class="divider-w mb-10">
        <div class='col-sm-12 mb-sm-12'>

          

              <div class="row">
                <div class="col-sm-12">
                 <h5>Loans History</h5>  
                  <table class="table table-striped table-border checkout-table dataTable table-responsive">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Duration</th>
                        <th>Type</th>
                        <th>Admin</th>   
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                        $the_account_type = 2; //Fecundvest Account Type
                        $the_user_id = $this->Users->getUserID();

                        $loans_info = $this->Finance->getAllUserLoans($the_user_id);
                        if ($loans_info !== false) {

                          $o = "";
                          $balance = 0;

                            foreach ($loans_info as $index => $loan) {

                              $user = $this->Users->getUser($the_user_id);

                              $title            = "";
                              $surname          = "";
                              $firstname        = "";
                              $othername        = "";
                              $profile_status_label = "";


                              $profile_info = $this->Personal->personalInfo($user['id']);
                              if ($profile_info !== false) {
                                $title        = $profile_info["title"];
                                $surname      = $profile_info["surname"];
                                $firstname   = $profile_info["firstname"];
                                $othername    = $profile_info["othername"];
                                if ($profile_info["lock_status"] == 0) {
                                  $profile_status_label = "Editable";
                                } else if ($profile_info["lock_status"] == 1) {
                                  $profile_status_label = "Locked";
                                }
                              }

                              $my_info = $profile_info;
                              if ($my_info !== false) {
                                if (($my_info["surname"] == "") || ($my_info["firstname"] == "") || ($my_info["phone"] == "")) {
                                  $my_info = false;
                                }
                              }

                              $admin_name = "";
                              $admin_info = $this->Personal->personalInfo($loan['admin_id']);
                              if ($admin_info !== false) {
                                $admin_name   = $profile_info["firstname"];
                              }

                              $status_label = "Active";
                              if($loan['active_status'] == 2){
                                $status_label = "Fully Paid";
                              }

                              $o .= "<tr>";
                              $o .= "<td>" . ($index + 1) . "</td>";
                              $o .= "<td class=''>" . $title . " " . $surname . " " . $firstname . "</td>";
                              $o .= "<td>" . $loan['amount'] . "</td>";
                              $o .= "<td>" . $loan['duration'] . " month(s)</td>";
                              $o .= "<td>" . $status_label . "</td>";
                              $o .= "<td>" . $admin_name . "</td>";
                              $o .= "<td class='' title='" . getfulldateinfo_Type1($loan['time_created']) . "'>" . date("d/m/Y", strtotime($loan['time_updated'])) . "</td>";
                              $o .= "</tr>";
                            }
                          
                            echo $o;
                          }
                            ?>

                    </tbody>
                  </table>
                </div>
              </div>



        

          
            
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