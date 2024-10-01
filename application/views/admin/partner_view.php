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

$my_info = $this->Partner->getPartnerAccount($partner_id);
if ($my_info !== false) {

  $personal_info = $this->Personal->personalInfo($my_info["user_id"]);
  if ($personal_info !== false) {

    //  print_r($my_info);

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
              <h4 class="font-alt">PARTNER INFO of <?php echo $my_info["business_name"]; ?></h4>
              <hr class="divider-w mb-10">
            </div>

            <?php
                if (isset($form_error)) {
                  if ($form_error != "") {
                    echo $form_error;
                  }
                }
                ?>

            <?php
                if ($my_info["lock_status"] == 1) {
                  // Profile Locked against Editing by User
                  echo "Profile editing has been disabled for your account. 
            Contact the website admin to make updates to your profile.";
                } else {
                  // Profile Enabled for Editing by User
                  ?>

              <br />
              <hr />
              <h4>Personal Info</h4>
              <div class="form-group">
                <label>Personal Name &nbsp; &nbsp; &nbsp; </label><?php echo $personal_info['title'] . " <b>" . $personal_info['surname'] . 
                "</b> " . $personal_info['firstname'] . " ". $personal_info['othername'] ; ?>
              </div>
              <div class="form-group">
                <label>Personal Other Name(s) &nbsp; &nbsp; &nbsp; </label>
              </div>
              <div class="form-group">
                <label>Personal Email &nbsp; &nbsp; &nbsp; </label><?php echo $personal_info['email']; ?>
              </div>
              <div class="form-group">
                <label>Personal Phone &nbsp; &nbsp; &nbsp; </label><?php echo $personal_info['phone']; ?>
              </div>

              <hr />
              <h4>Partner Account Info</h4>
              <div class="form-group">
                <label>Business Name &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['business_name']; ?>
              </div>
              <div class="form-group">
                <label>Owner Name &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['owner_name']; ?>
              </div>
              <div class="form-group">
                <label>Description &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['description']; ?>
              </div>
              <div class="form-group hidden">
                <label>LOGO &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['logo_file']; ?>
              </div>
              <div class="form-group">
                <label>Address &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['address']; ?>
              </div>
              <div class="form-group">
                <label>Country, State, City/Town &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['country'] . " " . $my_info['state'] . " " . $my_info['city']; ?>
              </div>
              <div class="form-group hidden">
                <label>Website &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['website']; ?>
              </div>
              <div class="form-group">
                <label>Phone &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['phone']; ?>
              </div>
              <div class="form-group">
                <label>Email &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['email']; ?>
              </div>
              <div class="form-group">
                <label>Identification &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['identification']; ?>
              </div>
              <div class="form-group hidden">
                <label>Faccebook &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['facebook']; ?>
              </div>
              <div class="form-group hidden">
                <label>Instagram &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['instagram']; ?>
              </div>
              <div class="form-group hidden">
                <label>Twitter &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['twitter']; ?>
              </div>
              <div class="form-group">
                <label>Category of Interest to Partner with Fecundhill &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['category']; ?>
              </div>
              <div class="form-group">
                <label>Major Sector/Industry that your business operates in &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['industry']; ?>
              </div>
              <div class="form-group">
                <label>Relevant Certification &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['certification']; ?>
              </div>

          <?php
              }
            }

            ?>

          </div>
        </div>
      </section>
    </div>

  <?php
  } else {
    echo "<h5>Partner Information Not Found!</h5>";
  }
  ?>

  <?php
  $this->load->view("template/footer");
  ?>
  <?php
  $this->load->view("template/footlinks");
  ?>