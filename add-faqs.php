<?php
/**
 * Página para la administración de preguntas frecuentes (FAQs).
 *
 * Este archivo gestiona la creación de la tabla de FAQs, la inserción de nuevas FAQs,
 * y la visualización de las FAQs existentes. También permite la edición y eliminación de FAQs.
 *
 * @file
 */
    
    $conn = new PDO("mysql:host=localhost;dbname=sistema_ecommerce", "root", "usbw");
    
    if (isset($_POST["submit"]))
    {
/**
 * Sección para la creación de la tabla de FAQs si no existe.
 */
        $sql = "CREATE TABLE IF NOT EXISTS faqs (
            id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
            Pregunta TEXT NULL,
            Respuesta TEXT NULL,
            Hora_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $statement = $conn->prepare($sql);
        $statement->execute();
        // Insertar una nueva FAQ
        $sql = "INSERT INTO faqs (Pregunta, Respuesta) VALUES (?, ?)";
        $statement = $conn->prepare($sql);
        $statement->execute([
            $_POST["question"],
            $_POST["answer"]
        ]);
    }
/**
 * Obtener todas las FAQs ordenadas por ID de forma descendente.
 */
    $sql = "SELECT * FROM faqs ORDER BY id DESC";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $faqs = $statement->fetchAll();
    
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
            <h1 class="text-center">Add FAQ</h1>
          
            <form method="POST" action="add-faqs.php">
              
                <div class="form-group">
                    <label>Enter Question</label>
                    <input type="text" name="question" class="form-control" required />
                </div>
                
                <div class="form-group">
                    <label>Enter Answer</label>
                    <textarea name="answer" id="answer" class="form-control" required></textarea>
                </div>
             
                <input type="submit" name="submit" class="btn btn-info" value="Add FAQ" />
            </form>
        </div>
    </div>
    <!-- Se muestran las FAQS agregadas -->
<div class="row">
    <div class="offset-md-2 col-md-8">
        <table class="table table-bordered">
          
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pregunta/th>
                    <th>Respuesta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
           
            <tbody>
                <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td><?php echo $faq["id"]; ?></td>
                        <td><?php echo $faq["Pregunta"]; ?></td>
                        <td><?php echo $faq["Respuesta"]; ?></td>
                        <td>
                        <a href="edit_faqs.php?id=<?php echo $faq['id']; ?>" class="btn btn-warning btn-sm"> Editar</a>
    

                          
                 <form method="POST" action="delete_faqs.php" onsubmit="return confirm('Estas seguro de querer borrar esta faq ?');">
                 <input type="hidden" name="id" value="<?php echo $faq['id']; ?>" required />
                <input type="submit" value="Delete" class="btn btn-danger btn-sm" />
                </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<script>
    // Se inicializa richtext
window.addEventListener("load", function () {
    $("#answer").richText();
});
</script>



    
</body>
</html>