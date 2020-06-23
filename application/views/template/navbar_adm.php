<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url('Home/home_so')?>" <?php if($this->uri->segment(1)=="home_so"){echo 'class="active"';}?>>E-Order Pratapa Nirmala (<?php echo $cust?>)</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">


                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url('Home/logout')?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                            <a href="<?php echo base_url('Home/home_so')?>" <?php if($this->uri->segment(1)=="home_so"){echo 'class="active"';}?>><i class="fa fa-table fa-fw"></i>Table Purchase Order</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Home/home_retur')?>" <?php if($this->uri->segment(1)=="home_retur"){echo 'class="active"';}?>><i class="fa fa-table fa-fw"></i>Table Retur</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Home/home_invoice')?>" <?php if($this->uri->segment(1)=="home_invoice"){echo 'class="active"';}?>><i class="fa fa-table fa-fw"></i>Table Pending Invoice</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url('Home/home_price')?>" <?php if($this->uri->segment(1)=="home_price"){echo 'class="active"';}?>><i class="fa fa-table fa-fw"></i>Table Price</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Home/home_import')?>" <?php if($this->uri->segment(1)=="home_import"){echo 'class="active"';}?>><i class="fa fa-upload fa-fw"></i>Import Purchase Order</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Home/home_import_retur')?>" <?php if($this->uri->segment(1)=="retur"){echo 'class="active"';}?>><i class="fa fa-upload fa-fw"></i>Import Retur</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
