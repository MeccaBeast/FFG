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

        .container {
            font-family: "Oswald", sans-serif;
        }
    </style>
    <title>Player Statistics-Premier League Fantasy Football</title>
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
    <div class="container" style="width:800px;">
        <h1 align="center" style="margin-top:15px">Player Database</h1>
        <br />
        <div class="table-responsive">
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">ID</th>
                        <th class="th-sm">Photo</th>
                        <th class="th-sm">Full Name</th>
                        <th class="th-sm">Team</th>
                        <th class="th-sm">Position</th>
                        <th class="th-sm">Current Price</th>
                        <th class="th-sm">Total Points</th>
                        <th class="th-sm">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?PHP
                    require_once "jsoncon.php";
                    foreach ($data['elements'] as $key => $item) {
                        ?>
                    <tr>
                        <td><?PHP echo $item['id']; ?></td>
                        <td><?PHP
                                $filename = $item['photo'];
                                $filename = str_replace(strrchr($filename, '.'), '', $filename);
                                echo "<img src='https://platform-static-files.s3.amazonaws.com/premierleague/photos/players/110x140/p$filename.png' class='img-fluid' alt='Responsive image'  width='60' height='50'>"; ?></td>
                        <td><?PHP echo $item['first_name']; ?> <?PHP echo $item['second_name']; ?></td>
                        <td><?PHP
                                for ($i = 0; $i < count($data['teams']); $i++) {
                                    if ($item['team_code'] == $data['teams'][$i]['code']) {
                                        echo $data['teams'][$i]['name'];
                                    }
                                }
                                ?></td>
                        <td><?PHP
                                for ($i = 0; $i < count($data['element_types']); $i++) {
                                    if ($item['element_type'] == $data['element_types'][$i]['id']) {
                                        echo $data['element_types'][$i]['plural_name'];
                                    }
                                } ?></td>
                        <td><?PHP echo $item['now_cost']; ?></td>
                        <td><?PHP echo $item['total_points']; ?></td>
                        <td><input type="button" name="view" value="View" player_id="<?php echo $item['id']; ?>" class="btn btn-info btn-xs view_data" /></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="th-sm">ID</th>
                        <th class="th-sm">Player Photo</th>
                        <th class="th-sm">Full Name</th>
                        <th class="th-sm">Team</th>
                        <th class="th-sm">Position</th>
                        <th class="th-sm">Current Price</th>
                        <th class="th-sm">Total Points</th>
                        <th class="th-sm">Detail
                        </th>
                    </tr>
                </tfoot>
            </table>
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
</body>
<script>
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

    });
</script>

</html>