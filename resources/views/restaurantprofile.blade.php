<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PartnerHub Master Dashboard - Edit Profile</title>
    <!-- Standardized Local Bootstrap CSS framework link integration hook -->
    
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

    <!-- Top Horizontal Navigation Global Frame -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"> Partner</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href='rest_index'>Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href='restaurantprofile'>Edit Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href='rest_editM.php'>Menu Edit</a></li>
                    <li class="nav-item"><a class="nav-link" href='rest_reservation.php'>Reservations</a></li>
                    <li class="nav-item"><a class="nav-link" href='rest_delistf.php'>Deliveries</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href='logout.php'>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5" style="max-width: 700px;">
        <!-- Matching Standard Profile Card Structure Block Component -->
        <div class="card shadow-sm p-4">
            <h2 class="h4 card-title fw-bold text-dark text-center mb-1">Edit Workspace Profile</h2>
            <p class="text-muted text-center small mb-4">Update your business details, capacity dimensions, and operational status indexes</p>
            
            <!-- Context Alerts Error Mapping Handling Engine Block -->
            <?php if(isset(\$_GET['msg'])): ?>
                <div class="alert alert-danger text-center p-2 mb-3" role="alert">
                    <?php echo htmlspecialchars(\$_GET['msg']); ?>
                </div>
            <?php endif; ?>
            
            <div id="error-msg-box" class="alert alert-danger text-center p-2 mb-3 d-none"></div>

            <form action="include/update.php" method="POST" enctype="multipart/form-data">
                
                <!-- Graphic Avatar Photo Selection Node Structure -->
                <div class="text-center mb-4">
                    <div class="mb-3 d-inline-block p-1 border rounded-circle bg-white shadow-sm">
                        <?php
                        if (isset(\(profile) && trim(\)profile) !== '') {
                            src = 'image/' . htmlspecialchars(profile);
                        } else {
                            \$src = 'image/dp.png';
                        }
                        ?>
                        <img id="imagePreview" src="<?php echo \$src ; ?>" alt="Profile Preview" class="rounded-circle object-fit-cover" style="width: 125px; height: 125px;">
                    </div>
                    <div class="mt-1">
                        <label for="imageUpload" class="btn btn-sm btn-outline-secondary px-3 rounded-pill">Change Cover / Photo</label>
                        <input type="file" id="imageUpload" name="image" accept="image/jpeg,image/png" class="d-none">
                    </div>
                </div>

                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fullName" class="form-label fw-semibold">Restaurant Name</label>
                            <input type="text" id="fullName" name="name" class="form-control" value="<?php echo htmlspecialchars(\$name); ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars(\$email); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mobile" class="form-label fw-semibold">Contact Phone No</label>
                            <input type="text" id="mobile" name="mobile" class="form-control" value="<?php echo htmlspecialchars(\$phone); ?>" minlength="10" maxlength="10" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="totalTables" class="form-label fw-semibold">No of Seating Tables</label>
                            <input type="number" id="totalTables" name="total_tables" class="form-control" value="<?php echo intval(\$total_tables); ?>" min="0" placeholder="e.g. 24" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="operatingHours" class="form-label fw-semibold">Operating Hours / Working Schedule</label>
                    <input type="text" id="operatingHours" name="operating_hours" class="form-control" value="<?php echo htmlspecialchars(\$operating_hours); ?>" placeholder="e.g., 11:00 AM - 11:00 PM, Mon-Sun" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">Complete Physical Address</label>
                    <textarea id="address" name="address" class="form-control" rows="2" required><?php echo htmlspecialchars(\$address); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Store Brief Description</label>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Describe your restaurant's theme, specialties, or fine dining ambiance elements..."><?php echo htmlspecialchars(\$description); ?></textarea>
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100 shadow-sm mt-3 py-2 fw-semibold">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle script processing components configuration link -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        const errorBox = document.getElementById("error-msg-box");
        const imageUpload = document.getElementById("imageUpload");
        const imagePreview = document.getElementById("imagePreview");
        const MAX_FILE_SIZE = 500 * 1024; // 500 KB limit boundary definition

        imageUpload.addEventListener('change', function() {
            const file = this.files[0];
            if(!file){
                return;
            }
        
            if(file.size > MAX_FILE_SIZE){
                errorBox.textContent = "Image file footprint is too large! Maximum limit target is 500Kb.";
                errorBox.classList.remove('d-none');
                this.value = "";
                imagePreview.src = "image/dp.png";
                return;
            }

            errorBox.textContent = "";
            errorBox.classList.add('d-none');
            const reader = new FileReader();
            reader.onload = function(e){
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>
