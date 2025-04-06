<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "tu-email@dominio.com";
    $subject = "Nueva Propiedad Registrada";
    
    // Recoge todos los datos del formulario
    $message = "<h2>Nueva Propiedad Registrada</h2><table>";
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            $value = implode(", ", $value);
        }
        $message .= "<tr><td><strong>" . htmlspecialchars($key) . "</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
    }
    $message .= "</table>";
    
    // Para archivos adjuntos (opcional)
    if (!empty($_FILES)) {
        $message .= "<h3>Archivos Adjuntos</h3><ul>";
        foreach ($_FILES as $file) {
            if ($file['error'] == UPLOAD_ERR_OK) {
                $message .= "<li>" . htmlspecialchars($file['name']) . " (" . $file['size'] . " bytes)</li>";
            }
        }
        $message .= "</ul>";
    }
    
    // Cabeceras del correo
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: formulario@tusitio.com\r\n";
    $headers .= "Reply-To: " . $_POST['ownerEmail'] . "\r\n";
    
    // Envía el correo
    if (mail($to, $subject, $message, $headers)) {
        header("Location: gracias.html");
    } else {
        header("Location: error.html");
    }
    exit;
}
?>