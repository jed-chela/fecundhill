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

$my_info = $this->Personal->personalInfo($profile_id);
if ($my_info !== false) {

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

        <div class="">
          <h4 class="font-alt">PROFILE of <?php echo $this->Personal->userName($profile_id); ?></h4>
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
          $referral_code = $this->Referrals->getReferralCode($my_info['user_id']);
          echo "<h5>Your Referral Code is <b>$referral_code</b></h5>";
        ?>
        <hr />
        <h4>Personal Info</h4>
        <div class="form-group">
          <label>Surname &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['surname']; ?>
        </div>
        <div class="form-group">
          <label>First Name &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['firstname']; ?>
        </div>
        <div class="form-group">
          <label>Other Name(s) &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['othername']; ?>
        </div>
        <div class="form-group">
          <label>Title &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['title']; ?>
        </div>
        <div class="form-group">
          <label>Marital Status &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['marital_status']; ?>
        </div>
        <div class="form-group">
          <label>Gender &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['gender']; ?>
        </div>

        <div class="form-group">
          <label>Date of Birth &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['date_of_birth']; ?>
        </div>

        <div class="form-group">
          <label>Place of Birth &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['place_of_birth']; ?>
        </div>

        <div class="form-group">
          <label>Mother's Maiden Name &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['mother_maiden']; ?>
        </div>

        <div class="form-group">
          <label>Nationality &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nationality']; ?>
        </div>

        <div class="form-group">
          <label>Resident Permit Number &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['residency_no']; ?>
        </div>

        <div class="form-group">
          <label>State of Origin &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['state_origin']; ?>
        </div>

        <div class="form-group">
          <label>Local Government &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['lga_origin']; ?>
        </div>

        <div class="form-group">
          <label>Tax Identification Number &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['tax_identification_no']; ?>
        </div>

        <div class="form-group">
          <label>Religion &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['religion']; ?>
        </div>

        <div class="form-group">
          <?php
            if ($my_info['dual_citizenship'] == "Yes") {
              ?>
          <label>Dual Citizenship &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['dual_citizen_country']; ?>

          <label>Social Security Number &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['social_security_no']; ?>
          <?php
            }
            ?>
        </div>

        <br />
        <hr />
        <h4>Contact Details</h4>
        <div class="form-group">
          <label>Residential Address &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['residential_address']; ?>
        </div>
        <div class="form-group">
          <label>House Number & Street Name &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['residential_street']; ?>
        </div>
        <div class="form-group">
          <label>Nearest Bus Stop/ Landmarks &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['residential_landmark']; ?>
        </div>
        <div class="form-group">
          <label>Town/City &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['residential_city']; ?>
        </div>
        <div class="form-group">
          <label>State of Residence &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['residential_state']; ?>
        </div>
        <div class="form-group">
          <label>LGA of Residence &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['residential_lga']; ?>
        </div>
        <div class="form-group">
          <label>Mailing/Shipping/Delivery Address &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['mailing_address']; ?>
        </div>
        <div class="form-group">
          <label>Phone Number (1) &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['phone']; ?>
        </div>
        <div class="form-group">
          <label>Phone Number (2) &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['phone2']; ?>
        </div>
        <div class="form-group">
          <label>Email Address &nbsp; &nbsp; &nbsp; </label><?php echo $this->Users->getUserEmail($my_info['user_id']); ?>
        </div>
        <div class="form-group">
          <label>Permanent Address &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['permanent_address']; ?>
        </div>


        <br />
        <hr />
        <h4>Means of Identification</h4>
        <div class="form-group">
          <label>Means of Identification &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['identification']; ?>
        </div>

        <div class="form-group">
          <label>ID Number &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['identification_no']; ?>
        </div>
        <div class="form-group">
          <label>ID Issue Date &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['identification_issue']; ?>
        </div>
        <div class="form-group">
          <label>ID Expiry Date &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['identification_expiry']; ?>
        </div>
        
        <br />
        <hr />
        <h4>Business/Employment Details</h4>
        <div class="form-group">
          <label>Employment Status &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employment_status']; ?>
        </div>

        <div class="form-group">
          <label>Employer's Name/Place or Employment &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employer_name']; ?>
        </div>
        <div class="form-group">
          <label>Date of Employment &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employment_date']; ?>
        </div>
        <div class="form-group">
          <label>Office/Work Address &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employer_address']; ?>
        </div>
        <div class="form-group">
          <label>Office/Work Nearest Bus Stop/Landmarks &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employer_landmark']; ?>
        </div>
        <div class="form-group">
          <label>Office/Work City/Town &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employer_city']; ?>
        </div>
        <div class="form-group">
          <label>Office/Work State &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employer_state']; ?>
        </div>
        <div class="form-group">
          <label>Office/Work LGA &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employer_lga']; ?>
        </div>
        <div class="form-group">
          <label>Office/Work Business Services/Product Lines &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employer_business']; ?>
        </div>
        <div class="form-group">
          <label>Office/Work Phone Number &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employer_phone']; ?>
        </div>
        <div class="form-group">
          <label>Employee ID Number &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['employee_id_no']; ?>
        </div>

        <br />
        <hr />
        <h4>Next-Of-Kin Details</h4>
        <div class="form-group">
          <label>Surname &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_surname']; ?>
        </div>
        <div class="form-group">
          <label>First Name &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_firstname']; ?>
        </div>
        <div class="form-group">
          <label>Other Names &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_othernames']; ?>
        </div>
        <div class="form-group">
          <label>Date of Birth &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_birthdate']; ?>
        </div>
        <div class="form-group">
          <label>Gender &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_gender']; ?>
        </div>
        <div class="form-group">
          <label>Title &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_title']; ?>
        </div>
        <div class="form-group">
          <label>Relationship &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_relationship']; ?>
        </div>
        <div class="form-group">
          <label>Email Address &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_email']; ?>
        </div>
        <div class="form-group">
          <label>Phone Number &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_phone']; ?>
        </div>
        <div class="form-group">
          <label>Phone Number 2 &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_phone2']; ?>
        </div>
        <div class="form-group">
          <label>Next-Of-Kin Address &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_address']; ?>
        </div>
        <div class="form-group">
          <label>House Number & Street Name &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_street']; ?>
        </div>
        <div class="form-group">
          <label>Nearest Bus Stop/Landmarks &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_landmark']; ?>
        </div>
        <div class="form-group">
          <label>City/Town &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_city']; ?>
        </div>
        <div class="form-group">
          <label>Next-Of-Kin State &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_state']; ?>
        </div>
        <div class="form-group">
          <label>Local Govt. Area &nbsp; &nbsp; &nbsp; </label><?php echo $my_info['nok_lga']; ?>
        </div>

      </div>
    </div>
  </section>
</div>

<?php
}else{
  echo "<h5>Profile Not Found!</h5>";
}
?>

  <?php
  $this->load->view("template/footer");
  ?>
  <?php
  $this->load->view("template/footlinks");
  ?>