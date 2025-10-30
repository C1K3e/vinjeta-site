<?php
// --- POST metoda
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Konfiguracija
    $to = "vinjeta@teol.net"; // OVDE STAVI SVOJ EMAIL
    $subject = "Nova poruka sa web forme";
    $uploads_dir = "uploads"; // folder za fajlove
    $max_file_size = 5 * 1024 * 1024; // 5 MB po fajlu
    $allowed_extensions = ['txt','pdf','doc','docx','jpg','jpeg','png','svg','xlsx','ai'];

    // --- Sanitizacija i validacija
    $ime = htmlspecialchars($_POST['naziv']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $poruka = htmlspecialchars($_POST['poruka']);

    if (!$email) {
        die("Neispravan e-mail.");
    }

    // --- Slanje e-maila
    $body = "Ime/Naziv: $ime\nEmail: $email\nPoruka:\n$poruka";
    $mail_sent = mail($to, $subject, $body);

    // --- Upload fajlova
    $uploaded_files = [];
    if (!empty($_FILES['prilog']['name'][0])) {
        if (!is_dir($uploads_dir)) mkdir($uploads_dir, 0755, true);

        foreach ($_FILES['prilog']['tmp_name'] as $key => $tmp_name) {
            $filename = basename($_FILES['prilog']['name'][$key]);
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            // --- Provera ekstenzije i veličine
            if (!in_array($ext, $allowed_extensions)) continue;
            if ($_FILES['prilog']['size'][$key] > $max_file_size) continue;

            $target_file = $uploads_dir . "/" . $filename;
            if (move_uploaded_file($tmp_name, $target_file)) {
                $uploaded_files[] = $filename;
            }
        }
    }

    // --- Poruka korisniku
    if ($mail_sent) {
        echo "<p>Poruka poslana! Fajlovi: " . implode(", ", $uploaded_files) . "</p>";
    } else {
        echo "<p>Greška pri slanju poruke.</p>";
    }
}
?>