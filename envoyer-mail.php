<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Inclut PHPMailer. Assurez-vous que le chemin est correct.

// Vérifie si la méthode d'envoi est POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation des champs
    if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['message'])) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Validation de l'email
        $name = htmlspecialchars(trim($_POST['name']));  // Nettoyer et sécuriser le nom
         // Nettoyer le sujet
        $message = htmlspecialchars(trim($_POST['message'])); // Nettoyer le message

        // Vérification que les champs ne sont pas vides après nettoyage
        if ($email && !empty($name) && !empty($message)) {
            $mail = new PHPMailer(true);
            try {
                // Configuration du serveur SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Serveur SMTP de Gmail
                $mail->SMTPAuth = true;
                $mail->Username = 'aymanls822@gmail.com'; // Remplace par ton adresse Gmail
                $mail->Password = 'wtbi olaj gqwm xfcm'; // Remplace par ton mot de passe d’application
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Définir l'expéditeur et le destinataire
                $mail->setFrom('aymanls822@gmail.com', 'Ameur'); // Expéditeur (adresse générique)
                $mail->addAddress('aymanls822@gmail.com'); // Destinataire (remplace par ton email)
                
                // Contenu de l'email
                $mail->isHTML(true);
                // Sujet de l'email
                $mail->Body    = "
                    <h2>Nouvelle question reçue</h2>
                    <p><strong>Nom :</strong> $name</p>
                    <p><strong>Email :</strong> $email</p>
                    
                    <p><strong>Message :</strong><br>" . nl2br($message) . "</p>
                ";

                // Envoi de l'email
                $mail->send();

                // Redirection vers la page de succès
                header("Location: question-succes.html");
                exit;
            } catch (Exception $e) {
                // Redirection vers la page d'erreur en cas d'échec
                header("Location: question-erreur.html");
                exit;
            }
        } else {
            // Redirection vers la page d'erreur si des champs sont invalides
            header("Location: question-erreur.html");
            exit;
        }
    } else {
        // Redirection vers la page d'erreur si les champs ne sont pas envoyés correctement
        header("Location: question-erreur.html");
        exit;
    }
} else {
    // Redirection vers la page d'erreur si la méthode n'est pas POST
    header("Location: question-erreur.html");
    exit;
}
?>
