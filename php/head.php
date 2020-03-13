<nav class="navbar navbar-expand-lg navbar-light" style="background-color: cyan;">
    <a class="navbar-brand" href="../homepage.html">
        <img src="../image/Premier_League_Logo.svg.png" width="120" height="50">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="mainpage.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="draft.php">Draft</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">League</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="createleague.php">Create A New League</a>
                    <a class="dropdown-item" href="joinleague.php">Join An Existed League</a>
                    <a class="dropdown-item" href="match.php">Your League/Match Center</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Statistics</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="myteam.php">My team</a>
                    <div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='playerdata.php'>Player database</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav mr-sm-5">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if (isset($_SESSION['username']) && isset($_SESSION['loggedin'])) {
                        echo $_SESSION["username"];;
                    } else {
                        echo "Guest";
                    } ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a id="login_button" class="dropdown-item" href="login.php">Login</a>
                    <a id="register_button" class="dropdown-item" href="register.php">Register</a>
                    <a id="reset_button" style="display: none;" class="dropdown-item" href="resetpassword.php">Reset Password</a>
                    <a id="logout_button" style="display: none;" class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<?php
if (isset($_SESSION["username"])) {
    echo '<script>';
    echo 'document.getElementById("login_button").style.display="none";';
    echo 'document.getElementById("register_button").style.display="none";';
    echo 'document.getElementById("reset_button").style.display="block";';
    echo 'document.getElementById("logout_button").style.display="block";';
    echo '</script>';
}
?>
<script type="text/javascript">
    <?php if (isset($_SESSION['adminname']) && isset($_SESSION['adminloggedin'])) {
        echo "document.getElementById('navbarSupportedContent').style.visibility = 'hidden';";
    } else {
        echo "document.getElementById('navbarSupportedContent').style.visibility = 'visible';";
    } ?>
</script>