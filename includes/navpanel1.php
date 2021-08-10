<?php
    $link = URLROOT. 'chapel_Members/member-';
    $user = new User();
?>
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <nav class="navbar header-navbar pcoded-header">
            <div class="navbar-wrapper">
                <div class="navbar-logo">
                    <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                        <i class="ti-menu"></i>
                    </a>
                    <div class="mobile-search waves-effect waves-light">
                        <div class="header-search">
                            <div class="main-search morphsearch-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                    <input type="text" class="form-control" placeholder="Enter Keyword">
                                    <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="<?=URLROOT?>">
                        <img class="img-fluid img-60" src="<?=URLROOT?>img/chap.png" alt="All Saints Chapel" />
                    </a>
                    <a class="mobile-options waves-effect waves-light">
                        <i class="ti-more"></i>
                    </a>
                </div>

                <div class="navbar-container container-fluid">
                    <ul class="nav-left">
                        <li>
                            <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                        </li>
                        <li class="header-search">
                            <div class="main-search morphsearch-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                    <input type="text" class="form-control">
                                    <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <li class="header-notification">
                            <a href="#!" class="waves-effect waves-light">
                                <i class="ti-bell"></i>
                                <span class="badge bg-c-red"></span>
                            </a>
                            <ul class="show-notification">
                                <li>
                                    <h6>Notifications</h6>
                                    <label class="label label-danger">New</label>
                                </li>
                                <li class="waves-effect waves-light">
                                    <div class="media">
                                        <img class="d-flex align-self-center img-radius" src="<?=URLROOT?>img/chap.png" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user">John Doe</h5>
                                            <p class="notification-msg">Permission</p>
                                            <span class="notification-time">Last Login 30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </li>
                        <li class="user-profile header-notification">
                            <a href="#!" class="waves-effect waves-light">
                                <img src="<?=URLROOT?>chapel_Members/profile/<?=$user->data()->passport;?>" class="img-radius" alt="<?=$user->data()->full_name?>">
                                <span><?=strtok($user->data()->full_name,' ')?></span>
                                <i class="ti-angle-down"></i>
                            </a>
                            <ul class="show-notification profile-notification">

                                <li class="waves-effect waves-light">
                                    <a href="member-profile">
                                        <i class="ti-user"></i> Profile
                                    </a>
                                </li>
                                <li class="waves-effect waves-light">
                                    <a href="member-inbox">
                                        <i class="ti-email"></i> My Messages
                                    </a>
                                </li>

                                <li class="waves-effect waves-light">
                                    <a href="logout">
                                        <i class="ti-layout-sidebar-left"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar">
                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                    <div class="pcoded-inner-navbar main-menu">
                        <div class="">
                            <div class="main-menu-header">
                                <img class="img-80 img-radius"  src="<?=URLROOT?>chapel_Members/profile/<?=$user->data()->passport;?>" alt="<?=$user->data()->full_name;?>">
                                <div class="user-details">
                                    <span id="more-details"><?=$user->data()->full_name;?><i class="fa fa-caret-down"></i></span>
                                </div>
                            </div>

                            <div class="main-menu-content">
                                <ul>
                                    <li class="more-details">
                                        <a href="member-profile"><i class="ti-user"></i>View Profile</a>
                                        <a href="logout"><i class="ti-layout-sidebar-left"></i>Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-15 p-b-0">
<!--                            <form class="form-material">-->
<!--                                <div class="form-group form-primary">-->
<!--                                    <input type="text" name="footer-email" class="form-control" required="">-->
<!--                                    <span class="form-bar"></span>-->
<!--                                    <label class="float-label"><i class="fa fa-search m-r-10"></i>Search Friend</label>-->
<!--                                </div>-->
<!--                            </form>-->
                        </div>

                        <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Menu</div>

                        <ul class="pcoded-item pcoded-left-item">
                            <li>
                                <a href="<?=$link?>dashboard" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-dashboard"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>

                            <li>
                                <a href="<?=$link?>feedback" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-comment"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Feedbacks</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=$link?>bulletin" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-book"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Bulletin</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>

                            <li>
                                <a href="<?=$link?>profile" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-user"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Profile</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="pcoded-content">
                    <!-- Page-header start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Dashboard</h5>
                                        <p class="m-b-0">Welcome to ASC </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <ul class="breadcrumb-title">
                                        <li class="breadcrumb-item">
                                            <a href="admin-<?=$title?>"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="admin-<?=strtolower($title)?>"><?=$title?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page-header end -->