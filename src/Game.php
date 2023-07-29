<?php
require 'Player.php';
require 'Orientation.php';

class Game
{
    public array $position_memory_player;
    private string $orientation;
    private int $nbOfStep;
    private string $playerName;
    public bool $moved = false;
    public array $players = [];
    public int $nbCaseBetweenPlayers = 0;

    public function __construct()
    {
        self::start();
    }

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

    private function playerWon(string $element, int $rowIndex, int $columnIndex)
    {
        if ($element == "P1" && $this->playerName == "P2" && strtoupper($this->orientation) == Orientation::AVANCER->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P2P1";
            exit("P2P1 AVANCER GAME OVER P2 WON . \n");
        }

        if ($element == "P2" && $this->playerName == "P1" && strtoupper($this->orientation) == Orientation::AVANCER->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P1P2";
            exit("P1P2 AVANCER GAME OVER P1 WON . \n");
        }

        if ($element == "P1" && $this->playerName == "P2" && strtoupper($this->orientation) == Orientation::GAUCHE->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P1P2";
            exit("P2P1 GAUCHE GAME OVER P1 WON . \n");
        }

        if ($element == "P2" && $this->playerName == "P1" && strtoupper($this->orientation) == Orientation::GAUCHE->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P2P1";
            exit("P1P2 GAUCHE GAME OVER P2 WON . \n");
        }

        if ($element == "P1" && $this->playerName == "P2" && strtoupper($this->orientation) == Orientation::DROITE->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P2P1";
            exit("P2P1 DROITE GAME OVER P2 WON . \n");
        }

        if ($element == "P2" && $this->playerName == "P1" && strtoupper($this->orientation) == Orientation::DROITE->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P1P2";
            exit("P1P2 DROITE GAME OVER P1 WON . \n");
        }
    }

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

    public function nbCases(string $element, int $rowIndex, int $columnIndex)
    {
        if ($element == "P1" && $this->playerName == "P2" && strtoupper($this->orientation) == Orientation::AVANCER->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P2P1";
        }

        if ($element == "P2" && $this->playerName == "P1" && strtoupper($this->orientation) == Orientation::AVANCER->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P1P2";
        }

        if ($element == "P1" && $this->playerName == "P2" && strtoupper($this->orientation) == Orientation::GAUCHE->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P1P2";
        }

        if ($element == "P2" && $this->playerName == "P1" && strtoupper($this->orientation) == Orientation::GAUCHE->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P2P1";
        }

        if ($element == "P1" && $this->playerName == "P2" && strtoupper($this->orientation) == Orientation::DROITE->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P2P1";
        }

        if ($element == "P2" && $this->playerName == "P1" && strtoupper($this->orientation) == Orientation::DROITE->get()) {
            $this->position_memory_player[$rowIndex][$columnIndex] = "P1P2";
        }
    }

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
                        }
                    }

                    if ($element == str_contains($element, $this->playerName) && strtoupper($orientation) == Orientation::GAUCHE->get()) {
                        if ($columnIndex - $nbOfSteps > 0) {
                            echo $columnIndex - $nbOfSteps;
                            $this->position_memory_player[$rowIndex][$columnIndex - $nbOfSteps] = $this->playerName;
                            $this->moved = true;
                        }
                    }

                    if ($element == str_contains($element, $this->playerName) && strtoupper($orientation) == Orientation::DROITE->get()) {
                        if ($columnIndex + $nbOfSteps <= 10 || $columnIndex + $nbOfSteps >= 10) {
                            $this->position_memory_player[$rowIndex][$columnIndex + $nbOfSteps] = $this->playerName;
                            $this->moved = true;
                        }
                    }
                    self::reformatGrille($element, $rowIndex, $columnIndex);
                }
            }
        }
        self::show();
        return $this->position_memory_player;
    }

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
