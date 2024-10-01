<?php
$this->load->view("template/profile_headlinks");
?>

<?php
$this->load->view("template/profile_nav");
?>
<?php
$this->load->view("template/slider_empty");
?>

<?php
$my_info = $this->Personal->myPersonalInfo();
if ($my_info !== false) {
  if (($my_info["surname"] == "") || ($my_info["firstname"] == "") || ($my_info["phone"] == "")) {
    $my_info = false;
  }
}
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
          <h4 class="font-alt">FINANCE</h4>
          <hr class="divider-w mb-10">
        </div>
        <?php
        // Check if Account has been verified
        $verify_account_status = $this->Users->getVerifyAccountInfoByID($this->Users->getUserID());

        if ($verify_account_status['status'] == 9) {
          echo "<p>You need to verify your email address to enable your account! An email was sent to " . $verify_account_status['email'] . " inbox when you registered. The email contains the verification link. Check your spam folder also, just in case. </p>";
        } else {

          // Savings Account Preview
          ?>

          <?php
            $this->load->view("template/dashboard_nav");
            ?>

          <p class="text-danger"><br/><b>Kindly keep your profile information updated to enable us serve you better and faster</b></p>

          <?php /* Large Nav Buttons */ ?>

          <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
            
            <h4>Request For Our Services</h4>
            <p class="text-success"><b> <a class="btn btn-success" href="<?php echo base_url(); ?>profile/new_special_message/finance">Hire Purchase</a></b></p>

          </div>

          <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
            <h4>Loans</h4>
            
            <?php // Loans Preview: Active Loans, Request New (If conditions are met, e.g. only 1 loan at a time) 
            ?>

            <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
              <h4>Active Loans</h4>
              <?php
                // Get Active Loans
                $check_active = $this->Finance->getActiveLoans($this->Users->getUserID());
                if ($check_active !== false) {
                  echo "<ol type='1'>";
                  foreach ($check_active as $req) {
                    echo "<li class='text-info'>";
                    echo "<span><b>Amount</b>: ₦" . number_format($req["amount"], 0) . " | </span> ";
                    echo "<span><b>Duration</b>: " . $req["duration"] . " months</span> | ";
                    echo "<span><b>Date of Application</b>: " . date("Y-m-d", strtotime($req["time_created"])) . "</span>";
                    echo "</form>";
                    echo "</li>";
                  }
                  echo "</ol>";
                } else {
                  echo "<p>No Active Loans at this time</p>";
                }
                ?>
              <hr />
            </div>

            <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
              <h4>Pending Loan Requests</h4>
              <?php
                // Get Pending Loan Request info
                $check_pending = $this->Finance->getPendingLoanRequest($this->Users->getUserID());
                if ($check_pending !== false) {
                  echo "<ul type='circle'>";
                  foreach ($check_pending as $req) {
                    echo "<li class='text-info'>";
                    echo "<span><b>Amount</b>: ₦" . number_format($req["amount"], 0) . " | </span> ";
                    echo "<span><b>Duration</b>: " . $req["duration"] . " months | </span> ";
                    echo "<span><b>Date of Application</b>: " . date("Y-m-d", strtotime($req["time_created"])) . "</span>";
                    echo "</form>";
                    echo "</li>";
                  }
                  echo "</ul>";
                } else {
                  echo "<p>No Pending Loan Requests at this time</p>";
                }
                ?>
              <hr />
            </div>

            <div class="col-lg-12">
              <a href="<?php echo base_url(); ?>profile/request_loan_form" class="btn btn-primary btn-lg">
                Make a New Loan Request
              </a>
<!--              <a href="" class="btn btn-primary btn-lg">
                View my Loan History
              </a>  -->
            </div>

          </div>
        </div> <!-- row -->

        <br/><hr/><br/>

        <div class="row">

          <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
            <h4>My Fecundvest Account</h4>
            <div class="col-lg-12">

              <?php // Fecundvest Account Preview 
            ?>
          <h4 class="col-sm-12 text-danger"><b>Premature Withdrawals / Termination:</b><br/> Clients are required to give a 14 working days withdrawal notification for withdrawals (before maturity date) below ₦100,000.<br/> and 30 working days notification for withdrawals (before maturity date) above ₦100,000.</h4>
          <div class='col-sm-12'>
            <?php

              $client_account_balance = 0;

              if ($my_info !== false) {
                $fixed_deposit_account_info = $this->Finance->getAccount($this->Users->getUserID(), 2);
                if ($fixed_deposit_account_info === false) {
                  // Ask to Request for A Fecundvest Account

                  echo "<h5 class='text-info'> To Request for a Fecundvest Account: </h5><a href='" . base_url() . "profile/new_fixed'><button class='btn btn-primary' >Click Here!</button></a>";
                  echo "";
                } else {

                  // GET FIXED DEPOSIT ACCOUNT BALANCE FROM TRANSACTIONS
                  $total = 0;
                  $records = $this->Finance->getTransactionRecordByAccountNo($fixed_deposit_account_info["id"]);
                  if ($records !== false) {
                    foreach ($records as $record) {
                      // Fecundvest Credit
                      if ($record["type"] == 1)
                        $total += $record["amount"];

                      // Fecundvest Withdrawal
                      if ($record["type"] == 5)
                        $total -= $record["amount"];
                      
                      // Admin Charges
                      if ($record["type"] == 6)
                        $total -= $record["amount"];
                      
                      // Default Charge
                      if ($record["type"] == 7)
                        $total -= $record["amount"];
                    }
                  }

                  $client_account_balance = $total;

                  echo "<h3 class='text-success'><b> Account Balance is ₦" . number_format($total, 2) . "</b></h3>";
                  //      echo "<a href='#' ><p class='text-default'> Transaction History (Feature Coming Soon)" . "</p></a>";
                }
              } else {
                echo "<p class='text-danger'> Edit/Update your profile information such as <b>Surname</b> and <b>First Name</b> and <b>Phone Number (1)</b> to access this feature.</p>";
              }
              ?>
            <hr />
          </div>

          <?php
            if ($fixed_deposit_account_info === false) {
              // Fecundvest account not yet opened
            }else{
          ?>
          
          <div class='col-sm-12'>
            <h4>Pending Withdrawal Requests</h4>
            <?php
              // Get Pending Withdrawal Request info
              $check_pending = $this->Finance->getPendingWithdrawalRequest($this->Users->getUserID());
              if ($check_pending !== false) {
                echo "<ul type='circle'>";
                foreach ($check_pending as $req) {
                  echo "<li class='text-info'>";
                  echo "<span><b>Amount</b>: " . $req["amount"] . " | </span> ";
                  echo "<span><b>Date of Application</b>: " . date("Y-m-d", strtotime($req["time_created"])) . "</span>";
                  echo "</form>";
                  echo "</li>";
                }
                echo "</ul>";
              } else {
                echo "<p>No Pending Loan Requests at this time</p>";
              }
              ?>
            <hr />
          </div>

          <a href="<?php echo base_url(); ?>profile/withdrawal_form" class="btn btn-success btn-lg">
            Withdraw from my Fecundvest
          </a>

          <?php
          }
          ?>

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



  <script type="text/javascript">
    computeFigures = function() {
      var amount = Number($("#loan_amount").val());

      if ((amount != "")) {
        if (typeof amount == "number") {

          $("#loan_amount").val(amount);

        }

        if (isNaN(amount)) {

          $("#loan_amount").val("0");

        }

        amount = Number($("#loan_amount").val())

        if (amount > 0) {
          // Compute Interest

        }
      }
    }

    $(function() {

      computeFigures();

      $("body").on("keyup", "#loan_amount", function() {
        computeFigures();
      })
      $("body").on("click", "#loan_amount", function() {
        computeFigures();
      })
    });


    function escapeHtml(unsafe) {
      return $('<div />').text(unsafe).html();
    }

    function unescapeHtml(safe) {
      return $('<div />').html(safe).text();
    }
  </script>