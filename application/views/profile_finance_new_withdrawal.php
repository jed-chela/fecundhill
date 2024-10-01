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

          <div class='col-sm-12 mb-sm-12'>
            <div class="col-lg-12">
              <a href="<?php echo base_url(); ?>profile/finance_home" class="btn btn-primary btn-lg">
                Back to Finance Dashboard
              </a>
            </div>

          </div>

          <?php // Fecundvest Account Preview 
            ?>
          <h4 class="col-sm-12 col-sm-offset-1 mb-sm-40">My Fecundvest Account</h4>
          <h4 class="col-sm-12 col-sm-offset-1 mb-sm-40 text-danger"><b>Premature Withdrawals / Termination:</b><br/> Clients are required to give a 14 working days withdrawal notification for withdrawals (before maturity date) below ₦100,000.<br/> and 30 working days notification for withdrawals (before maturity date) above ₦100,000.</h4>
          <div class='col-sm-12 col-sm-offset-1 mb-sm-10'>
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

                      // Bank Charges
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
          
          
          <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
            <form class="form" method="POST" style="overflow: hidden;">
              <h4>Withdrawal Request Form</h4>
              <?php
                if (isset($withdrawal_form_error)) {
                  if ($withdrawal_form_error != "") {
                    echo $withdrawal_form_error;
                  }
                }
                ?>
              <?php
                if ($my_info !== false) {
                  ?>
                <div class='col-sm-10 mb-sm-10' style="border: 1px solid #DDD;">
                  <div class="form-group">
                    <label>My Name</label>
                    <span><?php echo $my_info['firstname'] . " " . $my_info['surname'] . " " . $my_info['othername'] ?></span>
                  </div>
                  <div class="form-group">
                    <label>You can Withdraw up to: </label>
                    <span><?php
                        if($client_account_balance > 500){
                            echo "₦" . number_format( ($client_account_balance - 500), 2);
                        }else{
                          echo "₦0";
                        }
                      
                    ?></span>
                  </div>
                  <div class="form-group">
                    <label>Amount <span></span> </label>
                    <input class="form-control" type="number" name="withdraw_amount" placeholder="Withdrawal Amount" value=""
                    <?php
                        if($client_account_balance > 500){
                          $withdraw_limit_val = $client_account_balance - 500;
                          echo " max = " .($client_account_balance - 500)." ";
                        }else{
                          $withdraw_limit_val = 0;
                          echo " max = 0 ";
                        }
                      
                    ?>
                     required />
                    <input class="form-control" type="hidden" name="withdraw_limit" value="<?php echo $withdraw_limit_val; ?>" />
                  </div>

                  <div class="form-group">
                    <label>Which bank account type do you operate?</label>
                    <select class="form-control" name="bank_account" required>
                      <option value="">--Select One--</option>
                      <option>Current Account</option>
                      <option>Savings Account</option>
                      <option>Corporate Account</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Bank Name</label>
                    <input class="form-control" type="text" name="bank_name" maxlength="255" placeholder="" value="" required />
                  </div>
                  <div class="form-group">
                    <label>Account Name</label>
                    <input class="form-control" type="text" name="account_name" maxlength="255" placeholder="" value="" required />
                  </div>
                  <div class="form-group">
                    <label>Bank Account Number</label>
                    <input class="form-control" type="number" name="account_number" maxlength="20" placeholder="" value="" required />
                  </div>

                  <div class="form-group">
                    <input class="" type="checkbox" id="withdraw_confirm" name="withdraw_confirm" placeholder="Withdraw Confirm" value="" required />
                    <label for="withdraw_confirm">I have cross-checked and ensured that the values entered above are accurate and reliable! </label>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-round btn-b" type="submit" name='withdrawal_but' value="Send Request">Send Withdrawal Request</button>
                  </div>
                </div>
              <?php
                } else {
                  echo "<p class='text-danger'> Edit/Update your profile information such as <b>Surname</b> and <b>First Name</b> and <b>Phone Number (1)</b> to access this feature.</p>";
                }
                ?>
            </form>
            <hr />
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