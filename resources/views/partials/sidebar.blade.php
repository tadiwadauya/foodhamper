<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <ul class="pcoded-item pcoded-left-item">

                @role('admin')
                    <div class="pcoded-navigation-label">Dashboard</div>

                    <li class="">
                        <a href="{{ url('/home') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>


                    <div class="pcoded-navigation-label">Users</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                            <span class="pcoded-mtext">Users</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('users/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Add New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('users') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Manage Users</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('deleted-users') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Deleted Users</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('terminate-user-form') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Terminate User</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('reset-pin') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Reset Pin</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('get-users-import') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Import Users</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                            <span class="pcoded-mtext">Beneficiaries</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('beneficiaries/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Add New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('beneficiaries') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Manage Beneficiaries</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{ url('assign-beneficiary') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Assign Beneficiary</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{ url('import-beneficiary') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Import Beneficiary</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{ url('all-employee-beneficiaries') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Employee Beneficiaries</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-th-large"></i></span>
                            <span class="pcoded-mtext">Departments</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('departments/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Add New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('assign-manager') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Assign Manager</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('departments') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Manage Departments</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('get-department-import') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Import Departments</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-user"></i></span>
                            <span class="pcoded-mtext">Employee Types</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('usertypes/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Add New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('usertypes') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Manage Employees</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <div class="pcoded-navigation-label">Food Allocations</div>

                <li class="pcoded-hasmenu">
                    <a
                    href="javascript:void(0)"
                    class="waves-effect waves-dark"
                    >
                    <span class="pcoded-micon"
                        ><i class="fa fa-calendar"></i></span>
                    <span class="pcoded-mtext">Food Allocations</span>
                    </a>
                    <ul class="pcoded-submenu">
                    <li class="">
                        <a
                        href="{{ url('allocations/create') }}"
                        class="waves-effect waves-dark"
                        >
                        <span class="pcoded-mtext">Add New</span>
                        </a>
                    </li>
                    <li class="">
                        <a
                        href="{{ url('allocations') }}"
                        class="waves-effect waves-dark"
                        >
                        <span class="pcoded-mtext">Allocations</span>
                        </a>
                    </li>
                    <li class="">
                        <a
                        href="{{ url('import-allocation') }}"
                        class="waves-effect waves-dark"
                        >
                        <span class="pcoded-mtext">Import Allocation</span>
                        </a>
                    </li>
                    <li class="">
                        <a
                        href="{{ url('deleted-allocations') }}"
                        class="waves-effect waves-dark"
                        >
                        <span class="pcoded-mtext">Deleted Allocations</span>
                        </a>
                    </li>
                    </ul>
                </li>

                <li class="pcoded-hasmenu">
                    <a
                    href="javascript:void(0)"
                    class="waves-effect waves-dark"
                    >
                    <span class="pcoded-micon"
                        ><i class="fa fa-calendar"></i></span>
                    <span class="pcoded-mtext">Meat Allocations</span>
                    </a>
                    <ul class="pcoded-submenu">
                    <li class="">
                        <a
                        href="{{ url('meatallocations/create') }}"
                        class="waves-effect waves-dark"
                        >
                        <span class="pcoded-mtext">Add New</span>
                        </a>
                    </li>
                    <li class="">
                        <a
                        href="{{ url('meatallocations') }}"
                        class="waves-effect waves-dark"
                        >
                        <span class="pcoded-mtext">Meat Allocations</span>
                        </a>
                    </li>
                    <li class="">
                        <a
                        href="{{ url('import-meatallocation') }}"
                        class="waves-effect waves-dark"
                        >
                        <span class="pcoded-mtext">Import Meat Allocation</span>
                        </a>
                    </li>
                    <li class="">
                        <a
                        href="{{ url('deleted-meatallocations') }}"
                        class="waves-effect waves-dark"
                        >
                        <span class="pcoded-mtext">Deleted Meat Allocations</span>
                        </a>
                    </li>
                    </ul>
                </li>

                <li class="pcoded-hasmenu">
                    <a
                        href="javascript:void(0)"
                        class="waves-effect waves-dark"
                    >
                    <span class="pcoded-micon"
                    ><i class="fa fa-tasks"></i></span>
                        <span class="pcoded-mtext">Jobcards</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="">
                            <a
                                href="{{ url('jobcards/create') }}"
                                class="waves-effect waves-dark"
                            >
                                <span class="pcoded-mtext">Add New</span>
                            </a>
                        </li>
                        <li class="">
                            <a
                                href="{{ url('jobcards') }}"
                                class="waves-effect waves-dark"
                            >
                                <span class="pcoded-mtext">Manage Jobcards</span>
                            </a>
                        </li>
                        <li class="">
                            <a
                                href="{{ url('get-jobcard-import') }}"
                                class="waves-effect waves-dark"
                            >
                                <span class="pcoded-mtext">Import Jobcards</span>
                            </a>
                        </li>
                        <li class="">
                            <a
                                href="{{ url('deleted-jobcards') }}"
                                class="waves-effect waves-dark"
                            >
                                <span class="pcoded-mtext">Deleted</span>
                            </a>
                        </li>
                    </ul>
                </li>

                    <div class="pcoded-navigation-label">Requests</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-file-excel-o"></i></span>
                            <span class="pcoded-mtext">Food Requests</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('frequests/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Create New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('frequests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">All Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/get-daily-approval') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Daily Schedule</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('approved-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Approved Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('collected-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Collected Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('pending-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Pending Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/get-bulk-approval') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Bulk Approve</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-file-excel-o"></i></span>
                            <span class="pcoded-mtext"> Meat Requests</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('mrequests/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Create New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('mrequests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">All Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/get-daily-meat-approval') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Daily Schedule</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('approved-meat-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Approved Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('collected-meat-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Collected Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('pending-meat-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Pending Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/get-bulk-meat-approval') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Bulk Approve</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <div class="pcoded-navigation-label">Collection</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-book"></i></span>
                            <span class="pcoded-mtext">Food Collection</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('fcollections/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Add New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('fcollections') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Collections</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-skyatlas"></i></span>
                            <span class="pcoded-mtext">Meat Collection</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('mcollections/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Add New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('mcollections') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Collections</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-line-chart"></i></span>
                            <span class="pcoded-mtext">Reports</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('get-month-report') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Monthly</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('user-collection-report') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">User Collection</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <div class="pcoded-navigation-label">System Settings</div>

                    <li class="">
                        <a href="{{ url('hsettings-get') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-aperture"></i>
                            </span>
                            <span class="pcoded-mtext">Humber Settings</span>
                        </a>
                    </li>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                            <span class="pcoded-mtext">Admin</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('/activity') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Activity Log</span>
                                </a>
                            </li>
                            <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fa fa-skyatlas"></i></span>
                                    <span class="pcoded-mtext">Roles</span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="">
                                        <a href="{{ url('roles/create') }}" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext">Add New</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="{{ url('roles') }}" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext">Roles</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>
                @endrole

                @role('user')
                    <div class="pcoded-navigation-label">Dashboard</div>

                    <li class="">
                        <a href="{{ url('/home') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>

                    <div class="pcoded-navigation-label">Allocations</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-calendar"></i></span>
                            <span class="pcoded-mtext">Allocations</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('my-user-allocation') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">My Fooad Allocations</span>
                                </a>
                            </li>

                        </ul>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('my-user-allocation') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">My Meat Allocations</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <div class="pcoded-navigation-label"> My Food Requests</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-file-excel-o"></i></span>
                            <span class="pcoded-mtext">Food Requests</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('/my-user-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">All Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/create-user-request') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Create Request</span>
                                </a>
                            </li>

                        </ul>
                    </li>



                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-file-excel-o"></i></span>
                            <span class="pcoded-mtext"> Meat Requests</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('/create-user-mrequest') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Create Request</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/my-user-mrequests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">All Requests</span>
                                </a>
                            </li>

                        </ul>
                    </li>




                @endrole

                @role('hamperissuer')
                    <div class="pcoded-navigation-label">Dashboard</div>

                    <li class="">
                        <a href="{{ url('/home') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>

                    <div class="pcoded-navigation-label">Allocations</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-calendar"></i></span>
                            <span class="pcoded-mtext">Allocations</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('my-user-allocation') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">My Allocations</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <div class="pcoded-navigation-label"> My Requests</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-file-excel-o"></i></span>
                            <span class="pcoded-mtext">Humber Requests</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('/my-user-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">All Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/create-user-request') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Create Request</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{ url('/get-daily-approval') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Daily Schedule</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{ url('approved-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Approved Requests</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <div class="pcoded-navigation-label">Collection</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-book"></i></span>
                            <span class="pcoded-mtext">Food Collection</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('fcollections/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Add New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('fcollections') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Collections</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-skyatlas"></i></span>
                            <span class="pcoded-mtext">Meat Collection</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('mcollections/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Add New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('mcollections') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Collections</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole

                @role('datacapturer')
                    <div class="pcoded-navigation-label">Dashboard</div>

                    <li class="">
                        <a href="{{ url('/home') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>

                    <div class="pcoded-navigation-label">Allocations</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-calendar"></i></span>
                            <span class="pcoded-mtext">Allocations</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('my-user-allocation') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">My Allocations</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <div class="pcoded-navigation-label"> My Requests</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-file-excel-o"></i></span>
                            <span class="pcoded-mtext">Humber Requests</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('/my-user-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">All Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/create-user-request') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Create Request</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <div class="pcoded-navigation-label">Food Requests</div>

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-file-excel-o"></i></span>
                            <span class="pcoded-mtext">Requests</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="{{ url('frequests/create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Create New</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('frequests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">All Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/get-daily-approval') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Daily Schedule</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('approved-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Approved Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('collected-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Collected Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ url('pending-requests') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Pending Requests</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole
            </ul>
        </div>
    </div>
</nav>
