<?php
// 1. Conexión a la Base de Datos MySQL
$conexion = new mysqli("localhost", "root", "", "ubika");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 2. Capturar los datos enviados por el formulario
$titulo = $_POST['titulo'];
$categoria_id = $_POST['categoria_id'];
$tipo_precio = $_POST['tipo_precio'];
$precio = !empty($_POST['precio']) ? $_POST['precio'] : NULL;
$descripcion = $_POST['descripcion'];
$empresa_id = 1; // ID de ejemplo del comerciante logueado

// 3. Generar el Slug automáticamente a partir del título
function crearSlug($texto) {
    $slug = strtolower(trim($texto));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', "-", $slug);
    return trim($slug, '-');
}
$slug = crearSlug($titulo);



// 5. Insertar los datos en la Base de Datos (SQL)
$sql = "INSERT INTO productos (empresa_id, categoria_id, titulo, slug, descripcion, precio, tipo_precio, imagen_url) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("iissdsss", $empresa_id, $categoria_id, $titulo, $slug, $descripcion, $precio, $tipo_precio, $ruta_destino);

if ($stmt->execute()) {
    echo "¡Producto publicado con éxito en Ubika.pe!";
    // Redirigir al catálogo o perfil de empresa
} else {
    echo "Error al publicar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>