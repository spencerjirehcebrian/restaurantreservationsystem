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
    <?php
    include "template/dark-nav-bar.php";
    //Global Variable Declaration for customers
    $_SESSION["session_cust_restaurant_name"] = "";
    $_SESSION["session_cust_res_name"] = "";
    $_SESSION["session_cust_res_time_str"] = "";
    $_SESSION["session_cust_res_time_end"] = "";
    $_SESSION["session_cust_res_day"] = "";
    $_SESSION["session_cust_restaurant_id"] = "";
    $_SESSION["session_cust_restaurant_name"] = "";
    $_SESSION["session_cust_res_id"] = "";
    $_SESSION["session_cust_res_date"] = "";
    ?>

    <section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image: url('images/bg_1.jpg');">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center text-center">
            <div class="col-md-10 col-sm-12 ftco-animate">
              <h1 class="mb-3">Reserve at a time convenient for you</h1>
              <h><a class="btn btn-outline-primary btn-lg py-3 px-5" href="customer_add_reservation.php" role="button">Reserve Now</a></h4>
            </div>
          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url('images/bg_2.jpg');">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center text-center">
            <div class="col-md-10 col-sm-12 ftco-animate">
              <h1 class="mb-3">Restaurants with Tasty &amp; Delicious Cuisine</h1>
              <a class="btn btn-outline-primary btn-lg py-3 px-5" href="customer_view_restaurant.php" role="button">View Availiable Restaurants</a>
            </div>
          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url('images/bg_3.jpg');">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center text-center">
            <div class="col-md-10 col-sm-12 ftco-animate">
              <h1 class="mb-3">Organize Your Eating</h1>
              <p><a class="btn btn-outline-primary btn-lg py-3 px-5"href="customer_view_reservation.php"  role="button">Manage Your Reservation Schedules</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

  </body>

  <?php include "template/instagram.php"; ?>

  <?php include "template/footer.php"; ?>

  <?php include "template/script.php"; ?>
</html>
