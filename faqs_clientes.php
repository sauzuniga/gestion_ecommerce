<?php
include('config/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <div class="main-container">
        <div class="body-nav-bar">
            <img src="assets/web/niche.png" alt="">
            <center>
                <h3>Administrador</h3>
            </center>
            <ul class="mt10">
            <li> <a href="main.php">Inicio</a></li>
                <li> <a href="productos.php">Productos</a></li>
                <li> <a href="add-faqs.php">Agregar faqs</a></li>
                <li> <a href="faqs_clientes.php">Faqs de clientes</a></li>
            </ul>

        </div>
        <div class="body-page">
            <h2>Preguntas de los usuarios</h2>
            <table class="mt10">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Pregunta</th>
                    
                    
                </tr>
                </thead>
                <tbody>
                <?php
                $sql="SELECT * from faqs_clientes";
                $resultado=mysqli_query($con,$sql);
                    while ($row=mysqli_fetch_array($resultado)) {
                    echo 
                    '<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['pregunta'].'</td>
                    </tr>
                ' ;
                
                
                 }

                ?>
                </tbody>
                

            </table>
           

        </div>
    </div>
    
</body>


</html>