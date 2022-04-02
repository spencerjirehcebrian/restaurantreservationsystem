<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CLient Signup/Register</title>
      <?php
      include 'template/header.php';
      $_SESSION["customer_isLoggedIn"]=false;
      $_SESSION["restaurant_isLoggedIn"]=false;
      ?>
        <body>

    <?php
    require_once "config_databases.php";
    $username=$password=$confirm_password="";
    $username_err=$password_err=$confirm_password_err="";

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
      if(empty(trim($_POST["username"])))
      {
        $username_err="Please Enter A Username";
      }
      else
      {
        $sql="SELECT restaurant_id FROM restaurant_account WHERE restaurant_username=?";
        if($stmt=$mysql->prepare($sql))
        {
          $stmt->bind_param("s", $param_username);
          $param_username=trim($_POST["username"]);
          if ($stmt->execute())
          {
            $stmt->store_result();
            if($stmt->num_rows==1)
            {
              $username_err="This Username Is Already Taken";
            }else
            $stmt->close();
          }
        }
        //error check
          if(empty(trim($_POST["password"])))
          {
            $password_err="Please Enter A Password";
          }elseif (strlen(trim($_POST["password"]))<8)
          {
            $password_err="Please Enter Atleast 8 Characters";
          }else
          {
            $password=trim($_POST["password"]);
          }

          if(empty(trim($_POST["confirm_password"])))
          {
            $password_err="Please Confirm Password";
          }else
          {
            $confirm_password=trim($_POST["confirm_password"]);
            if(empty($password_err)&&($password!=$confirm_password))
            {
              $confirm_password_err="Passwords Do Not Match";
            }
          }
          //enter database
          if(empty($username_err)&&empty($password_err)&&empty($confirm_password_err))
          {
            $sql="INSERT INTO restaurant_account(restaurant_username, restaurant_password) VALUES(?,?)";
            if($stmt=$mysql->prepare($sql))
            {
              $username=$_POST["username"];
              $password=$_POST["password"];
              $param_username=$username;
              $param_password=password_hash($password, PASSWORD_DEFAULT);
              $stmt->bind_param("ss",$param_username, $password);
              if ($stmt->execute())
              {
                echo "<script>alert('Account Successfully Created');</script>";
                echo "<script type='text/javascript'>
                window.location.href = 'restaurant_login.php';
                </script>";
              }
              else
              {
                echo "<script>alert('Account Creation Failed);</script>";
              }
              $stmt->close();
            }
          }
      }

    }
    $mysql->close();
    ?>

    <?php include 'template/res-light-nav-bar.php'; ?>

    <section class="home-slider owl-carousel" style="height: 400px;">
      <div class="slider-item" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center">
            <div class="col-md-10 col-sm-12 ftco-animate text-center" style="padding-bottom: 25%;">
              <h1 class="mb-3">Restaurant Sign Up</h1>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <span class="subheading">Restaurant Sign Up</span>
            <h2>Register In Our Site</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 dish-menu">

            <div class="nav nav-pills justify-content-center ftco-animate" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link py-3 px-4 active" id="v-pills-home-tab" data-toggle="pill" href="" role="tab" aria-controls="v-pills-home" aria-selected="true"><span class="flaticon-cutlery"></span> As A Restaurant</a>
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



                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                          <div class="form-group <?php echo(!empty($username_err))? 'has-error':'';?> ">
                            <input type="text" name="username" class="form-control" required="" placeholder="Username" value="<?php echo $username;?>">
                          </div>

                          <div class="form-group <?php echo(!empty($password_err))? 'has-error':'';?> ">
                            <input type="password" name="password" class="form-control" required="" minlength="8" placeholder="Password" value="<?php echo $password;?>">
                          </div>

                          <div class="form-group <?php echo(!empty($confirm_password_err))? 'has-error':'';?> ">
                            <input type="password" name="confirm_password" class="form-control" required="" minlength="8" placeholder="Confirm Password" value="<?php echo $confirm_password;?>">
                          </div>

                          <div style="display:flex;" class="form-group">
                            <input style="margin:auto;" type="submit" value="Register" class="btn btn-primary py-3 px-5">

                          </div>


                      </form>
                      <p class="text-center">Already have a Restaurant Account? <a href="restaurant_login.php">Click Here.</a></p>
                      <p class="text-center">For Regular Customer Access <a href="customer_login.php">Click Here.</a> </p>
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

    <?php include 'template/instagram.php'; ?>

    <?php include 'template/footer.php'; ?>

    <?php include 'template/script.php'; ?>


      </form>
    </div>
  </body>
</html>
