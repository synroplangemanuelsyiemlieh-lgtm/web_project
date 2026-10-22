<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Delivery Portal - Login & Register</title>
    <!-- Local Bootstrap CSS Link -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        /* Optional: simple centering background style */
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                
                <!-- Navigation Tabs -->
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs nav-justified" id="authTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-3 fw-bold text-uppercase fs-6 border-0 rounded-0" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-panel" type="button" role="tab" aria-controls="login-panel" aria-selected="true">
                                Login
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 fw-bold text-uppercase fs-6 border-0 rounded-0" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-panel" type="button" role="tab" aria-controls="register-panel" aria-selected="false">
                                Register
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content" id="authTabsContent">
                        
                        <!-- Login Form Panel -->
                        <div class="tab-pane fade show active" id="login-panel" role="tabpanel" aria-labelledby="login-tab">
                            <h3 class="mb-4 text-dark fw-semibold">Welcome Back</h3>
                            <form id="loginForm" onsubmit="handleLogin(event)">
                                <div class="mb-3">
                                    <label for="login-username" class="form-label text-secondary small fw-medium">Username or Email</label>
                                    <input type="text" id="login-username" class="form-control py-2" required placeholder="Enter your username or email">
                                </div>
                                <div class="mb-4">
                                    <label for="login-password" class="form-label text-secondary small fw-medium">Password</label>
                                    <input type="password" id="login-password" class="form-control py-2" required placeholder="Enter your password">
                                </div>
                                <button type="submit" class="btn btn-warning w-100 text-white fw-bold py-2 shadow-sm" style="background-color: #ff5722; border: none;">Sign In</button>
                            </form>
                        </div>

                        <!-- Registration Form Panel (Mapped to Customer Schema) -->
                        <div class="tab-pane fade" id="register-panel" role="tabpanel" aria-labelledby="register-tab">
                            <h3 class="mb-4 text-dark fw-semibold">Create Customer Account</h3>
                            <form id="registerForm" onsubmit="handleRegister(event)">
                                <div class="mb-3">
                                    <label for="reg-username" class="form-label text-secondary small fw-medium">Username (u)</label>
                                    <input type="text" id="reg-username" class="form-control py-2" required placeholder="johndoe123">
                                </div>
                                <div class="mb-3">
                                    <label for="reg-name" class="form-label text-secondary small fw-medium">Full Name</label>
                                    <input type="text" id="reg-name" class="form-control py-2" required placeholder="John Doe">
                                </div>
                                <div class="mb-3">
                                    <label for="reg-email" class="form-label text-secondary small fw-medium">Email Address</label>
                                    <input type="email" id="reg-email" class="form-control py-2" required placeholder="john@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="reg-phone" class="form-label text-secondary small fw-medium">Phone Number</label>
                                    <input type="tel" id="reg-phone" class="form-control py-2" required placeholder="123-456-7890">
                                </div>
                                <div class="mb-3">
                                    <label for="reg-address" class="form-label text-secondary small fw-medium">Delivery Address</label>
                                    <textarea id="reg-address" class="form-control" rows="3" required placeholder="Street address, City, State, ZIP"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="reg-password" class="form-label text-secondary small fw-medium">Password</label>
                                    <input type="password" id="reg-password" class="form-control py-2" required placeholder="••••••••">
                                </div>
                                <div class="mb-4">
                                    <label for="reg-img" class="form-label text-secondary small fw-medium">Profile Image (img)</label>
                                    <input type="file" id="reg-img" class="form-control" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-warning w-100 text-white fw-bold py-2 shadow-sm" style="background-color: #ff5722; border: none;">Register Account</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Local Bootstrap Bundle JS (Includes Popper) -->
<script src="js/bootstrap.bundle.min.js"></script>

<script>
    function handleLogin(event) {
        event.preventDefault();
        const username = document.getElementById('login-username').value;
        alert(`Logged in successfully as: ${username}`);
    }

    function handleRegister(event) {
        event.preventDefault();
        const customerData = {
            username: document.getElementById('reg-username').value,
            name: document.getElementById('reg-name').value,
            email: document.getElementById('reg-email').value,
            phoneno: document.getElementById('reg-phone').value,
            address: document.getElementById('reg-address').value,
            password: document.getElementById('reg-password').value,
            img: document.getElementById('reg-img').files.length ? document.getElementById('reg-img').files[0].name : null
        };
        console.log("Submitting Data:", customerData);
        alert(`Account registered successfully for: ${customerData.username}`);
    }
</script>
</body>
</html>