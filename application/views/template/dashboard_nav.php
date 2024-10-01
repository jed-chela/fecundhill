<?php
$selected_1 = "";
$selected_2 = "";
$selected_3 = "";
$selected_4 = "";

if(isset($nav_tag)){
  if($nav_tag == "dashboard"){
    $selected_1 = "nav_highlight";
  }else if($nav_tag == "finance"){
    $selected_2 = "nav_highlight";
  }else if($nav_tag == "real_estate"){
    $selected_3 = "nav_highlight";
  }else if($nav_tag == "transport"){
    $selected_4 = "nav_highlight";
  }
}

?>

<div class="row multi-columns-row">
<?php /*  <div class="col-md-3 col-sm-3 col-xs-6 <?php echo $selected_1; ?>">
    <div class="alt-features-item">
      <a href="<?php echo base_url(); ?>profile/dashboard">
        <div class="alt-features-icon"><span class="fa fa-navicon"></span></div>
        <div style="font-size:8px;">&nbsp;</div>
        <h3 class="alt-features-title font-alt">Dashboard</h3>&nbsp;
      </a>
    </div>
  </div>  */ ?>
  <a href="<?php echo base_url(); ?>profile/finance_home" class=''>
  <div class="col-md-3 col-sm-3 col-xs-6 nav_dash_x <?php echo $selected_2; ?>">
    <div class="alt-features-item">
      
        <div class="alt-features-icon"><span class="fa fa-money"></span></div>
        <div style="font-size:8px;">&nbsp;</div>
        <h3 class="alt-features-title font-alt">Finance</h3>&nbsp;
      
    </div>
  </div>
  </a>
  <a href="<?php echo base_url(); ?>profile/real_estate_home" class=''>
  <div class="col-md-3 col-sm-3 col-xs-6 nav_dash_x <?php echo $selected_3; ?>">
    <div class="alt-features-item">
      
        <div class="alt-features-icon"><span class="fa fa-home"></span></div>
        <div style="font-size:8px;">&nbsp;</div>
        <h3 class="alt-features-title font-alt">Real Estate</h3>&nbsp;
      
    </div>
  </div>
  </a>
  <a href="<?php echo base_url(); ?>profile/transport_home" class=''>
  <div class="col-md-3 col-sm-3 col-xs-6 nav_dash_x <?php echo $selected_4; ?>">
    <div class="alt-features-item">
      
        <div class="alt-features-icon"><span class="fa fa-bus"></span></div>
        <div style="font-size:8px;">&nbsp;</div>
        <h3 class="alt-features-title font-alt">Transport</h3>&nbsp;
      
    </div>
  </div>
  </a>


</div>