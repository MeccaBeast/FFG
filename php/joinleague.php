<?php
// Include config file
session_start();
require_once "connection.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    echo "<script>if(confirm('To create a league, you have to log in first!')){document.location.href='login.php'}else{document.location.href='mainpage.php'};</script>";
}
$user_id = $_SESSION['id'];
$query = "SELECT user_id, team_name, formation, stratagy FROM draftteam WHERE user_id = $user_id;";
$statement = $pdo->prepare($query);
$statement->execute();
$result = $statement->fetch();
if ($statement->rowCount() == 0) {
    echo "<script>if(confirm('To join a league, you have to draft your team first!')){document.location.href='draft.php'}else{document.location.href='draft.php'};</script>";
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
    require_once 'connection.php';
    ?>
    <div class="container" style="width:1000px;">
        <h1 align="center" style="margin-top:10px">League List</h1>
        <br />
        <div class="table-responsive">
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">League ID</th>
                        <th class="th-sm">Owner Name</th>
                        <th class="th-sm">League Name</th>
                        <th class="th-sm">Attribute</th>
                        <th class="th-sm">Size</th>
                        <th class="th-sm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM league";
                    $statement = $pdo->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach ($result as $row) {
                        ?>
                    <tr>
                    <td><?PHP echo $row['league_id']; ?></td>
                    <td><?PHP $sql="SELECT username FROM user WHERE user_id = '".$row['owner_id']."'"; 
                            $res = $pdo->query($sql)->fetch(); echo $res['username'];?></td>
                    <td><?PHP echo $row['league_name']; ?></td>
                    <td><?PHP echo $row['attribute']; ?></td>
                    <td><?PHP echo $row['size']; ?></td>
                    <td><input type="button" name="join" value="Join" league_id="<?php echo $row['league_id']; ?>" class="btn btn-info btn-xs join" /></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="th-sm">League ID</th>
                        <th class="th-sm">Owner Name</th>
                        <th class="th-sm">League Name</th>
                        <th class="th-sm">Attribute</th>
                        <th class="th-sm">Size</th>
                        <th class="th-sm">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
</body>
<script>
    $(document).ready(function() {
        var dt = $('#dtBasicExample').DataTable({
            bAutoWidth: false,
            stateSave: true
        });
        $('.dataTables_length').addClass('bs-select');
      
        $(document).on('click', ".join", function(event) {
            var league_id = $(this).attr("league_id");
            $.ajax({
                url: "joinaction.php",
                method: "post",
                data: {
                    league_id: league_id
                },
                success: function(data) {
                    if (data == "OK") {
                        alert("You have successfully joined this league.");
                        window.location.replace("match.php");
                    } else if (data == "DUP") {
                        alert("Your team already exsited in this league.");
                    } else if (data == "OVERSIZE") {
                        alert("This league you choosed is alreafy full.");
                    } else if (data == "ONLY") {
                        alert("One team currently only can join one league.");
                    }
                }
            });
        });
    });
</script>

</html>