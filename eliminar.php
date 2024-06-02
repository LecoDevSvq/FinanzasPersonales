<?php
include 'conexion.php';

$id = $_POST['id'];

$sql = "DELETE FROM movimientos WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Movimiento eliminado correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header('Location: index.php');
?>
