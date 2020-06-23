<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url('Admin/home_so')?>" <?php if($this->uri->segment(1)=="home_so"){echo 'class="active"';}?>>Admin E-Order Pratapa Nirmala</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">


                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url('Admin/logout')?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="<?php echo base_url('Admin/home_so')?>" <?php if($this->uri->segment(1)=="home_so"){echo 'class="active"';}?>><i class="fa fa-dashboard fa-fw"></i> Table Sale Order</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/home_retur')?>" <?php if($this->uri->segment(1)=="home_retur"){echo 'class="active"';}?>><i class="fa fa-dashboard fa-fw"></i> Table Retur</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Accounts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url('Admin/formAdmin')?>" <?php if($this->uri->segment(1)=="formAdmin"){echo 'class="active"';}?>>Admin</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('Admin/formManager')?>" <?php if($this->uri->segment(1)=="formManager"){echo 'class="active"';}?>>Manager</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
