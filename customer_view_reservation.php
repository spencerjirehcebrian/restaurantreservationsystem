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
    <?php include "template/dark-nav-bar.php"; ?>
    <div>
      <div class="text-center heading-section ftco-animate">
        <br>
        <h2><?php echo $_SESSION["session_username"]; ?>'s</h2>
        <h3>Manage Reservations</h3>
      </div>

    <?php
    require_once "config_databases.php";
    require_once "php_functions.php";

    if (!isset($_SESSION["session_cust_status"])) {
        $_SESSION["session_cust_mode"] = "default";
    }

    if (isset($_GET["redirectToModify"])) {
        $temp_mod_sched_id = $_GET["var"];
        openReservationDetailsMod($temp_mod_sched_id);
    }

    if (isset($_GET["redirectToDelete"])) {
        $temp_mod_sched_id = $_GET["var"];
        $sql = "DELETE FROM restaurant_reservation WHERE customer_res_id=?";
        if ($stmt = $mysql->prepare($sql)) {
            $stmt->bind_param("s", $temp_mod_sched_id);
            $stmt->execute();
            echo "<script>alert('Reservation Schedule Deleted);</script>";
        } else {
            echo "<script>alert('Reservation Schedule Deletion Failed);</script>";
            $stmt->close();
        }
        $stmt->close();
    }

    $var_session_id = trim($_SESSION["session_id"]);
    $sql = "SELECT * FROM customer_reservation
    INNER JOIN restaurant_reservation
    ON customer_reservation.reservation_id = restaurant_reservation.reservation_id
    INNER JOIN restaurant_details
    ON customer_reservation.restaurant_id = restaurant_details.restaurant_id
    INNER JOIN customer_account
    ON customer_reservation.customer_id = customer_account.customer_id
    WHERE customer_reservation.customer_id=?";
    if ($stmt = $mysql->prepare($sql)) {
        $stmt->bind_param("s", $var_session_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
          <div class= "rounded container ftco-animate">
          <div class= "container bg-light border border-secondary rounded text-secondary">
          <?php
          echo '<br><div class="row">';
          echo '<div class="row">';
          echo '<div class="col  d-flex justify-content-center ">';
          echo //"<b>Reservation Number: </b>" . $row["customer_res_id"].
              //"<br><b>Reservation restaurant ID: </b>".$row["reservation_id"].
              //"<br><b>Customer ID: </b>".$row["customer_id"].
              //"<br><b>Customer Name: </b>" . $row["customer_username"].
              //"<br><b>Restaurant ID: </b>" . $row["restaurant_id"].
              "<br><b>Restaurant Name: </b>" . $row["restaurant_displayname"];
          ?> </div></div></div><div class="row"><div class="col"> <?php echo "<br><b>Reservation Name/Detail: </b>" .
     $row["reservation_name"] .
     "<br><b>Reservation Status: </b>" .
     $row["reservation_status"] .
     "<br><b>Reservation Date: </b>" .
     $row["reservation_date"]; ?> </div><div class="col"> <?php
 echo "<br><b>Reservation Time Start: </b>" .
     $row["reservation_time_start"] .
     "<br><b>Reservation Time End: </b>" .
     $row["reservation_time_end"] .
     "<br><b>Customer Party: </b>" .
     $row["customer_party"];
 echo "</div>";
 echo '<div class="row">';
 echo '<div class="col" align="center">';

 if ($row["reservation_status"] == "Complete") {
     echo ' <a class="btn btn-outline-danger" href="customer_view_reservation.php?redirectToDelete=true&var=' .
         $row["customer_res_id"] .
         '" role="button">Delete Reservation</a>';
 } else {
     echo '<br><a class="btn btn-outline-primary" href="customer_view_reservation.php?redirectToModify=true&var=' .
         $row["customer_res_id"] .
         '" role="button">Modify and Resend Request</a>';
     echo "<br>";
     echo '<br><a class="btn btn-outline-danger" href="customer_view_reservation.php?redirectToDelete=true&var=' .
         $row["customer_res_id"] .
         '" role="button">Cancel Reservation</a>';
 }

 echo "</div>";
 echo "<br>";
 echo "<br>";
 echo "</div>";
 echo "</div><br>";
 echo "</div>";
 echo "</div>";
 }

            $stmt->close();
        } else {
            echo "<br>No Reservations Availiable<br>";
            $stmt->close();
        }
    }
    ?>

     <!--<a href="customer_home.php" class="btn btn-danger">Back</a>-->
</div>






     <?php include "template/footer.php"; ?>

     <?php include "template/script.php"; ?>
   </body>
</html>
