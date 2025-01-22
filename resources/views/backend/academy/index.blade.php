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
                                <th>Name</th>
                                <th>Monthly Price</th>
                                <th>Age</th>
                                <th>Phone No</th>
                                <th>Email</th>
                                <th>Total Due Left</th>
                                <th>Joined Date</th>
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
                <form id="addAcademyForm">
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
                            <input type="number" class="form-control" id="total_due_left" name="total_due_left" required>
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
</div>

<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Initialize DataTable
        $('#academyDataTable').DataTable({
            ajax: {
                url: '{{ route("academy.data") }}', // Adjust the route as necessary
                dataSrc: ''
            },
            columns: [
                { data: 'student_name' },
                { data: 'monthly_price' },
                { data: 'age' },
                { data: 'phone_no' },
                { data: 'email' },
                { data: 'total_due_left' },
                { data: 'joined_date' }
            ]
        });

        // Handle form submission
        $('#addAcademyForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route("academy.store") }}', // Adjust the route as necessary
                data: $(this).serialize(),
                success: function(response) {
                    $('#addAcademyModal').modal('hide');
                    $('#academyDataTable').DataTable().ajax.reload();
                    alert(response.success);
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
