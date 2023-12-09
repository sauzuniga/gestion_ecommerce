<?php
    
    $conn = new PDO("mysql:host=localhost;dbname=sistema_ecommerce", "root", "usbw");
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
    if (isset($_POST["submit"]))
{
    // update the FAQ in database
    $sql = "UPDATE faqs SET Pregunta = ?, Respuesta = ? WHERE id = ?";
    $statement = $conn->prepare($sql);
    $statement->execute([
        $_POST["question"],
        $_POST["answer"],
        $_POST["id"]
    ]);
    // redirect back to previous page
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <script src="js/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="richtext/richtext.min.css" />
    <script src="richtext/jquery.richtext.js"></script>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <h1 class="text-center">Edit FAQ</h1>
          
            <form method="POST" action="edit_faqs.php">
               
                <input type="hidden" name="id" value="<?php echo $faq['id']; ?>" required />
               
                <div class="form-group">
                    <label>Enter Question</label>
                    <input type="text" name="question" class="form-control" value="<?php echo $faq['Pregunta']; ?>" required />
                </div>
                
                <div class="form-group">
                    <label>Enter Answer</label>
                    <textarea name="answer" id="answer" class="form-control" required><?php echo $faq['Respuesta']; ?></textarea>
                </div>
               
                <input type="submit" name="submit" class="btn btn-warning" value="Edit FAQ" />
            </form>
        </div>
    </div>
</div>
<script>

    window.addEventListener("load", function () {
        $("#answer").richText();
    });
</script>

</body>

</html>
   