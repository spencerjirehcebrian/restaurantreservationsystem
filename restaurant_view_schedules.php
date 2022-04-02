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
        <?php include "template/dark-nav-bar.php"; ?>
  <body>

    <div>
      <div class="text-center heading-section ftco-animate">
        <br>
    <h2><?php echo $_SESSION["session_username"]; ?>'s</h2>
      <h3>Restaurant Schedules</h3>
      <p>View and Modify</p>


    <?php
    require_once "config_databases.php";
    require_once "php_functions.php";

    if (isset($_GET["redirectToModSched"])) {
        $temp_mod_sched_id = $_GET["var"];
        modifySchedDetails($temp_mod_sched_id);
    }

    if (isset($_GET["redirectToDeleteSched"])) {
        $temp_mod_sched_id = $_GET["var"];
        $sql = "DELETE FROM restaurant_reservation WHERE reservation_id=?";
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

    $var_restaurant_id = trim($_SESSION["session_id"]);
    $sql = "SELECT * FROM restaurant_reservation WHERE restaurant_id=?";
    if ($stmt = $mysql->prepare($sql)) {
        $stmt->bind_param("s", $var_restaurant_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $day_unhash = dayUnhash($row["reservation_day_hash"]);
                $temp_mod_sched_id = $row["reservation_id"];
                echo '<div class="rounded container ftco-animate">';
                echo "<br>";
                echo '<div class="container bg-light border border-secondary rounded text-secondary">';
                echo "<br>";
                echo '<div class="row">';
                echo '<div class="col" align="center">';
                //echo '<div class="item border border-primary rounded">';
                echo "<b>Reservation ID: </b>" .
                    $row["reservation_id"] .
                    "<br><b>Days Availiable: </b>" .
                    $day_unhash .
                    "<br><b>Time Start: </b>" .
                    $row["reservation_time_start"];
                echo "<br><b>Time End: </b>" .
                    $row["reservation_time_end"] .
                    "<br><b>Max Party Number Allowed: </b>" .
                    $row["reservation_max_party"] .
                    "<br><b>Reservation Name and Details: </b>" .
                    $row["reservation_name"];
                echo "</div>";
                echo "</div>";
                echo '<div class="row">';
                echo '<div class="col" align="center">';
                echo '<br><a class="btn btn-outline-primary" href="restaurant_view_schedules.php?redirectToModSched=true&var=' .
                    $row["reservation_id"] .
                    '" role="button">Edit Schedule</a>';
                echo ' <a class="btn btn-outline-danger" href="restaurant_view_schedules.php?redirectToDeleteSched=true&var=' .
                    $row["reservation_id"] .
                    '" role="button">Delete Schedule</a>';
                //echo '<br><input class="btn btn-outline-secondary" type="button" value="Edit Schedule">';
                echo "</div>";
                echo "<br>";
                echo "</div><br>";
                echo "</div>";
                echo "</div>";
            }
            $stmt->close();
        } else {
            echo "No Schedules Found<br>";
            $stmt->close();
        }
    }
    echo "</div>";
    echo '<div class="row">';
    echo '<div class="col" align="center">';
    ?>
    <br>
      <div style="display:flex;"  class="form-group">
    <a href="restaurant_add_schedules.php" style="margin:auto;" type="submit" class="btn btn-primary py-3 px-5" >Add Schedule</a> <a href="restaurant_home.php" style="margin:auto;" type="submit" class="btn btn-danger py-3 px-5" >Back</a>
    </div>
        <br>
    </div>
    </div>
    </div>

    <?php include "template/instagram.php"; ?>

    <?php include "template/footer.php"; ?>

    <?php include "template/script.php"; ?>
  </body>
</html>
