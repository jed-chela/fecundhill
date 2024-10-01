<?php
  // Show New Loan Request Form

  /**
   * 
   * Number of children 
   * 
   * Lockup shop (yes or no) ｛business only｝
   * Operational bank account Type (savings, current or corporate)
   * functional bank cheque book (yes or no)
   * 
   * Extra Needed details on request for services { for loans and hire purchase partner's only}
   * Current salary income / weekly business turnover 
   * Currently servicing other loan (yes or no)
   * Referee 
   * Amount requested 
   * Purpose of loan {for loan request only}
   * 
   */
  ?>
<div class='col-sm-12'>
  <form class="form" method="POST" style="overflow: hidden;">
    <h4><b>New Loan Request Form</b></h4>
    <div class="col-sm-12">
    <?php
      if (isset($request_loan_form_error)) {
        if ($request_loan_form_error != "") {
          echo $request_loan_form_error;
        }
      }
      ?>
    </div>
    <?php
      if ($my_info !== false) {
        ?>
      <div class='col-sm-10 mb-sm-10' style="border: 1px solid #DDD;">
        <div class="form-group">
          <label>My Name</label>
          <span><?php echo $my_info['firstname'] . " " . $my_info['surname'] . " " . $my_info['othername'] ?></span>
        </div>
        <div class="form-group">
          <label>Amount</label>
          <input class="form-control" id="loan_amount" type="number" name="loan_amount" placeholder="Loan Amount" value="" required />
        </div>
        <div class="form-group">
          <label>Duration (months)</label>
          <input class="form-control" id="loan_duration" type="number" name="loan_duration" placeholder="e.g. 6" value="" required />
        </div>


        <?php /*
          <div class="form-group">
            <label>No of Children</label>
            <input class="form-control" type="number" name="children" placeholder="No of Children" value="" required />
          </div>

        <div class="form-group">
          <label>Which bank account type do you operate?</label>
          <select class="form-control" name="bank_account" required>
            <option value="">--Select One--</option>
            <option>Current Account</option>
            <option>Savings Account</option>
            <option>Corporate Account</option>
          </select>
        </div>

        
        <div class="form-group">
          <label>Employed or Self-employed?</label>
          <select class="form-control" name="employment" required>
            <option value="">--Select One--</option>
            <option>Employed</option>
            <option>Self-employed</option>
            <option>Unemployed</option>
          </select>
        </div>
*/ ?>
        <div class="form-group">
          <label>Loan type</label>
          <select class="form-control" name="employment" required>
            <option value="">--Select One--</option>
            <option>Business-based loan</option>
            <option>Salary-based loan</option>
            <option>Asset-based loan</option>
          </select>
        </div>

        <div class="form-group">
          <label>Do you have a valid personal bank account cheque book?</label>
          <select class="form-control" name="cheque_book" required>
            <option value="">--Select One--</option>
            <option>Yes</option>
            <option>No</option>
          </select>
        </div>

        <div class="form-group">
          <label>Bank Name</label>
          <input class="form-control" type="text" name="bank_name" maxlength="255" placeholder="" value="" required />
        </div>
        <div class="form-group">
          <label>Account Name</label>
          <input class="form-control" type="text" name="account_name" maxlength="255" placeholder="" value="" required />
        </div>
        <div class="form-group">
          <label>Bank Account Number</label>
          <input class="form-control" type="number" name="account_number" maxlength="20" placeholder="" value="" required />
        </div>

        <div class="form-group">
          <label>Current monthly salary income / Average monthly business turnover</label>
          <input class="form-control" type="number" name="current_income" placeholder="" value="" required />
        </div>

        <div class="form-group">
          <label>Are you currently servicing any other loan, possibly from a bank or other company?</label>
          <select class="form-control" name="other_loan" required>
            <option>No</option>
            <option>Yes</option>
          </select>
        </div>

        <div class="form-group">
          <label>Select a Deposit Frequency for your repayment</label>
          <select class="form-control" name="deposit_frequency" required>
            <option>Daily</option>
            <option>Weekly</option>
            <option>Monthly</option>
          </select>
        </div>

        <div class="form-group">
          <label>Payment Amount</label>
          <input class="form-control" type="text" name="payment_amount" placeholder="" value="" required />
        </div>

        <div class="form-group">
          <label>Specific Day / Date (e.g. Monday or 29th)</label>
          <input class="form-control" type="text" name="specific_day" placeholder="" value="" required />
        </div>
<?php /*
        <div class="form-group">
          <label>Purpose of Loan (e.g. Business, Medical, School Fees)</label>
          <input class="form-control" type="text" name="purpose" placeholder="" value="" required />
        </div>
*/ ?>
        <div class="form-group">
          <label>Mention your asset / inventory</label>
          <textarea class="form-control autosize" name="collateral" maxlength="999" required></textarea>
        </div>

        <div class="form-group">
          <label>Location of asset / inventory</label>
          <input class="form-control" type="text" name="asset_location" maxlength="499" placeholder="" value="" required />
        </div>

        <div class="form-group mb-10">
          <label for="referral_code">Referral Code (Optional)</label>
          <input class="form-control" type="text" name="referral_code" id="referral_code" style="text-transform: none;" >
        </div>
<?php /*
        <p style="text-align: center;"><span style="font-size: 14px;"><strong>LOAN TERMS AND CONDITTIONS</strong></span></p>
        
<p>Any communication by the borrower or guarantor regarding the loan facility shall be made directly to the lender by contacting the account officer via 08032726534 or e-mail to info@fecundhill.com</p>
<p>The Lender, with the consent of the Borrower and guarantor, reserves the right to vary the terms and conditions  of this Loan Agreement (Loan restructuring).</p>
<p>The Borrower and guarantor further warrants that the acceptance of this facility will not be, or result in a breach of any provisions of any other agreement to which the Borrower or guarantor is a party.</p>
<p>Borrower and guarantor warrants to inform the Lender of any change to his/her personal information including  place of work, business, phone number and address(s)</p>

<p>Default in Terms and conditions shall cause all outstanding amounts under this facility to  immediately become due and payable.</p>

<p>If any sum due and payable is not paid on the due date, including without limitation any moneys claimed under this Paragraph, interest shall be paid (both after as well as before any judgement) on such unpaid sum at such rate or rates as FECUNDHILL INT’L SERVICES LIMITED may from time to time stipulate from the date payment is due up to the date of payment.</p>
<p>The Lender reserves the right to publish the case of default, right to refer the case of default to Credit Bureau, regulatory or law enforcement agencies or any such body or entity it may deem fit for the purpose of recovering  debts owed.</p>
<p>Any civil dispute arising out of or in connection with this agreement which cannot be resolved by good faith, negotiations among the parties, including questions regarding the existence, validity or termination of this agreement, shall be settled via Mediation in English Language, at Delta State Multi-Door Court in Asaba, and the parties agree to be bound by the decision of the Court.</p>

<p>I assent that the lender is authorized to take any action deemed fit against me including right to deduct my salaries and money, seize and sell goods, property and services in my possession (both the ones listed and not listed herein) as part of payment to recover all debt and associated cost of debt recovery if I default the terms and conditions for the loan.</p>
<p>I would keep a bank account active and sufficiently funded from which I would also make payments for debts using cheques.</p>
<p>All payments and obligations would be made directly to the creditor</p>


        <div class="form-group">
          <input class="" id="loan_confirm" type="checkbox" name="loan_confirm" placeholder="Loan Confirm" value="" required />
          <label for="loan_confirm">I have cross-checked and ensured that the values entered above are accurate and reliable! </label>
        </div>    */ ?>
        <div class="form-group">
          <button class="btn btn-round btn-b" type="submit" name='request_loan_but' value="Send Request">Send Request</button>
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
