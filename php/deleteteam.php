<?php
//delete draft team and related records
require_once "connection.php";
if (isset($_POST['user_id'])) {
    $uid = $_POST['user_id'];

    $sql2 = "SELECT team_id FROM draftteam WHERE user_id =$uid";
    $res = $pdo->query($sql2)->fetch();
    $count2 = $pdo->query($sql2)->rowCount();

    $sql5 = "SELECT league_id FROM league WHERE owner_id = $uid";
    $res1 = $pdo->query($sql5)->fetchAll();
    $count3 = $pdo->query($sql5)->rowCount();

    if ($count3 > 0) {
        $sql7 = "DELETE FROM league WHERE owner_id = $uid";
        $stmt7 = $pdo->prepare($sql7);
        foreach ($res1 as $row) {
            $sql6 = "DELETE FROM leagueteam WHERE league_id = '" . $row['league_id'] . "'";
            $statement = $pdo->prepare($sql6);
            $statement->execute();
            $sql8 = "DELETE FROM matchrecord WHERE league_id = '" . $row['league_id'] . "'";
            $statement1 = $pdo->prepare($sql8);
            $statement1->execute();
        }
        $stmt7->execute();
    }

    if ($count2 > 0) {
        $sql3 = "DELETE FROM teamplayer WHERE team_id =  '" . $res['team_id'] . "'";
        $stmt3 = $pdo->prepare($sql3);
        $sql2 = "DELETE FROM matchrecord WHERE home =  '" . $res['team_id'] . "'";
        $stmt2 = $pdo->prepare($sql2);
        $sql5 = "DELETE FROM matchrecord WHERE away =  '" . $res['team_id'] . "'";
        $stmt5 = $pdo->prepare($sql5);
        $sql4 = "DELETE FROM leagueteam WHERE team_id =  '" . $res['team_id'] . "'";
        $stmt4 = $pdo->prepare($sql4);
        $sql1 = "DELETE FROM draftteam WHERE user_id = $uid";
        $stmt1 = $pdo->prepare($sql1);

        $stmt4->execute();
        $stmt3->execute();
        $stmt1->execute();
        $stmt2->execute();
        $stmt5->execute();
    }
    echo "OK";
} else {
    echo "NO";
}
