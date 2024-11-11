<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Inclut PHPMailer

// Vérifie si la méthode d'envoi est POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère les valeurs des champs du formulaire
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
    $sujet = isset($_POST['sujet']) ? $_POST['sujet'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($email) || empty($sujet) || empty($message)) {
        // Si un champ est manquant, renvoie une erreur
        $response['status'] = 'error';
        $response['msg'] = 'Tous les champs sont obligatoires.';
        echo json_encode($response);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Si l'email n'est pas valide, renvoie une erreur
        $response['status'] = 'error';
        $response['msg'] = 'L\'adresse email est invalide.';
        echo json_encode($response);
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aymanls822@gmail.com'; // Remplace par ton email
        $mail->Password = 'wtbi olaj gqwm xfcm'; // Remplace par ton mot de passe ou mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Définir l'expéditeur et le destinataire
        $mail->setFrom($email, "$nom $prenom");
        $mail->addAddress('aymanls822@gmail.com'); // Remplace par ton email de réception

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "Demande de devis : $sujet";
        $mail->Body = "
            <h2>Nouvelle demande de devis</h2>
            <p><strong>Nom :</strong> $nom $prenom</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Téléphone :</strong> $telephone</p>
            <p><strong>Sujet :</strong> $sujet</p>
            <p><strong>Message :</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
        ";

        // Envoyer l'email
        $mail->send();

        // Redirection vers la page de succès si l'envoi est réussi
        header("Location: devis-succes.html");
        exit;
    } catch (Exception $e) {
        // Redirection vers la page d'erreur en cas d'échec
        header("Location: devis-erreur.html");
        exit;
    }
} else {
    // Si la méthode n'est pas POST, redirige vers la page d'erreur
    header("Location: devis-erreur.html");
    exit;
}
?>
