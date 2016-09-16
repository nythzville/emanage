<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
              <?php if( $employee->photo ): ?>
                  <?php $emp_photo = str_replace('.jpg', '_200.jpg', $employee->photo) ?>
                  <?php $emp_photo = str_replace('.png', '_200.png', $emp_photo) ?>
                  <img src="/images/employees/profile_photo/{{ $emp_photo }}?{{ rand(0, 500) }}" class="img-responsive img-circle" />
              <?php else: ?>
                  <img src="/images/employees/profile_photo/{{ $employee->gender == 'male' ? 'male-default-photo-200.jpg' : 'female-default-photo-200.jpg' }}"  class="img-responsive" />
              <?php endif; ?>
            </div>
            <div class="pull-left info">
                <p>{{ ucwords($employee->firstname.' '.$employee->lastname) }}</p>
            </div>
        </div>
        <!-- search form -->
        {!! Form::open( array('url' => '/search/employee', 'class'=>'sidebar-form', 'method'=>'get') ) !!}
            <div class="input-group">
                <input type="text" name="search_user" class="form-control" placeholder="Search Employee ..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        {!! Form::close() !!}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
                <li class="treeview {{ (isset($mainmenu) && $mainmenu == 'admin' && isset($menu_action) && $menu_action == 'view_dashboard'  ) ? 'active':'' }}">
                
                  <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Dashboard</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li class="{{ (isset($mainmenu) && $mainmenu == 'admin' && isset($menu_action) && $menu_action == 'view_dashboard'  ) ? 'active':'' }}"><a href="/admin/dashboard"><i class="fa fa-circle-o"></i> View Dashboard</a></li>
                    <!-- <li class="{{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'lates'  ) ? 'active':'' }}"><a href="#"><i class="fa fa-circle-o"></i> Lates</a></li> -->
                  </ul>
                </li>

                <li class="treeview {{ (isset($mainmenu) && $mainmenu == 'employee') ? 'active':'' }}">
                  <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Employee Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li class="{{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'create'  ) ? 'active':'' }}">
                      <a href="/admin/employee/create"><i class="fa fa-circle-o"></i> Add New</a>
                    </li>
                    <li class="{{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'today'  ) ? 'active':'' }}">
                      <a href="/admin/employee"><i class="fa fa-circle-o"></i> View All</a>
                    </li>
                  </ul>
                </li>

                <li class="treeview {{ (isset($mainmenu) && $mainmenu == 'attendance') ? 'active':'' }}">
                  <a href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Attendance Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li class="{{ (isset($mainmenu) && $mainmenu == 'attendance' && isset($menu_action) && $menu_action == 'today'  ) ? 'active':'' }}">
                    <a href="/admin/employee/attendance/today"><i class="fa fa-circle-o"></i> Today</a></li>
                    <!-- <li class="{{ (isset($mainmenu) && $mainmenu == 'attendance' && isset($menu_action) && $menu_action == 'review'  ) ? 'active':'' }}"><a href="/admin/employee/attendance/review_attendance"><i class="fa fa-circle-o"></i> Review Attendance</a></li> -->
                  </ul>
                </li>

                <li class="treeview {{ (isset($mainmenu) && $mainmenu == 'leaves') ? 'active':'' }}">
                  <a href="#">
                    <i class="fa fa-ambulance"></i>
                    <span>Leave Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li class="{{ (isset($mainmenu) && $mainmenu == 'leaves' && isset($menu_action) && $menu_action == 'create'  ) ? 'active':'' }}"><a href="/admin/leaves/create"><i class="fa fa-circle-o"></i> Add New</a></li>
                    <li class="{{ (isset($mainmenu) && $mainmenu == 'leaves' && isset($menu_action) && $menu_action == 'show'  ) ? 'active':'' }}"><a href="/admin/leaves"><i class="fa fa-circle-o"></i> View All</a></li>
                  </ul>
                </li>


                <li><a href="#{{ BASE_URL }}/edit/email/"><i class="fa fa-wrench"></i> System Settings</a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>