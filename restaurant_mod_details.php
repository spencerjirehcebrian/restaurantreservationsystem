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

  <body>

    <?php
    require_once "config_databases.php";
    $var_session_id = trim($_SESSION["session_id"]);
    $sql = "SELECT * FROM restaurant_details WHERE restaurant_id=?";
    if ($stmt = $mysql->prepare($sql)) {
        $stmt->bind_param("s", $var_session_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $var_displayname = trim($row["restaurant_displayname"]);
                    $var_address = trim($row["restaurant_address"]);
                    $var_info = trim($row["restaurant_info"]);
                    $var_infosummary = trim($row["restaurant_infosummary"]);
                    $newrestaurant = false;
                }
                $stmt->close();
            } else {
                $stmt->close();
                $newrestaurant = true;
                $var_displayname = $var_address = $var_info = $var_infosummary = $var_menu =
                    "";
            }
        } else {
            echo "Error";
        }
    }
    $item_err1 = $item_err2 = $item_err3 = $item_err4 = $item_err5 = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["in_displayname"]))) {
            $item_err6_ = "Error";
        } else {
            $var_displayname = trim($_POST["in_displayname"]);
        }

        if (empty(trim($_POST["in_address"]))) {
            $item_err2 = "Empty Field";
        } else {
            $var_address = trim($_POST["in_address"]);
        }

        if (empty(trim($_POST["in_info"]))) {
            $item_err3 = "Empty Field";
        } else {
            $var_info = trim($_POST["in_info"]);
        }

        if (empty(trim($_POST["in_infosummary"]))) {
            $item_err4 = "Empty Field";
        } else {
            $var_infosummary = trim($_POST["in_infosummary"]);
        }

        if (empty(trim($_POST["in_menu"]))) {
            $item_err5_ = "Error";
        } else {
            $var_menu = trim($_POST["in_menu"]);
        }

        //Enter to SQLDatabase
        if (
            empty($item_err1) &&
            empty($item_err2) &&
            empty($item_err3) &&
            empty($item_err4) &&
            empty($item_err5) &&
            empty($item_err6) &&
            $newrestaurant === true
        ) {
            $sql =
                "INSERT INTO restaurant_details(restaurant_id, restaurant_displayname, restaurant_address, restaurant_info, restaurant_infosummary, restaurant_menu) VALUES(?,?,?,?,?,?)";
            if ($stmt = $mysql->prepare($sql)) {
                $var_restaurant_id = trim($_SESSION["session_id"]);
                $stmt->bind_param(
                    "ssssss",
                    $var_restaurant_id,
                    $var_displayname,
                    $var_address,
                    $var_info,
                    $var_infosummary,
                    $var_menu
                );
                if ($stmt->execute()) {
                    $page = $_SERVER["PHP_SELF"];
                    echo "<script>alert('Saved');</script>";
                    header("Refresh:0; $page");
                } else {
                    echo "<script>alert('Failed:Please Try Again);</script>";
                    header("Refresh:0; $page");
                }
                $stmt->close();
            }
        } elseif (
            empty($item_err1) &&
            empty($item_err2) &&
            empty($item_err3) &&
            empty($item_err4) &&
            empty($item_err5) &&
            empty($item_err6) &&
            $newrestaurant === false
        ) {
            $sql =
                "UPDATE restaurant_details SET restaurant_displayname =?,restaurant_address=?,restaurant_info =?,restaurant_infosummary=?, restaurant_menu=? WHERE restaurant_id=?";
            if ($stmt = $mysql->prepare($sql)) {
                $var_restaurant_id = trim($_SESSION["session_id"]);
                $stmt->bind_param(
                    "ssssss",
                    $var_displayname,
                    $var_address,
                    $var_info,
                    $var_infosummary,
                    $var_menu,
                    $var_restaurant_id
                );
                if ($stmt->execute()) {
                    echo "<script>alert('Saved');</script>";
                    echo "<script type='text/javascript'>
            window.location.href = 'restaurant_home.php';
            </script>";
                } else {
                    $page = $_SERVER["PHP_SELF"];
                    echo "<script>alert('Failed:Please Try Again);</script>";
                    header("Refresh:0; $page");
                }
                $stmt->close();
            }
        } else {
            echo "<script>alert('Empty Value: Please Try Again');</script>";
        }
    }
    ?>
    <?php include "template/res-light-nav-bar.php"; ?>
    <!-- END nav -->

    <section class="home-slider owl-carousel" style="height: 400px;">
      <div class="slider-item" style="background-image: url('images/restodetbg2.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center">
            <div class="col-md-10 col-sm-12 ftco-animate text-center" style="padding-bottom: 25%;">

              <h1 class="mb-3">Modify Restaurant Infromation</h1>
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


                          <div class="form-group <?php echo !empty($item_err1)
                              ? "has-error"
                              : ""; ?> ">
                            <label>Restaurant Display Name:</label>
                            <input type="text" name="in_displayname" class="form-control" required="" placeholder="Displayed Name" value="<?php echo $var_displayname; ?>">
                          </div>

                          <div class="form-group <?php echo !empty($item_err2)
                              ? "has-error"
                              : ""; ?> ">
                            <label>Address:</label>
                            <input type="text" name="in_address" class="form-control" required="" placeholder="Address" value="<?php echo $var_address; ?>">
                          </div>

                          <div class="form-group <?php echo !empty($item_err3)
                              ? "has-error"
                              : ""; ?> ">
                            <label>Restaurant Information:</label>
                            <textarea name="in_info" class="form-control" rows="4" cols="50"  required="" placeholder="About Us (You!):" value="<?php echo $var_info; ?>"><?php echo $var_info; ?></textarea>
                          </div>

                          <div class="form-group <?php echo !empty($item_err4)
                              ? "has-error"
                              : ""; ?> ">
                            <label>Displayed Information Summary:</label>
                            <textarea name="in_infosummary" class="form-control" rows="4" cols="50" required="" placeholder="Brief Introduction" value="<?php echo $var_infosummary; ?>"><?php echo $var_infosummary; ?></textarea>
                          </div>

                          <div style="display:flex;"  class="form-group">
                            <input style="margin:auto;" type="submit" class="btn btn-primary py-3 px-5" value="Save">
                            <a href="restaurant_home.php" style="margin:auto;" class="btn btn-danger py-3 px-5">Back</a>
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
  </body>
</html>
