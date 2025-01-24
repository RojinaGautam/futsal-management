@extends('backend.layout.app')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Attendance Data</h1>
    </div>

    <!-- DataTable -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Attendance Records</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="attendanceDataTable">
                        <thead class="thead-light">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>ID</th>
                                <th>Name</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($academyMembers as $academy)
                                <tr>
                                    <td><input type="checkbox" class="attendance-checkbox"></td>
                                    <td>{{ $academy->id }}</td>
                                    <td>{{ $academy->student_name }}</td>
                        
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Select/Deselect all checkboxes
        $('#selectAll').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.attendance-checkbox').prop('checked', isChecked);
        });
    });
</script>
@endsection
