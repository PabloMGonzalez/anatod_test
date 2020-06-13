<!DOCTYPE html>
<html lang="es">

<?php 

//conexion con la BD
//require_once 'class.database.php';
require_once 'inc/conn.php';

//recupera los datos de los distintos imputs
function recuperar_datos() {
    global $nombre, $dni, $localidad;
    $nombre=(isset($_POST["nombre"]) && !empty($_POST["nombre"]))? $_POST["nombre"]:"";
    $dni =(isset($_POST["dni"]) && !empty($_POST["dni"]))? $_POST["dni"]:"";
    $localidad=(isset($_POST["localidad"]) && !empty($_POST["localidad"]))? $_POST["localidad"]:"";  
}    	

//funcion q inicia las variables para guardar y/o modificar
function inicializar_vars() {
	global $nombre, $dni, $localidad;		
    $nombre=$dni=$localidad="";       
}

//crea una lista en el SELECT de todas las provincias
function lista_provincias(&$lista_p, &$nombre_provincia) {
    global $db;  
    $lista_p =  "<select class='data1' id='provincia' name='provincia'>".
                "<option value=0>Seleccione una Provincia</option>";
    $sql = "SELECT * 
                FROM provincias 
            ORDER BY provincia_nombre";
    $rs = $db->query($sql);  

    foreach ($rs as $row) {       
            $lista_p .= "<option value='{$row['provincia_id']}'>".($row['provincia_nombre'])."</option>";
        }     
    $lista_p .= "</select>";
    $rs=null;
}

//crea una lista en el SELECT de todas las localidades
function lista_localidades(&$lista_l, &$nombre_localidad) {
    global $db;
    $lista_l =  "<select class='data1' id='localidad' name='localidad'>".
                "<option disabled selected>Seleccione una Localidad</option>";
    $sql  = "SELECT * 
                FROM localidades           
            ORDER BY localidad_nombre";
    $rs = $db->query($sql);

    foreach ($rs as $row) {        
            $lista_l .= "<option value='{$row['localidad_id']}'>".($row['localidad_nombre'])."</option>";
        }     
    $lista_l .= "</select>";
    $rs=null;
}

lista_provincias($lista_p,$nombre_provincia);
lista_localidades($lista_l, $nombre_localidad);
inicializar_vars();
recuperar_datos();

$boton = (isset($_POST['enviar']) && !empty($_POST['enviar']))? true:false;

if ($boton==true) {
    $sql = "INSERT INTO clientes(cliente_nombre,cliente_dni,cliente_localidad) VALUES(?,?,?)"; 
    $sql = $db->prepare($sql);
    $sqlvalue=[$nombre,$dni,$localidad];
    $rs = $sql->execute($sqlvalue);

    if (!$rs) {
        print_r($db->errorInfo());  
    } else {
        header("location:index.php");   
    }
    $rs=null;
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="https://kit.fontawesome.com/1afd94d30f.js" crossorigin="anonymous"></script>    
    <title>Alta Cliente</title>
</head>

<body>
    <div>
        <div class="formulario">
            <form id="datos" action="index.php" method="POST">
                <h1>Alta Cliente <i class="fas fa-user-clock"></i></h1>

                <i class="fas fa-signature"></i> <input type="text" class='data1' placeholder="Nombre" name="nombre" id="nombre" value="" maxlength="35"
                    title="Ingrese el nombre" required>
                    <br>
                <i class="fas fa-passport"></i> <input type="number" class='data1' placeholder="DNI" name="dni" id="dni" value="" max="99999999"
                    title="Ingrese su DNI" required>
                    <br>
                <i class="fas fa-globe-americas"></i><?=$lista_p?>
                    <br>
                <i class="fas fa-map-marker-alt"></i><?=$lista_l?>               

                <input class="boton data1" type="submit" name="enviar" id="enviar" value="Enviar Datos">

            </form>
        </div>
    </div>
</body>

</html>