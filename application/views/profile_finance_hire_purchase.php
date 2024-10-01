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
          <h4 class="font-alt">FINANCE</h4>
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

            ?>

          <div class='col-sm-12 mb-sm-12'>
            <div class="col-lg-12">
              <a href="<?php echo base_url(); ?>profile/finance_home" class="btn btn-primary btn-xs">
                Back to Finance Dashboard
              </a>
            </div>
          </div>

          <h2 class="col-sm-12"><b>Hire Purchase<b></h2>
          <h4 class="col-sm-12 text-danger"><b></b><br/></h4>
          <div class='col-sm-12'>
          </div>

          <div class='col-sm-12'>
            
            <p class="text-success"><b> <a class="btn btn-success btn-lg" href="<?php echo base_url(); ?>profile/finance_section_hire_purchase_new_listing/finance">Hire Purchase Request Listing</a></b></p>

          </div>
<?php /*
          <div class='col-sm-12'>
            
            <p class="text-success"><b> <a class="btn btn-success btn-lg" href="<?php echo base_url(); ?>profile/finance_section_hire_purchase_form/finance">Special Request</a></b></p>

          </div>  */ ?>

          <hr class="divider-w mb-10">

          <h4 class="col-sm-12"><b>Published Listings<b></h4>
          <?php
            $this->load->view("published_listings_rows", array("category" => 3));
          ?>

          <br/><br/><br/>
          <hr class="divider-w mb-10">

          <h4 class="col-sm-12"><b>My Listings<b></h4>
          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>
          <?php
            $this->load->view("profile_listings_mine_rows", array("listing_type" => "hire_purchase"));
          ?>

          </div>

          

        </div> <!-- end row -->
        <hr class="divider-w mb-10">


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