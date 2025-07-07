<?php
require 'vendor/autoload.php';

use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Sustituye este valor por el ARN real de tu tópico SNS
    $snsTopicArn = 'arn:aws:sns:us-east-1:642854116542:sns';

    // Inicializa el cliente SNS
    $snsClient = new SnsClient([
        'version' => 'latest',
        'region'  => 'us-east-1'
        // Si necesitas especificar credenciales, añade aquí el array 'credentials'
    ]);

    // Crea el mensaje a enviar
    $messageToSend = json_encode([
        'email' => $email,
        'name' => $name,
        'message' => $message
    ]);

    try {
        // Publica el mensaje en el tópico SNS
        $snsClient->publish([
            'TopicArn' => $snsTopicArn,
            'Message'  => $messageToSend
        ]);

        // Conexión a la base de datos MySQL
        $mysqli = new mysqli("mysql", "my_user", "my_password", "my_database");

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Prepara y ejecuta la consulta
        $stmt = $mysqli->prepare("INSERT INTO form_data (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        $stmt->execute();

        echo "Message sent successfully.";
    } catch (AwsException $e) {
        echo "Error sending message: " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
