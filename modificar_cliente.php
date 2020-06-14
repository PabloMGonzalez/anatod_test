<!DOCTYPE html>
<html lang="es">

<?php 

//conexion con la BD
//require_once 'class.database.php';
require_once 'inc/conn.php';

//recupera los datos de los distintos inputs
function recuperar_datos() {
    global $nombre, $dni, $localidad, $provincia, $cliente_id;
    $nombre=(isset($_POST["nombre"]) && !empty($_POST["nombre"]))? $_POST["nombre"]:"";
    $dni =(isset($_POST["dni"]) && !empty($_POST["dni"]))? $_POST["dni"]:"";
    $localidad=(isset($_POST["localidad"]) && !empty($_POST["localidad"]))? $_POST["localidad"]:"";
    $provincia= (isset($_POST["provincia"]) && !empty($_POST["provincia"]))? $_POST["provincia"]:"";
    $cliente_id=(isset($_POST["cliente_id"]) && !empty($_POST["cliente_id"]))? $_POST["cliente_id"]:""; 
}    	

//funcion q inicia las variables para guardar y/o modificar
function inicializar_vars() {
	global $nombre, $dni, $localidad, $buscar, $provincia, $cliente_id;		
    $nombre=$dni=$localidad=$buscar=$provincia=$cliente_id="";       
}

//crea una lista en el SELECT de todas las provincias
function lista_provincias(&$lista_p, &$nombre_provincia) {
    global $db; 
    global $provincia; 
    $lista_p =  "<select class='data1' id='provincia' name='provincia'>".
                "<option value=0>Seleccione una Provincia</option>";
    $sql = "SELECT * 
                FROM provincias 
            ORDER BY provincia_nombre";
    $rs = $db->query($sql);  

    foreach ($rs as $row) { 
            $seleccionado="";      
            $lista_p .= "<option value='{$row['provincia_id']}'>".($row['provincia_nombre'])."</option>";

            if ($provincia == $row['provincia_nombre'] ) {
                $seleccionado="selected";  
                $lista_p .= "<option value='{$row['provincia_id']}'$seleccionado>".($row['provincia_nombre'])."</option>";
           
            }
        }     
    $lista_p .= "</select>";
    $rs=null;
}

//crea una lista en el SELECT de todas las localidades
function lista_localidades(&$lista_l, &$nombre_localidad) {
    global $db;
    global $localidad;
    $lista_l =  "<select class='data1' id='localidad' name='localidad'>".
                "<option selected>Seleccione una Localidad</option>";
    $sql  = "SELECT * 
                FROM localidades           
            ORDER BY localidad_nombre";
    $rs = $db->query($sql);

    foreach ($rs as $row) { 
            $seleccionado="";       
            $lista_l .= "<option value='{$row['localidad_id']}'>".($row['localidad_nombre'])."</option>";
            if ($localidad == $row['localidad_nombre'] ) {
                $seleccionado="selected";  
                $lista_l .= "<option value='{$row['localidad_id']}'$seleccionado>".($row['localidad_nombre'])."</option>";
            }
        }     
    $lista_l .= "</select>";
    $rs=null;
}

lista_provincias($lista_p,$nombre_provincia);
lista_localidades($lista_l, $nombre_localidad);
inicializar_vars();
recuperar_datos();


$boton = (isset($_POST['enviar']) && !empty($_POST['enviar']))? true:false;
$btn_buscar = (isset($_POST['btn_buscar']) && !empty($_POST['btn_buscar']))? true:false;

if ($boton==true) {
    $sql="UPDATE clientes 
            SET cliente_nombre=?, cliente_dni=?, cliente_localidad=?
            WHERE cliente_id=$cliente_id";
    $sql = $db->prepare($sql);
    $sqlvalue=[$nombre,$dni,$localidad];
    $rs = $sql->execute($sqlvalue);

    if (!$rs) {
        print_r($db->errorInfo());  #desarrollo
    } else {
        header("location modificar_cliente.php");
    }
    $rs=null;
}

if ($btn_buscar==true) {

    $buscar = $_POST['buscar'];
    if ($buscar != "") {
        $sql  = "SELECT clientes.*, provincias.provincia_nombre, localidades.localidad_nombre 
                    FROM clientes
                    INNER JOIN localidades ON localidades.localidad_id=clientes.cliente_localidad   
                    INNER JOIN provincias ON provincias.provincia_id=localidades.localidad_id
                WHERE cliente_dni = '$buscar'";
        $result = $db->query($sql); 
        
        foreach ($result as $reg) {

            $dni = $reg['cliente_dni'];

            if ($dni == $buscar) {
                $cliente_id = $reg['cliente_id'];
                $nombre = $reg['cliente_nombre']; 
                $dni = $reg['cliente_dni'];
                $provincia = $reg['provincia_nombre'];
                $localidad = $reg['localidad_nombre']; 
                lista_provincias($lista_p,$nombre_provincia);
                lista_localidades($lista_l, $nombre_localidad);             
                break;
            }          
        }            
    } 
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="https://kit.fontawesome.com/1afd94d30f.js" crossorigin="anonymous"></script>
    
    <title>Modificar Cliente</title>
</head>

<body>
    <div>
        <div class="formulario">
            <form id="buscar" action="modificar_cliente.php" method="POST">
                <h1>Buscar Cliente <i class="fas fa-search-plus"></i></i></h1>
                    <i class="fas fa-search"></i>                
                    <input class="data1" type="text" id="buscar" name="buscar" placeholder="Buscar por DNI" required>
                    <input id="btn_buscar" name="btn_buscar" type="submit" value="Buscar" class="boton data1">
            </form>
                    <br>
            <form id="datos" action="modificar_cliente.php" method="POST">
                    <h1>Modificar Cliente <i class="fas fa-user-cog"></i></h1>
                    <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$cliente_id?>">
                    <i class="fas fa-signature"></i> <input type="text" class='data1' placeholder="Nombre" name="nombre" id="nombre" value="<?=$nombre?>" maxlength="35"
                        title="Ingrese el nombre" required>
                    <br>
                    <i class="fas fa-passport"></i> <input type="number" class='data1' placeholder="DNI" name="dni" id="dni" value="<?=$dni?>" max="99999999"
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