<?php
session_start();
require_once "connection.php";
//get post value from ajax
$team_name = $_POST['team_name'];
//get session value
$user_id = $_SESSION['id'];
//execute sql to check whether the record exists
$query = "SELECT team_name FROM draftteam WHERE team_name = $team_name;";
$query1 = "SELECT user_id FROM draftteam WHERE user_id = $user_id;";
$statement = $pdo->prepare($query);
$statement->execute();

$statement1 = $pdo->prepare($query1);
$statement1->execute();
if ($statement->rowCount() > 0) {
    echo "namedup";
} elseif ($statement1->rowCount() > 0) {
    echo "teamdup";
} else {
    if (!empty($_POST['formation']) && !empty($_POST['stratagy']) && !empty($_POST['team_name'])) {
        $id = $_SESSION['id'];

        //insert draft team into database
        $sql = "INSERT INTO draftteam (user_id, team_name, formation, stratagy, team_total_point) VALUES ($id, :team_name, :formation, :stratagy, :total_point)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':team_name', $_POST['team_name'], PDO::PARAM_STR);
        $stmt->bindParam(':formation', $_POST['formation'], PDO::PARAM_STR);
        $stmt->bindParam(':stratagy', $_POST['stratagy'], PDO::PARAM_STR);
        $stmt->bindParam(':total_point', $_POST['total_point'], PDO::PARAM_INT);
        $stmt->execute();

        //get team id
        $sql1 = "SELECT team_id FROM draftteam WHERE user_id = $id;";
        $stmt1 = $pdo->query($sql1);
        $result = $stmt1->fetch();
        $team_id = $result["team_id"];

        $data = json_decode(stripslashes($_POST['player_id']));
        foreach ($data as $d) {
            $sql2 = "INSERT INTO teamplayer (team_id, player_id) VALUES ($team_id, $d)";
            $stmt2 = $pdo->prepare($sql2);
            try {
                $stmt2->execute();
            } catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
                echo "error";
            }
        }
        echo "OK";
    } else {
        echo "emptyinput";
    }
}
?>
