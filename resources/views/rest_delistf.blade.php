
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PartnerHub - Delivery Fulfillment Desk</title>
    <!-- Same Local Bootstrap CSS Reference -->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Optional: Add Bootstrap via CDN if your local custom.css doesn't include Bootstrap core -->
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

    <!-- Top Horizontal Navigation Component Frame -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Partner</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href='rest_index'>Home</a></li>
                    <li class="nav-item"><a class="nav-link" href='restaurantprofile'>Edit Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href='rest_editM'>Menu Edit</a></li>
                    <li class="nav-item"><a class="nav-link" href='rest_reservation'>Reservations</a></li>
                    <li class="nav-item"><a class="nav-link active" href='rest_delistf'>Deliveries</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href='logout'>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Workspace Matrix Grid -->
    <main class="container my-5" style="max-width: 900px;">
        <div class="row">
            <div class="col-12">
                <!-- Layout Section Header Description Panel -->
                <div class="card shadow-sm p-4 mb-4">
                    <h2 class="h4 card-title fw-bold text-dark mb-1">Active Run Assignments</h2>
                    <p class="text-muted small">Update and sign off on client cargo distribution drops instantly below.</p>
                </div>

                <!-- Live Dynamic Status Index Container -->
                <div class="row g-3" id="delivery-orders-container">
                    
                    <!-- DEMO ORDER 1: Pending (Warning Status) -->
                    <div class="col-12 order-delivery-row" id="order-row-101">
                        <div class="card shadow-sm border border-opacity-25 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-2 mb-3">
                                    <span class="fw-bold text-dark fs-5">#ORD-101</span>
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill status-tracker-badge">Pending Preparation</span>
                                </div>
                                <div class="row g-2">
                                    <div class="col-sm-4">
                                        <span class="d-block small text-muted fw-bold">ITEMS ORDERED</span>
                                        <span class="text-secondary small">2x Pepperoni Pizza, 1x Large Garlic Bread, 1x Diet Coke</span>
                                    </div>
                                    <div class="col-sm-5">
                                        <span class="d-block small text-muted fw-bold">DELIVERY DROP ADDRESS</span>
                                        <span class="text-secondary small">742 Evergreen Terrace, Springfield</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span class="d-block small text-muted fw-bold">CONTACT PHONE</span>
                                        <a href="tel:555-0199" class="text-decoration-none text-primary small fw-semibold">📞 555-0199</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light p-3 d-flex flex-wrap gap-2 justify-content-end border-top-0">
                                <button class="btn btn-sm btn-outline-secondary px-3 py-2 rounded-pill" onclick="updateDeliveryStatus(101, 'Out For Delivery', this)">Set Active</button>
                                <button class="btn btn-sm btn-danger px-3 py-2 text-white rounded-pill" onclick="updateDeliveryStatus(101, 'Failed Delivery', this)">Not Delivered</button>
                                <button class="btn btn-sm btn-success px-4 py-2 text-white rounded-pill fw-semibold" onclick="updateDeliveryStatus(101, 'Delivered', this)">Mark Delivered</button>
                            </div>
                        </div>
                    </div>

                    <!-- DEMO ORDER 2: Out For Delivery (Info Status) -->
                    <div class="col-12 order-delivery-row" id="order-row-102">
                        <div class="card shadow-sm border border-opacity-25 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-2 mb-3">
                                    <span class="fw-bold text-dark fs-5">#ORD-102</span>
                                    <span class="badge bg-info text-dark px-3 py-2 rounded-pill status-tracker-badge">Out For Delivery</span>
                                </div>
                                <div class="row g-2">
                                    <div class="col-sm-4">
                                        <span class="d-block small text-muted fw-bold">ITEMS ORDERED</span>
                                        <span class="text-secondary small">1x Vegan Burger, 1x Sweet Potato Fries</span>
                                    </div>
                                    <div class="col-sm-5">
                                        <span class="d-block small text-muted fw-bold">DELIVERY DROP ADDRESS</span>
                                        <span class="text-secondary small">123 Financial District, Apt 4B</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span class="d-block small text-muted fw-bold">CONTACT PHONE</span>
                                        <a href="tel:555-0145" class="text-decoration-none text-primary small fw-semibold">📞 555-0145</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light p-3 d-flex flex-wrap gap-2 justify-content-end border-top-0">
                                <button class="btn btn-sm btn-outline-secondary px-3 py-2 rounded-pill" onclick="updateDeliveryStatus(102, 'Out For Delivery', this)">Set Active</button>
                                <button class="btn btn-sm btn-danger px-3 py-2 text-white rounded-pill" onclick="updateDeliveryStatus(102, 'Failed Delivery', this)">Not Delivered</button>
                                <button class="btn btn-sm btn-success px-4 py-2 text-white rounded-pill fw-semibold" onclick="updateDeliveryStatus(102, 'Delivered', this)">Mark Delivered</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Same Bootstrap Bundle Script Framework Link -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        function updateDeliveryStatus(orderId, statusText, buttonElement) {
            // Confirmation alert for final terminations
            if ((statusText === 'Delivered' || statusText === 'Failed Delivery') && 
                !confirm(`Are you sure you want to mark order #ORD-${orderId} as "${statusText}"?`)) {
                return;
            }

            const formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('delivery_status', statusText);

            fetch('include/delivery_update.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const rowCard = document.getElementById(`order-row-${orderId}`);
                    
                    if (statusText === 'Delivered') {
                        // Smoothly strip completed entries from active operational lists
                        rowCard.classList.add('fade');
                        setTimeout(() => {
                            rowCard.remove();
                            checkEmptyWorkspace();
                        }, 300);
                        alert('Order marked completed successfully.');
                    } else {
                        // Dynamically update UI parameters in-place for active updates
                        const badge = rowCard.querySelector('.status-tracker-badge');
                        badge.textContent = statusText;
                        
                        // Dynamically adjust badges matching design rules
                        badge.className = "badge px-3 py-2 rounded-pill status-tracker-badge";
                        if(statusText === 'Out For Delivery') { badge.classList.add('bg-info', 'text-dark'); }
                        if(statusText === 'Failed Delivery') { badge.classList.add('bg-danger', 'text-white'); }
                    }
                } else {
                    alert(data.message || 'Database transaction update configuration failed.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('A network communication error surfaced.');
            });
        }

        function checkEmptyWorkspace() {
            const container = document.getElementById('delivery-orders-container');
            if (container.querySelectorAll('.order-delivery-row').length === 0) {
                container.innerHTML = `<div class="col-12 text-center py-5 text-muted card shadow-sm bg-white fw-medium">
                                            No pending active delivery orders allocated at the moment.
                                       </div>`;
            }
        }
    </script>
</body>
</html>
