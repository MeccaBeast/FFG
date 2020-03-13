<?php
session_start();
require_once "connection.php";
require_once "jsoncon.php";
$user_id = $_SESSION['id'];
error_reporting(E_ALL);
echo "<pre>";

// DISTRIBUTE TEAMS INTO CONTESTS

// THE TEAMS
$sql = "SELECT team_id FROM draftteam WHERE user_id = $user_id";
$result = $pdo->query($sql)->fetch();
$team_id = $result['team_id'];

$sql1 = "SELECT league_id FROM leagueteam WHERE team_id =  $team_id";
$result1 = $pdo->query($sql1)->fetch();
$l_id = $result1['league_id'];

$sql2 = "SELECT team_id FROM leagueteam WHERE league_id =  $l_id";
$teams = $pdo->query($sql2)->fetchAll(PDO::FETCH_COLUMN);
$count = count($teams);

if ($count <= 1) {
    echo "<h3>There should be at least 2 teams in the league to show the match schedule.</h3>";
} else {
    // HOW MANY WEEKS
    $weeks = $count - 1;

    // MAKE ENOUGH ARRAY ELEMENTS FOR THE DISTRIBUTION
    $array = array_merge($teams, $teams);

    // POPULATE THE MATCHES ARRAY
    $matches = array();
    while ($weeks) {
        foreach ($teams as $ptr => $team) {
            // FIND THE INDEX INTO THE DISTRIBUTION ARRAY
            $link = $ptr + $weeks;

            // SELECT THE HOME AND AWAY TEAMS
            $home = $team;
            $gk_tp = 0;
            $df_tp = 0;
            $mf_tp = 0;
            $fw_tp = 0;
            $home_tp = 0;
            $query = "SELECT player_id FROM teamplayer WHERE team_id = $home";
            $result = $pdo->query($query)->fetchAll(PDO::FETCH_COLUMN);
            $sql = "SELECT stratagy FROM draftteam WHERE team_id = $home";
            $res = $pdo->query($sql)->fetch();
            $sql1 = "SELECT formation FROM draftteam WHERE team_id = $home";
            $res1 = $pdo->query($sql1)->fetch();

            if($res['stratagy']=="Ultimate Attacking"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $gk_tp = $gk_tp + $data['elements'][$q]['total_points']*0.75;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $df_tp = $df_tp + $data['elements'][$q]['total_points']*0.5;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $mf_tp = $mf_tp + $data['elements'][$q]['total_points']*1.75;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $fw_tp = $fw_tp + $data['elements'][$q]['total_points']*2;
                            }
                        }
                    }
                }
            }else if($res['stratagy']=="Tiki Taka"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $gk_tp = $gk_tp + $data['elements'][$q]['total_points']*1;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $df_tp = $df_tp + $data['elements'][$q]['total_points']*1;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $mf_tp = $mf_tp + $data['elements'][$q]['total_points']*1.5;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $fw_tp = $fw_tp + $data['elements'][$q]['total_points']*1.5;
                            }
                        }
                    }
                }
            }else if($res['stratagy']=="Total Football"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $gk_tp = $gk_tp + $data['elements'][$q]['total_points']*1.25;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $df_tp = $df_tp + $data['elements'][$q]['total_points']*1.25;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $mf_tp = $mf_tp + $data['elements'][$q]['total_points']*1.25;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $fw_tp = $fw_tp + $data['elements'][$q]['total_points']*1.25;
                            }
                        }
                    }
                }
            }else if($res['stratagy']=="Defence & Counterattack"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $gk_tp = $gk_tp + $data['elements'][$q]['total_points']*1.25;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $df_tp = $df_tp + $data['elements'][$q]['total_points']*1.5;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $mf_tp = $mf_tp + $data['elements'][$q]['total_points']*1.5;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $fw_tp = $fw_tp + $data['elements'][$q]['total_points']*0.75;
                            }
                        }
                    }
                }
            }else if($res['stratagy']=="Ultimate Defending"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $gk_tp = $gk_tp + $data['elements'][$q]['total_points']*1.25;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $df_tp = $df_tp + $data['elements'][$q]['total_points']*2;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $mf_tp = $mf_tp + $data['elements'][$q]['total_points']*1.25;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $fw_tp = $fw_tp + $data['elements'][$q]['total_points']*0.75;
                            }
                        }
                    }
                }
            }

            if($res1['formation']=="4-3-3"){
                $home_tp = $fw_tp*1.5 + $mf_tp*1.25 + $df_tp*0.75 + $gk_tp;
            }else if($res1['formation']=="4-3-2-1"){
                $home_tp = $fw_tp*1.25 + $mf_tp*1.25 + $df_tp + $gk_tp;
            }else if($res1['formation']=="4-2-3-1"){
                $home_tp = $fw_tp*1.125 + $mf_tp*1.125 + $df_tp*1.125 + $gk_tp*1.125;
            }else if($res1['formation']=="3-5-2"){
                $home_tp = $fw_tp + $mf_tp*1.25 + $df_tp*1.25 + $gk_tp;
            }else if($res1['formation']=="5-3-2"){
                $home_tp = $fw_tp*0.75 + $mf_tp*1.25 + $df_tp*1.5 + $gk_tp;
            }
            //print_r($home_tp);

            $agk_tp = 0;
            $adf_tp = 0;
            $amf_tp = 0;
            $afw_tp = 0;
            $away_tp = 0;
            $away = $array[$link];
            $query1 = "SELECT player_id FROM teamplayer WHERE team_id = $away";
            $result1 = $pdo->query($query1)->fetchAll(PDO::FETCH_COLUMN);
            $sql2 = "SELECT stratagy FROM draftteam WHERE team_id = $away";
            $res2 = $pdo->query($sql2)->fetch();
            $sql3 = "SELECT formation FROM draftteam WHERE team_id = $away";
            $res3 = $pdo->query($sql3)->fetch();

            if($res2['stratagy']=="Ultimate Attacking"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result1[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $agk_tp = $agk_tp + $data['elements'][$q]['total_points']*0.75;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $adf_tp = $adf_tp + $data['elements'][$q]['total_points']*0.5;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $amf_tp = $amf_tp + $data['elements'][$q]['total_points']*1.75;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $afw_tp = $afw_tp + $data['elements'][$q]['total_points']*2;
                            }
                        }
                    }
                }
            }else if($res2['stratagy']=="Tiki Taka"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result1[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $agk_tp = $agk_tp + $data['elements'][$q]['total_points']*1;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $adf_tp = $adf_tp + $data['elements'][$q]['total_points']*1;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $amf_tp = $amf_tp + $data['elements'][$q]['total_points']*1.5;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $afw_tp = $afw_tp + $data['elements'][$q]['total_points']*1.5;
                            }
                        }
                    }
                }
            }else if($res2['stratagy']=="Total Football"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result1[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $agk_tp = $agk_tp + $data['elements'][$q]['total_points']*1.25;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $adf_tp = $adf_tp + $data['elements'][$q]['total_points']*1.25;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $amf_tp = $amf_tp + $data['elements'][$q]['total_points']*1.25;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $afw_tp = $afw_tp + $data['elements'][$q]['total_points']*1.25;
                            }
                        }
                    }
                }
            }else if($res2['stratagy']=="Defence & Counterattack"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result1[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $agk_tp = $agk_tp + $data['elements'][$q]['total_points']*1.25;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $adf_tp = $adf_tp + $data['elements'][$q]['total_points']*1.5;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $amf_tp = $amf_tp + $data['elements'][$q]['total_points']*1.5;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $afw_tp = $afw_tp + $data['elements'][$q]['total_points']*0.75;
                            }
                        }
                    }
                }
            }else if($res2['stratagy']=="Ultimate Defending"){
                for ($i = 0; $i < 15; $i++) {
                    for ($q = 0; $q < count($data['elements']); $q++) {
                        if ($data['elements'][$q]['id'] == $result1[$i]) {
                            if($data['elements'][$q]['element_type'] == 1){
                                $agk_tp = $agk_tp + $data['elements'][$q]['total_points']*1.25;
                            } 
                            if($data['elements'][$q]['element_type'] == 2){
                                $adf_tp = $adf_tp + $data['elements'][$q]['total_points']*2;
                            }
                            if($data['elements'][$q]['element_type'] == 3){
                                $amf_tp = $amf_tp + $data['elements'][$q]['total_points']*1.25;
                            }
                            if($data['elements'][$q]['element_type'] == 4){
                                $afw_tp = $afw_tp + $data['elements'][$q]['total_points']*0.75;
                            }
                        }
                    }
                }
            }

            if($res3['formation']=="4-3-3"){
                $away_tp = $afw_tp*1.5 + $amf_tp*1.25 + $adf_tp*0.75 + $agk_tp;
            }else if($res3['formation']=="4-3-2-1"){
                $away_tp = $afw_tp*1.25 + $amf_tp*1.25 + $adf_tp + $agk_tp;
            }else if($res3['formation']=="4-2-3-1"){
                $away_tp = $afw_tp*1.125 + $amf_tp*1.125 + $adf_tp*1.125 + $agk_tp*1.125;
            }else if($res3['formation']=="3-5-2"){
                $away_tp = $afw_tp + $amf_tp*1.25 + $adf_tp*1.25 + $agk_tp;
            }else if($res3['formation']=="5-3-2"){
                $away_tp = $afw_tp*0.75 + $amf_tp*1.25 + $adf_tp*1.5 + $agk_tp;
            }
            //print_r($away_tp);

            if ($home_tp > $away_tp) {
                $winorlose = "WIN";
                $home_serial="10";
                $sql = "SELECT match_id FROM matchrecord WHERE home = $home AND away = $away";
                $res = $pdo->query($sql)->fetch();
                if ($res['match_id'] !== "$home_serial$home$away"  || $res['match_id'] == null) {
                    $sql = "INSERT INTO matchrecord(match_id, home, away, league_id, home_win, away_win, draw, date) VALUES ($home_serial$home$away,$home,$away,$l_id,1,0,0,CURRENT_TIMESTAMP)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                }
            } else if ($home_tp < $away_tp) {
                $winorlose = "LOSE";
                $away_serial="20";
                $sql = "SELECT match_id FROM matchrecord WHERE home = $home AND away = $away";
                $res = $pdo->query($sql)->fetch();
                if ($res['match_id'] !== "$away_serial$home$away"  || $res['match_id'] == null) {
                    $sql = "INSERT INTO matchrecord(match_id, home, away, league_id, home_win, away_win, draw, date) VALUES ($away_serial$home$away,$home,$away,$l_id,0,1,0,CURRENT_TIMESTAMP)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                }
            } else if ($home_tp == $away_tp) {
                $winorlose = "DRAW";
                $draw_serial = '30';
                $sql = "SELECT match_id FROM matchrecord WHERE home = $home AND away = $away";
                $res = $pdo->query($sql)->fetch();
                if ($res['match_id'] !== "$draw_serial$home$away" || $res['match_id'] == null) {
                    $sql = "INSERT INTO matchrecord(match_id, home, away, league_id, home_win, away_win, draw, date) VALUES ($draw_serial$home$away ,$home,$away,$l_id,0,0,1,CURRENT_TIMESTAMP);";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                }
            }

            $matches[$team][$weeks] = array('home' => $home, 'away' => $away, 'win' => $winorlose);
        }

        // NEXT WEEK
        $weeks--;
    }

    // SORT THE MATCHES SENSIBLY SO WEEK ONE COMES FIRST
    foreach ($matches as $team => $contests) {
        ksort($contests);
        $matches[$team] = $contests;
    }

    // CREATE THE TABLE OF MATCHUPS
    $out = NULL;
    $out .= "<div class='container'><table class='table table-bordered'><thead class='thead-dark'>";
    $out .= PHP_EOL;


    // CREATE THE HEADERS FOR EACH WEEK
    $weeknums = end($matches);

    $out .= "<tr>";
    $out .= '<th> HOME TEAM </th>';
    foreach ($weeknums as $week => $matchup) {
        $out .= "<th> WEEK $week </th>";
    }
    $out .= '</tr></thead>';
    $out .= PHP_EOL;

    // CREATE THE MATRIX OF MATCHUPS
    foreach ($matches as $team => $contests) {
        $sql = "SELECT user_id FROM draftteam WHERE team_id = $team";
        $res = $pdo->query($sql)->fetch();
        $sql1 = "SELECT username FROM user WHERE user_id = " . $res['user_id'] . "";
        $res1 = $pdo->query($sql1)->fetch();
        $out .= "<tr><td> <b>" . $res1['username'] . "</b> </td>";
        foreach ($contests as $week => $matchup) {
            $sql = "SELECT user_id FROM draftteam WHERE team_id = " . $matchup['away'] . "";
            $res = $pdo->query($sql)->fetch();
            $sql1 = "SELECT username FROM user WHERE user_id = " . $res['user_id'] . "";
            $res1 = $pdo->query($sql1)->fetch();
            $out .= "<td>{$res1['username']}</td>";
        }
        $out .= "</tr>";
        $out .= PHP_EOL;
    }
    $out .= "</table></div>";
    $out .= PHP_EOL;

    echo "</pre>";
    echo $out;
}
?>