<!DOCTYPE html>
<html lang="es">

<?php
//conexion con la BD
//require_once 'class.database.php';
require_once 'inc/conn.php';

//devuelve todos los clientes de la BD, junto con sus provincias y localidades
    $sql = "SELECT clientes.*, provincias.*, localidades.* 
                FROM clientes                
                INNER JOIN localidades ON localidades.localidad_id=clientes.cliente_localidad  
                INNER JOIN provincias ON provincias.provincia_id=localidades.localidad_provincia              
            ORDER BY cliente_nombre";
    $rs = $db->query($sql);  

    if (!$rs) {
        print_r($db->errorInfo());        
    }                
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="https://kit.fontawesome.com/1afd94d30f.js" crossorigin="anonymous"></script>
    <title>Listado de Clientes</title>
</head>

<body>   
    <div class="background">
        <h1 align="center">Listado de Clientes <i class="fas fa-users"></i></h1>
        <table class="tabla">
            <tr>
                <th class="titulo"><i class="fas fa-fingerprint"></i> ID Cliente</th>
                <th class="titulo"><i class="fas fa-signature"></i> Nombre</th>
                <th class="titulo"><i class="fas fa-passport"></i> DNI</th>
                <th class="titulo"><i class="fas fa-globe-americas"></i> Provincia</th>
                <th class="titulo"><i class="fas fa-map-marker-alt"></i> Localidad</th>             
            </tr>

            <?php
                if($rs) {
                    foreach ($rs as $reg) {
                        $cliente = $reg['cliente_id'];
            ?>    
                <tr>                   
                    <td class="data" align="center"><?=$reg['cliente_id']?></td>
                    <td class="data" align="center"><?=$reg['cliente_nombre']?></td>
                    <td class="data" align="center"><?=$reg['cliente_dni']?></td>
                    <td class="data" align="center"><?=$reg['provincia_nombre']?></td>
                    <td class="data" align="center"><?=$reg['localidad_nombre']?></td>
                </tr> 
            <?php               
                    }        
                }       
            ?>                             
        </table>
    </div>
</body>

</html>