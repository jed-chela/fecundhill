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
          <h4 class="font-alt">My Fecundvest Transactions</h4>
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
                 <h5>Transaction History</h5>  
                  <table class="table table-striped table-border checkout-table dataTable table-responsive">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Account</th>
                        <th>Label</th>
                        <th>Amount</th>
                        <th>Admin</th>   
                        <th>Date</th>
                  <!--      <th></th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                        $the_account_type = 2; //Fecundvest Account Type

                        $account_info = $this->Finance->getAccount($this->Users->getUserID(), $the_account_type);
                        if ($account_info !== false) {

                            $o = "";
                            $records = $this->Finance->getTransactionRecordByAccountNo($account_info["id"]);
                            if ($records !== false) {
                              $balance = 0;

                              foreach ($records as $index => $record) {

                                $user = $this->Users->getUser($this->Users->getUserID());

                                $title            = "";
                                $surname          = "";
                                $firstname        = "";
                                $othername        = "";
                                $profile_status_label = "";
 
                                $account_type = 2 ? "Fixed" : "Savings";

                                $transaction_label = "";
                                if($record['type'] == 1){
                                  // Fecundvest Credit
                                  $transaction_label = "Deposit";
                                  $balance += $record["amount"];
                                }else if($record['type'] == 5){
                                  // Fecundvest Withdrawal
                                  $transaction_label = "Withdrawal";
                                  $balance -= $record["amount"];
                                }else if($record['type'] == 6){
                                  // Admin Charges
                                  $transaction_label = "Admin Charges";
                                  $balance -= $record["amount"];
                                }else if($record['type'] == 7){
                                  // Default Charge
                                  $transaction_label = "Default Charge";
                                  $balance -= $record["amount"];
                                }
                                
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
                                $admin_info = $this->Personal->personalInfo($record['admin_id']);
                                if ($admin_info !== false) {
                                  $admin_name   = $profile_info["firstname"];
                                }

                                $o .= "<tr>";
                                $o .= "<td>" . ($index + 1) . "</td>";
                                $o .= "<td>" . $title . " " . $surname . " " . $firstname . "</td>";
                                $o .= "<td>". $account_type."</td>";
                                $o .= "<td>" . $transaction_label . "</td>";
                                $o .= "<td>" . number_format($record['amount'], 2) . "</td>";
                                $o .= "<td>" . $admin_name . "</td>";
                                $o .= "<td title='" . getfulldateinfo_Type1($record['time_added']) . "'>" . date("d/m/Y", strtotime($record['time_updated'])) . "</td>";
                          //      $o .= "<td></td>";
                                $o .= "</tr>";
                              }

                              // Balance Row
                              $o .= "<tr>";
                              $o .= "<td></td>";
                              $o .= "<td></td>";
                              $o .= "<td></td>";
                              $o .= "<td><b>BALANCE</b></td>";
                              $o .= "<td>" . number_format($balance, 2) . "</td>";
                              $o .= "<td></td>";
                              $o .= "<td></td>";
                        //      $o .= "<td></td>";
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