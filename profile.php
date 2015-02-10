<?php
include('core.php');
$core = new core;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>LolVotes - Home</title>
    <link href="./css/bootstrap.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">
	<br/>
      <!-- Static navbar -->
      <div class="navbar navbar-inverse" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./index.php">LolVotes</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="./index.php">Home Page</a></li>
              <li><a href="./vote.php">Vote Now</a></li>
              <li><a href="./leaders.php">Leader Board</a></li>
             </ul>
              <?php
              $core->createBar();
              ?>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
        <?php
        $core->catcherrors();
        ?>
      <div class="jumbotron">
        <h1>LolVotes</h1>
      </div>	
	<div class="row .no">
        <?php
        $core->createProfileBox();
            ?>

	  <div class="col-md-6">
          <?php
          $core->createProfileVotes($core->getIDfromName($_GET['username']));
          ?>
	  </div>
	  </div>
	  <br/>
	<br/>
	
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>
