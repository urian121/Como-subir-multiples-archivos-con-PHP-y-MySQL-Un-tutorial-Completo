<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subir archivos con PHP</title>
  <link rel="stylesheet" href="assets/css/home.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>

<body>

<div class="container">
  <div class="row justify-content-md-center mt-5">
    <div class="col-md-12">
      <h2 class="text-center  font-weight-bold">Datos del Vehículo <hr></h2>
  </div>

<div class="col-md-5">
    <form action="recibeFile.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="propietario">Propietario</label>
        <input type="text" name="propietario" class="form-control" >
      </div>
      <div class="form-group">
        <label for="Placa">Placa</label>
        <input type="text" name="placa" class="form-control">
      </div>
      <div class="form-group">
        <label for="fotos_cars">Fotos del Vehículo</label>
        <input type="file"  name="fotos_cars[]" multiple accept="image/*"  class="form-control-file">
      </div>
      <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Enviar Formulario</button>
    </form>
</div>

<div class="col-md-7">
<?php
include('configBD.php');
$sqlQuery = "SELECT  c.*, c.id AS idCliente, f.* FROM clientes AS c
            INNER JOIN fotos_cars AS f
            ON c.placa = f.placa_cliente
            ORDER BY c.fecha DESC"; 
$resultadoSQL = mysqli_query($conn, $sqlQuery);  
if(mysqli_num_rows($resultadoSQL) > 0){
?>
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Propietario</th>
        <th scope="col">Placa</th>
        <th scope="col">Fotos</th>
      </tr>
    </thead>
    <tbody>
  <?php
  $count = 1;
   while($Data = mysqli_fetch_array($resultadoSQL)){ ?> 
      <tr>
        <th scope="row"><?php echo $count++; ?></th>
        <td><?php echo $Data['propietario']; ?></td>
        <td><?php echo $Data['placa']; ?></td>
        <td> <a href="ver_fotos.php?idFoto=<?php echo $Data['idCliente']; ?>">Ver Fotos</a></td>
      </tr>
      <?php } ?>
  </table>
</div>
<?php
}else{ ?>
  <p class="sinResultados">No hay Resultados</p>
<?php }?>

</div>

</div>
</div>



</body>
</html>