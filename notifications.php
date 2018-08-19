<?php

	require_once 'core/init.php';
	
	$session = Session::all();
	foreach ($session as $key => $val) {
		switch($key) {
			case 'success':
			case 'danger':
			case 'warning':
			case 'info':
				?>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="alert alert-<?php echo $key ?> alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $val ?>
						</div>
					</div>
				</div>
		<?php
			Session::delete($key);
			break;
			default:
		}
	}
?>