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
          <h4 class="font-alt">ADMIN DASHBOARD</h4>
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
            $current_user_id = $this->Users->getUserID();
            $my_privilege = $this->Users->getSubAdminAccess($current_user_id);
            ?>

          <!-- Metrics 

            1) Total Number of Users
            2) Total Number of Updated Profiles
            3) Fecundvest Accounts
            4) Total Number of Loan Requests
            5) Total Number of Active Loans
            6) Total Number of Loans Fully Paid
            7) Total Number of Real Estate Service Requests
            8) Total Number of Transport Service Requests
            9) Total Number of Real Estate Listing Requests
            10) Total Number of Transport Listing Requests
            11) Total Number of Requests to Acquire Real Estate Listings
            12) Total Number of Requests to Acquire Transport Listings

          -->
<?php
          // 0) Admin Messages
          $no_of_messages = 0;
          $all_admin_messages = $this->Personal->getAdminMessagesOne();
          if($all_admin_messages !== false){
            $no_of_messages = count($all_admin_messages);
          }

          // 1) No of Users
          $no_of_users = 0;
          $all_users = $this->Users->getAllUsers();
          if($all_users !== false){
            $no_of_users = count($all_users);
          }

          // 2) Total Number of Updated Profiles
          $no_of_updated_profiles = 0;
          $all_profiles = $this->Personal->getAllProfilesArray();
          if($all_profiles !== false){
            foreach ($all_profiles as $key => $profile) {
              if (($profile["surname"] == "") || ($profile["firstname"] == "") || ($profile["phone"] == "")) {
                // Profile Not Yet Updated
              }else{
                $no_of_updated_profiles = $no_of_updated_profiles + 1;
              }
            }
          }

          // 3. Fecundvest Accounts
          $fixed_deposit_account_count = 0;
          $fixed_deposit_accounts = $this->Finance->getAccountsByType(2);
          if($fixed_deposit_accounts !== false){
            $fixed_deposit_account_count = count($fixed_deposit_accounts);
          }

          // 4) Loan Requests (90 days)
          $no_of_loan_requests = 0;
          $min_date_90 = date ( "Y-m-d H:i:s", strtotime ( '-90 days' ) );
          $all_loan_requests = $this->Finance->getAllLoanRequestsByDate($min_date_90);
          if($all_loan_requests !== false){
            $no_of_loan_requests = count($all_loan_requests);
          }

          // 5) Total Number of Active Loans
          $no_of_active_loans = 0;
          $all_active_loans = $this->Finance->getAllLoansByStatus(1);
          if($all_active_loans !== false){
            $no_of_active_loans = count($all_active_loans);
          }

          // 6) Total Number of Fully Paid Loans
          $no_of_fully_paid_loans = 0;
          $all_fully_paid_loans = $this->Finance->getAllLoansByStatus(2);
          if($all_fully_paid_loans !== false){
            $no_of_fully_paid_loans = count($all_fully_paid_loans);
          }

          // 7) Total Number of Real Estate Service Requests
          $no_of_real_estate_service_requests = 0;
          $real_estate_requests = $this->Personal->getAdminServiceRequestsByCategoryAndDate("Real Estate", $min_date_90);
          if($real_estate_requests !== false){
            $no_of_real_estate_service_requests = count($real_estate_requests);
          }

          // 8) Total Number of Transport Service Requests
          $no_of_transport_service_requests = 0;
          $transport_requests = $this->Personal->getAdminServiceRequestsByCategoryAndDate("Transport", $min_date_90);
          if($transport_requests !== false){
            $no_of_transport_service_requests = count($transport_requests);
          }

          


          // 9) Total Number of Real Estate Listing Requests
          $no_of_real_estate_listings = 0;
          $all_real_estate_listings = $this->Listing->getAllListingsByDate($min_date_90, 1);
          if($all_real_estate_listings !== false){
            $no_of_real_estate_listings = count($all_real_estate_listings);
          }

          // 10) Total Number of Transport Listing Requests
          $no_of_transport_listings = 0;
          $all_transport_listings = $this->Listing->getAllListingsByDate($min_date_90, 2);
          if($all_transport_listings !== false){
            $no_of_transport_listings = count($all_transport_listings);
          }

          // 11) Total Number of Requests to Acquire Real Estate Listings
          $no_of_real_estate_acquire = 0;
          $no_of_transport_acquire = 0;
          $all_acquire_requests = $this->Listing->getAllListingRequestsByDate($min_date_90);
          if($all_acquire_requests !== false){
            foreach ($all_acquire_requests as $key => $value) {
              $listing_info = $this->Listing->getListing($value['listing_id']);
              if($listing_info !== false){
                if($listing_info["category"] == 1){
                  // Real Estate
                  $no_of_real_estate_acquire += 1;
                }else if($listing_info["category"] == 2){
                  //Transport
                  $no_of_transport_acquire += 1;
                }
              }
            }
          }

          // 12) Total Number of Requests to Acquire Transport Listings

?>
    <!--      <hr class="divider-w mt-10 mb-20">  -->
          <div class="row">
            <div class="dash-big-txt-box col-sm-12 col-md-12 col-lg-12">
              <div class='dash-big-txt-itm'><?php echo $no_of_messages; ?></div>
              <div class="dash-big-txt-desc">
                Admin Messages
              </div>
            </div>
          </div>
          <div class="row">
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_users; ?></div>
              <div class="dash-big-txt-desc">
                Users
              </div>
            </div>
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_updated_profiles; ?></div>
              <div class="dash-big-txt-desc">
                Updated Profiles
              </div>
            </div>
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $fixed_deposit_account_count; ?></div>
              <div class="dash-big-txt-desc">
                Fecundvest Accounts
              </div>
            </div>
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_loan_requests; ?></div>
              <div class="dash-big-txt-desc">
                Loan Requests (last 90 days)
              </div>
            </div>
          </div>
          <div class="row">
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_active_loans; ?></div>
              <div class="dash-big-txt-desc">
                Active Loans
              </div>
            </div>
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_fully_paid_loans; ?></div>
              <div class="dash-big-txt-desc">
                Fully Paid Loans 
              </div>
            </div>
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_real_estate_service_requests; ?></div>
              <div class="dash-big-txt-desc">
                Real Estate Service Requests (90 days)
              </div>
            </div>
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_transport_service_requests; ?></div>
              <div class="dash-big-txt-desc">
                Transport Service Requests (90 days)
              </div>
            </div>
          </div>

          <div class="row">
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_real_estate_listings;?></div>
              <div class="dash-big-txt-desc">
                Real Estate Listings
              </div>
            </div>
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_transport_listings;?></div>
              <div class="dash-big-txt-desc">
                Transport Listings
              </div>
            </div>
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_real_estate_acquire;?></div>
              <div class="dash-big-txt-desc">
                Request to Acquire Real Estate Listings
              </div>
            </div>
            <div class="dash-big-txt-box col-sm-6 col-md-6 col-lg-3">
              <div class='dash-big-txt-itm'><?php echo $no_of_transport_acquire;?></div>
              <div class="dash-big-txt-desc">
                Request to Acquire Transport Listings
              </div>
            </div>
          </div>

    <!--       <hr class="divider-w mt-10 mb-20"> -->

          <!-- Table 1: Requests for Savings Account -->
<?php /*          <h4 class='col-sm-12 col-sm-offset-1 mb-sm-10'>Requests for Savings Account</h4>
          <div class='col-sm-12 col-sm-offset-1 mb-sm-10'>
            <?php
              $savings_accounts = $this->Finance->getAccountRequests(1, 0);
              if ($savings_accounts === false) {
                // Nothing Available

                echo "<h5 class='text-info'> No new Requests at this time.</h5>";
              } else {

                echo "<ol type='1'>";
                foreach ($savings_accounts as $savings_account) {
                  echo "<li>" . $this->Personal->userName($savings_account["user_id"]) . " &nbsp; ";
                  echo "<a href='" . base_url() . "admin/view_profile/" . $savings_account["user_id"] . "' class='btn btn-default' target='_blank' >View User Profile</a> &nbsp; ";
                  echo "<form method='post' style='display:inline;' action='" . base_url() . "admin/dashboard'>";
                  echo "<input type='hidden' name='account_id' value='" . $savings_account["id"] . "' />";
                  echo "<button type='submit' name='new_account_confirm' value='Confirm New Account' class='btn btn-primary' >Confirm New Account</button>";
                  echo "</form>";
                  echo "</li>";
                }
                echo "</ol>";
              }
              ?>
            <hr />
          </div>    */ ?>
          <?php
            // Table 2: Requests for Fecundvest Account
            ?>
          <h4 class='col-sm-12 col-sm-offset-1 mb-sm-10'>Requests for Fecundvest Account</h4>
          <div class='col-sm-12 col-sm-offset-1 mb-sm-10'>
            <?php
              $fixed_accounts = $this->Finance->getAccountRequests(2, 0);
              if ($fixed_accounts === false) {
                // Nothing Available

                echo "<h5 class='text-info'> No new Requests at this time.</h5>";
              } else {

                echo "<div class='card'>";
                foreach ($fixed_accounts as $keyf => $fixed_account) {
                  echo "<div class='row p-2' style='padding-bottom: 5px;border:1px solid #EEE; margin-bottom:-1px;'>";
                  
                  echo "<div class='col-lg-12'>";
                    echo ($keyf + 1).". ".$this->Personal->userName($fixed_account["user_id"]) . " &nbsp; ";
            //        print_r($fixed_account);
                    echo "<br/> &nbsp; ";
                      echo "   Purpose: " . $fixed_account["purpose"] . " ";
                      echo " | Target: " . $fixed_account["target"] . " ";
                      echo " | Duration: " . $fixed_account["duration"] . " ";
                      echo " | Frequency: " . $fixed_account["frequency"] . " ";
                      echo " | Deposit Amount: ₦" . number_format($fixed_account["deposit_amount"]);
                      echo " | Specific Day: <i>" . $fixed_account["specific_day"] . "</i> ";
                      echo " | Commencement: <i>" . $fixed_account["start_date"] . "</i> ";
                      echo " | Termination: <i>" . $fixed_account["end_date"] . "</i> ";
                      echo " | Bank Name: <i>" . $fixed_account["bank_name"] . "</i> ";
                //      echo " | Account Name: <i>" . $fixed_account["account_name"] . "</i> ";
                      echo " | Account Number: <i>" . $fixed_account["account_number"] . "</i> <br/>";
                      echo " | Referral Code: <i>" . $fixed_account["referral_code"] . "</i> ";
                  echo "</div>";
                  
                  echo "<div class='col-lg-12 m-2'>";
                    echo "<a href='" . base_url() . "admin/view_profile/" . $fixed_account["user_id"] . "' class='btn btn-default' target='_blank' >View User Profile</a> &nbsp; ";
                    echo "<form method='post' style='display:inline;' action='" . base_url() . "admin/dashboard'>";
                    echo "<input type='hidden' name='account_id' value='" . $fixed_account["id"] . "' />";
                    echo "<button type='submit' name='new_account_confirm' value='Confirm New Account' class='btn btn-primary' >Confirm New Account</button>";
                    echo "</form>";
                  echo "</div>";

                  echo "</div>";
                }
                echo "</div>";
              }
              ?>
            <hr />
          </div>
          <?php
            // Feature 1: Transaction Entry

            // Feature 2: Transaction Search
            // Table for Feature 2: Transactions Search Results
            // Feature 3: Inline Edit Amount/Delete Transaction



            ?>

          <?php
            // Get Pending Withdrawal Requests
            ?>

          <h4 class='col-sm-12 col-sm-offset-1 mb-sm-10'>Pending Withdrawal Requests</h4>
          <div class='col-sm-12 col-sm-offset-1 mb-sm-10'>
            <?php
              $pending_withdrawals = $this->Finance->getAllPendingWithdrawalRequests();
              if ($pending_withdrawals === false) {
                // Nothing Available

                echo "<h5 class='text-info'> There are no Pending Withdrawal Requests at this time.</h5>";
              } else {
                echo "<ol type='1'>";
                foreach ($pending_withdrawals as $pending_withdrawal) {
                  echo "<li>" . $this->Personal->userName($pending_withdrawal["user_id"]) . " &nbsp; | Amount: ₦" . number_format($pending_withdrawal["amount"]);
                  echo " | " . $pending_withdrawal["bank_account"] . " ";
                  echo " | Bank Name: <i>" . $pending_withdrawal["bank_name"] . "</i> ";
                  echo " | Account Name: <i>" . $pending_withdrawal["account_name"] . "</i> ";
                  echo " | Account Number: <i>" . $pending_withdrawal["account_number"] . "</i> <br/>";
                  echo " <a href='" . base_url() . "admin/view_profile/" . $pending_withdrawal["user_id"] . "' class='btn btn-xs btn-default' target='_blank' >View User Profile</a> &nbsp; ";
                  echo "<a href='" . base_url() . "admin/transaction_management/tr_history/" . $pending_withdrawal["user_id"] . "/2" . "' target='_blank' class='btn btn-xs btn-success' >Transaction History</a> ";

                  echo "<form method='post' style='display:inline;' action='" . base_url() . "admin/dashboard'>";
                  echo "<input type='hidden' name='request_id' value='" . $pending_withdrawal["id"] . "' />";
                  echo "<button type='submit' name='withdrawal_reject' value='Reject Loan' class='btn btn-xs btn-danger' >REJECT Withdrawal Request</button> ";
                  echo "<button type='submit' name='withdrawal_accept' value='Accept Loan' class='btn btn-xs btn-success' >Accept Withdrawal Request</button>";
                  echo "</form> ";
                  echo "</li>";
                }
                echo "</ol>";
              }
              ?>
            <hr class="divider-w mb-10">
          </div>


          <?php
            // Withdrawal History
            ?>

          <h4 class='col-sm-12 col-sm-offset-1 mb-sm-10'>Withdrawal History</h4>
          <div class='col-sm-12 col-sm-offset-1 mb-sm-10'>
            <?php

              //      echo " <a href='" . base_url() . "admin/withdrawal_history' class='' target='_blank' >View Withdrawal History</a> &nbsp; ";

              ?>

            <hr class="divider-w mb-10" style="height:5px;" >
          </div>
          

          <?php // Loans Preview: Pending Loans, Active Loans 
            ?>
          <?php
            // Get Pending Loan Requests
            ?>

          <h4 class='col-sm-12 col-sm-offset-1 mb-sm-10'>Pending Loan Requests</h4>
          <div class='col-sm-12 col-sm-offset-1 mb-sm-10'>
            
            <?php
              $pending_loans = $this->Finance->getAllPendingLoanRequests();
              if ($pending_loans === false) {
                // Nothing Available

                echo "<h5 class='text-info'> There are no Pending Loan Requests at this time.</h5>";
              } else {
                echo "<ol type='1'>";
                foreach ($pending_loans as $pending_loan) {
                  echo "<li class='item-list'>" . $this->Personal->userName($pending_loan["user_id"]) . " &nbsp; | Amount: ₦" . number_format($pending_loan["amount"]);
                  echo " | Duration: " . $pending_loan["duration"] . " months ";
                  
                  echo " | Current Income: " . $pending_loan["current_income"] . " ";
                  echo " | Cheque Book: <i>" . $pending_loan["cheque_book"] . "</i> ";
                  echo " | Servicing Other Loan: <b>" . $pending_loan["other_loan"] . "</b> ";
                  echo " | Payment Amount: " . $pending_loan["payment_amount"] . " ";
                  echo " | Deposit Frequency: " . $pending_loan["deposit_frequency"] . " ";
                  echo " | Specific Day: " . $pending_loan["specific_day"] . " ";
                  echo " | Purpose: " . $pending_loan["purpose"] . " ";
                  echo " | Collateral: " . $pending_loan["collateral"] . " ";

                  echo " <a href='" . base_url() . "admin/edit_loan_request/" . $pending_loan["id"] . "' class='btn btn-xs btn-primary' target='_blank' >Edit Request</a> &nbsp; ";
                  echo " <a href='" . base_url() . "admin/view_profile/" . $pending_loan["user_id"] . "' class='btn btn-xs btn-default' target='_blank' >View User Profile</a> &nbsp; ";
                  echo " <a href='" . base_url() . "admin/view_loan_history/" . $pending_loan["user_id"] . "' class='btn btn-xs btn-primary' target='_blank' >Loans History</a> &nbsp; ";
                  

                  echo "<form method='post' style='display:inline;' action='" . base_url() . "admin/dashboard'>";
                  echo "<input type='hidden' name='request_id' value='" . $pending_loan["id"] . "' />";
                  echo "<button type='submit' name='loan_reject' value='Reject Loan' class='btn btn-xs btn-danger' >REJECT Loan Request</button> ";
                  echo "<button type='submit' name='loan_accept' value='Accept Loan' class='btn btn-xs btn-success' >Accept Loan Request</button>";
                  echo "</form> ";
                  echo "</li>";
                }
                echo "</ol>";
              }
              ?>
            <hr class="divider-w mb-10">
          </div>


          <?php
            // Partner Account for Civil Engineering Listings OR Assisted Transport Listings

            // Apply for a Partner Account

            // Update Partner Account Info

            // Add a Listing

            // View All My Pending Listings

            // View All My Active Listings

            // View All My Disabled Listings
            ?>

          <?php
            // ADMIN: Confirm Partner Account Requests
            ?>

          <h4 class='col-sm-12 col-sm-offset-1 mb-sm-10'>Partner Account Requests</h4>
          <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
            <?php
              $pending_partners = $this->Partner->getAllPendingPartnerAccounts();
              if ($pending_partners === false) {
                // Nothing Available

                echo "<h5 class='text-info'> There are no Pending Partner Requests at this time.</h5>";
              } else {
                echo "<ol type='1'>";
                foreach ($pending_partners as $partner) {
                  echo "<li style='border:1px solid #ccc; padding:5px;'>Partner Account Type of Interest: <b style='text-transform:uppercase;'>" . $partner["category"] . "</b> |  " . $this->Personal->userName($partner["user_id"]) . " &nbsp; | Business: " . $partner["business_name"];
                  echo " | Owner: " . $partner["owner_name"] . "  ";
                  echo "<br/><a href='" . base_url() . "admin/view_partner/" . $partner["id"] . "' class='btn btn-xs btn-default' target='_blank' >View Partner Info</a> &nbsp; ";
                  echo "<a href='" . base_url() . "admin/view_profile/" . $partner["user_id"] . "' class='btn btn-xs btn-warning' target='_blank' >View User Profile</a> &nbsp; ";
                  echo "<form method='post' style='display:inline;' action='" . base_url() . "admin/dashboard'>";
                  echo "<input type='hidden' name='partner_id' value='" . $partner["id"] . "' />";
                  echo "<button type='submit' name='partner_reject' value='Reject Partner' class='btn btn-xs btn-danger' >REJECT Partner Request</button> ";
                  echo "<button type='submit' name='partner_accept' value='Accept Partner' class='btn btn-xs btn-success' >Accept Partner Request</button>";
                  echo "</form> ";
                  echo "</li>";
                }
                echo "</ol>";
              }
              ?>
            <hr class="divider-w mb-10">
          </div>



          <?php
            // Get Active Loans
            ?>

          <h4 class='col-sm-12 col-sm-offset-1 mb-sm-10'>Active Loan Transactions Management</h4>
          <div class='col-sm-12 col-sm-offset-1 mb-sm-10'>
            <?php
              $active_loans = $this->Finance->getAllActiveLoans();
              if ($active_loans === false) {
                // Nothing Available

                echo "<h5 class='text-info'> There are no Active Loans at this time.</h5>";
              } else {
                echo "<ol type='1'>";
                foreach ($active_loans as $active_loan) {
                  echo "<li>" . $this->Personal->userName($active_loan["user_id"]) . " &nbsp; | Amount: ₦" . number_format($active_loan["amount"]);
                  echo " | Duration: " . $active_loan["duration"] . " months ";
                  echo "<a href='" . base_url() . "admin/view_profile/" . $active_loan["user_id"] . "' class='btn btn-xs btn-default' target='_blank' >View User Profile</a> &nbsp; ";
                  echo "<a href='" . base_url() . "admin/view_loan_history/" . $active_loan["user_id"] . "/2" . "' target='_blank' class='btn btn-xs btn-primary' >Loans History</a> ";

                  echo "<form method='post' style='display:inline;' action='" . base_url() . "admin/dashboard'>";
                  echo "<input type='hidden' name='loan_id' value='" . $active_loan["id"] . "' />";
      //      echo "<button type='submit' name='loan_repay' value='Add a Repayment' class='btn btn-xs btn-danger' >Add a Repayment</button>";
                if ($my_privilege[0]["permission"] == 10) {
                  echo "<button type='submit' name='loan_complete' value='Mark as Fully Repaid' class='btn btn-xs btn-success' >Mark as Fully Repaid</button>";
                }
                  echo "</form>";
                  echo "</li>";
                }
                echo "</ol>";
              }
              ?>
            <hr class="divider-w mb-10">
          </div>

          
          <?php
            // ADMIN: Publish Pending Listings

            // ADMIN: View All Listings
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

  <script src="<?php echo base_url(); ?>assets/js/typeahead/jquery.typeahead.min.js"></script>

  <script>
    $(document).ready(function() {

      var clientNames = new Array();
      var clientIds = new Object();

      $.each(clients_array, function(index, clientDats) {
        var client_name_val = clientDats[1] + " " + clientDats[2] + " " + clientDats[3] + " " + clientDats[4];
        clientNames.push(unescapeHtml(client_name_val));
        clientIds[client_name_val] = clientDats[0];
      });
      $('#member_text').typeahead({
        source: clientNames,
        order: "desc",
        minLength: 1,
        callback: {
          onInit: function(node) {
            console.log('Typeahead Initiated on ' + node.selector);
          },
          onClickAfter: function(node, a, item, event) {
            var new_c_id = clientIds[escapeHtml($('#member_text').val())];

            // Update Member ID
            $("#member_id").val(new_c_id);

          }
        }
      });

    });

    function escapeHtml(unsafe) {
      return $('<div />').text(unsafe).html();
    }

    function unescapeHtml(safe) {
      return $('<div />').html(safe).text();
    }
  </script>