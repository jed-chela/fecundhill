<div class='col-sm-12'>
  <form class="form" method="POST" style="overflow: hidden;">
    <h4>New Partner Account Request Form</h4>
    <?php
        if (isset($request_partner_form_error)) {
          if ($request_partner_form_error != "") {
            echo $request_partner_form_error;
          }
        }
        ?>
    <?php
      if ($my_info !== false) {
    ?>
      <div class='col-sm-10 mb-sm-10' style="border: 1px solid #DDD;">
        <div class="form-group">
          <label>Business Name</label>
          <input class="form-control no-textupper" type="text" name="business_name" placeholder="Business Name" value="" required />
        </div>
        <div class="form-group">
          <label>Owner Name</label>
          <input class="form-control no-textupper" type="text" name="owner_name" placeholder="Owner Name" value="" required />
        </div>
        <div class="form-group">
          <label>Functional Email Address</label>
          <input class="form-control no-textupper" type="text" name="email" value="" required />
        </div>
        <div class="form-group">
          <label>Functional Phone Number</label>
          <input class="form-control no-textupper" type="text" name="phone" value="" required />
        </div>
        <div class="form-group">
          <label>Business Address</label>
          <textarea name="address" class="form-control no-textupper" value="" required></textarea>
        </div>
        <div class="form-group">
          <label>Country</label>
          <?php $data_nat['selected_value'] = "";
                  $countries_options = $this->load->view("includes/nationality", $data_nat, true); ?>
          <select class="form-control" name="country" required>
            <?php // echo $countries_options; ?>
            <option value="Nigeria">Nigeria</option>
          </select>
        </div>
        <div class="form-group">
          <label>State</label>
          <?php $data_state['selected_value'] = "";
                  $states_options = $this->load->view("includes/states", $data_state, true); ?>
          <select class="form-control" name="state" required>
            <?php echo $states_options; ?>
          </select>
        </div>
        <div class="form-group">
          <label>City/Town</label>
          <input class="form-control no-textupper" type="text" name="city" value="" required />
        </div>
        <div class="form-group">
          <label>Description of the Business Services</label>
          <textarea name="description" class="form-control no-textupper" value="" required></textarea>
        </div>
        <div class="form-group">
          <label>Category of Interest to Partner with Fecundhill</label>
          <select class="form-control" name="category" required>
            <option>Real Estate</option>
          </select>
        </div>
        <div class="form-group">
          <label>Major Sector/Industry that your business operates in</label>
          <select class="form-control" name="industry" required>
            <option value="">-- Select One --</option>
            <option>Other</option>
            <option>Aerospace</option>
            <option>Agriculture</option>
            <option>Arms</option>
            <option>Automotive</option>
            <option>Broadcasting</option>
            <option>Chemical</option>
            <option>Computer</option>
            <option>Construction</option>
            <option>Defense</option>
            <option>Education</option>
            <option>Electrical power</option>
            <option>Electronics</option>
            <option>Energy</option>
            <option>Entertainment</option>
            <option>Film</option>
            <option>Financial services</option>
            <option>Fishing</option>
            <option>Food</option>
            <option>Health care</option>
            <option>Hospitality</option>
            <option>Information</option>
            <option>Insurance</option>
            <option>Internet</option>
            <option>Mass media</option>
            <option>Mining</option>
            <option>Music</option>
            <option>News Media</option>
            <option>Petroleum</option>
            <option>Pharmaceutical</option>
            <option>Publishing</option>
            <option>Pulp and paper</option>
            <option>Shipbuilding</option>
            <option>Software</option>
            <option>Steel</option>
            <option>Telecommunications</option>
            <option>Textile</option>
            <option>Timber</option>
            <option>Tobacco</option>
            <option>Transport</option>
            <option>Water</option>
          </select>
        </div>

        <div class="form-group">
          <label>Select your means of Identification &nbsp; &nbsp; &nbsp; </label>
          National ID Card: <input class="" id="identificationnid" type="radio" name="identification" value="National ID Card" />
          &nbsp; National Driver's License: <input class="" id="identificationndl" type="radio" name="identification" value="National Drivers License" />
          &nbsp; International Passport: <input class="" id="identificationip" type="radio" name="identification" value="International Passport" />
          &nbsp; Staff ID Card: <input class="" id="identificationsid" type="radio" name="identification" value="Staff ID Card" />
          &nbsp; Other: <input class="" id="identificationoth" type="radio" name="identification" value="Other" />
        </div>

        <div class="form-group">
          <label>Mention Your Relevant Certification if Any</label>
          <textarea name="certification" class="form-control no-textupper" value="" maxlength="500" required></textarea>
        </div>

        <div class="form-group">
          <label>Do you have a Lockup shop?</label>
          <select class="form-control" name="lockup_shop" required>
            <option>No</option>
            <option>Yes</option>
          </select>
        </div>

        <div class="form-group">
          <label>Which bank account type do you operate for your business?</label>
          <select class="form-control" name="bank_account_type" required>
            <option value="">--Select One--</option>
            <option>Current Account</option>
            <option>Savings Account</option>
            <option>Corporate Account</option>
          </select>
        </div>

        <div class="form-group">
          <label>Do you have a functional bank cheque book for the account?</label>
          <select class="form-control" name="cheque_book" required>
            <option value="">--Select One--</option>
            <option>Yes</option>
            <option>No</option>
          </select>
        </div>

        <div class="form-group">
          <input class="" id="partner_confirm" type="checkbox" name="partner_confirm" value="" required />
          <label for="partner_confirm">I have cross-checked and ensured that the values entered above are accurate and reliable! </label>
        </div>
        <div class="form-group">
          <button class="btn btn-round btn-b" type="submit" name='request_partner_but' value="Send Request">Send Request</button>
        </div>
      </div>
    <?php
        } else {
          echo "<p class='text-danger'> Edit/Update your profile information such as <b>Surname</b> and <b>First Name</b> and <b>Phone Number (1)</b> to access this feature.</p>";
        }
        ?>
  </form>
  <hr />
</div>