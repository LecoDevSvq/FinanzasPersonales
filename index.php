<?php
include 'conexion.php';

// Obtener movimientos
$sql = "SELECT * FROM movimientos ORDER BY fecha DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Finanzas Personales</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Control de Ingresos y Gastos</h1>

        <form action="agregar.php" method="post" class="mb-4">
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" step="0.01" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="ingreso">Ingreso</option>
                    <option value="gasto">Gasto</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
            <a href="balance.php" class="btn btn-info">Balance</a>
        </form>

        <h2 class="my-4">Movimientos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $fecha = date("d/m/Y", strtotime($row['fecha']));
                        echo "<tr>
                                <td>{$fecha}</td>
                                <td>{$row['descripcion']}</td>
                                <td>{$row['cantidad']} €</td>
                                <td>{$row['tipo']}</td>
                                <td>
                                <form id='deleteform' action='eliminar.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' class='btn btn-danger btn-sm'><i class='fa-solid fa-circle-minus'></i></button>
                                </form>                               
                            </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay movimientos</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>