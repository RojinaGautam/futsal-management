@extends('backend.layout.app')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Student Attendance</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Academy</li>
        </ol>
    </div>

    <!-- Attendance Date Filter -->
    <div class="row mb-4">
        <div class="col-md-4 d-flex">

            <div class="input-group">
                <input type="date" id="attendance_date" class="form-control border-0 shadow-sm" />
                <div class="input-group-append">
                    <button id="filterAttendance" class="btn btn-success px-4 py-2">
                        <i class="fas fa-search"></i> Load Attendance
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-chalkboard-teacher"></i> Mark Attendance</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-striped table-bordered table-hover" id="attendanceDataTable">
                        <thead class="thead-light">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>UN-ID</th>
                                <th>Name</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table Body will be populated after the date filter is applied -->
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <div>
                        <button id="submitAttendance" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Submit Attendance
                        </button>
                    </div>
                    <div class="text-muted">
                        <small>Note: Ensure to check the attendance before submitting.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Set default date to today's date
    var today = new Date().toISOString().split('T')[0];
    $('#attendance_date').val(today);

    // Initialize DataTable with defer render to improve performance
    var attendanceTable = $('#attendanceDataTable').DataTable({
        paging: false,
        searching: true,
        info: false,
        orderClasses: false,
        deferRender: true
    });

    $('#selectAll').on('change', function() {
        var isChecked = $(this).is(':checked');
        $('.attendance-checkbox').prop('checked', isChecked);
    });

    // Filter Attendance by Date
    $('#filterAttendance').on('click', function() {
        var selectedDate = $('#attendance_date').val();
        
        $('#attendance_date').val(selectedDate);

        if (!selectedDate) {
            toastr.warning('Please select a date.');
            return;
        }

        // AJAX to fetch attendance data for the selected date
        $.ajax({
            url: "{{ route('attendance.fetch') }}",
            method: "GET",
            data: {
                date: selectedDate,
            },
            success: function(response) {
                // Clear the existing table
                attendanceTable.clear();

                if (response.attendance.length > 0) {
                    // Populate the table with fetched attendance data
                    response.attendance.forEach(function(item) {
                        attendanceTable.row.add([
                            `<td class="text-center">
                                <input type="checkbox" class="attendance-checkbox" 
                                       value="${item.academy_member_id}" 
                                       ${item.status === 1 ? 'checked' : ''}>
                            </td>`,
                            item.academy_member_id,
                            item.student_name
                        ]);
                    });
                } else {
                    // If no attendance data is found, show all academy members as absent
                    response.academyMembers.forEach(function(academy) {
                        attendanceTable.row.add([
                            `<td class="text-center">
                                <input type="checkbox" class="attendance-checkbox" 
                                       value="${academy.id}">
                            </td>`,
                            academy.id,
                            academy.student_name
                        ]);
                    });
                }

                // Redraw the table to show new data and reapply search
                attendanceTable.draw();

                // Rebind select all and checkbox events
                $('#selectAll').on('change', function() {
                    var isChecked = $(this).is(':checked');
                    $('.attendance-checkbox').prop('checked', isChecked);
                });

                toastr.info('Attendance data loaded for ' + selectedDate);
            },
            error: function(xhr) {
                toastr.error('An error occurred while fetching attendance data.');
            }
        });
    });

    // Submit Attendance
    $('#submitAttendance').on('click', function() {
        var presentIds = [];

        // Collect IDs of checked rows (Present students)
        $('.attendance-checkbox:checked').each(function() {
            presentIds.push($(this).val());
        });

        // AJAX Submission
        $.ajax({
            url: "{{ route('attendance.submit') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                present_ids: presentIds,
                date: $('#attendance_date').val(),
            },
            success: function(response) {
                toastr.success(response.message || 'Attendance submitted successfully.');
            },
            error: function(xhr) {
                toastr.error('An error occurred while submitting attendance.');
            }
        });
    });

    // Trigger initial load on page load
    $('#filterAttendance').click();
});
</script>

@endsection
