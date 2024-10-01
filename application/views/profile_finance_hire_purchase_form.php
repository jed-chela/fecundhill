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

          <script type="text/javascript">
            <?php
              echo "var _base_url = '" . base_url() . "';";
              echo "var clients_array = [];";

              $clients_array = $this->Personal->getAllProfilesArray();
              if ($clients_array !== false) {

                foreach ($clients_array as $key => $value) {
                  echo "var cli_arr_obj = ['" . $value["user_id"] . "', '" . $value["title"] . "', '" . $value["firstname"] . "', '" . $value["surname"] . "', '" . $value["othername"] . "'] ;";

                  echo "clients_array.push(cli_arr_obj);";
                }
              }

              ?>
          </script>

          <?php
            $form_category = "finance";

            $hide_cat_1 = "";
            $hide_cat_2 = "";
            $hide_cat_3 = "";
            if ($form_category != "") {
              if ($form_category == "real_estate") {
                $hide_cat_2 = "hidden";
                $hide_cat_3 = "hidden";
              } else if ($form_category == "transport") {
                $hide_cat_1 = "hidden";
                $hide_cat_3 = "hidden";
              } else if ($form_category == "finance") {
                $hide_cat_1 = "hidden";
                $hide_cat_2 = "hidden";
              }
            }
          ?>

          <div class='col-sm-12 mb-sm-12'>
            <div class="col-lg-12">
              <a href="<?php echo base_url(); ?>profile/finance_section_hire_purchase" class="btn btn-primary btn-xs">
                Back
              </a>
            </div>
          </div>

          <div class='col-sm-12 mb-sm-12'>
            <br/>
            <hr class="divider-w mb-40">
          </div>

          <h4 class='col-sm-12'><b> Hire Purchase Request Form</b></h4>
          <div class='col-sm-11'>
            <div class='col-sm-10 mb-sm-8'>
              <form method="post" enctype="multipart/form-data">

                <div class="row mb-10">
                  <?php
                    if (isset($direct_message_error)) {
                      if ($direct_message_error != "") {
                        echo $direct_message_error;
                      }
                    }
                    ?>
        <!--          <div class="form-group mb-10">
                    <label for="member_text">Recipient: <b>Fecundhill Admin</b></label>
                    
                  </div>  -->
                </div>
                <div class="row">
                  <div class="form-group hidden">
                    <label>Category</label>
                    <select class="form-control" name="msg_category" required>
                      
                      <?php
                        if ($hide_cat_1 == "") {
                          echo "<option>Real Estate</option>";
                        }
                        if ($hide_cat_2 == "") {
                          echo "<option>Transport</option>";
                        }
                        if ($hide_cat_3 == "") {
                          echo "<option>Finance</option>";
                        }
                      ?>

                    </select>
                  </div>
                  <div class="form-group hidden">
                    <label>Sub Category</label><br />
                    <?php
                      if ($hide_cat_2 == "") {
                        ?>
                <!--      <input type="checkbox" name="sub_cat[]" value="Hire Purchase" /> Hire Purchase<br />  -->
                      <input type="checkbox" name="sub_cat[]" value="Executive Ride" /> Executive Ride<br />
                      <input type="checkbox" name="sub_cat[]" value="Flight Booking" /> Flight Booking<br />
                    <?php
                      }
                      if ($hide_cat_3 == "") {
                    ?>
                      <input type="checkbox" name="sub_cat[]" checked value="Hire Purchase" /> Hire Purchase<br />
                    <?php
                      }
                      if ($hide_cat_1 == "") {
                    ?>
                      <input type="checkbox" name="sub_cat[]" value="Certificate of Occupancy" /> Certificate of Occupancy<br />
                      <input type="checkbox" name="sub_cat[]" value="Land Survey" /> Land Survey<br />
                      <input type="checkbox" name="sub_cat[]" value="Building Plan" /> Building Plan<br />
                      <input type="checkbox" name="sub_cat[]" value="Property Development" /> Property Development<br />
                      <input type="checkbox" name="sub_cat[]" value="Property Sale and Purchase" /> Property Sale and Purchase<br />
                    <?php
                      }
                      ?>
                      
                  </div>
                  <div class="form-group mb-10">
                    <label for="msg_location">Location</label>
                    <input class="form-control" type="text" name="msg_location" id="msg_location" required style="text-transform: none;">
                  </div>
                  <?php
                      if ($hide_cat_1 == "hidden") {
                  ?>
                  <div class="form-group mb-10 hidden">
                    <label for="msg_destination">Destination</label>
                    <input class="form-control" type="text" name="msg_destination" id="msg_destination" value="" style="text-transform: none;">
                  </div>
                  <?php
                      }
                  ?>
                  <div class="form-group mb-10">
                    <label for="msg_subject">Message Title</label>
                    <input class="form-control" type="text" name="msg_subject" id="msg_subject" required style="text-transform: none;">
                  </div>
                  <div class="form-group mb-10">
                    <label for="msg_body">Message</label>
                    <textarea class="form-control" name="msg_body" id="msg_body" rows=4 required style="text-transform: none;"></textarea>
                  </div>
                  <div class="form-group mb-10">
                    <label for="file_upload">Upload Attachments (Max File Size of 2MB each. Please Note that Files larger than 2MB won't be uploaded and attached to the message. Allowed File Types: .jpg, .jpeg, .png, .pdf, .doc, .docx)</label>

                    <input type="file" class="form-control" name="file_upload[]" id="file_upload" accept=".pdf,.doc,.docx,image/*" multiple>
                  </div>

                  <div class="form-group">
                    <input type="submit" name="special_request_submit" class="btn btn-primary" disabled>
                  </div>

                </div>

              </form>
            </div>
          </div>
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