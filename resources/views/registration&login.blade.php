<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication Portal</title>
    <!-- Referencing downloaded / local Bootstrap source files as requested -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .auth-card {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
            color: #0d6efd;
        }
        .error-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        .is-invalid ~ .error-feedback {
            display: block;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card auth-card bg-white p-4">
            <h3 class="text-center mb-4 text-primary">Food Ordering Portal</h3>
            
            <!-- Navigation Tabs to switch views -->
            <ul class="nav nav-tabs mb-4" id="authTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active w-100" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-pane" type="button" role="tab">Login</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-pane" type="button" role="tab">Register</button>
                </li>
            </ul>

            <div class="tab-content" id="authTabsContent">
                <!-- ==================== LOGIN FORM ==================== -->
                <div class="tab-pane fade show active" id="login-pane" role="tabpanel">
                    <form id="loginForm" novalidate>
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="loginEmail" placeholder="name@example.com" required>
                            <div class="error-feedback">Please enter a valid email address.</div>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" minlength="6" required>
                            <div class="error-feedback">Password must be at least 6 characters long.</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Sign In</button>
                    </form>
                </div>

                <!-- ==================== REGISTRATION FORM ==================== -->
                <div class="tab-pane fade" id="register-pane" role="tabpanel">
                    <form id="registerForm" novalidate>
                        <!-- Role Selection aligned with ERD Profiles -->
                        <div class="mb-3">
                            <label for="regRole" class="form-label">Register As</label>
                            <select class="form-select" id="regRole" required>
                                <option value="" selected disabled>Choose account type...</option>
                                <option value="customer">Customer</option>
                                <option value="restaurant">Restaurant Owner</option>
                                <option value="delivery">Delivery Rider</option>
                            </select>
                            <div class="error-feedback">Please select an account type.</div>
                        </div>

                        <div class="mb-3">
                            <label for="regName" class="form-label">Full Name / Business Name</label>
                            <input type="text" class="form-control" id="regName" required>
                            <div class="error-feedback">Name cannot be empty.</div>
                        </div>

                        <div class="mb-3">
                            <label for="regUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="regUsername" minlength="4" required>
                            <div class="error-feedback">Username must be at least 4 alphanumeric characters.</div>
                        </div>

                        <div class="mb-3">
                            <label for="regEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="regEmail" required>
                            <div class="error-feedback">Please enter a valid unique email address.</div>
                        </div>

                        <div class="mb-3">
                            <label for="regPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="regPhone" pattern="^[0-9]{10}$" placeholder="10-digit number" required>
                            <div class="error-feedback">Please enter a valid 10-digit phone number.</div>
                        </div>

                        <div class="mb-3">
                            <label for="regPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="regPassword" minlength="6" required>
                            <div class="error-feedback">Password must be at least 6 characters long.</div>
                        </div>

                        <div class="mb-3">
                            <label for="regConfirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="regConfirmPassword" required>
                            <div class="error-feedback">Passwords do not match.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-2">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Referencing downloaded / local Bootstrap bundle JS script -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript Field Validation Validation Execution -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- Helper Functions ---
            function validateInput(inputElement, validationCondition) {
                if (validationCondition) {
                    inputElement.classList.remove('is-invalid');
                    inputElement.classList.add('is-valid');
                    return true;
                } else {
                    inputElement.classList.remove('is-valid');
                    inputElement.classList.add('is-invalid');
                    return false;
                }
            }

            // --- Login Form Validation ---
            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = document.getElementById('loginEmail');
                const pass = document.getElementById('loginPassword');
                
                const isEmailValid = validateInput(email, email.value.includes('@') && email.value.length > 4);
                const isPassValid = validateInput(pass, pass.value.length >= 6);

                if (isEmailValid && isPassValid) {
                    alert('Login form validation passed! Directing to dashboard...');
                    // Proceed with backend API authentication fetch calls here
                }
            });

            // --- Registration Form Validation ---
            const registerForm = document.getElementById('registerForm');
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const role = document.getElementById('regRole');
                const name = document.getElementById('regName');
                const username = document.getElementById('regUsername');
                const email = document.getElementById('regEmail');
                const phone = document.getElementById('regPhone');
                const pass = document.getElementById('regPassword');
                const confirmPass = document.getElementById('regConfirmPassword');

                let isValidForm = true;

                // Validate Account Type Selection
                if (!validateInput(role, role.value !== "")) isValidForm = false;

                // Validate Name
                if (!validateInput(name, name.value.trim().length > 0)) isValidForm = false;

                // Validate Username
                if (!validateInput(username, username.value.trim().length >= 4)) isValidForm = false;

                // Validate Email
                if (!validateInput(email, email.value.includes('@') && email.value.length > 4)) isValidForm = false;

                // Validate Phone (Basic 10 digit match regex)
                const phoneRegex = /^[0-9]{10}$/;
                if (!validateInput(phone, phoneRegex.test(phone.value))) isValidForm = false;

                // Validate Password Length
                if (!validateInput(pass, pass.value.length >= 6)) isValidForm = false;

                // Validate Password Match Confirmation
                if (!validateInput(confirmPass, confirmPass.value === pass.value && confirmPass.value.length > 0)) {
                    isValidForm = false;
                }

                if (isValidForm) {
                    alert('Registration validation passed! Sending credentials for review/onboarding...');
                    // Proceed with backend registration workflow calls here
                }
            });

            // Real-time error state removal toggle on field changes
            const allInputs = document.querySelectorAll('input, select');
            allInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
</body>
</html>