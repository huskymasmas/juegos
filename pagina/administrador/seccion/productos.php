<?php include("../template/cab.php");?>
<?php
$txtID=(isset($_POST["txtID"]))?$_POST["txtID"]:"";
$txtnombre=(isset($_POST["txtnombre"]))?$_POST["txtnombre"]:"";
$accion=(isset($_POST["accion"]))?$_POST["accion"]:"";




include("../confi/db.php");
switch($accion){

    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO juegos (nombre) VALUES (:nombre);");
        $sentenciaSQL->bindparam(':nombre', $txtnombre);
        $sentenciaSQL->execute();
        break;

        case "Modificar":
            $sentenciaSQL = $conexion->prepare("UPDATE juegos SET nombre =:nombre WHERE id = :id");
            $sentenciaSQL->bindParam(':nombre', $txtnombre);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
           
        break;

        case "Seleccionar":
            $sentenciaSQL = $conexion->prepare("SELECT * FROM juegos WHERE id = :id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $juego = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtnombre = $juego['nombre'];
            break;

        break;
        case "Borrar":
            $sentenciaSQL = $conexion->prepare("DELETE FROM juegos WHERE id = :id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
        break;
}
$sentenciaSQL = $conexion->prepare("SELECT * FROM juegos");
$sentenciaSQL->execute();
$listajuegos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos de Juego
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID</label>
                    <input type="text" class="form-control" value ="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Nombre</label>
                    <input type="text" class="form-control" value ="<?php echo $txtnombre; ?>" name="txtnombre" id="txtnombre" placeholder="Nombre del Juego">
                </div>
                
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-7">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($listajuegos as $juego) { ?>
            <tr>
                <td><?php echo $juego['id']; ?></td>
                <td><?php echo $juego['nombre']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $juego['id']; ?>"/>
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include("../template/pie.php") ?>