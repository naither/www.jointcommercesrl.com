<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $telefono = filter_var(trim($_POST["telefono"]), FILTER_SANITIZE_STRING);
    $mensaje = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    if (empty($nombre) || empty($email) || empty($telefono) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Todos los campos son obligatorios y el email debe ser válido.");
    }

    // Validar reCAPTCHA
    $recaptcha_secret = "n41th3r@1";
    $recaptcha_response = $_POST['n41th3r@1'];
    $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response";
    $recaptcha_verify = file_get_contents($recaptcha_url);
    $recaptcha_data = json_decode($recaptcha_verify);

    if (!$recaptcha_data->success) {
        die("Error: Verificación de reCAPTCHA fallida.");
    }

    // Configurar correo
    $destinatario = "naither@gmail.com";
    $asunto = "Nuevo mensaje de contacto de $nombre";
    $cuerpoMensaje = "Nombre: $nombre\nCorreo: $email\nTeléfono: $telefono\n\nMensaje:\n$mensaje";

    $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

    if (mail($destinatario, $asunto, $cuerpoMensaje, $headers)) {
        echo "Mensaje enviado correctamente.";
    } else {
        echo "Error al enviar el mensaje.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
