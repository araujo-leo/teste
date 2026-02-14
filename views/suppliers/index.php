<?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Suppliers</h2>
            <p class="text-muted small">Manage partner companies and contact info</p>
        </div>
        <button class="btn btn-primary shadow-sm" id="btnCreateSupplier" onclick="openModal()" style="display: none;">
            <i class="bi bi-plus-lg"></i> New Supplier
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                    <tr>
                        <th class="ps-4">CNPJ</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th class="text-end pe-4" id="actionsHeader">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="suppliersTableBody">
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <br><span class="mt-2 d-block">Loading suppliers...</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form id="supplierForm">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalTitle">Supplier</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" id="supplierId" name="id">

                        <div class="mb-3">
                            <label for="cnpj" class="form-label fw-bold">CNPJ</label>
                            <input type="text" class="form-control" id="cnpj" placeholder="00.000.000/0000-00" required>
                        </div>

                        <div class="mb-3">
                            <label for="companyName" class="form-label fw-bold">Company Name</label>
                            <input type="text" class="form-control" id="companyName" placeholder="Full company name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="contact@company.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Phone</label>
                            <input type="text" class="form-control" id="phone" placeholder="(00) 00000-0000" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select class="form-select" id="status">
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
                $('#btnCreateSupplier').show();
                $('#actionsHeader').show();
            } else {
                $('#actionsHeader').hide();
            }

            loadSuppliers(isAdmin);
            $('#supplierForm').on('submit', function(e) {
                e.preventDefault();
                saveSupplier();
            });
        });

        function loadSuppliers(isAdmin) {
            $.ajax({
                url: '/api/suppliers',
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') },
                success: function(response) {
                    let html = '';
                    const suppliers = response.data || response;

                    if (!suppliers || suppliers.length === 0) {
                        $('#suppliersTableBody').html('<tr><td colspan="6" class="text-center py-4">No suppliers found.</td></tr>');
                        return;
                    }

                    suppliers.forEach(supplier => {
                        const editAction = isAdmin ? `
                            <button class="btn btn-sm btn-light border" onclick='openModal(${JSON.stringify(supplier)})' title="Edit">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </button>
                        ` : '';

                        html += `
                        <tr>
                            <td class="ps-4 fw-bold">${supplier.cnpj}</td>
                            <td>${supplier.company_name}</td>
                            <td>${supplier.email}</td>
                            <td>${supplier.phone}</td>
                            <td>
                                <span class="badge rounded-pill ${supplier.status === 'active' ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border border-secondary'}">
                                    ${supplier.status.charAt(0).toUpperCase() + supplier.status.slice(1)}
                                </span>
                            </td>
                            <td class="text-end pe-4">${editAction}</td>
                        </tr>`;
                    });
                    $('#suppliersTableBody').html(html);
                },
                error: function(xhr) {
                    showToast('Error loading suppliers list.');
                    $('#suppliersTableBody').html('<tr><td colspan="6" class="text-center text-danger">Error loading data.</td></tr>');
                }
            });
        }

        function openModal(supplier = null) {
            const modalEl = document.getElementById('supplierModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            $('#supplierForm')[0].reset();

            if (supplier) {
                $('#modalTitle').html('<i class="bi bi-pencil me-2"></i>Edit Supplier');
                $('#supplierId').val(supplier.id);
                $('#cnpj').val(supplier.cnpj);
                $('#companyName').val(supplier.company_name);
                $('#email').val(supplier.email);
                $('#phone').val(supplier.phone);
                $('#status').val(supplier.status);
            } else {
                $('#modalTitle').html('<i class="bi bi-plus-lg me-2"></i>New Supplier');
                $('#supplierId').val('');
            }
            modal.show();
        }

        function saveSupplier() {
            const id = $('#supplierId').val();
            const data = {
                cnpj: $('#cnpj').val(),
                company_name: $('#companyName').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                status: $('#status').val()
            };

            const url = id ? `/api/supplier/${id}` : '/api/supplier';
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') },
                data: JSON.stringify(data),
                success: function(response) {
                    bootstrap.Modal.getInstance(document.getElementById('supplierModal')).hide();
                    const user = JSON.parse(localStorage.getItem('user') || '{}');
                    loadSuppliers(user.isAdmin == 1);
                    showToast('Supplier saved successfully!');
                },
                error: function(xhr) {
                    let msg = 'Error processing request.';
                    try {
                        const res = JSON.parse(xhr.responseText);
                        msg = res.error || res.message || msg;
                    } catch(e){}
                    showToast(msg);
                }
            });
        }
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>