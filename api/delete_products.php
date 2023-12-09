<?php
/**
 * Archivo para eliminar un producto de la base de datos y su imagen asociada.
 * 
 * Este archivo procesa la información recibida mediante una petición POST
 * para eliminar un producto específico de la base de datos y también elimina
 * la imagen asociada al producto en la carpeta correspondiente.
 * 
 * @file
 */
	include("../config/connection.php");
    /**
 * Respuesta de la operación de eliminación del producto.
 * 
 * @var stdClass $response
 */
	$response=new stdClass();
    // Se Obtiene el código del producto a eliminar
    $codpro=$_POST['codpro'];
    // Se Obtene la ruta de la imagen asociada al producto
    $sql="select rutimapro from producto where codpro=$codpro";
	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	$rutimapro=$row['rutimapro'];
    //Se elimina el producto de la base de datos
	$sql="delete from producto where codpro=$codpro";
	$result=mysqli_query($con,$sql);
    
    if ($result) {
        $response->state=true;
        unlink("../../ecommerce-2.0/assets/".$rutimapro);
    }else{
        $response->state=false;
        $response->detail="No se puede eliminar el producto";
    }
    // SE devolve la respuesta como JSON


echo json_encode($response);
    