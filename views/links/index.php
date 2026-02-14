<?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Product-Supplier Links</h2>
            <p class="text-muted small">Manage relationships between products and their providers</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Link New Relationship</div>
                <div class="card-body">
                    <form id="linkForm">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Select Product</label>
                            <select class="form-select" id="selectProduct" required>
                                <option value="">Choose a product...</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Select Supplier</label>
                            <select class="form-select" id="selectSupplier" required>
                                <option value="">Choose a supplier...</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="btnLink">
                            <i class="bi bi-link-45deg"></i> Create Link
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold" id="tableTitle">Linked Data</span>
                    <button class="btn btn-sm btn-outline-danger" id="btnUnlinkAll" style="display: none;">
                        <i class="bi bi-trash text-danger"></i> Unlink All
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                            <tr id="tableHeader">
                                <th class="ps-3">Name</th>
                                <th>Detail</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                            </thead>
                            <tbody id="linksTableBody">
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Select a product or supplier to see active links</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            const isAdmin = (user.isAdmin == 1);
            let currentView = 'product';

            if (!isAdmin) {
                $('#linkForm input, #linkForm select, #linkForm button').prop('disabled', true);
                $('#btnLink').text('Admin Only');
            }

            loadDropdowns();


            $('#selectProduct').on('change', function() {
                const productId = $(this).val();
                if (productId) {
                    currentView = 'product';
                    updateTableContext('Suppliers for this Product', ['Supplier Name', 'CNPJ']);
                    loadLinkedSuppliers(productId, isAdmin);
                }
            });

            $('#selectSupplier').on('change', function() {
                const supplierId = $(this).val();
                if (supplierId) {
                    currentView = 'supplier';
                    updateTableContext('Products for this Supplier', ['Product Name', 'Internal Code']);
                    loadLinkedProducts(supplierId, isAdmin);
                }
            });

            function updateTableContext(title, headers) {
                $('#tableTitle').text(title);
                $('#tableHeader').html(`
                    <th class="ps-3">${headers[0]}</th>
                    <th>${headers[1]}</th>
                    <th class="text-end pe-3">Actions</th>
                `);
            }

            $('#linkForm').on('submit', function(e) {
                e.preventDefault();
                const productId = $('#selectProduct').val();
                const supplierId = $('#selectSupplier').val();

                $.ajax({
                    url: '/api/link-product-supplier',
                    method: 'POST',
                    contentType: 'application/json',
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') },
                    data: JSON.stringify({
                        product_id: parseInt(productId),
                        supplier_id: parseInt(supplierId)
                    }),
                    success: function() {
                        showToast(true, 'Link created successfully!');
                        if(currentView === 'product') loadLinkedSuppliers(productId, isAdmin);
                        else loadLinkedProducts(supplierId, isAdmin);
                    },
                    error: function(xhr) {
                        const res = JSON.parse(xhr.responseText || '{}');
                        showToast(false, res.error || 'Failed to create link.');
                    }
                });
            });

            $('#btnUnlinkAll').on('click', function() {
                const productId = $('#selectProduct').val();
                const supplierId = $('#selectSupplier').val();

                let url = '';
                let callback = null;

                if (currentView === 'product' && productId) {
                    if (!confirm('Remove ALL suppliers for this product?')) return;
                    url = `/api/products/${productId}/suppliers`;
                    callback = () => loadLinkedSuppliers(productId, isAdmin);
                } else if (currentView === 'supplier' && supplierId) {
                    if (!confirm('Remove ALL products for this supplier?')) return;
                    url = `/api/suppliers/${supplierId}/products`;
                    callback = () => loadLinkedProducts(supplierId, isAdmin);
                }

                if(url) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') },
                        success: function() {
                            showToast(true, 'All links removed.');
                            callback();
                        }
                    });
                }
            });
        });

        function loadDropdowns() {
            const headers = { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') };
            $.ajax({
                url: '/api/products',
                method: 'GET',
                headers: headers,
                success: function(response) {
                    const products = response.data || response;
                    products.forEach(p => $('#selectProduct').append(`<option value="${p.id}">${p.name} (#${p.internal_code})</option>`));
                }
            });
            $.ajax({
                url: '/api/suppliers',
                method: 'GET',
                headers: headers,
                success: function(response) {
                    const suppliers = response.data || response;
                    suppliers.forEach(s => $('#selectSupplier').append(`<option value="${s.id}">${s.company_name}</option>`));
                }
            });
        }

        function loadLinkedSuppliers(productId, isAdmin) {
            $.ajax({
                url: `/api/products/${productId}/suppliers`,
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') },
                success: function(response) {
                    renderTable(response.suppliers, productId, 'product', isAdmin);
                }
            });
        }

        function loadLinkedProducts(supplierId, isAdmin) {
            $.ajax({
                url: `/api/suppliers/${supplierId}/products`,
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') },
                success: function(response) {
                    renderTable(response.products, supplierId, 'supplier', isAdmin);
                }
            });
        }

        function renderTable(data, parentId, type, isAdmin) {
            let html = '';
            if (isAdmin && parentId) $('#btnUnlinkAll').show();
            else $('#btnUnlinkAll').hide();

            if (!data || data.length === 0) {
                $('#linksTableBody').html(`<tr><td colspan="3" class="text-center py-4">No links found for this selection.</td></tr>`);
                return;
            }

            data.forEach(item => {
                const name = item.company_name || item.name;
                const detail = item.cnpj || item.internal_code;
                const itemId = item.id;

                const url = type === 'product'
                    ? `/api/products/${parentId}/suppliers/${itemId}`
                    : `/api/products/${itemId}/suppliers/${parentId}`;

                const deleteBtn = isAdmin ? `
                    <button class="btn btn-sm btn-light border" onclick="unlinkOne('${url}', '${type}', ${parentId})" title="Remove link">
                        <i class="bi bi-x-circle text-danger"></i>
                    </button>` : '';

                html += `<tr><td class="ps-3 fw-bold">${name}</td><td>${detail}</td><td class="text-end pe-3">${deleteBtn}</td></tr>`;
            });
            $('#linksTableBody').html(html);
        }

        function unlinkOne(url, type, parentId) {
            if (!confirm('Remove this specific link?')) return;
            $.ajax({
                url: url,
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') },
                success: function() {
                    showToast(true, 'Link removed successfully.');
                    const isAdmin = JSON.parse(localStorage.getItem('user')).isAdmin == 1;
                    if(type === 'product') loadLinkedSuppliers(parentId, isAdmin);
                    else loadLinkedProducts(parentId, isAdmin);
                }
            });
        }
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>