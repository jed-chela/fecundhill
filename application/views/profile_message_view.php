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
          <h4 class="font-alt">VIEW MESSAGE</h4>
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
            // Messages and Notifications

            $message = $this->Personal->getMessage($message_id);

            ?>

          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>

            <div class="row">
              <div class="col-sm-12">
                <a href="<?php echo base_url(); ?>profile/messages" style="text-decoration: none; color:blue;" >Back to Messages</a>
                <?php
                  if ($message !== false) {
                  
                    $recipient_label = "Received from Admin";
                    if ($message['type'] == 1) {
                      $recipient_label = "Sent to Admin";
                    }

                    $attachment_count_label = "None";
                    $attachments = $this->Personal->getMessageAttachments($message['id']);
                    if ($attachments !== false) {
                      $attachment_count_label = count($attachments);
                    }

                    $message_opened_time_label = "";
                    $o = "";
                    $o .= "<div>";
                      
                      $o .= "<h5> Date: " . getfulldateinfo_Type1($message['time_updated']) . "</h5>";
                      $o .= "<div>Message Type: " . $recipient_label . "</div>";
                      $o .= "<h2>" . $message['title'] . "</h2>";
                      $o .= "<h5>" . $message['message'] . "</h5>";
                      if($attachment_count_label == "None"){
                         $o .= "<div></div>";
                      }else{
                        $o .= "<div><b>Attachment(s): </b></div>";
                        foreach($attachments as $attached){
                          $o .= "<div>";
                            $o .= "<b><a href='".base_url()."uploads/dmfiles/".$attached['file_name']."' target='_blank' style='text-decoration: none; color:blue;' >".$attached['file_name']."</a></b>";
                          $o .= "</div>";
                        }
                        
                      }
                     
                      
                      
                    $o .= "</div>";
                  
                  }

                  echo $o;
                  ?>


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