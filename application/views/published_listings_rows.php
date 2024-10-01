
          <?php
            // Messages and Notifications

            $listings = $this->Listing->getAllListingsByPublishStatus(1, $category);

            ?>


              <hr class="divider-w mb-10">
              <div class='col-sm-12 mb-sm-12'>

                <div class="row">
                  <div class="col-sm-12">
                    <table class="table table-striped table-border checkout-table dataTable table-responsive">
                        <thead>
                        <tr>
                          <th>#</th>
                          <thvalue=''>Category</th>
                          <th>Title</th>
                          <th>Author</th>
                          <th>Photos</th>
                          <th>Date</th>
                          <?php   /*   <th class="hidden-xs">Opened</th>  */ ?>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                              $o = "";
                              if ($listings !== false) {
                                foreach ($listings as $index => $listing) {

                                  $author = $this->Partner->getPartnerAccount($listing['partner_id']);
                                  if ($author !== false) {
                                    $author_label = $author["business_name"];
                                  }

                                  $service_label = "Real Estate";
                                  if ($listing['category'] == 2) {
                                    $service_label = "Transport";
                                  }
                                  if ($listing['category'] == 3) {
                                    $service_label = "Hire Purchase";
                                    if($author_label == ""){
                                      $author_label = $this->Personal->userName($listing['user_id']);
                                    }
                                  }

                                  $attachment_count_label = "None";
                                  $attachments = $this->Listing->getListingPhotos($listing['id']);
                                  if ($attachments !== false) {
                                    $attachment_count_label = count($attachments);
                                  }


                                  $o .= "<tr>";
                                  $o .= "<td>" . ($index + 1) . "</td>";
                                  $o .= "<td>" . $service_label . "</td>";
                                  $o .= "<td>" . $listing['title'] . "</td>";
                                  $o .= "<td>" . $author_label . "</td>";
                                  $o .= "<td>" . $attachment_count_label . "</td>";
                                  $o .= "<td title='" . getfulldateinfo_Type1($listing['time_updated']) . "'>" . date("d/m/Y", strtotime($listing['time_updated'])) . "</td>";
                                  $o .= "<td>";
                                  $o .= "<a href='" . base_url() . "profile/listing_view2/" . $listing['id'] . "' class='btn btn-xs btn-default' >View</a> ";
                                  $o .= "</td>";
                                  $o .= "</tr>";
                                }
                              }

                              echo $o;
                              ?>

                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
              <hr class="divider-w mb-10">