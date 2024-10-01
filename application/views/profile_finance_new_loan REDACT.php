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

          <?php
            // Show New Loan Request Form

            /**
             * 
             * Number of children 
             * 
             * Lockup shop (yes or no) ｛business only｝
             * Operational bank account Type (savings, current or corporate)
             * functional bank cheque book (yes or no)
             * 
             * Extra Needed details on request for services { for loans and hire purchase partner's only}
             * Current salary income / weekly business turnover 
             * Currently servicing other loan (yes or no)
             * Referee 
             * Amount requested 
             * Purpose of loan {for loan request only}
             * 
             */
            ?>
          <div class='col-sm-10 col-sm-offset-1 mb-sm-10'>
            <form class="form" method="POST" style="overflow: hidden;">
              <h4>New Loan Request Form</h4>
              <?php
                if (isset($request_loan_form_error)) {
                  if ($request_loan_form_error != "") {
                    echo $request_loan_form_error;
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
                    <label>Amount</label>
                    <input class="form-control" id="loan_amount" type="number" name="loan_amount" placeholder="Loan Amount" value="" required />
                  </div>
                  <div class="form-group">
                    <label>Duration (months)</label>
                    <input class="form-control" id="loan_duration" type="number" name="loan_duration" placeholder="e.g. 6" value="" required />
                  </div>


                  <?php /*
                    <div class="form-group">
                      <label>No of Children</label>
                      <input class="form-control" type="number" name="children" placeholder="No of Children" value="" required />
                    </div>
*/ ?>

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
                    <label>Do you have a functional bank cheque book for the account?</label>
                    <select class="form-control" name="cheque_book" required>
                      <option value="">--Select One--</option>
                      <option>Yes</option>
                      <option>No</option>
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
                    <label>Current monthly salary income / Average monthly business turnover</label>
                    <input class="form-control" type="number" name="current_income" placeholder="" value="" required />
                  </div>

                  <div class="form-group">
                    <label>Are you currently servicing any other loan, possibly from a bank or other company?</label>
                    <select class="form-control" name="other_loan" required>
                      <option>No</option>
                      <option>Yes</option>
                    </select>
                  </div>


                  <div class="form-group">
                    <input class="" id="loan_confirm" type="checkbox" name="loan_confirm" placeholder="Loan Confirm" value="" required />
                    <label for="loan_confirm">I have cross-checked and ensured that the values entered above are accurate and reliable! </label>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-round btn-b" type="submit" name='request_loan_but' value="Send Request">Send Request</button>
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