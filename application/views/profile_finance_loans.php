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
              <a href="<?php echo base_url(); ?>profile/finance_home" class="btn btn-primary btn-xs">
                Back to Finance Dashboard
              </a>
            </div>

          </div>


          <div class='col-sm-12'>
            <h2><b>Loans</b></h2>
            
            <?php // Loans Preview: Active Loans, Request New (If conditions are met, e.g. only 1 loan at a time) 
            ?>

            <div class='col-sm-12'>
              <h4><b>Active Loans</b></h4>
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

            <div class='col-sm-12'>
              <h4><b>Pending Loan Requests</b></h4>
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
<!--              <a href="" class="btn btn-primary btn-lg">
                View my Loan History
              </a>  -->
            </div>

          </div>

          <?php 
            $data["my_info"] = $my_info;
            $this->load->view("profile_finance_new_loan", $data);
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