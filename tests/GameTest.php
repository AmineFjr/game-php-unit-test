<?php
require "./src/Game.php";
define('PHPUnit_RUNNER_IN_PHAR', 1);

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * test that grid is 10 by 10 
     * @author Amine
     */
    public function test_that_grid_is_10_by_10()
    {
        $game = new Game();
        $this->assertEquals(10, count($game->grille()));
    }

    /**
     * test that player play one by one 
     */
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

    /**
     * test that player can move 
     */
    public function test_that_gamer_can_do_action()
    {
        $game = new Game();
        $game->deplacement("P1", "AVANCER", 2);
        $this->assertIsArray($game->deplacement("P1", "AVANCER", 2));
    }

    /**
     * test gamer will not move if he is not on the grid
     */
    public function test_that_gamer_can_not_go_outside_grid()
    {
        $game = new Game();
        $game->deplacement("P1", "GAUCHE", 2);
        //if false then it means that the player 
        //will not move because his action will be outside the grid
        $movedOutsideGrid = $game->moved;
        $this->assertFalse($movedOutsideGrid);
    }

    /**
     * test to see if an opponent player is on the vision row or column
     */
    public function test_search_if_player_exist_on_column_or_row()
    {
        $game = new Game();
        $game->deplacement("P1", "AVANCER", 2);
        $game->deplacement("P2", "AVANCER", 1);

        $this->assertEquals(2, $game->distanceBetweenPlayers);
    }

    /**
     * test to see which player won the game
     */
    public function test_player_won_the_game()
    {
        $game = new Game();
        $game->deplacement("P1", "AVANCER", 2);
        $game->deplacement("P2", "AVANCER", 2);

        $this->assertEquals("P2 won the game", $game->playerWon);
    }
}
