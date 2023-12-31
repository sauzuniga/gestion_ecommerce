<?php
/**
 * Archivo para actualizar un producto en la base de datos.
 * 
 * Este archivo procesa la información recibida mediante una petición POST
 * para actualizar los datos de un producto en la base de datos. Se permite
 * actualizar el nombre, descripción, precio, estado y opcionalmente la imagen
 * asociada al producto.
 * 
 * @file
 */
	include("../config/connection.php");
	/**
 * Respuesta de la operación de actualización del producto.
 * 
 * @var stdClass $response
 */
	$response=new stdClass();

	// Obtener los datos del producto a actualizar
	$codpro=$_POST['codigo'];
	$nompro=$_POST['nombre'];
	$despro=$_POST['descripcion'];
	$prepro=$_POST['precio'];
	$estado=$_POST['estado'];
	$rutimapro=$_POST['rutimapro'];

	if(isset($_FILES['imagen'])){
		$nombre_imagen = date("YmdHis").".jpg";  
		// Consulta para actualizar los datos del producto incluyendo la nueva imagen
		$sql="update producto set nompro='$nompro',despro='$despro',
		estado=$estado,prepro=$prepro,rutimapro='$nombre_imagen'
		where codpro=$codpro";
		$result=mysqli_query($con,$sql);
		if ($result) {			
			 // Se Mueve la nueva imagen a la carpeta de destino
			if(move_uploaded_file($_FILES['imagen']['tmp_name'], "../../ecommerce-2.0/assets/".$nombre_imagen)){
				$response->state=true;
				//Se Elimina la antigua imagen asociada al producto
				unlink("../../ecommerce-2.0/assets/".$rutimapro);
			}else{
				$response->state=false;
				$response->detail="Hubo un error al cargar la imagen";
			}
		}else{
			$response->state=false;
			$response->detail="No se pudo actualizar el producto";
		}
	}else{
		$sql="update producto set nompro='$nompro',despro='$despro',
		estado=$estado,prepro=$prepro
		where codpro=$codpro";
		$result=mysqli_query($con,$sql);
		if ($result) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="No se pudo actualizar los datos";
		}
	}

	echo json_encode($response);