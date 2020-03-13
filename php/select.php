<?php   
 require_once "jsoncon.php";
 $output = "";
 if(isset($_POST["player_id"])){
     for ($i = 0; $i < count($data['elements']); $i++) {
          if ($data['elements'][$i]['id'] == $_POST["player_id"]) {
               $output .= '  
               <div class="table-responsive">  
                    <table class="table table-bordered">
               <tr>'; 
               $filename = $data['elements'][$i]['photo'];
               $filename = str_replace(strrchr($filename, '.'), '', $filename);
               echo "<img src='https://platform-static-files.s3.amazonaws.com/premierleague/photos/players/110x140/p$filename.png' class='img-fluid' alt='Responsive image'>";
               $output .='
               </tr> 
               <tr>  
                    <td width="30%"><label>ID</label></td>  
                    <td width="70%">'.$data['elements'][$i]['id'].'</td>  
               </tr> 
               <tr>  
                     <td width="30%"><label>Web Name</label></td>  
                     <td width="70%">'.$data['elements'][$i]['web_name'].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Player ID</label></td>  
                     <td width="70%">'.$data['elements'][$i]['code'].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Full Name</label></td>  
                     <td width="70%">'.$data['elements'][$i]['first_name'].' '.$data['elements'][$i]["second_name"].'</td>  
                </tr>
                <tr>  
                    <td width="30%"><label>Current Price</label></td>  
                    <td width="70%">'.$data['elements'][$i]['now_cost'].'</td>  
               </tr> 
                <tr>  
                     <td width="30%"><label>Value Season</label></td>  
                     <td width="70%">'.$data['elements'][$i]['value_season'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Cost Change from Start</label></td>  
                     <td width="70%">'.$data['elements'][$i]['cost_change_start'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Percentage selected by</label></td>  
                     <td width="70%">'.$data['elements'][$i]['selected_by_percent'].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Transfers In</label></td>  
                     <td width="70%">'.$data['elements'][$i]['transfers_in'].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Transfers Out</label></td>  
                     <td width="70%">'.$data['elements'][$i]['transfers_out'].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Points Per Game</label></td>  
                     <td width="70%">'.$data['elements'][$i]['points_per_game'].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Minutes</label></td>  
                     <td width="70%">'.$data['elements'][$i]['minutes'].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Goals Scored</label></td>  
                     <td width="70%">'.$data['elements'][$i]['goals_scored'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Assists</label></td>  
                     <td width="70%">'.$data['elements'][$i]['assists'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Clean Sheets</label></td>  
                     <td width="70%">'.$data['elements'][$i]['clean_sheets'].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Goals Conceded</label></td>  
                     <td width="70%">'.$data['elements'][$i]['goals_conceded'].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Own Goals</label></td>  
                     <td width="70%">'.$data['elements'][$i]['own_goals'].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Penalties Saved</label></td>  
                     <td width="70%">'.$data['elements'][$i]['penalties_saved'].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Penalties Missed</label></td>  
                     <td width="70%">'.$data['elements'][$i]['penalties_missed'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Yellow Cards</label></td>  
                     <td width="70%">'.$data['elements'][$i]['yellow_cards'].'</td>  
                </tr>   
                <tr>  
                     <td width="30%"><label>Red Cards</label></td>  
                     <td width="70%">'.$data['elements'][$i]['red_cards'].'</td>  
                </tr>   
                <tr>  
                     <td width="30%"><label>Saves</label></td>  
                     <td width="70%">'.$data['elements'][$i]['saves'].'</td>  
                </tr>   
                <tr>  
                     <td width="30%"><label>Bonus Points</label></td>  
                     <td width="70%">'.$data['elements'][$i]['bonus'].'</td>  
                </tr>      
                <tr>  
                     <td width="30%"><label>Bonus Point System Score</label></td>  
                     <td width="70%">'.$data['elements'][$i]['bps'].'</td>  
                </tr>   
                <tr>  
                     <td width="30%"><label>Influence</label></td>  
                     <td width="70%">'.$data['elements'][$i]['influence'].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Creativity</label></td>  
                     <td width="70%">'.$data['elements'][$i]['creativity'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Threat</label></td>  
                     <td width="70%">'.$data['elements'][$i]['threat'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>ICT Index</label></td>  
                     <td width="70%">'.$data['elements'][$i]['ict_index'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>News</label></td>  
                     <td width="70%">'.$data['elements'][$i]['news'].'</td>  
                </tr> 
               </table></div>';
               echo $output;
          }
     }
}
 ?>