<div class="navbar-content">
			 	<div class="main-navigation navbar-collapse collapse" id="mySidenav">
					 <div class="navigation-toggler" class="closebtn" onclick="closeNav()">
						<i class="clip-chevron-left"></i>
						<i class="clip-chevron-right"></i>
					</div>
				 	<ul class="main-navigation-menu">
						 <?php
		if(empty($_SESSION['menu_time']))
		{
			$_SESSION['menu_time'] = 0;
		}
		foreach($menu_data as $mainmenu)
		{
		 	if(!empty($mainmenu->url_name))
			{
			 	if($mainmenu->menu_name == "Dashboard" && $_SESSION['menu_time'] == 0)
				{
					echo "<script>window.location='".base_url().$mainmenu->url_name."'</script>";
					$_SESSION['menu_time'] = 1;
				}
		?> 		
						<li>
							<a href="<?=base_url().$mainmenu->url_name?>" class="tooltips" data-toggle="tooltip" data-title="<?=$mainmenu->menu_name?>" ><i class="fa fa-<?=$mainmenu->fa_icon?>"></i>
								<span class="title"> <?=$mainmenu->menu_name?> </span><span class="selected"></span>
							</a>
						</li>
			<?php 
			}
			else
			{
			?>
					<li>
							<a class="dropdown-btn" title="<?=$mainmenu->menu_name?>" data-title="<?=$mainmenu->menu_name?>"><i class="fa fa-<?=$mainmenu->fa_icon?>"></i><span class="title"> <?=$mainmenu->menu_name?> <i class="fa fa-caret-down"></i></span></a>
							<div class="dropdown-container">
							<?php
							foreach($mainmenu->submenu as $submenu)
							{
							?>
							     <a href="<?=base_url().$submenu->url_name?>" class="tooltips" data-toggle="tooltip" data-title="<?=$submenu->menu_name?>" ><i class="fa fa-<?=$submenu->fa_icon?>"></i>  <?=$submenu->menu_name?></a> 
								<?php  
							}
							?> 
							</div>
						</li>
			<?php 
			}
		}
		?>
				</ul>
		<!-- end: MAIN NAVIGATION MENU -->
			</div>
	<!-- end: SIDEBAR -->
</div>