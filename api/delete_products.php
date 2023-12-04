<?php
	include("../config/connection.php");
	$response=new stdClass();
    $codpro=$_POST['codpro'];
    $sql="select rutimapro from producto where codpro=$codpro";
	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	$rutimapro=$row['rutimapro'];
	$sql="delete from producto where codpro=$codpro";
	$result=mysqli_query($con,$sql);
    
    if ($result) {
        $response->state=true;
        unlink("../../ecommerce-2.0/assets/".$rutimapro);
    }else{
        $response->state=false;
        $response->detail="No se puede eliminar el producto";
    }

echo json_encode($response);
    