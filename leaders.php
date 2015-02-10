<?php

include('core.php');
$core = new core;
?>

<!DOCTYPE html>
<html lang="en">



    <!-- Prerequisites  -->
  <head>
      <!-- Meta Data -->
    <meta charset="utf-8">

      <!-- Web Page Title -->
    <title>LolVotes - LeaderBoard</title>

      <!-- CSS StyleSheets -->
    <link href="./css/bootstrap.css" rel="stylesheet">

      <!-- JavaScript Library Files -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script src="../../dist/js/bootstrap.min.js"></script>
  </head>




    <!-- Content -->
  <body>

  <!-- "Nav-bar" Divider -->
    <div class="container">
	<br/>
      <div class="navbar navbar-inverse" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
              <!-- Nav-bar Title -->
            <a class="navbar-brand" href="./index.php">LolVotes</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!-- Page Links -->
              <li><a href="./index.php">Home Page</a></li>
              <li><a href="./vote.php">Vote Now</a></li>
              <li class="active"><a href="./leaders.php">Leader Board</a></li>
             </ul>
              <!-- Logged In Reminder -->
              <?php
              $core->createBar();
              ?>
          </div>
        </div>
      </div>


        <?php
        $core->catcherrors();
        ?>
    <!-- "Jumbo-tron" Divider (LolVotes Picture Box) -->
      <div class="jumbotron">
          <!-- Title -->
        <h1>LolVotes</h1>
      </div>



	<!-- Body Divider -->
	<div class="row" style="margin-left: 8px;margin-right: 10px;">
	  <div class="col-md-12" style="height:400px;">
          <!-- Table Code -->
          <table class="table table-bordered">
              <tr>
                  <!-- Field Headings -->
                  <b><th>Username</th></b>
                  <b><th>Points</th></b>
                  <b><th>Total Votes</th></b>
                  <b><th>Votes Correct</th></b>
              </tr>

                  <?php //enter PHP
                    $core->createTopTen();
                  ?> <!-- Leave php -->
          </table>
	<br/>
    </div>
  </body>
</html> <!-- Finish Leader-Board Page -->












