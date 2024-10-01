<div class="module-small bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div class="widget">
          <h5 class="widget-title font-alt">Contact Fecundhill</h5>
          <p>Address: 44 Old Lagos-Asaba Road, Agbor, Delta State, Nigeria.</p>
          <p>Phone: 08032726534</p>
          <p>Email: <a href="#">info@fecundhill.com</a></p>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="widget">
          <h5 class="widget-title font-alt">Social Links</h5>
          <ul class="icon-list">
            <li>Connect on <a href="https://www.facebook.com/Fecundhill" target="_blank">Facebook</a></li>
            <li>Follow on <a href="https://twitter.com/Fecundhill" target="_blank">Twitter</a></li>
            <li>View on <a href="https://www.instagram.com/Fecundhill" target="_blank">Instagram</a></li>
          </ul>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="widget">
          <h5 class="widget-title font-alt">Quicklinks</h5>
          <ul class="icon-list">
            <?php

            if ($this->Users->isActive()) {
              ?>
              <li><a href="<?php echo base_url(); ?>profile/finance_home">Fecundvest</a></li>
              <li><a href="<?php echo base_url(); ?>profile/finance_home">Loans</a></li>
              <li><a href="<?php echo base_url(); ?>profile/real_estate_home">Real Estate Listings</a></li>
              <li><a href="<?php echo base_url(); ?>profile/transport_home">Assisted Transport Services</a></li>
            <?php
            } else {
              ?>
              <li><a href="<?php echo base_url(); ?>welcome/about_finance">Fecundvest</a></li>
              <li><a href="<?php echo base_url(); ?>welcome/about_finance">Loans</a></li>
              <li><a href="<?php echo base_url(); ?>welcome/about_real_estate">Real Estate Listings</a></li>
              <li><a href="<?php echo base_url(); ?>welcome/about_transport">Assisted Transport Services</a></li>
            <?php
            }
            ?>

          </ul>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="widget">
          <h5 class="widget-title font-alt">Quick Services</h5>
          <ul class="widget-posts">
            <li class="clearfix">
              <div class="widget-posts-image"><b><img src="<?php echo base_url(); ?>assets/images/items/contract.jpg" alt="Post Thumbnail" /></b></div>
              <div class="widget-posts-body">
                <div class="widget-posts-title"><b>Loans</b></div>
                <div class="widget-posts-meta">Business and Workers</div>
              </div>
            </li>
            <li class="clearfix">
              <div class="widget-posts-image"><b><img src="<?php echo base_url(); ?>assets/images/items/money.jpg" alt="Post Thumbnail" /></b></div>
              <div class="widget-posts-body">
                <div class="widget-posts-title"><b>Fecundvest</b></div>
                <div class="widget-posts-meta">And other Services</div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<hr class="divider-d">
<footer class="footer bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <?php
        date_default_timezone_set("GMT");
        ?>
        <p class="copyright font-alt">&copy; <?php echo date("Y"); ?>&nbsp;<a href="#">Fecundhill</a>, All Rights Reserved</p>
      </div>
      <div class="col-sm-6">
        <div class="footer-social-links">
          <a href="https://www.facebook.com/Fecundhill" target="_blank"><i class="fa fa-facebook"></i></a>
          <a href="https://twitter.com/Fecundhill" target="_blank"><i class="fa fa-twitter"></i></a>
          <a href="https://www.instagram.com/Fecundhill" target="_blank"><i class="fa fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>
</div>
<div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
</main>