<?php

    // Only process POST requests.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
		$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = strip_tags(trim($_POST["phone"]));
        $message = strip_tags(trim($_POST["message"]));


        // Check that data was sent to the mailer.
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! Il y a eu un problème avec votre soumission. Veuillez compléter le formulaire et réessayer.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "zannmoos@gmail.com";

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
		$email_content .= "Phone Number: $phone\n";
		$email_content .= "Message: $message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // $handle = mail($recipient, $subject, $email_content, $email_headers);
        // var_dump($handle);
        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            header('HTTP/1.0 200 OK');
            echo "Merci ! Votre message a été envoyé.";
        } else {
            // Set a 500 (internal server error) response code.
            header('HTTP/1.1 500 Erreur interne du serveur');
            echo "Oops! Un problème est survenu et nous n'avons pas pu envoyer votre message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        header('HTTP/1.1 403 Error inconnue');
        echo "Il y a eu un problème avec votre demande, veuillez réessayer encore.";
    }

?>

