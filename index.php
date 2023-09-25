<?php
// connection a ma base de donne tp_1
$host = "localhost";
$db = "tp_1";
$user = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8"; 

try {
    $pdo = new PDO($dsn, $user, $password);
    if ($pdo) {
        echo "Connected to the $db database successfully";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

require_once('class/crud.php');
require_once('class/Horloge.php');

// creer un objet crud 
$crud = new Crud($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'ajouter') {
            $nouvelleHorloge = [
                'brand' => $_POST['brand'],
                'type' => $_POST['type'],
                'model' => $_POST['model'],
                'price' => $_POST['price']
            ];
            $resultatAjout = $crud->ajouterHorloge($nouvelleHorloge);
            if ($resultatAjout) {
                echo "Horloge ajoutée avec l'ID : $resultatAjout";
            } else {
                echo "Erreur lors de l'ajout de l'horloge.";
            }
        } elseif ($_POST['action'] === 'éditer') {
            $idHorloge = $_POST['id'];
            $horlogeModifiee = [
                'brand' => $_POST['brand'],
                'type' => $_POST['type'],
                'model' => $_POST['model'],
                'price' => $_POST['price']
            ];
            $crud->updateHorlogeById($idHorloge, $horlogeModifiee);
            echo "Horloge mise à jour avec succès.";
        } elseif ($_POST['action'] === 'supprimer') {
            $idHorloge = $_POST['id'];
            $resultatSuppression = $crud->deleteHorlogeById($idHorloge);
            echo $resultatSuppression;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Horloges</title>
</head>
<body>
    <h1>Gestion des Horloges</h1>

    <!-- formulaire pour afficher tt mes produits de la table horloge   -->
    <h2>Liste des Horloges</h2>
    <ul>
        <?php
        $horloges = $crud->getHorloges();

        foreach ($horloges as $horloge) {
            echo "<li>{$horloge['brand']} - {$horloge['model']} - {$horloge['price']} $</li>";
        }
        ?>
    </ul>
<!-- formulaire pour afficher un item selon son id  -->
   
    <h2>Rechercher l'horloge avec son ID</h2>
    <form method="get" action="index.php">
        <label>ID de l'Horloge:</label>
        <input type="text" name="id">
        <input type="submit" value="Afficher">
    </form>
    <?php
    if (isset($_GET['id'])) {
        $idHorloge = $_GET['id'];
        $horlogeParId = $crud->getHorlogeById($idHorloge);
        if ($horlogeParId) {
            echo "<pre>";
            print_r($horlogeParId);
            echo "</pre>";
        } else {
            echo "Horloge introuvable pour l'ID spécifié.";
        }
    }
    ?>

    <!-- formulaire pour ajouter une horloge -->
    <h2>Ajouter une Horloge</h2>
    <form method="post" action="index.php">
        <label>Marque:</label>
        <input type="text" name="brand">
        <label>Type:</label>
        <input type="text" name="type">
        <label>Modele:</label>
        <input type="text" name="model">
        <label>Prix:</label>
        <input type="text" name="price">
        <input type="submit" name="action" value="ajouter">
    </form>

    <!-- formulaire pour la modification d un item  -->
    <h2>modifier une Horloge</h2>
    <form method="post" action="index.php">
        <label>Id de l horloge a modifier :</label>
        <input type="text" name="id">
        <label>Nouvelle Marque:</label>
        <input type="text" name="brand">
        <label>Nouveau Type:</label>
        <input type="text" name="type">
        <label>Nouveau Modele:</label>
        <input type="text" name="model">
        <label>Nouveau Prix:</label>
        <input type="text" name="price">
        <input type="submit" name="action" value="Modifier">
    </form>

    <!-- formulaire pour supprimer un item selon son id  -->
    <h2>Supprimer une Horloge</h2>
    <form method="post" action="index.php">
        <label>ID de l'Horloge à supprimer:</label>
        <input type="text" name="id">
        <input type="submit" name="action" value="supprimer">
    </form>
</body>
</html>
