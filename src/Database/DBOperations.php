<?php

require_once '../../src/ConfigLoader.php';
require_once '../../src/Log/LogWriter.php';
require_once '../../src/errors.php';


class DBOperations {

    private PDO $conn;
    private LogWriter $log;
    private ConfigLoader $config;

    public function __construct() {
        $this->config = new ConfigLoader;
        $this->log = new LogWriter();
        $this->conn = new PDO(
            "mysql:dbname=".$this->config->get('db.name')."; host=".$this->config->get('db.host'),
            $this->config->get('db.user'),
            $this->config->get('db.pass')
        );
        $this->conn->exec("SET NAMES 'utf-8'");
        $this->conn->exec("SET CHARACTER SET 'utf8'");
    }

    private function error($error): void {
        $this->log->logEntry(__CLASS__, debug_backtrace()[1]['function'], $error);
    }

    public function parseDate($date) {
        return $date[8].$date[9].".".$date[5].$date[6];
    }

    public function getTournamentList() {
        $sql = 'SELECT name FROM tournaments';

        $query = $this->conn->query($sql);

        $result = $query->fetchAll();

        return $result;
    }

    public function getTournamentIntro($tournament_name) {
        $sql = 'SELECT * FROM tournaments WHERE name = :name';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':name' => $tournament_name,
            )
        );

        $data = $query->fetchObject();

        $result["tournament"] = $data->name;
        $result["start"] = $this->parseDate($data->start_date);
        $result["end"] = $this->parseDate($data->end_date);
        $result["format"] = $data->format;
        $result["fund"] = $data->fund;
        $result["tier"] = $data->tier;

        $id = $data->id_tournament;

        $sql = 'SELECT COUNT(*) AS "count" FROM participants WHERE id_tournament = :id_tournament';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_tournament' => $id,
            )
        );

        $data = $query->fetchObject();

        $result["count"] = $data->count;

        return $result;
    }

    public function getTournamentInfo($tournament_name) {
        $sql = 'SELECT * FROM tournaments WHERE name = :name';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':name' => $tournament_name,
            )
        );

        $data = $query->fetchObject();

        $result["tournament"] = $data->name;
        $result["start"] = $this->parseDate($data->start_date);
        $result["end"] = $this->parseDate($data->end_date);
        $result["fund"] = $data->fund;
        $result["city"] = $data->city;

        $id = $data->id_country;

        $sql = 'SELECT * FROM countries WHERE id_country = :id_country';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_country' => $id,
            )
        );

        $data = $query->fetchObject();

        $result["country"] = $data->name;

        return $result;
    }

    public function getParticipantTeams($tournament_name) {
        $sql = 'SELECT * FROM tournaments WHERE name = :name';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':name' => $tournament_name,
            )
        );

        $data = $query->fetchObject();
        $id = $data->id_tournament;

        $sql = 'SELECT teams.name FROM participants 
                INNER JOIN teams ON participants.id_team = teams.id_team
                WHERE participants.id_tournament = :id_tournament';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_tournament' => $id,
            )
        );

        $data = $query->fetchAll();

        $result = $data;

        return $result;
    }

    public function getMatchesInfo($tournament_name) {
        $sql = 'SELECT * FROM tournaments WHERE name = :name';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':name' => $tournament_name,
            )
        );

        $data = $query->fetchObject();
        $id = $data->id_tournament;

        $sql = 'SELECT * FROM matches WHERE id_tournament = :id_tournament';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_tournament' => $id,
            )
        );

        $data = $query->fetchAll();

        $count = count($data);

        for($i = 0; $i<$count; $i++) {
            $result[$i]["id"] = $data[$i]["id_match"];
            $result[$i]["score1"] = $data[$i]["first_score"];
            $result[$i]["score2"] = $data[$i]["second_score"];
            $result[$i]["format"] = $data[$i]["format"];
            $result[$i]["ladder"] = $data[$i]["ladder"];
            $result[$i]["state"] = $data[$i]["state"];

            $sql = 'SELECT * FROM teams WHERE id_team = :id_team';

            $query = $this->conn->prepare($sql);
            $query->execute(
                array(
                    ':id_team' => $data[$i]["first_team"],
                )
            );

            $obj = $query->fetchObject();

            $result[$i]["team1"] = $obj->name;

            $sql = 'SELECT * FROM teams WHERE id_team = :id_team';

            $query = $this->conn->prepare($sql);
            $query->execute(
                array(
                    ':id_team' => $data[$i]["second_team"],
                )
            );

            $obj = $query->fetchObject();

            $result[$i]["team2"] = $obj->name;

        }

        return $result;
    }

    public function getMatch($id_match) {

        $sql = 'SELECT * FROM matches WHERE id_match = :id_match';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_match' => $id_match,
            )
        );

        $data = $query->fetchObject();

        $result["score1"] = $data->first_score;
        $result["score2"] = $data->second_score;
        $result["format"] = $data->format;
        $result["ladder"] = $data->ladder;
        $result["state"] = $data->state;

        $sql = 'SELECT * FROM teams WHERE id_team = :id_team';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_team' => $data->first_team,
            )
        );

        $obj = $query->fetchObject();

        $result["team1"] = $obj->name;
        $result["full_winrate1"] = $obj->full_winrate;
        $result["local_winrate1"] = $obj->local_winrate;
        $result["winstreak1"] = $obj->local_winrate;
        $result["current_position1"] = $obj->current_position;

        $country = $obj->id_country;

        $sql = 'SELECT * FROM countries WHERE id_country = :id_country';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_country' => $country,
            )
        );

        $obj = $query->fetchObject();

        $result["country1"] = $obj->name;

        $sql = 'SELECT * FROM teams WHERE id_team = :id_team';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_team' => $data->second_team,
            )
        );

        $obj = $query->fetchObject();

        $result["team2"] = $obj->name;
        $result["full_winrate2"] = $obj->full_winrate;
        $result["local_winrate2"] = $obj->local_winrate;
        $result["winstreak2"] = $obj->local_winrate;
        $result["current_position2"] = $obj->current_position;

        $country = $obj->id_country;

        $sql = 'SELECT * FROM countries WHERE id_country = :id_country';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_country' => $country,
            )
        );

        $obj = $query->fetchObject();

        $result["country2"] = $obj->name;

        return $result;
    }

    public function getTeamList() {
        $sql = 'SELECT * FROM teams';

        $query = $this->conn->prepare($sql);
        $query->execute();



        $data = $query->fetchAll();

        $count = count($data);
        for ($i = 0; $i<$count; $i++) {

            $result[$i]["name"] = $data[$i]["name"];
            $result[$i]["position"] = $data[$i]["current_position"];
            $result[$i]["diff"] = $data[$i]["current_position"] - $data[$i]["last_position"];

            $sql = 'SELECT * FROM countries WHERE id_country = :id_country';

            $query = $this->conn->prepare($sql);
            $query->execute(
                array(
                    ':id_country' => $data[$i]["id_country"],
                )
            );

            $obj = $query->fetchObject();

            $result[$i]["country"] = $obj->name;
        }

        return $result;
    }

    public function getTeam($name) {
        $sql = 'SELECT * FROM teams WHERE name = :name';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':name' => $name,
            )
        );

        $data = $query->fetchObject();

        $id = $data->id_team;

        $result["name"] = $data->name;
        $result["full_winrate"] = $data->full_winrate;
        $result["local_winrate"] = $data->local_winrate;
        $result["winstreak"] = $data->winstreak;
        $result["current_position"] = $data->current_position;
        $result["last_position"] = $data->last_position;

        $country = $data->id_country;

        $sql = 'SELECT * FROM countries WHERE id_country = :id_country';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_country' => $country,
            )
        );

        $data = $query->fetchObject();

        $result["country"] = $data->name;

        $sql = 'SELECT * FROM drafts WHERE id_team = :id_team';

        $query = $this->conn->prepare($sql);
        $query->execute(
            array(
                ':id_team' => $id,
            )
        );

        $data = $query->fetchAll();

        $count = count($data);

        for($i = 0; $i<$count; $i++) {

            $sql = 'SELECT * FROM players WHERE id_player = :id_player';

            $query = $this->conn->prepare($sql);
            $query->execute(
                array(
                    ':id_player' => $data[$i]["id_player"],
                )
            );

            $result["players"][$i] = $query->fetchObject();

        }

        return $result;
    }
}
