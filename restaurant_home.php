<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Restaurant Home</title>
    <style type="text/css">
      .adminlogo{
          border: 2px solid black;
          height: 300px;
          position: relative;
      }
    </style>

  </head>
  <?php
  require_once "php_functions.php";
  initializeSession("restaurant");
  include "template/header.php";
  ?>

  <body>
  <?php include "template/res-dark-nav-bar.php"; ?>
    <?php $_SESSION["session_restaurant_mod_reservation_id"] = ""; ?>
<section class="bg-primary ">
    <div class= "rounded container bg-light">
      <div class="text-center heading-section ftco-animate">
        <br>
        <h1>Restaurant</h1>
        <h3>Administration Page</h3>
        <div>
          <p> Hello, <b><?php echo htmlspecialchars(
              $_SESSION["session_username"]
          ); ?></b> and welcome to the Restaurant Administration Home Page. Select any option below to continue. </p>
        </div>
        <img class="adminlogo" src="images/adminlogo.png">


      </div>
          <br>

    <div class= "rounded container ftco-animate">
    <div class= "container border-secondary rounded text-secondary">
    <div class="row">
    <div class="col-sm  d-flex justify-content-center ">
    <p><a class="btn btn-primary  py-2 px-6" href="restaurant_view_customer.php" role="button">Veiw and Manage Current Customer Reservations</a></p>
    </div>
    </div>
    <div class="row">
    <div class="col-sm  d-flex justify-content-center ">
    <p><a class="btn btn-primary  py-2 px-6" href="restaurant_view_schedules.php" role="button">Veiw and Modify Reservation Schedules</a></p>
    </div>
    </div>
    </div>
    <div class="row">
    <div class="col-sm  d-flex justify-content-center ">
    <p><a class="btn btn-primary py-2 px-6" href="restaurant_mod_details.php" role="button">Modify Restaurant Info</a></p>
    </div>
    </div>
    <div class="row">
    <div class="col-sm  d-flex justify-content-center ">
    <p><a class="btn btn-primary py-2 px-6" href="restaurant_view_menu.php" role="button">View and Modify Restaurant Menu</a></p>
    </div>
    </div>
    </div>
    <br>
    <br>
    <br>
    </div>
  </section>
  </body>


      <?php include "template/instagram.php"; ?>

      <?php include "template/footer.php"; ?>

      <?php include "template/script.php"; ?>

</html>
