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
          <h4 class="font-alt">NEW SAVINGS ACCOUNT TERMS AND CONDITIONS</h4>
          <hr class="divider-w mb-10">
        </div>
        <?php
        // Check if Account has been verified
        $verify_account_status = $this->Users->getVerifyAccountInfoByID($this->Users->getUserID());

        if ($verify_account_status['status'] == 9) {

          echo "<p>You need to verify your email address to enable your account! An email was sent to " . $verify_account_status['email'] . " inbox when you registered. The email contains the verification link. Check your spam folder also, just in case. </p>";
        } else {
          ?>

          <h5>To FECUNDHILL</h5>
          <h5>I/WE (the Customer) HEREBY REQUEST AND AUTHORISE YOU TO</h5>
          <p>1. Open an account in my/our name and at any time subsequently open further accounts as I/We may direct.</p>
          <p>2. Honour all orders which may be drawn on the said account provided such orders are signed by me/us and to debit such order to the said account whether such account be for the time being in credit or overdrawn or may become overdrawn in consequence of such debit without prejudice to your right to refuse to allow any overdraft or increase of overdraft and in consideration</p>
          <h5>I/We agree</h5>
          <ol type='a'>
            <li> To assume full responsibility for the genuineness, correctness and validity of endorsements appearing on all cheques, orders, bills, notes, negotiable instruments, receipts and/or other documents deposited in my/our account.</li>
            <li> To be responsible for the repayment of any overdraft with interest and to comply and be bound by your rules for the conduct of a Savings Account receipt of which I/We hereby acknowledge.</li>
            <li> To free FECUNDHILL from any responsibility for any loss or damage to funds deposited with FECUNDHILL due to any future government order, law, levy, tax, embargo and/or all other causes beyond FECUNDHILL's control.</li>
            <li> That all funds standing to my/our credit are payable on demand only in such local currency as may be in circulation.</li>
            <li> To be bound by any notification of change in conditions governing the account directed to my/our last known address and any notice or letter sent to my/our last known email address shall be considered as duly delievered and received by me/us at the time it will be delivered in the ordinary course of an email.</li>
            <li> I/We note that FECUNDHILL will accept no liability whatsoever for funds handed to members of staff outside of FECUNDHILL premises or paid into an account different from FECUNDHILL official Bank Account(s).</li>
            <li> That any disagreements with entries on my/our Account Statements will be made by me/us within 15 days of the dispatch of the Account Statement. Failing receipt by Fecundhill of a notice of disagreement of entries within 15 days from the date of dispatch of my/our Account Statement as rendered is correct.</li>
            <li> The Customer hereby agrees that the Customer shall, at his/its own expense, indemnify, defend and hold harmless FECUNDHILL from and against any and all liability any other loss that may occur, arising from or relating to the operation or use of the Account or the Services or breach, non-performance or inadequate performance by the Customer of any of these Terms or the acts, errors, representations, misrepresentations, misconduct or negligence of the Customer in performance of its obligations.</li>
            <li> Under no circumstances shall FECUNDHILL be liable to the Customer for any indirect, incidental, consequential, special or exemplary damages in connection with the Account or the Services.</li>
            <li> FECUNDHILL shall not be liable for any failure to perform any obligation contained in these Terms or for any loss or damage whatsoever suffered or incurred by the Customer howsoever caused and whether such loss or damage is attributable (directly or indirectly) to any dispute or any other matter or circumstances whatsoever.</li>
            <li> The Customer shall always keep FECUNDHILL indemnified against, and save FECUNDHILL harmless from all actions, proceedings, claims, losses, damages, costs, interest (both before and after judgement) and expenses (including legal costs on a solicitor and client basis) which may be brought against or suffered or incurred by FECUNDHILL in resolving any dispute relating to the Customer's Account with FECUNDHILL or in enforcing FECUNDHILL's rights under or in connection with these Terms and conditions contained herein, or which may have arisen either directly or indirectly out of or in connection with FECUNDHILL performing its obligations hereunder or accepting instructions, including but not limited to, fax and other telecommunications or electronic instructions, and acting or failing to act thereon.</li>
            <li> If any sum due and payable by the Customer is not paid on the due date, including without limitation any moneys claimed under this Paragraph, the Customer shall be liable to pay interest (both after as well as before any judgement) on such unpaid sum at such rate or rates as FECUNDHILL may from time to time stipulate from the date payment is due up to the date of payment.</li>
            <li> The Customer shall solely be responsible for ensuring full compliance with all the applicable laws and regulations in any relevant jurisdiction in connection with establishment of his/her Account with FECUNDHILL and shall indemnify and keep indemnified FECUNDHILL from all actions, proceedings claims, losses, damages, costs and expenses (including legal costs on a solicitor and client basis) which may be brought against or suffered or incurred by FECUNDHILL in connection with any failure to comply with any such applicable laws/regulations.</li>
            <li> The indemnities as aforesaid shall continue notwithstanding the termination of the Account.</li>
            <li> That any sum standing to the debit of the current account shall bear interest charges at the rate fixed by FECUNDHILL from time to time. FECUNDHILL is authorized to debit from the account the usual banking charges, interest, commissions and any service charge set by the Management from time to time.</li>
            <li> I/We also agree that in addition to any general lien or similar right to which you as bankers may be entitled by law you may at any time without notice to me/us combine or consolidate all or any of my/our accounts without any liabilities to you and set off or transfer any sum or sums standing to the credit of anyone or more of such accounts or any other credits, be it cash, cheques, valuables, deposits, securities, negotiable instruments or other assets belonging tome/us with you in or towards satisfaction of any of my/our liabilities to you or any other account or in any other respect whether such liabilities be actual or contingents, primary or collateral and joint or several.</li>
            <li> I/We shall be solely responsible for the safe-keeping and the confidentiality of the statements of account, balance confirmation certificate, cheque books (if any), Debit card (if any) and its PIN, user id and passwords relating to internet banking and such other items relevant or pertaining to the Account.</li>
          </ol>

          <h5>SAVINGS ACCOUNT FEATURES<h5>
              <h5>Account Features:</h5>
              <ul>
                <li> Zero minimum account opening balance</li>
                <li> Account details can be uploaded via our contact centre, branch or website</li>
                <li> Maximum single deposit-N500,000</li>
                <li> Maximum Cumulative Balance-N5,000,000</li>
                <li> Transactions are limited to Nigeria</li>
              </ul>

              <h5>3. TERMINATION OF THIS AGREEMENT</h5>
              <p>Either party may terminate this agreement with seven days written notice to the other party. PROVIDED HOWEVER, THAT FECUNDHILL may terminate his agreement with or without notice if the circumstance so warrant.</p>
              <h5>4. GENERAL PROVISIONS</h5>
              <p>4.1. FECUNDHILL reserves the right at all times to supplement, amend or vary this agreement as a result of a requirement of law or product development or such other reason communicated to the Customer at the time of notification of the change. Any such change will be effective upon notice to the Customer and notice shall be by any means FECUNDHILL thinks fit. On receipt of such notification, the Customer may at its discretion terminate this agreement in accordance with the conditions of this agreement.</p>
              <p>4.2. On termination, bankruptcy, dissolution, insolvency, liquidation or death, the Customer's obligations will continue until all cards issued in respect of the account are returned and all outstanding indebtedness owed to FECUNDHILL by the Customer is fully repaid.</p>
              <p>4.3. The waiver by FECUNDHILL of any breach of any term of this agreement will not prevent the subsequent enforcement of that term and will not be deemed a waiver of any subsequent breach.</p>

              <h5>5. DEFINITION OF TERMS</h5>
              <p>As used in this agreement,</p>
              <p>FECUNDHILL refers to FECUNDHILL GROUP<br/>
                CUSTOMER refers to persons, legal entities or corporation in whose name an account is opened</p>


                <form method="post">
                  <p><b><input type='checkbox' id='confirm_terms' name='confirm_terms' required value=""> I HEREBY CONFIRM THAT I HAVE READ THE ABOVE TERMS AND CONDITIONS AND AFFIRM THAT I TRULY UNDERSTAND AND ACCEPT SAME AS BINDING ON ME.</b></p>
                  <?php
                    $my_info = $this->Personal->myPersonalInfo();
                    ?>
                  <p>Authorized Signatory: <?php echo $my_info['firstname'] . " " . $my_info['surname'] . " " . $my_info['othername'] ?> <br />
                    Date Authorized: <?php echo date("d/m/Y"); ?></p>

                  <button class="btn btn-danger" name="open_savings_account" value="whatever">Open a New Savings Account with FECUNDHILL</button>
                </form>
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