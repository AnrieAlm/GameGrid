<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST["email"];
    $password = $_POST["password"];

    try{
        require_once "db.php";
        $query = "INSERT INTO users (email , password) VALUES (?, ?); ";

        $stmt = $pdo -> prepare($query);

        $stmt -> execute([$email, $password]);

        $pdo = null;
        $stmt = null;

        header("Location: ../index.php");


        die();

    }catch(PDOException $e){
        die("QUERY FAILED: ". $e -> getMessage());
      
    }
}else{
    header("Location: ../index.php");
}