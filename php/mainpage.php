<?php
// Initialize the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Premier League Fantasy Football</title>
    <style type="text/css">
        body {
            font: 14px sans-serif;
            font-family: "Oswald", sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }

        .bg-img {
            /* The image used */
            background-image: url("../image/trophy1.jpg");
            min-height: 240px;
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            /* Needed to position the navbar */
            position: relative;
        }


        /* Position the navbar container inside the image */

        .container-fluid {
            position: absolute;
            margin: 0px;
            bottom: 0px;
            width: auto;
        }

        .nav-tabs>li>a {
            background-color: cyan;
            border-color: black;
            color: black;
        }

        .nav-tabs>li+li {
            margin-left: 10px; // 2px by default
        }

        .example-container {
            width: 500px;
            margin-top: 30px;
        }

        .example-container img {
            float: left;
            width: 250px;
            height: 250px;
            padding: 0 20px 20px 0;
        }

        .container {
            font-family: "Oswald", sans-serif;
        }
    </style>
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
    <div class="bg-img">
        <div class="container-fluid">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="help-tab" data-toggle="tab" href="#help" role="tab" aria-controls="help" aria-selected="false">Help</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="example-container">
                            <img src="../image/team.jpg">
                            <h3>Draft your team</h3>
                            <p>Using limited budget to pick 15 players from player list, and arranging them according to formation and position.</p>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="example-container">
                            <img src="../image/league.jpg">
                            <h3>Create or Join a league</h3>
                            <p>Create a league with a specific size for your friends, family or someone you never meet before.
                                Also, you can join a public league or get invited by a private league.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="match_p" class="container" style="margin-top:10px">
                <h3>Real-Life Match Prediction</h3>
                <form method="post" id="edit_form">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="select">Home Team</label>
                                <select class="form-control" name="h_select" id="h_select">
                                    <option selected>Please Make A Selection</option>
                                    <?php
                                    require_once "jsoncon.php";
                                    foreach ($data['teams'] as $key => $item) {
                                        echo "<option value = '" . $item['name'] . "' >" . $item['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="select">Away Team</label>
                                <select class="form-control" name="a_select" id="a_select">
                                    <option selected>Please Make A Selection</option>
                                    <?php
                                    require_once "jsoncon.php";
                                    foreach ($data['teams'] as $key => $item) {
                                        echo "<option value = '" . $item['name'] . "'>" . $item['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" id="home_pic" style="display:table-cell; vertical-align:middle; text-align:center">

                        </div>
                        <div class="col" id="score" style="display:table-cell; vertical-align:middle; text-align:center; horizontal-align:middle ;">

                        </div>
                        <div class="col" id="away_pic" style="display:table-cell; vertical-align:middle; text-align:center">

                        </div>
                    </div><br>
                    <div align="center">
                        <button type="button" type="submit" name="predict" id="predict" class="btn btn-info predict">Start Prediction</button>
                    </div>
                </form>
            </div>
            <div class="container" style="margin-top:10px; width:800px">
                <h3>EPL fixture</h3>
                <div class="row" style="margin-top:10px;">
                    <div class="col">
                        <button type="button" type="submit" name="previous" id="previous" class="btn btn-dark previous" style="width:100px">Previous</button>
                    </div>
                    <div class="col">
                        <button type="button" type="submit" name="next" id="next" class="btn btn-dark next" style="width:100px;float: right">Next</button>
                    </div>
                </div>
                <div class="container" id="readfixture" name="readfixture" style="vertical-align:middle; text-align:center; horizontal-align:middle">

                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="help" role="tabpanel" aria-labelledby="help-tab">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                User Guide
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Game Rule
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Contact Us
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $('#myTab a').on('click', function(e) {
        e.preventDefault()
        $(this).tab('show')
    })

    $(document).ready(function() {

        load_data();
        var index = 1;

        function load_data() {
            index = 1;
            var event_n = index;
            $.ajax({
                method: "POST",
                data: {
                    event_n: event_n
                },
                url: "fixture.php",
                success: function(data) {
                    $('#readfixture').html(data);
                }
            });
        }

        $("#h_select").change(function() {
            $("#home_pic").empty();
            $("#score").empty();
            var h_name = $(this).children("option:selected").val();
            if (h_name == $("#a_select").children("option:selected").val()) {
                alert("Home team and Away team can not be the same one...");
                $("#h_select").val('Please Make A Selection');
            } else {
                if (h_name == 'Arsenal') {
                    $("#home_pic").append('<img src="../image/800px-Arsenal_FC.svg.png" width="200px" height="240px">');
                } else if (h_name == 'Aston Villa') {
                    $("#home_pic").append('<img src="../image/800px-Aston_Villa_FC_crest_(2016).svg.png" width="200px" height="240px">');
                } else if (h_name == 'Bournemouth') {
                    $("#home_pic").append('<img src="../image/800px-AFC_Bournemouth.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Brighton') {
                    $("#home_pic").append('<img src="../image/800px-Brighton_&_Hove_Albion_logo.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Burnley') {
                    $("#home_pic").append('<img src="../image/800px-Burnley_F.C._Logo.svg.png" width="200px" height="240px">');
                } else if (h_name == 'Chelsea') {
                    $("#home_pic").append('<img src="../image/800px-Chelsea_FC.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Crystal Palace') {
                    $("#home_pic").append('<img src="../image/800px-Crystal_Palace_FC_logo.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Everton') {
                    $("#home_pic").append('<img src="../image/800px-Everton_FC_logo.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Leicester') {
                    $("#home_pic").append('<img src="../image/800px-Leicester_City_crest.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Liverpool') {
                    $("#home_pic").append('<img src="../image/800px-Liverpool_FC.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Man City') {
                    $("#home_pic").append('<img src="../image/800px-Manchester_City_FC_badge.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Man Utd') {
                    $("#home_pic").append('<img src="../image/800px-Manchester_United_FC_crest.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Newcastle') {
                    $("#home_pic").append('<img src="../image/Newcastle_United_Logo.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Norwich') {
                    $("#home_pic").append('<img src="../image/800px-Norwich_City.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Sheffield Utd') {
                    $("#home_pic").append('<img src="../image/800px-Sheffield_United_FC_logo.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Southampton') {
                    $("#home_pic").append('<img src="../image/800px-FC_Southampton.svg.png" width="240px" height="240px">');
                } else if (h_name == 'Spurs') {
                    $("#home_pic").append('<img src="../image/800px-Tottenham_Hotspur.svg.png" width="120px" height="240px">');
                } else if (h_name == 'Watford') {
                    $("#home_pic").append('<img src="../image/800px-Watford.svg.png" width="240px" height="240px">');
                } else if (h_name == 'West Ham') {
                    $("#home_pic").append('<img src="../image/800px-West_Ham_United_FC_logo.svg.png" width="200px" height="240px">');
                } else if (h_name == 'Wolves') {
                    $("#home_pic").append('<img src="../image/200px-Wolverhampton_Wanderers.svg.png" width="240px" height="240px">');
                }
            }
        });

        $("#a_select").change(function() {
            $("#away_pic").empty();
            $("#score").empty();
            var a_name = $(this).children("option:selected").val();
            if (a_name == $("#h_select").children("option:selected").val()) {
                alert("Home team and Away team can not be the same one...");
                $("#a_select").val('Please Make A Selection');
            } else {
                if (a_name == 'Arsenal') {
                    $("#away_pic").append('<img src="../image/800px-Arsenal_FC.svg.png" width="200px" height="240px">');
                } else if (a_name == 'Aston Villa') {
                    $("#away_pic").append('<img src="../image/800px-Aston_Villa_FC_crest_(2016).svg.png" width="200px" height="240px">');
                } else if (a_name == 'Bournemouth') {
                    $("#away_pic").append('<img src="../image/800px-AFC_Bournemouth.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Brighton') {
                    $("#away_pic").append('<img src="../image/800px-Brighton_&_Hove_Albion_logo.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Burnley') {
                    $("#away_pic").append('<img src="../image/800px-Burnley_F.C._Logo.svg.png" width="200px" height="240px">');
                } else if (a_name == 'Chelsea') {
                    $("#away_pic").append('<img src="../image/800px-Chelsea_FC.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Crystal Palace') {
                    $("#away_pic").append('<img src="../image/800px-Crystal_Palace_FC_logo.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Everton') {
                    $("#away_pic").append('<img src="../image/800px-Everton_FC_logo.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Leicester') {
                    $("#away_pic").append('<img src="../image/800px-Leicester_City_crest.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Liverpool') {
                    $("#away_pic").append('<img src="../image/800px-Liverpool_FC.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Man City') {
                    $("#away_pic").append('<img src="../image/800px-Manchester_City_FC_badge.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Man Utd') {
                    $("#away_pic").append('<img src="../image/800px-Manchester_United_FC_crest.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Newcastle') {
                    $("#away_pic").append('<img src="../image/Newcastle_United_Logo.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Norwich') {
                    $("#away_pic").append('<img src="../image/800px-Norwich_City.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Sheffield Utd') {
                    $("#away_pic").append('<img src="../image/800px-Sheffield_United_FC_logo.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Southampton') {
                    $("#away_pic").append('<img src="../image/800px-FC_Southampton.svg.png" width="240px" height="240px">');
                } else if (a_name == 'Spurs') {
                    $("#away_pic").append('<img src="../image/800px-Tottenham_Hotspur.svg.png" width="120px" height="240px">');
                } else if (a_name == 'Watford') {
                    $("#away_pic").append('<img src="../image/800px-Watford.svg.png" width="240px" height="240px">');
                } else if (a_name == 'West Ham') {
                    $("#away_pic").append('<img src="../image/800px-West_Ham_United_FC_logo.svg.png" width="200px" height="240px">');
                } else if (a_name == 'Wolves') {
                    $("#away_pic").append('<img src="../image/200px-Wolverhampton_Wanderers.svg.png" width="240px" height="240px">');
                }
            }
        });

        $('#predict').on('click', function(event) {
            var home = $("#h_select").val();
            var away = $("#a_select").val();
            $.ajax({
                url: "cal_score.php",
                method: "POST",
                data: {
                    home: home,
                    away: away
                },
                success: function(data) {
                    console.log(data);
                    $("#score").empty();
                    $("#score").append(data);
                }
            });
        });


        $('#next').on('click', function(event) {
            index++;
            var event_n = index;
            if (event_n > 38) {
                alert("This is the end of the fixture.");
            } else {
                $.ajax({
                    method: "POST",
                    data: {
                        event_n: event_n
                    },
                    url: "fixture.php",
                    success: function(data) {
                        $('#readfixture').html(data);
                    }
                });
            }
        });

        $('#previous').on('click', function(event) {
            index--;
            var event_n = index;
            if (event_n < 1) {
                alert("This is the start of the fixture.");
            } else {
                $.ajax({
                    method: "POST",
                    data: {
                        event_n: event_n
                    },
                    url: "fixture.php",
                    success: function(data) {
                        $('#readfixture').html(data);
                    }
                });
            }
        });
    });
</script>

</html>