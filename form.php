<?php
session_start(); // Start the session at the very beginning

$name = $studentId = $studentIC = $kod_program = $semester = "";
$modePeg = ""; // For radio button
$taraf_pengajian_semasa = []; // For checkboxes, initialize as empty array

$program_dipohon = $mod_pengajian_baru = $sesi_pertukaran = $alasan_permohonan = "";

// 2. Initialize ALL error variables with empty values
//    'alamat_suratErr' removed
$namerErr = $studentIdErr = $studentICErr = $kod_programErr = $semesterErr = "";
$modePegErr = $taraf_pengajian_semasaErr = "";
$program_dipohonErr = $mod_pengajian_baruErr = $sesi_pertukaranErr = $alasan_permohonanErr = "";

$form_valid_php = true; // Flag to track if all PHP validation passes
$success_message = ""; // Variable to hold success message

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Nama Pelajar
  if (empty($_POST["name"])) {
    $nameErr = "Nama Pelajar diperlukan.";
    $form_valid_php = false;
  } else {
    $name = htmlspecialchars($_POST["name"]);
    // Optional: Add regex for name if needed (e.g., only letters and spaces)
    if (!preg_match("/^[a-zA-Z\s.-]+$/", $name)) {
        $nameErr = "Nama hanya boleh mengandungi huruf, ruang, titik atau sengkang.";
        $form_valid_php = false;
    }
  }

  // No. Pelajar
  if (empty($_POST["studentId"])) {
    $studentIdErr = "No. Pelajar diperlukan.";
    $form_valid_php = false;
  } else {
    $studentId = htmlspecialchars($_POST["studentId"]);
    // Optional: Add regex for student ID if specific format (e.g., only digits)
    if (!preg_match("/^\d+$/", $studentId)) {
        $studentIdErr = "No. Pelajar mesti nombor.";
        $form_valid_php = false;
    }
  }

  // No. Kad Pengenalan
  if (empty($_POST["studentIC"])) {
    $studentICErr = "No. Kad Pengenalan diperlukan.";
    $form_valid_php = false;
  } else {
    $studentIC = htmlspecialchars($_POST["studentIC"]);
    // Must be exactly 12 digits
    if (!preg_match("/^\d{12}$/", $studentIC)) {
        $studentICErr = "No. Kad Pengenalan mestilah 12 digit.";
        $form_valid_php = false;
    }
  }

  // Kod Program
  if (empty($_POST["kod_program"])) {
    $kod_programErr = "Kod Program diperlukan.";
    $form_valid_php = false;
  } else {
    $kod_program = htmlspecialchars($_POST["kod_program"]);
  }

  // Semester
  if (empty($_POST["semester"])) {
    $semesterErr = "Semester diperlukan.";
    $form_valid_php = false;
  } else {
    $semester = htmlspecialchars($_POST["semester"]);
    // Must be digits
    if (!preg_match("/^\d+$/", $semester)) {
        $semesterErr = "Semester mesti nombor.";
        $form_valid_php = false;
    }
  }

  // Mod Pengajian Semasa (Radio Button)
  if (empty($_POST["modePeg"])) {
    $modePegErr = "Mod Pengajian Semasa diperlukan.";
    $form_valid_php = false;
  } else {
    $modePeg = htmlspecialchars($_POST["modePeg"]);
  }

  // Taraf Pengajian Semasa (Checkboxes)
  if (empty($_POST["taraf_pengajian_semasa"])) {
    $taraf_pengajian_semasaErr = "Taraf Pengajian Semasa diperlukan.";
    $form_valid_php = false;
  } else {
    $taraf_pengajian_semasa = $_POST["taraf_pengajian_semasa"]; // This is an array
    // Sanitize each selected value in the array
    foreach ($taraf_pengajian_semasa as $key => $value) {
        $taraf_pengajian_semasa[$key] = htmlspecialchars($value);
    }
  }

  // Kod/Nama Program (dipohon)
  if (empty($_POST["program_dipohon"])) {
    $program_dipohonErr = "Kod/Nama Program yang dipohon diperlukan.";
    $form_valid_php = false;
  } else {
    $program_dipohon = htmlspecialchars($_POST["program_dipohon"]);
  }

  // Sesi Pertukaran
  if (empty($_POST["sesi_pertukaran"])) {
    $sesi_pertukaranErr = "Sesi Pertukaran diperlukan.";
    $form_valid_php = false;
  } else {
    $sesi_pertukaran = htmlspecialchars($_POST["sesi_pertukaran"]);
  }

  // Tujuan Pertukaran (Alasan Permohonan)
  if (empty($_POST["alasan_permohonan"])) {
    $alasan_permohonanErr = "Tujuan Pertukaran diperlukan.";
    $form_valid_php = false;
  } else {
    $alasan_permohonan = htmlspecialchars($_POST["alasan_permohonan"]);
  }

  // --- Final Check and Redirect ---
  if ($form_valid_php) {
    // Store all validated data in session (using a new key for this form's data)
    $_SESSION['form_data_pertukaran'] = [
        'namae' => $name,
        'studentId' => $studentId,
        'studentIC' => $studentIC,
        'kod_program' => $kod_program,
        'semester' => $semester,
        'modePeg' => $modePeg,
        'taraf_pengajian_semasa' => $taraf_pengajian_semasa, // This is an array
        'program_dipohon' => $program_dipohon,
        'sesi_pertukaran' => $sesi_pertukaran,
        'alasan_permohonan' => $alasan_permohonan
    ];
    // Set a success message
    $success_message = "Permohonan anda telah berjaya dihantar!";
    
    // OPTIONAL: Clear form fields after successful submission
    $name = $studentId = $studentIC = $kod_program = $semester = "";
    $mod_pengajian_semasa = "";
    $taraf_pengajian_semasa = [];
    $program_dipohon = $sesi_pertukaran = $alasan_permohonan = "";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT600 - Borang Permohonan Pertukaran Program</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <header>
        <div class="header-content">
            <img src="image/uitm logo.png" alt="UITM Logo" class="uitm-logo"> 
            <div class="header-text">
                <p>UiTM/ICEPS/JPJ/S3/19</p>
                <p>INSTITUT OF CONTINUING EDUCATION & PROFESSIONAL STUDIES</p>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="profile.html">My Profile</a></li>
                <li><a href="form.php">Application Form</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="application-form-section">
            <h1>BORANG PERMOHONAN PERTUKARAN PROGRAM</h1>

            <div class="form-section instructions-section">
                <div class="study-modes-table">
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="transfer-application-form"> 
                <div class="form-section student-details-section">
                    <h2>BUTIRAN PELAJAR</h2>
                    <div class="form-grid">
                        <div class="form-group <?php echo (!empty($nama_pelajarErr)) ? 'invalid' : ''; ?>">
                            <label for="nama_pelajar">Nama Pelajar:</label>
                            <input type="text" id="nama_pelajar" name="nama_pelajar" placeholder="Enter your full name" value="<?php echo $nama_pelajar;?>" required>
                            <span class="error" id="nama_error"><?php echo $nama_pelajarErr;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($no_pelajarErr)) ? 'invalid' : ''; ?>">
                            <label for="no_pelajar">No. Pelajar:</label>
                            <input type="text" id="no_pelajar" name="no_pelajar" placeholder="Enter your student ID" value="<?php echo $no_pelajar;?>" required>
                            <span class="error" id="np_error"><?php echo $no_pelajarErr;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($no_kad_pengenalanErr)) ? 'invalid' : ''; ?>">
                            <label for="no_kad_pengenalan">No. Kad Pengenalan:</label>
                            <input type="text" id="no_kad_pengenalan" name="no_kad_pengenalan" placeholder="Enter your IC number (e.g., 123456789012)" value="<?php echo $no_kad_pengenalan;?>" required>
                            <span class="error" id="kp_error"><?php echo $no_kad_pengenalanErr;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($kod_programErr)) ? 'invalid' : ''; ?>">
                            <label for="kod_program">Kod Program:</label>
                            <input type="text" id="kod_program" name="kod_program" placeholder="Enter program code (e.g., CS110)" value="<?php echo $kod_program;?>" required>
                            <span class="error" id="kodprogram_error"><?php echo $kod_programErr;?></span>
                        </div>
                        <div class="form-group span-2 <?php echo (!empty($semesterErr)) ? 'invalid' : ''; ?>">
                            <label for="semester">Semester:</label>
                            <input type="text" id="semester" name="semester" placeholder="Enter semester (e.g., 1, 2, 3)" value="<?php echo $semester;?>" required>
                            <span class="error" id="semester_error"><?php echo $semesterErr;?></span>
                        </div>
                        <div class="form-group span-2 <?php echo (!empty($mod_pengajian_semasaErr)) ? 'invalid' : ''; ?>">
                            <label>Mod Pengajian Semasa:</label>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" name="mod_pengajian_semasa" value="sepenuh_masa" <?php echo ($mod_pengajian_semasa == 'sepenuh_masa') ? 'checked' : ''; ?> required> Sepenuh Masa
                                </label>
                                <label>
                                    <input type="radio" name="mod_pengajian_semasa" value="separuh_masa" <?php echo ($mod_pengajian_semasa == 'separuh_masa') ? 'checked' : ''; ?>> Separuh Masa
                                </label>
                            </div>
                            <span class="error" id="mod_pengajian_semasa_error"><?php echo $mod_pengajian_semasaErr;?></span>
                        </div>

                        <div class="form-group span-2 <?php echo (!empty($taraf_pengajian_semasaErr)) ? 'invalid' : ''; ?>">
                            <label>Taraf Pengajian Semasa:</label>
                            <div class="checkbox-group">
                                <label>
                                    <input type="checkbox" name="taraf_pengajian_semasa[]" value="diploma" <?php echo (in_array('diploma', $taraf_pengajian_semasa)) ? 'checked' : ''; ?>> Diploma
                                </label>
                                <label>
                                    <input type="checkbox" name="taraf_pengajian_semasa[]" value="sarjana_muda" <?php echo (in_array('sarjana_muda', $taraf_pengajian_semasa)) ? 'checked' : ''; ?>> Sarjana Muda
                                </label>
                            </div>
                            <span class="error" id="taraf_pengajian_semasa_error"><?php echo $taraf_pengajian_semasaErr;?></span>
                        </div>
                    </div>
                </div>

                <div class="form-section application-reason-section">
                    <h2 class="section-heading">Saya seperti butiran di atas ingin memohon pertukaran (Sila nyatakan):</h2>
                    <div class="form-grid">
                        <div class="form-group <?php echo (!empty($program_dipohonErr)) ? 'invalid' : ''; ?>">
                            <label for="program_dipohon">Kod/Nama Program</label>
                            <input type="text" id="program_dipohon" name="program_dipohon" placeholder="e.g., CS240 - Sarjana Muda Teknologi Maklumat (Kepujian)" value="<?php echo $program_dipohon;?>" required>
                            <span class="error" id="program_error"><?php echo $program_dipohonErr;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($sesi_pertukaranErr)) ? 'invalid' : ''; ?>">
                            <label for="sesi_pertukaran">Sesi Pertukaran</label>
                            <input type="text" id="sesi_pertukaran" name="sesi_pertukaran" placeholder="e.g., Mac 2025" value="<?php echo $sesi_pertukaran;?>" required>
                            <span class="error" id="sesi_pertukaran_error"><?php echo $sesi_pertukaranErr;?></span>
                        </div>
                        <div class="form-group span-2 <?php echo (!empty($alasan_permohonanErr)) ? 'invalid' : ''; ?>">
                            <label for="alasan_permohonan">Tujuan Pertukaran</label>
                            <textarea id="alasan_permohonan" name="alasan_permohonan" rows="3" placeholder="Enter your reason for application" required><?php echo $alasan_permohonan;?></textarea>
                            <span class="error" id="alasan_error"><?php echo $alasan_permohonanErr;?></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-button">Hantar Permohonan</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 UiTM Arau - ICT600 Web Technology & Application</p>
    </footer>

    <script src="js/script.js"></script> 
</body>
</html>