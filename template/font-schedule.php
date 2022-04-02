   
<?php 

  if(isset($_POST['search_schedule'])){
		$date = $_POST['reservation_date'];
		$timestamp = strtotime($date);
		$day = date('w', $timestamp);
		var_dump($day);
		if($day=='0'){
			$_COOKIE['dayhash'] = "1-1-1-1-1-1-2";
			$_COOKIE['sday'] = $day;
			header("location:reservation.php?res_id=".$res_id);
		} else if ($day=='1'){
			$_COOKIE['dayhash'] = "2-1-1-1-1-1-1";
			$_COOKIE['sday'] = $day;
			header("location:reservation.php?res_id=".$res_id);
		}
		else if ($day=='2'){
			$_COOKIE['dayhash'] = "1-2-1-1-1-1-1";
			$_COOKIE['sday'] = $day;
			header("location:reservation.php?res_id=".$res_id);
		}
		else if ($day=='3'){
			$_COOKIE['dayhash'] = "1-1-2-1-1-1-1";
			$_COOKIE['sday'] = $day;
			header("location:reservation.php?res_id=".$res_id);
		}
		else if ($day=='4'){
			$_COOKIE['dayhash'] = "1-1-1-2-1-1-1";
			$_COOKIE['sday'] = $day;
			header("location:reservation.php?res_id=".$res_id);
		}
		else if ($day=='5'){
			$_COOKIE['dayhash'] = "1-1-1-1-2-1-1";
			$_COOKIE['sday'] = $day;
			header("location:reservation.php?res_id=".$res_id);
		}
		else{
			$_COOKIE['dayhash'] = "1-1-1-1-1-2-1";
			$_COOKIE['sday'] = $day;
			header("location:reservation.php?res_id=".$res_id);
		}
	}
?>
     <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 text-center heading-section">
            <h3 style="border-bottom: 1px solid black;">Available Schedules</h3>
          </div>
        </div>
        <!-- Search Date -->
        <div style="justify-content:center;align-items:center" class="row d-flex">
          <div style="background: white;"class="col-md-10 makereservation mb-4">
            <form action="reservation.php?res_id=<?php echo $res_id?>" method="POST">
              <label style="margin-left:20px" for="">Date</label>
                <div style="display:flex;margin: auto 0"class="row">
                  <div class="col-md-9">
                    <div class="form-group">
                      <input type="date" name="reservation_date" class="form-control" placeholder="Date" required="">
                    </div>
                  </div>
                  <div style="margin:auto;" class="form-group">
                    <input type="hidden" name="res_id" value="<?php echo $_GET['res_id']; ?>">
                    <input style="background:#4267B2;color:#fff;" type="submit" name="search_schedule" value="Submit" class="btn btn-primary py-3 px-5">
                  </div>
              </div>  
            </form>
          </div>
        </div>
        <!-- Schedules -->
        <div class="row">
          <div class="col-md-12 dish-menu">
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="row">
                  <?php  
                    $con = connect();
                    // From Manage-insert.php
                    if(isset($_COOKIE['dayhash'])){
                      $sdayhash = $_COOKIE['dayhash'];
                      $sday = $_COOKIE['sday'];
                    }
                    // Select Available Reservation
                    $sql = "SELECT * FROM `restaurant_reservation` WHERE EXISTS (SELECT * FROM `customer_reservation` WHERE `customer_reservation`.reservation_id = `restaurant_reservation`.reservation_id and `customer_reservation`.reservation_status = 'Pending');";
                    $result = $con->query($sql);
                    // Check Chosen Date
                    foreach ($result as $r) {  
                      if(isset($_COOKIE['dayhash'])){
                        if((substr($r['reservation_day_hash'],0,1)==substr($sdayhash,0,1)) && ($sday=='1')){
                          $con = true;
                        } 
                        if((substr($r['reservation_day_hash'],2,1)==substr($sdayhash,2,1)) && ($sday=='2')){
                          $con = true;
                        } 
                        if((substr($r['reservation_day_hash'],4,1)==substr($sdayhash,4,1)) && ($sday=='3')){
                          $con = true;
                        } 
                        if((substr($r['reservation_day_hash'],6,1)==substr($sdayhash,6,1)) && ($sday=='4')){
                          $con = true;
                        } 
                        if((substr($r['reservation_day_hash'],8,1)==substr($sdayhash,8,1)) && ($sday=='5')){
                          $con = true;
                        } 
                        if((substr($r['reservation_day_hash'],10,1)==substr($sdayhash,10,1)) && ($sday=='7')){
                          $con = true;
                        } 
                        if((substr($r['reservation_day_hash'],12,1)==substr($sdayhash,12,1)) && ($sday=='0')){
                          $con = true;
                        } 
                      }
                        if($con or !isset($_COOKIE['dayhash'])) {
                        // Design Schedules
                        ?>
                          <div class="col-lg-12">
                              <div class="menus d-flex">
                              <div style="margin: auto;width:100%" class="text d-flex py-5">
                                <div class="row">
                                  <div class="row one-half my-1">
                                      <div class="col-lg-6">
                                        <h3>Reservation ID: <?php echo $r['reservation_id']; ?></h3>
                                      </div>
                                      <div class="col-lg-6">
                                          <h3>Available Days: 
                                            <?php //Output Available Days from Hash
                                              $days = "N/A";
                                              if((substr($r['reservation_day_hash'],0,1)=='2')){
                                                $days = "Monday";
                                                $con = true;
                                              } 
                                              if((substr($r['reservation_day_hash'],2,1)=='2')){
                                                if(!$con){
                                                  $days .= " - Tuesday";
                                                  $con = true;
                                                }
                                                else {
                                                  $days = "Tuesday"; 
                                                  $con = false;
                                                }
                                              } 
                                              if((substr($r['reservation_day_hash'],4,1)=='2')){
                                                if(!$con){
                                                  $days .= " - Wednesday";
                                                  $con = true;
                                                }
                                                else {
                                                  $days = "Wednesday"; 
                                                  $con = false;
                                                }
                                              } 
                                              if((substr($r['reservation_day_hash'],6,1)=='2')){
                                                if(!$con){
                                                  $days .= " - Thursday";
                                                  $con = true;
                                                }
                                                else {
                                                  $days = "Thursday"; 
                                                  $con = false;
                                                }
                                              } 
                                              if((substr($r['reservation_day_hash'],8,1)=='2')){
                                                if(!$con){
                                                  $days .= " - Friday";
                                                  $con = true;
                                                }
                                                else {
                                                  $days = "Friday"; 
                                                  $con = false;
                                                }
                                              } 
                                              if((substr($r['reservation_day_hash'],10,1)=='2')){
                                                if(!$con){
                                                  $days .= " - Saturday";
                                                  $con = true;
                                                }
                                                else {
                                                  $days = "Saturday"; 
                                                  $con = false;
                                                }
                                              } 
                                              if((substr($r['reservation_day_hash'],12,1)=='2')){
                                                if(!$con){
                                                  $days .= " - Sunday";
                                                  $con = true;
                                                }
                                                else {
                                                  $days = "Sunday"; 
                                                  $con = false;
                                                }
                                              }
                                              echo "$days"; ?></h3>
                                      </div>
                                    </div>
                                    <div class="row one-half my-1">
                                      <div class="col-lg-6">
                                        <h3>Reservation Start Time: <?php echo $r['reservation_time_start']; ?></h3>
                                      </div>
                                      <div class="col-lg-6">
                                          <h3>Reservation End Time: <?php echo $r['reservation_time_end']; ?></h3>
                                      </div>
                                    </div>
                                    <div class="row one-half my-1">
                                      <div class="col-lg-6">
                                        <h3>Max Party Number Allowed: <?php echo $r['reservation_max_party']; ?></h3>
                                      </div>
                                      <div class="col-lg-6">
                                          <h3>Table Details: <?php echo $r['reservation_name']; ?></h3>
                                      </div>
                                    </div>
                                    <div class="row one-half mt-1">
                                      <a href="reservation.php?res_id=<?php echo $r['id']; ?>" class="btn btn-info" style="margin-left: auto;">Select Schedule</a>
                                    </div>
                                </div>
                              </div>
                              </div>
                          </div>
                        <?php }// End of Checking Selected Date
                      } // End of for Loop for checking schedules
                      ?>
              </div><!-- END -->
            </div>
          </div>
        </div>
      </div>
