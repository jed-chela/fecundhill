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
          <h4 class="font-alt">NEW FIXED DEPOSIT ACCOUNT TERMS AND CONDITIONS</h4>
          <hr class="divider-w mb-10">
        </div>
        <?php
        // Check if Account has been verified
        $verify_account_status = $this->Users->getVerifyAccountInfoByID($this->Users->getUserID());

        if ($verify_account_status['status'] == 9) {

          echo "<p>You need to verify your email address to enable your account! An email was sent to " . $verify_account_status['email'] . " inbox when you registered. The email contains the verification link. Check your spam folder also, just in case. </p>";
        } else {
          ?>

          <p><strong><span style="font-size: 22px;">FECUNDVEST</span></strong></p>
<p><strong>To FECUNDHILL</strong></p>
<p><strong>I / WE (the Customer) HEREBY REQUEST AND AUTHORISE YOU TO</strong></p>
<p>1. Open an account in my/our name and at any time subsequently open further accounts as I / We may direct.</p>
<p>2. Honor all orders which may be drawn on the said account provided such orders are signed by me / us and to debit such order to the said account whether such account be for the time being in credit or overdrawn or may become overdrawn in consequence of such debit without prejudice to your right to refuse to allow any overdraft or increase of overdraft and in consideration</p>
<p><strong>I / We agree</strong></p>
<p>a) To assume full responsibility for the genuineness, correctness and validity of endorsements appearing on all orders, bills, notes, negotiable instruments, receipts and/or other documents deposited.</p>
<p>b) To be responsible for the repayment of any overdraft with interest and to comply and be bound by your rules for the conduct of an Account receipt of which I / We hereby acknowledge.</p>
<p>c) To free FECUNDHILL from any responsibility for any loss or damage to funds deposited with FECUNDHILL due to any future government order, law, levy, tax, embargo and / or all other causes beyond FECUNDHILL&apos;s control.</p>
<p>d) That all funds standing to my / our credit are payable on demand only in such local currency as may be in circulation.</p>
<p>e) To be bound by any notification of change in conditions governing the account dispatched to my / our last known address and any notice or mail sent to my / our last known email address shall be considered as duly delivered and received by me / us at the time it will be delivered in the ordinary course of an email.</p>
<p>f) And I / We note that FECUNDHILL will accept no liability whatsoever for funds handed to members of staff outside of FECUNDHILL premises or paid into an account different from FECUNDHILL official Bank Account(s).</p>
<p>g) That any disagreements or complaints with entries on my / our Account Statements will be made by me / us within 15 days of the dispatch of the Account Statement. Failing receipt by FECUNDHILL of a notice of disagreement / complaint of entries within 15 days from the date of dispatch of my / our Account Statement as rendered is correct.</p>
<p>h) The Customer hereby agrees that the Customer shall, at his / its own expense, indemnify, defend and hold harmless, FECUNDHILL, from and against any and all liability or any other loss that may occur, arising from or relating to the operation or use of the Account or the Services or breach, non-performance or inadequate performance by the Customer of any of these Terms or the acts, errors, representations, misrepresentations, misconduct or negligence of the Customer in performance of its obligations.</p>
<p>i) Under no circumstances shall FECUNDHILL be liable to the Customer for any indirect, incidental, consequential, special or exemplary damages in connection with the Account or the Services.</p>
<p>j) FECUNDHILL shall not be liable for any failure to perform any obligation contained in these Terms or for any loss or damage whatsoever suffered or incurred by the Customer howsoever caused and whether such loss or damage is attributable (directly or indirectly) to any dispute or any other matter or circumstances whatsoever.</p>
<p>k) The Customer shall always keep FECUNDHILL indemnified against, and save FECUNDHILL, harmless from all actions, proceedings, claims, losses, damages, costs, interest (both before and after judgement) and expenses (including legal costs on a solicitor and client basis) which may be brought against or suffered or incurred by FECUNDHILL in resolving any dispute relating to the Customer&apos;s Account with FECUNDHILL or in enforcing FECUNDHILL&apos;s rights under or in connection with these Terms and conditions contained herein, or which may have arisen either directly or indirectly out of or in connection with FECUNDHILL performing its obligations hereunder or accepting instructions, including but not limited to, fax and other telecommunications or electronic instructions, and acting or failing to act thereon.</p>
<p>l) If any sum due and payable by the Customer is not paid on the due date, including without limitation any moneys claimed under this Paragraph, the Customer shall be liable to pay interest (both after as well as before any judgement) on such unpaid sum at such rate or rates as FECUNDHILL may from time to time stipulate from the date payment is due up to the date of payment.</p>
<p>m) The Customer shall solely be responsible for ensuring full compliance with all the applicable laws and regulations in any relevant jurisdiction in connection with establishment of his / her Account with FECUNDHILL and shall indemnify and keep indemnified FECUNDHILL from all actions, proceedings claim, losses, damages, costs and expenses (Including legal costs on a solicitor and client basis) which may be brought against or suffered or incurred by FECUNDHILL in connection with any failure to comply with any such applicable laws / regulations.</p>
<p>n) The indemnities as aforesaid shall continue notwithstanding the termination of the Account.</p>
<p>o) That any sum standing to the debit of the current account shall bear interest charges at the rate fixed by FECUNDHILL from time to time. FECUNDHILL is authorized to debit from the account the usual charges, interest, commissions and any service charge set by the Management from time to time.</p>
<p>p) I / We also agree that in addition to any general lien or similar right to which you may be entitled by law you may at any time without notice to me/us combine or consolidate all or any of my/our accounts without any liabilities to you and set off or transfer any sum or sums standing to the credit of anyone or more of such accounts or any other credits, be it cash, cheques, valuables, deposits, securities, negotiable instruments or other assets belonging to me/us with you in or towards satisfaction of any of my/our liabilities to you or any other account or in any other respect whether such liabilities be actual or contingents, primary or collateral and joint or several.</p>
<p>q) I / We shall be solely responsible for the safe-keeping and the confidentiality of the statements of account, balance confirmation certificate and its PIN, user id and passwords relevant or pertaining to the Account.</p>
<p><strong>FINANCIAL GOAL ACCOUNT FEATURES</strong></p>
<p>Account Features: </p>
<ul style="list-style: square;">
  <li>Account details can be uploaded via our contact Centre, branch or website</li>
  <li>Maximum single deposit-N500,000</li>
  <li>Maximum Cumulative Balance-N5,000,000</li>
  <li>Transactions are limited to Nigeria</li>
</ul>
<p>3. TERMINATION OF THIS AGREEMENT</p>
<p>Either party may terminate this agreement with seven days written notice to the other party. PROVIDED HOWEVER, THAT FECUNDHILL may terminate his agreement with or without notice if the circumstance so warrant.</p>
<p>4. GENERAL PROVISIONS</p>
<p>4.1. FECUNDHILL reserves the right at all times to supplement, amend or vary this agreement as a result of a requirement of law or product development or such other reason communicated to the Customer at the time of notification of the change. Any such change will be effective upon notice to the Customer and notice shall be by any means FECUNDHILL deems fit. On receipt of such notification, the Customer may at its discretion terminate this agreement in accordance with the conditions of this agreement.</p>
<p>4.2. On termination, bankruptcy, dissolution, insolvency, liquidation or death, the Customer&apos;s obligations will continue until all cards issued in respect of the account are returned and all outstanding indebtedness owed to FECUNDHILL by the Customer is fully repaid.</p>
<p>4.3 Default in schedule beyond 3 consecutive working days would lead to forfeiture of all benefits.</p>
<p>4.4 Withdrawal or termination of the contract before the agreed date shall lead to 5% penalty fee of the withdrawal amount payable.</p>
<p>4.5 Benefit would only be awarded on the termination date if the customer fulfills the financial goal schedule</p>
<p>4.6. The waiver by FECUNDHILL of any breach of any term of this agreement will not prevent the subsequent enforcement of that term and will not be deemed a waiver of any subsequent breach.</p>
<p>5. DEFINITION OF TERMS</p>
<p><i>As used in this agreement,</i><br/>
    <i>FECUNDHILL refers to FECUNDHILL INT&rsquo;L SERVICES LIMITED</i><br/>
    <i>CUSTOMER refers to persons, legal entities or corporation in whose name an account is Opened</i><br/>
<?php 
//<p><strong>I _____________________________________________ HEREBY CONFIRM THAT I HAVE READ THE ABOVE TERMS AND CONDITIONS AND AFFIRM THAT I TRULY UNDERSTAND AND ACCEPT SAME AS BINDING ON ME.</strong></p>
?>


              <form method="post">

                

                <p><b><input type='checkbox' id='confirm_terms' name='confirm_terms' required value="">&nbsp; I HEREBY CONFIRM THAT I HAVE READ THE ABOVE TERMS AND CONDITIONS AND AFFIRM THAT I TRULY UNDERSTAND AND ACCEPT SAME AS BINDING ON ME.</b></p>
                <?php
                  $my_info = $this->Personal->myPersonalInfo();
                  ?>
                <p>Authorized Signatory: <?php echo $my_info['firstname'] . " " . $my_info['surname'] . " " . $my_info['othername'] ?> <br />
                  Date Authorized: <?php echo date("d/m/Y"); ?></p>

                <button class="btn btn-danger" name="open_fixed_account" value="whatever">Open a New Fecundvest Account with FECUNDHILL</button>
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