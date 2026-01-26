<?php

namespace Rpg\Model;

use Rpg\Interfaces\ArmeInterface;
use Rpg\Interfaces\CompetenceInterface;
use Rpg\Interfaces\RaceInterface;

class Personnage
{
    private string $nom;

    private RaceInterface $race;
    private ArmeInterface $arme;

    /** @var CompetenceInterface[] */
    private array $competences = [];

    private int $niveau      = 0;
    private int $experience  = 0;
    private int $pvMax       = 100;
    private int $pvActuels   = 50;
    private int $manaMax     = 50;
    private int $manaActuels = 5;

    /** @var array<string,int|float> */
    private array $statsBase = [];

    public function __construct(
        string $nom,
        RaceInterface $race,
        ArmeInterface $arme,
        array $competences = []
    ) {
        $this->nom         = $nom;
        $this->race        = $race;
        $this->arme        = $arme;
        $this->competences = $competences;
    }

    // --- Nom ---

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    // --- Race ---

    public function getRace(): RaceInterface
    {
        return $this->race;
    }

    public function setRace(RaceInterface $race): void
    {
        $this->race = $race;
    }

    // --- Arme ---

    public function getArme(): ArmeInterface
    {
        return $this->arme;
    }

    public function setArme(ArmeInterface $arme): void
    {
        $this->arme = $arme;
    }

    // --- Compétences ---

    /**
     * @return CompetenceInterface[]
     */
    public function getCompetences(): array
    {
        return $this->competences;
    }

    public function addCompetence(CompetenceInterface $competence): void
    {
        $this->competences[] = $competence;
    }

    // --- Niveau / XP ---

    public function getNiveau(): int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): void
    {
        $this->niveau = $niveau;
    }

    public function getExperience(): int
    {
        return $this->experience;
    }

    public function gagnerExperience(int $xp): void
    {
        $this->experience += $xp;
    }

    // --- Stats de base ---

    public function getStatsBase(): array
    {
        return $this->statsBase;
    }

    public function setStatsBase(array $stats): void
    {
        $this->statsBase = $stats;
    }

    // --- PV / Mana ---

    public function getPvMax(): int
    {
        return $this->pvMax;
    }

    public function getPvActuels(): int
    {
        return $this->pvActuels;
    }

    public function setPvActuels(int $pv): void
    {
        $this->pvActuels = max(0, min($pv, $this->pvMax));
    }

    public function getManaMax(): int
    {
        return $this->manaMax;
    }

    public function getManaActuels(): int
    {
        return $this->manaActuels;
    }

    public function setManaActuels(int $mana): void
    {
        $this->manaActuels = max(0, min($mana, $this->manaMax));
    }

    // --- Compétences / capacités ---

    public function utiliserCompetence(int $index, ?Personnage $cible = null): string
    {
        if (!isset($this->competences[$index])) {
            return "Compétence inconnue.";
        }

        if ($cible === null) {
            $cible = $this;
        }

        return $this->competences[$index]->utiliser($cible);
    }

    public function utiliserCapaciteRaciale(): string
    {
        return $this->race->utiliserCapacite();
    }

    // --- Combat ---

    public function attaquer(Personnage $cible): array
    {
        // 1. Calcul des dégâts en fonction de l'arme
        $degats = random_int(
            $this->arme->getdegatsMin(),
            $this->arme->getdegatsMax()
        );

        // 2. Application des dégâts
        $cible->recevoirDegats($degats);

        // 3. Données pour le contrôleur / la vue
        return [
            'attaquant_nom'       => $this->nom,
            'cible_nom'           => $cible->getNom(),
            'arme_nom'            => $this->arme->getNom(),
            'degats'              => $degats,
            'pv_cible_restants'   => $cible->getPvActuels(),
            'cible_est_vivante'   => $cible->estVivant(),
        ];
    }

    public function recevoirDegats(int $degats): void
    {
        $this->pvActuels -= $degats;

        if ($this->pvActuels < 0) {
            $this->pvActuels = 0;
        }
    }

    public function estVivant(): bool
    {
        return $this->pvActuels > 0;
    }

    // --- Fiche personnage ---

    public function getFiche(): array
    {
        return [
            'nom'          => $this->nom,
            'race_nom'     => $this->race->getNom(),
            'niveau'       => $this->niveau,
            'experience'   => $this->experience,
            'pv_actuels'   => $this->pvActuels,
            'pv_max'       => $this->pvMax,
            'mana_actuels' => $this->manaActuels,
            'mana_max'     => $this->manaMax,
            'arme_nom'     => $this->arme ? $this->arme->getNom() : null,
            'arme_desc'    => $this->arme ? $this->arme->getDescription() : null,
        ];
    }
}
