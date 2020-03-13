<?php
// Initialize the session
session_start();
$id = $_SESSION['id'];
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "connection.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = $ans = "";
$new_password_err = $confirm_password_err = $ans_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have atleast 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    if (empty(trim($_POST["ans"]))) {
        $ans_err = "Please enter an answer.";
    } else {
        $ans = trim($_POST["ans"]);
    }

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            // Google reCAPTCHA API secret key 
            $secretKey = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';

            // Verify the reCAPTCHA response 
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);

            // Decode json data 
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {
                // Prepare an update statement
                $sql = "SELECT answer FROM user WHERE user_id = $id";
                $res = $pdo->query($sql)->fetch();

                if ($ans !== $res["answer"]) {
                    echo "<script>alert('The answer you give is wrong!');</script>";
                } else {
                    $sql = "UPDATE user SET password = :password WHERE user_id = :user_id";

                    if ($stmt = $pdo->prepare($sql)) {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                        $stmt->bindParam(":user_id", $param_id, PDO::PARAM_INT);

                        // Set parameters
                        $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $param_id = $id;

                        // Attempt to execute the prepared statement
                        if ($stmt->execute()) {
                            // Password updated successfully. Destroy the session, and redirect to login page
                            session_destroy();
                            header("location: login.php");
                            exit();
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                }
            } else {
                $statusMsg = 'Robot verification failed, please try again.';
                echo "<script>alert('$statusMsg');</script>";
            }
        } else {
            $statusMsg = 'Please check on the reCAPTCHA box.';
            echo "<script>alert('$statusMsg');</script>";
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password-Premier League Fantasy Football</title>
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include 'head.php';
    ?>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Security Question</label>
                <p>Your Security Question is: <?php $sql = "SELECT safequestion from user where user_id = $id";
                                                $res = $pdo->query($sql)->fetch();
                                                echo $res["safequestion"];
                                                ?></p>
            </div>
            <div class="form-group <?php echo (!empty($ans_err)) ? 'has-error' : ''; ?>">
                <label>Answer</label>
                <input type="text" name="ans" class="form-control" value="<?php echo $ans; ?>">
                <span class="help-block"><?php echo $ans_err; ?></span>
            </div>
            <!-- Google reCAPTCHA box -->
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</html>