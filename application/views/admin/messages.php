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
          <h4 class="font-alt">DIRECT MESSAGES</h4>
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

            $admin_messages = $this->Personal->getAdminMessages();

            ?>

          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>

            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-border checkout-table dataTable table-responsive">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Sender</th>
                      <th>Recipient</th>
                      <th>Title</th>
                      <th>Attachments</th>
                      <th>Sent</th>
                      <?php /*          <th>Opened</th> */ ?>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $o = "";
                      if ($admin_messages !== false) {
                        foreach ($admin_messages as $index => $message) {

                          $attachment_count_label = "None";

                          $message_opened_time_label = "";

                          $o .= "<tr>";
                          $o .= "<td>" . ($index + 1) . "</td>";
                          $o .= "<td>" . ($message['type'] == 1 ? $this->Personal->userName($message['sender_id']) : "Admin") . "</td>";
                          $o .= "<td>" . ($message['type'] == 2 ? $this->Personal->userName($message['recipient_id']) : "Admin") . "</td>";
                          $o .= "<td>" . $message['title'] . "</td>";
                          $o .= "<td>" . $attachment_count_label . "</td>";
                          $o .= "<td title='" . getfulldateinfo_Type1($message['time_updated']) . "'>" . date("d/m/Y", strtotime($message['time_updated'])) . "</td>";
                          //          $o .= "<td>" . $message_opened_time_label . "</td>";
                          $o .= "<td>";
                          $o .= "<a href='" . base_url() . "admin/message_view/" . $message['id'] . "' class='btn btn-xs btn-default' >View</a>";
                          $o .= "</td>";
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