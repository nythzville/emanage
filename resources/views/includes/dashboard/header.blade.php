<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="/" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        {!! HTML::image('dashboard/images/logo.png', 'Employee Management', array('class' => 'icon')) !!}
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>{{ ucwords($employee->firstname.' '.$employee->lastname) }}<i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">                        
                        <li class="user-header">
                            <p>
                                {{ ucwords($employee->firstname.' '.$employee->lastname) }}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ BASE_URL }}/profile/">
                                    <button type="button" class="btn btn-primary btn-flat">Profile</button>
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ BASE_URL }}/logout/">
                                    <button type="button" class="btn btn-danger btn-flat">Logout</button>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>