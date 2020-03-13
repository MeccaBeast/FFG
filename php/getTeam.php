<?php
require_once "connection.php";
$output = "";
if (isset($_POST['lid'])) {
    $lid = $_POST['lid'];
    $sql = "SELECT team_id FROM leagueteam WHERE league_id = $lid";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    foreach ($result as $row) {
        $tid = $row['team_id'];
        $sql1 = "SELECT team_name FROM draftteam WHERE team_id = $tid";
        $result1 = $pdo->query($sql1)->fetch();
        $tname = $result1['team_name'];
        $output .= "<option value = '$tid'>$tid, $tname</option>";
    }
    echo $output;
} else {
    return false;
}
?>
