<?php
$host     = "localhost";
$user     = "root";
$password = ""; 
$dbname   = "tienda";

$conn = new mysqli($host, $user, $password, $dbname);

$connection_error = "";
if ($conn->connect_error) {
    $connection_error = "Error de conexión: " . $conn->connect_error;
}

$sql = $_POST['query'] ?? '';
$result = null;
$query_error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($sql) && !$connection_error) {
    $result = $conn->query($sql);
    if ($result === false) {
        $query_error = "Error en la consulta SQL: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consola de Consultas SQL</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f6f9; color: #333; }
        h1 { color: #2c3e50; margin-bottom: 5px; }
        
        .user-badge { 
            display: inline-block; 
            background-color: #e2e8f0; 
            color: #475569; 
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 14px; 
            font-weight: bold; 
            margin-top: 0; 
            margin-bottom: 25px; 
            border: 1px solid #cbd5e1; 
        }

        textarea { width: 100%; height: 120px; font-family: monospace; font-size: 14px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { margin-top: 10px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-size: 15px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .alert { padding: 12px; margin-top: 15px; border-radius: 4px; font-weight: bold; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        th, td { border: 1px solid #dee2e6; padding: 10px; text-align: left; }
        th { background-color: #343a40; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Consola de Consultas SQL</h1>
    <div class="user-badge">Usuario: <?php echo htmlspecialchars($user); ?></div>
    <div class="user-badge">Base de Datos: <?php echo htmlspecialchars($dbname); ?></div>


    <form method="POST" action="">
        <label for="query"><strong>Ingresa tu sentencia SQL:</strong></label><br><br>
        <textarea name="query" id="query" placeholder="Introduce una sentencia SQL para ver los resultados abajo. Ejemplo: SELECT * FROM user;"><?php echo htmlspecialchars($sql); ?></textarea><br>
        <button type="submit">Ejecutar Consulta</button>
    </form>

    <?php if ($connection_error): ?>
        <div class="alert error"><?php echo $connection_error; ?></div>
    <?php endif; ?>

    <?php if ($query_error): ?>
        <div class="alert error"><?php echo $query_error; ?></div>
    <?php endif; ?>

    <h2>Resultados <?php if ($result && is_object($result)) { echo "(" . $result->num_rows . " filas encontradas)"; } ?></h2>

    <?php if ($result && is_object($result)): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <?php 
                        while ($field = $result->fetch_field()) {
                            echo "<th>" . htmlspecialchars($field->name) . "</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $cell) {
                            echo "<td>" . htmlspecialchars($cell ?? 'NULL') . "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($result === true): ?>
        <div class="alert success">Consulta ejecutada correctamente (comando DDL/DML aplicado).</div>
    <?php endif; ?>

</body>
</html>