<?php
class WikipediaParser {
	
	public function __construct() {
		global $t;
		$t->setPlugin("wikipedia");
	}

	public function getByTitle($title, $lang = "de") {
		global $t;
		$article = json_decode(file_get_contents("https://" . $lang .  ".wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles=".urlencode($title)), true);
		
		file_put_contents("log/wiki.log", json_encode($article));
		
		
		$res = reset($article["query"]["pages"]);
		
		$title = $res["title"];
		$extr = $res["extract"];
		
		if ($extr == "") {
			return $t->g("404");
		}
		
		$text = array();
		$text[] = "*".$title."*";
		$text[] = $extr;
		$text[] = "";
		$text[] = "*" . $t->g("full_article") . ":*";
		$text[] = "https://" . $lang . ".wikipedia.org/?curid=" . $res["pageid"];
		
		return implode("\n", $text);
	}

	public function search($search, $lang = "de") {
		global $t;
		$url = "https://".$lang.".wikipedia.org/w/api.php?action=query&format=json&generator=search&gsrsearch=" . urlencode($search);
		
		$res = json_decode(file_get_contents($url), true);
		
		$results = $res["query"];
		
		if (is_array($results)) {
			$text = array();
			$text[] = "*" . $t->g("results") ."*";
			$pages = $results["pages"];
			foreach ($pages as $page) {
				$title = $page["title"];
				$id = $page["pageid"];
				$text[] = "";
				$text[] = $title;
				$text[] = "/wikip_" . $id;
			}
		} else {
			return $t->g("404");
		}
		
		return implode("\n", $text);
	}
	
	public function page($pid, $lang = "de") {
		global $t;
		$url = "https://" . $lang .  ".wikipedia.org/w/api.php?format=json&".
				"action=query&prop=extracts&exintro=&explaintext=&pageids=" . urlencode($pid);
		$res = json_decode(file_get_contents($url), true);
		
		if (is_array($res["query"]["pages"])) {
			$page = array_pop($res["query"]["pages"]);
			$title = $page["title"];
			$extr = $page["extract"];
			
			$text = array();
			$text[] = "*".$title."*";
			$text[] = $extr;
			$text[] = "";
			$text[] = "*" . $t->g("full_article") . ":*";
			$text[] = "https://" . $lang . ".wikipedia.org/?curid=" . $pid;
			return implode("\n", $text);
		} else {
			return $t->g("404");
		}
	}
}
?>
