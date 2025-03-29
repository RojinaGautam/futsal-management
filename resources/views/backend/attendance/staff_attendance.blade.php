@extends('backend.layout.app')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Staff Attendance</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Check In/Out</h6>
                </div>
                <div class="card-body">
                    <form id="attendanceForm">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" id="attendance_date" name="date" value="{{ date('Y-m-d') }}">

                        <div class="form-group">
                            <label for="attendanceStatus">Attendance Status</label>
                            <div id="attendanceStatus">
                                <!-- Check-in/Check-out button will be displayed here -->
                            </div>
                        </div>

                        <div id="attendanceMessage" class="mt-3" style="display: none;">
                            <div class="alert alert-success" role="alert">
                                Attendance completed for today!
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const userId = $('#user_id').val();
        const date = $('#attendance_date').val();

        // Check attendance status on page load
        $.ajax({
            type: 'GET',
            url: `/staff-attendance/${userId}/${date}`, // Adjust the URL as needed
            success: function(response) {
                if (response.check_in && response.check_out) {
                    // User has checked in and checked out
                    $('#attendanceStatus').html(`
                        <button class="btn btn-success" disabled>Checked In</button>
                        <button class="btn btn-danger" disabled>Checked Out</button>
                    `);
                    $('#attendanceMessage').show(); // Show attendance completed message
                } else if (response.check_in) {
                    // User has checked in but not checked out
                    $('#attendanceStatus').html(`
                        <button class="btn btn-danger" id="checkOutBtn">Check Out</button>
                    `);
                } else {
                    // User has not checked in
                    $('#attendanceStatus').html(`
                        <button class="btn btn-success" id="checkInBtn">Check In</button>
                    `);
                }
            },
            error: function() {
                toastr.error('Error fetching attendance status.');
            }
        });

        // Handle check-in button click
        $(document).on('click', '#checkInBtn', function() {
            $.ajax({
                type: 'POST',
                url: '/staff-attendance/check-in',
                data: {
                    user_id: userId,
                    date: date,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.message);
                    $('#attendanceStatus').html(`
                        <button class="btn btn-danger" id="checkOutBtn">Check Out</button>
                    `);
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Handle check-out button click
        $(document).on('click', '#checkOutBtn', function() {
            $.ajax({
                type: 'POST',
                url: '/staff-attendance/check-out',
                data: {
                    user_id: userId,
                    date: date,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.message);
                    $('#attendanceStatus').html(`
                        <button class="btn btn-success" id="checkInBtn">Check In</button>
                    `);
                    $('#attendanceMessage').show(); // Show attendance completed message
                },
                error: function(xhr) {
                    toastr.error('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
