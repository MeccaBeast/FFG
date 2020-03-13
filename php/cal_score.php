<?php
$home = $_POST["home"];
$away = $_POST["away"];

$home_team_history_total_goal = 0;
$home_team_history_total_lost = 0;

$away_team_history_total_goal = 0;
$away_team_history_total_lost = 0;

$home_total_goal = 0;
$away_total_goal = 0;

$output = '';

require_once "jsoncon.php";
//History Goal and Goal conceded for last 10 seasons and current season
$json0910 = file_get_contents("../json/season-0910_json.json", false, stream_context_create($arrContextOptions));
$json0910_array = json_decode($json0910, true);

$json1011 = file_get_contents("../json/season-1011_json.json", false, stream_context_create($arrContextOptions));
$json1011_array = json_decode($json1011, true);

$json1112 = file_get_contents("../json/season-1112_json.json", false, stream_context_create($arrContextOptions));
$json1112_array = json_decode($json1112, true);

$json1213 = file_get_contents("../json/season-1213_json.json", false, stream_context_create($arrContextOptions));
$json1213_array = json_decode($json1213, true);

$json1314 = file_get_contents("../json/season-1314_json.json", false, stream_context_create($arrContextOptions));
$json1314_array = json_decode($json1314, true);

$json1415 = file_get_contents("../json/season-1415_json.json", false, stream_context_create($arrContextOptions));
$json1415_array = json_decode($json1415, true);

$json1516 = file_get_contents("../json/season-1516_json.json", false, stream_context_create($arrContextOptions));
$json1516_array = json_decode($json1516, true);

$json1617 = file_get_contents("../json/season-1617_json.json", false, stream_context_create($arrContextOptions));
$json1617_array = json_decode($json1617, true);

$json1718 = file_get_contents("../json/season-1718_json.json", false, stream_context_create($arrContextOptions));
$json1718_array = json_decode($json1718, true);

$json1819 = file_get_contents("../json/season-1819_json.json");
$json1819_array = json_decode($json1819, true);

$json1920 = file_get_contents("https://fantasy.premierleague.com/api/fixtures/", false, stream_context_create($arrContextOptions));
$json1920_array = json_decode($json1920, true);

for ($i = 0; $i < count($json0910_array); $i++) {
    if ($json0910_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json0910_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json0910_array[$i]['FTAG'];
    }
    if ($json0910_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json0910_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json0910_array[$i]['FTHG'];
    }
    if ($json0910_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json0910_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json0910_array[$i]['FTAG'];
    }
    if ($json0910_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json0910_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json0910_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json0910_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json0910_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1011_array); $i++) {
    if ($json1011_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1011_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1011_array[$i]['FTAG'];
    }
    if ($json1011_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1011_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1011_array[$i]['FTHG'];
    }
    if ($json1011_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1011_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1011_array[$i]['FTAG'];
    }
    if ($json1011_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1011_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1011_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json1011_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json1011_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1112_array); $i++) {
    if ($json1112_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1112_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1112_array[$i]['FTAG'];
    }
    if ($json1112_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1112_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1112_array[$i]['FTHG'];
    }
    if ($json1112_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1112_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1112_array[$i]['FTAG'];
    }
    if ($json1112_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1112_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1112_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json1112_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json1112_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1213_array); $i++) {
    if ($json1213_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1213_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1213_array[$i]['FTAG'];
    }
    if ($json1213_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1213_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1213_array[$i]['FTHG'];
    }
    if ($json1213_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1213_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1213_array[$i]['FTAG'];
    }
    if ($json1213_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1213_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1213_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json1213_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json1213_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1314_array); $i++) {
    if ($json1314_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1314_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1314_array[$i]['FTAG'];
    }
    if ($json1314_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1314_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1314_array[$i]['FTHG'];
    }
    if ($json1314_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1314_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1314_array[$i]['FTAG'];
    }
    if ($json1314_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1314_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1314_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json1314_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json1314_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1415_array); $i++) {
    if ($json1415_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1415_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1415_array[$i]['FTAG'];
    }
    if ($json1415_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1415_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1415_array[$i]['FTHG'];
    }
    if ($json1415_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1415_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1415_array[$i]['FTAG'];
    }
    if ($json1415_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1415_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1415_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json1415_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json1415_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1516_array); $i++) {
    if ($json1516_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1516_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1516_array[$i]['FTAG'];
    }
    if ($json1516_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1516_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1516_array[$i]['FTHG'];
    }
    if ($json1516_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1516_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1516_array[$i]['FTAG'];
    }
    if ($json1516_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1516_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1516_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json1516_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json1516_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1617_array); $i++) {
    if ($json1617_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1617_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1617_array[$i]['FTAG'];
    }
    if ($json1617_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1617_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1617_array[$i]['FTHG'];
    }
    if ($json1617_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1617_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1617_array[$i]['FTAG'];
    }
    if ($json1617_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1617_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1617_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json1617_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json1617_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1718_array); $i++) {
    if ($json1718_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1718_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1718_array[$i]['FTAG'];
    }
    if ($json1718_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1718_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1718_array[$i]['FTHG'];
    }
    if ($json1718_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1718_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1718_array[$i]['FTAG'];
    }
    if ($json1718_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1718_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1718_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json1718_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json1718_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1819_array); $i++) {
    if ($json1819_array[$i]['HomeTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1819_array[$i]['FTHG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1819_array[$i]['FTAG'];
    }
    if ($json1819_array[$i]['AwayTeam'] == $home) {
        $home_team_history_total_goal = $home_team_history_total_goal + $json1819_array[$i]['FTAG'];
        $home_team_history_total_lost = $home_team_history_total_lost + $json1819_array[$i]['FTHG'];
    }
    if ($json1819_array[$i]['HomeTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1819_array[$i]['FTHG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1819_array[$i]['FTAG'];
    }
    if ($json1819_array[$i]['AwayTeam'] == $away) {
        $away_team_history_total_goal = $away_team_history_total_goal + $json1819_array[$i]['FTAG'];
        $away_team_history_total_lost = $away_team_history_total_lost + $json1819_array[$i]['FTHG'];
    }
    $home_total_goal = $home_total_goal + $json1819_array[$i]['FTHG'];
    $away_total_goal = $away_total_goal + $json1819_array[$i]['FTAG'];
}

for ($i = 0; $i < count($json1920_array); $i++) {
    for ($q = 0; $q < count($data['teams']); $q++) {
        if ($data['teams'][$q]['name'] == $home) {
            if ($json1920_array[$i]['team_h'] == $data['teams'][$q]['id']) {
                $home_team_history_total_goal = $home_team_history_total_goal + $json1920_array[$i]['team_h_score'];
                $home_team_history_total_lost = $home_team_history_total_lost + $json1920_array[$i]['team_a_score'];
            }
            if ($json1920_array[$i]['team_a'] == $data['teams'][$q]['id']) {
                $home_team_history_total_goal = $home_team_history_total_goal + $json1920_array[$i]['team_a_score'];
                $home_team_history_total_lost = $home_team_history_total_lost + $json1920_array[$i]['team_h_score'];
            }
        }
        if ($data['teams'][$q]['name'] == $away) {
            if ($json1920_array[$i]['team_h'] == $data['teams'][$q]['id']) {
                $away_team_history_total_goal = $away_team_history_total_goal + $json1920_array[$i]['team_h_score'];
                $away_team_history_total_lost = $away_team_history_total_lost + $json1920_array[$i]['team_a_score'];
            }
            if ($json1920_array[$i]['team_a'] == $data['teams'][$q]['id']) {
                $away_team_history_total_goal = $away_team_history_total_goal + $json1920_array[$i]['team_a_score'];
                $away_team_history_total_lost = $away_team_history_total_lost + $json1920_array[$i]['team_h_score'];
            }
        }
    }
    $home_total_goal = $home_total_goal + $json1920_array[$i]['team_h_score'];
    $away_total_goal = $away_total_goal + $json1920_array[$i]['team_a_score'];
}
//Possion algorithm to calculate and predict the match score
$average_home = $home_total_goal / 3800;
$average_away = $away_total_goal / 3800;

$atk_ab_h = ($home_team_history_total_goal / 190) / $average_home;
$def_ab_a = ($away_team_history_total_lost / 190) / $average_home;
$score_h = $atk_ab_h * $average_home * $def_ab_a;

$atk_ab_a = ($away_team_history_total_goal / 190) / $average_away;
$def_ab_h = ($home_team_history_total_lost / 190) / $average_away;
$score_a = $atk_ab_a * $average_away * $def_ab_h;

function factorial($number)
{
    if ($number < 2) {
        return 1;
    } else {
        return ($number * factorial($number - 1));
    }
}

function poisson($chance, $occurrence)
{
    $e = exp(1);

    $a = pow($e, (-1 * $chance));
    $b = pow($chance, $occurrence);
    $c = factorial($occurrence);

    return $a * $b / $c;
}

$p_h = array();
$p_a = array();

$h_p_h = 0;
$h_p_a = 0;

$s_h = 0;
$s_a = 0;

for ($k = 0; $k <= 5; $k++) {
    $p_h[$k] = poisson($score_h, $k);
    $p_a[$k] = poisson($score_a, $k);
}

//print_r($p_h);
//print_r($p_a);

for ($k = 0; $k <= 5; $k++) {
    if ($h_p_h < $p_h[$k]) {
        $h_p_h = $p_h[$k];
        $s_h = $k;
    } else {
        $h_p_h = $h_p_h;
        $s_h = $s_h;
    }
}

for ($k = 0; $k <= 5; $k++) {
    if ($h_p_a < $p_a[$k]) {
        $h_p_a = $p_a[$k];
        $s_a = $k;
    } else {
        $h_p_a = $h_p_a;
        $s_a = $s_a;
    }
}
//Find top scorer in each team according to ICT_index
$ht_ict = array();
$at_ict = array();

for ($i = 0; $i < count($data['teams']); $i++) {
    if ($data['teams'][$i]['name'] == $home) {
        foreach ($data['elements'] as $key => $item) {
            if ($item['team'] == $data['teams'][$i]['id']) {
                $newarray=array($item['id'], $item['first_name'],$item['second_name'],$item['ict_index']);
                array_push($ht_ict, $newarray);
            }
        }
    }
    if ($data['teams'][$i]['name'] == $away) {
        foreach ($data['elements'] as $key => $item) {
            if ($item['team'] == $data['teams'][$i]['id']) {
                $newarray=array($item['id'],$item['first_name'],$item['second_name'],$item['ict_index']);
                array_push($at_ict, $newarray);
            }
        }
    }
}

function usort_callback($a, $b)
{
  if ( $a['3'] == $b['3'] )
    return 0;

  return ( $a['3'] > $b['3'] ) ? -1 : 1;
}

usort($ht_ict, 'usort_callback');
usort($at_ict, 'usort_callback');
//Array that contains top scorers for each team
$h_top = array_slice($ht_ict, 0, $s_h);
$a_top = array_slice($at_ict, 0, $s_a);
//Goal time array
$array_n_h=array();
$array_n_a=array();
//Score and goal sheet output
$output .= "<p style='font-size:100px;'>$s_h:$s_a</p>";
$output .= "<div class='row'>
<div class='col'>
<p style = 'text-align:left'>Home Goal Sheet:</p>";
for($i=0;$i<$s_h;$i++){
    $number = mt_rand(1, 95);
    array_push($array_n_h,$number);
}
for($i=0;$i<$s_a;$i++){
    $number = mt_rand(1, 95);
    array_push($array_n_a,$number);
}
//sort goal time
for($j = 0; $j < count($array_n_h); $j ++) {
    for($i = 0; $i < count($array_n_h)-1; $i ++){

        if($array_n_h[$i] > $array_n_h[$i+1]) {
            $temp = $array_n_h[$i+1];
            $array_n_h[$i+1]=$array_n_h[$i];
            $array_n_h[$i]=$temp;
        }       
    }
}

for($j = 0; $j < count($array_n_a); $j ++) {
    for($i = 0; $i < count($array_n_a)-1; $i ++){

        if($array_n_a[$i] > $array_n_a[$i+1]) {
            $temp = $array_n_a[$i+1];
            $array_n_a[$i+1]=$array_n_a[$i];
            $array_n_a[$i]=$temp;
        }       
    }
}

for($i=0;$i<$s_h;$i++){
    $k = array_rand($h_top);
    $s = $h_top[$k]['2'];
    $number = $array_n_h[$i];
    if($number > 90){
        $output .= "<p style = 'text-align:left'>(90+ min)$s</p>";
    }else{
        $output .= "<p style = 'text-align:left'>($number min)$s</p>";
    }
}
$output .= "</div><div class='col'>
<p style = 'text-align:right'>Away Goal Sheet:</p>";
for($i=0;$i<$s_a;$i++){
    $k = array_rand($a_top);
    $s = $a_top[$k]['2'];
    $number = $array_n_a[$i];
    if($number > 90){
        $output .= "<p style = 'text-align:left'>(90+ min)$s</p>";
    }else{
        $output .= "<p style = 'text-align:left'>($number min)$s</p>";
    }
}
$output .= "</div></div>";
echo $output;
