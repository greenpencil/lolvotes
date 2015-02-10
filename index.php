<?php
include('core.php');
$core = new core;
?>

<!DOCTYPE html>
<html lang="en">

  <head>
      <!-- Meta Data -->
      <meta charset="utf-8">

      <!-- Web Page Title -->
      <title>LolVotes - Home</title>

      <!-- CSS StyleSheets -->
      <link href="./css/bootstrap.css" rel="stylesheet">

      <!-- JavaScript Library Files -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script src="./js/bootstrap.min.js"></script>
  </head>

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
              <li class="active"><a href="./index.php">Home Page</a></li>
              <li><a href="./vote.php">Vote Now</a></li>
              <li><a href="./leaders.php">Leader Board</a></li>
             </ul>
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
	<div class="row">
        <!-- Body Divider Left -->
	  <div class="col-md-6" style="height:490px">
          <!-- Vote Now Button -->
	  <a href="/" class="btn btn-primary btn-lg btn-block">Vote Now</a>
	  <br/>
          <!-- Twitch Stream Embed -->
	  <object type="application/x-shockwave-flash" height="378" width="508" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel=lolesports" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel=lolesports&auto_play=true&start_volume=25" /></object>
	  </div>
        <!-- Body Divider Right -->
	  <div class="col-md-6" style="height:490px">
	  </div>
	</div>
	<br/>
  </body>
</html>
