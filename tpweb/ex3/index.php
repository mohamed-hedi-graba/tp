<?php
require_once 'PokemonTypes.php';

$attack1 = new AttackPokemon(10, 20, 2, 50);
$attack2 = new AttackPokemon(15, 25, 1.5, 30);

$charizard = new PokemonFeu("Charizard", "", 100, $attack1);
$blastoise = new PokemonEau("Blastoise", "", 120, $attack2);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Combat Pokémon</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f4f6;
      margin: 0;
      padding: 20px;
    }

    .combat-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
      max-width: 800px;
      margin: auto;
    }

    .header, .winner {
      background-color: #e0f7fa;
      padding: 10px;
      text-align: center;
      font-weight: bold;
      border-radius: 6px;
    }

    .round {
      background-color: #ffcdd2;
      padding: 10px;
      border-radius: 6px;
    }

    .pokemon-row {
      display: flex;
      justify-content: space-between;
      background-color: #fff;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 6px;
    }

    .pokemon-card {
      width: 48%;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .stats {
      text-align: left;
      width: 100%;
    }

    .stats p {
      margin: 2px 0;
    }
  </style>
</head>
<body>
  <div class="combat-container">
    <div class="header">Les combattants</div>

    <div class="pokemon-row">
      <div class="pokemon-card">
        <div class="stats">
          <p><strong>Nom:</strong> <?= $charizard->getNom() ?></p>
          <p>Health Points: <?= $charizard->getHp() ?></p>
          <p>Max Attack: <?= $charizard->getAttackPokemon()->getAttackMaximal() ?></p>
          <p>Special Attack: <?= $charizard->getAttackPokemon()->getSpecialAttack() ?></p>
          <p>Probabilité Spéciale: <?= $charizard->getAttackPokemon()->getProbabilitySpecialAttack() ?>%</p>
        </div>
      </div>

      <div class="pokemon-card">
        <div class="stats">
          <p><strong>Nom:</strong> <?= $blastoise->getNom() ?></p>
          <p>Health Points: <?= $blastoise->getHp() ?></p>
          <p>Max Attack: <?= $blastoise->getAttackPokemon()->getAttackMaximal() ?></p>
          <p>Special Attack: <?= $blastoise->getAttackPokemon()->getSpecialAttack() ?></p>
          <p>Probabilité Spéciale: <?= $blastoise->getAttackPokemon()->getProbabilitySpecialAttack() ?>%</p>
        </div>
      </div>
    </div>

    <div class="header">Déroulement du combat</div>

    <?php
    $turn = 0;
    while (!$charizard->isDead() && !$blastoise->isDead()) {
      $turn++;
      echo "<div class='round'>";
      echo "<p><strong>Tour $turn :</strong></p>";
      $damage = $charizard->attack($blastoise);
      echo "<p>{$charizard->getNom()} attaque {$blastoise->getNom()} et inflige $damage dégâts. Il lui reste {$blastoise->getHp()} HP.</p>";
      if ($blastoise->isDead()) {
        echo "<p><strong>{$blastoise->getNom()} est K.O. ! {$charizard->getNom()} gagne !</strong></p>";
        break;
      }
      $damage = $blastoise->attack($charizard);
      echo "<p>{$blastoise->getNom()} attaque {$charizard->getNom()} et inflige $damage dégâts. Il lui reste {$charizard->getHp()} HP.</p>";
      if ($charizard->isDead()) {
        echo "<p><strong>{$charizard->getNom()} est K.O. ! {$blastoise->getNom()} gagne !</strong></p>";
        break;
      }
      echo "</div>";
    }
    ?>
  </div>
</body>
</html>
