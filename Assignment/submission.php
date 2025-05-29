<?php
session_start(); // Start the session to access stored data

$form_data = []; // Initialize an empty array for form data
$display_error = false; // Flag to indicate if data is missing

// Check if form data exists in the session
// The session key is 'form_data_pertukaran' as set in form.php
if (isset($_SESSION['form_data_pertukaran']) && !empty($_SESSION['form_data_pertukaran'])) {
    $form_data = $_SESSION['form_data_pertukaran'];
    // Clear the session data after displaying it, so it's not shown again on refresh
    unset($_SESSION['form_data_pertukaran']);
} else {
    // If no data is found in session, set an error flag
    $display_error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT600 - Ringkasan Permohonan</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="image/uitm_logo.png" alt="UITM Logo" class="uitm-logo">
            <div class="header-text">
                <p>UiTM/ICEPS/JPJ/S3/19</p>
                <p>INSTITUT OF CONTINUING EDUCATION & PROFESSIONAL STUDIES</p>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">My Profile</a></li>
                <li><a href="form.php">Application Form</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="results-display-section">
            <?php if ($display_error): ?>
                <div class="error-message-results">
                    <h2>Ralat: Tiada Data Permohonan Ditemui</h2>
                    <p>Sila isi borang permohonan terlebih dahulu.</p>
                    <a href="form.php" class="back-button">Kembali ke Borang Permohonan</a>
                </div>
            <?php else: ?>
                <div class="results-container">
                    <h2>Butiran Permohonan Anda</h2>
                    <p><strong>Nama Pelajar:</strong> <?php echo htmlspecialchars($form_data['nama_pelajar']); ?></p>
                    <p><strong>No. Pelajar:</strong> <?php echo htmlspecialchars($form_data['no_pelajar']); ?></p>
                    <p><strong>No. Kad Pengenalan:</strong> <?php echo htmlspecialchars($form_data['no_kad_pengenalan']); ?></p>
                    <p><strong>Kod Program:</strong> <?php echo htmlspecialchars($form_data['kod_program']); ?></p>
                    <p><strong>Semester:</strong> <?php echo htmlspecialchars($form_data['semester']); ?></p>
                    <p><strong>Mod Pengajian Semasa:</strong> <?php echo htmlspecialchars($form_data['mod_pengajian_semasa']); ?></p>
                    <p><strong>Taraf Pengajian Semasa:</strong> <?php echo htmlspecialchars(implode(', ', $form_data['taraf_pengajian_semasa'])); ?></p>
                    <p><strong>Kod/Nama Program Dipohon:</strong> <?php echo htmlspecialchars($form_data['program_dipohon']); ?></p>
                    <p><strong>Sesi Pertukaran:</strong> <?php echo htmlspecialchars($form_data['sesi_pertukaran']); ?></p>
                    <p><strong>Tujuan Pertukaran:</strong> <?php echo nl2br(htmlspecialchars($form_data['alasan_permohonan'])); ?></p>
                    <a href="form.php" class="back-button">Kembali ke Borang Permohonan</a>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 UiTM Arau - ICT600 Web Technology & Application</p>
    </footer>
</body>
</html>