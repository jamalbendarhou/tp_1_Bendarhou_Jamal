<?php
class Crud {
    //methode pour afficher tt les horloges 
    public function getHorloges() {
        global $pdo; 
        $PDOStatement = $pdo->query("SELECT * FROM horloge ORDER BY id ASC"); 
        $horloges = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $horloges; 
    }
// methode pour afficher une horloge avec id 
    public function getHorlogeById($id) {
        global $pdo; 
        $PDOStatement = $pdo->prepare("SELECT * FROM horloge WHERE id = :id"); // preparation de rqt sql pour affichage 
        $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $PDOStatement->execute();
        $horloge = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $horloge;
    }
// methode pour ajouter un item 
    public function ajouterHorloge($horloge) {
        global $pdo;
        //requete sql pour l ajout
        $PDOStatement = $pdo->prepare("INSERT INTO horloge (brand, type, model, price) VALUES (:brand, :type, :model, :price)");
        $PDOStatement->bindParam(':brand', $horloge['brand'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':type', $horloge['type'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':model', $horloge['model'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':price', $horloge['price'], PDO::PARAM_STR);
        $PDOStatement->execute();
        if ($PDOStatement->rowCount() <= 0) {
            return false;
        }
        return $pdo->lastInsertId();
    }
//methode pour modifier un item 
    public function updateHorlogeById($id, $horloge) {
        global $pdo; 
        //requete sql pour modification dans la table horloge 
        $PDOStatement = $pdo->prepare("UPDATE horloge SET brand = :brand, type = :type, model = :model, price = :price WHERE id = :id");
        $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $PDOStatement->bindParam(':brand', $horloge['brand'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':type', $horloge['type'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':model', $horloge['model'], PDO::PARAM_STR);
        $PDOStatement->bindParam(':price', $horloge['price'], PDO::PARAM_STR);
        $PDOStatement->execute();
    }

    //methode pour supprimer un item avec un id precis 

    public function deleteHorlogeById($id) {
        $horloge = $this->getHorlogeById($id);
        global $pdo;
        if ($horloge) {
            $PDOStatement = $pdo->prepare("DELETE FROM horloge WHERE id = :id"); // preparation de requete sql 
            $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
            $PDOStatement->execute();
            return "L'horloge avec l'id " . $id . " a été supprimée.";
        } else {
            return "Horloge introuvable";
        }
    }
}
