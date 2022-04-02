<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
  </head>
  <?php
  require_once "php_functions.php";
  initializeSession("restaurant");
  include "template/header.php";
  include "template/res-light-nav-bar.php";
  ?>
  <body>

    <?php
    require_once "config_databases.php";

    $var_res_reservation_id = trim(
        $_SESSION["session_restaurant_mod_reservation_id"]
    );
    $sql = "SELECT * FROM restaurant_reservation WHERE reservation_id =?";
    if ($stmt = $mysql->prepare($sql)) {
        $stmt->bind_param("s", $var_res_reservation_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $var_res_time_str = trim($row["reservation_time_start"]);
                    $var_res_time_end = trim($row["reservation_time_end"]);
                    $var_res_details = trim($row["reservation_name"]);
                    $var_res_max_party = trim($row["reservation_max_party"]);
                }
                $stmt->close();
            } else {
                $stmt->close();
            }
        } else {
            echo "Error";
        }
    }

    $item_err1 = $item_err2 = $item_err3 = $item_err4 = $item_err5 = $item_err6 =
        "";
    $var_res_date = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $array_res_date = [1, 1, 1, 1, 1, 1, 1];
        if (!empty($_POST["in_res_date1"])) {
            $array_res_date[0] = 2;
        }
        if (!empty($_POST["in_res_date2"])) {
            $array_res_date[1] = 2;
        }
        if (!empty($_POST["in_res_date3"])) {
            $array_res_date[2] = 2;
        }
        if (!empty($_POST["in_res_date4"])) {
            $array_res_date[3] = 2;
        }
        if (!empty($_POST["in_res_date5"])) {
            $array_res_date[4] = 2;
        }
        if (!empty($_POST["in_res_date6"])) {
            $array_res_date[5] = 2;
        }
        if (!empty($_POST["in_res_date7"])) {
            $array_res_date[6] = 2;
        }
        $var_res_date = implode("-", $array_res_date);
        if ($var_res_date == "1-1-1-1-1-1-1") {
            $item_err1 = "Please Select a Day";
        }

        if (empty(trim($_POST["in_res_time_str"]))) {
            $item_err2 = "Empty Field";
        } else {
            $var_res_time_str = trim($_POST["in_res_time_str"]);
        }

        if (empty(trim($_POST["in_res_time_end"]))) {
            $item_err3 = "Empty Field";
        } else {
            $var_res_time_end = trim($_POST["in_res_time_end"]);
        }

        if (empty(trim($_POST["in_res_details"]))) {
            $item_err4 = "Empty Field";
        } else {
            $var_res_details = trim($_POST["in_res_details"]);
        }

        if (empty(trim($_POST["in_res_max_party"]))) {
            $item_err5 = "Empty Field";
        } else {
            if (trim($_POST["in_res_max_party"]) <= 0) {
                $item_err5 = "Must be a Proper Number";
            } else {
                $var_res_max_party = trim($_POST["in_res_max_party"]);
            }
            $var_res_max_party = trim($_POST["in_res_max_party"]);
        }

        //Enter to SQLDatabase
        if (
            empty($item_err2) &&
            empty($item_err3) &&
            empty($item_err4) &&
            empty($item_err5) &&
            empty($item_err6)
        ) {
            $sql =
                "UPDATE restaurant_reservation SET reservation_day_hash=?, reservation_time_start=?, reservation_time_end=?, reservation_name=?, reservation_max_party=?  WHERE reservation_id=?";
            if ($stmt = $mysql->prepare($sql)) {
                $stmt->bind_param(
                    "ssssss",
                    $var_res_date,
                    $var_res_time_str,
                    $var_res_time_end,
                    $var_res_details,
                    $var_res_max_party,
                    $var_res_reservation_id
                );
                if ($stmt->execute()) {
                    $page = $_SERVER["PHP_SELF"];
                    echo "<script>alert('Reservation Schedule Entry Created Successfully');</script>";
                    echo "<script type='text/javascript'>
            window.location.href = 'restaurant_view_schedules.php';
            </script>";
                } else {
                    echo "<script>alert('Reservation Schedule Entry Failed);</script>";
                    header("Refresh:0; $page");
                }
                $stmt->close();
            }
        } else {
            echo "<script>alert('Empty Value: Please Try Again');</script>";
        }
    }
    ?>


            <div>
      <!-- END nav -->

      <section class="home-slider owl-carousel" style="height: 400px;">
        <div class="slider-item" style="background-image: url('images/restodetbg2.jpg');" data-stellar-background-ratio="0.5">
          <div class="overlay"></div>
          <div class="container">
            <div class="row slider-text align-items-center justify-content-center">
              <div class="col-md-10 col-sm-12 ftco-animate text-center" style="padding-bottom: 25%;">

                <h1 class="mb-3">Modify Reservation Infromation</h1>
              </div>
            </div>
          </div>
        </div>
      </section>


      <section class="ftco-section bg-light">
        <div class="container">
          <div class="row justify-content-center mb-5 pb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">

                <div class="text-center heading-section ftco-animate">
                  <br>
              <h2><?php echo $_SESSION["session_username"]; ?>'s</h2>
                <h3>Modify Reservation Details</h3>
                <p>Options</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 dish-menu">



              <!--register as customer-->
              <div class="tab-content py-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                  <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                      <div class="menus d-flex ftco-animate" style="background: white;">
                        <div class="row" style="width: 100%">
                    <div class="col-md-12">



                          <form action="<?php echo htmlspecialchars(
                              $_SERVER["PHP_SELF"]
                          ); ?>" method="POST">

                            <div class="form-group <?php echo !empty($item_err4)
                                ? "has-error"
                                : ""; ?> ">
                              <label>Reservation Name/Details:</label>
                              <textarea id="in_res_details_id" name="in_res_details" required="" placeholder="Reservation Name/Details:" class="form-control" rows="4" cols="50" value="<?php echo $var_res_details; ?>"><?php echo $var_res_details; ?></textarea>
                              <span class="help-block"><?php echo $item_err4; ?></span>
                            </div>

                            <div class="form-group <?php echo !empty($item_err1)
                                ? "has-error"
                                : ""; ?> ">
                              <label>Reservation Days Avaliable:</label><br>
                              <input class="form-group" type="checkbox" id="weekday-mon" name="in_res_date1" class="form-check" />
                              <label for="weekday-mon">Monday</label><br>
                              <input class="form-group" type="checkbox" id="weekday-tue" name="in_res_date2" class="form-check" />
                              <label for="weekday-tue">Tuesday</label><br>
                              <input class="form-group" type="checkbox" id="weekday-wed" name="in_res_date3" class="form-check" />
                              <label for="weekday-wed">Wednesday</label><br>
                              <input class="form-group" type="checkbox" id="weekday-thu" name="in_res_date4" class="form-check" />
                              <label for="weekday-thu">Thursday</label><br>
                              <input class="form-group" type="checkbox" id="weekday-fri" name="in_res_date5" class="form-check" />
                              <label for="weekday-fri">Friday</label><br>
                              <input class="form-group" type="checkbox" id="weekday-sat" name="in_res_date6" class="form-check" />
                              <label for="weekday-sat">Saturday</label><br>
                              <input class="form-group" type="checkbox" id="weekday-sun" name="in_res_date7" class="form-check" />
                              <label for="weekday-sun">Sunday</label><br>
                              <span class="help-block"><?php echo $item_err1; ?></span>
                            </div>

                            <div class="form-group <?php echo !empty($item_err2)
                                ? "has-error"
                                : ""; ?> ">
                              <label>Reservation Time Start:</label>
                              <input type="time" name="in_res_time_str" class="form-control" required="" placeholder="00:00" value="<?php echo $var_res_time_str; ?>">
                            </div>

                            <div class="form-group <?php echo !empty($item_err3)
                                ? "has-error"
                                : ""; ?> ">
                              <label>Reservation Time End:</label>
                              <input type="time" name="in_res_time_end" class="form-control" required="" placeholder="00:00" value="<?php echo $var_res_time_end; ?>">
                            </div>



                              <div class="form-group <?php echo !empty(
                                  $item_err4
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <label>Max Party Members Allowed:</label>
                                <input type="number" name="in_res_max_party" class="form-control"  required="" placeholder="Max Party Numbers Allowed" value="<?php echo $var_res_max_party; ?>">
                              </div>


                            <div style="display:flex;"  class="form-group">
                              <input style="margin:auto;" type="submit" class="btn btn-primary py-3 px-5" value="Save">
                              <a href="restaurant_home.php" style="margin:auto;" class="btn btn-danger py-3 px-5">Back</a>
                            </div>
                        </form>

                    </div>
                </div>
                    </div>
                    </div>
                  </div>
                </div><!-- END -->


                <!-- END -->
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php include "template/instagram.php"; ?>

      <?php include "template/footer.php"; ?>

      <?php include "template/script.php"; ?>
  </body>
</html>
