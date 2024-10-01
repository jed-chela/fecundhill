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
          <div class="row">
            <div class='col-sm-6'>
              <div class='col-sm-12'>
                
                <p class="text-success"><b> <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>profile/finance_section_loans">Loans</a></b></p>

              </div>

<!--              <div class='col-sm-12 hidden x-none'>
                
                <p class="text-success"><b> <a class="btn btn-success btn-lg" href="<?php echo base_url(); ?>profile/finance_section_hire_purchase">Hire Purchase</a></b></p>

              </div>  -->


              <div class='col-sm-12'>
                
                <p class="text-success"><b> <a class="btn btn-success btn-lg" href="<?php echo base_url(); ?>profile/finance_section_fecundvest">Fecundvest</a></b></p>

              </div>
            </div>
  <?php /*  <div class='col-sm-6'>
              <h4>Fecundhill Official Online Payment</h4>
              <div><a href="https://flutterwave.com/pay/n6dakku6voo8" target="_blank"><button class="btn btn-info">Make a Payment</button></a></div>
            </div>  */ ?>
          </div>

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