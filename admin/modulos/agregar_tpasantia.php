<?php
check_admin();

if(isset($enviar)){
	$name = clear($name);
	$cedula = clear($cedula);
	//$oferta = clear($oferta);
	$categoria=clear($categoria);
	$imagen = "";
	$descargable = "";

	$x = $mysqli->query("SELECT * FROM tpasantia WHERE cedula = '$cedula' and name='$name'");

	if(mysqli_num_rows($x)>0){
		alert("Trabajo ya registrado");
		redir("?p=agregar_tpasantia");
		die();
	}



	if(is_uploaded_file($_FILES['imagen']['tmp_name'])){
		$imagen = $name.rand(0,1000).".png";
		move_uploaded_file($_FILES['imagen']['tmp_name'], "../ipasantia/".$imagen);
	}

	if(is_uploaded_file($_FILES['descargable']['tmp_name'])){
		$descargable = rand(0,1000).$_FILES['descargable']['name'];
		move_uploaded_file($_FILES['descargable']['tmp_name'], "../descargable/".$descargable);
	}

	$mysqli->query("INSERT INTO tpasantia (name, cedula, id_categoria,imagen,descargable) VALUES ('$name','$cedula','$categoria','$imagen','$descargable')");
	alert("Producto agregado");
	redir("?p=agregar_tpasantia");
}

if(isset($eliminar)){
	$mysqli->query("DELETE FROM tpasantia WHERE id = '$eliminar'");
	redir("?p=agregar_tpasantia");
}




?>

<h1>Agregar Producto</h1><br><br>

<form method="post" action="" enctype="multipart/form-data">
	<div class="form-group">
		<input type="text" class="form-control" name="name" placeholder="Titulo"/>
	</div>


	<div class="form-group">
		<input type="text" class="form-control" name="cedula" placeholder="Cedula (1234567)"/>
	</div>


	<label>Imagen del producto</label>

	<div class="form-group">
		<input type="file" class="form-control" name="imagen" title="Imagen del producto" placeholder="Imagen del producto"/>
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
		<label>¿Tiene algun archivo de descarga?</label>
		<input class="form-control" type="file" name="descargable"/>
	</div>


	<div class="form-group">
		<button type="submit" class="btn btn-success" name="enviar"><i class="fa fa-check"></i> Agregar Producto</button>
	</div>

</form><br>

<br>

<table class="table table-striped">

	<tr>
		<th>Titulo</th>
		<th>Cedula</th>
		<th>Autor</th>
		<th>Imagen</th>
		<th>Carrera</th>
		<th>Acciones</th>
	</tr>

	<?php
		$prod = $mysqli->query("SELECT * FROM tpasantia ORDER BY id DESC");
		while($rp=mysqli_fetch_array($prod)){



			
			$cat = $mysqli->query("SELECT * FROM categorias WHERE id = '".$rp['id_categoria']."'");

			if(mysqli_num_rows($cat)>0){
				$rcat = mysqli_fetch_array($cat);
				$categoria = $rcat['categoria'];
			
			}else{
				$categoria = "--";
			}

			$nama = $mysqli->query("SELECT * FROM autores WHERE Cedula='".$rp['cedula']."'");
			if(mysqli_num_rows($nama)>0){
				$xnama=mysqli_fetch_array($nama);
				$name= $xnama['FullName'];
			}else{
				$name = "--";
			}

			?>
				<tr>
					<td><?=$rp['name']?></td>

				

					<td><?=$rp['cedula']?></td>

					<td><?=$name?></td>

					<td><img src="../ipasantia/<?=$rp['imagen']?>" class="imagen_carro"/></td>


					<td><?=$categoria?></td>
					<td>
						
						<a style="color:#08f" href="?p=modificar_tpasantia&id=<?=$rp['id']?>"><i class="fa fa-edit"></i></a>
						&nbsp;
						<a style="color:#08f" href="?p=agregar_tpasantia&eliminar=<?=$rp['id']?>"><i class="fa fa-times"></i></a>

					</td>
				</tr>
			<?php
		}
	?>

</table>