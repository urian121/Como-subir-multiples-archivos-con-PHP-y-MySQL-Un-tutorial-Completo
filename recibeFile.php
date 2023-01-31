<?php
include('configBD.php');
//ucwords pasar a mayúsculas solo la primera letra de toda la cadena
$propietario    = ucwords($_POST['propietario']);
//strtoupper Para pasar a Mayuscula
$placa          = trim(strtoupper($_POST['placa']));

//Verificando si existe el directorio
$dirLocal = "files_cars";
if (!file_exists($dirLocal)) {
    mkdir($dirLocal, 0777, true);
}
$miDir         = opendir($dirLocal); //Habro el directorio


if(isset($_POST['submit']) && count($_FILES['fotos_cars']['name'])>0){

// Recorrer cada archivo subido
foreach ($_FILES['fotos_cars']['name'] as $i => $name) {
  //strlen métod de php pues devuelve la longitud de una cadena
  if (strlen($_FILES['fotos_cars']['name'][$i]) > 1) {
  
  $fileName          = $_FILES['fotos_cars']['name'][$i];
  $sourceFoto        = $_FILES['fotos_cars']['tmp_name'][$i];
  $tamanoFoto        = $_FILES["fotos_cars"]['size'][$i];
  $restricciontamano = "500";//MB
  if((($tamanoFoto/1024)/1024)<=$restricciontamano){

  /**Renombrando cada foto que llega desde el formulario */
  $nuevoNombreFile    = substr(md5(uniqid(rand())),0,15);
  $extension_foto     = pathinfo($fileName, PATHINFO_EXTENSION);
  $nombreFoto         = $nuevoNombreFile.'_'.$placa.'.'.$extension_foto;


  $resultadoFotos     = $dirLocal.'/'.$nombreFoto;

    // Mover archivo a una ubicación permanente
    move_uploaded_file($sourceFoto, $resultadoFotos);
  
    // Insertar información del archivo en la base de datos
    $sql = "INSERT INTO fotos_cars (foto, placa_cliente) VALUES ('{$nombreFoto}', '{$placa}')";
    mysqli_query($conn, $sql);
    
  }else{
    echo'<p style="color:red">Existe una foto que supera el peso Maximo de '.$tamanoFoto.'</p>';
  }
}
}

/**Nota:Obvio no se puede meter este INSERT dentro del Foreach, por que crearía el mismo clientes
 * la n cantidad de veces de acuerda al numero de imagenes que se esten cargando, solo aplicaría
 * para cuando se carga una sola imagen.
 */
$sql = "INSERT INTO clientes (propietario, placa) VALUES ('{$propietario}', '{$placa}')";
mysqli_query($conn, $sql);


}
// Cerrar conexión a la base de datos
mysqli_close($conn);

// Redirigir a la página de inicio
header("Location: index.php");
