<?php
Class core {
    private $db;

    function __construct() {
        $dbHost = "127.0.0.1";
        $dbUser = "root";
        $dbPassword = "lewis123";
        $dbName = "lolvotes";

        $this->db = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPassword);

    }

    function __destruct() {
        $db = null;
    }


    function checkUserExists ($fUsername)
    {
        $checkUser =  $this->db->prepare("SELECT * FROM user  WHERE USERNAME = '" . $fUsername . "'");
        $checkUser->execute();
        return $checkUser->rowCount();
    }

    function checkEmailExists ($fEmail)
    {
        $checkEmail =  $this->db->prepare("SELECT * FROM  user  WHERE EMAIL_ADDRESS = '" . $fEmail . "'");
        $checkEmail->execute();
        return $checkEmail->rowCount();
    }

    function getVoteNum($fUserid)
    {
        $getVoteNum =  $this->db->prepare('SELECT * FROM vote WHERE USER_ID = ' . $fUserid);
        $getVoteNum->execute();

        return $getVoteNum->rowCount();
    }

    function calcPercentCorrect ($fUserid)
    {
        //Retrieve all votes made by current user with function
        $GetAllVotes =  $this->getVoteNum($fUserid);

        //Retrieve all correct votes made by current userid
        $GetCorrectVotes =  $this->db->prepare("SELECT * FROM vote WHERE USER_ID =" .$fUserid . " AND VOTE_RESULT = 'TRUE'");
        $GetCorrectVotes->execute();

        //If number of rows of total votes query is equal to 0
        if(!$GetAllVotes == 0)
        { //Calculate Percentage Correct
            $PercentageCorrect = round(($GetCorrectVotes->rowCount()) / $GetAllVotes * 100); //round to prevent large decimals
        }
        else
        { //Percentage Correct = 0 (stops dividing by 0 error)
            $PercentageCorrect = 0;
        }

        return $PercentageCorrect;
    }

    function createTopTen()
    {
        $getTopTen10 = $this->db->prepare('SELECT * FROM `user` ORDER BY points DESC LIMIT 10');
        $getTopTen10->execute();
        //Loop, assign values into $row as an Array until last record
        while($row = $getTopTen10->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['USERNAME'] . "</td>"; //Current Username of user in loop
            echo "<td>" . $row['POINTS'] . "</td>" ; //Current Points of user in loop
            echo "<td>" . $this->getVoteNum($row['USER_ID']) . "</td>"; //Current counted votes of user in loop
            echo "<td>" . $this->calcPercentCorrect($row['USER_ID']). "% </td>"; //Current calculated percentage correct votes of user in loop
            echo "</tr>";
        }
    }

    function createBar()
    {
        echo "<p class='navbar-text navbar-right'>";

        if(isset($_COOKIE["username"]))
        {
            echo("Signed in as <a href=\"./profile.php?username=".$_COOKIE['username']."\" class=\"navbar-link\">".$_COOKIE['username']."</a> <a class=\"navbar-link\" href=\"logout.php\">[Logout]</a>");
        }
        else {
            echo("<a href=\"\" data-toggle=\"modal\" data-target=\"#login\" class=\"navbar-link\">Login</a> or <a href=\"\" data-toggle=\"modal\" data-target=\"#register\" class=\"navbar-link\">Register</a>");
        }

        echo "</p>";
        $this->createRegister();
        $this->createLogin();
    }

    function createRegister()
    {
      ?>
       <div class="modal fade" id="register" tabindex="-2" role="dialog" aria-labelledby="registerLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="registerLabel">Register</h4>
              </div>
              <div class="modal-body">

                <form role="form" action="register.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"  placeholder="Email Address">
                  </div>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="verifypassword">Verify Password</label>
                    <input type="password" class="form-control" id="verifypassword" name="verifypassword" placeholder="Verify Password">
                  </div>
                    <?php
                        echo '<input type="hidden" name="page" value="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'] .'">';
                    ?>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    <?php
    }

    function createLogin()
    {
        ?>
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="loginLabel">Login</h4>
                    </div>
                    <div class="modal-body">

                        <form role="form" method="post" action="login.php">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            </div>
                            <?php
                            echo '<input type="hidden" name="page" value="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'] .'">';
                            ?>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
<?php
    }

    function checkLogin($fUsername, $fPassword)
    {
        $hashedPassword = md5($fPassword);

        $query = $this->db->prepare("SELECT * FROM user WHERE USERNAME = '".$fUsername."' AND PASSWORD = '".$hashedPassword."'");
        $query->execute();
        $count = $query->rowCount();
        echo $hashedPassword;
        if($count == 1 )
        {
            return true;
        }
        else {
            return false;
        }
    }

    function createUser($username, $password, $email)
    {
        $passwordhashed = md5($password);
        $date_joined = date('y/m/d');
        $query = $this->db->prepare("INSERT INTO user (`USERNAME`,`PASSWORD`,`EMAIL_ADDRESS`, `DATE_JOINED`) VALUES ( :username, :password, :email, :date_joined)");
        $query->execute(array(':username' => $username, ':password' => $passwordhashed, ':email'=> $email, ':date_joined' => $date_joined));
    }

    function verifyLogin($fUsername,$fPassword)
    {
            if($this->checkLogin($fUsername,$fPassword) == true)
            {
                setcookie("username", $fUsername, time()+3600);
            }
    }

    function catcherrors()
    {
        if(isset($_GET['error']))
        {
            if($_GET['error'] == "password")
            {
                echo '<p class="bg-danger">Your Passwords do not match</p>';
            }
            elseif ($_GET['error'] == "username")
            {
                echo '<p class="bg-danger">A user already has that username</p>';
            }
            elseif ($_GET['error'] == "email")
            {
                echo '<p class="bg-danger">A user already has that email</p>';
            }
            elseif ($_GET['error'] == "usernamelengthsm")
            {
                echo '<p class="bg-danger">Your username must be longer than 2 characters</p>';
            }
            elseif ($_GET['error'] == "usernamelengthlr")
            {
                echo '<p class="bg-danger">Your username must not be longer than 20 characters</p>';
            }
            elseif ($_GET['error'] == "login")
            {
                echo '<p class="bg-danger">Wrong Username or Password</p>';
            }
            elseif ($_GET['error'] == "none")
            {
                echo '<p class="bg-success">Success! User created please login!</p>';

            }
            elseif($_GET['error'] == "vote")
            {
                echo '<p class="bg-success">Success! Vote created please check your vote history!</p>';
            }
            elseif ($_GET['error'] == "loggedin")
            {
                echo '<p class="bg-danger">You need to be logged in to do that</p>';
            }
        }
    }

    function getIDfromName($username)
    {
        $getID = $this->db->prepare('SELECT * FROM `user` WHERE USERNAME="' . $username . '"');
        $getID->execute();
        while($row = $getID->fetch(PDO::FETCH_ASSOC)) {
            return $row['USER_ID'];
        }
    }

    function getUserPoints($userid)
    {
        $getpoints = $this->db->prepare('SELECT * FROM `user` WHERE USER_ID="' . $userid . '"');
        $getpoints->execute();
        while($row = $getpoints->fetch(PDO::FETCH_ASSOC)) {
            return $row['POINTS'];
        }
    }

    function getUserEmail($userid)
    {
        $getEmail = $this->db->prepare('SELECT * FROM `user` WHERE USER_ID="' . $userid . '"');
        $getEmail->execute();
        while($row = $getEmail->fetch(PDO::FETCH_ASSOC)) {
            return $row['EMAIL_ADDRESS'];
        }
    }

    function createProfileBox()
    {
        $userid = $this->getIDfromName($_GET['username']);
        echo '<div class="col-md-6">';

		echo '<img src="./img/uploads/'.$userid.'.jpg" class="img-rounded" height="150" style="float:right">';
		echo '<p style="font-size:30px;font-weight:800">' . $_GET['username'] . '<p>';
		echo '<p>Email: '.$this->getUserEmail($userid).'<br/>';
		echo 'Total Votes: '.$this->getVoteNum($userid).'<br/>';
		echo 'Success percentage: '.$this->calcPercentCorrect($userid).'%<br/>';
		echo '</p><p>';
        echo '<b>Points</b><br/>';
		echo $this->getUserPoints($userid). ' <img src="./img/coin.png" width="20">';
		echo '</p>';
	    echo '</div>';
    }

    function createProfileVotes($userid) {

        echo "<table class='table table-bordered'>";
        echo "<tr>";
        echo "<th>Game</th>";
        echo "<th>Type</th>";
        echo "<th>Vote</th>";
        echo "<th>Result</th>";
        echo "</tr>";

        $profile = $this->db->prepare('SELECT * FROM game INNER JOIN vote ON game.GAME_ID = vote.GAME_ID WHERE USER_ID="' . $userid . '"');
        $profile->execute();
        while($row = $profile->fetch(PDO::FETCH_ASSOC)) {
            if($row['VOTE_RESULT'] == "TRUE")
            {
                echo "<tr class='success''>";
            }
            elseif($row['VOTE_RESULT'] == "FALSE")
            {
                echo "<tr class='danger''>";
            }
            else
            {
                echo "<tr class='info'>";
            }

            echo "<td>". $row['TEAM_1']." vs ".$row['TEAM_2']. "</td>";

            echo "<td>".$row['VOTE_TYPE']."</td>";
            echo "<td>".$row['INPUTTED_VOTE']."</td>";

            if($row['VOTE_RESULT'] == "TRUE")
            {
                echo "<td>SUCCESSFUL</td>";
            }
            elseif($row['VOTE_RESULT'] == "FALSE")
            {
                echo "<td>UNSUCCESSFUL</td>";
            }
            else
            {
                echo "<td>IN PROGRESS</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    function createVoteModal($type,$team1,$team2,$gameid)
    {
      echo '<div class="modal fade" id="'.$team1.$team2.$type.'" tabindex="-1" role="dialog" aria-labelledby="'.$team1.$team2.$type.'" aria-hidden="true">';
        echo '<div class="modal-dialog">';
      echo '<div class="modal-content">';
      echo '<div class="modal-header">';
      echo ' <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
      echo ' <h4 class="modal-title" id="'.$team1.$team2.$type.'">'.ucfirst($type).' Vote</h4>';
      echo ' </div>';
      echo ' <div class="modal-body">';
        echo '   <form method="POST" action="placevote.php">';


        if($type == "winner")
        {
	  echo '	<div class="radio">';
	  echo '	  <label>';
	  echo '		<input type="radio" name="winnervote" id="'. ucfirst($team2).'" value="'. $team2.'" checked>';
      echo 'Team '.ucfirst($team1);
      echo '</label>';
	  echo '	</div>';
	  echo '	<div class="radio">';
	  echo '	  <label>';
	  echo '		<input type="radio" name="winnervote" id="'.ucfirst($team2).'" value="'. $team2.'">';
      echo '   Team '. ucfirst($team2);
      echo '</label>';
	  echo '	</div>';
        }
        elseif($type == "LVP")
        {
            echo '<select name="winnervote">';
            echo '<option value="'.$team1.'Player1">'.$team1.' Player1</option>';
            echo '<option value="'.$team2.'Player1">'.$team2.' Player1</option>';
            echo '<option value="'.$team1.'Player2">'.$team1.' Player2</option>';
            echo '<option value="'.$team2.'Player2">'.$team2.' Player2</option>';
            echo '<option value="'.$team1.'Player3">'.$team1.' Player3</option>';
            echo '<option value="'.$team2.'Player3">'.$team2.' Player3</option>';
            echo '<option value="'.$team1.'Player4">'.$team1.' Player4</option>';
            echo '<option value="'.$team2.'Player4">'.$team2.' Player4</option>';
            echo '<option value="'.$team1.'Player5">'.$team1.' Player5</option>';
            echo '<option value="'.$team2.'Player5">'.$team2.' Player5</option>';
            echo '</select>';
        }
        elseif($type == "MVP")
        {
            echo '<select name="winnervote">';
            echo '<option value="'.$team1.'Player1">'.$team1.' Player1</option>';
            echo '<option value="'.$team2.'Player1">'.$team2.' Player1</option>';
            echo '<option value="'.$team1.'Player2">'.$team1.' Player2</option>';
            echo '<option value="'.$team2.'Player2">'.$team2.' Player2</option>';
            echo '<option value="'.$team1.'Player3">'.$team1.' Player3</option>';
            echo '<option value="'.$team2.'Player3">'.$team2.' Player3</option>';
            echo '<option value="'.$team1.'Player4">'.$team1.' Player4</option>';
            echo '<option value="'.$team2.'Player4">'.$team2.' Player4</option>';
            echo '<option value="'.$team1.'Player5">'.$team1.' Player5</option>';
            echo '<option value="'.$team2.'Player5">'.$team2.' Player5</option>';
            echo '</select>';
        }

      echo ' </div>';
      echo '<input type="hidden" name="votetype" value="'.$type.'">';
      echo '<input type="hidden" name="gameid" value="'.$gameid.'">';
      echo '<input type="hidden" name="page" value="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'] .'">';
      echo ' <div class="modal-footer">';
      echo '   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
      echo '   <button type="submit" class="btn btn-primary">Place Vote</button>';
        echo '	</form>';
        echo ' </div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }

    function createVoteButton($team1,$team2,$gameid)
    {
       echo' <a href="" class="btn btn-primary" data-toggle="modal" data-target="#'.$team1.$team2.'winner">Vote for Winner</a>';
		echo'	<a href="" class="btn btn-primary" data-toggle="modal" data-target="#'.$team1.$team2.'MVP">Vote for MVP</a>';
		echo'	<a href="" class="btn btn-primary" data-toggle="modal" data-target="#'.$team1.$team2.'LVP">Vote for LVP</a>'
        ;

        $this->createVoteModal("winner",$team1,$team2,$gameid);
        $this->createVoteModal("MVP",$team1,$team2,$gameid);
        $this->createVoteModal("LVP",$team1,$team2,$gameid);

    }

    function makeVote($gameid,$userid,$votetype,$inputvote)
    {

        $datetime = date('y/m/d H:i:s');
        $query = $this->db->prepare("INSERT INTO `vote` (`VOTE_ID`, `GAME_ID`, `USER_ID`, `VOTE_TYPE`, `INPUTTED_VOTE`, `VOTE_DATETIME`) VALUES (NULL, :gameid, :userid, :votetype, :inputtedvote, :datetime)");
        $query->execute(array(':gameid' => $gameid, ':userid' => $userid, ':votetype' => $votetype, ':inputtedvote'=> $inputvote, ':datetime'=> $datetime));
    }

    function createVotePage()
    {
        $profile = $this->db->prepare('SELECT * FROM `game`');
        $profile->execute();
        while($row = $profile->fetch(PDO::FETCH_ASSOC))
        {
            echo'<div class="col-md-12" style="margin-bottom:20px">';
            echo'        <p><a data-toggle="collapse" data-parent="#games" href="#game'.$row['GAME_ID'].'"><h2>'.ucfirst($row['TEAM_1']).' vs '.ucfirst($row['TEAM_2']).'</h2></a></p>';
            echo'        <p class="pull-right" style="margin-top: -50px;"><img src="./img/teams/'.strtolower($row['TEAM_1']).'.png" height="50px"> <img src="./img/teams/vs.png" height="50px"> <img src="./img/teams/'.strtolower($row['TEAM_2']).'.png" height="50px"></p>';
            echo'        <br/>';
            echo'        <div id="game'.$row['GAME_ID'].'" class="pull-left collapse">';
            $this->createVoteButton(strtolower($row['TEAM_1']),strtolower($row['TEAM_2']),$row['GAME_ID']);
            echo'</div>';
            echo'</div>';
        }
    }

    function calcVote($gameid,$type)
    {
        $votemode = $this->db->prepare("SELECT `INPUTTED_VOTE`, COUNT(`INPUTTED_VOTE`) AS 'value' FROM vote WHERE GAME_ID=".$gameid." AND VOTE_TYPE='".$type."' GROUP BY `VOTE_TYPE` ORDER BY `value` DESC 	LIMIT 1");
        $votemode->execute();
        while($row = $votemode->fetch(PDO::FETCH_ASSOC)) {
            return $row['INPUTTED_VOTE'];
        }
    }

    function awardUsers($gameid,$winner)
    {
        $winnerpoints = $this->db->prepare("SELECT user.USER_ID FROM `user` INNER JOIN vote ON vote.USER_ID = `user`.USER_ID WHERE GAME_ID = ".$gameid." AND INPUTTED_VOTE = '".$winner."'");        $winnerpoints->execute();
       while($row = $winnerpoints->fetch(PDO::FETCH_ASSOC)) {
          $this->awardPoints($row['USER_ID'],10);
        }
        $awardwinner = $this->db->prepare("UPDATE vote SET VOTE_RESULT = 'TRUE' WHERE GAME_ID = ".$gameid." AND INPUTTED_VOTE ='".$winner."'");
        $awardwinner->execute();

        $MVP = $this->calcVote($gameid,"MVP");
        $mvppoints = $this->db->prepare("SELECT user.USER_ID FROM `user` INNER JOIN vote ON vote.USER_ID = `user`.USER_ID WHERE GAME_ID = ".$gameid." AND INPUTTED_VOTE = '".$MVP."'");
        $mvppoints->execute();
        while($row = $mvppoints->fetch(PDO::FETCH_ASSOC)) {
            $this->awardPoints($row['USER_ID'],5);
        }
        $awardMVP = $this->db->prepare("UPDATE vote SET VOTE_RESULT = 'TRUE' WHERE GAME_ID = ".$gameid." INPUTTED_VOTE =".$MVP);
        $awardMVP->execute();

        $LVP = $this->calcVote($gameid,"LVP");
        $lvppoints = $this->db->prepare("SELECT user.USER_ID FROM `user` INNER JOIN vote ON vote.USER_ID = `user`.USER_ID WHERE GAME_ID = ".$gameid." AND INPUTTED_VOTE = '".$LVP."'");
        $lvppoints->execute();
       while($row = $lvppoints->fetch(PDO::FETCH_ASSOC)) {
            $this->awardPoints($row['USER_ID'],5);
        }
        $awardLVP = $this->db->prepare("UPDATE vote SET VOTE_RESULT = 'TRUE' WHERE GAME_ID = ".$gameid." INPUTTED_VOTE =".$LVP);
        $awardLVP->execute();
    }

    function awardPoints($userid,$points)
    {
        $awarduser = $this->db->prepare("UPDATE user SET POINTS = POINTS + ".$points." WHERE USER_ID = ".$userid);
        $awarduser->execute();
    }
}
