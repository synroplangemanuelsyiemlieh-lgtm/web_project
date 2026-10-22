<?php
session_start();
if(!isset($_SESSION['username'])){
    header('Location: index.php');
    exit;
}
include 'include/config.php';

$sql="SELECT `name`, `address`, `email`, `phone`, `profile` FROM `users` WHERE `username` = ?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($name, $address, $email, $phone, $profile);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Local Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

    <?php include 'navbarr.php'; ?>
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

    <div class="container my-5" style="max-width: 600px;">
        <div class="card shadow-sm p-4">
            <h2 class="h4 card-title fw-bold text-dark text-center mb-3">Edit Profile</h2>
            
            <?php if(isset($_GET['msg'])): ?>
                <div class="alert alert-danger text-center p-2 mb-3" role="alert">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>
            
            <div id="error-msg-box" class="alert alert-danger text-center p-2 mb-3 d-none"></div>

            <form action="include/update.php" method="POST" enctype="multipart/form-data">
                
                <!-- Avatar Upload Context Block Structure Layout -->
                <div class="text-center mb-4">
                    <div class="mb-3 d-inline-block p-1 border rounded-circle bg-white">
                        <?php
                        if (isset($profile) && trim($profile) !== '') {
                            $src = 'image/' . htmlspecialchars($profile);
                        } else {
                            $src = 'image/dp.png';
                        }
                        ?>
                        <img id="imagePreview" src="<?php echo $src ; ?>" alt="Profile Preview" class="rounded-circle object-fit-cover" style="width: 120px; height: 120px;">
                    </div>
                    <div class="mt-1">
                        <label for="imageUpload" class="btn btn-sm btn-outline-secondary px-3">Choose Photo</label>
                        <input type="file" id="imageUpload" name="image" accept="image/jpeg,image/png" class="d-none">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="fullName" class="form-label fw-semibold">Name</label>
                    <input type="text" id="fullName" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">Address</label>
                    <textarea id="address" name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($address); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label fw-semibold">Phone</label>
                    <input type="text" id="mobile" name="mobile" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" minlength="10" maxlength="10" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100 shadow-sm mt-3 py-2">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Local Bootstrap JS script call hook integration wrapper -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        const errorBox = document.getElementById("error-msg-box");
        const imageUpload = document.getElementById("imageUpload");
        const imagePreview = document.getElementById("imagePreview");
        const MAX_FILE_SIZE = 500 * 1024;

        imageUpload.addEventListener('change', function() {
            const file = this.files[0];
            if(!file){
                return;
            }
        
            if(file.size > MAX_FILE_SIZE){
                errorBox.textContent = "Image is too large. Max size is 500Kb.";
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
