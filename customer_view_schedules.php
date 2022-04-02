<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>View Open Reservation Schedules</title>
</head>
<?php
require_once "php_functions.php";
initializeSession("customer");
include "template/header.php";
?>
<body>
  <?php
  include "template/dark-nav-bar.php";
  $item_err = "";
  require_once "php_functions.php";
  ?>

    <div>
      <div class="text-center heading-section ftco-animate">
        <br>
      <h2><?php echo $_SESSION["session_cust_restaurant_name"]; ?></h2>
      <h3>Reservation Schedules</h3>
      <p>Search by Date</p>
    </div>
<form action="<?php echo htmlspecialchars(
    $_SERVER["PHP_SELF"]
); ?>" method="POST">
    <div class="form-group <?php echo !empty($item_err)
        ? "has-error"
        : ""; ?> ">
      <div class="row">
      <label></label>
      <div class="col" align="">
      <input type="date" name="in_alres_date" class="form-control" value="<?php echo $var_alres_date; ?>">
      </div>
      <input type="submit" class="btn btn-primary py-2 px-5" value="Search">
      </div>
      </div>
      <!--<p> <a class="btn btn-outline-primary" href="customer_view_schedules.php?filterDate=true&var=<?php
//echo $var_alres_date
?>" role="button">Search</a></p>-->
    </div>
  </form>

    <?php
    require_once "config_databases.php";

    if (!isset($_SESSION["session_cust_status"])) {
        $_SESSION["session_cust_status"] = "default";
    }

    if (!isset($_POST["in_alres_date"]) && empty($temp_date) == true) {
        $_POST["in_alres_date"] = date("Y-m-d");
        $temp_date = $_POST["in_alres_date"];
    }
    $temp_date = $_POST["in_alres_date"];
    $var_restaurant_id = $_SESSION["session_cust_restaurant_id"];

    $sql = "SELECT * FROM restaurant_reservation
      WHERE restaurant_id=?";

    if ($stmt = $mysql->prepare($sql)) {
        $stmt->bind_param("s", $var_restaurant_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $timestamp = strtotime($temp_date);
        $day = date("D", $timestamp);
        $availSched = false;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $day_unhash = dayUnhash($row["reservation_day_hash"]);
                $day_hashed = trim($row["reservation_day_hash"]);
                $temp_mod_sched_id = $row["reservation_id"];
                if (!empty($temp_date)) {
                    if (dayHashCompare($day, $day_hashed) === true) {
                        echo '<div class="rounded container ftco-animate">';
                        echo '<div class="container bg-light border border-secondary rounded text-secondary">';
                        echo "<br>";
                        echo '<div class="row">';
                        echo '<div class="col" align="center">';
                        //echo '<div class="item border border-primary rounded">';
                        echo "<b>Reservation ID: </b>" .
                            $row["reservation_id"] .
                            "<br><b>Days Availiable: </b>" .
                            $day_unhash .
                            "<br><b>Time Schedule: </b>" .
                            $row["reservation_time_start"] .
                            " - " .
                            $row["reservation_time_end"] .
                            "<br><b>Max Party Number Allowed: </b>" .
                            $row["reservation_max_party"] .
                            "<br><b>Details: </b>" .
                            $row["reservation_name"];
                        //"<br><b>Reservation Status: </b>" . $row["reservation_status"];
                        $var_reservation_id = $row["reservation_id"];
                        $sql1 = "SELECT * FROM restaurant_reservation
                    INNER JOIN customer_reservation
                    ON customer_reservation.reservation_id = restaurant_reservation.reservation_id
                    WHERE customer_reservation.reservation_id=? and customer_reservation.reservation_date=? ";
                        if ($stmt1 = $mysql->prepare($sql1)) {
                            $stmt1->bind_param(
                                "ss",
                                $var_reservation_id,
                                $temp_date
                            );
                            $stmt1->execute();
                            $result1 = $stmt1->get_result();
                            if ($result1->num_rows > 0) {
                                while ($row1 = $result1->fetch_assoc()) {
                                    if (
                                        $row1["reservation_status"] ==
                                        "Reserved"
                                    ) {
                                        $temp_mod_res_status = "Reserved";
                                    } else {
                                        $temp_mod_res_status = "Unreserved";
                                    }
                                }
                                $availSched = true;
                            } else {
                                //echo "<br><b>Reservation Status: </b>Unreserved";
                                $temp_mod_res_status = "Unreserved";
                            }
                            echo "<br><b>Reservation Status: </b>" .
                                $temp_mod_res_status;
                        }
                        echo "</div>";
                        echo "</div>";
                        echo '<div class="row">';
                        echo '<div class="col" align="center">';
                        echo '<br><a class="btn btn-outline-primary" href="customer_view_schedules.php?redirectToSomewhere=true
                    &var=' .
                            $row["reservation_id"] .
                            "&var1=" .
                            $row["reservation_name"] .
                            "&var2=" .
                            $row["reservation_time_start"] .
                            "&var3=" .
                            $row["reservation_time_end"] .
                            "&var4=" .
                            $row["reservation_day_hash"] .
                            "&var5=" .
                            $row["reservation_max_party"] .
                            "&var6=" .
                            $temp_date .
                            "&var7=" .
                            $temp_mod_res_status .
                            '" role="button">Select</a>';
                        echo "</div>";
                        echo "</div><br>";
                        echo "</div><br>";
                        $availSched = true;
                    }
                }
            }
            $stmt->close();
            $AvailSched = false;
        } else {
            //echo "<script>alert('No Reservations Set At This Date');</script>";
            $stmt->close();
        }
    }

    if (isset($_GET["redirectToSomewhere"])) {
        $temp_mod_sched_id = $_GET["var"];
        $temp_mod_sched_name = $_GET["var1"];
        $temp_mod_sched_time_str = $_GET["var2"];
        $temp_mod_sched_time_end = $_GET["var3"];
        $temp_mod_sched_time_day = $_GET["var4"];
        $temp_mod_sched_party = $_GET["var5"];
        $temp_mod_sched_date = $_GET["var6"];
        $temp_reservation_status = $_GET["var7"];

        if ($temp_reservation_status == "Reserved") {
            echo "<script>alert('Reservation Schedule is Already Booked');</script>";
        } else {
            openReservationDetailsViaSched(
                $temp_mod_sched_id,
                $temp_mod_sched_name,
                $temp_mod_sched_time_str,
                $temp_mod_sched_time_end,
                $temp_mod_sched_time_day,
                $temp_mod_sched_party,
                $temp_mod_sched_date,
                $temp_mod_res_status
            );
        }
    }
    ?>


    <?php  ?>
    <div class="row">
    <div class="col" align="center">
    <a class="btn btn-outline-danger" href="customer_view_restaurant_details.php" role="button">Back to Restaurant Details</a>
    </div>
    </div>
      <br>
    </div>
      </div>


  </body>


  <?php include "template/instagram.php"; ?>

  <?php include "template/footer.php"; ?>

  <?php include "template/script.php"; ?>
</html>
