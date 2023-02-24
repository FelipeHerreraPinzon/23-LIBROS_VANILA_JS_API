<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; 
$usuario = "root"; 
$contrasenia = ""; 
$nombreBaseDatos = "libros_bd";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $sqlLibros = mysqli_query($conexionBD,"SELECT * FROM libros WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlLibros) > 0){
        $libros = mysqli_fetch_all($sqlLibros,MYSQLI_ASSOC);
        echo json_encode($libros);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlLibros = mysqli_query($conexionBD,"DELETE FROM libros WHERE id=".$_GET["borrar"]);
    if($sqlLibros){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos de nombre y correo
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $nombre=$data->nombre;
    $categoria=$data->categoria;
    $autor=$data->autor;
        if(($nombre!="")&&($categoria!="")&&($autor!="")){
            
    $sqlLibros = mysqli_query($conexionBD,"INSERT INTO libros(nombre,categoria,autor) VALUES('$nombre','$categoria','$autor') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $nombre=$data->nombre;
    $categoria=$data->categoria;
    $autor=$data->autor;
    
    $sqlLibros = mysqli_query($conexionBD,"UPDATE libros SET nombre='$nombre',categoria='$categoria',autor='$autor' WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla empleados
$sqlLibros = mysqli_query($conexionBD,"SELECT * FROM libros ");
if(mysqli_num_rows($sqlLibros) > 0){
    $libros = mysqli_fetch_all($sqlLibros,MYSQLI_ASSOC);
    echo json_encode($libros);
}
else{ echo json_encode([["success"=>0]]); }


?>
