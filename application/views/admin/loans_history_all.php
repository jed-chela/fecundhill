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
          <h4 class="font-alt">Loans History for All Users</h4>
          <hr class="divider-w mb-10">
        </div>

        <?php
        if (isset($form_error)) {
          if ($form_error != "") {
            echo $form_error;
          }
        }
        ?>

        
        <br />
        <hr />
        
        <div class="row">
                <div class="col-sm-12 overflow-x">
                 <h5>Loans History</h5>  
                  <table class="table table-striped table-border checkout-table dataTable table-responsive">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Amount</th>
                <!--        <th>Duration</th>   -->
                        <th>Bank Name</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Type</th>
                        <th>Admin</th>   
                        <th>Date</th>
                        <th>Loan Request Info</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                            $o = "";
                            $loans_info = $this->Finance->getAllLoans();
                            if ($loans_info !== false) {

                            $o = "";
                            $balance = 0;

                              foreach ($loans_info as $index => $loan) {

                                $loan_req_str = "";
                                $loan_req = $this->Finance->getLoanRequestRecord($loan['loan_request_id']);
                                if($loan_req !== false){
                                  $loan_req_str .= " Duration: " . $loan_req["duration"] . " months ";
                                  $loan_req_str .= " | Current Income: " . $loan_req["current_income"] . " ";
                                  $loan_req_str .= " | Cheque Book: <i>" . $loan_req["cheque_book"] . "</i> ";
                                  $loan_req_str .= " | Servicing Other Loan: <b>" . $loan_req["other_loan"] . "</b> ";
                                  $loan_req_str .= " | Payment Amount: " . $loan_req["payment_amount"] . " ";
                                  $loan_req_str .= " | Deposit Frequency: " . $loan_req["deposit_frequency"] . " ";
                                  $loan_req_str .= " | Specific Day: " . $loan_req["specific_day"] . " ";
                          //        $loan_req_str .= " | Purpose: " . $loan_req["purpose"] . " ";
                                  $loan_req_str .= " | Asset/Inventory: " . $loan_req["collateral"] . " ";
                                  $loan_req_str .= " | Asset/Inventory Location: " . $loan_req["asset_location"] . " ";
                                  $loan_req_str .= " | Termination Date: " . $loan_req["termination_date"] . " ";
                                  $loan_req_str .= " | Moratorium: " . $loan_req["moratorium"] . " ";
                                }

                                $the_user_id = $loan["user_id"];

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
                                  $admin_name   = $admin_info["firstname"];
                                }

                                $status_label = "Active";
                                if($loan['active_status'] == 2){
                                  $status_label = "Fully Paid";
                                }

                              $o .= "<tr>";
                              $o .= "<td>" . ($index + 1) . "</td>";
                              $o .= "<td class=''>" . $title . " " . $surname . " " . $firstname . "</td>";
                              $o .= "<td>" . $loan['amount'] . "</td>";
                      //        $o .= "<td>" . $loan['duration'] . " month(s)</td>";
                              if($loan_req !== false){
                                $o .= "<td>" . $loan_req['bank_name'] . "</td>";
                                $o .= "<td>" . $loan_req['account_name'] . "</td>";
                                $o .= "<td>" . $loan_req['account_number'] . "</td>";
                              }else{
                                $o .= "<td></td>";
                                $o .= "<td></td>";
                                $o .= "<td></td>";
                              }
                              
                              $o .= "<td>" . $status_label . "</td>";
                              $o .= "<td>" . $admin_name . "</td>";
                              $o .= "<td class='' title='" . getfulldateinfo_Type1($loan['time_created']) . "'>" . date("d/m/Y", strtotime($loan['time_updated'])) . "</td>";
                              $o .= "<td>".$loan_req_str."</td>";
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
    </div>
  </section>
</div>


  <?php
  $this->load->view("template/footer");
  ?>
  <?php
  $this->load->view("template/footlinks");
  ?>