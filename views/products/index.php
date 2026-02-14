<?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Products</h2>
        </div>
        <button class="btn btn-primary shadow-sm" id="btnCreateProduct" onclick="openModal()" style="display: none;">
            <i class="bi bi-plus-lg"></i> New Product
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Internal Code</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end pe-4" id="actionsHeader">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="productsTableBody">
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <br><span class="mt-2 d-block">Loading products...</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form id="productForm">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalTitle">Product</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" id="productId" name="id">

                        <div class="mb-3">
                            <label for="internalCode" class="form-label fw-bold">Internal Code</label>
                            <input type="text" class="form-control" id="internalCode" placeholder="Ex: PRD-001" required>
                        </div>

                        <div class="mb-3">
                            <label for="productName" class="form-label fw-bold">Name</label>
                            <input type="text" class="form-control" id="productName" placeholder="Product name" required>
                        </div>

                        <div class="mb-3">
                            <label for="productPrice" class="form-label fw-bold">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="productPrice" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="productDescription" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" id="productDescription" rows="3" placeholder="Brief description..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="productStatus" class="form-label fw-bold">Status</label>
                            <select class="form-select" id="productStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            const isAdmin = (user.isAdmin == 1);

            if (isAdmin) {
                $('#btnCreateProduct').show();
                $('#actionsHeader').show();
            } else {
                $('#actionsHeader').hide();
            }

            loadProducts(isAdmin);
            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                saveProduct();
            });
        });

        function loadProducts(isAdmin) {
            $.ajax({
                url: '/api/products',
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') },
                success: function(response) {
                    let html = '';
                    const products = response.data || response;

                    if (!products || products.length === 0) {
                        $('#productsTableBody').html('<tr><td colspan="6" class="text-center py-4">No products found.</td></tr>');
                        return;
                    }

                    products.forEach(product => {
                        const editAction = isAdmin ? `
                            <button class="btn btn-sm btn-light border" onclick='openModal(${JSON.stringify(product)})' title="Edit">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </button>
                        ` : '';

                        const formattedPrice = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(product.price || 0);

                        html += `
                        <tr>
                            <td class="ps-4"><span class="badge bg-light text-dark border">#${product.internal_code}</span></td>
                            <td class="fw-bold">${product.name}</td>
                            <td>${formattedPrice}</td>
                            <td class="text-muted small">${product.description || '-'}</td>
                            <td>
                                <span class="badge rounded-pill ${product.status == 1 ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border border-secondary'}">
                                    ${product.status == 1 ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                            <td class="text-end pe-4">${editAction}</td>
                        </tr>`;
                    });
                    $('#productsTableBody').html(html);
                },
                error: function(xhr) {
                    showToast('false', 'Error loading products list.');
                    $('#productsTableBody').html('<tr><td colspan="6" class="text-center text-danger">Error loading data.</td></tr>');
                }
            });
        }

        function openModal(product = null) {
            const modalEl = document.getElementById('productModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            $('#productForm')[0].reset();
            if (product) {
                $('#modalTitle').html('<i class="bi bi-pencil me-2"></i>Edit Product');
                $('#productId').val(product.id);
                $('#internalCode').val(product.internal_code);
                $('#productName').val(product.name);
                $('#productPrice').val(product.price);
                $('#productDescription').val(product.description);
                $('#productStatus').val(product.status);
            } else {
                $('#modalTitle').html('<i class="bi bi-plus-lg me-2"></i>New Product');
                $('#productId').val('');
            }
            modal.show();
        }

        function saveProduct() {
            const id = $('#productId').val();
            const data = {
                internal_code: $('#internalCode').val(),
                name: $('#productName').val(),
                price: parseFloat($('#productPrice').val()),
                description: $('#productDescription').val(),
                status: $('#productStatus').val()
            };

            const url = id ? `/api/products/${id}` : '/api/product';
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') },
                data: JSON.stringify(data),
                success: function(response) {
                    bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
                    const user = JSON.parse(localStorage.getItem('user') || '{}');
                    loadProducts(user.isAdmin == 1);
                    showToast(true, 'Product saved successfully!');
                },
                error: function(xhr) {
                    let msg = 'Error processing request.';
                    try {
                        const res = JSON.parse(xhr.responseText);
                        msg = res.error || res.message || msg;
                    } catch(e){}
                    showToast(false, msg);
                }
            });
        }
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>