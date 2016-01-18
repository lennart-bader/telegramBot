<?php
global $pluginManager;
global $t;
include("plugins/imdb/config.php");
$t->setPlugin("imdb");

$pluginManager->registerAlias("imdb", "imdb", "text");

$helps = $t->g("help");
$helps[] = "";
$helps[] = TMDB_USE_TEXT;

$pluginManager->addHelp("imdb", $helps);

?>