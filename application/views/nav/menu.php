<header class="main-header">
	<a  class="logo">
		<span class="logo-mini"><b><?php echo APP_NAME_FRONT_ALIAS ?></b><?php echo APP_NAME_END_ALIAS ?></span>
		<span class="logo-lg"><b><?php echo APP_NAME_FRONT ?></b><?php echo APP_NAME_END ?></span>
	</a>

	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs"><?php echo $this->session->userdata('nama_admin'); ?></span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<p>
								<?php echo $this->session->userdata('nama_admin'); ?> - <?php echo $this->session->userdata('nama_kategori');?>
							</p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="<?php echo base_url()?>password" class="btn btn-default btn-sm"><i class="fa fa-key"></i> Ubah Password</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo base_url()?>dashboard/logout" class="btn btn-danger btn-sm"><i class="fa fa-lock"></i> Log out</a>
							</div>
						</li>
					</ul>
				</li>
				<!-- Control Sidebar Toggle Button -->
				<li>
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
				</li>
			</ul>
		</div>

	</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<?php
			if(!empty($menu)){
	            foreach($menu as $rows){
	                if(!empty($rows['SUB_ID'])){
	                    $arrSubId = explode("|", $rows['SUB_ID']);
	                    $arrSubMenu = explode("|", $rows['SUB_NAMA']);
	                    $arrSubControl = explode("|", $rows['SUBMENU_CONTROLLER']);
	                    $arrCurrentSubControl = explode("|", $rows['SUBMENU_FUNCTION']);
	                    $activeMenu = '';
	                    if(in_array(strtolower($current_controller), $arrCurrentSubControl)){
	                        $activeMenu = 'active';
	                    }

	                    ?>
	                    <li class="treeview <?php echo $activeMenu; ?>">
	                        <a href="#">
	                            <i class="<?php echo $rows['MENU_ICON']; ?>"></i>
	                            <span><?php echo $rows['MENU_NAMA']; ?></span>
	                            <span class="pull-right-container">
	                                <i class="fa fa-angle-left pull-right"></i>
	                            </span>
	                        </a>

	                        <ul class="treeview-menu">
	                        <?php
	                        for($a = 0; $a < count($arrSubId); $a++){
	                            $activeSubControl = (strtolower($current_controller) == $arrCurrentSubControl[$a]) ? 'active' : '';
	                            ?>
	                            <li class="<?php echo $activeSubControl; ?>">
	                                <a href="<?php echo base_url().$arrSubControl[$a].'/'.$arrCurrentSubControl[$a]; ?>"><i class="fa fa-genderless"></i> <?php echo $arrSubMenu[$a]; ?></a>
	                            </li>
	                        <?php } ?>
	                        </ul>
	                    </li>
	                    <?php
	                }else {?>
	                    <li class="active">
	                        <a href="<?php echo base_url().$rows['MENU_CONTROLLER'].'/'.$rows['FUNC'];; ?>"><i class="fa fa-th"></i> <span><?php echo $rows['MENU_NAMA']; ?></span></a>
	                    </li><?php
	                }      
	            }
	        }
            ?>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>