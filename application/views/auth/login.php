<?php
$this->load->view("template/headlinks");
?>
<?php
$this->load->view("template/nav");
?>
<?php
$this->load->view("template/slider_empty");
?>

<div class="main">
  <section class="module-small bg-dark-60" data-background="<?php echo base_url(); ?>assets/images/items/business.jpg">

  </section>
  <section class="module module-padding-top-off">
    <div class="container">
      <div class="row">
        <div class="col-sm-5 col-sm-offset-1 mb-sm-40">
          <h4 class="font-alt">Login</h4>
          <hr class="divider-w mb-10">
          <?php
          if (isset($login_error)) {
            if ($login_error != "") {
              echo $login_error;
            }
          }
          $login_used_email = "";
          if (isset($log_used_email)) {
            if ($log_used_email != "") {
              $login_used_email = $log_used_email;
            }
          }

          $regis_used_email         = "";
          $regis_used_firstname     = "";
          $regis_used_surname       = "";
          $regis_used_phone         = "";
          $regis_used_gender        = "";
          $regis_used_lga_location  = "";
          $regis_used_town          = "";
          
          if (isset($reg_used_email)) {
            if ($reg_used_email != "") {
              $regis_used_email         = $reg_used_email;
              $regis_used_firstname     = $reg_used_firstname;
              $regis_used_surname       = $reg_used_surname;
              $regis_used_phone         = $reg_used_phone;
              $regis_used_gender        = $reg_used_gender;
              $regis_used_lga_location  = $reg_used_lga_location;
              $regis_used_town          = $reg_used_town;
            }
          }

          ?>
          <form class="form" method="POST">
            <div class="form-group">
              <input class="form-control no-textupper" id="email" type="text" name="email" placeholder="Email" value="<?= $login_used_email; ?>" />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="password" type="password" name="password" placeholder="Password" />
            </div>
            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='login_but' value="Login">Login</button>
            </div>
            <div class="form-group"><a href="<?php echo base_url(); ?>auth/forgot">Forgot Password?</a></div>
          </form>
        </div>
        <div class="col-sm-5">
          <h4 class="font-alt">Register</h4>
          <hr class="divider-w mb-10">
          <?php
          if (isset($reg_error)) {
            if ($reg_error != "") {
              echo $reg_error;
            }
          }
          ?>
          <form class="form" method="POST" id="register">
            <div class="form-group">
              <input class="form-control no-textupper" id="firstname" type="text" name="firstname" value="<?= $regis_used_firstname; ?>" placeholder="Firstname" required />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="surname" type="text" name="surname" value="<?= $regis_used_surname; ?>" placeholder="Surname" required />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="reg_email" type="text" name="reg_email" value="<?= $regis_used_email; ?>" placeholder="Email" required>
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="password" type="password" name="reg_password" placeholder="Password" minlength="6" required />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="re-password" type="password" name="reg_password2" placeholder="Re-enter Password" required />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="phone" type="text" name="phone" value="<?= $regis_used_phone; ?>" placeholder="Phone Number (WhatsApp/call preferred)" required />
            </div>
            <div class="form-group">
              <label>Date of Birth (dd/mm/yyyy)</label>
              <input class="form-control no-textupper" id="date_of_birth" type="date" name="date_of_birth" placeholder="Date of Birth (dd-mm-yyyy)" value="" min="1900-01-01" max="2050-12-31" required />
            </div>
            <div class="form-group">
              <select class="form-control" id="gender" name="gender" required>
                <option value="">-- Gender --</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control" id="marital_status" name="marital_status" required>
                <option value="">-- Marital Status --</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
              </select>
            </div>
            <div class="form-group">
              
              <?php
                $data_nat['selected_value'] = "";
                $states_opts = $this->load->view("includes/states", $data_nat, true);
              ?>
              <select class="form-control" id="state_location" name="state_location" required>
                <option value="">-- Where do you live? --</option>
                <?php
                  if($states_opts !== false)
                  echo $states_opts;
                ?>
              </select>
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="lga_location" type="text" name="lga_location" value="<?= $regis_used_lga_location; ?>" placeholder="L.G.A of residence" required />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="town" type="text" name="town" value="<?= $regis_used_town; ?>" placeholder="Town" required />
            </div>
            <div class="form-group">
              <button class="btn btn-block btn-round btn-b" type="submit" name='register_but' value="Register">Register</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>


  <?php
  $this->load->view("template/footer");
  ?>
  <?php
  $this->load->view("template/footlinks");
  ?>