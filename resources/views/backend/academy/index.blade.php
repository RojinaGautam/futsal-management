@extends('backend.layout.app')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Academy Data</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Academy</li>
        </ol>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Academy Members</h6>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="toggleFilters">
                        <i class="fas fa-filter"></i> Show/Hide Filters
                    </button>
                </div>
                <div class="card-body" id="filterPanel" style="display: none;">
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nameFilter" class="font-weight-bold">Name</label>
                                    <input type="text" class="form-control" id="nameFilter" placeholder="Filter by name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dueFilter" class="font-weight-bold">Due Amount</label>
                                    <select class="form-control" id="dueFilter">
                                        <option value="">All</option>
                                        <option value="0">No Due (0)</option>
                                        <option value="1-1000">1-1000</option>
                                        <option value="1001-5000">1001-5000</option>
                                        <option value="5001+">Above 5000</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="startDate" class="font-weight-bold">Joined Date (From)</label>
                                    <input type="date" class="form-control" id="startDate">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="endDate" class="font-weight-bold">Joined Date (To)</label>
                                    <input type="date" class="form-control" id="endDate">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" id="clearFilterButton">
                                        <i class="fas fa-eraser"></i> Clear Filters
                                    </button>
                                    <button type="button" class="btn btn-primary" id="filterButton">
                                        <i class="fas fa-search"></i> Apply Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable -->
    <div class="row">
        <div class="col-lg-12">

            <div class="card mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-lg-end justify-content-sm-start">
                    <!-- <h6 class="m-0 font-weight-bold text-primary">Academy Members</h6> -->
                    <button type="button" class="btn btn-primary justify-content-end " data-toggle="modal" data-target="#addAcademyModal">
                        Add Academy Member
                    </button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="academyDataTable" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>UN-ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Total Due Left</th>
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

    <!-- Modal for Viewing Details -->
    <!-- Modal for Viewing Details -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title font-weight-bold" id="viewDetailsModalLabel">Academy Member Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="memberDetails" class="px-3">
                        <!-- Member details will be populated dynamically -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Make a Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="paymentForm">
                    <div class="modal-body">
                        <div id="paymentMemberDetails"></div>
                        <div class="form-group">
                            <label for="payment_amount">Payment Amount</label>
                            <input type="number" class="form-control" id="payment_amount" name="payment_amount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Academy Member Modal -->
    <div class="modal fade" id="addAcademyModal" tabindex="-1" role="dialog" aria-labelledby="addAcademyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="addAcademyModalLabel">Add Academy Member</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addAcademyForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_name" class="font-weight-bold">Student Name</label>
                                    <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Enter full name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="monthly_price" class="font-weight-bold">Monthly Price</label>
                                    <input type="number" class="form-control" id="monthly_price" name="monthly_price" placeholder="Enter monthly price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="age" class="font-weight-bold">Age</label>
                                    <input type="number" class="form-control" id="age" name="age" placeholder="Enter age" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_no" class="font-weight-bold">Phone No</label>
                                    <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Enter phone number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="font-weight-bold">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="joined_date" class="font-weight-bold">Joined Date</label>
                                    <input type="date" class="form-control" id="joined_date" name="joined_date" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image" class="font-weight-bold">Student Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>
                            </div>

                            <!-- Payment Type Selection -->
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">Payment Type</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="paymentTypeDue" name="payment_type" class="custom-control-input" value="due" checked>
                                        <label class="custom-control-label" for="paymentTypeDue">Due Amount</label>
                                    </div>
                                    <div class="custom-control custom-radio mt-2">
                                        <input type="radio" id="paymentTypeAdvance" name="payment_type" class="custom-control-input" value="advance">
                                        <label class="custom-control-label" for="paymentTypeAdvance">Advance Payment</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic Payment Form -->
                            <div class="col-12">
                                <div id="dueAmountForm">
                                    <div class="form-group">
                                        <label for="total_due_left" class="font-weight-bold">Total Due Amount</label>
                                        <input type="number" class="form-control" id="total_due_left" name="total_due_left" required>
                                    </div>
                                </div>
                                <div id="advanceAmountForm" style="display: none;">
                                    <div class="form-group">
                                        <label for="advance_amount" class="font-weight-bold">Advance Amount</label>
                                        <input type="number" class="form-control" id="advance_amount" name="advance_amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Academy Member Modal -->
    <div class="modal fade" id="editAcademyModal" tabindex="-1" role="dialog" aria-labelledby="editAcademyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title font-weight-bold" id="editAcademyModalLabel">Edit Academy Member</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editAcademyForm" enctype="multipart/form-data">
                    @method('POST')
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="modal-body px-4">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_student_name" class="font-weight-bold">Student Name</label>
                                    <input type="text" class="form-control rounded-lg shadow-sm" id="edit_student_name" name="student_name" placeholder="Enter full name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_monthly_price" class="font-weight-bold">Monthly Price</label>
                                    <input type="number" class="form-control rounded-lg shadow-sm" id="edit_monthly_price" name="monthly_price" placeholder="Enter monthly price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_age" class="font-weight-bold">Age</label>
                                    <input type="number" class="form-control rounded-lg shadow-sm" id="edit_age" name="age" placeholder="Enter age" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_phone_no" class="font-weight-bold">Phone No</label>
                                    <input type="text" class="form-control rounded-lg shadow-sm" id="edit_phone_no" name="phone_no" placeholder="Enter phone number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_email" class="font-weight-bold">Email</label>
                                    <input type="email" class="form-control rounded-lg shadow-sm" id="edit_email" name="email" placeholder="Enter email address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_total_due_left" class="font-weight-bold">Total Due Left</label>
                                    <input type="number" class="form-control rounded-lg shadow-sm" id="edit_total_due_left" name="total_due_left" placeholder="Enter total due left" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_joined_date" class="font-weight-bold">Joined Date</label>
                                    <input type="date" class="form-control" id="edit_joined_date" name="joined_date" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_image" class="font-weight-bold">Student Image</label>
                                    <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                                    <div id="current_image" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary rounded-lg px-4 py-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning text-white rounded-lg px-4 py-2">Update Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



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
                    <p>Are you sure you want to delete this member?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="successMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="errorMessage"></p>
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
        $('#toggleFilters').on('click', function() {
            $('#filterPanel').slideToggle();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Initialize DataTable
        var table = $('#academyDataTable').DataTable({
            ajax: {
                url: '{{ route("academy.data") }}',
                dataSrc: '',
                data: function(d) {
                    d.nameFilter = $('#nameFilter').val();
                    d.dueFilter = $('#dueFilter').val();
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'image',
                    render: function(data, type, row) {
                        return data ?
                            `<img src="${data}" class="rounded-circle" width="50" height="50" alt="Student Image">` :
                            `<img src="images/default-avatar.png" class="rounded-circle" width="50" height="50" alt="Default Image">`;
                    }
                },
                {
                    data: 'student_name'
                },
                {
                    data: 'total_due_left',
                    render: function(data, type, row) {
                        if (data < 0) {
                            return `<span class="text-success">${Math.abs(data)} (Advance)</span>`;
                        } else {
                            return `<span class="text-danger">${data}</span>`;
                        }
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
                        return `
                            <button class="btn btn-success pay-btn" data-id="${row.id}" data-total="${row.total_due_left}" title="Pay">Pay</button>
                        `;
                    }
                }
            ]
        });

        // Handle view icon click

        $('#academyDataTable').on('click', '.view-btn', function() {
            var id = $(this).data('id');

            // Clear previous details and show loading feedback
            $('#memberDetails').html('<p>Loading details...</p>');

            $.ajax({
                type: 'GET',
                url: '/academy/' + id,
                success: function(response) {
                    // Check if response contains the expected data
                    if (response) {
                        // Populate the modal with member details
                        $('#memberDetails').html(`
                            <div class="text-center mb-4">
                                ${response.image ? 
                                    `<img src="${response.image}" class="rounded-circle" width="150" height="150" alt="Student Image">` :
                                    `<img src="images/default-avatar.png" class="rounded-circle" width="150" height="150" alt="Default Image">`
                                }
                            </div>
                            <p><strong>Name:</strong> ${response.student_name}</p>
                            <p><strong>Monthly Price:</strong> ${response.monthly_price}</p>
                            <p><strong>Age:</strong> ${response.age}</p>
                            <p><strong>Phone No:</strong> ${response.phone_no}</p>
                            <p><strong>Email:</strong> ${response.email}</p>
                            <p><strong>Payment Status:</strong> ${
                                response.total_due_left < 0 
                                    ? `<span class="text-success">${Math.abs(response.total_due_left)} (Advance)</span>`
                                    : `<span class="text-danger">${response.total_due_left}</span>`
                            }</p>
                            <p><strong>Joined Date:</strong> ${response.joined_date}</p>
                            <p><strong>Payment History:</strong></p>
                            <ul>
                                ${response.payment_history && response.payment_history.length > 0 
                                    ? response.payment_history.map(payment => `<li>Amount: ${payment.amount}, Date: ${payment.date}</li>`).join('') 
                                    : '<li>No payment history available.</li>'}
                            </ul>
                        `);
                    } else {
                        $('#memberDetails').html('<p class="text-danger">Unable to fetch member details.</p>');
                    }
                },
                error: function() {
                    $('#memberDetails').html('<p class="text-danger">Error fetching details. Please try again.</p>');
                }
            });

            // Show the modal
            $('#viewDetailsModal').modal('show');
        });

        $('#filterButton').on('click', function() {
            table.ajax.reload();
            toastr.info('Filters applied!');
        });

        // Handle clear filter button click
        $('#clearFilterButton').on('click', function() {
            $('#nameFilter').val('');
            $('#dueFilter').val('');
            $('#startDate').val('');
            $('#endDate').val('');
            table.ajax.reload();
            toastr.info('Filters cleared!');
        });
        // Handle pay button click
        $('#academyDataTable').on('click', '.pay-btn', function() {
            var id = $(this).data('id');
            var totalDueLeft = $(this).data('total');
            $('#paymentMemberDetails').html(`<p>Total Due Left: <strong>${totalDueLeft}</strong></p>`);
            $('#paymentForm').data('id', id); // Store the ID in the form
            $('#paymentModal').modal('show'); // Show the payment modal
        });

        // Handle payment form submission
        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // Ensure you set this data attribute on the payment modal
            var paymentAmount = parseFloat($('#payment_amount').val());
            var paymentDate = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

            // Validate payment amount
            if (isNaN(paymentAmount) || paymentAmount <= 0) {
                toastr.error('Payment amount must be a positive number.');
                return;
            }


            $.ajax({
                type: 'PUT',
                url: '/academy/' + id + '/payment',
                data: {
                    payment_amount: paymentAmount,
                    payment_date: paymentDate,
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    $('#paymentModal').modal('hide');
                    table.ajax.reload();

                    // Show success message with Toastr
                    toastr.success('Payment successful! New Total Due Left: ' + response.new_total_due_left);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr, status, error);

                    let errorMessage = 'An unexpected error occurred. Please try again.';

                    if (xhr.responseJSON) {
                        errorMessage = xhr.responseJSON.message || xhr.responseJSON.error || errorMessage;
                    } else if (xhr.status === 0) {
                        errorMessage = 'Network error. Please check your internet connection.';
                    } else if (xhr.status === 400) {
                        errorMessage = 'Invalid request.';
                    } else if (xhr.status === 403) {
                        errorMessage = 'You do not have permission to perform this action.';
                    } else if (xhr.status === 404) {
                        errorMessage = 'Booking not found.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Server error. Please contact support.';
                    }

                    toastr.error('Error: ' + errorMessage);
                }
            });
        });

        // Add these new handlers
        $('input[name="payment_type"]').change(function() {
            if (this.value === 'due') {
                $('#dueAmountForm').show();
                $('#advanceAmountForm').hide();
                $('#total_due_left').prop('required', true);
                $('#advance_amount').prop('required', false);
            } else {
                $('#dueAmountForm').hide();
                $('#advanceAmountForm').show();
                $('#total_due_left').prop('required', false);
                $('#advance_amount').prop('required', true);
            }
        });

        // Update the add form submission
        $('#addAcademyForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            // Handle advance payment
            if (formData.get('payment_type') === 'advance') {
                formData.set('total_due_left', -Math.abs(formData.get('advance_amount')));
                formData.delete('advance_amount');
            }
            formData.delete('payment_type');

            $.ajax({
                type: 'POST',
                url: '{{ route("academy.store") }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#addAcademyModal').modal('hide');
                    table.ajax.reload();
                    toastr.success('Academy member added successfully!');
                    
                    // Reset the form
                    $('#addAcademyForm')[0].reset();
                    $('#dueAmountForm').show();
                    $('#advanceAmountForm').hide();
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle edit button click to populate the form
        $('#academyDataTable').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            // Fetch the current data for the selected academy member
            $.ajax({
                type: 'GET',
                url: '/academy/' + id,
                success: function(response) {
                    // Populate the form fields with the current data
                    $('#edit_id').val(response.id);
                    $('#display_id').text(response.id);
                    $('#edit_student_name').val(response.student_name);
                    $('#edit_monthly_price').val(response.monthly_price);
                    $('#edit_age').val(response.age);
                    $('#edit_phone_no').val(response.phone_no);
                    $('#edit_email').val(response.email);
                    $('#edit_total_due_left').val(response.total_due_left);
                    $('#edit_joined_date').val(response.joined_date);

                    // Show current image if it exists
                    if (response.image) {
                        $('#current_image').html(`
                            <img src="${response.image}" class="rounded-circle" width="100" height="100" alt="Current Image">
                            <p class="mt-2">Current Image</p>
                        `);
                    } else {
                        $('#current_image').html(`
                            <img src="images/default-avatar.png" class="rounded-circle" width="100" height="100" alt="Default Image">
                            <p class="mt-2">No Current Image</p>
                        `);
                    }
                },
                error: function() {
                    toastr.error('Error fetching member details.');
                }
            });

            // Show the modal
            $('#editAcademyModal').modal('show');
        });

        // Handle edit form submission
        $('#editAcademyForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var id = $('#edit_id').val(); // Get the ID of the member being edited
            var formData = new FormData(this); // Create FormData object

            // Log all form data in a readable way
            console.log("Form Data:");
            formData.forEach((value, key) => {
                console.log(key + ': ' + value);
            });

            $.ajax({
                type: 'POST', // Laravel updates accept PATCH/POST
                url: '/academy/update/' + id, // URL for the update request
                data: formData,
                processData: false, // Don't process FormData
                contentType: false, // Don't set contentType
                dataType: "JSON",
                success: function(response) {
                    $('#editAcademyModal').modal('hide'); // Hide modal
                    table.ajax.reload(); // Reload DataTable
                    toastr.success(response.success); // Show success message
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr, status, error);

                    let errorMessage = 'An unexpected error occurred. Please try again.';

                    if (xhr.responseJSON) {
                        errorMessage = xhr.responseJSON.message || xhr.responseJSON.error || errorMessage;
                    } else if (xhr.status === 0) {
                        errorMessage = 'Network error. Please check your internet connection.';
                    } else if (xhr.status === 400) {
                        errorMessage = 'Invalid request.';
                    } else if (xhr.status === 403) {
                        errorMessage = 'You do not have permission to perform this action.';
                    } else if (xhr.status === 404) {
                        errorMessage = 'Booking not found.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Server error. Please contact support.';
                    }

                    toastr.error('Error: ' + errorMessage);
                }
            });
        });



        // Handle delete icon click
        $('#academyDataTable').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            $('#confirmDeleteBtn').data('id', id); // Store the ID in the delete button
            $('#deleteConfirmationModal').modal('show'); // Show the delete confirmation modal
        });

        // Handle delete confirmation
        $('#confirmDeleteBtn').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                type: 'DELETE',
                url: '/academy/' + id,
                success: function(response) {
                    $('#deleteConfirmationModal').modal('hide');
                    table.ajax.reload();
                    toastr.success(response.success);
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        $('#selectAll').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('input[type="checkbox"]').prop('checked', isChecked);
        });


    });
</script>
@endsection