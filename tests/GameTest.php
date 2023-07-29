<?php
require "./src/Game.php";

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function test_that_grid_is_10_by_10()
    {
        $game = new Game();
        $this->assertEquals(10, count($game->grille()));
    }

    public function test_that_gamers_play_one_by_one()
    {
        $game = new Game();
        $game->deplacement("P1", "AVANCER", 2);
        $game->deplacement("P2", "DROITE", 2);
        $seeIfPlayerPlayOneByOne = $game->players;
        $this->assertIsArray($seeIfPlayerPlayOneByOne);
        $this->assertEquals("P1", $seeIfPlayerPlayOneByOne[0]);
        $this->assertEquals("P2", $seeIfPlayerPlayOneByOne[1]);
    }

    public function test_that_gamer_can_do_action() 
    {
        $game = new Game();
        $game->deplacement("P1", "AVANCER", 2);
        $this->assertIsArray($game->deplacement("P1", "AVANCER", 2));
    }

    public function test_that_gamer_can_not_go_outside_grid() 
    {
        $game = new Game();
        $game->deplacement("P1", "GAUCHE", 2);
        //if false then it means that the player 
        //will not move because his action will be outside the grid
        $movedOutsideGrid = $game->moved; 
        $this->assertFalse($movedOutsideGrid);
    }
    
}
