<?php
session_start();
require_once "connection.php";
//join league
$lid = $_POST['league_id'];
$uid = $_SESSION['id'];

$sql1 = "SELECT team_id FROM draftteam WHERE user_id = $uid;";
$stmt1 = $pdo->query($sql1);
$result = $stmt1->fetch();
$tid = $result["team_id"];
// get the judge conditions ready
$query = "SELECT * FROM leagueteam WHERE team_id = $tid AND league_id = $lid";
$statement = $pdo->prepare($query);
$statement->execute();

$query3 = "SELECT * FROM leagueteam WHERE team_id = $tid";
$statement3 = $pdo->prepare($query3);
$statement3->execute();

$query1 = "SELECT * FROM leagueteam WHERE league_id = $lid";
$statement1 = $pdo->prepare($query1);
$statement1->execute();

$query2 = "SELECT size FROM league WHERE league_id = $lid";
$statement2 = $pdo->query($query2);
$result = $statement2->fetch();
$size = $result["size"];
if($statement3->rowCount() == 0){
    if ($statement->rowCount() == 0) {
        if($statement1->rowCount() < $size){
        $sql2 = "INSERT INTO leagueteam (league_id, team_id) VALUES ($lid, $tid)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute();
        echo "OK";
        }else{
            echo "OVERSIZE";
        }
    }else{
        echo "DUP";
    }
}else{
    echo "ONLY";
}

?>
