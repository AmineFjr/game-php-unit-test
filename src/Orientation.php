<?php

enum Orientation {
    case AVANCER;
    case GAUCHE;
    case DROITE;

    public function get(): string
    {
        return match($this) {
            self::AVANCER => "AVANCER",
            self::GAUCHE =>  "GAUCHE",
            self::DROITE => "DROITE"
        };
    }
}
