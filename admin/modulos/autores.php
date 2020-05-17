<?php
check_admin();


if(isset($enviar)){
	$name = clear($name);
	$cedula = clear($cedula);
	//$oferta = clear($oferta);
	$categoria=clear($categoria);
	

	


	$mysqli->query("INSERT INTO autores (FullName, cedula, id_categoria) VALUES ('$name','$cedula','$categoria')");
	alert("Producto agregado");
	redir("?p=autores");
}


if(isset($eliminar)){
	$mysqli->query("DELETE FROM autores WHERE id = '$eliminar'");
	redir("?p=autores");
}




?>


<h1>Agregar Autor</h1><br><br>

<form method="post" action="" enctype="multipart/form-data">
	<div class="form-group">
		<input type="text" class="form-control" name="name" placeholder="Nombre completo"/>
	</div>


	<div class="form-group">
		<input type="text" class="form-control" name="cedula" placeholder="Cedula (1234567)"/>
	</div>


	<div class="form-group">

		<select name="categoria" required class="form-control">
			<option value="">Seleccione una categoria</option>
			<?php
				$q = $mysqli->query("SELECT * FROM categorias ORDER BY categoria ASC");

				while($r=mysqli_fetch_array($q)){
					?>
						<option value="<?=$r['id']?>"><?=$r['categoria']?></option>
					<?php
				}
			?>
		</select>

	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-success" name="enviar"><i class="fa fa-check"></i> Guardar</button>
	</div>

</form><br>

<table class="table table-striped">


    <tr>
		<th>Cedula</th>
		<th>Nombre</th>
		<th>Carrera</th>
		<th>Acciones</th>
	</tr>
    
    
	<?php
		$prod = $mysqli->query("SELECT * FROM autores ORDER BY id DESC");
		while($rp=mysqli_fetch_array($prod)){

			
			$cat = $mysqli->query("SELECT * FROM categorias WHERE id = '".$rp['id_categoria']."'");

			if(mysqli_num_rows($cat)>0){
				$rcat = mysqli_fetch_array($cat);
				$categoria = $rcat['categoria'];
			
			}else{
				$categoria = "--";
			}




			?>


<tr>
			

				

					<td><?=$rp['Cedula']?></td>
					<td><?=$rp['FullName']?></td>
				
					<td><?=$categoria?></td>
					<td>
						
						<a style="color:#08f" href="?p=modificar_producto&id=<?=$rp['id']?>"><i class="fa fa-edit"></i></a>
						&nbsp;
						<a style="color:#08f" href="?p=autores&eliminar=<?=$rp['id']?>"><i class="fa fa-times"></i></a>

					</td>
				</tr>


				<?php
		}
	?>

</table>