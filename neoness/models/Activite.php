<?php

class Activite extends Model
{
    public function __construct()
    {
        $this->table = 'activites';   // nom de la table en BDD
        $this->getConnection();   // ouvre la connexion
    }

    public function addActivite(array $data)
    {
        $sql = "INSERT INTO {$this->table} 
        (user_id, sport_id, date_activite, duree_minutes, calories)
        VALUES (:user_id, :sport_id, :date_activite, :duree_minutes, :calories)";

        $query = $this->_connexion->prepare($sql);

        $params = [
            ':user_id' => $data['user_id'],
            ':sport_id' => $data['sport_id'],
            ':date_activite' => $data['date_activite'],
            ':duree_minutes' => $data['duree_minutes'],
            ':calories' => $data['calories'],
        ];
        return $query->execute($params);

    }

    public function getActiviteJour($userId, $date)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id
        AND date_activite = :date_activite ORDER BY id DESC";
        $query = $this->_connexion->prepare($sql);
        $query->execute([
            ":user_id" => $userId,
            ":date_activite" => $date,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}