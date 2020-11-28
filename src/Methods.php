<?php

require_once '../../src/Database/DBOperations.php';
require_once '../../src/MBFunctions.php';
require_once '../../src/RPC/JSON_RPC.php';
require_once '../../src/errors.php';
require_once '../../src/Check/regex.php';


class Methods {

    private DBOperations $db;
    private MBFunctions $mb;
    private JSON_RPC $rpc;

    public function __construct() {
        $this->db = new DBOperations();
        $this->mb = new MBFunctions();
        $this->rpc = new JSON_RPC();
    }

    private function error($error) {
        return $this->rpc->makeErrorResponse(__CLASS__, $error, debug_backtrace()[1]['function']);
    }

    public function getTournamentIntro($data)
    {
        $db = $this->db;
        $name = $data->name;

        return $this->rpc->makeResultResponse($db->getTournamentIntro($name));
    }

    public function getTournamentInfo($data)
    {
        $db = $this->db;
        $name = $data->name;

        return $this->rpc->makeResultResponse($db->getTournamentInfo($name));
    }

    public function getTournamentList()
    {
        $db = $this->db;

        return $this->rpc->makeResultResponse($db->getTournamentList());
    }

    public function getTeamList()
    {
        $db = $this->db;

        return $this->rpc->makeResultResponse($db->getTeamList());
    }

    public function getParticipantTeams($data)
    {
        $db = $this->db;
        $name = $data->name;

        return $this->rpc->makeResultResponse($db->getParticipantTeams($name));
    }

    public function getMatchesInfo($data)
    {
        $db = $this->db;
        $name = $data->name;

        return $this->rpc->makeResultResponse($db->getMatchesInfo($name));
    }

    public function getMatch($data)
    {
        $db = $this->db;
        $name = $data->id;

        return $this->rpc->makeResultResponse($db->getMatch($name));
    }

    public function getTeam($data)
    {
        $db = $this->db;
        $name = $data->name;

        return $this->rpc->makeResultResponse($db->getTeam($name));
    }
}
