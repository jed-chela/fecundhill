<?php
$this->load->view("template/headlinks");
?>
<?php /*
<div class="page-loader">
  <div class="loader">Loading...</div>
</div>  */ ?>

<?php
$this->load->view("template/nav");
?>
<?php
$this->load->view("template/slider");
?>


<div class="main">
  <section class="module-extra-small bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-8 col-lg-6 col-lg-offset-2">
          <div class="col-12 callout-text font-alt">
            <h4 style="margin-top: 0px; height: auto;">Looking for a first-class Real Estate consultant?</h4>
            <p style="margin-bottom: 0px; height: auto;">We are always here for you</p>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-2">
          <div class="callout-btn-box"><a class="btn btn-w btn-round" href="<?php echo base_url(); ?>auth/login">Register to Connect with us</a></div>
        </div>
      </div>
    </div>
  </section>
  <section class="module-medium">
    <div class="container">
      <div class="row multi-columns-row">
        <?php /*        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="content-box">
            <div class="content-box-image"><img src="<?php echo base_url(); ?>assets/images/items/contract.jpg" alt="Consult With Us" /></div>
            <h3 class="content-box-title font-serif">Partner With Us</h3>&nbsp;
          </div>
        </div>  */ ?>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="content-box">
            <div class="content-box-image"><img src="<?php echo base_url(); ?>assets/images/items/chess.jpg" alt="Take Proper Strategy" /></div>
            <h3 class="content-box-title font-serif">Take Proper Strategy</h3>&nbsp;
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="content-box">
            <div class="content-box-image"><img src="<?php echo base_url(); ?>assets/images/items/money.jpg" alt="Grow Your Assets" /></div>
            <h3 class="content-box-title font-serif">Grow Your Assets</h3>&nbsp;
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="module pt-0 pb-0">
    <div class="row position-relative m-0">
      <div class="col-xs-12 col-md-6 side-image" data-background="<?php echo base_url(); ?>assets/images/items/adult.jpg"></div>
      <div class="col-xs-12 col-md-6 col-md-offset-6">
        <div class="row finance-image-content">
          <div class="col-md-10 col-md-offset-1">
            <h2 class="module-title font-alt">Service Areas</h2>
            <div class="row multi-columns-row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="alt-features-item">
                  <a href="<?php echo base_url(); ?>welcome/about_real_estate">
                    <div class="alt-features-icon"><span class="fa fa-home"></span></div>
                    <h3 class="alt-features-title font-alt">Real Estate</h3>
                    Buy Property &CirclePlus; 
                    Sell Property
                  </a>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="alt-features-item">
                  <a href="<?php echo base_url(); ?>welcome/about_finance">
                    <div class="alt-features-icon"><span class="fa fa-money"></span></div>
                    <h3 class="alt-features-title font-alt">Finance</h3> Loans &CirclePlus; Fecundvest 
                  </a>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                
                <div class="alt-features-item">
                  <a href="<?php echo base_url(); ?>welcome/about_transport">
                    <div class="alt-features-icon"><span class="fa fa-bus"></span></div>
                    <h3 class="alt-features-title font-alt">Transport</h3> Executive Ride-Hailing &CirclePlus; Executive Ride Partnership
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--  <section class="module sliding-portfolio">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <h2 class="module-title font-alt">Testimonials</h2>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="owl-carousel text-center" data-items="4" data-pagination="false" data-navigation="false">
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="work-item"><a href="#">
                  <div class="work-image"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/finance/case1.jpg" alt="Portfolio Item" /></div>
                  <div class="work-caption font-alt">
                    <h3 class="work-title">Corporate Identity</h3>
                    <div class="work-descr">Illustration</div>
                  </div>
                </a></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="work-item"><a href="#">
                  <div class="work-image"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/finance/case2.jpg" alt="Portfolio Item" /></div>
                  <div class="work-caption font-alt">
                    <h3 class="work-title">Bag MockUp</h3>
                    <div class="work-descr">Marketing</div>
                  </div>
                </a></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="work-item"><a href="#">
                  <div class="work-image"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/finance/case3.jpg" alt="Portfolio Item" /></div>
                  <div class="work-caption font-alt">
                    <h3 class="work-title">Disk Cover</h3>
                    <div class="work-descr">Illustration</div>
                  </div>
                </a></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="work-item"><a href="#">
                  <div class="work-image"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/finance/case4.jpg" alt="Portfolio Item" /></div>
                  <div class="work-caption font-alt">
                    <h3 class="work-title">Corporate Identity</h3>
                    <div class="work-descr">Illustration</div>
                  </div>
                </a></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="work-item"><a href="#">
                  <div class="work-image"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/finance/case5.jpg" alt="Portfolio Item" /></div>
                  <div class="work-caption font-alt">
                    <h3 class="work-title">Bag MockUp</h3>
                    <div class="work-descr">Marketing</div>
                  </div>
                </a></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="work-item"><a href="#">
                  <div class="work-image"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/finance/case6.jpg" alt="Portfolio Item" /></div>
                  <div class="work-caption font-alt">
                    <h3 class="work-title">Disk Cover</h3>
                    <div class="work-descr">Illustration</div>
                  </div>
                </a></div>
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="text-center"><a class="btn btn-border-d btn-circle mt-50" href="#">View All Cases</a></div>
        </div>
      </div>
    </div>
  </section>  -->
  <!--
  <section id="partners" class="module-small bg-dark p-0">
    <div class="container">
      <div class="row client">
        <div class="owl-carousel text-center" data-items="6" data-pagination="false" data-navigation="false">
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="client-logo"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/client-logo-1.png" alt="Client Logo" /></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="client-logo"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/client-logo-2.png" alt="Client Logo" /></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="client-logo"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/client-logo-3.png" alt="Client Logo" /></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="client-logo"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/client-logo-4.png" alt="Client Logo" /></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="client-logo"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/client-logo-5.png" alt="Client Logo" /></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="client-logo"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/client-logo-1.png" alt="Client Logo" /></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="client-logo"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/client-logo-2.png" alt="Client Logo" /></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="client-logo"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/client-logo-3.png" alt="Client Logo" /></div>
            </div>
          </div>
          <div class="owl-item">
            <div class="col-sm-12">
              <div class="client-logo"><img src="<?php echo base_url(); ?>assets/Titan/assets/images/client-logo-4.png" alt="Client Logo" /></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>  -->

  <?php
  $this->load->view("template/contactform");
  ?>

  <br>

  <section class="module pt-0 pb-0">
    <div class="row position-relative m-0">
      <div class="col-xs-12 col-md-6 side-image" data-background="<?php echo base_url(); ?>assets/images/items/support.jpg"></div>
      <div class="col-xs-12 col-md-6 col-md-offset-6">
        <div class="row finance-image-content">
          <div class="col-md-10 col-md-offset-1">
            <h2 class="module-title font-alt">Fecundhill foundation</h2>
            <div class="row multi-columns-row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="alt-features-item">
                  <div class="alt-features-icon"><span class="icon-global"></span></div>
                  <h3 class="alt-features-title font-alt"> </h3>
                  <p>The Fecundhill Foundation is the brainchild of the Fecundhill Group, dedicated to grooming youths into great leaders and entrepreneurs with character, instruments that would offer solutions to societal challenges and show capacity to lead today. We would sustain and create more achievements by ensuring its ripple effect.</p>
                  <div class="form-group">
                    <a href="<?php echo base_url(); ?>welcome/contact_us" class="btn btn-round btn-b">Reach Out</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
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