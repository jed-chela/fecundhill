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
          <h4 class="font-alt">USER MANAGEMENT</h4>
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

          <?php
            // Messages and Notifications

            $users = $this->Users->getAllUsers();

          ?>

          <hr class="divider-w mb-10">
          <div class='col-sm-12 mb-sm-12'>

            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-border checkout-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Email</th>
                      <th>Profile Edit</th>
                      <th>Title</th>
                      <th>Surname</th>
                      <th>First Name</th>
                      <th>Othernames</th>
                      <th>Date Joined</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $o = "";
                      if ($users !== false) {
                        foreach ($users as $index => $user) {

                          $title        = "";
                          $surname      = "";
                          $firstname   = "";
                          $othername    = "";
                          $profile_status_label = "";

                          $profile_info = $this->Personal->personalInfo($user['id']);
                          if ($profile_info !== false) {
                            $title        = $profile_info["title"];
                            $surname      = $profile_info["surname"];
                            $firstname   = $profile_info["firstname"];
                            $othername    = $profile_info["othername"];
                            if($profile_info["lock_status"] == 0){
                              $profile_status_label = "Editable";
                            }else if($profile_info["lock_status"] == 1){
                              $profile_status_label = "Locked";
                            }
                            
                          }

                          $sub_admin_status = $this->Users->getSubAdminAccess($user['id']);

                          $my_info = $profile_info;
                          if ($my_info !== false) {
                            if (($my_info["surname"] == "") || ($my_info["firstname"] == "") || ($my_info["phone"] == "")) {
                              $my_info = false;
                            }
                          }

                          $o .= "<tr>";
                          $o .= "<td>" . ($index + 1) . "</td>";
                          $o .= "<td>" . $user['email'] . "</td>";
                          $o .= "<td>" . $profile_status_label . "</td>";
                          $o .= "<td>" . $title . "</td>";
                          $o .= "<td>" . $surname . "</td>";
                          $o .= "<td>" . $firstname . "</td>";
                          $o .= "<td>" . $othername . "</td>";
                          $o .= "<td title='" . getfulldateinfo_Type1($user['time_created']) . "'>" . date("d/m/Y", strtotime($user['time_created'])) . "</td>";
                          $o .= "<td>";
                          if($my_info !== false){
                            $o .= "<a href='" . base_url() . "admin/view_profile/" . $user["id"] . "' target='_blank' class='btn btn-xs btn-default' title='View' ><i class='fa fa-eye'></i></a> ";
                          }else{
                            $o .= "<button class='btn btn-xs btn-default' disabled >No Profile Info Yet</button> ";
                          }
                          if($profile_status_label == "Editable"){
                          $o .= "<a href='" . base_url() . "admin/user_management/lock_profile/" . $user["id"] . "' class='btn btn-xs btn-warning' title='Lock Profile' ><i class='fa fa-lock'></i></a>";
                          }else if($profile_status_label == "Locked"){
                          $o .= "<a href='" . base_url() . "admin/user_management/unlock_profile/" . $user["id"] . "' class='btn btn-xs btn-primary' title='Unlock Profile' ><i class='fa fa-unlock'></i></a>";
                          }
                          // Sub Admin Access
                          if($my_privilege[0]["permission"] == 10){
                            if($sub_admin_status === false){
          $o .= " <a href='" . base_url() . "admin/user_management/enable_subadmin/" . $user["id"] . "' ".
            "class='btn btn-xs btn-primary' onclick=\"if(confirm('Are you sure that you want to make this User a Sub-Admin?')){}else{return false;}\" title='Make Sub-Admin' ><i class='fa fa-user-plus'></i></a>";
                            }else{
                  //            print_r($sub_admin_status[0]);
                              if( ($sub_admin_status[0]["permission"] == 10) && ($sub_admin_status[0]["user_id"] != $current_user_id ) ){
          $o .= " <a href='" . base_url() . "admin/user_management/disable_subadmin/" . $user["id"] . "' class='btn btn-xs btn-danger' title='Remove as MAIN-Admin' ><i class='fa fa-user'></i> <i class='fa fa-close'></a>";
                              }else if ($sub_admin_status[0]["permission"] == 1) {
          $o .= " <a href='" . base_url() . "admin/user_management/disable_subadmin/" . $user["id"] . "' class='btn btn-xs btn-primary' title='Remove as Sub-Admin' ><i class='fa fa-user'></i> <i class='fa fa-close'></i></a>";
          $o .= " <a href='" . base_url() . "admin/user_management/enable_mainadmin/" . $user["id"] . "' ".
              "class='btn btn-xs btn-danger' onclick=\"if(confirm('Are you sure that you want to make this User a MAIN Admin?')){}else{return false;}\" title='Make MAIN-Admin' ><i class='fa fa-user-plus'></i></a>";
                              }
                            }
                          }
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