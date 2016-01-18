<?php
include("plugins/imdb/api/tmdb-api.php");

class Imdb {
    private $tmdb;

    public function __construct() {
        // Check if DB table exists
        global $db;
        $query = "SHOW TABLES LIKE `p_imdb_table`";
        $db->query($query);
        if ($db->numRows() == 0) {
            // Table does not exist
            $this->setupDb();
        }
        $this->tmdb = new TMDB(TMDB_API_KEY, LANGUAGE);
    }
    
    public function execute($message) {
        global $api;
        global $t;
        $t->setPlugin("imdb");
        $cmd = explode("_", $message->getCommand());
        if (sizeof($cmd) == 1) {
            $cmd[] = "multi";
        }
        if (sizeof($cmd) >= 2) {
            switch ($cmd[1]) {
                case "multi":
                    $data = $message->getData();
                    $text = implode(" ", $data);
                    $res = $this->tmdb->searchMulti($text);

                    if (sizeof($res["all"]) == 0) {
                        $api->sendMessage($message->chat->id, $t->g("notfound"));
                    } else {
                        $texts = array();
                        foreach ($res["all"] as $r) {
                            $class = get_class($r);
                            switch ($class) {
                                case "Movie":
                                    $texts[] = $this->shortMovie($r);
                                    break;
                                case "TVShow":
                                    $texts[] = $this->shortTvShow($r);
                                    break;
                                case "Person":
                                    $texts[] = $this->shortPerson($r);
                                    break;
                            }
                        }

                        $texts[] = "";
                        $texts[] = TMDB_USE_TEXT;
                        $api->sendMessage($message->chat->id, implode("\n\n", $texts), "Markdown", true);
                    }
                    break;
                case "m":
                    $data = $message->getData();
                    $text = implode(" ", $data);
                    $movies = $this->tmdb->searchMovie($text);

                    if (sizeof($movies) == 0) {
                        $api->sendMessage($message->chat->id, $t->g("notfound"));
                    } else {
                        $texts = array();
                        foreach ($movies as $m) {
                            $texts[] = $this->shortMovie($m);
                        }

                        $texts[] = "";
                        $texts[] = TMDB_USE_TEXT;
                        $api->sendMessage($message->chat->id, implode("\n\n", $texts), "Markdown", true);
                    }
                    break;
                case "s":
                    $data = $message->getData();
                    $text = implode(" ", $data);
                    $series = $this->tmdb->searchTvShow($text);

                    if (sizeof($series) == 0) {
                        $api->sendMessage($message->chat->id, $t->g("notfound"));
                    } else {
                        $texts = array();
                        foreach ($series as $s) {
                            $texts[] = $this->shortTvShow($s);
                        }
                        $texts[] = TMDB_USE_TEXT;
                        $api->sendMessage($message->chat->id, implode("\n\n", $texts), "Markdown", true);
                    }                    
                    break;
                case "p":
                    $data = $message->getData();
                    $text = implode(" ", $data);
                    $persons = $this->tmdb->searchPerson($text);

                    if (sizeof($persons) == 0) {
                        $api->sendMessage($message->chat->id, $t->g("notfound"));
                    } else {
                        $texts = array();
                        foreach ($persons as $p) {
                            $texts[] = $this->shortPerson($p);
                        }
                        $texts[] = TMDB_USE_TEXT;
                        $api->sendMessage($message->chat->id, implode("\n\n", $texts), "Markdown", true);
                    }                    
                    break;
                case "dm":
                    $movie = $this->tmdb->getMovie($cmd[2]);
                    $text  = $this->movieDetail($movie);
                    $img   = $this->tmdb->getImageURL() . $movie->getPoster();
                    if ($img != $this->tmdb->getImageURL()) {
                        $api->sendPhoto($message->chat->id, $img);
                    }
                    $api->sendMessage($message->chat->id, $text, "Markdown", true);
                    break;
                case "ds":
                    $show  = $this->tmdb->getTvShow($cmd[2]);
                    $text  = $this->tvShowDetail($show);
                    $img   = $this->tmdb->getImageURL() . $show->getPoster();
                    if ($img != $this->tmdb->getImageURL()) {
                        $api->sendPhoto($message->chat->id, $img);
                    }
                    $api->sendMessage($message->chat->id, $text, "Markdown", true);
                    break;
                case "dp":
                    $person = $this->tmdb->getPerson($cmd[2]);
                    $text   = $this->personDetail($person);
                    $img    = $this->tmdb->getImageURL() . $person->getProfile();
                    if ($img != $this->tmdb->getImageURL()) {
                        $api->sendPhoto($message->chat->id, $img);
                    }
                    $api->sendMessage($message->chat->id, $text, "Markdown", true);
                    break;
                case "season":
                    $season = $this->tmdb->getSeason($cmd[2], $cmd[3]);
                    $text   = $this->seasonDetail($season);
                    $img    = $this->tmdb->getImageURL() . $season->getPoster();
                    if ($img != $this->tmdb->getImageURL()) {
                        $api->sendPhoto($message->chat->id, $img);
                    }
                    $api->sendMessage($message->chat->id, $text, "Markdown", true);
                    break;
                case "episode":
                    $episode = $this->tmdb->getEpisode($cmd[2], $cmd[3], $cmd[4]);
                    $text    = $this->episodeDetail($episode);
                    $img    = $this->tmdb->getImageURL() . $episode->getStill();
                    if ($img != $this->tmdb->getImageURL()) {
                        $api->sendPhoto($message->chat->id, $img);
                    }
                    $api->sendMessage($message->chat->id, $text, "Markdown", true);
                    break;
                case "add":
                    break;
                case "rm":
                    break;
                case "list":
                    break;
                case "later":
                    break;
                case "watched":
                    break;
                case "never":
                    break;
                default:
                    $api->sendMessage($message->chat->id, $t->g("default"), "Markdown");
                    break;                
            }
        } else {
            $api->sendMessage($message->chat->id, $t->g("default"), "Markdown");
        }
    }    

    private function shortMovie($movie) {
        global $t;
        $text   = array();
        $data   = json_decode($movie->getJSON(), true);
        $text[] = '*' . $movie->getTitle() . "* (" . $t->g("movie") . ")";
        $text[] = $data["release_date"] . ", " . $data["vote_average"] . " / 10";
        $text[] = "/imdb\\_dm\\_" . $data["id"];
        return implode("\n", $text);
    }    

    private function shortTvShow($show) {
        global $t;
        $text   = array();
        $data   = json_decode($show->getJSON(), true);
        $text[] = '*' . $data["name"] . "* (" . $t->g("tvshow") . ")";
        $text[] = $data["first_air_date"] . ", " . $data["vote_average"] . " / 10";
        $text[] = "/imdb\\_ds\\_" . $data["id"];
        return implode("\n", $text);
    }   

    private function shortPerson($person) {
        global $t;
        $text   = array();
        $data   = json_decode($person->getJSON(), true);
        $text[] = '*' . $person->getName() . "* (" . $t->g("person") . ")";
        $text[] = "/imdb\\_dp\\_" . $data["id"];
        return implode("\n", $text);
    }

    private function movieDetail($movie) {
        global $t;
        $data  = json_decode($movie->getJSON(), true);
        $text   = array();
        $text[] = '*' . $data["title"] . "* (" . $t->g("movie") . ")";
        $text[] = $data["overview"];
        $text[] = $data["release_date"] . ", " . $data["vote_average"] . " / 10";
        $text[] = "/imdb\\_add\\_" . $data["id"];
        $text[] = "";
        $text[] = TMDB_USE_TEXT;
        return implode("\n", $text);
    }

    private function tvShowDetail($show) {
        global $t;
        $data  = json_decode($show->getJSON(), true);
        $text   = array();
        $text[] = '*' . $data["name"] . "* (" . $t->g("tvshow") . ")";
        $text[] = $data["overview"];
        $text[] = $data["first_air_date"] . ", *" . $data["vote_average"] . " / 10*";
        $text[] = sprintf($t->g("numseasons"), $show->getNumSeasons());

        $seasons = $show->getSeasons();
        foreach ($seasons as $season) {
            $season->reload($this->tmdb);
            $text[] = "- " . $t->g("season") . " " . $season->getSeasonNumber() . "  /imdb\\_season\\_" .$show->getID(). "\\_".$season->getSeasonNumber();
        }

        $text[] = "/imdb\\_add\\_" . $data["id"];
        $text[] = "";
        $text[] = TMDB_USE_TEXT;
        return implode("\n", $text);
    }

    private function personDetail($person) {
        global $t;
        $roles = $person->getMovieRoles();
        $rtext = array();
        foreach ($roles as $role) {
            $rtext[] = "- *" . $role->getCharacter() . "* in *" . $role->getMovieTitle() . "*";
            $rtext[] = "  /imdb\\_dm\\_".$role->getMovieID();
        }

        $data  = json_decode($person->getJSON(), true);
        $text   = array();
        $text[] = '*' . $person->getName() . "* (" . $t->g("person") . ")";
        $text[] = $t->g("birthday").": ".$person->getBirthday();


        $roles = $person->getMovieRoles();
        if (sizeof($roles) > 0) {
            $text[] = "*" . $t->g("movieroles")."*: ";
            foreach ($roles as $role) {
                $text[] = "- *" . $role->getCharacter() . "* in *" . $role->getMovieTitle() . "*";
                $text[] = "  /imdb\\_dm\\_".$role->getMovieID();
            }
            $text[] = "";
        }
        
        $roles = $person->getTVShowRoles();

        if (sizeof($roles) > 0) {
            $text[] = "*" . $t->g("tvroles")."*: ";
            foreach ($roles as $role) {
                $text[] = "- *" . $role->getCharacter() . "* in *" . $role->getTVShowName() . "*";
                $text[] = "  /imdb\\_ds\\_".$role->getTVShowID();
            }
        }
        

        $text[] = "";
        $text[] = TMDB_USE_TEXT;
        return implode("\n", $text);
    }

    private function seasonDetail($season) {
        global $t;
        $season->reload($this->tmdb);
        $text[] = '*' . $season->getName() . "* (" . $t->g("season") . ")";
        $text[] = "*" . $t->g("numepisodes") . "*: " . $season->getNumEpisodes();
        $text[] = "*" . $t->g("airdate") . "*: " . $season->getAirDate();
        $text[] = "*" . $t->g("episodes") . "*:";
        $episodes = $season->getEpisodes();
        foreach ($episodes as $e) {
            $text[] = "- " . $e->getName() . "  /imdb\\_episode\\_" . $season->getTVShowID() ."\\_" . $season->getSeasonNumber() . "\\_" . $e->getEpisodeNumber();
        }
        $text[] = "*" . $t->g("back2series") . "*  /imdb\\_ds\\_".$season->getTVShowID();
        $text[] = "";
        $text[] = TMDB_USE_TEXT;
        return implode("\n", $text);
    }

    private function episodeDetail($episode) {
        global $t;
        $text[] = "*" . $episode->getName() . "* (" . $t->g("episode") . ")";
        $text[] = $episode->getOverview();
        $text[] = "*" . $t->g("airdate") . "*: " . $episode->getAirDate();
        $text[] = "*" . $t->g("back2season") . "*  /imdb\\_season\\_".$episode->getTVShowID() . "\\_".$episode->getSeasonNumber();
        $text[] = "";
        $text[] = TMDB_USE_TEXT;
        return implode("\n", $text);

    }
    
    private function setupDb() {
        global $db;
        $query = "
                CREATE TABLE `p_imdb` ( 
                `id` BIGINT NOT NULL AUTO_INCREMENT , 
                `userid` INT NOT NULL , 
                `imdbid` INT NOT NULL , 
                `status` INT NOT NULL , 
                `json` LONGTEXT NOT NULL , 
                `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`));
        ";
        $db->query($query);
    }
}
?>