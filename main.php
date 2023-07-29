<?php
require 'Game.php';

$game = new Game();

$game->deplacement("P1", "AVANCER", 2);

$game->deplacement("P2", "DROITE", 2);

$game->deplacement("P1", "GAUCHE", 1);

$game->deplacement("P2", "DROITE", 1);

$game->deplacement("P1", "DROITE", 2);

$game->deplacement("P2", "DROITE", 2);

$game->deplacement("P1", "AVANCER", 2);

$game->deplacement("P2", "DROITE", 2);