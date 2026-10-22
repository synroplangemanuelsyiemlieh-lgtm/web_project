
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <li class="nav-item"><a class="nav-link " href='restaurantprofile'>Edit Profile</a></li>
                    <li class="nav-item"><a class="nav-link active" href='rest_editM'>Menu Edit</a></li>
                    <li class="nav-item"><a class="nav-link" href='rest_reservation'>Reservations</a></li>
                    <li class="nav-item"><a class="nav-link" href='rest_delistf'>Deliveries</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href='logout'>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container with sections layered one per row -->
    <main class="container my-5">
        <div class="row g-4">

            <!-- Section 3: Category Catalog Builder -->
            <section id="cat-builder" class="col-md-6">
                <div class="card h-100 shadow-sm p-4">
                    <form action="/makeCat" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h2 class="h4 card-title fw-bold text-dark">Category Catalog Builder</h2>
                        <p class="text-muted small">Populate inventory parameters directly into your custom customer ordering indexes.</p>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" class="form-control" name="name" placeholder="e.g. Butter Naan">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Choose Photo</label>
                            <input type="file" class="form-control" name="img" accept="image/jpeg,image/png">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm mt-2">Add Category</button>
                    </form>
                </div>
            </section>

            <!-- Section 4: Menu Catalog Builder -->
            <section id="menu-builder" class="col-md-6">
                <div class="card h-100 shadow-sm p-4">
                    <form action="/makeMenu" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h2 class="h4 card-title fw-bold text-dark">Menu Catalog Builder</h2>
                        <p class="text-muted small">Populate inventory parameters directly into your custom customer ordering indexes.</p>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Item Name</label>
                            <input type="text" class="form-control" name="name" placeholder="e.g. Butter Naan">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select" name="category_id">
                                <option value="0">--select--</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }} ({{ $category->menus_count }} items)
                                </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Base Cost / Price (₹)</label>
                            <input type="number" class="form-control" name="price" placeholder="e.g. 120">
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block fw-semibold">Dietary Tag</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_veg" id="dietVeg" value="true">
                                <label class="form-check-label" for="dietVeg">Veg</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_veg" id="dietNonVeg" value="false">
                                <label class="form-check-label" for="dietNonVeg">Non-Veg</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Choose Photo</label>
                            <input type="file" class="form-control" name="img" accept="image/jpeg,image/png">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm">Add Item</button>
                    </form>
                </div>
            </section>

            <!-- Section: Menu Preview Table -->
            <section id="menu-preview" class="col-12"> 
                <div class="card shadow-sm p-4"> 
                    <h2 class="h4 card-title fw-bold text-dark">Current Menu Preview</h2> 
                    <p class="text-muted small">Manage availability status and prices for items actively displayed to customers.</p> 
                    <div class="table-responsive"> 
                        @if(session('success')) 
                            <div class="alert alert-success">{{ session('success') }}</div> 
                        @endif 
                        <table class="table table-striped align-middle"> 
                            <thead> 
                                <tr> 
                                    <th>Photo</th> 
                                    <th>Item Name</th> 
                                    <th>Category</th> 
                                    <th>Price</th> 
                                    <th>Dietary Status</th> 
                                    <th>Availability</th> 
                                    <th class="text-end">Actions</th> 
                                </tr> 
                            </thead> 
                            <tbody> 
                                @foreach ($menus as $item) 
                                    <tr> 
                                        <td> 
                                            @if($item->img) 
                                                <img src="{{ asset('Menu_photos/$item->img') }}"width="60" class="rounded">
                                            @else 
                                                <span class="text-muted">No Image</span> 
                                            @endif 
                                        </td> 
                                        <td class="fw-bold">{{ $item->name }}</td> 
                                        <td>{{ $item->category->name ?? 'Uncategorized' }}</td> 
                                        <td>₹{{ number_format($item->price, 2) }}</td> 
                                        <td> 
                                            <span class="badge {{ $item->is_veg ? 'bg-success' : 'bg-danger' }}"> 
                                                {{ $item->is_veg ? 'Veg' : 'Non-Veg' }} 
                                            </span> 
                                        </td> 
                                        <td> 
                                            <span class="badge {{ $item->is_avail ? 'bg-primary' : 'bg-secondary' }}"> 
                                                {{ $item->is_avail ? 'Available' : 'Out of Stock' }} 
                                            </span> 
                                        </td> 
                                        <!-- Functional Delete Action Column Element -->
                                        <td class="text-end">
                                            <button type="button" 
                                                    class="btn btn-primary btn-sm shadow-sm" 
                                                    data-id="{{ $item->id }}" 
                                                    onclick="deleteMenu(this)">
                                                <i class="bi bi-trashme me-1"></i> Remove
                                            </button>
                                        </td>
                                    </tr> 
                                @endforeach 
                            </tbody> 
                        </table> 
                        <div class="mt-4"> 
                            {{ $menus->links() }} 
                        </div> 
                    </div> 
                </div> 
            </section> 

        </div>
    </main>
    
    <!-- Local Bootstrap JS Script Asset -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteMenu(button) {
            if (!confirm("Are you sure you want to permanently delete this menu item?")) {
                return;
            }

            const itemId = button.getAttribute('data-id');
            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if(!response.ok) throw new Error('419 or 404');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    button.closest('tr').remove();
                    // alert('Item deleted successfully!'); // better use toast
                } else {
                    alert('Failed to delete: ' + (data.message || ''));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            });
        }
        
    </script>
    @if ($errors->any())
    <script>
        let errorMessages = "";
        @foreach ($errors->all() as $error)
            errorMessages += "- {{ $error }}\n";
        @endforeach
        alert("Validation Failed:\n" + errorMessages);
    </script>
    @endif
    
</body>
</html>
