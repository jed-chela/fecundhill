<?php

  // View Listings
  $show_listings = true;
  $vehicles = NULL;

  $error_message_for_listing = "";

  $vehicles = $this->Listing->getVehicleSignupByUser($this->Users->getUserID());
  
  if ($show_listings ===true) {

    


?>

                <div class="row">
                  <div class="col-sm-12">
                    <table class="table table-striped table-border checkout-table dataTable table-responsive">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Brand</th>
                          <th>Model</th>
                          <th>Year</th>
                          <th>Color</th>
                          <th>Plate</th>
                          <th>Passengers</th>
                          <th>Town</th>
                      <!--    <th>Author</th> -->
                          <th>Documents</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead>
                        <tbody>
                        <?php

                              $o = "";
                              if ($vehicles !== false) {
                                foreach ($vehicles as $index => $vehicle) {

                                  $author_label = "";
                            //      $author = $this->Partner->getPartnerAccount($vehicle['partner_id']);
                            //      if ($author !== false) {
                            //        $author_label = $author["business_name"];
                            //      }

                            /*      $service_label = "Real Estate";
                                  if ($vehicle['category'] == 2) {
                                    $service_label = "Transport";
                                  }
                                  if ($vehicle['category'] == 3) {
                                    $service_label = "Hire Purchase";
                                    if($author_label == ""){
                                      $author_label = $this->Personal->userName($vehicle['user_id']);
                                    }
                                  }
                            */
                                  $attachment_count_label = "None";
                                  $attachments = $this->Listing->getListingPhotos($vehicle['id']);
                                  if ($attachments !== false) {
                                    $attachment_count_label = count($attachments);
                                  }
                                  
                                  $status_label = "<span class='label label-default'>Under Review</span>";
                                  if($vehicle['status'] == 1){
                                    $status_label = "<span class='label label-success'>Approved</span>";
                                  }else if($vehicle['status'] == 2){
                                    $status_label = "<span class='label label-danger'>Rejected</span>";
                                  }else if($vehicle['status'] == 3){
                                    $status_label = "<span class='label label-warning'>Suspended</span>";
                                  }

                                  $o .= "<tr>";
                                  $o .= "<td>" . ($index + 1) . "</td>";
                                  $o .= "<td>" . $vehicle['vehicle_brand'] . "</td>";
                                  $o .= "<td>" . $vehicle['vehicle_model'] . "</td>";
                                  $o .= "<td>" . $vehicle['vehicle_model_year'] . "</td>";
                                  $o .= "<td>" . $vehicle['vehicle_color'] . "</td>";
                                  $o .= "<td>" . $vehicle['vehicle_plate'] . "</td>";
                                  $o .= "<td>" . $vehicle['vehicle_passengers'] . "</td>";
                                  $o .= "<td>" . $vehicle['vehicle_town'] . "</td>";
                                  $o .= "<td>" . $attachment_count_label . "</td>";
                                  $o .= "<td title='" . getfulldateinfo_Type1($vehicle['time_updated']) . "'>" . date("d/m/Y", strtotime($vehicle['time_updated'])) . "</td>";
                                  $o .= "<td>" . $status_label . "</td>";
                                  $o .= "<td>";
                                  $o .= "<a href='" . base_url() . "profile/listing_view/" . $vehicle['id'] . "' class='btn btn-xs btn-default' >View</a>";
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