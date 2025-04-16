<?php
require_once 'AttackPokemon.php';

class Pokemon {
    private $nom;
    private $url;
    private $hp;
    private $attackPokemon;
    
    public function __construct($nom, $url, $hp, AttackPokemon $attackPokemon) {
        $this->nom = $nom;
        $this->url = $url;
        $this->hp = $hp;
        $this->attackPokemon = $attackPokemon; 
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function getUrl() {
        return $this->url;
    }
    
    public function getHp() {
        return $this->hp;
    }
    
    public function getAttackPokemon() {
        return $this->attackPokemon;
    }
    
    public function setHp($hp) {
        $this->hp = $hp;
    }
    
    public function isDead() {
        return $this->hp <= 0;
    }     
    
    public function attack(Pokemon $other) {
        $damage = rand($this->attackPokemon->getAttackMinimal(), $this->attackPokemon->getAttackMaximal());
        if (rand(1, 100) <= $this->attackPokemon->getProbabilitySpecialAttack()) {
            $damage *= $this->attackPokemon->getSpecialAttack();
        }
        //$other->setHp($other->getHp() - $damage);
        return $damage;
    }
    
    public function whoAmI() {
        echo "Name: {$this->nom}, HP: {$this->hp}, URL: {$this->url}\n";
    }
}
?>