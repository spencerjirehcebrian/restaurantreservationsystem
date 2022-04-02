<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Customer Login</title>
    </style>
  </head>
  <?php
  include "template/header.php";
  $_SESSION["customer_isLoggedIn"] = false;
  $_SESSION["restaurant_isLoggedIn"] = false;
  ?>
  <body>
  <?php include "template/light-nav-bar.php"; ?>

    <?php
    require_once "config_databases.php";
    $username = $password = "";
    $username_err = $password_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please Enter A Username";
        } else {
            $username = trim($_POST["username"]);
        }

        if (empty(trim($_POST["password"]))) {
            $password_err = "Please Enter A Password";
        } else {
            $password = trim($_POST["password"]);
        }
        if (empty($username_err) && empty($password_err)) {
            $sql =
                "SELECT customer_id, customer_username, customer_password FROM customer_account where  customer_username=?";
            if ($stmt = $mysql->prepare($sql)) {
                $stmt->bind_param("s", $param_username);
                $param_username = $username;
                if ($stmt->execute()) {
                    $stmt->store_result();
                }
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashedpassword);
                    if ($stmt->fetch()) {
                        $password = $_POST["password"];
                        //hash not used because not compatible with innoDB service
                        $temphash = password_hash($password, PASSWORD_DEFAULT);
                        if ($password = $hashedpassword) {
                            session_start();
                            $_SESSION["customer_isLoggedIn"] = true;
                            $_SESSION["restaurant_isLoggedIn"] = false;
                            $_SESSION["session_id"] = $id;
                            $_SESSION["session_username"] = $username;
                            echo "<script>alert('Log In Successful');</script>";
                            echo "<script type='text/javascript'>
                window.location.href = 'customer_home.php';
                </script>";
                        } else {
                            $password_err = "Incorrect Password";
                        }
                    } else {
                        $username_err = "Username Does Not Exist";
                    }
                } else {
                    echo "<script>alert('Log In Failed');</script>";
                }
            }
            $stmt->close();
        }
        $mysql->close();
    }
    ?>

    <section class="home-slider owl-carousel" style="height: 400px;">
      <div class="slider-item" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center">
            <div class="col-md-10 col-sm-12 ftco-animate text-center" style="padding-bottom: 25%;">

              <h1 class="mb-3">Customer Login</h1>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <span class="subheading">Customer Login</span>
            <h2>Log In To The Site</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 dish-menu">

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

                      <div class="form-group <?php echo !empty($username_err)
                          ? "has-error"
                          : ""; ?> ">
                        <label>User Name:</label>
                        <input type="text" name="username" class="form-control" required="" placeholder="Your Username" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                      </div>

                      <div class="form-group <?php echo !empty($password_err)
                          ? "has-error"
                          : ""; ?> ">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control" required="" minlength="8" placeholder="Your Password" value="<?php echo $password; ?>">
                        <span class="help-block"><?php echo $password_err; ?></span>
                      </div>

                      <div style="display:flex;"  class="form-group">
                        <input style="margin:auto;" type="submit" class="btn btn-primary py-3 px-5" value="Login">
                      </div>

                      <!--<p><a class="btn btn-outline-primary py-3 px-5" href="customer_signup.php" role="button">Customer Signup</a></p>
                      <p><a class="btn btn-outline-primary py-3 px-5" <a href="restaurant_login.php" role="button">Restaurant Login</a></p>-->
                      <p class="text-center">For Register <a href="customer_signup.php">Click Here.</a></p>
                      <p class="text-center">For Restaurant Client Access <a href="restaurant_login.php">Click Here.</a> </p>
					        </div>
					    </div>
	                </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>


  </body>
  <?php include "template/instagram.php"; ?>

  <?php include "template/footer.php"; ?>

  <?php include "template/script.php"; ?>
</html>
