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

 

    <!-- DataTable -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-end">
                    <!-- <h6 class="m-0 font-weight-bold text-primary">Academy Members</h6> -->
                    <button type="button" class="btn btn-primary justify-content-end " data-toggle="modal" data-target="#addAcademyModal">
                        Add Academy Member
                    </button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="academyDataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>UN-ID</th>
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

    <style>
        .modal-header {
            background-color: #17a2b8;
            color: white;
        }

        .modal-content {
            border-radius: 10px;
        }

        #memberDetails p {
            font-size: 16px;
            margin-bottom: 8px;
        }

        #memberDetails p strong {
            color: #343a40;
        }
    </style>


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
                <form id="addAcademyForm">
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
                                    <label for="total_due_left" class="font-weight-bold">Total Due Left</label>
                                    <input type="number" class="form-control" id="total_due_left" name="total_due_left" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="joined_date" class="font-weight-bold">Joined Date</label>
                                    <input type="date" class="form-control" id="joined_date" name="joined_date" required>
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
                <form id="editAcademyForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_student_name" class="font-weight-bold">Student Name</label>
                                    <input type="text" class="form-control" id="edit_student_name" name="student_name" placeholder="Enter full name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_monthly_price" class="font-weight-bold">Monthly Price</label>
                                    <input type="number" class="form-control" id="edit_monthly_price" name="monthly_price" placeholder="Enter monthly price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_age" class="font-weight-bold">Age</label>
                                    <input type="number" class="form-control" id="edit_age" name="age" placeholder="Enter age" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_phone_no" class="font-weight-bold">Phone No</label>
                                    <input type="text" class="form-control" id="edit_phone_no" name="phone_no" placeholder="Enter phone number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_email" class="font-weight-bold">Email</label>
                                    <input type="email" class="form-control" id="edit_email" name="email" placeholder="Enter email address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_total_due_left" class="font-weight-bold">Total Due Left</label>
                                    <input type="number" class="form-control" id="edit_total_due_left" name="total_due_left" placeholder="Enter total due left" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_joined_date" class="font-weight-bold">Joined Date</label>
                                    <input type="date" class="form-control" id="edit_joined_date" name="joined_date" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning text-white">Update Member</button>
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

</div>

<script>
    $(document).ready(function() {
        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize DataTable
        var table = $('#academyDataTable').DataTable({
            ajax: {
                url: '{{ route("academy.data") }}',
                dataSrc: ''
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'student_name'
                },
                {
                    data: 'total_due_left'
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
                            <p><strong>Name:</strong> ${response.student_name}</p>
                            <p><strong>Monthly Price:</strong> ${response.monthly_price}</p>
                            <p><strong>Age:</strong> ${response.age}</p>
                            <p><strong>Phone No:</strong> ${response.phone_no}</p>
                            <p><strong>Email:</strong> ${response.email}</p>
                            <p><strong>Total Due Left:</strong> ${response.total_due_left}</p>
                            <p><strong>Joined Date:</strong> ${response.joined_date}</p>
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
            var id = $(this).data('id');
            var paymentAmount = $('#payment_amount').val();
            var totalDueLeft = parseFloat($('#paymentMemberDetails strong').text());

            // Update the total due left
            var newTotalDueLeft = totalDueLeft - parseFloat(paymentAmount);

            // Make an AJAX call to update the database (you need to implement this in your controller)
            $.ajax({
                type: 'PUT',
                url: '/academy/' + id,
                data: {
                    total_due_left: newTotalDueLeft,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    $('#paymentModal').modal('hide');
                    table.ajax.reload(); // Reload the DataTable
                    alert('Payment successful! New Total Due Left: ' + newTotalDueLeft);
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle add form submission
        $('#addAcademyForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route("academy.store") }}',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addAcademyModal').modal('hide');
                    table.ajax.reload();
                    $('#successMessage').text(response.success);
                    $('#successModal').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle edit icon click
        $('#academyDataTable').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: '/academy/' + id,
                success: function(response) {
                    $('#edit_id').val(response.id);
                    $('#edit_student_name').val(response.student_name);
                    $('#edit_monthly_price').val(response.monthly_price);
                    $('#edit_age').val(response.age);
                    $('#edit_phone_no').val(response.phone_no);
                    $('#edit_email').val(response.email);
                    $('#edit_total_due_left').val(response.total_due_left);
                    $('#edit_joined_date').val(response.joined_date);
                    $('#editAcademyModal').modal('show'); // Show the edit modal
                }
            });
        });

        // Handle edit form submission
        $('#editAcademyForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                type: 'PUT',
                url: '/academy/' + id,
                data: $(this).serialize(),
                success: function(response) {
                    $('#editAcademyModal').modal('hide');
                    table.ajax.reload();
                    $('#successMessage').text(response.success);
                    $('#successModal').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle delete icon click
        $('#academyDataTable').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            $('#confirmDeleteBtn').data('id', id); // Store the ID in the confirm button
            $('#deleteConfirmationModal').modal('show'); // Show the confirmation modal
        });

        // Handle confirm delete button click
        $('#confirmDeleteBtn').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                type: 'DELETE',
                url: '/academy/' + id,
                success: function(response) {
                    $('#deleteConfirmationModal').modal('hide');
                    table.ajax.reload();
                    $('#successMessage').text(response.success);
                    $('#successModal').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection