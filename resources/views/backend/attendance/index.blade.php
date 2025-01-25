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
                    <button id="filterAttendance" class="btn btn-primary px-4 py-2">
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
                <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-chalkboard-teacher"></i> Mark Attendance</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-striped table-bordered table-hover" id="attendanceDataTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center"><input type="checkbox" id="selectAll"></th>
                                <th>ID</th>
                                <th>Student Name</th>
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

    // Initialize DataTable
    var attendanceTable = $('#attendanceDataTable').DataTable({
        paging: false, // Disable pagination to show all records
        searching: true, // Enable search for filtering
        info: false, // Disable "Showing X of Y entries"
        ordering: false, // Disable column ordering
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
            alert('Please select a date.');
            return;
        }

        // AJAX to fetch attendance data for the selected date
        $.ajax({
            url: "{{ route('attendance.fetch') }}", // Adjust the route to fetch data based on the selected date
            method: "GET",
            data: {
                date: selectedDate,
            },
            success: function(response) {
                // Clear previous table data
                var tableBody = $('#attendanceDataTable tbody');
                tableBody.empty(); // Clear existing rows

                if (response.attendance.length > 0) {
                    // Populate the table with fetched attendance data
                    response.attendance.forEach(function(item) {
                        var row = `<tr data-id="${item.academy_member_id}">
                            <td class="text-center"><input type="checkbox" class="attendance-checkbox" value="${item.academy_member_id}" ${item.status === 1 ? 'checked' : ''}></td>
                            <td>${item.academy_member_id}</td>
                            <td>${item.student_name}</td>
                        </tr>`;
                        tableBody.append(row);
                    });
                } else {
                    // If no attendance data is found, show all academy members as absent
                    response.academyMembers.forEach(function(academy) {
                        var row = `<tr data-id="${academy.id}">
                            <td class="text-center"><input type="checkbox" class="attendance-checkbox" value="${academy.id}"></td>
                            <td>${academy.id}</td>
                            <td>${academy.student_name}</td>
                        </tr>`;
                        tableBody.append(row);
                    });
                }
         

        
                alert('Attendance data loaded for ' + selectedDate);
            },
            error: function(xhr) {
                alert('An error occurred while fetching attendance data.');
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
            url: "{{ route('attendance.submit') }}", // Adjust your route as needed
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                present_ids: presentIds,
                date: $('#attendance_date').val(), // Send the selected date for submission
            },
            success: function(response) {
                alert(response.message || 'Attendance submitted successfully.');
            },
            error: function(xhr) {
                alert('An error occurred while submitting attendance.');
            }
        });
    });
});
</script>

@endsection
