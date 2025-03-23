@extends('backend.layout.app')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bookings Data</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bookings</li>
        </ol>
    </div>

    <!-- DataTable -->
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="form-group mb-0">
                        <label for="filter_date" class="mr-2">Filter by Date:</label>
                        <input type="date" class="form-control" id="filter_date" name="filter_date" value="{{ date('Y-m-d') }}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBookingModal">
                        Add New Booking
                    </button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="bookingsDataTable" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Amount Paid</th>
                                <th>Actions</th>
                                <th>Payment</th>
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

    <!-- Add Booking Modal -->
    <div class="modal fade" id="addBookingModal" tabindex="-1" role="dialog" aria-labelledby="addBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="addBookingModalLabel">Add New Booking</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addBookingForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_name" class="font-weight-bold">Name</label>
                                    <input type="text" class="form-control" id="booking_name" name="booking_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number" class="font-weight-bold">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_date" class="font-weight-bold">Booking Date</label>
                                    <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_time" class="font-weight-bold">Booking Time</label>
                                    <select class="form-control" id="booking_time" name="booking_time" required>
                                        <option value="6:00 AM - 7:00 AM">6:00 AM - 7:00 AM</option>
                                            <option value="7:00 AM - 8:00 AM">7:00 AM - 8:00 AM</option>
                                            <option value="8:00 AM - 9:00 AM">8:00 AM - 9:00 AM</option>
                                            <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                                            <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                                            <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                                            <option value="12:00 PM - 1:00 PM">12:00 PM - 1:00 PM</option>
                                            <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                                            <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                                            <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                                            <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                                            <option value="5:00 PM - 6:00 PM">5:00 PM - 6:00 PM</option>
                                            <option value="6:00 PM - 7:00 PM">6:00 PM - 7:00 PM</option>
                                            <option value="7:00 PM - 8:00 PM">7:00 PM - 8:00 PM</option>
                                            <option value="8:00 PM - 9:00 PM">8:00 PM - 9:00 PM</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_amount_paid" class="font-weight-bold">Amount Paid</label>
                                    <input type="number" step="0.01" value="0" class="form-control" id="total_amount_paid" name="total_amount_paid" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Booking Modal -->
    <div class="modal fade" id="editBookingModal" tabindex="-1" role="dialog" aria-labelledby="editBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title font-weight-bold" id="editBookingModalLabel">Edit Booking</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editBookingForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_booking_name" class="font-weight-bold">Name</label>
                                    <input type="text" class="form-control" id="edit_booking_name" name="booking_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_phone_number" class="font-weight-bold">Phone Number</label>
                                    <input type="text" class="form-control" id="edit_phone_number" name="phone_number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_booking_date" class="font-weight-bold">Booking Date</label>
                                    <input type="date" class="form-control" id="edit_booking_date" name="booking_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_booking_time" class="font-weight-bold">Booking Time</label>
                                    <select class="form-control" id="edit_booking_time" name="booking_time" required>
                                        <option value="7:00 AM - 8:00 AM">7:00 AM - 8:00 AM</option>
                                        <option value="8:00 AM - 9:00 AM">8:00 AM - 9:00 AM</option>
                                        <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                                        <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                                        <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                                        <option value="12:00 PM - 1:00 PM">12:00 PM - 1:00 PM</option>
                                        <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                                        <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                                        <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                                        <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                                        <option value="5:00 PM - 6:00 PM">5:00 PM - 6:00 PM</option>
                                        <option value="6:00 PM - 7:00 PM">6:00 PM - 7:00 PM</option>
                                        <option value="7:00 PM - 8:00 PM">7:00 PM - 8:00 PM</option>
                                        <option value="8:00 PM - 9:00 PM">8:00 PM - 9:00 PM</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_total_amount_paid" class="font-weight-bold">Amount Paid</label>
                                    <input type="number" step="any" class="form-control" id="edit_total_amount_paid" name="total_amount_paid" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning text-white">Update Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title font-weight-bold" id="viewDetailsModalLabel">Booking Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="bookingDetails" class="px-3">
                        <!-- Booking details will be populated dynamically -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this booking?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="paymentModalLabel">Make Payment</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="paymentForm">
                    <div class="modal-body">
                        <div id="paymentBookingDetails"></div>
                        <div class="form-group">
                            <label for="payment_amount">Payment Amount</label>
                            <input type="number" step="0.01" class="form-control" id="payment_amount" name="payment_amount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Submit Payment</button>
                    </div>
                </form>
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

    // Initialize DataTable with modified ajax and default date
    var table = $('#bookingsDataTable').DataTable({
        ajax: {
            url: '{{ route("bookings.data") }}',
            data: function(d) {
                d.filter_date = $('#filter_date').val() || '{{ date('Y-m-d') }}';
            },
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'booking_name' },
            { data: 'booking_date' },
            { data: 'booking_time' },
            { data: 'total_amount_paid' },
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
                            <button class="btn btn-sm delete-btn btn-outline-danger" data-id="${row.id}" title="Delete">
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
                        <button class="btn btn-success pay-btn" data-id="${row.id}" data-total="${row.total_amount_paid}">
                            Pay
                        </button>
                    `;
                }
            }
        ]
    });


    // Add event listener for date filter
    $('#filter_date').on('change', function() {
        table.ajax.reload();
    });

    // Modify clear filter functionality to set today's date instead of empty
    $('#filter_date').on('click', function() {
        if($(this).val() !== '{{ date('Y-m-d') }}') {
            $(this).val('{{ date('Y-m-d') }}');
            table.ajax.reload();
        }
    });

    // Add Booking Form Submission
    $('#addBookingForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '{{ route("bookings.store") }}',
            data: $(this).serialize(),
            success: function(response) {
                $('#addBookingModal').modal('hide');
                table.ajax.reload();
                toastr.success('Booking added successfully!');
            },
            error: function(xhr) {
                toastr.error('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    // View Booking Details
    $('#bookingsDataTable').on('click', '.view-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '/bookings/' + id,
            success: function(response) {
                $('#bookingDetails').html(`
                    <p><strong>Name:</strong> ${response.booking_name}</p>
                    <p><strong>Phone Number:</strong> ${response.phone_number}</p>
                    <p><strong>Booking Date:</strong> ${response.booking_date}</p>
                    <p><strong>Booking Time:</strong> ${response.booking_time}</p>
                    <p><strong>Amount Paid:</strong> ${response.total_amount_paid}</p>
                `);
                $('#viewDetailsModal').modal('show');
            },
            error: function() {
                toastr.error('Error fetching booking details');
            }
        });
    });

    // Edit Booking
    $('#bookingsDataTable').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '/bookings/' + id,
            success: function(response) {
                $('#edit_id').val(response.id);
                $('#edit_booking_name').val(response.booking_name);
                $('#edit_phone_number').val(response.phone_number);
                $('#edit_booking_date').val(response.booking_date);
                $('#edit_booking_time').val(response.booking_time);
                $('#edit_total_amount_paid').val(response.total_amount_paid);
                $('#editBookingModal').modal('show');
            },
            error: function() {
                toastr.error('Error fetching booking details');
            }
        });
    });

    // Update Booking
    $('#editBookingForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_id').val();
        $.ajax({
            type: 'PATCH',
            url: '/bookings/update/' + id,
            data: $(this).serialize(),
            success: function(response) {
                $('#editBookingModal').modal('hide');
                table.ajax.reload();
                toastr.success('Booking updated successfully!');
            },
            error: function(xhr) {
                toastr.error('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    // Delete Booking
    $('#bookingsDataTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        $('#confirmDeleteBtn').data('id', id);
        $('#deleteConfirmationModal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            type: 'DELETE',
            url: '/bookings/' + id,
            success: function(response) {
                $('#deleteConfirmationModal').modal('hide');
                table.ajax.reload();
                toastr.success('Booking deleted successfully!');
            },
            error: function(xhr) {
                toastr.error('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    // Handle Payment
    $('#bookingsDataTable').on('click', '.pay-btn', function() {
        var id = $(this).data('id');
        var currentAmount = $(this).data('total');
        $('#paymentBookingDetails').html(`<p>Current Amount Paid: <strong>${currentAmount}</strong></p>`);
        $('#paymentForm').data('id', id);
        $('#paymentModal').modal('show');
    });

    $('#paymentForm').on('submit', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            type: 'PUT',
            url: '/bookings/' + id + '/payment',
            data: $(this).serialize(),
            success: function(response) {
                $('#paymentModal').modal('hide');
                table.ajax.reload();
                toastr.success('Payment processed successfully!');
            },
            error: function(xhr) {
                toastr.error('Error: ' + xhr.responseJSON.message);
            }
        });

    });
});
</script>
@endsection