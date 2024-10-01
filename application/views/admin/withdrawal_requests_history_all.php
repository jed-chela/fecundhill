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
          <h4 class="font-alt">Withdrawal Requests History for All Users</h4>
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
                <div class="col-sm-12">
                 <h5>Withdrawal Requests History</h5>  
                  <table class="table table-striped table-border checkout-table dataTable table-responsive">
                    <thead>
                      <tr>
                        <th class="">#</th>
                        <th>Customer</th>
                        <th class="">Amount</th>
                        <th class="">Bank Account</th>
                        <th class="">Bank Name</th>
                        <th class="">Account Name</th>
                        <th class="">Account No</th>
                        <th class="">Status</th>
              <!--          <th class="">Children</th>      -->
                        <th class="">Date</th>
              <!--          <th></th>           -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                            $o = "";
                            $records_all = $this->Finance->getAllWithdrawalRequests();
                            if ($records_all !== false) {
                              $balance = 0;

                              foreach ($records_all as $index => $record) {

                                $user = $this->Users->getUser($record["user_id"]);

                                $title            = "";
                                $surname          = "";
                                $firstname        = "";
                                $othername        = "";
                                $profile_status_label = "";
 
                                $account_type = 2 ? "Fixed" : "Savings";

                                $transaction_label = "";
                  
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
                          /*      $admin_info = $this->Personal->personalInfo($record['admin_id']);
                                if ($admin_info !== false) {
                                  $admin_name   = $profile_info["firstname"];
                                }
                          */
                                $o .= "<tr>";
                                $o .= "<td>" . ($index + 1) . "</td>";
                                $o .= "<td>" . $title . " " . $surname . " " . $firstname . "</td>";
                                $o .= "<td>". $record['amount']."</td>";
                                $o .= "<td>" . $record['bank_account'] . " months</td>";
                                $o .= "<td>" . $record['bank_name'] . "</td>";
                                $o .= "<td>" . $record['account_name'] . "</td>";
                                $o .= "<td>" . $record['account_number'] . "</td>";

                                if($record['status'] == 0){
                                  $o .= "<td>Pending</td>";
                                }else if($record['status'] == 1){
                                  $o .= "<td>Approved</td>";
                                }else if($record['status'] == 2){
                                  $o .= "<td>Rejected</td>";
                                }

                  //              $o .= "<td>" . $record['children'] . "</td>";
                                $o .= "<td title='" . getfulldateinfo_Type1($record['time_created']) . "'>" . date("d/m/Y", strtotime($record['time_updated'])) . "</td>";
                  //              $o .= "<td></td>";
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