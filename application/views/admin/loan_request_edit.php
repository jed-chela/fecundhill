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
          <h4 class="font-alt">Edit Loan Request</h4>
          <hr class="divider-w mb-10">
        </div>

        
        <?php

          $o = "";
          $record = $this->Finance->getLoanRequestRecord($request_id);
          if ($record !== false) {
            
              $user = $this->Users->getUser($record["user_id"]);

              $profile_status_label = "";
             
              $profile_info = $this->Personal->personalInfo($user['id']);
              if ($profile_info !== false) {
                
              }

              $my_info = $profile_info;
          ?>
          


          <div class="row">
          <div class="col-sm-12">

            <form class="form" method="POST" style="overflow: hidden;">
              <h4>New Loan Request Form</h4>
              
                <div class='col-sm-10 mb-sm-10' style="border: 1px solid #DDD;">
                  <?php
                if (isset($request_loan_form_error)) {
                  if ($request_loan_form_error != "") {
                    echo $request_loan_form_error;
                  }
                }
                ?>
                
                  <div class="form-group">
                    <label>My Name</label>
                    <span><?php echo $my_info['firstname'] . " " . $my_info['surname'] . " " . $my_info['othername'] ?></span>
                    <input class="form-control" type="hidden" name="loan_request_id" value="<?php echo $record['id'] ;?>" required />
                  </div>
                  <div class="form-group">
                    <label>Amount</label>
                    <input class="form-control" id="loan_amount" type="number" name="loan_amount" placeholder="Loan Amount" 
                    value="<?php echo $record['amount'] ;?>" required />
                  </div>
                  <div class="form-group">
                    <label>Duration (months)</label>
                    <input class="form-control" id="loan_duration" type="number" name="loan_duration" placeholder="e.g. 6" value="<?php echo $record['duration'] ;?>" required />
                  </div>


                  <?php /*
                    <div class="form-group">
                      <label>No of Children</label>
                      <input class="form-control" type="number" name="children" placeholder="No of Children" value="" required />
                    </div>
*/ ?>

<?php /*                  <div class="form-group">
                    <label>Which bank account type do you operate?</label>
                    <select class="form-control" name="bank_account" required disabled="">
                      <?php
                        $sel_bnk1 = ""; $sel_bnk2 = ""; $sel_bnk3 = "";
                        if($record['bank_account'] == 'Current Account'){
                          $sel_bnk1 = "selected";
                        }else if($record['bank_account'] == 'Savings Account'){
                          $sel_bnk2 = "selected";
                        }else if($record['bank_account'] == 'Corporate Account'){
                          $sel_bnk3 = "selected";
                        }
                */      ?>
<?php /*                      <option value="">--Select One--</option>
                      <option <?php echo $sel_bnk1; ?><?php /* >Current Account</option>
                      <option <?php echo $sel_bnk2; ?><?php /* >Savings Account</option>
                      <option <?php echo $sel_bnk3; ?><?php /* >Corporate Account</option>
                    </select>
                  </div>
*/  ?>            

                  <div class="form-group">
                    <label>Employed or Self-employed?</label>
                    <select class="form-control" name="employment" required>
                      <?php
                        $sel_emp1 = ""; $sel_emp2 = ""; $sel_emp3 = "";
                        if($record['employment'] == 'Employed'){
                          $sel_emp1 = "selected";
                        }else if($record['employment'] == 'Self-employed'){
                          $sel_emp2 = "selected";
                        }else{
                          $sel_emp3 = "selected";
                        }
                      ?>
                      <option value="">--Select One--</option>
                      <option <?php echo $sel_emp1; ?> >Employed</option>
                      <option <?php echo $sel_emp2; ?> >Self-employed</option>
                      <option <?php echo $sel_emp3; ?> >Unemployed</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Do you have a valid personal bank account cheque book?</label>
                    <select class="form-control" name="cheque_book" required disabled="">
                      <?php
                        $sel_chk1 = ""; $sel_chk2 = "";
                        if($record['cheque_book'] == 'Yes'){
                          $sel_chk1 = "selected";
                        }else if($record['cheque_book'] == 'No'){
                          $sel_chk2 = "selected";
                        }
                      ?>
                      <option value="">--Select One--</option>
                      <option <?php echo $sel_chk1; ?> >Yes</option>
                      <option <?php echo $sel_chk2; ?> >No</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Bank Name</label>
                    <input class="form-control no-textupper" type="text" name="bank_name" maxlength="255" placeholder="" value="<?php echo $record['bank_name'] ;?>" disabled />
                  </div>
                  <div class="form-group">
                    <label>Account Name</label>
                    <input class="form-control no-textupper" type="text" name="account_name" maxlength="255" placeholder="" 
                    value="<?php echo $record['account_name'] ;?>" disabled />
                  </div>
                  <div class="form-group">
                    <label>Bank Account Number</label>
                    <input class="form-control" type="number" name="account_number" maxlength="20" placeholder="" 
                    value="<?php echo $record['account_number'] ;?>" disabled />
                  </div>

                  <div class="form-group">
                    <label>Current monthly salary income / Average monthly business turnover</label>
                    <input class="form-control no-textupper" type="number" name="current_income" placeholder="" 
                    value="<?php echo $record['current_income'] ;?>" disabled />
                  </div>

                  <div class="form-group">
                    <label>Are you currently servicing any other loan, possibly from a bank or other company?</label>
                    <select class="form-control" name="other_loan" disabled>
                      <?php
                        $sel_otl1 = ""; $sel_otl2 = "";
                        if($record['other_loan'] == 'Yes'){
                          $sel_otl1 = "selected";
                        }else if($record['other_loan'] == 'No'){
                          $sel_otl2 = "selected";
                        }
                      ?>
                      <option <?php echo $sel_otl1; ?> >No</option>
                      <option <?php echo $sel_otl2; ?> >Yes</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Select a Deposit Frequency for your repayment</label>
                    <div class="">Selected Option: <?php echo $record['deposit_frequency']; ?></div>
                    <?php
                      $dep_f = $record['deposit_frequency'];
                      $dep_f1 = ""; $dep_f2 = ""; $dep_f3 = "";
                      if($dep_f == "Daily"){
                        $dep_f1 = "selected";
                      }else if($dep_f == "Weekly"){
                        $dep_f2 = "selected";
                      }else if($dep_f == "Monthly"){
                        $dep_f3 = "selected";
                      }
                    ?>
                    <select class="form-control" name="deposit_frequency" required>
                      <option <?php echo $dep_f1; ?> >Daily</option>
                      <option <?php echo $dep_f2; ?> >Weekly</option>
                      <option <?php echo $dep_f3; ?> >Monthly</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Payment Amount</label>
                    <input class="form-control" type="text" name="payment_amount" value="<?php echo $record['payment_amount']; ?>" />
                  </div>

                  <div class="form-group">
                    <label>Specific Day/Date (e.g. Monday or 29th)</label>
                    <input class="form-control" type="text" name="specific_day" value="<?php echo $record['specific_day']; ?>" />
                  </div>
<?php /*
                  <div class="form-group">
                    <label>Purpose of Loan (e.g. Business, Medical, School Fees)</label>
                    <input class="form-control" type="text" name="purpose" value="<?php echo $record['purpose']; ?><?php /*" disabled />
                  </div>
*/ ?>
                  <div class="form-group">
                    <label>List your asset/inventory</label>
                    <textarea class="form-control autosize" name="collateral" maxlength="999" value="<?php echo $record['collateral']; ?>"  disabled ></textarea>
                  </div>

                  <div class="form-group">
                    <label>Location of asset/inventory</label>
                    <input class="form-control" type="text" name="asset_location" maxlength="499" value="<?php echo $record['asset_location']; ?>" disabled />
                  </div>

                  <div class="form-group">
                    <label>Termination Date</label>
                    <input class="form-control no-textupper" id="termination_date" type="date" name="termination_date" placeholder="Termination Date" value="<?php echo $record['termination_date']; ?>" />
                  </div>

                  <div class="form-group">
                    <label>Moratorium</label>
                    <input class="form-control no-textupper" id="moratorium" type="text" name="moratorium" placeholder="Moratorium" value="<?php echo $record['moratorium']; ?>" />
                  </div>

                  <div class="form-group">
                    <input class="" id="loan_confirm" type="checkbox" name="loan_confirm" placeholder="Loan Confirm" value="" required />
                    <label for="loan_confirm">I have cross-checked and ensured that the values entered above are accurate and reliable! </label>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-round btn-b" type="submit" name='update_loan_request_but' value="Update Request">Update Request</button>
                  </div>
                </div>
              
            </form>
                  
                      

                </div>
              </div>



          <?php    
          }

          echo $o;
          ?>

        
        

      </div>
    </div>
  </section>
</div>


  <?php
  $this->load->view("template/footer");
  ?>
  <?php
  $this->load->view("template/footlinks");
  ?>