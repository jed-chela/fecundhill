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

$personal_info = $this->Personal->personalInfo($profile_id);
if ($personal_info !== false) {


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
              <h4 class="font-alt">Contact Information</h4>
              <hr class="divider-w mb-10">
            </div>

            <?php
                if (isset($form_error)) {
                  if ($form_error != "") {
                    echo $form_error;
                  }
                }
                ?>

              <br />
              <hr />
              <h4>Personal Info</h4>
              <div class="form-group">
                <label>Personal Name &nbsp; &nbsp; &nbsp; </label><?php echo $personal_info['title'] . " <b>" . $personal_info['surname'] . 
                "</b> " . $personal_info['firstname'] . " ". $personal_info['othername'] ; ?>
              </div>
              <div class="form-group">
                <label>Personal Email &nbsp; &nbsp; &nbsp; </label><?php echo $personal_info['email']; ?>
              </div>
              <div class="form-group">
                <label>Personal Phone &nbsp; &nbsp; &nbsp; </label><?php echo $personal_info['phone']; ?>
              </div>

              <?php
                $my_info = $this->Partner->getAccount($personal_info["user_id"]);
                if ($my_info !== false) {

                //  print_r($my_info);
              ?>

              <hr />
              <h4>Partner Account Info</h4>
              <div class="form-group">
                <label>Business Name &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['business_name']; ?>
              </div>
              <div class="form-group">
                <label>Owner Name &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['owner_name']; ?>
              </div>
              <div class="form-group">
                <label>Phone &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['phone']; ?>
              </div>
              <div class="form-group">
                <label>Email &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['email']; ?>
              </div>
              <div class="form-group">
                <label>Description &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['description']; ?>
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
              
              

          <?php
            }

            ?>

          </div>
        </div>
      </section>
    </div>

  <?php
  } else {
    echo "<h5>Profile Information Not Found!</h5>";
  }
  ?>

  <?php
  $this->load->view("template/footer");
  ?>
  <?php
  $this->load->view("template/footlinks");
  ?>