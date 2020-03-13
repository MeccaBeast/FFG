<?php
// Include config file
require_once "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Define variables and initialize with empty values
$username = $email = $password = $tel = $confirm_password = $ans = $question = "";
$username_err = $email_err = $password_err = $tel_err = $confirm_password_err = $ans_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST["question"];
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT user_id FROM user WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } elseif (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email = trim($_POST["email"]);
    } else {
        $email_err = "This is not a valid email address";
    }

    if (empty(trim($_POST["ans"]))) {
        $ans_err = "Please enter an answer.";
    } else {
        $ans = trim($_POST["ans"]);
    }

    function validate_phone_number($phone)
    {
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        // Check the lenght of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            return false;
        } else {
            return true;
        }
    }

    if (empty(trim($_POST["tel"]))) {
        $tel_err = "Please enter a telephone number.";
    } elseif (validate_phone_number($_POST["tel"]) == true) {
        $tel = trim($_POST["tel"]);
    } else {
        $tel_err = "This is not a valid telephone number";
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($email_err) && empty($confirm_password_err)) {
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            // Google reCAPTCHA API secret key 
            $secretKey = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';

            // Verify the reCAPTCHA response 
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);

            // Decode json data 
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {

                // Prepare an insert statement
                $sql = "INSERT INTO user (username, password, email, tel, isEmailConfirmed, safequestion, answer,token) VALUES (:username, :password, :email, :tel, '0', :ques, :ans, :token)";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                    $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    $stmt->bindParam(":tel", $param_tel, PDO::PARAM_STR);
                    $stmt->bindParam(":ques", $param_ques, PDO::PARAM_STR);
                    $stmt->bindParam(":ans", $param_ans, PDO::PARAM_STR);

                    $token = 'sdlfdkfhgDSJKFAHUS123987!@';
                    $token = str_shuffle($token);
                    $token = substr($token, 0, 10);
                    $stmt->bindParam(":token", $token, PDO::PARAM_STR);
                    // Set parameters
                    $param_username = $username;
                    $param_email = $email;
                    $param_tel = $tel;
                    $param_ques = $question;
                    $param_ans = $ans;
                    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        require_once '../phpmailer/vendor/autoload.php';

                        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                        try {
                            //Server settings
                            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                            $mail->isSMTP();                                      // Set mailer to use SMTP
                            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                            $mail->SMTPAuth = true;                               // Enable SMTP authentication
                            $mail->Username = 'gba78769df@gmail.com';                 // SMTP username
                            $mail->Password = 'mc081229snake';                           // SMTP password
                            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                            $mail->Port = 587;
                            $mail->SMTPOptions = array(
                                'ssl' => array(
                                    'verify_peer' => false,
                                    'verify_peer_name' => false,
                                    'allow_self_signed' => true
                                )
                            ); // TCP port to connect to

                            //Recipients
                            $mail->setFrom('gba78769df@gmail.com', 'Durham EPL Fantasy Football Game');
                            $mail->addAddress($email, $username);   // Add a recipient

                            //Content
                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = 'Please verify email!';
                            $mail->Body    = "
                          Please click on the link below:<br><br>

                          <a href='http://localhost/dashboard/FFG/php/confirm.php?email=$email&token=$token'>Click here</a>";
                            if ($mail->send()) {
                                $msg = "You have been registered! Please verify your email!";
                                echo "<script>alert('$msg');window.location.href='../homepage.html';</script>";
                            } else {
                                $msg = "Error!Please try again!";
                                echo "<script>alert('$msg');</script>";
                            }
                        } catch (Exception $e) {
                            echo 'Message could not be sent.';
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                        }
                    } else {
                        echo "Something went wrong. Please try again later.";
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
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
    <title>Sign Up-Premier League Fantasy Football</title>
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
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email address</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($tel_err)) ? 'has-error' : ''; ?>">
                <label>Telephone Number</label>
                <input type="text" name="tel" class="form-control" value="<?php echo $tel; ?>">
                <span class="help-block"><?php echo $tel_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Security Question</label>
                <select class="form-control" name="question" id="question">
                    <option selected>Select A Formation</option>
                    <option value="What's your mother's birthday?">What's your mother's birthday?</option>
                    <option value="Where were you born?">Where were you born?</option>
                    <option value="What is your favourite motto?">What is your favourite motto?</option>
                </select>
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
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</html>