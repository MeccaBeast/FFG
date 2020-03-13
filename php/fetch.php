<?php
// table of match record management
require_once "connection.php";
$output = "<form name='frm' method='POST' action=''>
<table id='matchtable' class='table table-striped table-bordered table-sm' cellspacing='0' width='100%'>
<thead>
    <tr>
        <th class='th-sm'>Match ID</th>
        <th class='th-sm'>Date</th>
        <th class='th-sm'>League Name</th>
        <th class='th-sm'>Home Team</th>
        <th class='th-sm'>Away Team</th>
        <th class='th-sm'>Home Win</th>
        <th class='th-sm'>Away Win</th>
        <th class='th-sm'>Draw</th>
        <th class='th-sm'>Action</th>
    </tr>
</thead>
<tbody>";
$sql = "SELECT * FROM matchrecord";
$statement = $pdo->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $row) {
    $output .= '
            <tr>
            <td match_id = ' . $row['match_id'] . '>' . $row['match_id'] . '</td>
            <td>' . $row['date'] . '</td>';
    $query = "SELECT league_name FROM league WHERE league_id = '" . $row['league_id'] . "'";
    $res = $pdo->query($query)->fetch();
    $output .= '<td> ' . $res['league_name'] . ' </td>';
    $query1 = "SELECT team_name FROM draftteam WHERE team_id = '" . $row['home'] . "'";
    $res1 = $pdo->query($query1)->fetch();
    $output .= '<td> ' . $res1['team_name'] . ' </td>';
    $query2 = "SELECT team_name FROM draftteam WHERE team_id = '" . $row['away'] . "'";
    $res2 = $pdo->query($query2)->fetch();
    $output .= '<td> ' . $res2['team_name'] . ' </td>';
    if ($row['home_win'] == 1) {
        $output .= "<td> &#10004 </td>";
    } else {
        $output .= "<td> X </td>";
    }
    if ($row['away_win'] == 1) {
        $output .= "<td> &#10004  </td>";
    } else {
        $output .= "<td> X </td>";
    }
    if ($row['draw'] == 1) {
        $output .= "<td> &#10004  </td>";
    } else {
        $output .= "<td> X </td>";
    }
    $output .= "<td><input type='button' data-toggle='modal' data-target='#exampleModalScrollable' name='edit' value='Edit' match_id='" . $row['match_id'] . "' class='btn btn-primary btn-xs edit_data' />
                <input type='button' id='mdelete' name='mdelete' value='Delete' match_id='" . $row['match_id'] . "' class='btn btn-danger btn-xs delete_data' /></td>
        </tr>";
}
$output .= "
    </tbody>
    <tfoot>
        <tr>
            <th class='th-sm'>Match ID</th>
            <th class='th-sm'>Date</th>
            <th class='th-sm'>League Name</th>
            <th class='th-sm'>Home Team</th>
            <th class='th-sm'>Away Team</th>
            <th class='th-sm'>Home Win</th>
            <th class='th-sm'>Away Win</th>
            <th class='th-sm'>Draw</th>
            <th class='th-sm'>Action</th>
        </tr>
    </tfoot>
</table>
</form>
<script>
var mt = $('#matchtable').DataTable({
    bAutoWidth: false,
    stateSave: true
});
$('.dataTables_length').addClass('bs-select');
$(document).ready(function() {
    function load_data() {
        $.ajax({
            method: 'POST',
            url: 'fetch.php',
            success: function(data) {
                $('#match_data').html(data);
            }
        });
    }

    $('.edit_data').on('click', function() {
        var mid = $(this).closest('tr').children()[0].textContent;
        var date = $(this).closest('tr').children()[1].textContent;
        $('#mid').val(mid);
        $('#date').val(date);
    });

    $('.delete_data').on('click', function(event) {
        var mid = $('#mdelete').attr('match_id');
        var action = 'delete_record';
        $.ajax({
            url: 'adminedit.php',
            method: 'POST',
            data: {
                mid:mid,
                action: action
            },
            success: function(data) {
                console.log(data);
                alert('Successfully delete!');
                load_data();
            }
        });
    });
});
</script>";
echo $output;
?>
