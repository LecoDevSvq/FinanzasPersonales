<?php
include 'conexion.php';

$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$tipo = $_POST['tipo'];
$fecha = $_POST['fecha'];

$sql = "INSERT INTO movimientos (descripcion, cantidad, tipo, fecha) VALUES ('$descripcion', '$cantidad', '$tipo', '$fecha')";

if ($conn->query($sql) === TRUE) {
    header('Location: index.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
