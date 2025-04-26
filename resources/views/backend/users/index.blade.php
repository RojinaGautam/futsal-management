@extends('backend.layout.app')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
            Add User
        </button>
    </div>

    <!-- DataTable -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="userDataTable" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Amount</th>
                                <th>Actions</th>
                                <th>Pay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here via DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addUserForm" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="salarySection" style="display: none;">
                            <label for="monthly_salary">Monthly Salary</label>
                            <input type="number" class="form-control" id="monthly_salary" name="monthly_salary" step="0.01">
                        </div>
                        <div class="form-group" id="paymentDateSection" style="display: none;">
                            <label for="payment_date">Payment Date</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_user_id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="edit_phone_number" name="phone_number">
                        </div>
                        <div class="form-group">
                            <label for="edit_role">Role</label>
                            <select class="form-control" id="edit_role" name="role" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="edit_salarySection" style="display: none;">
                            <label for="edit_monthly_salary">Monthly Salary</label>
                            <input type="number" class="form-control" id="edit_monthly_salary" name="monthly_salary" step="0.01">
                        </div>
                        <div class="form-group" id="edit_paymentDateSection" style="display: none;">
                            <label for="edit_payment_date">Payment Date</label>
                            <input type="date" class="form-control" id="edit_payment_date" name="payment_date">
                        </div>
                        <div class="form-group" id="unlockUserSection" style="display: none;">
                            <button type="button" class="btn btn-warning" id="unlockUserBtn">Unlock User</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning text-white">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View User Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel">User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="userDetailsContent">
                        <!-- User details will be populated here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize DataTable
        var table = $('#userDataTable').DataTable({
            ajax: {
                url: '{{ route("users.data") }}',
                dataSrc: ''
            },
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1; // Calculate SN
                    }
                },
                { data: 'name' },
                { data: 'email' },
                { data: 'phone_number' },
                {
                    data: 'amount', // Display the amount
                    render: function(data) {
                        return data ? data : 'N/A'; // Display amount or N/A if not available
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                                                       <div class="d-flex">
                                <button class="btn btn-sm view-btn btn-outline-info mr-2" data-id="${row.id}" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm edit-btn btn-outline-warning mr-2" data-id="${row.id}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm delete-btn  btn-outline-danger" data-id="${row.id}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        if (row.roles.some(role => role.name === 'staff')) { // Check if the user is staff
                            return `<button class="btn btn-success pay-btn" data-id="${row.id}" data-amount="${row.amount}">Pay</button>`;
                        }
                        return ''; // No button for non-staff users
                    }
                }
            ]
        });

        // Handle add user form submission
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route("users.store") }}',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addUserModal').modal('hide');
                    table.ajax.reload();
                    toastr.success('User added successfully!');
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle edit button click
        $('#userDataTable').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            // Fetch the current data for the selected user
            $.ajax({
                type: 'GET',
                url: '/users/' + id,
                success: function(response) {
                    // Populate the form fields with the current data
                    $('#edit_user_id').val(response.id);
                    $('#edit_name').val(response.name);
                    $('#edit_email').val(response.email);
                    $('#edit_phone_number').val(response.phone_number);

                    // Check if roles exist and set the role
                    if (response.roles.length > 0) {
                        $('#edit_role').val(response.roles[0].name);
                    } else {
                        $('#edit_role').val(''); // Set to empty or a default value
                    }

                    // Check if the user is staff and populate salary and payment date
                    if (response.roles.length > 0 && response.roles[0].name === 'staff') {
                        $('#edit_salarySection').show();
                        $('#edit_paymentDateSection').show();

                        // Fetch the salary details if available
                        if (response.salaries.length > 0) {
                            $('#edit_monthly_salary').val(response.salaries[0].monthly_salary);
                            $('#edit_payment_date').val(response.salaries[0].payment_date);
                        } else {
                            $('#edit_monthly_salary').val(''); // Clear if no salary record
                            $('#edit_payment_date').val(''); // Clear if no payment date
                        }
                    } else {
                        $('#edit_salarySection').hide();
                        $('#edit_paymentDateSection').hide();
                    }

                    // Check if the user is locked
                    if (response.failed_attempts >= 5) {
                        $('#unlockUserSection').show(); // Show unlock button
                    } else {
                        $('#unlockUserSection').hide(); // Hide unlock button
                    }
                },
                error: function() {
                    toastr.error('Error fetching user details.');
                }
            });

            // Show the modal
            $('#editUserModal').modal('show');
        });

        // Handle edit form submission
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var id = $('#edit_user_id').val(); // Get the ID of the user being edited

            $.ajax({
                type: 'PUT',
                url: '/users/' + id,
                data: $(this).serialize(),
                success: function(response) {
                    $('#editUserModal').modal('hide'); // Hide modal
                    table.ajax.reload(); // Reload DataTable
                    toastr.success('User updated successfully!');
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle delete button click
        $('#userDataTable').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            $('#confirmDeleteBtn').data('id', id); // Store the ID in the delete button
            $('#deleteConfirmationModal').modal('show'); // Show the delete confirmation modal
        });

        // Handle delete confirmation
        $('#confirmDeleteBtn').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                type: 'DELETE',
                url: '/users/' + id,
                success: function(response) {
                    $('#deleteConfirmationModal').modal('hide');
                    table.ajax.reload();
                    toastr.success('User deleted successfully!');
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle unlock user button click
        $('#unlockUserBtn').on('click', function() {
            var id = $('#edit_user_id').val(); // Get the user ID

            $.ajax({
                type: 'POST',
                url: '/users/unlock', // Define the route for unlocking
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    toastr.success(response.message);
                    $('#editUserModal').modal('hide'); // Hide modal
                    table.ajax.reload(); // Reload DataTable
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Show salary fields if the selected role is staff
        $('#role').change(function() {
            if ($(this).val() === 'staff') {
                $('#salarySection').show();
                $('#paymentDateSection').show();
            } else {
                $('#salarySection').hide();
                $('#paymentDateSection').hide();
            }
        });

        // Handle view button click
        $('#userDataTable').on('click', '.view-btn', function() {
            var id = $(this).data('id');

            // Fetch the current data for the selected user
            $.ajax({
                type: 'GET',
                url: '/users/' + id,
                success: function(response) {
                    // Populate the modal with user details
                    $('#userDetailsContent').html(`
                        <p><strong>Name:</strong> ${response.name}</p>
                        <p><strong>Email:</strong> ${response.email}</p>
                        <p><strong>Phone Number:</strong> ${response.phone_number}</p>
                        <p><strong>Role:</strong> ${response.roles.length > 0 ? response.roles[0].name : 'No role assigned'}</p>
                        <p><strong>Failed Attempts:</strong> ${response.failed_attempts}</p>
                        <p><strong>Salary Details:</strong></p>
                        <ul>
                            ${response.salaries.length > 0 ? response.salaries.map(salary => `<li>Monthly Salary: ${salary.monthly_salary}, Payment Date: ${salary.payment_date}</li>`).join('') : '<li>No salary records available.</li>'}
                        </ul>
                    `);
                    // Show the modal
                    $('#viewDetailsModal').modal('show');
                },
                error: function() {
                    toastr.error('Error fetching user details.');
                }
            });
        });
    });
</script>
@endsection