<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        @if (auth()->guard('admin')->user()->role === 'Manager')
            <div class="sidebar-brand-text mx-3">Manager</div>
        @else
            <div class="sidebar-brand-text mx-3">Admin</div>

        @endif
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    @unless(auth()->guard('admin')->user()->role === 'Manager')
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manager"
                aria-expanded="true" aria-controls="manager">
                <i class="fas fa-fw fa-cog"></i>
                <span>Maneger</span>
            </a>
            <div id="manager" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="{{ route('list.maneger') }}">List</a>
                    <a class="collapse-item" href="{{ route('create.maneger') }}">Create Manager</a>
                </div>
            </div>
        </li>
    @endunless
    @if(auth()->guard('admin')->user()->manage_organization == 1)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Organizations</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="{{route('list.organization')}}">List</a>
                    <a class="collapse-item" href="{{route('create.organization')}}">Create</a>
                </div>
            </div>
        </li>
    @endif
    @if(auth()->guard('admin')->user()->manage_team == 1)
    <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Team</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Utilities:</h6>
                    <a class="collapse-item" href="{{route('list.team')}}">List</a>
                    <a class="collapse-item" href="{{route('create.team')}}">Create</a>
                </div>
            </div>
        </li>
    @endif
    @if(auth()->guard('admin')->user()->manage_employee == 1)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Employees</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">List</h6>
                    <a class="collapse-item" href="{{ route('list.employee') }}">List</a>
                    <a class="collapse-item" href="{{ route('create.employee') }}">Create</a>
                    <a class="collapse-item" href="{{ route('employee.import.form') }}">Import</a>
                </div>
            </div>
        </li>
    @endif

    @if(auth()->guard('admin')->user()->manage_report  == 1)
    <div class="sidebar-heading">
        Reports
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reports"
            aria-expanded="true" aria-controls="reports">
            <i class="fas fa-fw fa-cog"></i>
            <span>Reports</span>
        </a>
        <div id="reports" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="{{route('teams.average.salary')}}">Avg Salary</a>
                <a class="collapse-item" href="{{route('organizations.employee.count')}}">Org Employees</a>
            </div>
        </div>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
