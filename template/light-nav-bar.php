<!-- nav-bar.php -->
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
  	<div class="container">
	    <a class="navbar-brand" href="customer_home.php">Restaurant Reservation</a>
	    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="oi oi-menu"></span> Menu
	    </button>

	    <div class="collapse navbar-collapse" id="ftco-nav">
	      <ul class="navbar-nav ml-auto">
	        <li class="nav-item active"><a href="customer_home.php" class="nav-link">Home</a></li>
          <li class="nav-item active"><a href="customer_view_reservation.php" class="nav-link">My Reservations</a></li>

          <?php if($_SESSION["restaurant_isLoggedIn"]==false && $_SESSION["customer_isLoggedIn"]==false){ ?>
	         <li class="nav-item"><a href="customer_signup.php" class="nav-link">Register</a></li>
	       	 <li class="nav-item"><a href="customer_login.php" class="nav-link">Login</a></li>
         <?php }elseif ($_SESSION["restaurant_isLoggedIn"]==true || $_SESSION["customer_isLoggedIn"]==true) { ?>

	        <li class="nav-item active"><a href="logout.php" class="nav-link">Logout</a></li>
          <li class="nav-item"><a href="customer_home.php" class="nav-link">Username: <?php echo $_SESSION['session_username'];?></a></li>
	        <?php } ?>

	      </ul>
	    </div>
  	</div>
</nav>
