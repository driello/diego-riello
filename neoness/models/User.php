<?php

class User extends Model
{
    public function __construct()
    {
        $this->table = 'users';   // nom de la table en BDD
        $this->getConnection();   // ouvre la connexion
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (nom, prenom, tel, age, poids, taille, objectif_poids, password_hash)
                VALUES
                (:nom, :prenom, :tel, :age, :poids, :taille, :objectif_poids, :password_hash)";

        $stmt = $this->_connexion->prepare($sql);

        $params = [
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':tel' => $data['tel'],
            ':age' => (int) $data['age'],
            ':poids' => (float) $data['poids'],
            ':taille' => (float) $data['taille'],
            ':objectif_poids' => (float) $data['objectif_poids'],
            ':password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
        ];

        return $stmt->execute($params);
    }

    public function verifyLogin($tel, $password)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tel = :tel LIMIT 1";
        $stmt = $this->_connexion->prepare($sql);
        $stmt->execute([':tel' => $tel]);

        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }

        return $user;
    }

    public function calculImc($poids, $taille)
    {
        if ($taille <= 0) {
            return 0;
        }

        return round($poids / ($taille * $taille), 1);
    }
}
