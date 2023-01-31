<?php

use PDO;
use PDOException;

//Se connecter à la base de données
try{
    $connection = new PDO('mysql:host=localhost;dbname=Facturation', 'metarar22', 'root');
    }
    catch (PDOException $erreur){
        die('Erreur: ' . $erreur->getMessage());
    }

$request_method = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

switch($request_method)
{
  case 'GET':
    if(!empty($_GET["id"]))
    {
      // Récupérer une seule facture par l'ID
      $id = ($_GET["id"]);
      getFacture($id);
    }
    else
    {
      // Récupérer toutes les factures
      getAllFacture();
    }
    break;

  case 'POST':
    //Ajouter une Facture
    addFacture();
    break;
  
  case 'DELETE';
  //Supprimer une facture
    deleteFacture();
    break;

  default:
    // Requête invalide
    header("Method Not Allowed");
    break;
  
}

//Extraire toutes les factures
function getAllFacture(){
  global $connection;
  $sql = "SELECT * FROM Facture";
  $stmt = $connection->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($result);
}   


//Extraire une seule facture
function getFacture($id){
  global $connection;
  $sql = "SELECT * FROM Facture WHERE id = $id";
  $stmt = $connection->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($result);
}   

//Ajouter une facture
function addFacture(){
  global $connection;
  $Date = $_POST["Date"];
  $TTC = $_POST["TTC"];
  $Designation = $_POST["Designation"];
  $Status = $_POST["Status"];
  $Client_id = $_POST["Client_id"];
  
  try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO Facture(Date, TTC, Designation, Status, Client_id) VALUES('$Date', '$TTC', '$Designation', '$Status', '$Client_id')";
    $connection->exec($sql);
    echo "Insertion réussie";
    }catch (PDOException $erreur){
      die('Erreur: ' . $erreur->getMessage());

}
}

function deleteFacture(){
  global $connection;
  $id = $_GET['id'];
  $sql = "DELETE FROM Facture WHERE id= :id";
  $stmt = $connection->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  if ($stmt->execute()){
    echo 'Facture deleted';
  }
  
}



