<?php




try{
    $connection = new PDO('mysql:host=localhost;dbname=Facturation', 'metarar22', 'root');
    }
    catch (PDOException $erreur){
        die('Erreur: ' . $erreur->getMessage());
    }
    

$Query1 = 'CREATE TABLE IF NOT EXISTS Client(
    Client_id INT AUTO_INCREMENT PRIMARY KEY,
    Client_name varchar(30) NOT NULL,
    Client_adress varchar (50) NOT NULL
    )';         

$Query2 = 'CREATE TABLE IF NOT EXISTS Facture(
    id INT AUTO_INCREMENT PRIMARY KEY,
    Date DATE NOT NULL,
    TTC INT NOT NULL,
    Designation Text NOT NULL,
    Status TEXT NOT NULL,
    Client_id INT NOT NULL
    )';





$statement1 = $connection->prepare($Query1);
$statement1->execute();


$statement2 = $connection->prepare($Query2);
$statement2->execute();




/*
$Query3 = ';

//insertion des données dans la table user 
$Clients=[
    ['Client_name' => 'Paul', 'Client_adress' => '9 rue Lourmel'],
    ['Client_name' => 'Marine', 'Client_adress' => '10 rue Lourmel']

];


$statement3 = $connection->prepare($Query3);
foreach($Clients as $Client) {
    $statement3->execute($Client);
}
*/






$Query4= 'INSERT INTO Facture(Date, TTC, Designation, Status, Client_id) VALUES(:Date, :TTC, :Designation, :Status, :Client_id)';

//Insertion des données dans categories
$Factures=[
    [
    'Date' => '2022-08-22',
    'TTC' => '1400',
    'Designation' => 'Achat PC',
    'Status' => 'NOT PAYED',
    'Client_id' => '1'  
    ],
    [
    'Date' => '2022-08-22',
    'TTC' => '1600',
    'Designation' => 'Achat PC',
    'Status' => 'NOT PAYED',
    'Client_id' => '2'  
    ]

];
    


$statement5 = $connection->prepare($Query4);

foreach($Factures as $Facture) {
    $statement5->execute($Facture);
}

