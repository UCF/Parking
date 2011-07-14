<?php disallow_direct_load('sidebar.php');?>

<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Sidebar')):?>
	<div class="side-nav">
		<h2>Find Out More</h2>
		<ul>
			<li><a href="">Pay a Citation</a></li>
			<li><a href="">Parking Maps</a></li>
			<li><a href="">Shuttle Schedules</a></li>
		</ul>
	</div>
	
	<div class="side-nav">
		<h2>Parking Permit Information</h2>
		<ul>
			<li><a href="">Visitor Permits</a></li>
			<li><a href="">Students Permits</a></li>
			<li><a href="">Employee Permits</a></li>
		</ul>
	</div>
	

<?php endif;?>