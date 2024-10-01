<nav class="navbar navbar-custom navbar-fixed-top navbar-transparent" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!--      <a class="navbar-brand" href="<?php echo base_url(); ?>">Fecundhill</a> -->
      <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src='<?php echo base_url(); ?>assets/images/logo220x100a.png' /></a>
    </div>
    <div class="collapse navbar-collapse" id="custom-collapse">
      <ul class="nav navbar-nav navbar-right">
        <?php
        // Check if Account Holder is an Admin or Subadmin
        $user_permission = $this->Users->getSubAdminAccess($this->Users->getUserID());

        if ($user_permission !== false) {

          ?>
          <li class="dropdown"><a class="dropdown-toggle" href="<?php echo base_url(); ?>admin" data-toggle="dropdown">Administration</a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url(); ?>admin">Admin Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/new_message">New Direct Message</a></li>
              <li><a href="<?php echo base_url(); ?>admin/messages">View all Messages</a></li>
              <li><a href="<?php echo base_url(); ?>admin/listings">View all Listings</a></li>
              <li><a href="<?php echo base_url(); ?>admin/listing_requests">View all Listing Requests</a></li>
              <li><a href="<?php echo base_url(); ?>admin/service_requests">View all Service Requests</a></li>
              <li><a href="<?php echo base_url(); ?>admin/transaction_management">Manage Transactions</a></li>
              <li><a href="<?php echo base_url(); ?>admin/view_loan_requests_history">Loan Request History</a></li>
              <li><a href="<?php echo base_url(); ?>admin/view_loans_history">Loans History</a></li>
              <li><a href="<?php echo base_url(); ?>admin/withdrawal_requests_history">Withdrawal Request History</a></li>
          <!--    <li><a href="<?php echo base_url(); ?>admin/booking/flight">Flight Booking Requests</a></li>
              <li><a href="<?php echo base_url(); ?>admin/express_delivery">Express Delivery Requests</a></li>  -->
              <li><a href="<?php echo base_url(); ?>admin/booking/ride">Ride Booking Requests</a></li>
          <!--        <li><a href="<?php echo base_url(); ?>admin/driver_signups">Driver Signups</a></li> -->
              <li><a href="<?php echo base_url(); ?>admin/vehicle_signups">Vehicle List</a></li>
              <li><a href="<?php echo base_url(); ?>admin/referrals">Referrals</a></li>
              <li><a href="<?php echo base_url(); ?>admin/referral_codes">User Referral Codes</a></li>
              <li><a href="<?php echo base_url(); ?>admin/user_management">Manage Users</a></li>
            </ul>
          </li>
        <?php
        }
        ?>
        <li class="dropdown"><a class="dropdown-toggle" href="<?php echo base_url(); ?>profile" data-toggle="dropdown">Profile</a>
          <?php
          // Check if Account has been verified
          $verify_account_status = $this->Users->getVerifyAccountInfoByID($this->Users->getUserID());

          if ($verify_account_status['status'] == 1) {

            ?>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url(); ?>profile">Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>profile/view">My Profile Info</a></li>
              <li><a href="<?php echo base_url(); ?>profile/edit">Edit Profile Info</a></li>
              <li><a href="<?php echo base_url(); ?>profile/new_listing">Create a New Listing</a></li>
              <li><a href="<?php echo base_url(); ?>profile/listings">My Listings</a></li>
              <li><a href="<?php echo base_url(); ?>profile/vehicles">My Vehicles</a></li>
              <li><a href="<?php echo base_url(); ?>profile/requests">My Requests to Acquire Listings</a></li>
              <li><a href="<?php echo base_url(); ?>profile/service_requests">My Service Requests</a></li>
              <li><a href="<?php echo base_url(); ?>profile/transactions_all">All Transactions</a></li>
<!--              <li><a href="<?php echo base_url(); ?>profile/verify_sms">Account Verification</a></li> -->
            </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" href="<?php echo base_url(); ?>profile/messages" data-toggle="dropdown">Messages</a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url(); ?>profile/new_message">Send a Direct Message</a></li>
            <li><a href="<?php echo base_url(); ?>profile/messages">Messages and Notifications</a></li>
          </ul>
        </li>
        <?php /*        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Finance</a>
          <ul class="dropdown-menu">
            <li><a href="about2.html">Savings</a></li>
            <li><a href="about3.html">Loans</a></li>
            <li><a href="about1.html">Fecundvest</a></li>
            <!--      <li><a href="about4.html">Account Activity History</a></li> -->
          </ul>
        </li> */ ?>

        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Finance</a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url(); ?>profile/finance_home">Finance Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>profile/transactions">My Fecundvest Transactions</a></li>
            <li><a href="<?php echo base_url(); ?>profile/loans">My Loans</a></li>
            <?php /*                       <li><a href="<?php echo base_url(); ?>profile/finance_withdrawals">Withdrawal Requests</a></li>  */ ?>

          </ul>
        </li>

        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Real Estate</a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url(); ?>profile/real_estate_home">Real Estate Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>profile/new_special_message/real_estate">Request Our Services</a></li>
            <li><a href="<?php echo base_url(); ?>profile/published_listings/1">View Listings</a></li>
            <?php /*           <li><a href="about3.html">Real Estate</a></li>
            <li><a href="about1.html">Civil Engineering</a></li>  */ ?>
          </ul>
        </li>

        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Transport</a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url(); ?>profile/transport_home">Transport Dashboard</a></li>
      <!--      <li><a href="<?php echo base_url(); ?>profile/transport_booking/flight">Book a Flight</a></li>
            <li><a href="<?php echo base_url(); ?>profile/express_delivery">Express Delivery</a></li>  -->
            <li><a href="<?php echo base_url(); ?>profile/transport_booking/ride">Book a Ride</a></li>
            <li><a href="<?php echo base_url(); ?>profile/new_special_message/transport">Request Our Services</a></li>
            <?php /*           <li><a href="about3.html">Car Hire</a></li>
            <li><a href="about1.html">Truck Hire</a></li>
            <li><a href="about4.html">Transport Services</a></li> */ ?>
          </ul>
        <?php
        }
        ?>
        </li>

        <li><a class='btn btn-primary nav-payment-but' href="https://flutterwave.com/pay/n6dakku6voo8">Make a Payment</a></li>
        <li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
      </ul>

    </div>
  </div>
</nav>