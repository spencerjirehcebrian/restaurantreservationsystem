<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Customer Home</title>
</head>
<?php
require_once "php_functions.php";
initializeSession("customer");
include "template/header.php";
?>
<body>
  <?php include "template/dark-nav-bar.php"; ?>
    <?php
    $_SESSION["session_cust_mode"] = "add";

    require_once "config_databases.php";
    require_once "php_functions.php";
    $var_alres_dispname = $var_alres_max_party = "";
    $item_err1 = $item_err2 = $item_err3 = $item_err4 = $item_err5 = "";

    if (!isset($_SESSION["session_cust_status"])) {
        $_SESSION["session_cust_mode"] = "default";
    }

    if (isset($_GET["redirectToSched"])) {
        $temp_add_cust_sched_id = $_GET["var"];
        $temp_add_cust_sched_name = $_GET["var1"];
        openrestaurantSched($temp_add_cust_sched_id, $temp_add_cust_sched_name);
    }

    if (isset($_GET["redirectToRestaurants"])) {
        $temp_add_cust_status = $_GET["var1"];
        $temp_mod_cust_rest_id = $_GET["var"];
        $var_alres_res_name = "";
        $var_alres_time_str = "";
        $var_alres_time_end = "";
        $var_alres_date = "";
        openrestaurantList($temp_add_cust_status, $temp_mod_cust_rest_id);
    }

    try {
        $var_alres_dispname = trim($_SESSION["session_cust_restaurant_name"]);
        $var_alres_res_name = trim($_SESSION["session_cust_res_name"]);
        $var_alres_time_str = trim($_SESSION["session_cust_res_time_str"]);
        $var_alres_time_end = trim($_SESSION["session_cust_res_time_end"]);
        $var_alres_day = trim($_SESSION["session_cust_res_day"]);
        $temp_restaurant_id = trim($_SESSION["session_cust_restaurant_id"]);
        $temp_restaurant_name = trim($_SESSION["session_cust_restaurant_name"]);
        $temp_customer_id = trim($_SESSION["session_id"]);
        $temp_reservation_id_restaurant = trim(
            $_SESSION["session_cust_res_id"]
        );
        $temp_customer_username = trim($_SESSION["session_username"]);
        $var_alres_date = trim($_SESSION["session_cust_res_date"]);
    } catch (\Exception $e) {
        echo "<script>alert('Variable Loading Error');</script>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["in_alres_dispname"]))) {
            $item_err1 = "Error";
        } else {
            $var_alres_dispname = trim($_POST["in_alres_dispname"]);
        }

        if (empty(trim($_POST["in_alres_res_name"]))) {
            $item_err2 = "Empty Field";
        } else {
            $var_alres_res_name = trim($_POST["in_alres_res_name"]);
        }

        if (empty(trim($_POST["in_alres_time_str"]))) {
            $item_err3 = "Empty Field";
        } else {
            $var_res_time_str = trim($_POST["in_alres_time_str"]);
        }

        if (empty(trim($_POST["in_alres_time_end"]))) {
            $item_err4 = "Empty Field";
        } else {
            $var_res_time_end = trim($_POST["in_alres_time_end"]);
        }

        if (empty(trim($_POST["in_alres_date"]))) {
            $item_err5 = "Empty Field";
        } else {
            $timestamp = strtotime($_POST["in_alres_date"]);
            $day = date("D", $timestamp);
            if (dayHashCompare($day, $var_alres_day) === false) {
                echo "<script>alert('Reservation Not Availiable on this Day');</script>";
                $item_err5 = "Reservation Not Availiable on this Day";
            } else {
                $var_alres_date = trim($_POST["in_alres_date"]);
            }
        }

        if (empty(trim($_POST["in_alres_party"]))) {
            $item_err6 = "Empty Field";
        } else {
            if (
                trim($_POST["in_alres_party"]) <=
                $_SESSION["session_cust_res_max_party"]
            ) {
                if (trim($_POST["in_alres_party"]) <= 0) {
                    $item_err6 = "Must be a Proper Number";
                } else {
                    $var_alres_party = trim($_POST["in_alres_party"]);
                }
            } else {
                echo "<script>alert('Over Party Limit');</script>";
                $item_err6 = "Over Party Limit";
            }
        }

        //Enter to SQLDatabase
        if (
            empty($item_err1) &&
            empty($item_err2) &&
            empty($item_err3) &&
            empty($item_err4) &&
            empty($item_err5) &&
            empty($item_err6)
        ) {
            $sql =
                "INSERT INTO customer_reservation(reservation_id, customer_id, restaurant_id, reservation_date, customer_party, reservation_status) VALUES(?,?,?,?,?,?)";
            if ($stmt = $mysql->prepare($sql)) {
                $temp_reservation_status = "Pending";
                $stmt->bind_param(
                    "ssssss",
                    $temp_reservation_id_restaurant,
                    $temp_customer_id,
                    $temp_restaurant_id,
                    $var_alres_date,
                    $var_alres_party,
                    $temp_reservation_status
                );
                if ($stmt->execute()) {
                    $page = $_SERVER["PHP_SELF"];
                    echo "<script>alert('Reservation Schedule Entry Created Successfully');</script>";
                    echo "<script type='text/javascript'>
            window.location.href = 'customer_home.php';
            </script>";
                } else {
                    echo "<script>alert('Reservation Schedule Entry Failed);</script>";
                    header("Refresh:0; $page");
                }
                $stmt->close();
            }
        } else {
            echo "<script>alert('Reservation Schedule Entry Failed);</script>";
        }
    }
    ?>

    <section style=" background:#E6E6FA; box-shadow:"class="ftco-section justify-content-center bg-light pb-5">
      <div class="container">
        <br>
        <br>
        <br>
        <div class="row  justify-content-center mb-5 pt-1">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2>Your Reservation</h2>
          </div>
        </div>
        <div style="justify-content:center;align-items:center" class="row d-flex">
          <div class="col-md-8 ftco-animate makereservation bg-light">

            <form action="<?php echo htmlspecialchars(
                $_SERVER["PHP_SELF"]
            ); ?>" method="POST">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Restaurant Name</label>
                    <input type="text" name="in_alres_dispname" class="form-control"  placeholder="Restaurant Name"   required="" value="<?php echo $var_alres_dispname; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Reservation Name/Detail</label>
                    <input type="text" name="in_alres_res_name" class="form-control" placeholder="Reservation Name/Detail"  required="" value="<?php echo $var_alres_res_name; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Start Time</label>
                    <input type="text" name="in_alres_time_str" class="form-control" placeholder="00:00" required="" value="<?php echo $var_alres_time_str; ?>" readonly>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">End Time</label>
                    <input type="text" name="in_alres_time_end" class="form-control" placeholder="00:00" required="" value="<?php echo $var_alres_time_end; ?>" readonly>

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Date</label>
                    <input type="date" name="in_alres_date" class="form-control" placeholder="Date" required="" value="<?php echo $var_alres_date; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Number of People/Party Number</label>
                    <input type="number" name="in_alres_party" required="" placeholder="Number of People"  min="1" class="form-control"value="<?php echo $var_alres_max_party; ?>">

                  </div>
                </div>
                <div style="display:flex; flex-wrap:wrap;" class="col-md-12 mt-3">
                  <div style="margin: auto;" class="form-group">
                    <a href="customer_mod_reservation.php?redirectToRestaurants=true&var=<?php echo $temp_restaurant_id; ?>&var1=add" class="btn btn-info py-3 px-5" style="width: 100%;">Change Restaurant</a>
                  </div>
                  <div style="margin: auto;" class="form-group">
                    <a href="customer_add_reservation.php?redirectToSched=true&var=<?php echo $temp_restaurant_id; ?>&var1=<?php echo $temp_restaurant_name; ?>" class="btn btn-info py-3 px-5" style="width: 100%;">Change Schedule</a>
                  </div>
                  <div style="margin: auto;" class="form-group">
                    <br>
                  <input type="submit"value="Confirm and Send"  class="btn btn-primary py-3 px-5" style="width: 100%;">

                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>

      </div>
      <br>
      <br>
      <br>
    </section>
  </body>

          <?php include "template/footer.php"; ?>

          <?php include "template/script.php"; ?>

</html>
