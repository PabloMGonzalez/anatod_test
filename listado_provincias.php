<!DOCTYPE html>
<html lang="es">

<?php
//conexion con la BD
//require_once 'class.database.php';
require_once 'inc/conn.php';
//devuelve la cantidad de clientes por localidad y provincia
    $sql = "SELECT provincias.*, localidades.localidad_nombre, count(clientes.cliente_id) 'cant_clientes'
                FROM provincias                
                INNER JOIN localidades ON localidades.localidad_provincia=provincias.provincia_id
	            INNER JOIN clientes ON clientes.cliente_localidad=localidades.localidad_id             
            GROUP BY provincias.provincia_nombre";
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
    <title>Listado de Provincias</title>
</head>

<body>   
    <div class="background">
        <h1 align="center">Listado de Provincias <i class="fas fa-globe-americas"></i></h1>
        <table class="tabla">
            <tr>
                <th class="titulo"><i class="far fa-lightbulb"></i> ID Provincia</th>
                <th class="titulo"><i class="fas fa-globe-americas"></i> Provincia</th>
                <th class="titulo"><i class="fas fa-map-marker-alt"></i> Localidad</th>
                <th class="titulo"><i class="fas fa-calculator"></i> Cantidad Clientes</th>                          
            </tr>

            <?php                
                if($rs) {
                    foreach ($rs as $reg) {
                        $provincia = $reg['provincia_id'];                        
            ?>    
                <tr>                   
                    <td class="data" align="center"><?=$reg['provincia_id']?></td>
                    <td class="data" align="center"><?=$reg['provincia_nombre']?></td>
                    <td class="data" align="center"><?=$reg['localidad_nombre']?></td>
                    <td class="data" align="center"><?=$reg['cant_clientes']?></td>                   
                </tr> 
            <?php               
                    }        
                }       
            ?>                             
        </table>
    </div>
</body>

</html>