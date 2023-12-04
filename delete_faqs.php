<?php
    
    $conn = new PDO("mysql:host=localhost;dbname=sistema_ecommerce", "root", "");
   
    $sql = "SELECT * FROM faqs WHERE id = ?";
    $statement = $conn->prepare($sql);
    $statement->execute([
        $_REQUEST["id"]
    ]);
    $faq = $statement->fetch();
    if (!$faq)
    {
        die("FAQ not found");
    }
 
    $sql = "DELETE FROM faqs WHERE id = ?";
    $statement = $conn->prepare($sql);
    $statement->execute([
        $_POST["id"]
    ]);
   
    header("Location: " . $_SERVER["HTTP_REFERER"]);
?>
