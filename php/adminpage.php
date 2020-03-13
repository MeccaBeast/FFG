<?php
// Initialize the session
session_start();
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
            height: 600px;
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
            height: 800px;
        }
    </style>
    <title>Admin Page-Premier League Fantasy Football</title>
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
    require_once 'connection.php';
    ?>
    <div class="tab">
        <button class="tablinks" onclick="openEvent(event, 'home')" id="defaultOpen">Home</button>
        <button class="tablinks" onclick="openEvent(event, 'user')">User Management</button>
        <button class="tablinks" onclick="openEvent(event, 'match')">Match Record Management</button>
    </div>

    <div id="home" class="tabcontent">
        <h3>Welcome Admin</h3>
        <p>Please be aware that if admin wants to logout, simply click the button below to logout.</p>
        <a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
    </div>

    <div id="user" class="tabcontent">
        <h3>User Management</h3>
        <div class="table-responsive">
            <table id="usertable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">User ID</th>
                        <th class="th-sm">User Name</th>
                        <th class="th-sm">Email Address</th>
                        <th class="th-sm">Password</th>
                        <th class="th-sm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT user_id, username, email FROM user";
                    $statement = $pdo->prepare($sql);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach ($result as $row) {
                        ?>
                    <tr>
                        <td><?php echo $row['user_id'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td>********</td>
                        <td><input type="button" id = "del" name="del" value="Delete" user_id="<?php echo $row['user_id']; ?>" class="btn btn-danger btn-xs btn-del" /></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="th-sm">User ID</th>
                        <th class="th-sm">User Name</th>
                        <th class="th-sm">Email Address</th>
                        <th class="th-sm">Password</th>
                        <th class="th-sm">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div id="match" class="tabcontent">
        <h3>Match Record Management</h3>
        <div id="match_data" class="table-responsive">

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="edit_form">
                        <div class="form-group">
                            <label for="mid">Match ID</label>
                            <input type="text" class="form-control" id="mid" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date">
                            <span id="error_2" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="select">Select League</label>
                            <select class="form-control" name="l_select" id="l_select">
                                <option disabled selected>Please make a selection (ID, Name)</option>
                                <?php
                                $sql = "SELECT league_id FROM league";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetchAll();

                                foreach ($result as $row) {
                                    $lid = $row['league_id'];
                                    $sql1 = "SELECT league_name FROM league WHERE league_id = $lid";
                                    $result1 = $pdo->query($sql1)->fetch();
                                    $lname = $result1['league_name'];
                                    ?>
                                <option value=<?php echo $lid; ?>><?php echo "$lid , $lname" ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <span id="error_3" class="text-danger"></span>
                        </div>
                        <div class='form-group'>
                            <label for='select2'>Select Home Team</label>
                            <select class='form-control' id='select2'>
                                <option disabled selected>Please make a selection (ID, Name)</option>
                            </select>
                            <span id="error_4" class="text-danger"></span>
                        </div>
                        <div class='form-group'>
                            <label for='select3'>Select Away Team</label>
                            <select class='form-control' id='select3'>
                                <option disabled selected>Please make a selection (ID, Name)</option>
                            </select>
                            <span id="error_5" class="text-danger"></span>
                        </div>
                        <div class='form-group'>
                            <label for='select4'>Winner</label>
                            <select class='form-control' id='select4'>
                                <option disabled selected>Please make a selection (ID, Name)</option>

                            </select>
                            <span id="error_6" class="text-danger"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" type="submit" name="update" id="update" class="btn btn-primary update">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var ut = $('#usertable').DataTable({
            bAutoWidth: false,
            stateSave: true
        });

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

            load_data();

            function load_data() {
                $.ajax({
                    method: "POST",
                    url: "fetch.php",
                    success: function(data) {
                        $('#match_data').html(data);
                    }
                });
            }

            $("#l_select").change(function() {
                $("#select2").empty();
                $("#select3").empty();
                var lid = $(this).children("option:selected").val();
                $.ajax({
                    url: "getTeam.php",
                    method: 'POST',
                    data: {
                        lid: lid
                    },
                    success: function(result) {
                        $("#select2").append('<option disabled selected>Please make a selection (ID, Name)</option>');
                        $("#select2").append(result);
                        $("#select3").append('<option disabled selected>Please make a selection (ID, Name)</option>');
                        $("#select3").append(result);
                    }
                });
            });

            function removeDuplicateOptions(s, comparitor) {
                if (s.tagName.toUpperCase() !== 'SELECT') {
                    return false;
                }
                var c, i, o = s.options,
                    sorter = {};
                if (!comparitor || typeof comparitor !== 'function') {
                    comparitor = function(o) {
                        return o.value;
                    }; //by default we comare option values.
                }
                for (i = 0; i < o.length; i++) {
                    c = comparitor(o[i]);
                    if (sorter[c]) {
                        s.removeChild(o[i]);
                        i--;
                    } else {
                        sorter[c] = true;
                    }
                }
                return true;
            }

            $('#select2').change(function() {
                var seltext1 = $('#select2 :selected').text();
                var selval1 = $('#select2 :selected').val();
                if (seltext1 == $('#select3 :selected').text() || selval1 == $('#select3 :selected').val()) {
                    alert("YOU CAN NOT CHOOSE DUPLICATE TEAM AS WIN OR LOSE TEAM!");
                    $(this).removeAttr("selected");
                } else {
                    $('#select4').append('<option value = ' + selval1 + '>' + seltext1 + '</option>');
                    var s = document.getElementById("select4");
                    removeDuplicateOptions(s);
                }
            });

            $('#select3').change(function() {
                var seltext2 = $('#select3 :selected').text();
                var selval2 = $('#select3 :selected').val();
                if (seltext2 == $('#select2 :selected').text() || selval2 == $('#select2 :selected').val()) {
                    alert("YOU CAN NOT CHOOSE DUPLICATE TEAM AS WIN OR LOSE TEAM!");
                    $(this).removeAttr("selected");
                } else {
                    $('#select4').append('<option value = ' + selval2 + '>' + seltext2 + '</option>');
                    var s = document.getElementById("select4");
                    removeDuplicateOptions(s);
                }
            });

            $('#update').on('click', function(event) {
                event.preventDefault();
                var error_2 = '';
                var error_3 = '';
                var error_4 = '';
                var error_5 = '';
                var error_6 = '';

                if ($('#date').val() == '') {
                    error_2 = 'Match date is required';
                    $('#error_2').text(error_2);
                    $('#date').css('border-color', '#cc0000');
                } else {
                    error_2 = '';
                    $('#error_2').text(error_2);
                    $('#date').css('border-color', '');
                }

                if ($('#l_select :selected').text() == '' || $('#l_select :selected').text() == 'Please make a selection (ID, Name)') {
                    error_3 = 'Please select a league';
                    $('#error_3').text(error_3);
                    $('#l_select').css('border-color', '#cc0000');
                } else {
                    error_3 = '';
                    $('#error_3').text(error_3);
                    $('#l_select').css('border-color', '');
                }

                if ($('#select2 :selected').text() == '' || $('#select2 :selected').text() == 'Please make a selection (ID, Name)') {
                    error_4 = 'Please select a home team';
                    $('#error_4').text(error_4);
                    $('#select2').css('border-color', '#cc0000');
                } else {
                    error_4 = '';
                    $('#error_4').text(error_4);
                    $('#select2').css('border-color', '');
                }

                if ($('#select3 :selected').text() == '' || $('#select3 :selected').text() == 'Please make a selection (ID, Name)') {
                    error_5 = 'Please select an away team';
                    $('#error_5').text(error_5);
                    $('#select3').css('border-color', '#cc0000');
                } else {
                    error_ed = '';
                    $('#error_5').text(error_5);
                    $('#select3').css('border-color', '');
                }

                if ($('#select4 :selected').text() == '' || $('#select4 :selected').text() == 'Please make a selection (ID, Name)') {
                    error_6 = 'Please choose a winner';
                    $('#error_6').text(error_6);
                    $('#select4').css('border-color', '#cc0000');
                } else {
                    error_6 = '';
                    $('#error_6').text(error_6);
                    $('#select4').css('border-color', '');
                }

                if (error_2 != '' || error_3 != '' || error_4 != '' || error_5 != '' || error_6 != '') {
                    return false;
                } else {
                    var mid = $("#mid").val();
                    var date = $("#date").val();
                    var league = $("#l_select").val();
                    var home = $("#select2").val();
                    var away = $("#select3").val();
                    var win = $("#select4").val();
                    var action = 'edit';
                    $.ajax({
                        url: "adminedit.php",
                        method: "POST",
                        data: {
                            mid: mid,
                            date: date,
                            league: league,
                            home: home,
                            away: away,
                            win: win,
                            action: action
                        },
                        success: function(data) {
                            console.log(data);
                            $('#exampleModalScrollable').modal('hide');
                            alert("Successfully updated!");
                            load_data();
                        }
                    });
                }
            });

            $(".btn-del").on("click", function() {
                var action = "user_del";
                var uid = $(this).closest('tr').children()[0].textContent;;
                $.ajax({
                    url: "adminedit.php",
                    method: "POST",
                    data: {
                        uid: uid,
                        action: action
                    },
                    success: function(data) {
                        console.log(data);
                        alert("Successfully delete!");
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>

</html>