<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
    body{font:14px sans-serif; text-align: center;}
    </style>
  </head>
  <body>
    <?php
    session_start();
    $_SESSION=array();
    session_destroy();
    echo "<script type='text/javascript'>
    window.location.href = 'customer_login.php';
    </script>";
    exit;
    ?>
  </body>
</html>
