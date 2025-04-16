<?php

require_once 'Pokemon.php';

class PokemonFeu extends Pokemon {
    public function attack(Pokemon $other) {
        $damage = parent::attack($other);
        if ($other instanceof PokemonPlante) {
            $damage *= 2;
        } elseif ($other instanceof PokemonEau || $other instanceof PokemonFeu) {
            $damage *= 0.5;
        }
        $other->setHp($other->getHp() - $damage);
        return $damage;
    }
}

class PokemonEau extends Pokemon {
    public function attack(Pokemon $other) {
        $damage = parent::attack($other);
        if ($other instanceof PokemonFeu) {
            $damage *= 2;
        } elseif ($other instanceof PokemonEau || $other instanceof PokemonPlante) {
            $damage *= 0.5;
        }
        $other->setHp($other->getHp() - $damage);
        return $damage;
    }
}

class PokemonPlante extends Pokemon {
    public function attack(Pokemon $other) {
        $damage = parent::attack($other);
        if ($other instanceof PokemonEau) {
            $damage *= 2;
        } elseif ($other instanceof PokemonPlante || $other instanceof PokemonFeu) {
            $damage *= 0.5;
        }
        $other->setHp($other->getHp() - $damage);
        return $damage;
    }
}
?>