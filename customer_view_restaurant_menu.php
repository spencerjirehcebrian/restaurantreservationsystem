<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
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
    <h2><?php echo $_SESSION["session_cust_restaurant_name"] . "'s"; ?></h2>
      <h3>Restaurant Menu</h3>

    <?php
    require_once "config_databases.php";

    if (!isset($_SESSION["session_cust_status"])) {
        $_SESSION["session_cust_mode"] = "default";
    }

    if (isset($_GET["redirectToSched"])) {
        $temp_add_cust_sched_id = $_GET["var"];
        $temp_add_cust_sched_name = $_GET["var1"];
        openrestaurantSched($temp_add_cust_sched_id, $temp_add_cust_sched_name);
    }

    $sql = "SELECT * FROM restaurant_menu WHERE restaurant_id=?";
    if ($stmt = $mysql->prepare($sql)) {
        $temp_restaurant_id = trim($_SESSION["session_cust_restaurant_id"]);
        $temp_restaurant_name = trim($_SESSION["session_cust_restaurant_name"]);
        $stmt->bind_param("s", $temp_restaurant_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="rounded container ftco-animate">';
                echo '<div class="container bg-light border border-secondary rounded text-secondary">';
                echo '<div class="row">';
                echo '<div class="col" align="center">';

                echo "<br><b>Number </b>" .
                    $row["menu_id"] .
                    "<br><b>Name: </b>" .
                    $row["menu_name"] .
                    "<br><b>Details: </b>" .
                    $row["menu_details"] .
                    "<br><b>Price: PHP </b>" .
                    $row["menu_prices"];
            }
            $stmt->close();
        } else {
            echo "Error:DatabaseEmpty/Missing";
            $stmt->close();
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
    <br>
    </div>
    <br>
    <div class="row">';
    <div class="col" align="center">
    <a class="btn btn-outline-primary" href="customer_view_restaurant_menu.php?redirectToSched=true&var=<?php echo $temp_restaurant_id; ?>&var1=<?php echo $temp_restaurant_name; ?>" role="button">See Reservations Schedules</a>
    <br>
    </div>
    <div class="col" align="center">
    <a  class="btn btn-outline-danger" href="customer_view_restaurant_details.php" class="btn btn-danger">Back to Restaurant's Details</a>
    <br>
    </div>
    </div>
    <br>
    </div>



  </body>

  <?php include "template/footer.php"; ?>

  <?php include "template/script.php"; ?>
</html>
