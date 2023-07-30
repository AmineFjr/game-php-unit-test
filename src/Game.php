<?php
require 'Player.php';
require 'Orientation.php';

/**
 * @author Amine Fajry <fajry39@gmail.com>
 */
class Game
{
    public array $position_memory_player;
    private string $orientation;
    private int $nbOfStep;
    private string $playerName;
    public bool $moved = false;
    public array $players = [];
    public int $distanceBetweenPlayers = 0;
    public string $playerWon = '';

    public function __construct()
    {
        self::start();
    }

    /**
     * @return array
     */
    public function grille(): array
    {
        // Taille de la grille
        $taille = 10;
        // Boucle pour générer les lignes
        for ($i = 1; $i <= $taille; $i++) {
            // Boucle pour générer les colonnes
            for ($j = 1; $j <= $taille; $j++) {
                $tableau[$i][$j] = " . ";
            }
        }
        return $tableau;
    }

    public function start()
    {
        $tableau = self::grille();
        $taille = 10;
        $tableau[1][1] = 'P1-P2';
        $this->position_memory_player = $tableau;

        for ($i = 1; $i <= $taille; $i++) {
            // Boucle pour générer les colonnes
            for ($j = 1; $j <= $taille; $j++) {
                echo $tableau[$i][$j];
            }
            echo "\n";
        }
    }

    /**
     * this function know which player won the game
     */
    private function playerWon()
    {
        $taille = 10;
        $playerExisted = [];
        for ($i = 1; $i <= $taille; $i++) {
            for ($j = 1; $j <= $taille; $j++) {
                if ($this->position_memory_player[$i][$j] != 'P1-P2' && $this->position_memory_player[$i][$j] != ' . ') {
                    $playerExisted[] = $this->position_memory_player[$i][$j];
                }
            }
        }
        if (count($playerExisted) == 1) {
            $this->playerWon = $playerExisted[0] . ' won the game';
            echo $this->playerWon;
            if (!defined('PHPUnit_RUNNER_IN_PHAR')) exit;
        }
    }

    /**
     * this function reformat the grid after each player action
     * @param string $element
     * @param int $rowIndex
     * @param int $columnIndex
     */
    private function reformatGrille(string $element, int $rowIndex, int $columnIndex)
    {
        if (!$this->moved) {
            $this->position_memory_player[$rowIndex][$columnIndex] = $element;
        } else {
            if ($element == str_contains($element, $this->playerName)) {
                if ($element == str_contains($element, "-")) {
                    if (str_contains($element, "P1") && $this->playerName == "P1") {
                        $this->position_memory_player[$rowIndex][$columnIndex] = "P2";
                    } else {
                        $this->position_memory_player[$rowIndex][$columnIndex] = "P1";
                    }
                } else {
                    $this->position_memory_player[$rowIndex][$columnIndex] = " . ";
                }
            }
        }
    }

    /**
     * this function track error
     */
    private function trackError()
    {
        if ($this->playerName !== "P1" && $this->playerName !== "P2") {
            exit('Player name must be P1 or P2');
        }

        if ($this->orientation != "DROITE" && $this->orientation != "GAUCHE" && $this->orientation != "AVANCER") {
            exit("Orientation must be DROITE, GAUCHE or AVANCER");
        }

        if ($this->nbOfStep >= 3 || $this->nbOfStep < 0) {
            exit("Number of steps must be between 0 and 3");
        }
    }

    /**
     * this function search the number of cases between players
     * @param int $rowIndex
     * @param int $columnIndex
     * @param string $playerName
     * @return int
     */
    public function nbCasesBetweenPlayers(int $rowIndex, int $columnIndex, string $playerName)
    {
        ($playerName === "P1") ? $playerToSearch = "P2" : $playerToSearch = "P1";
        //serch on column
        for ($i = 1; $i <= 10; $i++) {
            if ($this->position_memory_player[$rowIndex][$i] == $playerToSearch) {
                $this->distanceBetweenPlayers = $i - $rowIndex;
            }
        }

        //serch on row
        for ($i = 1; $i <= 10; $i++) {
            if ($this->position_memory_player[$i][$columnIndex] == $playerToSearch) {
                $this->distanceBetweenPlayers = $i - $columnIndex;
            }
        }
        return $this->distanceBetweenPlayers;
    }

    /**
     * this function move the player
     * @param string $player
     * @param string $orientation
     * @param int $nbOfSteps
     * @return array|string
     */
    public function deplacement(string $player, string $orientation, int $nbOfSteps = 0): array | string
    {
        $this->playerName = $player;
        $this->orientation = $orientation;
        $this->nbOfStep = $nbOfSteps;
        $this->moved = false;
        $this->players[] = $player;

        self::trackError();

        if ($nbOfSteps != 0) {
            foreach ($this->position_memory_player as $rowIndex => $row) {
                foreach ($row as $columnIndex => $element) {
                    if ($element == str_contains($element, $this->playerName) && strtoupper($orientation) == Orientation::AVANCER->get()) {
                        if ($rowIndex + $nbOfSteps <= 10 || $rowIndex + $nbOfSteps >= 10) {
                            $this->position_memory_player[$rowIndex + $nbOfSteps][$columnIndex] = $this->playerName;
                            $this->moved = true;
                            self::nbCasesBetweenPlayers($rowIndex + $nbOfSteps, $columnIndex, $this->playerName);
                        }
                    }

                    if ($element == str_contains($element, $this->playerName) && strtoupper($orientation) == Orientation::GAUCHE->get()) {
                        if ($columnIndex - $nbOfSteps > 0) {
                            echo $columnIndex - $nbOfSteps;
                            $this->position_memory_player[$rowIndex][$columnIndex - $nbOfSteps] = $this->playerName;
                            $this->moved = true;
                            self::nbCasesBetweenPlayers($rowIndex, $columnIndex - $nbOfSteps, $this->playerName);
                        }
                    }

                    if ($element == str_contains($element, $this->playerName) && strtoupper($orientation) == Orientation::DROITE->get()) {
                        if ($columnIndex + $nbOfSteps <= 10 || $columnIndex + $nbOfSteps >= 10) {
                            $this->position_memory_player[$rowIndex][$columnIndex + $nbOfSteps] = $this->playerName;
                            $this->moved = true;
                            self::nbCasesBetweenPlayers($rowIndex, $columnIndex + $nbOfSteps, $this->playerName);
                        }
                    }
                    self::reformatGrille($element, $rowIndex, $columnIndex);
                }
            }
        }
        self::show();
        self::playerWon();
        return $this->position_memory_player;
    }

    /**
     * this function show the grid on the terminal
     */
    private function show()
    {
        sleep(1);
        echo '-------------------------------------' . "\n";
        echo $this->playerName . ' ACTION : ' . $this->orientation . ' - ' . $this->nbOfStep . ' STEPS' . "\n";
        echo '-------------------------------------' . "\n";

        $taille = 10;
        for ($i = 1; $i <= $taille; $i++) {
            // Boucle pour générer les colonnes
            for ($j = 1; $j <= $taille; $j++) {
                echo $this->position_memory_player[$i][$j];
            }
            echo "\n";
        }
    }
}
