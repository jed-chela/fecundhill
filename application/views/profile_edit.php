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
if ($my_info === false) {
  
  $this->Personal->createMyPersonalInfo();
  $my_info = $this->Personal->myPersonalInfo();
}

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
          <h4 class="font-alt">EDIT PROFILE</h4>
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
          echo "<p>Profile editing has been disabled for your account. 
            Contact the website admin to make updates to your profile.</p>";
        } else {
          // Profile Enabled for Editing by User
          ?>

          <form class="form" method="POST">
            <br />
            <hr />
            <h4>Personal Info</h4>
            <div class="form-group">
              <input class="form-control no-textupper" id="surname" type="text" name="surname" placeholder="Surname" value="<?php echo $my_info['surname']; ?>" />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="firstname" type="text" name="firstname" placeholder="First Name" value="<?php echo $my_info['firstname']; ?>" />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="othername" type="text" name="othername" placeholder="Other Names" value="<?php echo $my_info['othername']; ?>" />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="title" type="text" name="title" placeholder="Title" value="<?php echo $my_info['title']; ?>" />
            </div>
            <div class="form-group mark">
              <label>MARITAL STATUS &nbsp; &nbsp; &nbsp; </label>
              <?php
                $sel1ms = "";
                $sel2ms = "";
                if ($my_info['marital_status'] != "")
                  $my_info['marital_status'] == "single" ? $sel1ms = "checked" : $sel2ms = "checked";

                ?>
              SINGLE: <input class="" id="marital_statuss" type="radio" name="marital_status" <?php echo $sel1ms; ?> value="single" required />
              &nbsp; MARRIED: <input class="" id="marital_statusm" type="radio" name="marital_status" <?php echo $sel2ms; ?> value="married" required />
            </div>
            <div class="form-group mark">
              <label>GENDER &nbsp; &nbsp; &nbsp; </label>
              <?php
                $sel1ge = "";
                $sel2ge = "";
                if ($my_info['gender'] != "")
                  $my_info['gender'] == "m" ? $sel1ge = "checked" : $sel2ge = "checked";
                ?>
              MALE: <input class="" id="genderm" type="radio" name="gender" <?php echo $sel1ge; ?> value="m" required />
              &nbsp; FEMALE: <input class="" id="genderf" type="radio" name="gender" value="f" required />
            </div>

            <div class="form-group">
              <label>DATE OF BIRTH &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="date_of_birth" type="date" name="date_of_birth" value="<?php echo $my_info['date_of_birth']; ?>" />
              <!--
            <input class="" id="dob_day" type="number" min=1 max=31 name="dob_day" placeholder=" DAY, e.g. 2" />
            <input class="" id="dob_month" type="number" min=1 name="dob_month" placeholder=" MONTH, e.g. 4" />
            <input class="" id="dob_year" type="number" min=1900 max="<?php echo date('Y'); ?>" name="dob_year" placeholder=" YEAR, e.g. 1980" /> -->
            </div>

            <div class="form-group hidden">
              <label>PLACE OF BIRTH &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="place_of_birth" type="text" name="place_of_birth" placeholder="Place of Birth e.g. Lagos, Nigeria" value="<?php echo $my_info['place_of_birth']; ?>" />
            </div>

            <div class="form-group hidden">
              <label>NO OF CHILDREN &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="children" type="text" name="children" placeholder="" value="<?php echo $my_info['children']; ?>" />
            </div>

            <div class="form-group">
              <input class="form-control no-textupper" id="mother_maiden" type="text" name="mother_maiden" placeholder="Mother's Maiden Name" value="<?php echo $my_info['mother_maiden']; ?>" />
            </div>

            <div class="form-group mark">
              <label>NATIONALITY: </label>
              <?php
                  $data_nat['selected_value'] = $my_info["nationality"];
                  $data_nat_opts = $this->load->view("includes/nationality", $data_nat, true);
              ?>
              <select class="form-control" id="nationality" name="nationality" required>
                <?php
                 echo $data_nat_opts; 
                ?>
              </select>
            </div>

            <div class="form-group">
              <input class="form-control no-textupper" id="residency_no" type="text" name="residency_no" placeholder="Resident Permit Number" value="<?php echo $my_info['residency_no']; ?>" />
            </div>

            <div class="form-group mark">
              <label>STATE OF ORIGIN: </label>
              <?php
                  $data_state['selected_value'] = $my_info["state_origin"];
                  $data_state_opts = $this->load->view("includes/states", $data_state, true);
              ?>
              <select class="form-control" id="state_origin" name="state_origin" required>
                <?php
                  echo $data_state_opts;
                ?>
              </select>
            </div>

            <div class="form-group mark">
              <input class="form-control no-textupper" id="lga_origin" type="text" name="lga_origin" placeholder="LOCAL GOVERNMENT AREA OF ORIGIN" value="<?php echo $my_info['lga_origin']; ?>" required />
            </div>

            <div class="form-group">
              <input class="form-control no-textupper" id="tax_identification_no" type="text" name="tax_identification_no" placeholder="TAX IDENTIFICATION NUMBER" value="<?php echo $my_info['tax_identification_no']; ?>" />
            </div>

            <div class="form-group hidden">
              <label>RELIGION (Optional): </label>
              <select class="form-control" id="religion" name="religion">
                <?php

                  $religion_arr = array(
                    "Did Not Specify", "Christianity", "Islam", "African Traditional",
                    "Budhism", "Hinduism", "Taoism", "Other",
                  );
                  $selected_value = $my_info["religion"];
                  for ($i = 0; $i < count($religion_arr); $i++) {
                    echo "<option value='" . $religion_arr[$i] . "'";
                    if ($selected_value == $religion_arr[$i]) {
                      echo " selected ";
                    }
                    echo ">" . $religion_arr[$i] . "</option>";
                  }

                  ?>
              </select>
            </div>

            <div class="form-group hidden">
              <label>BLOOD GROUP: </label>
              <input class="form-control no-textupper" id="blood_group" type="text" name="blood_group" placeholder="Blood Group" value="<?php echo $my_info['blood_group']; ?>" />
            </div>

            <div class="form-group">
              <label>DO YOU HAVE DUAL CITIZENSHIP? &nbsp; &nbsp; &nbsp; </label>
              <?php
                $sel1du = "";
                $sel2du = "";
                if ($my_info['dual_citizenship'] != ""){
                  $my_info['dual_citizenship'] == "No" ? $sel1du = "checked" : $sel2du = "checked";
                }else{
                  $sel2du = "checked";
                }
                ?>
              YES: <input class="" id="dual_citizenshipn" type="radio" name="dual_citizenship" <?php echo $sel1du; ?> value="No" />
              &nbsp; NO: <input class="" id="dual_citizenshipy" type="radio" name="dual_citizenship" <?php echo $sel2du; ?> value="Yes" />
            </div>

            <div class="form-group">
              <input class="form-control no-textupper" id="dual_citizen_country" type="text" name="dual_citizen_country" placeholder="DUAL CITIZENSHIP COUNTRIES" value="<?php echo $my_info['dual_citizen_country']; ?>" />
            </div>

            <div class="form-group">
              <label>If available, Please provide your social security number &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="social_security_no" type="text" name="social_security_no" placeholder="Social Security Number" value="<?php echo $my_info['social_security_no']; ?>" />
            </div>

            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='edit_profile_but' value="Save Changes">Save Changes</button>
            </div>


            <br />
            <hr />
            <h4>Contact Details</h4>
            <div class="form-group mark">
              <label>Full Residential Address </label>
              <textarea class="form-control no-textupper" id="residential_address" type="text" name="residential_address" placeholder="Full Residential Address" required><?php echo $my_info['residential_address']; ?></textarea>
            </div>
            <div class="form-group">
              <label>House Number & Street Name </label>
              <input class="form-control no-textupper" id="residential_street" type="text" name="residential_street" placeholder="House Number & Street Name" value="<?php echo $my_info['residential_street']; ?>" />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="residential_landmark" type="text" name="residential_landmark" placeholder="Nearest Bus Stop/ Landmarks" value="<?php echo $my_info['residential_landmark']; ?>" />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="residential_city" type="text" name="residential_city" placeholder="Town/City" value="<?php echo $my_info['residential_city']; ?>" />
            </div>
            <div class="form-group">
              <label>State of Residence: </label>
              <?php
                  $data_stater['selected_value'] = $my_info["residential_state"];
                  $data_stater_opts = $this->load->view("includes/states", $data_stater, true);
              ?>
              <select class="form-control" id="residential_state" name="residential_state">
                <?php
                  echo $data_stater_opts;
                ?>
              </select>
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="residential_lga" type="text" name="residential_lga" placeholder="Local Govt. Area of Residence" value="<?php echo $my_info['residential_lga']; ?>" />
            </div>
            <div class="form-group">
              <textarea class="form-control no-textupper" id="mailing_address" type="text" name="mailing_address" placeholder="Mailing/Shipping/Delivery Address"><?php echo $my_info['mailing_address']; ?></textarea>
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="phone" type="text" name="phone" placeholder="Phone Number (1)" value="<?php echo $my_info['phone']; ?>" />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="phone2" type="text" name="phone2" placeholder="Phone Number (2)" value="<?php echo $my_info['phone2']; ?>" />
            </div>
            <div class="form-group">
              <input class="form-control no-textupper" id="email" type="text" name="email" placeholder="Email Adddress" value="<?php echo $my_info['email']; ?>" />
            </div>
            <div class="form-group mark">
              <textarea class="form-control no-textupper" id="permanent_address" type="text" name="permanent_address" placeholder="Permanent Address" required><?php echo $my_info['permanent_address']; ?></textarea>
            </div>

            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='edit_profile_but' value="Save Changes">Save Changes</button>
            </div>

            <br />
            <hr />
            <h4>Means of Identification</h4>
            <div class="form-group">
              <label>Select your means of Identification &nbsp; &nbsp; &nbsp; </label>
              <?php
                $sel1id = "";
                $sel2id = "";
                $sel3id = "";
                $sel4id = "";
                switch ($my_info['identification']) {
                  case "National ID Card":
                    $sel1id = "checked";
                    break;
                  case "National Drivers License":
                    $sel2id = "checked";
                    break;
                  case "International Passport":
                    $sel3id = "checked";
                    break;
                  case "Staff ID Card":
                    $sel4id = "checked";
                    break;
                }
                ?>
                National ID Card: <input class="" id="identificationnid" type="radio" name="identification" <?php echo $sel1id; ?> value="National ID Card" required />
                &nbsp; National Driver's License: <input class="" id="identificationndl" type="radio" name="identification" <?php echo $sel2id; ?> value="National Drivers License" required />
                &nbsp; International Passport: <input class="" id="identificationip" type="radio" name="identification" <?php echo $sel3id; ?> value="International Passport" required />
                &nbsp; Staff ID Card: <input class="" id="identificationsid" type="radio" name="identification" <?php echo $sel4id; ?> value="Staff ID Card" required />
            </div>

            <div class="form-group">
              <label>ID Number &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="identification_no" type="text" name="identification_no" placeholder="ID Number" value="<?php echo $my_info['identification_no']; ?>" />
            </div>
            <div class="form-group">
              <label>ID Issue Date &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="identification_issue" type="date" name="identification_issue" placeholder="ID Issue Date" value="<?php echo $my_info['identification_issue']; ?>" />
            </div>
            <div class="form-group">
              <label>ID Expiry Date &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="identification_expiry" type="date" name="identification_expiry" placeholder="ID Expiry Date" value="<?php echo $my_info['identification_expiry']; ?>" />
            </div>

            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='edit_profile_but' value="Save Changes">Save Changes</button>
            </div>

            <br />
            <hr />
            <h4>Business/Employment Details</h4>
            <div class="form-group mark">
              <label>What is your employment status? &nbsp; &nbsp; &nbsp; </label>
              <?php
                $sel1em = "";
                $sel2em = "";
                $sel3em = "";
                $sel4em = "";
                $sel5em = "";
                switch ($my_info['employment_status']) {
                  case "Self-Employed":
                    $sel1em = "checked";
                    break;
                  case "Employed":
                    $sel2em = "checked";
                    break;
                  case "Unemployed":
                    $sel3em = "checked";
                    break;
                  case "Retired":
                    $sel4em = "checked";
                    break;
                  case "Student":
                    $sel5em = "checked";
                    break;
                }
                ?>
                Self-Employed: <input class="" id="employment_statusse" type="radio" name="employment_status" <?php echo $sel1em; ?> value="Self-Employed" required />
                &nbsp; Employed: <input class="" id="employment_statuse" type="radio" name="employment_status" <?php echo $sel2em; ?> value="Employed" required />
                &nbsp; Unemployed: <input class="" id="employment_statusu" type="radio" name="employment_status" <?php echo $sel3em; ?> value="Unemployed" required />
                &nbsp; Retired: <input class="" id="employment_statusr" type="radio" name="employment_status" <?php echo $sel4em; ?> value="Retired" required />
                &nbsp; Student: <input class="" id="employment_statusst" type="radio" name="employment_status" <?php echo $sel5em; ?> value="Student" required />
            </div>

            <div class="form-group mark">
              <label>Business Name/Place of Employment &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="employer_name" type="text" name="employer_name" placeholder="Employer's Name/Place of Employment" value="<?php echo $my_info['employer_name']; ?>" required />
            </div>
            <div class="form-group mark">
              <label>Start Date &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="employment_date" type="date" name="employment_date" value="<?php echo $my_info['employment_date']; ?>" required />
            </div>
            <div class="form-group mark">
              <label>Office/Work Address &nbsp; &nbsp; &nbsp; </label>
              <textarea class="form-control no-textupper" id="employer_address" type="date" name="employer_address" placeholder="Office/Work Address" required><?php echo $my_info['employer_address']; ?></textarea>
            </div>
            <div class="form-group mark">
              <label>Office/Work Nearest Bus Stop/Landmarks &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="employer_landmark" type="text" name="employer_landmark" placeholder="Office/Work Nearest Bus Stop/Landmarks " value="<?php echo $my_info['employer_landmark']; ?>" required />
            </div>
            <div class="form-group mark">
              <label>Office/Work City/Town &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="employer_city" type="text" name="employer_city" placeholder="Office/Work City/Town " value="<?php echo $my_info['employer_city']; ?>" required />
            </div>
            <div class="form-group mark">
              <label>Office/Work State </label>
              <?php
                $data_statew['selected_value'] = $my_info["employer_state"];
                $data_statew_opts = $this->load->view("includes/states", $data_statew, true);
              ?>
              <select class="form-control" id="employer_state" name="employer_state" required>
                <?php
                  echo $data_statew_opts;
                ?>
              </select>
            </div>
            <div class="form-group mark hidden">
              <label>Office/Work Local Govt. Area </label>
              <input class="form-control no-textupper" id="employer_lga" type="text" name="employer_lga" placeholder="Office/Work Local Govt. Area" value="<?php echo $my_info['employer_lga']; ?>" />
            </div>
            <div class="form-group mark">
              <label>Office/Work Designation (Rank) </label>
              <input class="form-control no-textupper" id="employer_rank" type="text" name="employer_rank" placeholder="Office/Work Designation (Rank)" value="<?php echo $my_info['employer_rank']; ?>" />
            </div>
            <div class="form-group mark">
              <label>Office/Work Business Services/Product Lines </label>
              <input class="form-control no-textupper" id="employer_business" type="text" name="employer_business" placeholder="Services/Product Lines" value="<?php echo $my_info['employer_business']; ?>" required />
            </div>
            <div class="form-group mark">
              <label>Pension Fund Administrator (Optional) </label>
              <input class="form-control no-textupper" id="employer_phone" type="text" name="employer_phone" placeholder="Pension Fund Administrator " value="<?php echo $my_info['employer_phone']; ?>" />
            </div>
            <div class="form-group">
              <label>Employee ID Number </label>
              <input class="form-control no-textupper" id="employee_id_no" type="text" name="employee_id_no" placeholder="Employee ID Number " value="<?php echo $my_info['employee_id_no']; ?>" />
            </div>

            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='edit_profile_but' value="Save Changes">Save Changes</button>
            </div>

            <br />
            <hr />
            <h4>Next-Of-Kin Details</h4>
            <div class="form-group">
              <label>Surname </label>
              <input class="form-control no-textupper" id="nok_surname" type="text" name="nok_surname" placeholder="Surname" value="<?php echo $my_info['nok_surname']; ?>" />
            </div>
            <div class="form-group">
              <label>First Name </label>
              <input class="form-control no-textupper" id="nok_firstname" type="text" name="nok_firstname" placeholder="First Name" value="<?php echo $my_info['nok_firstname']; ?>" />
            </div>
            <div class="form-group">
              <label>Other Names </label>
              <input class="form-control no-textupper" id="nok_othernames" type="text" name="nok_othernames" placeholder="Other Names" value="<?php echo $my_info['nok_othernames']; ?>" />
            </div>
            <div class="form-group">
              <label>Date of Birth </label>
              <input class="form-control no-textupper" id="nok_birthdate" type="date" name="nok_birthdate" value="<?php echo $my_info['nok_birthdate']; ?>" />
            </div>
            <div class="form-group">
              <label>GENDER &nbsp; &nbsp; &nbsp; </label>
              <?php
                $sel1no = "";
                $sel2no = "";
                if ($my_info['nok_gender'] != ""){
                  $my_info['nok_gender'] == "m" ? $sel1no = "checked" : $sel2no = "checked";
                }else{
                  $sel1no = "checked";
                }
                ?>
              MALE: <input class="" id="nok_genderm" type="radio" name="nok_gender" <?php echo $sel1no; ?> value="m" />
              &nbsp; FEMALE: <input class="" id="nok_genderf" type="radio" name="nok_gender" <?php echo $sel2no; ?> value="f" />
            </div>
            <div class="form-group">
              <label>Title </label>
              <input class="form-control no-textupper" id="nok_title" type="text" name="nok_title" placeholder="Next-Of-Kin Title" value="<?php echo $my_info['nok_title']; ?>" />
            </div>
            <div class="form-group">
              <label>Relationship </label>
              <input class="form-control no-textupper" id="nok_relationship" type="text" name="nok_relationship" placeholder="Next-Of-Kin Relationship" value="<?php echo $my_info['nok_relationship']; ?>" />
            </div>
            <div class="form-group">
              <label>Email Address </label>
              <input class="form-control no-textupper" id="nok_email" type="text" name="nok_email" placeholder="Next-Of-Kin Email Address" value="<?php echo $my_info['nok_email']; ?>" />
            </div>
            <div class="form-group">
              <label>Phone Number </label>
              <input class="form-control no-textupper" id="nok_phone" type="text" name="nok_phone" placeholder="Next-Of-Kin Phone Number" value="<?php echo $my_info['nok_phone']; ?>" />
            </div>
            <div class="form-group">
              <label>Phone Number 2 </label>
              <input class="form-control no-textupper" id="nok_phone2" type="text" name="nok_phone2" placeholder="Next-Of-Kin Phone Number 2" value="<?php echo $my_info['nok_phone2']; ?>" />
            </div>
            <div class="form-group">
              <label>Next-Of-Kin Address &nbsp; &nbsp; &nbsp; </label>
              <textarea class="form-control no-textupper" id="nok_address" type="date" name="nok_address" placeholder="Next-Of-Kin Address"><?php echo $my_info['nok_address']; ?></textarea>
            </div>
            <div class="form-group">
              <label>House Number & Street Name &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="nok_street" type="text" name="nok_street" placeholder="Next-Of-Kin House Number & Street Name" value="<?php echo $my_info['nok_street']; ?>" />
            </div>
            <div class="form-group">
              <label>Nearest Bus Stop/Landmarks &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="nok_landmark" type="text" name="nok_landmark" placeholder="Next-Of-Kin Nearest Bus Stop/Landmarks " value="<?php echo $my_info['nok_landmark']; ?>" />
            </div>
            <div class="form-group">
              <label>City/Town &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="nok_city" type="text" name="nok_city" placeholder="Next-Of-Kin City/Town" value="<?php echo $my_info['nok_city']; ?>" />
            </div>
            <div class="form-group">
              <label>Next-Of-Kin State </label>
              <?php
                  $data_statek['selected_value'] = $my_info["nok_state"];
                  $data_statek_opts = $this->load->view("includes/states", $data_statek, true);
              ?>
              <select class="form-control" id="nok_state" name="nok_state">
                <?php
                  echo $data_statek_opts;
                ?>
              </select>
            </div>
            <div class="form-group">
              <label>Local Govt. Area &nbsp; &nbsp; &nbsp; </label>
              <input class="form-control no-textupper" id="nok_lga" type="text" name="nok_lga" placeholder="Next-Of-Kin Local Govt. Area" value="<?php echo $my_info['nok_lga']; ?>" />
            </div>


            <div class="form-group">
              <button class="btn btn-round btn-b" type="submit" name='edit_profile_but' value="Save Changes">Save Changes</button>
            </div>

          </form>

        <?php
          // Profile Enabled for Editing by User
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