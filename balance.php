<?php
include 'conexion.php';

// Obtener ingresos y gastos entre fechas
$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : date('Y-m-01');
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : date('Y-m-d');

$sqlIngresos = "SELECT SUM(cantidad) AS total_ingresos FROM movimientos WHERE tipo='ingreso' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
$sqlGastos = "SELECT SUM(cantidad) AS total_gastos FROM movimientos WHERE tipo='gasto' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'";

$resultIngresos = $conn->query($sqlIngresos);
$resultGastos = $conn->query($sqlGastos);

$totalIngresos = $resultIngresos->fetch_assoc()['total_ingresos'] ?? 0;
$totalGastos = $resultGastos->fetch_assoc()['total_gastos'] ?? 0;

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Balance de Finanzas Personales</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Balance de Ingresos y Gastos</h1>

        <form method="post" class="mb-4">
            <div class="form-group">
                <label for="fecha_inicio">Fecha Inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fechaInicio; ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha Fin:</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $fechaFin; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
            <a href="index.php" class="btn btn-info">Volver</a>
        </form>

        <h2 class="my-4">Resumen</h2>
        <ul class="list-group">
            <li class="list-group-item">Total Ingresos: <?php echo number_format($totalIngresos, 2); ?> €</li>
            <li class="list-group-item">Total Gastos: <?php echo number_format($totalGastos, 2); ?> €</li>
            <li class="list-group-item">Balance: <?php echo number_format($totalIngresos - $totalGastos, 2); ?> €</li>
        </ul>

        <h2 class="my-4">Gráfica</h2>
        <canvas id="balanceChart" width="400" height="200"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('balanceChart').getContext('2d');
        var balanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Ingresos', 'Gastos'],
                datasets: [{
                    label: 'Cantidad (€)',
                    data: [<?php echo $totalIngresos; ?>, <?php echo $totalGastos; ?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
