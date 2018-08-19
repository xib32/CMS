<?php

	require_once 'core/init.php';
	
	$user = new User();
	
	if($user->check()) {
		Redirect::to('dashboard');
	}
	
	Helper::getHeader('Admin', 'header', $user);
		
?>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="jumbotron">
			<h1 class="text-center">Admin</h1>
			<p>Dobrodošli u administratorski dio.<br> Ukoliko ste posjetitelj, molimo vas da se vratite na dio za posjetitelje.</p>
			<p>
				<a class="btn btn-primary btn-lg" href="index.php" role="button">Početna</a>
			</p>
		</div>
	</div>
</div>

<?php

	Helper::getFooter();

?>


	
	