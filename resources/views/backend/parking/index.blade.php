@extends('backend.layout.app')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Parkings in CI/CD</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Parking</li>
        </ol>
    </div>

    <!-- Filter Section -->
    <!-- Filter Section for Parking Data -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Parking Entries</h6>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="toggleParkingFilters">
                        <i class="fas fa-filter"></i> Show/Hide Filters
                    </button>
                </div>
                <div class="card-body" id="parkingFilterPanel" style="display: none;">
                    <form id="parkingFilterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nameFilter" class="font-weight-bold">Name</label>
                                    <input type="text" class="form-control" id="nameFilter" placeholder="Filter by name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="addressFilter" class="font-weight-bold">Address</label>
                                    <input type="text" class="form-control" id="addressFilter" placeholder="Filter by address">
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
                                    <label for="priceFilter" class="font-weight-bold">Monthly Price</label>
                                    <select class="form-control" id="priceFilter">
                                        <option value="">All</option>
                                        <option value="0-500">0-500</option>
                                        <option value="501-1000">501-1000</option>
                                        <option value="1001+">Above 1000</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="startDate" class="font-weight-bold">Date From</label>
                                    <input type="date" class="form-control" id="startDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="endDate" class="font-weight-bold">Date To</label>
                                    <input type="date" class="form-control" id="endDate">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" id="clearParkingFilterButton">
                                        <i class="fas fa-eraser"></i> Clear Filters
                                    </button>
                                    <button type="button" class="btn btn-primary" id="applyParkingFilterButton">
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addParkingModal">
                        Add Parking Record
                    </button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="parkingDataTable" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Monthly Price</th>
                                <th>Total Due</th>
                                <th>Actions</th>
                                <th>Pay</th> <!-- New Column for Pay Button -->
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
                        <input type="hidden" id="payment_parking_id" name="parking_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Parking Modal -->
    <div class="modal fade" id="addParkingModal" tabindex="-1" role="dialog" aria-labelledby="addParkingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="addParkingModalLabel">Add Parking Record</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addParkingForm">
                    <div class="modal-body">
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number" class="font-weight-bold">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="font-weight-bold">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="monthly_price" class="font-weight-bold">Monthly Price</label>
                                    <input type="number" class="form-control" id="monthly_price" name="monthly_price" required>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Type Selection -->
                        <div class="row mt-3">
                            <div class="col-12">
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
                        </div>

                        <!-- Dynamic Payment Form -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div id="dueAmountForm">
                                    <div class="form-group">
                                        <label for="total_due" class="font-weight-bold">Total Due Amount</label>
                                        <input type="number" class="form-control" id="total_due" name="total_due" required>
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
                        <button type="submit" class="btn btn-primary">Add Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Parking Modal -->
    <div class="modal fade" id="editParkingModal" tabindex="-1" role="dialog" aria-labelledby="editParkingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title font-weight-bold" id="editParkingModalLabel">Edit Parking Record</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editParkingForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_name" class="font-weight-bold">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_phone_number" class="font-weight-bold">Phone Number</label>
                            <input type="text" class="form-control" id="edit_phone_number" name="phone_number" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_address" class="font-weight-bold">Address</label>
                            <input type="text" class="form-control" id="edit_address" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_monthly_price" class="font-weight-bold">Monthly Price</label>
                            <input type="number" class="form-control" id="edit_monthly_price" name="monthly_price" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_total_due" class="font-weight-bold">Total Due</label>
                            <input type="number" class="form-control" id="edit_total_due" name="total_due" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Update Record</button>
                    </div>
                </form>
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
                <p>Are you sure you want to delete this parking record? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Add this after your existing modals -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold" id="viewDetailsModalLabel">Parking Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="parkingDetails" class="px-3">
                    <!-- Details will be populated dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
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

        $('#toggleParkingFilters').on('click', function() {
            $('#parkingFilterPanel').slideToggle();
        });


        // Initialize DataTable
        var table = $('#parkingDataTable').DataTable({
            ajax: {
                url: '{{ route("parkings.data") }}',
                dataSrc: '',
                data: function(d) {
                    d.nameFilter = $('#nameFilter').val();
                    d.addressFilter = $('#addressFilter').val();
                    d.dueFilter = $('#dueFilter').val();
                    d.priceFilter = $('#priceFilter').val();
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'phone_number' },
                { data: 'address' },
                { data: 'monthly_price' },
                { 
                    data: 'total_due',
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
                            <button class="btn btn-success pay-btn" data-id="${row.id}" data-total="${row.total_due}" title="Pay">Pay</button>
                        `;
                    }
                }
            ]
        });

        $('#applyParkingFilterButton').on('click', function() {
            table.ajax.reload();
            toastr.info('Filters applied!');
        });

        // Handle clear filter button click
        $('#clearParkingFilterButton').on('click', function() {
            $('#nameFilter').val('');
            $('#addressFilter').val('');
            $('#dueFilter').val('');
            $('#priceFilter').val('');
            $('#startDate').val('');
            $('#endDate').val('');
            table.ajax.reload();
            toastr.info('Filters cleared!');
        });

        // Handle pay button click
        $('#parkingDataTable').on('click', '.pay-btn', function() {
            var id = $(this).data('id');
            var totalDue = $(this).data('total');
            var displayAmount = totalDue < 0 
                ? `${Math.abs(totalDue)} (Advance)` 
                : totalDue;
            
            $('#paymentMemberDetails').html(`
                <p>Paying for parking ID: ${id}</p>
                <p>Current Status: <span class="${totalDue < 0 ? 'text-success' : 'text-danger'}">${displayAmount}</span></p>
            `);
            $('#payment_parking_id').val(id);
            $('#paymentModal').modal('show');
        });

        // Handle payment form submission
        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#payment_parking_id').val();
            var paymentAmount = $('#payment_amount').val();

            $.ajax({
                type: 'PUT',
                url: '/parkings/' + id + '/payment',
                data: {
                    payment_amount: paymentAmount,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#paymentModal').modal('hide');
                    table.ajax.reload();
                    toastr.success('Payment successful! New Total Due: ' + response.new_total_due);
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle payment type radio button change
        $('input[name="payment_type"]').change(function() {
            if (this.value === 'due') {
                $('#dueAmountForm').show();
                $('#advanceAmountForm').hide();
                $('#total_due').prop('required', true);
                $('#advance_amount').prop('required', false);
            } else {
                $('#dueAmountForm').hide();
                $('#advanceAmountForm').show();
                $('#total_due').prop('required', false);
                $('#advance_amount').prop('required', true);
            }
        });

        // Modify the add form submission
        $('#addParkingForm').on('submit', function(e) {
            e.preventDefault();
            
            let formData = $(this).serializeArray();
            let paymentType = $('input[name="payment_type"]:checked').val();
            let finalData = {};

            // Convert serialized array to object
            formData.forEach(item => {
                finalData[item.name] = item.value;
            });

            // Handle the total_due based on payment type
            if (paymentType === 'advance') {
                // Store advance payment as negative value
                finalData.total_due = -Math.abs(finalData.advance_amount);
                delete finalData.advance_amount; // Remove the advance_amount field
            }

            // Remove payment_type from final data
            delete finalData.payment_type;

            $.ajax({
                type: 'POST',
                url: '{{ route("parkings.store") }}',
                data: finalData,
                success: function(response) {
                    $('#addParkingModal').modal('hide');
                    table.ajax.reload();
                    toastr.success('Parking record added successfully!');
                    
                    // Reset the form
                    $('#addParkingForm')[0].reset();
                    $('#dueAmountForm').show();
                    $('#advanceAmountForm').hide();
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle edit button click
        $('#parkingDataTable').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: '/parkings/' + id,
                success: function(response) {
                    $('#edit_id').val(response.id);
                    $('#edit_name').val(response.name);
                    $('#edit_phone_number').val(response.phone_number);
                    $('#edit_address').val(response.address);
                    $('#edit_monthly_price').val(response.monthly_price);
                    $('#edit_total_due').val(response.total_due);
                    $('#editParkingModal').modal('show');
                },
                error: function() {
                    toastr.error('Error fetching parking record details.');
                }
            });
        });

        // Handle edit form submission
        $('#editParkingForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                type: 'PATCH',
                url: '/parkings/update/' + id,
                data: $(this).serialize(),
                success: function(response) {
                    $('#editParkingModal').modal('hide');
                    table.ajax.reload();
                    toastr.success('Parking record updated successfully!');
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle delete button click
        $('#parkingDataTable').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            $('#confirmDeleteBtn').data('id', id);
            $('#deleteConfirmationModal').modal('show');
        });

        // Handle delete confirmation
        $('#confirmDeleteBtn').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                type: 'DELETE',
                url: '/parkings/' + id,
                success: function(response) {
                    $('#deleteConfirmationModal').modal('hide');
                    table.ajax.reload();
                    toastr.success('Parking record deleted successfully!');
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Add this handler for the view button
        $('#parkingDataTable').on('click', '.view-btn', function() {
            var id = $(this).data('id');
            
            // Clear previous details and show loading
            $('#parkingDetails').html('<p>Loading details...</p>');
            
            $.ajax({
                type: 'GET',
                url: '/parkings/' + id,
                success: function(response) {
                    if (response) {
                        $('#parkingDetails').html(`
                            <div class="mb-4">
                                <h6 class="font-weight-bold">Basic Information</h6>
                                <p><strong>Name:</strong> ${response.name}</p>
                                <p><strong>Phone Number:</strong> ${response.phone_number}</p>
                                <p><strong>Address:</strong> ${response.address}</p>
                                <p><strong>Monthly Price:</strong> ${response.monthly_price}</p>
                                <p><strong>Payment Status:</strong> ${
                                    response.total_due < 0 
                                        ? `<span class="text-success">${Math.abs(response.total_due)} (Advance)</span>`
                                        : `<span class="text-danger">${response.total_due}</span>`
                                }</p>
                            </div>
                            <div>
                                <h6 class="font-weight-bold">Payment History</h6>
                                ${response.payment_history && response.payment_history.length > 0 
                                    ? '<ul class="list-unstyled">' + 
                                        response.payment_history.map(payment => 
                                            `<li class="mb-2">
                                                <span class="badge badge-success">Amount: ${payment.amount}</span>
                                                <span class="badge badge-info">Date: ${payment.date}</span>
                                            </li>`
                                        ).join('') + 
                                        '</ul>'
                                    : '<p>No payment history available.</p>'
                                }
                            </div>
                        `);
                    } else {
                        $('#parkingDetails').html('<p class="text-danger">Unable to fetch details.</p>');
                    }
                },
                error: function() {
                    $('#parkingDetails').html('<p class="text-danger">Error fetching details. Please try again.</p>');
                }
            });

            $('#viewDetailsModal').modal('show');
        });
    });
</script>
@endsection