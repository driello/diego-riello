<?php
// Exercice 2 : CompteBancaire
// - Propriété privée solde
// - Méthodes : deposer(), retirer(), getSolde()
// - Validation : ne pas retirer plus que le solde

class CompteBancaire
{
    private string $titulaire;
    private float $solde;

    public function __construct(string $titulaire, float $soldeInitial = 0.0)
    {
        if ($soldeInitial < 0) {
            throw new InvalidArgumentException("Le solde initial ne peut pas être négatif.");
        }

        $this->titulaire = $titulaire;
        $this->solde = $soldeInitial;
    }

    public function deposer(float $montant): void
    {
        if ($montant <= 0) {
            echo "Le montant du dépôt doit être positif.<br>";
            return;
        }

        $this->solde += $montant;
        echo "Dépôt de {$montant} € effectué. Nouveau solde : {$this->solde} €<br>";
    }

    public function retirer(float $montant): void
    {
        if ($montant <= 0) {
            echo "Le montant du retrait doit être positif.<br>";
            return;
        }

        if ($montant > $this->solde) {
            echo "Retrait de {$montant} € impossible : solde insuffisant ({$this->solde} €).<br>";
            return;
        }

        $this->solde -= $montant;
        echo "Retrait de {$montant} € effectué. Nouveau solde : {$this->solde} €<br>";
    }

    public function getSolde(): float
    {
        return $this->solde;
    }

    public function afficher(): void
    {
        echo "Compte de {$this->titulaire} — solde actuel : {$this->solde} €<br>";
    }
}


// --- Petit scénario de test ---

$compteDiego = new CompteBancaire("Diego", 100);

$compteDiego->afficher();
$compteDiego->deposer(50);    // solde = 150
$compteDiego->retirer(30);    // solde = 120
$compteDiego->retirer(500);   // refusé, insuffisant

echo "Solde final : " . $compteDiego->getSolde() . " €<br>";
