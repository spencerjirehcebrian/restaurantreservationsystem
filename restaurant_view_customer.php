<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Current Reservations</title>
  </head>
  <?php
  require_once "php_functions.php";
  initializeSession("restaurant");
  include "template/header.php";
  ?>

  <body>
  <?php include "template/res-dark-nav-bar.php"; ?>
      <div>
        <div class="text-center heading-section ftco-animate">
          <br>
      <h2><?php echo $_SESSION["session_username"]; ?>'s</h2>
        <h3>Reservation Schedules</h3>
        <p>Actively In Use</p>
      </div>

    <?php
    require_once "config_databases.php";
    require_once "php_functions.php";

    if (!isset($_SESSION["session_cust_status"])) {
        $_SESSION["session_cust_mode"] = "default";
    }

    if (isset($_GET["redirectToModify"])) {
        $temp_mod_sched_id = $_GET["var"];
        openReservationDetailsrestaurantMod($temp_mod_sched_id);
    }

    if (!isset($_GET['$temp_filter'])) {
        $temp_filter = "all";
    }

    if (isset($_GET["filterCurrentReservation"])) {
        $temp_filter = $_GET["var"];
    }

    if (isset($_GET["redirectToRestaurantDeny"])) {
        $temp_mod_sched_id = $_GET["var"];
        $temp_reservation_status = "Denied";
        $sql =
            "UPDATE customer_reservation SET reservation_status=? WHERE customer_res_id=?";
        if ($stmt = $mysql->prepare($sql)) {
            $stmt->bind_param(
                "ss",
                $temp_reservation_status,
                $temp_mod_sched_id
            );
            $stmt->execute();
            echo "<script>alert('Reservation Schedule Denied);</script>";
        } else {
            echo "<script>alert('Reservation Schedule Denied Failed);</script>";
            $stmt->close();
        }
        $stmt->close();
    }

    if (isset($_GET["redirectToRestaurantApprove"])) {
        $temp_mod_sched_id = $_GET["var"];
        $temp_reservation_status = "Reserved";
        $sql =
            "UPDATE customer_reservation SET reservation_status=? WHERE customer_res_id=?";
        if ($stmt = $mysql->prepare($sql)) {
            $stmt->bind_param(
                "ss",
                $temp_reservation_status,
                $temp_mod_sched_id
            );
            $stmt->execute();
            echo "<script>alert('Reservation Schedule Approved);</script>";
        } else {
            echo "<script>alert('Reservation Schedule Approval Failed);</script>";
            $stmt->close();
        }
        $stmt->close();
    }

    if (isset($_GET["redirectToRestaurantCancel"])) {
        $temp_mod_sched_id = $_GET["var"];
        $temp_reservation_status = "Cancelled";
        $sql =
            "UPDATE customer_reservation SET reservation_status=? WHERE customer_res_id=?";
        if ($stmt = $mysql->prepare($sql)) {
            $stmt->bind_param(
                "ss",
                $temp_reservation_status,
                $temp_mod_sched_id
            );
            $stmt->execute();
            echo "<script>alert('Reservation Schedule Deleted);</script>";
        } else {
            echo "<script>alert('Reservation Schedule Deletion Failed);</script>";
            $stmt->close();
        }
        $stmt->close();
    }

    if (isset($_GET["redirectToRestaurantComplete"])) {
        $temp_mod_sched_id = $_GET["var"];
        $sql = "DELETE FROM customer_reservation WHERE customer_res_id=?";
        if ($stmt = $mysql->prepare($sql)) {
            $stmt->bind_param("s", $temp_mod_sched_id);
            $stmt->execute();
            echo "<script>alert('Reservation Schedule Complete);</script>";
        } else {
            echo "<script>alert('Reservation Schedule Complete Failed);</script>";
            $stmt->close();
        }
        $stmt->close();
    }
    ?>
    <div class= "rounded container ftco-animate">
    <div class= "container border border-secondary rounded text-secondary" >
        <br>
    <div class="row d-flex justify-content-center">
    <div class="col-3"><?php echo '<a class="btn btn-outline-secondary" href="restaurant_view_customer.php?filterCurrentReservation=true&var=Reserved" role="button">Filter by Aproved Reservations</a>'; ?></div>

    <div class="col-3"><?php echo '<a class="btn btn-outline-secondary" href="restaurant_view_customer.php?filterCurrentReservation=true&var=Denied" role="button">Filter by Denied Reservations</a>'; ?></div>
    </div>
    <br>
    <div class="row d-flex justify-content-center">
    <div class="col-3"><?php echo '<a class="btn btn-outline-secondary" href="restaurant_view_customer.php?filterCurrentReservation=true&var=Cancelled" role="button">Filter by Canceled Reservations</a>'; ?></div>
    <div class="col-3"><?php echo '<a class="btn btn-outline-secondary" href="restaurant_view_customer.php?filterCurrentReservation=true&var=Pending" role="button">Filter by Pending Reservations</a>'; ?></div>
    </div>
    <br>
    <div class="row d-flex justify-content-center">
    <div class="col-3"><?php echo '<a class="btn btn-outline-secondary" href="restaurant_view_customer.php?filterCurrentReservation=true&var=all" role="button">Filter by All Active Reservations</a>'; ?></div>
      </div>
        <br>
        </div>
        <?php
        $var_session_id = trim($_SESSION["session_id"]);
        //Verification of Reserved or Unreserved Schedule
        if ($temp_filter == "all") {
            $sql = "SELECT * FROM customer_reservation
    INNER JOIN restaurant_reservation
    ON customer_reservation.reservation_id = restaurant_reservation.reservation_id
    INNER JOIN restaurant_details
    ON customer_reservation.restaurant_id = restaurant_details.restaurant_id
    INNER JOIN customer_account
    ON customer_reservation.customer_id = customer_account.customer_id
    WHERE customer_reservation.restaurant_id=?";
        } else {
            $sql = "SELECT * FROM customer_reservation
    INNER JOIN restaurant_reservation
    ON customer_reservation.reservation_id = restaurant_reservation.reservation_id
    INNER JOIN restaurant_details
    ON customer_reservation.restaurant_id = restaurant_details.restaurant_id
    INNER JOIN customer_account
    ON customer_reservation.customer_id = customer_account.customer_id
    WHERE customer_reservation.restaurant_id=? and customer_reservation.reservation_status=?";
        }
        if ($stmt = $mysql->prepare($sql)) {
            if ($temp_filter == "all") {
                $stmt->bind_param("s", $var_session_id);
            } else {
                $stmt->bind_param("ss", $var_session_id, $temp_filter);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="rounded container ftco-animate">';
                    echo "<br>";
                    echo '<div class="container bg-light border border-secondary rounded text-secondary">';
                    echo "<br>";
                    echo '<div class="row">';
                    echo '<div class="col" align="center">';

                    //echo '<div class="item border border-primary rounded">';
                    echo "<b>Reservation Number: </b>" .
                        $row["customer_res_id"] .
                        "<br><b>Restaurant Reservation ID: </b>" .
                        $row["reservation_id"] .
                        //"<br><b>Customer ID: </b>".$row["customer_id"].
                        "<br><b>Customer Name: </b>" .
                        $row["customer_username"];
                    echo "</div>";
                    echo '<div class="col" align="center">';
                    echo //"<b>Restaurant ID: </b>" . $row["restaurant_id"].
                        //"<br><b>Restaurant Name: </b>" . $row["restaurant_displayname"].
                        "<b>Reservation Date: </b>" .
                            $row["reservation_date"] .
                            "<br><b>Reservation Time Schedule: </b>" .
                            $row["reservation_time_start"] .
                            "-" .
                            $row["reservation_time_end"];
                    echo "</div>";
                    echo '<div class="col" align="center">';
                    echo "<b>Customer Party: </b>" .
                        $row["customer_party"] .
                        "<br><b>Reservation Status: </b>" .
                        $row["reservation_status"] .
                        "<br><b>Reservation Name/Detail: </b>" .
                        $row["reservation_name"];

                    echo "</div>";

                    echo '<div class="col" align="center">';

                    if ($row["reservation_status"] == "Pending") {
                        echo '<a class="btn btn-outline-primary" href="restaurant_view_customer.php?redirectToRestaurantApprove=true&var=' .
                            $row["customer_res_id"] .
                            '" role="button">Approve Reservation Request</a>';
                        echo '<br><br><a class="btn btn-outline-danger" href="restaurant_view_customer.php?redirectToRestaurantDeny=true&var=' .
                            $row["customer_res_id"] .
                            '" role="button">Deny Reservation Request</a>';
                    } elseif ($row["reservation_status"] == "Denied") {
                        echo '<a class="btn btn-outline-primary" href="restaurant_view_customer.php?redirectToRestaurantApprove=true&var=' .
                            $row["customer_res_id"] .
                            '" role="button">Approve Reservation Request</a>';
                    } elseif ($row["reservation_status"] == "Reserved") {
                        echo '<a class="btn btn-outline-primary" href="restaurant_view_customer.php?redirectToRestaurantComplete=true&var=' .
                            $row["customer_res_id"] .
                            '" role="button">Complete Reservation</a>';
                        echo '<br><br><a class="btn btn-outline-danger" href="restaurant_view_customer.php?redirectToRestaurantCancel=true&var=' .
                            $row["customer_res_id"] .
                            '" role="button">Cancel Reservation</a>';
                    }
                    echo "</div>";
                    echo "<br>";
                    echo "</div>";
                    echo "<br>";
                    echo "</div>";
                    echo "</div>";
                }
                $stmt->close();
            } else {
                echo '<div align="center">';
                echo "<br>No Reservations Found<br>";
                echo "</div>";
                $stmt->close();
            }
        }
        ?>
    <br>
        <div class="text-center ftco-animate">
     <a href="restaurant_home.php" class="btn btn-danger">Back</a>
    </div>
    <br>
    <br>
      </div>


  </body>

        <?php include "template/instagram.php"; ?>

        <?php include "template/footer.php"; ?>

        <?php include "template/script.php"; ?>

</html>
