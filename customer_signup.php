<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Customer Signup/Register</title>

  </head>

      <?php
      include "template/header.php";
      $_SESSION["customer_isLoggedIn"] = false;
      $_SESSION["restaurant_isLoggedIn"] = false;
      ?>
        <body>

    <?php
    require_once "config_databases.php";
    $username = $password = $confirm_password = $dob = $sex = $fname = $lname = $email = $pnumber =
        "";
    $username_err = $password_err = $confirm_password_err = "";
    $item_err = $item_err1 = $item_err2 = $item_err3 = $item_err4 = $item_err5 =
        "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["firstname"]))) {
            $item_err = "Empty Field";
        } else {
            $fname = trim($_POST["firstname"]);
        }

        if (empty(trim($_POST["lastname"]))) {
            $item_err1 = "Empty Field";
        } else {
            $lname = trim($_POST["lastname"]);
        }

        if (empty(trim($_POST["dob"]))) {
            $item_err3 = "Empty Field";
        } else {
            $dob = trim($_POST["dob"]);
        }

        if (empty(trim($_POST["sex"]))) {
            $item_err2 = "Empty Field";
        } else {
            $sex = trim($_POST["sex"]);
        }

        if (empty(trim($_POST["username"]))) {
            $username_err = "Please Enter A Username";
        } else {
            $sql =
                "SELECT customer_id FROM customer_account WHERE customer_username=?";
            if ($stmt = $mysql->prepare($sql)) {
                $stmt->bind_param("s", $param_username);
                $param_username = trim($_POST["username"]);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $username_err = "This Username Is Already Taken";
                    } else {
                        $stmt->close();
                    }
                }
            }
            //error check
            if (empty(trim($_POST["password"]))) {
                $password_err = "Please Enter A Password";
            } elseif (strlen(trim($_POST["password"])) < 8) {
                $password_err = "Please Enter Atleast 8 Characters";
                echo "<script>alert($password_err);</script>";
            } else {
                $password = trim($_POST["password"]);
            }

            if (empty(trim($_POST["confirm_password"]))) {
                $password_err = "Please Confirm Password";
            } else {
                $confirm_password = trim($_POST["confirm_password"]);
                if (empty($password_err) && $password != $confirm_password) {
                    $confirm_password_err = "Passwords Do Not Match";
                    echo "<script>alert($confirm_password_err);</script>";
                }
            }
            //enter database
            try {
                if (
                    empty($username_err) &&
                    empty($password_err) &&
                    empty($confirm_password_err)
                ) {
                    $sql =
                        "INSERT INTO customer_account(customer_email, customer_username, customer_password, customer_fname, customer_lname, customer_dob, customer_sex, customer_pnumber) VALUES(?,?,?,?,?,?,?,?)";
                    if ($stmt = $mysql->prepare($sql)) {
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $email = trim($_POST["email"]);
                        $pnumber = trim($_POST["pnumber"]);
                        $param_username = $username;
                        $param_password = password_hash(
                            $password,
                            PASSWORD_DEFAULT
                        );
                        $stmt->bind_param(
                            "ssssssss",
                            $email,
                            $param_username,
                            $password,
                            $fname,
                            $lname,
                            $dob,
                            $sex,
                            $pnumber
                        );
                        if ($stmt->execute()) {
                            echo "<script>alert('Sign Up Successful');</script>";
                            echo "<script type='text/javascript'>
                  window.location.href = 'customer_login.php';
                  </script>";
                        } else {
                            echo "<script>alert('Sign Up Failed: Please Try Again');</script>";
                        }
                        $stmt->close();
                    }
                }
            } catch (\Exception $e) {
                echo "Something Went Wrong Please Try Again" . $e;
            }
        }
    }
    $mysql->close();
    ?>


        <?php include "template/light-nav-bar.php"; ?>
        <!-- END nav -->

        <section class="home-slider owl-carousel" style="height: 400px;">
          <div class="slider-item" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
              <div class="row slider-text align-items-center justify-content-center">
                <div class="col-md-10 col-sm-12 ftco-animate text-center" style="padding-bottom: 25%;">

                  <h1 class="mb-3">Customer Sign Up</h1>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="ftco-section bg-light">
          <div class="container">
            <div class="row justify-content-center mb-5 pb-5">
              <div class="col-md-7 text-center heading-section ftco-animate">
                <span class="subheading">Customer Sign Up</span>
                <h2>Register In Our Site</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 dish-menu">

                <div class="nav nav-pills justify-content-center ftco-animate" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link py-3 px-4 active" id="v-pills-home-tab" data-toggle="pill" href="" role="tab" aria-controls="v-pills-home" aria-selected="true"><span class="flaticon-meat"></span> As A Customer</a>
                </div>

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

                              <div class="form-group <?php echo !empty(
                                  $username_err
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <input type="text" name="username" class="form-control" required="" placeholder="Username" value="<?php echo $username; ?>">
                              </div>

                              <div class="form-group <?php echo !empty(
                                  $item_err
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <input type="text" name="firstname" class="form-control" required="" placeholder="First Name" value="<?php echo $fname; ?>">
                              </div>

                              <div class="form-group <?php echo !empty(
                                  $item_err1
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <input type="text" name="lastname" class="form-control" required="" placeholder="Last Name" value="<?php echo $lname; ?>">
                              </div>

                              <div class="form-group <?php echo !empty(
                                  $item_err2
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <label>Sex/Gender: </label>
                                <select class="form-control" name="sex" value="<?php echo $sex; ?>">

                                  <option value="Male">Male</option>
                                  <option value="Female">Female</option>
                                  <option value="Other">Other</option>
                                </select>
                                <span class="help-block"><?php echo $item_err2; ?></span>
                              </div>

                              <div class="form-group <?php echo !empty(
                                  $item_err3
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <input type="date" name="dob" class="form-control" required="" placeholder="Date of Birth" value="<?php echo $dob; ?>">
                              </div>

                              <div class="form-group <?php echo !empty(
                                  $item_err4
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <input type="email" name="email" class="form-control" required="" placeholder="Email" value="<?php echo $email; ?>">
                              </div>

                              <div class="form-group <?php echo !empty(
                                  $item_err5
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <input type="number" name="pnumber" class="form-control" required="" placeholder="Phone Number" value="<?php echo $pnumber; ?>">
                              </div>

                              <div class="form-group <?php echo !empty(
                                  $password_err
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <input type="password" name="password" class="form-control" required="" minlength="8" placeholder="Password" value="<?php echo $password; ?>">
                              </div>

                              <div class="form-group <?php echo !empty(
                                  $confirm_password_err
                              )
                                  ? "has-error"
                                  : ""; ?> ">
                                <input type="password" name="confirm_password" class="form-control" required="" minlength="8" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>">
                              </div>

                              <div style="display:flex;" class="form-group">
                                <input style="margin:auto;" type="submit" value="Register" class="btn btn-primary py-3 px-5">
                                <!--<input  style="margin:auto;" type="reset" class="btn btn-default py-3 px-5" value="Reset">-->
                              </div>


                          </form>
                          <p class="text-center">Already have an Account? <a href="customer_login.php">Click Here.</a></p>
                          <p class="text-center">For Restaurant Client Access <a href="restaurant_login.php">Click Here.</a> </p>
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



      </form>
    </div>
  </body>
  <?php include "template/instagram.php"; ?>

  <?php include "template/footer.php"; ?>

  <?php include "template/script.php"; ?>
</html>
