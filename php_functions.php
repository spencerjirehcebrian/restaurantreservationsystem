<?php
function initializeSession($sessionMode) {
  session_start();
  if ($sessionMode == "restaurant")
  {
    if(isset($_SESSION["loggedin"]) && $_SESSION["restaurant_isLoggedIn"]!=true && $_SESSION["customer_isLoggedIn"]==true){
      header("location:restaurant_login.php");
      exit;
    }else {
      if($_SESSION["customer_isLoggedIn"]!=true && $_SESSION["restaurant_isLoggedIn"]!=true){
        header("location:restaurant_login.php");
        exit;
    }
  }
  }else{
    if(isset($_SESSION["loggedin"]) && $_SESSION["customer_isLoggedIn"]!=true && $_SESSION["restaurant_isLoggedIn"]==true){
      header("location:customer_login.php");
      exit;
    }else {
      if($_SESSION["customer_isLoggedIn"]!=true && $_SESSION["restaurant_isLoggedIn"]!=true){
        header("location:customer_login.php");
        exit;
    }
  }
}
}


function dayUnhash($hash) {
  $array_day = explode('-',$hash);
  $array_tostr_day = array("", "", "", "", "", "", "");
  if($array_day[0] == 2)
  {
    $array_tostr_day[0] = "MONDAY ";
  }
  if($array_day[1] == 2)
  {
    $array_tostr_day[1] = "TUESDAY ";
  }
  if($array_day[2] == 2)
  {
    $array_tostr_day[2] = "WEDNESDAY ";
  }
  if($array_day[3] == 2)
  {
    $array_tostr_day[3] = "THURSDAY ";
  }
  if($array_day[4] == 2)
  {
    $array_tostr_day[4] = "FRIDAY ";
  }
  if($array_day[5] == 2)
  {
    $array_tostr_day[5] = "SATURDAY ";
  }
  if($array_day[6] == 2)
  {
    $array_tostr_day[6] = "SUNDAY ";
  }

  $day_str = implode("", $array_tostr_day);
  return $day_str;
}

function modifySchedDetails($mod_sched_id){
  $_SESSION["session_restaurant_mod_reservation_id"]=$mod_sched_id;
  header("location:restaurant_mod_schedules.php");
}

/*function openrestaurantSched($cust_restaurant_id, $cust_restaurant_name){
  $_SESSION["session_cust_restaurant_id"]=$cust_restaurant_id;
  $_SESSION["session_cust_restaurant_name"]=$cust_restaurant_name;
  if ($_SESSION['session_cust_mode']=="default") {
  header("location:customer_view_schedules.php");
  }
  elseif ($_SESSION['session_cust_mode']=="add") {
    header("location:customer_add_reservation.php");
  }
  elseif ($_SESSION['session_cust_mode']=="mod") {
    header("location:customer_mod_reservation.php");
  }
}*/

function openrestaurantSched($cust_restaurant_id, $cust_restaurant_name){
  $_SESSION["session_cust_restaurant_id"]=$cust_restaurant_id;
  $_SESSION["session_cust_restaurant_name"]=$cust_restaurant_name;
    $_SESSION['session_cust_mode']="add";
  header("location:customer_view_schedules.php");
}

function openrestaurantList($cust_status,$cust_restaurant_id){
  $_SESSION["session_cust_status"]=$cust_status;
  $_SESSION["session_cust_restaurant_id"]=$cust_restaurant_id;
  header("location:customer_view_restaurant.php");
}

function openrestaurantDetails($cust_det_restaurant_id, $cust_det_restaurant_name){
  $_SESSION["session_cust_restaurant_id"]=$cust_det_restaurant_id;
  $_SESSION["session_cust_restaurant_name"]=$cust_det_restaurant_name;
  header("location:customer_view_restaurant_details.php");
}

function openrestaurantMenu($cust_det_restaurant_id, $cust_det_restaurant_name){
  $_SESSION["session_cust_restaurant_id"]=$cust_det_restaurant_id;
  $_SESSION["session_cust_restaurant_name"]=$cust_det_restaurant_name;
  header("location:customer_view_restaurant_menu.php");
}

function openReservationDetails($cust_restaurant_id){
  $_SESSION["session_cust_restaurant_id"]=$cust_restaurant_id;
  if ($_SESSION['session_cust_status']=="default") {
    header("location:customer_add_reservation.php");
  }
  elseif ($_SESSION['session_cust_status']=="add") {
    header("location:customer_add_reservation.php");
  }
  elseif ($_SESSION['session_cust_status']=="mod") {
    header("location:customer_mod_reservations.php");
  }
}

function openReservationDetailsViaSched($cust_res_id,$cust_res_name,$cust_res_time_str,$cust_res_time_end,$cust_res_day,$cust_res_max_party,$cust_sched_date){
  $_SESSION["session_cust_res_id"]=$cust_res_id;
  $_SESSION["session_cust_res_name"]=$cust_res_name;
  $_SESSION["session_cust_res_time_str"]=$cust_res_time_str;
  $_SESSION["session_cust_res_time_end"]=$cust_res_time_end;
  $_SESSION["session_cust_res_day"]=$cust_res_day;
  $_SESSION["session_cust_res_max_party"]=$cust_res_max_party;
  $_SESSION["session_cust_res_date"]=$cust_sched_date;
  if ($_SESSION['session_cust_mode']=="default") {
    echo "<script type='text/javascript'>
    window.location.href = 'customer_add_reservation.php';
    </script>";
  }
  elseif ($_SESSION['session_cust_mode']=="add") {
    echo "<script type='text/javascript'>
    window.location.href = 'customer_add_reservation.php';
    </script>";
  }
  elseif ($_SESSION['session_cust_mode']=="mod") {
    echo "<script type='text/javascript'>
    window.location.href = 'customer_mod_reservation.php';
    </script>";
  }
}

function openReservationDetailsMod($mod_sched_id){
  $_SESSION["session_cust_mod_id"]=$mod_sched_id;
  header("location:customer_mod_reservation.php");
}

function openReservationRestaurantMod($mod_sched_id){
  $_SESSION["session_cust_mod_id"]=$mod_sched_id;
  header("location:customer_mod_reservation.php");
}


function modifyMenuDetails($mod_menu_id){
  $_SESSION["session_restaurant_mod_menu_id"]=$mod_menu_id;
  $_SESSION["session_restaurant_mod_menu_type"]=true;
  header("location:restaurant_mod_menu.php");
}

function addMenuDetails(){
  $_SESSION["session_restaurant_mod_menu_type"]=false;
  header("location:restaurant_mod_menu.php");
}


function dayHashCompareArray($daynumber, $array_day2){
  if ("2" === $array_day2){
    return true;
  }
  else {
    return false;
  }

}

function dayHashCompare($day, $day_hash) {
  $array_day3 = explode('-', $day_hash);
  switch ($day) {
  case 'Mon':
    return dayHashCompareArray("0", $array_day3[0]);
    break;
  case 'Tue':
    return dayHashCompareArray("1", $array_day3[1]);
    break;
  case 'Wed':
    return dayHashCompareArray("2", $array_day3[2]);
    break;
  case 'Thu':
    return dayHashCompareArray("3", $array_day3[3]);
    break;
  case 'Fri':
    return dayHashCompareArray("4", $array_day3[4]);
    break;
  case 'Sat':
    return dayHashCompareArray("5", $array_day3[5]);
    break;
  case 'Sun':
    return dayHashCompareArray("6", $array_day3[6]);
    break;
}

}
?>
