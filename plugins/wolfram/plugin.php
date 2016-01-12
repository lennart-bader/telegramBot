<?php

	require_once("WolframAlphaEngine.php");

	
    class Wolfram {
        public function __construct() {
        
        }
    
        public function execute($message) {
            $cmd = strtolower($message->getCommand());
			$data = $message->getData();
			
			$params = array("format" => "plaintext");
			
			$wa = new WolframAlphaEngine(WOLFRAM_API_KEY);
            $res = $wa->getResults(implode(" ", $data), $params);
			
			file_put_contents("log/wolfram.log", json_encode($res));
			
			$sol = array();
			
			if ($res->isError()) {
				Api::reply($message, "Da kann ich leider nichts mit anfangen...", false);
				return;
			}
			
			
			
			if (count($res->getPods()) > 0) {
				foreach ($res->getPods() as $pod) {
					if ($pod->attributes["id"] == "Solution") {
						$sol[] = "*Ergebnisse für " . implode(" ", $data) . "*:";
						foreach ($pod->getSubpods() as $solution) {
							$sol[] = api::encodePlain($solution->plaintext);
						}					
					} elseif ($pod->attributes["id"] == "ComplexSolution") {
						$sol[] = "*Komplexe Ergebnisse für " . implode(" ", $data) . "*:";
						foreach ($pod->getSubpods() as $solution) {
							$sol[] = api::encodePlain($solution->plaintext);
						}
					} elseif ($pod->attributes["id"] == "Result") {
						$sol[] = "*Ergebnis für " . implode(" ", $data) . "*:";
						foreach ($pod->getSubpods() as $solution) {
							$sol[] = api::encodePlain($solution->plaintext);
						}
					}
				}
			}
			
			if (sizeof($sol) == 0) {
				$sol[] = "Leider keine Ergebnisse :(";
			}
			            						
            Api::reply($message->chat, implode("\n", $sol), true);
        }
    }
?>
