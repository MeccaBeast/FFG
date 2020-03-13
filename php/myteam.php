<?php
// Initialize the session
session_start();
require_once "connection.php";
require_once "jsoncon.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    echo "<script>if(confirm('To draft your team, you have to log in!')){document.location.href='login.php'}else{document.location.href='login.php'};</script>";
}

$user_id = $_SESSION['id'];
$query = "SELECT user_id, team_name, formation, stratagy FROM draftteam WHERE user_id = $user_id;";
$statement = $pdo->prepare($query);
$statement->execute();
$result = $statement->fetch();
if ($statement->rowCount() == 0) {
    echo "<script>if(confirm('To view your team, you have to draft your team first!')){document.location.href='draft.php'}else{document.location.href='draft.php'};</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:before {
            bottom: .5em;
        }

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
            height: 1200px;
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
            height: 1200px;
        }

        label {
            font-size: 25px;
        }

        .container {
            font-family: "Oswald", sans-serif;
        }
    </style>
    <title>My team-Premier League Fantasy Football</title>
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
    ?>
    <div class="tab">
        <button class="tablinks" onclick="openEvent(event, 'home')" id="defaultOpen">My Team</button>
        <button class="tablinks" onclick="openEvent(event, 'g_rank')">Global Rank</button>
    </div>

    <div id="home" class="tabcontent">
        <div class="container" style="width:1600px;">
            <h1 align="center" style="margin-top:10px">My team</h1>
            <br>
            <div class="row">
                <div class="col-4" style="text-align:center">
                    <h4>Team Name:<br><?php echo $result['team_name']; ?></h4>
                </div>
                <div class="col-4" style="text-align:center">
                    <h4>Formation:<br><?php echo $result['formation']; ?></h4>
                </div>
                <div class="col-4" style="text-align:center">
                    <h4>Stratagy:<br><?php echo $result['stratagy']; ?></h4>
                </div>
            </div>
            <br />

            <div class="row">
                <div class="col-6">
                    <h5>Goalkeeper:</h5>
                    <div class="table-responsive">
                        <table id="gk" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">ID
                                    </th>
                                    <th class="th-sm">Photo
                                    </th>
                                    <th class="th-sm">Full Name
                                    </th>
                                    <th class="th-sm">Detail
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query1 = "SELECT team_id FROM draftteam WHERE user_id = $user_id;";
                                $statement1 = $pdo->prepare($query1);
                                $statement1->execute();
                                $result1 = $statement1->fetch();
                                $team_id = $result1['team_id'];
                                $query2 = "SELECT player_id FROM teamplayer WHERE team_id = $team_id;";
                                $statement2 = $pdo->prepare($query2);
                                $statement2->execute();
                                $result2 = $statement2->fetchAll();
                                $total_row = $statement2->rowCount();
                                if ($total_row > 0) {
                                    foreach ($result2 as $row) {
                                        $player_id = $row["player_id"];
                                        for ($i = 0; $i < count($data['elements']); $i++) {
                                            if ($data['elements'][$i]['id'] == $player_id && $data['elements'][$i]['element_type'] == 1) {
                                                ?>
                                <tr>
                                    <td><?PHP echo $data['elements'][$i]['id']; ?></td>
                                    <td><?PHP
                                                        $filename = $data['elements'][$i]['photo'];
                                                        $filename = str_replace(strrchr($filename, '.'), '', $filename);
                                                        echo "<img src='https://platform-static-files.s3.amazonaws.com/premierleague/photos/players/110x140/p$filename.png' class='img-fluid' alt='Responsive image'  width='60' height='50'>"; ?>
                                    </td>
                                    <td><?PHP echo $data['elements'][$i]['first_name']; ?> <?PHP echo $data['elements'][$i]['second_name']; ?></td>
                                    <td><input type="button" name="view" value="View" player_id="<?php echo $row["player_id"]; ?>" class="btn btn-info btn-xs view_data" /></td>
                                </tr>
                                <?php }
                                        }
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6">
                    <h5>Defender:</h5>
                    <table id="df" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm">ID
                                </th>
                                <th class="th-sm">Photo
                                </th>
                                <th class="th-sm">Full Name
                                </th>
                                <th class="th-sm">Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($total_row > 0) {
                                foreach ($result2 as $row) {
                                    $player_id = $row["player_id"];
                                    for ($i = 0; $i < count($data['elements']); $i++) {
                                        if ($data['elements'][$i]['id'] == $player_id && $data['elements'][$i]['element_type'] == 2) {
                                            ?>
                            <tr>
                                <td><?PHP echo $data['elements'][$i]['id']; ?></td>
                                <td><?PHP
                                                    $filename = $data['elements'][$i]['photo'];
                                                    $filename = str_replace(strrchr($filename, '.'), '', $filename);
                                                    echo "<img src='https://platform-static-files.s3.amazonaws.com/premierleague/photos/players/110x140/p$filename.png' class='img-fluid' alt='Responsive image'  width='60' height='50'>"; ?>
                                </td>
                                <td><?PHP echo $data['elements'][$i]['first_name']; ?> <?PHP echo $data['elements'][$i]['second_name']; ?></td>
                                <td><input type="button" name="view" value="View" player_id="<?php echo $row["player_id"]; ?>" class="btn btn-info btn-xs view_data" /></td>
                            </tr>
                            <?php }
                                    }
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h5>Midfeilder:</h5>
                    <table id="mf" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm">ID
                                </th>
                                <th class="th-sm">Photo
                                </th>
                                <th class="th-sm">Full Name
                                </th>
                                <th class="th-sm">Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($total_row > 0) {
                                foreach ($result2 as $row) {
                                    $player_id = $row["player_id"];
                                    for ($i = 0; $i < count($data['elements']); $i++) {
                                        if ($data['elements'][$i]['id'] == $player_id && $data['elements'][$i]['element_type'] == 3) {
                                            ?>
                            <tr>
                                <td><?PHP echo $data['elements'][$i]['id']; ?></td>
                                <td><?PHP
                                                    $filename = $data['elements'][$i]['photo'];
                                                    $filename = str_replace(strrchr($filename, '.'), '', $filename);
                                                    echo "<img src='https://platform-static-files.s3.amazonaws.com/premierleague/photos/players/110x140/p$filename.png' class='img-fluid' alt='Responsive image'  width='60' height='50'>"; ?>
                                </td>
                                <td><?PHP echo $data['elements'][$i]['first_name']; ?> <?PHP echo $data['elements'][$i]['second_name']; ?></td>
                                <td><input type="button" name="view" value="View" player_id="<?php echo $row["player_id"]; ?>" class="btn btn-info btn-xs view_data" /></td>
                            </tr>
                            <?php }
                                    }
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <h5>Attacker:</h5>
                    <table id="at" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm">ID
                                </th>
                                <th class="th-sm">Photo
                                </th>
                                <th class="th-sm">Full Name
                                </th>
                                <th class="th-sm">Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($total_row > 0) {
                                foreach ($result2 as $row) {
                                    $player_id = $row["player_id"];
                                    for ($i = 0; $i < count($data['elements']); $i++) {
                                        if ($data['elements'][$i]['id'] == $player_id && $data['elements'][$i]['element_type'] == 4) {
                                            ?>
                            <tr>
                                <td><?PHP echo $data['elements'][$i]['id']; ?></td>
                                <td><?PHP
                                                    $filename = $data['elements'][$i]['photo'];
                                                    $filename = str_replace(strrchr($filename, '.'), '', $filename);
                                                    echo "<img src='https://platform-static-files.s3.amazonaws.com/premierleague/photos/players/110x140/p$filename.png' class='img-fluid' alt='Responsive image'  width='60' height='50'>"; ?>
                                </td>
                                <td><?PHP echo $data['elements'][$i]['first_name']; ?> <?PHP echo $data['elements'][$i]['second_name']; ?></td>
                                <td><input type="button" name="view" value="View" player_id="<?php echo $row["player_id"]; ?>" class="btn btn-info btn-xs view_data" /></td>
                            </tr>
                            <?php }
                                    }
                                }
                            } ?>
                        </tbody>
                    </table>
                    <br><br><br>
                    <input type="button" name="dt" id="dt" value="DELETE TEAM" user_id="<?php echo $user_id; ?>" class="btn btn-danger btn-xs delete_team" style="margin:auto;display:block" />
                </div>
            </div>
        </div>
        <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataModalLabel">Player detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="player_detail">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="g_rank" class="tabcontent">
        <h1 style="margin-top:10px">Global Ranking</h1>
        <div class="table-responsive">
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Rank</th>
                        <th class="th-sm">User ID</th>
                        <th class="th-sm">User Name</th>
                        <th class="th-sm">Team Name</th>
                        <th class="th-sm">Team Total Points</th>
                        <th class="th-sm">Formation</th>
                        <th class="th-sm">Tactics</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql_t = "SELECT team_id FROM draftteam";
                    $res_t = $pdo->query($sql_t)->fetchAll();
                    $size = count($res_t);
                    $tp_rank = array();
                    foreach ($res_t as $row) {
                        $tp = 0;
                        $sql_p = "SELECT player_id FROM teamplayer WHERE team_id = " . $row['team_id'] . "";
                        $res_p = $pdo->query($sql_p)->fetchAll(PDO::FETCH_COLUMN);
                        for ($i = 0; $i < 15; $i++) {
                            for ($q = 0; $q < count($data['elements']); $q++) {
                                if ($data['elements'][$q]['id'] == $res_p[$i]) {
                                    $tp = $tp + $data['elements'][$q]['total_points'];
                                }
                            }
                        }

                        $sql_ui = "SELECT user_id, team_name, formation, stratagy FROM draftteam WHERE team_id = " . $row['team_id'] . "";
                        $res_ui = $pdo->query($sql_ui)->fetch();
                        $sql_un = "SELECT username FROM user WHERE user_id = " . $res_ui['user_id'] . "";
                        $res_un = $pdo->query($sql_un)->fetch();
                        $un = $res_un['username'];
                        $uid = $res_ui['user_id'];
                        $tn = $res_ui['team_name'];
                        $format = $res_ui['formation'];
                        $tactic = $res_ui['stratagy'];

                        $team_tp = array($uid, $un, $tn, $tp, $format, $tactic);
                        array_push($tp_rank, $team_tp);
                    }

                    for ($i = 0; $i < $size; $i++) {
                        for ($j = $i + 1; $j < $size; $j++) {
                            if ($tp_rank[$i]['3'] < $tp_rank[$j]['3']) {
                                $tmp = $tp_rank[$i];
                                $tp_rank[$i] = $tp_rank[$j];
                                $tp_rank[$j] = $tmp;
                            }
                        }
                    }

                    for ($i = 0; $i < $size; $i++) {
                        echo "<tr>";
                        $rank = $i + 1;
                        echo "<td>$rank</td>";
                        echo "<td>" . $tp_rank[$i]['0'] . "</td>";
                        echo "<td>" . $tp_rank[$i]['1'] . "</td>";
                        echo "<td>" . $tp_rank[$i]['2'] . "</td>";
                        echo "<td>" . $tp_rank[$i]['3'] . "</td>";
                        echo "<td>" . $tp_rank[$i]['4'] . "</td>";
                        echo "<td>" . $tp_rank[$i]['5'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
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
        var dt = $('#dtBasicExample').DataTable({
            bAutoWidth: false,
            stateSave: true
        });
        $('.dataTables_length').addClass('bs-select');

        $(document).on('click', ".view_data", function(event) {
            var player_id = $(this).attr("player_id");
            $.ajax({
                url: "select.php",
                method: "post",
                data: {
                    player_id: player_id
                },
                success: function(data) {
                    $('#player_detail').html(data);
                    $('#dataModal').modal("show", {
                        backdrop: 'true'
                    });
                }
            });
        });

        $("#dt").on("click", function() {
            if (confirm("Are you sure that you want to delete your team?")) {
                var user_id = $(this).attr("user_id");
                console.log(user_id);
                $.ajax({
                    url: "deleteteam.php",
                    method: "post",
                    data: {
                        user_id: user_id
                    },
                    success: function(data) {
                        if(data == "OK"){
                            console.log(data);
                            location.reload();
                            alert("Successfully delete!");
                        }else if(data == "NO"){
                            alert("Something Went Wrong...");
                        }
                    }
                });
            } else {
                alert("Enjoy!");
            }
        });
    });
</script>

</html>