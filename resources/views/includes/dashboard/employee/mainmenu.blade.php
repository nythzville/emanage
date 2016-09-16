<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas" id="leftsidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if( $emp->photo ): ?>
                    <?php $emp_photo = str_replace('.jpg', '_200.jpg', $emp->photo) ?>
                    <?php $emp_photo = str_replace('.png', '_200.png', $emp_photo) ?>
                    <img src="/images/employees/profile_photo/{{ $emp_photo }}?{{ rand(0, 500) }}" class="img-circle" class="img-responsive" />
                <?php else: ?>
                    <img src="/images/employees/profile_photo/{{ $emp->gender == 'male' ? 'male-default-photo-200.jpg' : 'female-default-photo-200.jpg' }}"  class="img-responsive" />
                <?php endif; ?>
                </div>
            <div class="pull-left info">
                <p>{{ ucwords($employee->firstname.' '.$employee->lastname) }}</p>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
                <!-- <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Dashboard</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                </li> -->
                <li class="treeview {{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'view_dashboard'  ) ? 'active':'' }}">
                
                  <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Dashboard</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li class="{{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'view_dashboard'  ) ? 'active':'' }}"><a href="/employee/dashboard"><i class="fa fa-circle-o"></i> View Dashboard</a></li>
                    <!-- <li class="{{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'lates'  ) ? 'active':'' }}"><a href="#"><i class="fa fa-circle-o"></i> Lates</a></li> -->
                  </ul>
                </li>
                <li class="treeview {{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'today'  ) ? 'active':'' }}">
                
                  <a href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Attendance</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li class="{{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'today'  ) ? 'active':'' }}"><a href="/employee/attendance"><i class="fa fa-circle-o"></i> Today</a></li>
                    <!-- <li class="{{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'lates'  ) ? 'active':'' }}"><a href="#"><i class="fa fa-circle-o"></i> Lates</a></li> -->
                  </ul>
                </li>

                <!-- <li class="treeview {{ (isset($mainmenu) && $mainmenu == 'employee') ? 'active':'' }}">
                    <a href="#">
                        <i class="fa fa-user"></i> 
                        <span>My Profile</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                    <li class="{{ (isset($mainmenu) && $mainmenu == 'employee' && isset($menu_action) && $menu_action == 'profile'  ) ? 'active':'' }}"><a href="/employee/personal_information"><i class="fa fa-circle-o"></i> Profile</a></li>
                  </ul>
                </li> -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>