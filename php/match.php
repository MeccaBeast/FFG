<?php
// Initialize the session
require_once 'connection.php';
session_start();
$uid = $_SESSION['id'];
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    echo "<script>if(confirm('To view a league, you have to log in first!')){document.location.href='login.php'}else{document.location.href='mainpage.php'};</script>";
}
$sql = "SELECT team_id FROM draftteam WHERE user_id = $uid";
$res = $pdo->query($sql)->fetch();

if ($res['team_id']==null) {
    echo "<script>if(confirm('To view a league, you have to create a team!')){document.location.href='joinleague.php'}else{document.location.href='joinleague.php'};</script>";
} else {
    $tid = $res['team_id'];
    $sql1 = "SELECT league_id FROM leagueteam WHERE team_id = " . $res['team_id'] . "";
    $res1 = $pdo->query($sql1)->fetch();
    
    if ($res1['league_id']==null) {
        echo "<script>if(confirm('To view a league, you have to join a league!')){document.location.href='joinleague.php'}else{document.location.href='joinleague.php'};</script>";
    } else {
        $lid = $res1['league_id'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            box-sizing: border-box
        }

        body {
            font-family: "Oswald", sans-serif;
        }

        /* Style the tab */
        .tab {
            float: left;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            width: 20%;
            height: 1600px;
        }

        /* Style the buttons inside the tab */
        .tab button {
            display: block;
            background-color: inherit;
            color: black;
            font-family: "Oswald", sans-serif;
            padding: 22px 16px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current "tab button" class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            float: left;
            padding: 0px 12px;
            font-family: "Oswald", sans-serif;
            border: 1px solid #ccc;
            width: 80%;
            border-left: none;
            height: 1600px;
        }

        label {
            font-size: 25px;
        }
    </style>
    <title>Match Center-Premier League Fantasy Football</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="../css/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/datatables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include 'head.php';
    require_once "jsoncon.php";
    ?>
    <div class="tab">
        <button class="tablinks" onclick="openEvent(event, 'home')" id="defaultOpen">Home</button>
        <button class="tablinks" onclick="openEvent(event, 'schedule')">Match Schedule</button>
        <button class="tablinks" onclick="openEvent(event, 'match_r')">Your Match Record</button>
        <button class="tablinks" onclick="openEvent(event, 'match_g')">Gameweek Schedule</button>
    </div>

    <div id="home" class="tabcontent">
        <h3 style="margin-top:10px">Welcome To Your League Center</h3><br>
        <div class="container">
            <h4>Leader Board (Based on Team Total Points)</h4>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Rank</th>
                        <th>User</th>
                        <th>Total points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_t = "SELECT team_id FROM leagueteam WHERE league_id = $lid";
                    $res_t = $pdo->query($sql_t)->fetchAll();
                    $league_size = count($res_t);
                    $tp_rank = array();
                    foreach ($res_t as $row) {
                        $tp = 0;
                        $sql_p = "SELECT player_id FROM teamplayer WHERE team_id = " . $row['team_id'] . "";
                        $res_p = $pdo->query($sql_p)->fetchAll(PDO::FETCH_COLUMN);

                        $sql_ui = "SELECT user_id FROM draftteam WHERE team_id = " . $row['team_id'] . "";
                        $res_ui = $pdo->query($sql_ui)->fetch();
                        $sql_un = "SELECT username FROM user WHERE user_id = " . $res_ui['user_id'] . "";
                        $res_un = $pdo->query($sql_un)->fetch();
                        $un = $res_un['username'];

                        for ($i = 0; $i < 15; $i++) {
                            for ($q = 0; $q < count($data['elements']); $q++) {
                                if ($data['elements'][$q]['id'] == $res_p[$i]) {
                                    $tp = $tp + $data['elements'][$q]['total_points'];
                                }
                            }
                        }

                        $team_tp = array($un, $tp);
                        array_push($tp_rank, $team_tp);
                    }

                    for ($i = 0; $i < $league_size; $i++) {
                        for ($j = $i + 1; $j < $league_size; $j++) {
                            if ($tp_rank[$i]['1'] < $tp_rank[$j]['1']) {
                                $tmp = $tp_rank[$i];
                                $tp_rank[$i] = $tp_rank[$j];
                                $tp_rank[$j] = $tmp;
                            }
                        }
                    }

                    for ($i = 0; $i < $league_size; $i++) {
                        echo "<tr>";
                        $rank = $i + 1;
                        echo "<td>$rank</td>";
                        echo "<td>" . $tp_rank[$i]['0'] . "</td>";
                        echo "<td>" . $tp_rank[$i]['1'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div><br>
        <div class="container">
            <h4>Leader Board (Based on Game Record)</h4>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Rank</th>
                        <th>User</th>
                        <th>Number of Victory</th>
                        <th>Number of Lose</th>
                        <th>Number of Draw</th>
                        <th>Win Rate</th>
                        <th>Team Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $array_order = array();
                    $query = "SELECT team_id FROM leagueteam WHERE league_id = $lid";
                    $stmt = $pdo->query($query);
                    $result = $stmt->fetchAll();
                    foreach ($result as $row) {
                        $query_h = "SELECT count(home) AS t_h_g, sum(case home_win when '1' then 1 else 0 end) AS win_num FROM matchrecord WHERE home = '" . $row['team_id'] . "'";
                        $query_a = "SELECT count(away) AS t_a_g, sum(case away_win when '1' then 1 else 0 end) AS win_num FROM matchrecord WHERE away = '" . $row['team_id'] . "'";
                        $query_hd = "SELECT sum(case draw when '1' then 1 else 0 end) AS draw_num FROM matchrecord WHERE home = '" . $row['team_id'] . "'";
                        $query_ad = "SELECT sum(case draw when '1' then 1 else 0 end) AS draw_num FROM matchrecord WHERE away = '" . $row['team_id'] . "'";
                        $res_h = $pdo->query($query_h)->fetch();
                        $res_a = $pdo->query($query_a)->fetch();
                        $res_hd = $pdo->query($query_hd)->fetch();
                        $res_ad = $pdo->query($query_ad)->fetch();
                        $t_g_n = $res_h['t_h_g'] + $res_a['t_a_g'];
                        if ($t_g_n == 0) {
                            echo "There is only one team in the league.";
                            $w_r = 0;
                        } else {
                            $w_r = ($res_h['win_num'] + $res_a['win_num']) / $t_g_n;
                        }
                        $num_w = $res_h['win_num'] + $res_a['win_num'];
                        $num_d = $res_ad['draw_num'] + $res_hd['draw_num'];
                        if ($t_g_n == 0) {
                            $num_l = 0;
                        } else {
                            $num_l = $t_g_n - $num_w - ($res_ad['draw_num'] + $res_hd['draw_num']);
                        }
                        $score = $num_w * 3 + $num_d * 1 + $num_l * 0;
                        $sql = "SELECT user_id FROM draftteam WHERE team_id = '" . $row['team_id'] . "'";
                        $res = $pdo->query($sql)->fetch();
                        $sql1 = "SELECT username FROM user WHERE user_id = '" . $res['user_id'] . "'";
                        $res1 = $pdo->query($sql1)->fetch();
                        $newarray = array($res1['username'], $num_w, $num_l, $num_d, $w_r, $score);
                        array_push($array_order, $newarray);
                    }

                    $l_size = count($result);
                    for ($i = 0; $i < $l_size; $i++) {
                        for ($j = $i + 1; $j < $l_size; $j++) {
                            if ($array_order[$i]['5'] < $array_order[$j]['5']) {
                                $tmp = $array_order[$i];
                                $array_order[$i] = $array_order[$j];
                                $array_order[$j] = $tmp;
                            }
                        }
                    }

                    for ($i = 0; $i < $l_size; $i++) {
                        echo "<tr>";
                        $rank = $i + 1;
                        echo "<td>$rank</td>";
                        $percent = round((float) $array_order[$i]['4'] * 100) . '%';
                        echo "<td>" . $array_order[$i]['0'] . "</td>";
                        echo "<td>" . $array_order[$i]['1'] . "</td>";
                        echo "<td>" . $array_order[$i]['2'] . "</td>";
                        echo "<td>" . $array_order[$i]['3'] . "</td>";
                        echo "<td>$percent</td>";
                        echo "<td>" . $array_order[$i]['5'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="schedule" class="tabcontent">
        <h3 style="margin-top:10px">Match Schedule Table</h3><br>
        <div class="table-responsive" id="schedule_data">
        </div>
    </div>

    <div id="match_r" class="tabcontent">
        <h3 style="margin-top:10px">Your Match Record (In current league)</h3><br>
        <div class="container">
            <h4>As Home Team</h4>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Match ID</th>
                        <th>League</th>
                        <th>Home Team</th>
                        <th>Away Team</th>
                        <th>Home Win</th>
                        <th>Home Lose</th>
                        <th>Draw</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2 = "SELECT * FROM matchrecord WHERE home = $tid AND league_id = $lid";
                    $statement = $pdo->prepare($sql2);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach ($result as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['match_id']; ?></td>
                            <?php
                                $query = "SELECT league_name FROM league WHERE league_id = '" . $row['league_id'] . "'";
                                $res3 = $pdo->query($query)->fetch(); ?>
                            <td><?php echo $res3['league_name']; ?></td>
                            <?php $query1 = "SELECT team_name FROM draftteam WHERE team_id = '" . $row['home'] . "'";
                                $res4 = $pdo->query($query1)->fetch(); ?>
                            <td><?php echo $res4['team_name']; ?></td>
                            <?php $query2 = "SELECT team_name FROM draftteam WHERE team_id = '" . $row['away'] . "'";
                                $res5 = $pdo->query($query2)->fetch(); ?>
                            <td><?php echo $res5['team_name']; ?></td>
                            <?php if ($row['home_win'] == 1) { ?>
                                <td><?php echo "&#10004"; ?></td>
                            <?php } else { ?>
                                <td><?php echo "X"; ?></td>
                            <?php }
                                if ($row['away_win'] == 1) { ?>
                                <td><?php echo "&#10004"; ?></td>
                            <?php } else { ?>
                                <td><?php echo "X"; ?></td>
                            <?php }
                                if ($row['draw'] == 1) { ?>
                                <td><?php echo "&#10004"; ?></td>
                            <?php } else { ?>
                                <td><?php echo "X"; ?></td>
                            <?php } ?>
                            <td><?php echo $row['date']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="container">
            <h4>As Away Team</h4>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Match ID</th>
                        <th>League</th>
                        <th>Home Team</th>
                        <th>Away Team</th>
                        <th>Home Win</th>
                        <th>Home Lose</th>
                        <th>Draw</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql3 = "SELECT * FROM matchrecord WHERE away = $tid AND league_id = $lid";
                    $statement1 = $pdo->prepare($sql3);
                    $statement1->execute();
                    $result1 = $statement1->fetchAll();
                    foreach ($result1 as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['match_id']; ?></td>
                            <?php
                                $query = "SELECT league_name FROM league WHERE league_id = '" . $row['league_id'] . "'";
                                $res3 = $pdo->query($query)->fetch(); ?>
                            <td><?php echo $res3['league_name']; ?></td>
                            <?php $query1 = "SELECT team_name FROM draftteam WHERE team_id = '" . $row['home'] . "'";
                                $res4 = $pdo->query($query1)->fetch(); ?>
                            <td><?php echo $res4['team_name']; ?></td>
                            <?php $query2 = "SELECT team_name FROM draftteam WHERE team_id = '" . $row['away'] . "'";
                                $res5 = $pdo->query($query2)->fetch(); ?>
                            <td><?php echo $res5['team_name']; ?></td>
                            <?php if ($row['home_win'] == 1) { ?>
                                <td><?php echo "&#10004"; ?></td>
                            <?php } else { ?>
                                <td><?php echo "X"; ?></td>
                            <?php }
                                if ($row['away_win'] == 1) { ?>
                                <td><?php echo "&#10004"; ?></td>
                            <?php } else { ?>
                                <td><?php echo "X"; ?></td>
                            <?php }
                                if ($row['draw'] == 1) { ?>
                                <td><?php echo "&#10004"; ?></td>
                            <?php } else { ?>
                                <td><?php echo "X"; ?></td>
                            <?php } ?>
                            <td><?php echo $row['date']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="match_g" class="tabcontent">
        <div class="container">
            <h3 style="margin-top:10px">EPL Gameweek Deadline Schedule</h3><br>
            <div class="row">
                <div class="col-sm">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Gameweek</th>
                                    <th>Deadline</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i <= 18; $i++) {
                                    ?>
                                    <tr>
                                        <td><?php echo $data['events'][$i]['name'] ?></td>
                                        <td><?php echo $data['events'][$i]['deadline_time'] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Gameweek</th>
                                    <th>Deadline</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once "jsoncon.php";
                                for ($i = 19; $i <= 37; $i++) {
                                    ?>
                                    <tr>
                                        <td><?php echo $data['events'][$i]['name'] ?></td>
                                        <td><?php echo $data['events'][$i]['deadline_time'] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    function openEvent(evt, eventName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(eventName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();

    $(document).ready(function() {
        load_schedule();

        function load_schedule() {
            $.ajax({
                method: "POST",
                url: "test.php",
                success: function(data) {
                    $('#schedule_data').html(data);
                }
            });
        }
    });
</script>

</html>