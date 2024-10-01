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
          <h4 class="font-alt">TRANSACTION MANAGEMENT</h4>
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

    //        $accounts = $this->Finance->getAccountsByType2(2);
              $accounts = $this->Users->getAllUsers();

            ?>

          <?php
            if (isset($req_type)) {
              if ($req_type == "transaction_add") {

                ?>
              <hr class="divider-w mb-10">
              <div class='col-sm-12 mb-sm-12'>

                <div class="row">
                  <div class="col-sm-12">
                    <h4>Add a Transaction</h4>
                    <div class="col-lg-12 col-sm-12 col-xs-12">

                      <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
                        <form class="form" method="POST" style="overflow: hidden;">
                          <?php
                                if (isset($add_transaction_error)) {
                                  if ($add_transaction_error != "") {
                                    echo $add_transaction_error;
                                  }
                                }
                                ?>
                          <?php 
                            $user = $this->Users->getUser($the_user_id);
                            $profile_info = $this->Personal->personalInfo($the_user_id);
                            if ($profile_info !== false) {
                              $title        = $profile_info["title"];
                              $surname      = $profile_info["surname"];
                              $firstname    = $profile_info["firstname"];
                              $othername    = $profile_info["othername"];
                            }
                          ?>
                          <div class='col-sm-10 mb-sm-10' style="border: 1px solid #DDD;">
                            <h4>
                              <?php echo $title." ".$surname." ".$firstname." ".$othername; ?>
                            </h4>
                            <div class="form-group">
                              <label>Amount</label>
                              <input class="form-control no-textupper" type="number" name="the_amount" value="" required />
                              <input class="form-control no-textupper" type="hidden" name="the_user_id" value="<?php echo $the_user_id; ?>" required />
                            </div>

                            <div class="form-group">
                              <label>Transaction Type</label>
                              <select class="form-control" name="the_transaction_type" required>
                                <option value="1">Credit</option>
                                <option value="2">Fecundvest Interest</option>
                                <option value="6">Admin Charges</option>
                                <option value="7">Default Charge</option>
                                <option value="8">Fecundvest bonus</option>
                                <option value="9">Referral bonus</option>
                                <option value="10">Loan repayment</option>
                                <option value="11">Ride payout</option>
                                <option value="12">Hire purchase payment</option>
                                <option value="15">Hire purchase debt</option>
                                <option value="16">Delivery Payout</option>
                                <option value="17">Property debt</option>
                                <option value="18">Property payout</option>
                                <option value="19">Mortgage</option>
                                <option value="20">Mortgage payment</option>
                                <option value="21">Rent payment</option>
                                <option value="22">Vehicle debt</option>
                                <option value="23">Vehicle repayment</option>
                    <!--            <option disabled >Deposit (Disabled)</option>
                                <option disabled >Savings (Disabled)</option>     -->
                              </select>
                            </div>

                            <div class="form-group">
                              <input class="" id="the_amount_confirm" type="checkbox" name="the_amount_confirm" value="" required />
                              <label for="the_amount_confirm">I have cross-checked and ensured that the values entered above are accurate and reliable! </label>
                            </div>
                            <div class="form-group">
                              <button class="btn btn-round btn-b" type="submit" name='new_transaction_but' value="Save Transaction">Save Transaction</button>
                            </div>
                          </div>

                        </form>
                        <hr />
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            <?php
                } else if ($req_type == "transaction_history") {
                  // TRANSACTION HISTORY
                  ?>

              <div class="row">
                <div class="col-sm-12">
                 <h5>Transaction History</h5>  
                  <table class="table table-striped table-border checkout-table">
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

          //              $account_info = $this->Finance->getAccount($the_user_id, $the_account_type);

          //              if ($account_info !== false) {

                            $o = "";
                    //        $records = $this->Finance->getTransactionRecordByAccountNo($account_info["id"]);
                            $records = $this->Finance->getTransactions($the_user_id);
                            
                            if ($records !== false) {
                              $balance = 0;

                              foreach ($records as $index => $record) {

                                $user = $this->Users->getUser($the_user_id);

                                $title            = "";
                                $surname          = "";
                                $firstname        = "";
                                $othername        = "";
                                $profile_status_label = "";
                                
                        //        $account_type = 2 ? "Fixed" : "Savings";
                                $account_type = 2 ? "Fecundvest" : "Savings";
                                
                                $transaction_label = "";
                                if($record['type'] == 1){
                                  // Credit
                                  $transaction_label = "Credit";
                                  $balance += $record["amount"];
                                }else if($record['type'] == 2){
                                  // Fecundvest Interest
                                  $transaction_label = "Fecundvest Credit";
                                  $balance -= $record["amount"];
                                
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

                                switch ($record['type']) {
                                  case 8:
                                    $transaction_label = "Fecundvest bonus";
                                    $balance += $record["amount"];
                                    break;
                                  case 9:
                                    $transaction_label = "Referral bonus";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 10:
                                    $transaction_label = "Loan repayment";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 11:
                                    $transaction_label = "Ride payout";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 12:
                                    $transaction_label = "Hire purchase repayment";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 13:
                                    $transaction_label = "Loan disbursement";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 15:
                                    $transaction_label = "Hire purchase debt";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 16:
                                    $transaction_label = "Delivery payout";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 17:
                                    $transaction_label = "Property debt";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 18:
                                    $transaction_label = "Property payout";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 19:
                                    $transaction_label = "Mortgage";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 20:
                                    $transaction_label = "Mortgage payment";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 21:
                                    $transaction_label = "Rent payment";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 22:
                                    $transaction_label = "Vehicle debt";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                  case 23:
                                    $transaction_label = "Vehicle repayment";
                                    $balance += $record["amount"];
                                    $account_type = "";
                                    break;
                                }

                                $profile_info = $this->Personal->personalInfo($user['id']);
                                if ($profile_info !== false) {
                                  $title        = $profile_info["title"];
                                  $surname      = $profile_info["surname"];
                                  $firstname    = $profile_info["firstname"];
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
                                $o .= "<td>" . $record['amount'] . "</td>";
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
                              $o .= "</tr>";    /*  */
                            }

                            echo $o;
            //              }
                            ?>

                    </tbody>
                  </table>
                </div>
              </div>



          <?php
              } // end else if($req_type == "transaction_history"){
            }
            ?>

          <?php
            if (isset($req_type)) {
              if ($req_type != "transaction_history") {
                ?>
              <hr class="divider-w mb-10">
              <div class='col-sm-12 mb-sm-12'>

                <div class="row">
                  <div class="col-sm-12">
                    <h4>Accounts</h4>
                    <table class="table table-striped table-border checkout-table">
                      <tbody>
                        <tr>
                          <th>#</th>
                          <th>Email</th>
                          <th>Name</th>
                          <th>Date Created</th>
                          <th></th>
                        </tr>
                        <?php

                              $o = "";
                              if ($accounts !== false) {
                                foreach ($accounts as $index => $account) {

                                  $user = $this->Users->getUser($account['id']);

                                  $rec_account_type = 2;

                                  $title        = "";
                                  $surname      = "";
                                  $firstname   = "";
                                  $othername    = "";
                                  $profile_status_label = "";

                                  $profile_info = $this->Personal->personalInfo($user['id']);
                                  if ($profile_info !== false) {
                                    $title        = $profile_info["title"];
                                    $surname      = $profile_info["surname"];
                                    $firstname    = $profile_info["firstname"];
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

                                  $o .= "<tr>";
                                  $o .= "<td>" . ($index + 1) . "</td>";
                                  $o .= "<td>" . $user['email'] . "</td>";
                                  $o .= "<td>" . $title . " " . $surname . " " . $firstname . " " . $othername . "</td>";
                                  $o .= "<td title='" . getfulldateinfo_Type1($user['time_created']) . "'>" . date("d/m/Y", strtotime($user['time_created'])) . "</td>";
                                  $o .= "<td>";
                                  if ($my_info !== false) {
                                    $o .= "<a href='" . base_url() . "admin/transaction_management/tr_add/" . $user["id"] . "/" . $rec_account_type . "' class='btn btn-xs btn-primary' >Add Transaction</a> ";
                                    
                    //                $o .= " <a href='" . base_url() . "admin/view_loan_requests_history/" . $user["id"] . "' class='btn btn-xs btn-default' target='_blank' >Loan Requests</a> ";

                                    $o .= " <a href='" . base_url() . "admin/view_loan_history/" . $user["id"] . "' class='btn btn-xs btn-primary' >Loans</a> ";

                                    $o .= "<a href='" . base_url() . "admin/transaction_management/tr_history/" . $user["id"] . "/" . $rec_account_type . "' class='btn btn-xs btn-success' >Transaction History</a> ";
                                  } else {
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
              } // end else if($req_type != "transaction_history"){
            }
            ?>

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