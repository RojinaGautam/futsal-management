<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="{{ global_asset('img/logo/logo.png') }}" rel="icon">
  <title>ravess - DashboardD</title>
  <link href="{{ global_asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ global_asset('backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ global_asset('backend/css/ruang-admin.min.css') }}" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Add CSRF token here -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="{{ global_asset('backend/vendor/datatables/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" href="{{global_asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}">
  <script src="{{ global_asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ global_asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <!-- 
      <script src="{{ global_asset('backend/vendor/datatables/dataTables.bootstrap4.js') }}"></script>
      
      <script src="{{ global_asset('backend/vendor/datatables/jquery.dataTables.js') }}"></script> -->
  <!-- Toastr CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
          <!-- <img src="img/logo/logo2.png"> -->
        </div>
        <div class="sidebar-brand-text mx-3">Rave Futsal</div>
      </a>
      <div class="nav-separator"></div>
      <li class="nav-item">
        <a class="nav-link" href="/admin">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <div class="nav-separator"></div>
      <li class="nav-item">
        <a class="nav-link" href="/bookings">
          <i class="fas fa-fw fa-book"></i>
          <span>Bookings</span>
        </a>
      </li>
      <div class="nav-separator"></div>
      <li class="nav-item">
        <a class="nav-link" href="/parkings">
          <i class="fas fa-fw fa-parking"></i>
          <span>Parking</span>
        </a>
      </li>
      <div class="nav-separator"></div>
      <li class="nav-item">
        <a class="nav-link" href="/academy">
          <i class="fas fa-fw fa-football-ball"></i>
          <span>Academy</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/users">
          <i class="fas fa-fw fa-user"></i>
          <span>Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/staff-attendance">
          <i class="fas fa-fw fa-calendar-check"></i>
          <span>Attendance</span>
        </a>
      </li>
      <div class="nav-separator"></div>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?" aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-warning badge-counter">2</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/man.png" style="max-width: 60px" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been
                      having.</div>
                    <div class="small text-gray-500">Udin Cilok · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/girl.png" style="max-width: 60px" alt="">
                    <div class="status-indicator bg-default"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people
                      say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Jaenab · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks fa-fw"></i>
                <span class="badge badge-success badge-counter">3</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Task
                </h6>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Design Button
                      <div class="small float-right"><b>50%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Make Beautiful Transitions
                      <div class="small float-right"><b>30%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Create Pie Chart
                      <div class="small float-right"><b>75%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>
              </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          @if(auth()->check())
            <div class="user-info">
                @if(auth()->user()->hasRole('super-admin'))
                    <span class="badge badge-danger">Super Admin</span>
                @elseif(auth()->user()->hasRole('admin'))
                    <span class="badge badge-warning">Admin</span>
                @elseif(auth()->user()->hasRole('staff'))
                    <span class="badge badge-info">Staff</span>
                @else
                    <span class="badge badge-secondary">User</span>
                @endif
            </div>
          @endif
          @yield('content')
        </div>

        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to logout?</p>
              </div>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script>
                document.write(new Date().getFullYear());
              </script> - developed by
              <b><a href="https://dstudiosnepal.com/" target="_blank">dstudiosnepal</a></b>
            </span>
          </div>
        </div>

      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="{{ global_asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ global_asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ global_asset('backend/js/ruang-admin.min.js') }}"></script>
  <script src="{{ global_asset('backend/vendor/chart.js/Chart.min.js') }}"></script>
  <script src="{{ global_asset('backend/js/demo/chart-area-demo.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    // Optional: Set default options for Toastr
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000", // How long the toast will display without user interaction
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn", // Fade in
      "hideMethod": "fadeOut" // Fade out
    };
    $(document).ready(function() {
      // Get the current URL path
      var path = window.location.pathname;

      // Find the most specific matching link
      $('.sidebar .nav-item .nav-link').each(function() {
        var href = $(this).attr('href');

        // Check if the href is defined and matches the current path
        if (href && (path === href || path.startsWith(href + '/'))) {
          // Remove any previous selections
          $('.sidebar .nav-item .nav-link').removeClass('selected');
          // Add selected class to this link
          $(this).addClass('selected');
        }
      });
    });
  </script>
  <style>
    /* Custom styling for the sidebar */
    .sidebar {
      background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
      border-right: 1px solid #e3e6f0;
    }

    /* Custom separator between nav items */
    .nav-separator {
      height: 0;
      margin: 0.1rem 1rem;
      border-top: 1px solid rgba(0, 0, 0, 0.05);
      box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05);
    }


    /* Style for navbar items */
    .sidebar .nav-item {
      position: relative;
      margin-bottom: 5px;
    }

    /* Styling for navigation links */
    .sidebar .nav-item .nav-link {
      display: block;
      padding: 0.5rem 1rem;
      color: #3a3b45;
      font-weight: 500;
      border-left: 4px solid transparent;
      transition: all 0.3s ease;
      border-radius: 0 5px 5px 0;
      margin: 2px 0;
      line-height: 1.5;
    }

    /* Hover effect for nav links */
    .sidebar .nav-item .nav-link:hover {
      background-color: rgba(92, 147, 107, 0.1);
      color: #5c936b;
      transform: translateX(3px);
      border-left: 4px solid #5c936b;
      padding-top: 0.5rem;
      padding-bottom: 0.5rem;
    }

    /* Selected/active nav link */
    .sidebar .nav-item .nav-link.selected {
      color: #5c936b;
      border-radius: 0 7px 7px 0;
      border-left: 5px solid #5c936b;
      font-weight: 600;
      padding-top: 0.5rem;
      padding-bottom: 0.5rem;
    }

    /* Keep selected link styling consistent on hover */
    .sidebar .nav-item .nav-link.selected:hover {
      transform: translateX(3px);
      background-color: rgba(92, 147, 107, 0.2);
    }

    /* Icon styling in nav links */
    .sidebar .nav-item .nav-link i {
      margin-right: 0.5rem;
      font-size: 1rem;
      opacity: 0.8;
      width: 20px;
      text-align: center;
      transition: all 0.3s ease;
    }

    /* Icon in selected nav link */
    .sidebar .nav-item .nav-link.selected i {
      opacity: 1;
      color: #5c936b;
    }

    /* Add a subtle pulse animation to selected icon */
    .sidebar .nav-item .nav-link.selected:hover i {
      animation: pulse 1s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.1);
      }

      100% {
        transform: scale(1);
      }
    }

    /* Brand section styling */
    .sidebar-brand {
      padding: 1.2rem 1rem;
      background-color: #5c936b;
      color: white;
      transition: all 0.3s ease;
    }

    .sidebar-brand:hover {
      background-color: #4e8760;
    }

    .sidebar-brand-text {
      font-weight: 700;
      letter-spacing: 0.05em;
    }
  </style>
</body>


</html>