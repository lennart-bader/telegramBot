<?php
    class Spiegel {
        public function getLastTopics($num = 10) {
            if( !$xml = simplexml_load_file('http://www.spiegel.de/schlagzeilen/tops/index.rss') ) {
                return false;
            }
             
            $out = array();
             
            $i = $num;
             
            if( !isset($xml->channel[0]->item) ) {
                return false;
            }
             
            foreach($xml->channel[0]->item as $item) {
                if( $i-- == 0 ) {
                    break;
                }
             
                $out[] = array(
                    'title'        => (string) $item->title,
                    'description'  => (string) $item->description,
                    'link'         => (string) $item->guid,
                    'date'         => date('d.m.Y H:i', strtotime((string) $item->pubDate))
                );
            }
            
            return $out;
        }
        
        public function search($search, $matchall = true) {
            $articles = $this->getLastTopics(-1);
            if ($out === false) {
                return false;
            }
            
            // TODO: Add $matchall = false
            
            $items = array();
            foreach ($articles as $item) {
                $add = true;
                foreach ($search as $s) {
                    if (strpos(strtolower($item["title"]), strtolower($s)) === false && strpos(strtolower($item["description"]), strtolower($s)) === false) {
                        $add = false;
                        break;
                    }
                }
                
                if ($add) {
                    $items[] = $item;
                }                
            }            
            
            return $items;
        }
    }
?>