<?php 
$host = "localhost";
$data = "Web Test";
$user = "root";
$PASS = "";
$chrs = "utf8";
$attr = "mysql:host=$host;dbname=$data;charset=$chrs";
$opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try{
    $pdo = new PDO($attr, $user, $PASS, $opts);
}
catch(PDOException $e){
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

$count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

if ($count==0){
    for($i=1;$i<=100;$i++){
        $name = "User $i";
        $email = "Email $i";
        $pdo -> query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
}
}