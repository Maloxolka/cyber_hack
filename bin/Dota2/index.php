<?php
require_once '../../src/Methods.php';
require_once '../../src/Check/DataCheck.php';
require_once '../../src/RPC/JSON_RPC.php';
require_once '../../src/errors.php';

$methods = new Methods();
$check = new DataCheck();
$rpc = new JSON_RPC();

mb_internal_encoding("UTF-8");

function error($error, $method = "empty") {
    global $rpc;
    return $rpc->makeErrorResponse("index.php", $error, $method);
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $raw_data = json_decode(file_get_contents("php://input"), false, 512, JSON_THROW_ON_ERROR);
    } catch(JsonException $e) {
        error(ERR_DECODE);
    }

    if (!empty($raw_data)) {
        $params = $raw_data->params;

        if ($rpc->checkRequestFormat($raw_data)) {
            $method = $raw_data->method;
            if ($method == "getTournamentList") {
                if (true) {
                    echo $methods->getTournamentList();
                } else {
                    echo error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method == "getTournamentIntro") {
                if (true) {
                    echo $methods->getTournamentIntro($params);
                } else {
                    echo error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method == "getTournamentInfo") {
                if (true) {
                    echo $methods->getTournamentInfo($params);
                } else {
                    echo error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method == "getParticipantTeams") {
                if (true) {
                    echo $methods->getParticipantTeams($params);
                } else {
                    echo error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method == "getMatchesInfo") {
                if (true) {
                    echo $methods->getMatchesInfo($params);
                } else {
                    echo error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method == "getMatch") {
                if (true) {
                    echo $methods->getMatch($params);
                } else {
                    echo error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method == "getTeamList") {
                if (true) {
                    echo $methods->getTeamList($params);
                } else {
                    echo error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method == "getTeam") {
                if (true) {
                    echo $methods->getTeam($params);
                } else {
                    echo error(ERR_INVALID_PARAMS, $method);
                }
            } else {
                echo error(ERR_METHOD_NOT_FOUND, $method);
            }
        } else {
            echo error(ERR_INVALID_REQUEST);
        }
    } else {
        echo error(ERR_PARSE);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "User module ready";
}


