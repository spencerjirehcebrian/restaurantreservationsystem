<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Modify Reservation Options</title>

  </head>
  <?php
  require_once "php_functions.php";
  initializeSession("restaurant");
  include "template/header.php";
  ?>
        <?php include "template/res-dark-nav-bar.php"; ?>
  <body>

    <?php
    require_once "config_databases.php";
    $addMenu = trim($_SESSION["session_restaurant_mod_menu_type"]);
    $var_menu_name = $var_menu_prices = $var_menu_details = "";
    $var_menu_id = trim($_SESSION["session_restaurant_mod_menu_id"]);
    $sql = "SELECT * FROM restaurant_menu WHERE menu_id =?";
    if ($stmt = $mysql->prepare($sql)) {
        $stmt->bind_param("s", $var_menu_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0 && $addMenu == true) {
                while ($row = $result->fetch_assoc()) {
                    $var_menu_name = trim($row["menu_name"]);
                    $var_menu_prices = trim($row["menu_prices"]);
                    $var_menu_details = trim($row["menu_details"]);
                }
                $stmt->close();
            } else {
                $stmt->close();
            }
        } else {
            echo "Error";
        }
    }

    $item_err2 = $item_err3 = $item_err4 = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["in_menu_name"]))) {
            $item_err2 = "Empty Field";
        } else {
            $var_menu_name = trim($_POST["in_menu_name"]);
        }

        if (empty(trim($_POST["in_menu_details"]))) {
            $item_err3 = "Empty Field";
        } else {
            $var_menu_details = trim($_POST["in_menu_details"]);
        }

        if (empty(trim($_POST["in_menu_prices"]))) {
            $item_err4 = "Empty Field";
        } else {
            if (trim($_POST["in_menu_prices"]) <= 0) {
                $item_err4 = "Must be a Proper Number";
            } else {
                $var_menu_prices = trim($_POST["in_menu_prices"]);
            }
            $var_menu_prices = trim($_POST["in_menu_prices"]);
        }

        //Enter to SQLDatabase
        $var_session_id = trim($_SESSION["session_id"]);
        if (
            empty($item_err2) &&
            empty($item_err3) &&
            empty($item_err4) &&
            $addMenu == true
        ) {
            $sql =
                "UPDATE restaurant_menu SET restaurant_id=?, menu_name=?, menu_details=?, menu_prices=? WHERE menu_id=?";
            if ($stmt = $mysql->prepare($sql)) {
                $stmt->bind_param(
                    "sssss",
                    $var_session_id,
                    $var_menu_name,
                    $var_menu_details,
                    $var_menu_prices,
                    $var_menu_id
                );
                if ($stmt->execute()) {
                    echo "<script>alert('Item Modified Successfully');</script>";
                    echo "<script type='text/javascript'>
            window.location.href = 'restaurant_view_menu.php';
            </script>";
                } else {
                    $page = $_SERVER["PHP_SELF"];
                    echo "<script>alert('Item Modification Failed);</script>";
                    header("Refresh:0; $page");
                }
                $stmt->close();
            }
        } elseif (
            empty($item_err2) &&
            empty($item_err3) &&
            empty($item_err4) &&
            $addMenu == false
        ) {
            $sql =
                "INSERT INTO restaurant_menu(restaurant_id, menu_name, menu_prices, menu_details) VALUES(?,?,?,?)";
            if ($stmt = $mysql->prepare($sql)) {
                $stmt->bind_param(
                    "ssss",
                    $var_session_id,
                    $var_menu_name,
                    $var_menu_prices,
                    $var_menu_details
                );
                if ($stmt->execute()) {
                    $page = $_SERVER["PHP_SELF"];
                    echo "<script>alert('Item Menu Entry Created Successfully');</script>";
                    echo "<script type='text/javascript'>
            window.location.href = 'restaurant_view_menu.php';
            </script>";
                } else {
                    echo "<script>alert('Item Menu Entry Failed);</script>";
                    header("Refresh:0; $page");
                }
                $stmt->close();
            }
        } else {
            echo "<script>alert('Item Menu Entry Failed);</script>";
        }
    }
    ?>


      <section class="home-slider owl-carousel" style="height: 400px;">
        <div class="slider-item" style="background-image: url('images/restodetbg2.jpg');" data-stellar-background-ratio="0.5">
          <div class="overlay"></div>
          <div class="container">
            <div class="row slider-text align-items-center justify-content-center">
              <div class="col-md-10 col-sm-12 ftco-animate text-center" style="padding-bottom: 25%;">

                <h1 class="mb-3">Modify Restaurant Menu</h1>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="ftco-section bg-light">
        <div class="container">
          <div class="row justify-content-center mb-5 pb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
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

                            <div class="form-group ">
                              <label>Menu Item Name: </label>
                              <input type="text" name="in_menu_name" required="" placeholder="Menu Item Name" class="form-control" value="<?php echo $var_menu_name; ?>"></input>
                            </div>

                            <div class="form-group">
                              <label>Item Details:</label>
                              <textarea name="in_menu_details" required="" placeholder="Item Details" class="form-control" rows="3" cols="50" value="<?php echo $var_menu_details; ?>"></textarea>
                            </div>

                            <div class="form-group">
                              <label>Price:</label>
                              <input type="number" name="in_menu_prices" class="form-control" required="" placeholder="Price" value="<?php echo $var_menu_prices; ?>"></input>
                            </div>

                            <div style="display:flex;"  class="form-group">
                              <input type="submit" style="margin:auto;" class="btn btn-primary py-3 px-5" value="Save"></input>
                               <a href="restaurant_view_menu.php"style="margin:auto;" class="btn btn-danger py-3 px-5">Back</a>
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
