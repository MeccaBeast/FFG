<?php
//connect to Premier league fantasy football api
 $arrContextOptions = array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ),
                    );
                    $json = file_get_contents("https://fantasy.premierleague.com/api/bootstrap-static/", false, stream_context_create($arrContextOptions));
                    $data = json_decode($json, true);?>
