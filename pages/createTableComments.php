<?
include_once("functions.php");
$pdo = connect();

$tableName = 'comments';
$sql = "CREATE TABLE IF NOT EXISTS $tableName (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    UserId int NOT NULL,
    HotelId int NOT NULL,
    Comment TEXT NOT NULL,
    Rating int NOT NULL,
    FOREIGN KEY (HotelId) REFERENCES hotels(Id),
    FOREIGN KEY (UserId) REFERENCES users(Id)) default charset = 'utf8'";

try{
    $pdo->exec($sql);
    echo "<div class='alert alert-success'>Table $tableName created successfully.</div>";
}catch(PDOException $ex){
    echo "Error creating table: ".$ex->getMessage();
}