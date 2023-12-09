<?php

/**
 * Archivo para guardar un nuevo producto en la base de datos.
 * 
 * Este archivo procesa la información recibida mediante una petición POST
 * para insertar un nuevo producto en la base de datos y almacenar su imagen
 * en la carpeta correspondiente.
 * 
 * @file
 */
	include("../config/connection.php");
	/**
 * Respuesta de la operación de guardado del producto.
 * 
 * @var stdClass $response
 */
    $response=new stdClass();

	// Obtener los datos del formulario
	$codigo=$_POST['codigo'];
	$nombre=$_POST['nombre'];
	$descripcion=$_POST['descripcion'];
	$precio=$_POST['precio'];
	$estado=$_POST['estado'];
	// Validar que se haya ingresado un nombre

	if ($nombre=="") {
		$response->state=false;
		$response->detail="Falta el nombre";
	}else{
		 // Validar que se haya proporcionado una descripción
		if ($descripcion=="") {
			$response->state=false;
			$response->detail="Falta la descripcion";
		}else{
			 //Verificar que se ha escogido una imagen
			if(isset($_FILES['imagen'])){
				
				$nombre_imagen = date("YmdHis").".jpg";
				 // Se inserta el nuevo producto en la base de datos  
				$sql="INSERT INTO producto (nompro,despro,prepro,estado,rutimapro)
				VALUES ('$nombre','$descripcion',$precio,$estado,'$nombre_imagen')";
				$result=mysqli_query($con,$sql);
				if ($result) {
					 //Se mueve la imagen a la carpeta de destino
					if(move_uploaded_file($_FILES['imagen']['tmp_name'], "../../ecommerce-2.0/assets/".$nombre_imagen)){
						$response->state=true;
					}else{
						$response->state=false;
						$response->detail="hubo un error al cargar la imagen";
					}
				}else{
					$response->state=false;
					$response->detail="No se pudo guardar el producto";
				}
			}else{
				$response->state=false;
				$response->detail="Falta la imagen";
			}
		}
	}
// Se devolve la respuesta como JSON
	echo json_encode($response);
