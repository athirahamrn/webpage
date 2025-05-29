document.addEventListener('DOMContentLoaded', function() {
    // --- Application Form Page (form.html) Validation ---
    const transferApplicationForm = document.getElementById('transfer-application-form');

    if (transferApplicationForm) { // Only run this block if the form exists on the page
        const form = transferApplicationForm;

        // Function to validate a single input field (text, tel, textarea)
        function validateInputField(elementId, errorMessageElementId, regex = null, customMessage = "") {
            const inputElement = document.getElementById(elementId);
            const errorElement = document.getElementById(errorMessageElementId);
            let isValid = true;

            if (inputElement && errorElement) {
                const value = inputElement.value.trim();
                errorElement.textContent = ""; // Clear previous error
                inputElement.classList.remove('invalid'); // Clear invalid state

                if (value === "") {
                    errorElement.textContent = customMessage || `${inputElement.previousElementSibling.textContent.replace(':', '')} diperlukan.`;
                    inputElement.classList.add('invalid');
                    isValid = false;
                } else if (regex && !regex.test(value)) {
                    errorElement.textContent = customMessage || `${inputElement.previousElementSibling.textContent.replace(':', '')} tidak sah.`;
                    inputElement.classList.add('invalid');
                    isValid = false;
                }
            }
            return isValid;
        }

        // Function to validate radio group
        function validateRadioGroup(name, errorMessageElementId, customMessage = "") {
            const radioButtons = document.querySelectorAll(`input[name="${name}"]`);
            const errorElement = document.getElementById(errorMessageElementId);
            let isChecked = false;
            const formGroup = radioButtons[0] ? radioButtons[0].closest('.form-group') : null;

            if (errorElement) {
                errorElement.textContent = ""; // Clear previous error
            }
            if (formGroup) {
                formGroup.classList.remove('invalid'); // Clear invalid state from group
            }

            radioButtons.forEach(radio => {
                if (radio.checked) {
                    isChecked = true;
                }
            });

            if (!isChecked) {
                if (errorElement) {
                    errorElement.textContent = customMessage || `Sila pilih Mod Pengajian Semasa.`;
                }
                if (formGroup) {
                    formGroup.classList.add('invalid'); // Add invalid state to group
                }
                return false;
            }
            return true;
        }

        // Function to validate checkbox group
        function validateCheckboxGroup(name, errorMessageElementId, customMessage = "") {
            const checkboxes = document.querySelectorAll(`input[name="${name}"]:checked`);
            const allCheckboxes = document.querySelectorAll(`input[name="${name}"]`);
            const errorElement = document.getElementById(errorMessageElementId);
            const formGroup = allCheckboxes[0] ? allCheckboxes[0].closest('.form-group') : null;

            if (errorElement) {
                errorElement.textContent = ""; // Clear previous error
            }
            if (formGroup) {
                formGroup.classList.remove('invalid'); // Clear invalid state from group
            }

            if (checkboxes.length === 0) {
                if (errorElement) {
                    errorElement.textContent = customMessage || `Sila pilih Taraf Pengajian Semasa.`;
                }
                if (formGroup) {
                    formGroup.classList.add('invalid'); // Add invalid state to group
                }
                return false;
            }
            return true;
        }


        // Function to validate the entire form
        function validateForm() {
            let isValid = true; // Start with true and set to false if any validation fails

            // Clear all previous errors and invalid classes before re-validation
            document.querySelectorAll('.error').forEach(el => el.textContent = '');
            document.querySelectorAll('.invalid').forEach(el => el.classList.remove('invalid'));


            // Order matters here for correct short-circuiting with &&
            // Validate text inputs first (8 fields)
            isValid = validateInputField('nama_pelajar', 'nama_error', /^[a-zA-Z\s]+$/, 'Nama hanya boleh mengandungi huruf dan ruang.') && isValid;
            isValid = validateInputField('no_kad_pengenalan', 'kp_error', /^\d{12}$/, 'No. Kad Pengenalan mestilah 12 digit.') && isValid;
            isValid = validateInputField('no_pelajar', 'np_error', /^\d{10}$/, 'No. Pelajar mestilah 10 digit.') && isValid;
            isValid = validateInputField('kod_program', 'kodprogram_error') && isValid;
            isValid = validateInputField('kampus', 'kampus_error') && isValid;
            isValid = validateInputField('semester', 'semester_error', /^\d+$/, 'Semester mesti nombor.') && isValid;
            isValid = validateInputField('no_telefon', 'notel_error', /^\d{10,11}$/, 'No. Telefon mesti 10-11 digit nombor.') && isValid;
            
            // Validate radio/checkbox groups (2 fields, completing the 10 important inputs)
            isValid = validateRadioGroup('mod_pengajian_semasa', 'mod_pengajian_semasa_error') && isValid; 
            isValid = validateCheckboxGroup('taraf_pengajian_semasa[]', 'taraf_pengajian_semasa_error') && isValid; 

            // Validate additional form fields (Program, Mod Pengajian Baru, Kampus Baru, Sesi Pertukaran, Tujuan Pertukaran)
            isValid = validateInputField('program_dipohon', 'program_error') && isValid;
            // The following fields are optional in the form, but if you want to make them required, uncomment the lines below:
            // isValid = validateInputField('mod_pengajian_baru', 'mod_pengajian_baru_error') && isValid;
            // isValid = validateInputField('kampus_baru', 'kampus_baru_error') && isValid;
            // isValid = validateInputField('sesi_pertukaran', 'sesi_pertukaran_error') && isValid;
            isValid = validateInputField('alasan_permohonan', 'alasan_error') && isValid;


            return isValid;
        }

        // Add event listener to the form
        form.addEventListener("submit", function(event) {
            // Always prevent default submission to handle validation
            event.preventDefault(); 
            
            if (!validateForm()) {
                // DO NOT use alert() here. Rely on inline error messages and styling.
                // alert("Sila isi semua maklumat yang diperlukan dengan betul."); // REMOVED
                // You might want to scroll to the first error if the form is very long
                const firstInvalidField = document.querySelector('.invalid');
                if (firstInvalidField) {
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                alert("Permohonan berjaya dihantar!");
                form.reset(); // Clear form after successful submission
                // Also clear any red borders/invalid classes if left over on individual inputs or groups
                document.querySelectorAll('input.invalid, textarea.invalid').forEach(el => el.classList.remove('invalid'));
                document.querySelectorAll('.form-group.invalid').forEach(el => el.classList.remove('invalid'));
            }
        });
    }

    // --- My Profile Page (profile.html) Functionality ---
    // This part is commented out because profile details are hardcoded in profile.html.
    // Uncomment and use if you decide to dynamically set profile info via JS.
    /*
    const profileDetailsDiv = document.getElementById('profile-details');
    if (profileDetailsDiv) {
        const yourFullName = "NURUL ATHIRAH BINTI AMRAN";
        const yourMatricNo = "2023142825";
        const yourClassGroup = "RCDCS2405A";

        profileDetailsDiv.innerHTML = `
            <p><strong>Full Name:</strong> ${yourFullName}</p>
            <p><strong>Matric No:</strong> ${yourMatricNo}</p>
            <p><strong>Class Group:</strong> ${yourClassGroup}</p>
        `;
    }
    */
});