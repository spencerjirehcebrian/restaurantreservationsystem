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
        <br>
    <h2><?php echo $_SESSION["session_cust_restaurant_name"]; ?></h2>
      <h3>Restaurant Details</h3>
      <p></p>
    </div>

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
    if (isset($_GET["redirectToMenu"])) {
        $temp_add_cust_sched_id = $_GET["var"];
        $temp_add_cust_sched_name = $_GET["var1"];
        openrestaurantMenu($temp_add_cust_sched_id, $temp_add_cust_sched_name);
    }

    $sql = "SELECT * FROM restaurant_details WHERE restaurant_id=?";
    if ($stmt = $mysql->prepare($sql)) {
        $temp_restaurant_id = trim($_SESSION["session_cust_restaurant_id"]);
        $stmt->bind_param("s", $temp_restaurant_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="rounded container ftco-animate">';
                echo '<div class="container bg-light border border-secondary rounded text-secondary">';
                echo "<br>";
                echo '<div class="row">';
                echo '<div class="col" align="center">';

                echo //"<b>Restaurant Name: </b>" .
                    "<h2>" .
                        $row["restaurant_displayname"] .
                        "</h2>" .
                        "<br><b>Address: </b>" .
                        $row["restaurant_address"];
                echo "<br><b>Details: </b>" . $row["restaurant_infosummary"];
                echo "<br><b>About us: </b>" . $row["restaurant_info"];
                //echo "<br><b>Restaurant Menu: </b>" . $row["restaurant_menu"];
                $temp_restaurant_id = $row["restaurant_id"];
                $temp_restaurant_name = $row["restaurant_displayname"];
            }
            $stmt->close();
        } else {
            echo "Error:DatabaseEmpty/Missing";
            $stmt->close();
        }
    }
    ?>


    <div class="row">
    <div class="col" align="center">
    <br>
    <a class="btn btn-outline-primary" href="customer_view_restaurant_details.php?redirectToMenu=true&var=<?php echo $temp_restaurant_id; ?>&var1=<?php echo $temp_restaurant_name; ?>" role="button">Open Restaurant's Menu</a>
    </div>
    <div class="col" align="center">
    <br>
    <a class="btn btn-outline-primary" href="customer_view_restaurant_details.php?redirectToSched=true&var=<?php echo $temp_restaurant_id; ?>&var1=<?php echo $temp_restaurant_name; ?>" role="button">Open Restaurant's Reservations Menu</a>
    </div>
    <div class="col" align="center">
    <br>
    <a class="btn btn-outline-danger" href="customer_view_restaurant.php" role="button">Back to List</a>
    </div>
    </div>
    <br>
    </div>
    <?php
    echo "</div>";
    echo "</div>";
    echo "<br>";
    echo "</div>";
    echo "</div>";
    ?>


  </body>



  <?php include "template/instagram.php"; ?>

  <?php include "template/footer.php"; ?>

  <?php include "template/script.php"; ?>
</html>
