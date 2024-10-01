<?php

  // View Listings
  $show_listings = true;
  $listings = NULL;

  $error_message_for_listing = "";

  $listings = $this->Listing->getListingsByUserID($this->Users->getUserID());
  
  if ($show_listings ===true) {

    


?>

                <div class="row">
                  <div class="col-sm-12">
                    <table class="table table-striped table-border checkout-table dataTable table-responsive">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Category</th>
                          <th>Title</th>
                          <th>Author</th>
                          <th>Photos</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead>
                        <tbody>
                        <?php

                              $o = "";
                              if ($listings !== false) {
                                foreach ($listings as $index => $listing) {

                                  $author_label = "";
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
                                  
                                  $status_label = "<span class='label label-warning'>Under Review</span>";
                                  if($listing['publish_status'] == 1){
                                    $status_label = "<span class='label label-primary'>Published</span>";
                                  }

                                  $o .= "<tr>";
                                  $o .= "<td>" . ($index + 1) . "</td>";
                                  $o .= "<td>" . $service_label . "</td>";
                                  $o .= "<td>" . $listing['title'] . "</td>";
                                  $o .= "<td>" . $author_label . "</td>";
                                  $o .= "<td>" . $attachment_count_label . "</td>";
                                  $o .= "<td title='" . getfulldateinfo_Type1($listing['time_updated']) . "'>" . date("d/m/Y", strtotime($listing['time_updated'])) . "</td>";
                                  $o .= "<td>" . $status_label . "</td>";
                                  $o .= "<td>";
                                  $o .= "<a href='" . base_url() . "profile/listing_view/" . $listing['id'] . "' class='btn btn-xs btn-default' >View</a>";
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

<?php
    // Show Listings Check
    }else{
      echo $error_message_for_listing;
    }
?>