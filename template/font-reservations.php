
      <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section">
            <h3>Manage Reservations</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 dish-menu">

            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="row">
                  <?php  
                    $con = connect();
                    $sql = "SELECT * FROM `restaurant_info` WHERE location;";
                    $result = $con->query($sql);
                    foreach ($result as $r) {
                  ?>
                  <div class="col-lg-12">
                    <div class="menus d-flex">
                      <div class="menu-img" style="background-image: url(dashboard/user-image/<?php echo $r['logo']; ?>)"></div>
                      <div class="text d-flex">
                        <div class="row one-half">
                        	<div class="col-lg-12">
                          	<h3><?php echo $r['restaurent_name']; ?></h3>
                      		</div>
                          <div class="col-lg-12">
                            <p><?php echo $r['address']; ?></p>
                          </div>
                        </div>
                        <div style="margin: 0px 10px" class="one-third">
                        	<a href="check-reservation.php?res_id=<?php echo $r['id']; ?>" class="btn btn-info" style="width: 100%;margin: 18px auto 0px;">Select</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
              </div><!-- END -->
            </div>
          </div>
        </div>
      </div>

<?php include 'template/script.php'; ?>
<script src="dashboard/assets/vendor/jquery/jquery.js"></script>
<script src="dashboard/assets/vendor/select2/select2.js"></script>
<script src="dashboard/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>