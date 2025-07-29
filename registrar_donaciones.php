<?php
// Incluir archivo de conexión
require_once 'conexion.php';

// Obtener donantes usando PDO
$stmt_donantes = $conexion->query("SELECT id_donante, nombre FROM DONANTE");
$donantes = $stmt_donantes->fetchAll(PDO::FETCH_ASSOC);

// Obtener proyectos usando PDO
$stmt_proyectos = $conexion->query("SELECT id_proyecto, nombre FROM PROYECTO");
$proyectos = $stmt_proyectos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Donaciones</title>
  <style>
    .proyecto-item {
      border: 1px solid #ccc;
      padding: 10px;
      margin: 5px 0;
      background-color: #f9f9f9;
    }
    .proyecto-item input[type="checkbox"] {
      margin-right: 10px;
    }
    .proyecto-item input[type="number"] {
      width: 100px;
      margin-left: 10px;
    }
  </style>
  <script>
    function toggleMonto(checkbox, montoInput) {
      if (checkbox.checked) {
        montoInput.disabled = false;
        montoInput.required = true;
        montoInput.focus();
      } else {
        montoInput.disabled = true;
        montoInput.required = false;
        montoInput.value = '';
      }
    }
  </script>
</head>
<body>
  <h2>Registrar Donación</h2>
  <form action="procesar_donacion.php" method="post">
    <label for="donante">Donante:</label><br>
    <select name="id_donante" required>
      <option value="">Seleccione un donante</option>
      <?php foreach ($donantes as $row): ?>
        <option value="<?= $row['id_donante'] ?>"><?= $row['nombre'] ?></option>
      <?php endforeach; ?>
    </select><br><br>

    <label>Proyectos y montos a donar:</label><br>
    <div style="border: 1px solid #ddd; padding: 15px; max-height: 300px; overflow-y: auto;">
      <?php foreach ($proyectos as $row): ?>
        <div class="proyecto-item">
          <input type="checkbox" 
                 name="proyectos_seleccionados[]" 
                 value="<?= $row['id_proyecto'] ?>"
                 id="proyecto_<?= $row['id_proyecto'] ?>"
                 onchange="toggleMonto(this, document.getElementById('monto_<?= $row['id_proyecto'] ?>'))">
          <label for="proyecto_<?= $row['id_proyecto'] ?>">
            <strong><?= htmlspecialchars($row['nombre']) ?></strong>
          </label>
          <br>
          <label for="monto_<?= $row['id_proyecto'] ?>">Monto: $</label>
          <input type="number" 
                 name="montos[<?= $row['id_proyecto'] ?>]" 
                 id="monto_<?= $row['id_proyecto'] ?>"
                 step="0.01" 
                 min="0.01"
                 disabled
                 placeholder="0.00">
        </div>
      <?php endforeach; ?>
    </div>
    <small>* Seleccione los proyectos y especifique el monto para cada uno</small><br><br>

    <label for="fecha">Fecha de donación:</label><br>
    <input type="date" name="fecha" required><br><br>

    <button type="submit">Registrar Donación</button>
  </form>
</body>
</html>
