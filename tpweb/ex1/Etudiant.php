<?php
class Etudiant {
    private $nom;
    private $notes = [];

    // Constructeur
    public function __construct($nom, $notes) {
        $this->nom = $nom;
        $this->notes = $notes;
    }

    // Méthode pour afficher les notes avec couleurs
    public function afficherNotes() {
        echo "<h3>Notes de $this->nom :</h3>";
        echo "<div style='display: flex; gap: 10px;'>";
        foreach ($this->notes as $note) {
            $color = $this->getColor($note);
            echo "<div style='background-color: $color; padding: 10px; border-radius: 5px;'>$note</div>";
        }
        echo "</div>";
    }

    // Déterminer la couleur selon la note
    private function getColor($note) {
        if ($note < 10) return 'red';
        elseif ($note > 10) return 'green';
        else return 'orange';
    }

    // Méthode pour calculer la moyenne
    public function calculerMoyenne() {
        if (count($this->notes) === 0) return 0;
        return array_sum($this->notes) / count($this->notes);
    }

    // Méthode pour afficher le résultat d'admission
    public function afficherAdmission() {
        $moyenne = $this->calculerMoyenne();
        echo "<p><strong>Moyenne :</strong> " . number_format($moyenne, 2) . "</p>";
        echo "<p><strong>Résultat :</strong> " . ($moyenne >= 10 ? "Admis" : "Non Admis") . "</p>";
    }
}
?>
