<?php
// Include config file
session_start();
require_once "connection.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    echo "<script>if(confirm('To create a league, you have to log in first!')){document.location.href='login.php'}else{document.location.href='mainpage.php'};</script>";
}

$user_id = $_SESSION['id'];
$query = "SELECT user_id, team_name, formation, stratagy FROM draftteam WHERE user_id = $user_id;";
$statement = $pdo->prepare($query);
$statement->execute();
$result = $statement->fetch();
if ($statement->rowCount() == 0) {
    echo "<script>if(confirm('To create a league, you have to draft your team first!')){document.location.href='draft.php'}else{document.location.href='draft.php'};</script>";
}

// Define variables and initialize with empty values
$lname = $size = $att = "";
$lname_err = $size_err = $att_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["lname"]))) {
        $lname_err = "Please enter a league name.";
    } else {
        // Prepare a select statement
        $sql = "SELECT league_id FROM league WHERE league_name = :lname";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":lname", $param_lname, PDO::PARAM_STR);

            // Set parameters
            $param_lname = trim($_POST["lname"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $lname_err = "This league name is already taken.";
                } else {
                    $lname = trim($_POST["lname"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    if (empty(trim($_POST["size"])) || trim($_POST["size"]) > 20) {
        $size_err = "Please enter a size for your league, the size can not be over 20.";
    } else {
        $size = trim($_POST["size"]);
    }

    // Validate password
    if (empty(trim($_POST["att"]))) {
        $att_err = "Please make a selection to determine whether your league is public.";
    } else {
        $att = trim($_POST["att"]);
    }

    // Check input errors before inserting in database
    if (empty($lname_err) && empty($size_err) && empty($att_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO league (league_name, size, attribute, owner_id) VALUES (:lname, :size, :att, :uid);";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":lname", $param_lname, PDO::PARAM_STR);
            $stmt->bindParam(":size", $param_size, PDO::PARAM_STR);
            $stmt->bindParam(":att", $param_att, PDO::PARAM_STR);
            $stmt->bindParam(":uid", $param_uid, PDO::PARAM_STR);

            // Set parameters
            $param_lname = $lname;
            $param_size = $size;
            $param_att = $att;
            $param_uid = $user_id;

            // Attempt to execute the prepared statement
            $stmt->execute();

            $query = "SELECT team_id FROM draftteam WHERE user_id = $user_id;";
            $statement = $pdo->prepare($query);
            $statement->execute(); 
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $team_id = $row["team_id"];

            $query1 = "SELECT league_id FROM league WHERE owner_id = $user_id;";
            $statement1 = $pdo->prepare($query1);
            $statement1->execute(); 
            $row1 = $statement1->fetch(PDO::FETCH_ASSOC);
            $league_id = $row1["league_id"];

            $sql1 = "INSERT INTO leagueteam (league_id, team_id) VALUES (:lid, :tid)";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->bindParam(":lid", $param_lid, PDO::PARAM_STR);
            $stmt1->bindParam(":tid", $param_tid, PDO::PARAM_STR);

            $param_lid = $league_id;
            $param_tid = $team_id;
            
            if ($stmt1->execute()) {
                // Redirect to login page
                header("location: myteam.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
        unset($stmt1);
        unset($statement);
        unset($statement1);
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
    <title>Create A New League-Premier League Fantasy Football</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include 'head.php';
    ?>
    <div class="wrapper">
        <h2>Create a New League</h2>
        <p>Please fill this form to create a league.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>">
                <label>League Name</label>
                <input type="text" name="lname" class="form-control" value="<?php echo $lname; ?>">
                <span class="help-block"><?php echo $lname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($size_err)) ? 'has-error' : ''; ?>">
                <label>League Size</label>
                <select name="size" class="form-control" value="<?php echo $size; ?>">
                <option selected>Please make a selection</option>
                <option value="12">12</option>
                <option value="14">14</option>
                <option value="16">16</option>
                <option value="18">18</option>
                <option value="20">20</option>
                </select>
                <span class="help-block"><?php echo $size_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($att_err)) ? 'has-error' : ''; ?>">
                <label>Attributes</label>
                <select class="form-control" value="<?php echo $att; ?>" name="att">
                    <span class="help-block"><?php echo $att_err; ?></span>
                    <option selected>Please make a selection</option>
                    <option value="Private">Private</option>
                    <option value="Public">Public</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Or you wanna join a league <a href="joinleague.php">Join here</a>.</p>
        </form>
    </div>
</body>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</html>