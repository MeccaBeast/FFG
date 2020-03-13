<?php
// get official EPL fixture from API
$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);
$json = file_get_contents("https://fantasy.premierleague.com/api/fixtures/", false, stream_context_create($arrContextOptions));
$data = json_decode($json, true);
$json1 = file_get_contents("https://fantasy.premierleague.com/api/bootstrap-static/", false, stream_context_create($arrContextOptions));
$data1 = json_decode($json1, true);
$en = $_POST['event_n'];
$output="";
$output.="<table class='table table-borderless'>
<thead>
<tr>
<td>Date</td>
<td>Home</td>
<td></td>
<td></td>
<td></td>
<td>Away</td>
</tr>
</thead>";
for($i = 0; $i < count($data); $i++){
    if($data[$i]["event"] == $en){
        $output.="
        <tr>
        <td>".$data[$i]['kickoff_time']."</td>
        <td>";
        foreach($data1["teams"] as $item){
            if($item['id']==$data[$i]['team_h']){
                $home = $item['name'];
                if ($home == 'Arsenal') {
                    $output.= '<img src="../image/800px-Arsenal_FC.svg.png" width="40px" height="50px">';
                } else if ($home == 'Aston Villa') {
                    $output.='<img src="../image/800px-Aston_Villa_FC_crest_(2016).svg.png" width="40px" height="50px">';
                } else if ($home == 'Bournemouth') {
                    $output.='<img src="../image/800px-AFC_Bournemouth.svg.png" width="50px" height="50px">';
                } else if ($home == 'Brighton') {
                    $output.='<img src="../image/800px-Brighton_&_Hove_Albion_logo.svg.png" width="50px" height="50px">';
                } else if ($home == 'Burnley') {
                    $output.='<img src="../image/800px-Burnley_F.C._Logo.svg.png" width="40px" height="50px">';
                } else if ($home == 'Chelsea') {
                    $output.='<img src="../image/800px-Chelsea_FC.svg.png" width="50px" height="50px">';
                } else if ($home == 'Crystal Palace') {
                    $output.='<img src="../image/800px-Crystal_Palace_FC_logo.svg.png" width="50px" height="50px">';
                } else if ($home == 'Everton') {
                    $output.='<img src="../image/800px-Everton_FC_logo.svg.png" width="50px" height="50px">';
                } else if ($home == 'Leicester') {
                    $output.='<img src="../image/800px-Leicester_City_crest.svg.png" width="50px" height="50px">';
                } else if ($home == 'Liverpool') {
                    $output.='<img src="../image/800px-Liverpool_FC.svg.png" width="50px" height="50px">';
                } else if ($home == 'Man City') {
                    $output.='<img src="../image/800px-Manchester_City_FC_badge.svg.png" width="50px" height="50px">';
                } else if ($home == 'Man Utd') {
                    $output.='<img src="../image/800px-Manchester_United_FC_crest.svg.png" width="50px" height="50px">';
                } else if ($home == 'Newcastle') {
                    $output.='<img src="../image/Newcastle_United_Logo.svg.png" width="50px" height="50px">';
                } else if ($home == 'Norwich') {
                    $output.='<img src="../image/800px-Norwich_City.svg.png" width="45px" height="50px">';
                } else if ($home == 'Sheffield Utd') {
                    $output.='<img src="../image/800px-Sheffield_United_FC_logo.svg.png" width="50px" height="50px">';
                } else if ($home == 'Southampton') {
                    $output.='<img src="../image/800px-FC_Southampton.svg.png" width="50px" height="50px">';
                } else if ($home == 'Spurs') {
                    $output.='<img src="../image/800px-Tottenham_Hotspur.svg.png" width="30px" height="50px">';
                } else if ($home == 'Watford') {
                    $output.='<img src="../image/800px-Watford.svg.png" width="50px" height="50px">';
                } else if ($home == 'West Ham') {
                    $output.='<img src="../image/800px-West_Ham_United_FC_logo.svg.png" width="40px" height="50px">';
                } else if ($home == 'Wolves') {
                    $output.='<img src="../image/200px-Wolverhampton_Wanderers.svg.png" width="50px" height="50px">';
                }
            }
        }
        $output.="</td>
        <td><p style='font-size:30px'>".$data[$i]['team_h_score']."</p></td>
        <td><p style='font-size:30px'>:</p></td>
        <td><p style='font-size:30px'>".$data[$i]['team_a_score']."</p></td>
        <td>";
        foreach($data1["teams"] as $item){
            if($item['id']==$data[$i]['team_a']){
                $away = $item['name'];
                if ($away == 'Arsenal') {
                    $output.= '<img src="../image/800px-Arsenal_FC.svg.png" width="40px" height="50px">';
                } else if ($away == 'Aston Villa') {
                    $output.='<img src="../image/800px-Aston_Villa_FC_crest_(2016).svg.png" width="40px" height="50px">';
                } else if ($away == 'Bournemouth') {
                    $output.='<img src="../image/800px-AFC_Bournemouth.svg.png" width="50px" height="50px">';
                } else if ($away == 'Brighton') {
                    $output.='<img src="../image/800px-Brighton_&_Hove_Albion_logo.svg.png" width="50px" height="50px">';
                } else if ($away == 'Burnley') {
                    $output.='<img src="../image/800px-Burnley_F.C._Logo.svg.png" width="40px" height="50px">';
                } else if ($away == 'Chelsea') {
                    $output.='<img src="../image/800px-Chelsea_FC.svg.png" width="50px" height="50px">';
                } else if ($away == 'Crystal Palace') {
                    $output.='<img src="../image/800px-Crystal_Palace_FC_logo.svg.png" width="50px" height="50px">';
                } else if ($away == 'Everton') {
                    $output.='<img src="../image/800px-Everton_FC_logo.svg.png" width="50px" height="50px">';
                } else if ($away == 'Leicester') {
                    $output.='<img src="../image/800px-Leicester_City_crest.svg.png" width="50px" height="50px">';
                } else if ($away == 'Liverpool') {
                    $output.='<img src="../image/800px-Liverpool_FC.svg.png" width="50px" height="50px">';
                } else if ($away == 'Man City') {
                    $output.='<img src="../image/800px-Manchester_City_FC_badge.svg.png" width="50px" height="50px">';
                } else if ($away == 'Man Utd') {
                    $output.='<img src="../image/800px-Manchester_United_FC_crest.svg.png" width="50px" height="50px">';
                } else if ($away == 'Newcastle') {
                    $output.='<img src="../image/Newcastle_United_Logo.svg.png" width="50px" height="50px">';
                } else if ($away == 'Norwich') {
                    $output.='<img src="../image/800px-Norwich_City.svg.png" width="45px" height="50px">';
                } else if ($away == 'Sheffield Utd') {
                    $output.='<img src="../image/800px-Sheffield_United_FC_logo.svg.png" width="50px" height="50px">';
                } else if ($away == 'Southampton') {
                    $output.='<img src="../image/800px-FC_Southampton.svg.png" width="50px" height="50px">';
                } else if ($away == 'Spurs') {
                    $output.='<img src="../image/800px-Tottenham_Hotspur.svg.png" width="30px" height="50px">';
                } else if ($away == 'Watford') {
                    $output.='<img src="../image/800px-Watford.svg.png" width="50px" height="50px">';
                } else if ($away == 'West Ham') {
                    $output.='<img src="../image/800px-West_Ham_United_FC_logo.svg.png" width="40px" height="50px">';
                } else if ($away == 'Wolves') {
                    $output.='<img src="../image/200px-Wolverhampton_Wanderers.svg.png" width="50px" height="50px">';
                }
            }
        }
        $output.="</td>
        </tr>";
    }
}
$output.="</table>";
echo $output;
?>
