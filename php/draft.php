<?php
// Initialize the session
session_start();
require_once "connection.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    echo "<script>if(confirm('To draft your team, you have to log in!')){document.location.href='login.php'}else{document.location.href='mainpage.php'};</script>";
}
$user_id = $_SESSION['id'];
$query = "SELECT user_id FROM draftteam WHERE user_id = $user_id;";
$statement = $pdo->prepare($query);
$statement->execute();
if ($statement->rowCount() > 0) {
    echo "<script>if(confirm('You have already owned a team!')){document.location.href='myteam.php'}else{document.location.href='mainpage.php'};</script>";
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

        .container {
            font-family: "Oswald", sans-serif;
        }
    </style>
    <title>Draft-Premier League Fantasy Football</title>
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
    <div class="row">
        <div class="col-sm-6">
            <div class="container">
                <h1 align="center" style="margin-top:10px">Player Pick</h1>
                <div class="table-responsive">
                    <table id="first_table" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm">ID
                                </th>
                                <th class="th-sm">Photo</th>
                                <th class="th-sm">Full Name
                                </th>
                                <th class="th-sm">Position
                                </th>
                                <th class="th-sm">Value
                                </th>
                                <th class="th-sm">Belong to
                                </th>
                                <th class="th-sm">Total Point
                                </th>
                                <th class="th-sm">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once "jsoncon.php";
                            foreach ($data['elements'] as $key => $item) {
                                ?>
                            <tr>
                                <td><?PHP echo $item['id']; ?></td>
                                <td><?PHP
                                        $filename = $item['photo'];
                                        $filename = str_replace(strrchr($filename, '.'), '', $filename);
                                        echo "<img src='https://platform-static-files.s3.amazonaws.com/premierleague/photos/players/110x140/p$filename.png' class='img-fluid' alt='Responsive image' width='60' height='50'>"; ?></td>
                                <td><?PHP echo $item['first_name']; ?> <?PHP echo $item['second_name']; ?></td>
                                <td><?PHP
                                        for ($i = 0; $i < count($data['element_types']); $i++) {
                                            if ($item['element_type'] == $data['element_types'][$i]['id']) {
                                                echo $data['element_types'][$i]['plural_name'];
                                            }
                                        } ?></td>
                                <td><?PHP echo $item['now_cost']; ?></td>
                                <td><?PHP
                                        for ($i = 0; $i < count($data['teams']); $i++) {
                                            if ($item['team_code'] == $data['teams'][$i]['code']) {
                                                echo $data['teams'][$i]['name'];
                                            }
                                        }
                                        ?></td>
                                <td><?PHP echo $item['total_points']; ?></td>
                                <td><input type="button" name="view" value="View" player_id="<?php echo $item['id']; ?>" class="btn btn-info btn-xs view_data" />
                                    <button id="add" class="btn btn-success btn_add">Add</button>
                                </td>
                            </tr>
                            <?php }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID
                                </th>
                                <th>Player ID
                                </th>
                                <th>Full Name
                                </th>
                                <th>Position
                                </th>
                                <th>Value
                                </th>
                                <th>Belong to
                                </th>
                                <th>Total Point
                                </th>
                                <th>Action
                                </th>
                            </tr>
                        </tfoot>
                    </table>
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
        </div>
        <div class="col-sm-6">
            <div class="container">
                <h1 align="center" style="margin-top:10px">Draft Squad</h1><br>
                <h5>Please be cautioned that each team should be consisted of 2 Goalkeepers, 5 Defenders, 5 Midfielders and 3 Forwards.</h5><br>
                <div class="row">
                    <div class="col-4">
                        <h5>Player Picked</h5>
                        <p id="p1">0/15</p>
                    </div>
                    <div class="col-4">
                        <h5>Budget Remained</h5>
                        <p id="p2">1000</p>
                    </div>
                    <div class="col-4">
                        <h5>Team Total Points</h5>
                        <p id="p3" name="p3">0</p>
                    </div>
                </div>
                <form id="myForm" action="submitDraftAction.php" method="POST">
                    <table id="second_table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Player ID</th>
                                <th>Player Name</th>
                                <th>Position</th>
                                <th>Price</th>
                                <th>Total Points</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="teamlist">

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-4">
                            <select class="form-control" name="formation" id="formation">
                                <option selected>Select A Formation</option>
                                <option value="4-3-3">4-3-3</option>
                                <option value="4-3-2-1">4-3-2-1</option>
                                <option value="4-2-3-1">4-2-3-1</option>
                                <option value="5-3-2">5-3-2</option>
                                <option value="3-5-2">3-5-2</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-control" name="stratagy" id="stratagy">
                                <option selected>Select A Stratagy</option>
                                <option value="Ultimate Attacking">Ultimate Attacking</option>
                                <option value="Tiki-Taka">Tiki-Taka</option>
                                <option value="Total Football">Total Football</option>
                                <option value="Defense & Counterattack">Defense & Counterattack</option>
                                <option value="Ultimate Defencing">Ultimate Defencing</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="team_name" name="team_name" placeholder="Enter a Teamname" onkeyup="validate();" />
                            <span id="error_tn" class="text-danger"></span>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="col-4">
                            <button type="button" id="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    function validate() {
        var element = document.getElementById('team_name');
        element.value = element.value.replace(/[^a-zA-Z0-9@]+/, '');
    };

    $(document).ready(function() {
        //initialize data table
        var dt = $('#first_table').DataTable({
            bAutoWidth: false,
            stateSave: true
        });
        $('.dataTables_length').addClass('bs-select');
        // view player data
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
    });

//initialize different global counters
    var occurence = 0;
    var totalRows = 0;
    var total = 0;
    var arrayPlayer = [];
    var count_gk = 0;
    var count_df = 0;
    var count_mf = 0;
    var count_at = 0;
    var cost = 0;

//add player to the draft team table
    $(".btn_add").on("click", function() {
        var column1 = $(this).closest('tr').children()[0].textContent;
        var column2 = $(this).closest('tr').children()[1].textContent;
        var column3 = $(this).closest('tr').children()[2].textContent;
        var column4 = $(this).closest('tr').children()[3].textContent;
        var column5 = $(this).closest('tr').children()[4].textContent;
        var column6 = $(this).closest('tr').children()[6].textContent;

        if (totalRows <= 14) {
            if ($("#second_table .copy_" + column1).length == 0) {
                if (column4 === "Goalkeepers") {
                    if (count_gk <= 1) {
                        $("#second_table").append("<tr class='copy_" + column1 + "'><td name='player_id'>" + column1 + "</td><td>" + column3 + "</td><td>" + column4 + "</td><td class='cost'>" + column5 + "</td><td class='point'>" + column6 + "</td><td><button class='btn btn-danger btn_remove'>Remove</button></td></tr>");
                        count_gk++;
                        occurence++;
                        document.getElementById("p1").innerHTML = occurence + "/15";
                        get_total();
                        get_cost();
                        totalRows = totalRows + 1;
                        total = total + parseInt(column6);
                        arrayPlayer.push(column1);
                        console.log(count_gk);
                    } else {
                        alert("Please check whether your goalkeeper group is full.");
                        console.log(count_gk);
                    }
                } else if (column4 === "Defenders") {
                    if (count_df <= 4) {
                        $("#second_table").append("<tr class='copy_" + column1 + "'><td name='player_id'>" + column1 + "</td><td>" + column3 + "</td><td>" + column4 + "</td><td class='cost'>" + column5 + "</td><td class='point'>" + column6 + "</td><td><button class='btn btn-danger btn_remove'>Remove</button></td></tr>");
                        count_df++;
                        occurence++;
                        document.getElementById("p1").innerHTML = occurence + "/15";
                        get_total();
                        get_cost();
                        totalRows = totalRows + 1;
                        total = total + parseInt(column6);
                        arrayPlayer.push(column1);
                        console.log(count_df);
                    } else {
                        alert("Please check whether your defender group is full.");
                        console.log(count_df);
                    }
                } else if (column4 === "Midfielders") {
                    if (count_mf <= 4) {
                        $("#second_table").append("<tr class='copy_" + column1 + "'><td name='player_id'>" + column1 + "</td><td>" + column3 + "</td><td>" + column4 + "</td><td class='cost'>" + column5 + "</td><td class='point'>" + column6 + "</td><td><button class='btn btn-danger btn_remove'>Remove</button></td></tr>");
                        count_mf++;
                        occurence++;
                        document.getElementById("p1").innerHTML = occurence + "/15";
                        get_total();
                        get_cost();
                        totalRows = totalRows + 1;
                        total = total + parseInt(column6);
                        arrayPlayer.push(column1);
                        console.log(count_mf);
                    } else {
                        alert("Please check whether your midfielder group is full.");
                        console.log(count_mf);
                    }
                } else if (column4 === "Forwards") {
                    if (count_at <= 2) {
                        $("#second_table").append("<tr class='copy_" + column1 + "'><td name='player_id'>" + column1 + "</td><td>" + column3 + "</td><td>" + column4 + "</td><td class='cost'>" + column5 + "</td><td class='point'>" + column6 + "</td><td><button class='btn btn-danger btn_remove'>Remove</button></td></tr>");
                        count_at++;
                        occurence++;
                        document.getElementById("p1").innerHTML = occurence + "/15";
                        get_total();
                        get_cost();
                        totalRows = totalRows + 1;
                        total = total + parseInt(column6);
                        arrayPlayer.push(column1);
                        console.log(count_at);
                    } else {
                        alert("Please check whether your forward group is full.");
                        console.log(count_at);
                    }
                }
            } else {
                alert("You've already picked this player!");
            }
        } else {
            alert("Please check whether your team is full, or maybe the number for each position is over the limitation (2 GK, 3 ATT, 5 MID ,5 DEF)!");
        }
    });
//remove table row from the draft team table
    $("body").on("click", ".btn_remove", function() {
        var column1 = $(this).closest('tr').children()[0].textContent;
        var column2 = $(this).closest('tr').children()[2].textContent;
        var column4 = $(this).closest('tr').children()[4].textContent;

        $(this).parent().parent().remove();
        $(".btn_add").removeAttr("disabled");
        if (column2 == "Goalkeepers") {
            count_gk--;
            console.log(count_gk);
        } else if (column2 == "Defenders") {
            count_df--;
            console.log(count_df);
        } else if (column2 == "Midfielders") {
            count_mf--;
            console.log(count_mf);
        } else if (column2 == "Forwards") {
            count_at--;
            console.log(count_at);
        }
        get_total();
        get_cost();
        occurence--;
        document.getElementById("p1").innerHTML = occurence + "/15";
        totalRows = totalRows - 1;
        total = total - parseInt(column4);
        var item = column1;

        var index = arrayPlayer.indexOf(item);
        if (index !== -1) arrayPlayer.splice(index, 1);
    });
//get the total points
    function get_total() {
        var main_total = 0;
        if ($('.point').length > 0) {
            $('.point').each(function(i) {
                main_total += parseInt($(this).html())
            });
        }
        document.getElementById("p3").innerHTML = main_total;
    }
//get the value of remained budget
    function get_cost() {
        var main_cost = 1000;
        if ($('.cost').length > 0) {
            $('.cost').each(function(i) {
                main_cost -= parseFloat($(this).html());
                cost = main_cost;
            });
        }
        document.getElementById("p2").innerHTML = main_cost;
        if (cost <= 0) {
            alert("Please be aware, you are out of budget....");
        }
    }
// reset the draft table
    $('#reset').on('click', () => {
        $('#teamlist').empty();
        document.getElementById("p1").innerHTML = "0/15";
        document.getElementById("p2").innerHTML = "1000";
        document.getElementById("p3").innerHTML = "0";
        occurence = 0;
        totalRows = 0;
        total = 0;
        arrayPlayer = [];
        count_gk = 0;
        count_df = 0;
        count_mf = 0;
        count_at = 0;
        cost = 0;
    });
//send team data into database
    $("#submit").click(function(e) {
        if (cost >= 0) {
            if (occurence == 15) {
                e.preventDefault();
                var error_tn = '';
                if ($('#team_name').val() == '') {
                    error_tn = 'Team name is required';
                    $('#error_tn').text(error_tn);
                    $('#team_name').css('border-color', '#cc0000');
                } else {
                    error_tn = '';
                    $('#error_tn').text(error_tn);
                    $('#team_name').css('border-color', '');
                }

                if (error_tn != '') {
                    return false;
                } else {
                    var team_name = $("#team_name").val();
                    var formation = $("#formation").val();
                    var stratagy = $("#stratagy").val();
                    var jsonString = JSON.stringify(arrayPlayer);
                    var total_point = total;
                    //var dataString = 'team_name=' + team_name + 'formation=' + formation + 'stratagy=' + stratagy + 'player_id=' + player_id;
                    $.ajax({
                        type: 'POST',
                        data: {
                            team_name: team_name,
                            formation: formation,
                            stratagy: stratagy,
                            player_id: jsonString,
                            total_point: total_point
                        },
                        url: 'submitDraftAction.php',
                        success: function(data) {
                            if (data == "OK") {
                                setTimeout(function() {
                                    window.location.href = "myteam.php";
                                }, 2000);
                                alert("Submit Successful!");
                            } else if (data == "emptyinput") {
                                alert("Teamname must be inputed!");
                            } else if (data == "error") {
                                alert("There is an error occured!");
                            } else if (data == "namedup") {
                                alert("This team name is already existed!");
                            } else if (data == "teamdup") {
                                alert("You've already owned a team!");
                            }

                        }
                    });
                }
            } else {
                alert("Your team is not full yet...");
                return false;
            }
        } else {
            alert("Your can not submit the team due to the budget is negative.");
            return false;
        }
    });
</script>

</html>