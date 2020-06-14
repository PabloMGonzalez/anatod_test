<?php 

require_once 'inc/conn.php';

$conexion=mysqli_connect('anatodtest.c75o4mima6rb.us-east-1.rds.amazonaws.com','test','test5678','test_anatod');
$provincia=$_POST['provincia'];
	
	$sql = "SELECT localidades.localidad_nombre
				from provincias
    			inner join localidades on localidades.localidad_provincia=provincias.provincia_id
			where provincias.provincia_id=$provincia";

	$result=mysqli_query($conexion,$sql);

	$cadena="<select class='data1' id='localidad' name='localidad'>";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value='.$ver[0].'>'.($ver[0]).'</option>';
	}

	echo  $cadena."</select>";
	

?>