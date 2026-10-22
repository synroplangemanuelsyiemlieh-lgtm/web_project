<?php
session_start();
$username=$_SESSION['username'];
include 'include/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PartnerHub Master Dashboard</title>
    <!-- Local Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

    <!-- Top Horizontal Navigation -->
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

    <!-- Main Content Container -->
    <main class="container my-5">
        <div class="row g-4">
            
            <!-- Section 1: Restaurant Profile -->
            <section id="onboarding" class="col-12 col-lg-6">
                <div class="card h-100 shadow-sm p-4">
                    <h2 class="h4 card-title fw-bold text-dark">Restaurant Profile</h2>
                    <p class="text-muted small">Enter foundational workspace details to initialize store listing profiles.</p>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Restaurant Name</label>
                        <p class="form-control-plaintext bg-light px-3 py-2 rounded"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Complete Physical Address</label>
                        <textarea class="form-control" rows="2">102, Gourmet Street, Foodie Lane, Sector 5, Mumbai - 400001</textarea>
                    </div>
                </div>
            </section>

            <!-- Section 4: Manage Menu / Live Menu Preview -->
            <section id="menu-preview" class="col-12">
                <div class="card shadow-sm p-4">
                    <h2 class="h4 card-title fw-bold text-dark">Current Live Menu Preview</h2>
                    <p class="text-muted small">Manage availability status and prices for items actively displayed to customers.</p>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border">
                            <thead class="table-light">
                                <tr>
                                    <th>Item Name</th>
                                    <th>Price (₹)</th>
                                    <th>Dietary Status</th>
                                    <th>Inventory Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $sql = $conn->prepare("SELECT `menu_id`,`name`, `price`, `isveg`, `is_avail`, `restaurant` FROM `menu` WHERE restaurant=?");
                            $sql->bind_param("s", $_SESSION['username']); 
                            $sql->execute();
                            $result = $sql->get_result(); 
                            
                            if ($result->num_rows === 0) {
                                echo "<tr><td colspan='4' class='text-center text-muted py-4'>No records found</td></tr>";
                            } else {
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['is_avail'] == 1) {
                                        $btnText = "Available";
                                        $btnClass = "btn-success";
                                    } else {
                                        $btnText = "Sold Out";
                                        $btnClass = "btn-danger";
                                    }
                                    
                                    if($row['isveg'] == 1){
                                        $isveg = "VEG";
                                        $isclass = "bg-success text-white";
                                    } else {
                                        $isveg = "NON-VEG";
                                        $isclass = "bg-danger text-white";
                                    }
                                    
                                    echo "<tr>";
                                    echo "<td class='fw-semibold'>{$row['name']}</td>"; 
                                    echo "<td>₹ {$row['price']}</td>";
                                    echo "<td><span class='badge {$isclass}'>".$isveg."</span></td>";
                                    echo "<td><button class='btn btn-sm {$btnClass} w-100 rounded-pill' data-id='{$row['menu_id']}' onclick='toggleStock(this)'>" . $btnText . "</button></td>";             
                                    echo "</tr>";
                                }           
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Section 5: Incoming Orders / Live Orders Desk -->
            <section id="live-orders" class="col-12">
                <div class="card shadow-sm p-4">
                    <h2 class="h4 card-title fw-bold text-dark">Incoming Orders / Live Orders Desk</h2>
                    <p class="text-muted small">Monitor operational fulfillment flows for customer transactions in real time.</p>
                    
                    <div class="row g-3">
                        <!-- Order 1 -->
                        <div class="col-md-4 order-card">
                            <div class="card border-warning h-100">
                                <div class="card-header bg-warning bg-opacity-10 d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">#ORD-8841</span>
                                    <span class="badge bg-warning text-dark status-badge">Preparing</span>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-secondary">1x Paneer Butter Masala, 2x Garlic Naan</p>
                                </div>
                                <div class="card-footer bg-transparent border-0 d-grid gap-1 status-actions">
                                    <button class="btn btn-sm btn-outline-secondary btn-status">New Order</button>
                                    <button class="btn btn-sm btn-outline-secondary btn-status active btn-dark text-white">Preparing</button>
                                    <button class="btn btn-sm btn-outline-secondary btn-status">Ready for Pickup</button>
                                    <button class="btn btn-sm btn-outline-secondary btn-status">Delivered</button>
                                </div>
                            </div>
                        </div>

                        <!-- Order 2 -->
                        <div class="col-md-4 order-card">
                            <div class="card border-info h-100">
                                <div class="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">#ORD-8842</span>
                                    <span class="badge bg-info text-dark status-badge">Ready for Pickup</span>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-secondary">1x Chicken Tikka Masala, 1x Garlic Naan</p>
                                </div>
                                <div class="card-footer bg-transparent border-0 d-grid gap-1 status-actions">
                                    <button class="btn btn-sm btn-outline-secondary btn-status">New Order</button>
                                    <button class="btn btn-sm btn-outline-secondary btn-status">Preparing</button>
                                    <button class="btn btn-sm btn-outline-secondary btn-status active btn-dark text-white">Ready for Pickup</button>
                                    <button class="btn btn-sm btn-outline-secondary btn-status">Delivered</button>
                                </div>
                            </div>
                        </div>

                        <!-- Order 3 -->
                        <div class="col-md-4 order-card">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">#ORD-8843</span>
                                    <span class="badge bg-primary text-white status-badge">New Order</span>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-secondary">2x Dal Makhani, 4x Tandoori Roti</p>
                                </div>
                                <div class="card-footer bg-transparent border-0 d-grid gap-1 status-actions">
                                    <button class="btn btn-sm btn-outline-secondary btn-status active btn-dark text-white">New Order</button>
                                    <button class="btn btn-sm btn-outline-secondary btn-status">Preparing</button>
                                    <button class="btn btn-sm btn-outline-secondary btn-status">Ready for Pickup</button>
                                    <button class="btn btn-sm btn-outline-secondary btn-status">Delivered</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        const statusContainers = document.querySelectorAll('.status-actions');
        statusContainers.forEach(container => {
            container.addEventListener('click', (event) => {
                const clickedButton = event.target;
                if (!clickedButton.classList.contains('btn-status')) return;

                const buttons = container.querySelectorAll('.btn-status');
                buttons.forEach(btn => btn.classList.remove('active', 'btn-dark', 'text-white'));
                
                clickedButton.classList.add('active', 'btn-dark', 'text-white');

                const orderCard = container.closest('.order-card');
                const badge = orderCard.querySelector('.status-badge');
                badge.textContent = clickedButton.textContent;
            });
        });

        function toggleStock(button) {
            const itemId = button.getAttribute('data-id');
            const currentStatus = button.textContent.trim();
            const newStatus = (currentStatus === 'Available') ? 'Sold Out' : 'Available';

            const formData = new FormData();
            formData.append('id', itemId);
            formData.append('status', newStatus);

            fetch('include/stockupdate.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (newStatus === 'Sold Out') {
                        button.textContent = 'Sold Out';
                        button.classList.remove('btn-success');
                        button.classList.add('btn-danger');
                    } else {
                        button.textContent = 'Available';
                        button.classList.remove('btn-danger');
                        button.classList.add('btn-success');
                    }
                } else {
                    alert('Failed to update stock status in database.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('A network error occurred.');
            });
        }
    </script>
</body>
</html>
