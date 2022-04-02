<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<title>View Restaurants</title>
</head>
<?php
require_once "php_functions.php";
initializeSession("customer");
include "template/header.php";
?>
<body>
<?php include "template/dark-nav-bar.php"; ?>

      <div class="text-center heading-section ftco-animate">
        <br>
        <h2>Availiable Restaurants</h2>
        <p></p>
      </div>

  <?php
  require_once "config_databases.php";
  require_once "php_functions.php";

  if (!isset($_SESSION["session_cust_status"])) {
      $_SESSION["session_cust_mode"] = "default";
  }

  if (isset($_GET["redirectToDetails"])) {
      $temp_add_cust_sched_id = $_GET["var"];
      $temp_add_cust_sched_name = $_GET["var1"];
      openrestaurantDetails(
          $temp_add_cust_sched_id,
          $temp_add_cust_sched_name
      );
  }

  if (isset($_GET["redirectToSched"])) {
      $temp_add_cust_sched_id = $_GET["var"];
      $temp_add_cust_sched_name = $_GET["var1"];
      openrestaurantSched($temp_add_cust_sched_id, $temp_add_cust_sched_name);
  }

  $sql = "SELECT * FROM restaurant_details";
  if ($stmt = $mysql->prepare($sql)) {
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="rounded container ftco-animate">';
              echo "<br>";
              echo '<div class="container bg-light border border-secondary rounded text-secondary">';
              echo "<br>";
              echo '<div class="col" align="center">';
              //echo '<div class="item border border-primary rounded">';
              echo "<b>Restaurant Name: </b><h2>" .
                  $row["restaurant_displayname"] .
                  "</h2>" .
                  "<b>Address: </b>" .
                  $row["restaurant_address"];
              echo "<br><b>Details: </b>" . $row["restaurant_infosummary"];
              echo "</div>";
              echo '<div class="row">';
              echo '<div class="col" align="center"><br>';
              echo '<a class="btn btn-outline-primary" href="customer_view_restaurant.php?redirectToSched=true&var=' .
                  $row["restaurant_id"] .
                  "&var1=" .
                  $row["restaurant_displayname"] .
                  '" role="button">Select for Reservation</a>';
              echo "</div>";
              echo '<div class="col" align="center"><br>';
              echo '<a class="btn btn-outline-primary" href="customer_view_restaurant.php?redirectToDetails=true&var=' .
                  $row["restaurant_id"] .
                  "&var1=" .
                  $row["restaurant_displayname"] .
                  '" role="button">Open Restaurant Details</a>';
              echo "</div>";
              echo "</div>";
              echo "<br>";
              echo "</div>";
              echo "<br>";
              echo "</div>";
              echo "</div>";
          }
          $stmt->close();
      } else {
          echo "Error:DatabaseEmpty/Missing";
          $stmt->close();
      }
  }
  ?>
</body>

    <?php include "template/footer.php"; ?>

    <?php include "template/script.php"; ?>
</html>
