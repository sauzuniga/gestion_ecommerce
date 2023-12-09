<?php
include('config/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
      <!-- Modal para añadir productos -->
    <div class="modal" id="modal-producto" style="display: none;">
        <div class="body-modal">
            <button class="btn-close" onclick="hide_modal('modal-producto')"><i class="fa fa-window-close-o" aria-hidden="true"></i></button>
            <h3>Añadir productos</h3>
            
                <input type="text" id="codigo" style="display: none;">
                <div class="div-flex">
                <label>Nombre:</label>
                <input type="text" id="nombre">
                </div>
                <div class="div-flex">
                <label>Descripción:</label>
                <input type="text" id="descripcion">
                </div>
                <div class="div-flex">
                <label>Precio:</label>
                <input type="text" id="precio">
                </div>
                <div class="div-flex">
                <label>Estado:</label>
                <select id="estado">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                </div>
                <div class="div-flex">
                <input type="file" id="imagen">
                </div>
                <button onclick="save_product()">Guardar</button>
        </div>
    </div>
     <!-- Modal para editar productos -->
    <div class="modal" id="modal-producto-edit" style="display: none;">
		<div class="body-modal">
			<button class="btn-close" onclick="hide_modal('modal-producto-edit')"><i class="fa fa-times" aria-hidden="true"></i></button>
			<h3>Editar producto</h3>
			<div class="div-flex">
				<label>Código</label>
				<input type="text" id="codigo-e" disabled>
			</div>
			<div class="div-flex">
				<label>Nombre</label>
				<input type="text" id="nombre-e">
			</div>
			<div class="div-flex">
				<label>Descripción</label>
				<input type="text" id="descripcion-e">
			</div>
			<div class="div-flex">
				<label>Precio</label>
				<input type="number" id="precio-e">
			</div>
			<input type="text" id="rutimapro-aux" style="display: none;">
			<div class="div-flex">
				<label>Estado</label>
				<select id="estado-e">
					<option value="1">Activo</option>
					<option value="0">Inactivo</option>
				</select>
			</div>
			<img id="rutimapro" src="" style="width: 200px;margin: 5px auto;">
			<div class="div-flex">
				<input type="file" id="imagen-e">
			</div>
			<button onclick="update_product()">Actualizar</button>
		</div>
	</div>
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
            <h2>Mis productos</h2>
            <!-- Tabla de productos -->
            <table class="mt10">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th class="td-option">Opciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                 // Consulta para obtener productos
                $sql="SELECT * from producto";
                $resultado=mysqli_query($con,$sql);
                 // Iteración sobre los resultados para mostrar productos en la tabla
                    while ($row=mysqli_fetch_array($resultado)) {
                    echo 
                    '<tr>
                    <td>'.$row['codpro'].'</td>
                    <td>'.$row['nompro'].'</td>
                    <td>'.$row['despro'].'</td>
                    <td>'.$row['prepro'].'</td>
                    <td class="td-option">
                    <div class="div-flex div-td-button">
                        <button onclick="edit_products('.$row['codpro'].')"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button onclick="delete_products('.$row['codpro'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                    </td>
                    </tr>
                ' ;
                
                
                 }

                ?>
                </tbody>
                

            </table>
            <!-- Botón para mostrar el modal de agregar productos -->
            <button class="mt10" onclick="show_modal('modal-producto')">Agregar productos</button>

        </div>
    </div>
    <script type="text/javascript">
    /**
     * Muestra un modal por su ID.
     * @param {string} id - ID del modal a mostrar.
     */
    function show_modal(id){
        document.getElementById(id).style.display = "block";
    }
     /**
     * Oculta un modal por su ID.
     * @param {string} id - ID del modal a ocultar.
     */
    function hide_modal(id){
        document.getElementById(id).style.display = "none";
    }
     /**
     * Guarda un producto mediante una solicitud AJAX.
     */
    function save_product(){
			let fd=new FormData();
			fd.append('codigo',document.getElementById('codigo').value);
			fd.append('nombre',document.getElementById('nombre').value);
			fd.append('descripcion',document.getElementById('descripcion').value);
			fd.append('precio',document.getElementById('precio').value);
			fd.append('estado',document.getElementById('estado').value);
			fd.append('imagen',document.getElementById('imagen').files[0]);
			let request=new XMLHttpRequest();
			request.open('POST','api/producto_save.php',true);
			request.onload=function(){
                if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					console.log(response);
					if (response.state) {
						alert("Producto guardado");
						window.location.reload();
					}else{
						Swal.fire({
                       title: "Aviso",
                       text: response.detail,
                        icon: "info"
});

					}
				}

            }
            request.send(fd)
        }
     /**
     * Elimina un producto mediante una solicitud AJAX.
     * @param {number} codpro - Código del producto a eliminar.
     */
        function delete_products(codpro) {
    var c = confirm("¿Estás seguro de eliminar el producto de código " + codpro + "?");
    if (c) {
        let fd = new FormData();
        fd.append('codpro', codpro);  
        let request = new XMLHttpRequest();
        request.open('POST', 'api/delete_products.php', true);
        request.onload = function () {
            if (request.readyState == 4 && request.status == 200) {
                let response = JSON.parse(request.responseText);
                console.log(response);
                if (response.state) {
                    alert("Producto eliminado");
                    window.location.reload();
                } else {
                    alert(response.detail);
                }
            }
        }
        request.send(fd);
    }
}
/**
     * Edita la información de un producto mediante una solicitud AJAX.
     * @param {number} codpro - Código del producto a editar.
     */
function edit_products(codpro){
			let fd=new FormData();
			fd.append('codpro',codpro);
			let request=new XMLHttpRequest();
			request.open('POST','api/get_product.php',true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					console.log(response);
					document.getElementById("codigo-e").value=codpro;
					document.getElementById("nombre-e").value=response.product.nompro;
					document.getElementById("descripcion-e").value=response.product.despro;
					document.getElementById("precio-e").value=response.product.prepro;
					document.getElementById("estado-e").value=response.product.estado;
					document.getElementById("rutimapro").src="../ecommerce-2.0/assets/"+response.product.rutimapro;
					document.getElementById("rutimapro-aux").value=response.product.rutimapro;
					show_modal('modal-producto-edit');
					
				}
			}
			request.send(fd);
		}
     /**
     * Actualiza la información de un producto mediante una solicitud AJAX.
     */
        function update_product(){
			let fd=new FormData();
			fd.append('codigo',document.getElementById('codigo-e').value);
			fd.append('nombre',document.getElementById('nombre-e').value);
			fd.append('descripcion',document.getElementById('descripcion-e').value);
			fd.append('precio',document.getElementById('precio-e').value);
			fd.append('estado',document.getElementById('estado-e').value);
			fd.append('imagen',document.getElementById('imagen-e').files[0]);
			fd.append('rutimapro',document.getElementById("rutimapro-aux").value);
			let request=new XMLHttpRequest();
			request.open('POST','api/update_products.php',true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					console.log(response);
					if (response.state) {
						alert("El producto se ha actualizado");
						window.location.reload();
					}else{
						alert(response.detail);
					}
				}
			}
			request.send(fd);
		}
    </script>
   
    
    

</body>
</html>