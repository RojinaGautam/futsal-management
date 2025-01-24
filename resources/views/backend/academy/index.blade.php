@extends('backend.layout.app')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Academy Data</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAcademyModal">
            Add Academy Member
        </button>
    </div>

    <!-- DataTable -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Academy Members</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="academyDataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
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
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel">Academy Member Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="memberDetails">
                        <img id="memberImage" src="" alt="Member Image" class="img-fluid mb-3" style="display: none;">
                        <p><strong>Name:</strong> <span id="memberName"></span></p>
                        <p><strong>Monthly Price:</strong> <span id="memberMonthlyPrice"></span></p>
                        <p><strong>Age:</strong> <span id="memberAge"></span></p>
                        <p><strong>Phone No:</strong> <span id="memberPhoneNo"></span></p>
                        <p><strong>Email:</strong> <span id="memberEmail"></span></p>
                        <p><strong>Total Due Left:</strong> <span id="memberTotalDueLeft"></span></p>
                        <p><strong>Joined Date:</strong> <span id="memberJoinedDate"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAcademyModalLabel">Add Academy Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addAcademyForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="student_name">Student Name</label>
                            <input type="text" class="form-control" id="student_name" name="student_name" required>
                        </div>
                        <div class="form-group">
                            <label for="monthly_price">Monthly Price</label>
                            <input type="number" class="form-control" id="monthly_price" name="monthly_price" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_no">Phone No</label>
                            <input type="text" class="form-control" id="phone_no" name="phone_no" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="total_due_left">Total Due Left</label>
                            <input type="number" class="form-control" id="total_due_left" name="total_due_left" value="0" required>
                        </div>
                        <div class="form-group">
                            <label for="joined_date">Joined Date</label>
                            <input type="date" class="form-control" id="joined_date" name="joined_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Academy Member Modal -->
    <div class="modal fade" id="editAcademyModal" tabindex="-1" role="dialog" aria-labelledby="editAcademyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAcademyModalLabel">Edit Academy Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editAcademyForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_student_name">Student Name</label>
                            <input type="text" class="form-control" id="edit_student_name" name="student_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_monthly_price">Monthly Price</label>
                            <input type="number" class="form-control" id="edit_monthly_price" name="monthly_price" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_age">Age</label>
                            <input type="number" class="form-control" id="edit_age" name="age" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_phone_no">Phone No</label>
                            <input type="text" class="form-control" id="edit_phone_no" name="phone_no" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_total_due_left">Total Due Left</label>
                            <input type="number" class="form-control" id="edit_total_due_left" name="total_due_left" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_joined_date">Joined Date</label>
                            <input type="date" class="form-control" id="edit_joined_date" name="joined_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Member</button>
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
            columns: [
                { data: 'id' },

                { data: 'student_name' },
                { data: 'total_due_left' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <i class="fas fa-eye text-info view-btn px-2" data-id="${row.id}" style="cursor: pointer;" title="View Details"></i>
                            <i class="fas fa-edit text-warning edit-btn px-2" data-id="${row.id}" style="cursor: pointer;" title="Edit"></i>
                            <i class="fas fa-trash text-danger delete-btn px-2" data-id="${row.id}" style="cursor: pointer;" title="Delete"></i>
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
            $.ajax({
                type: 'GET',
                url: '/academy/' + id,
                success: function(response) {
                    // Populate the modal with member details
                    $('#memberName').text(response.student_name);
                    $('#memberMonthlyPrice').text(response.monthly_price);
                    $('#memberAge').text(response.age);
                    $('#memberPhoneNo').text(response.phone_no);
                    $('#memberEmail').text(response.email);
                    $('#memberTotalDueLeft').text(response.total_due_left);
                    $('#memberJoinedDate').text(response.joined_date);

                    // Show the image if it exists
                    if (response.image) {
                        $('#memberImage').attr('src', '/images/' + response.image).show(); // Set the image source and show it
                    } else {
                        $('#memberImage').hide(); // Hide the image if it doesn't exist
                    }

                    $('#viewDetailsModal').modal('show'); // Show the modal
                }
            });
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
            var paymentAmount = parseFloat($('#payment_amount').val());
            var totalDueLeft = parseFloat($('#paymentMemberDetails strong').text());

            // Check if payment amount exceeds total due left
            if (paymentAmount > totalDueLeft) {
                $('#errorMessage').text('Payment amount cannot exceed the total due left of ' + totalDueLeft);
                $('#errorModal').modal('show'); // Show the error modal
                return; // Stop the submission
            }

            // Update the total due left
            var newTotalDueLeft = totalDueLeft - paymentAmount;

            // Make an AJAX call to update the database
            $.ajax({
                type: 'PUT',
                url: '/academy/' + id,
                data: {
                    total_due_left: newTotalDueLeft,
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    $('#paymentModal').modal('hide');
                    table.ajax.reload(); // Reload the DataTable
                    $('#successMessage').text('Payment successful! New Total Due Left: ' + newTotalDueLeft);
                    $('#successModal').modal('show'); // Show the success modal
                },
                error: function(xhr) {
                    $('#errorMessage').text('Error: ' + xhr.responseJSON.message);
                    $('#errorModal').modal('show'); // Show the error modal
                }
            });
        });

        // Handle add form submission
        $('#addAcademyForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this); // Create FormData object
            $.ajax({
                type: 'POST',
                url: '{{ route("academy.store") }}',
                data: formData,
                processData: false, // Important for file uploads
                contentType: false, // Important for file uploads
                success: function(response) {
                    $('#addAcademyModal').modal('hide');
                    table.ajax.reload();
                    $('#successMessage').text(response.success);
                    $('#successModal').modal('show'); // Show the success modal
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
            var formData = new FormData(this); // Create FormData object
            $.ajax({
                type: 'PUT',
                url: '/academy/' + id,
                data: formData,
                processData: false, // Important for file uploads
                contentType: false, // Important for file uploads
                success: function(response) {
                    $('#editAcademyModal').modal('hide');
                    table.ajax.reload();
                    $('#successMessage').text(response.success);
                    $('#successModal').modal('show'); // Show the success modal
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
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
                    $('#successMessage').text(response.success);
                    $('#successModal').modal('show'); // Show the success modal
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        $('#selectAll').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('input[type="checkbox"]').prop('checked', isChecked);
        });

        $('#attendanceForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serializeArray(); // Use serializeArray to get an array of form data
            var attendanceData = {};

            // Build the attendance data object
            formData.forEach(function(item) {
                if (item.name.startsWith('attendance')) {
                    attendanceData[item.name.split('[')[1].split(']')[0]] = item.value; // Extract the member ID
                }
            });

            // Check if attendance data is empty
            if (Object.keys(attendanceData).length === 0) {
                alert('Please select at least one member to mark attendance.');
                return; // Stop the submission
            }

            // Add the attendance date to the data
            attendanceData.attendance_date = $('#attendance_date').val();

            $.ajax({
                type: 'POST',
                url: '{{ route("attendance.store") }}',
                data: {
                    attendance: attendanceData,
                    attendance_date: $('#attendance_date').val(),
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    alert(response.success);
                    location.reload(); // Reload the page to see updated attendance
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
