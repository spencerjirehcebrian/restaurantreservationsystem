<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Reservation Schedules</title>

  </head>
  <?php
  require_once "php_functions.php";
  initializeSession("restaurant");
  include "template/header.php";
  ?>
        <?php include "template/res-dark-nav-bar.php"; ?>
  <body>

    <div>
      <div class="text-center heading-section ftco-animate">
        <br>
    <h2><?php echo $_SESSION["session_username"]; ?>'s</h2>
      <h3>Restaurant Menu</h3>
      <p>Actively Displayed</p>
    </div>


    <?php
    require_once "config_databases.php";
    require_once "php_functions.php";

    if (isset($_GET["redirectToModMenu"])) {
        $temp_mod_menu_id = $_GET["var"];
        modifyMenuDetails($temp_mod_menu_id);
    }

    if (isset($_GET["redirectToAddMenu"])) {
        addMenuDetails();
    }

    if (isset($_GET["redirectToDeleteMenu"])) {
        $temp_mod_menu1_id = $_GET["var"];
        $sql1 = "DELETE FROM restaurant_menu WHERE menu_id=?";
        if ($stmt1 = $mysql->prepare($sql1)) {
            $stmt1->bind_param("s", $temp_mod_menu1_id);
            $stmt1->execute();
            echo "<script>alert('Reservation Schedule Deleted);</script>";
        } else {
            echo "<script>alert('Reservation Schedule Deletion Failed);</script>";
            $stmt1->close();
        }
        $stmt1->close();
    }

    $var_restaurant_id = trim($_SESSION["session_id"]);
    $sql = "SELECT * FROM restaurant_menu WHERE restaurant_id=?";
    if ($stmt = $mysql->prepare($sql)) {
        $stmt->bind_param("s", $var_restaurant_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $temp_mod_sched_id = $row["menu_id"];
                echo '<div class="rounded container ftco-animate">';
                echo "<br>";
                echo '<div class="container bg-light border border-secondary rounded text-secondary">';
                echo '<div class="row">';
                echo '<div class="col" align="center">';
                //echo '<div class="item border border-primary rounded">';
                echo "<br><b> " . $row["menu_name"] . "</b>";
                echo "<br>" .
                    $row["menu_details"] .
                    "<br><b>Price: " .
                    $row["menu_prices"] .
                    "</b>";
                echo "</div>";
                echo "</div>";
                echo '<div class="row">';
                echo '<div class="col" align="center">';
                echo '<br><a class="btn btn-outline-primary" href="restaurant_view_menu.php?redirectToModMenu=true&var=' .
                    $row["menu_id"] .
                    '" role="button">Edit Item</a>';
                echo ' <a class="btn btn-outline-danger" href="restaurant_view_menu.php?redirectToDeleteMenu=true&var=' .
                    $row["menu_id"] .
                    '" role="button">Delete Item</a>';
                echo "</div>";
                echo "</div>";
                echo "<br>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                //echo '<br><input class="btn btn-outline-secondary" type="button" value="Edit Schedule">';
            }
            $stmt->close();
        } else {
            echo "No Menu Found<br>";
            $stmt->close();
        }
    }

    echo "<br>";
    echo '<div class="row">';
    echo '<div class="col" align="center">';
    ?>
    <div style="display:flex;"  class="form-group">
    <a href="restaurant_view_menu.php?redirectToAddMenu=true" style="margin:auto;" class="btn btn-primary py-3 px-5" >Add Item</a> <a href="restaurant_home.php" style="margin:auto;"  class="btn btn-danger py-3 px-5" >Back</a>
    </div>
    </div>
      </div>
        </div>
        <br>


        <?php include "template/instagram.php"; ?>

        <?php include "template/footer.php"; ?>

        <?php include "template/script.php"; ?>
  </body>
</html>
