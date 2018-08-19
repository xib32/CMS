<?php

	require_once 'core/init.php';
	
	$user = new User();
	$_db = DB::getInstance();
	
	if(!$user->check()) {
		Redirect::to('login');
	}
	
	$validation = new Validation();
	$upload = new Upload();
	
	if(Input::exists()) {
		
		if(Token::check(Input::get('_csrf'))) {
			
			$validate = $validation->check(array(
				'naziv' => array(
					'required' => true,
					'min'      => 1,
					'max'      => 60
				),
				'sadr' => array(
					'required' => false,
					'min'      => 1
				)
			));
			
			if($validate->passed()) {
				try {
					if(!$upload->upload_files(Input::get('naziv'))){
						exit;
					}					
					$_db->insert(
						'novosti',array(
							'heading' => Input::get('naziv'),
							'content' => Input::get('sadr'),
							'path' => 'images/'.Input::get('naziv').' '.date('d.m.y'),
							'objava'  => Input::get('objava'),
					));
										
				} catch(Exception $e) {
					Session::flash('danger', $e->getMessage());
					exit;
				}
				
				Session::flash('success', 'Novost dodana!');
			}	
		} else {
			Session::flash('danger', 'CSRF Token missmatch');
		}
	}
	Helper::getHeader('Dashboard', 'header', $user);
	
	require_once 'notifications.php';
	if(isset($_GET["id"])){
		$_db->get('path','media',array('novosti_id','=',$_GET["id"]));
		$array_paht=$_db->results();
		$img_folder=$array_paht[0]['path'];
		if (is_dir($img_folder))
           $dir_handle = opendir($img_folder);
		while($file = readdir($dir_handle)) {
	       if ($file != "." && $file != "..") {
	            if (!is_dir($img_folder."/".$file))
	                 unlink($img_folder."/".$file);
	            else
	                 delete_directory($img_folder.'/'.$file);
	       }
	 }
	 closedir($dir_handle);
	 rmdir($img_folder);
	
	$_db->delete('media',array('novosti_id','=',$_GET["id"]));
	$_db->delete('novosti',array('id','=',$_GET["id"]));
	Redirect::to('dashboard');
	}
?>
<head>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<script>
function preview_images() 
{
 var total_file=document.getElementById("images").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<div class='col-md-3'><img class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
 }
}
</script>
</head>
<body>
	<div class="row">
		<div class="col-md-15 col-md-offset-0" >
			<div class="jumbotron">
				<h1 class="text-center">Admin panel</h1>
			</div>
		</div>
		<div class="panel-group col-md-10 col-md-offset-1">
			<div class="panel panel-primary" >
				<div class="panel-heading">
					<h3 class="panel-title">
					Pregled novosti
					</h3>
				</div>
				<div class="panel-body">
					<?php $_db->get('heading,created,id','novosti');
					$array_obavjesti = $_db->results();
					echo'
						<div class="container col-md-10">
							<h2>Novosti</h2>        
							  <table class="table table-hover">
								<thead>
								  <tr>
									<th>Broj novosti</th>
									<th>Naziv novosti</th>
									<th>Datum novosti</th>
									<th></th>
									<th></th>
								  </tr>
								</thead>
								<tbody>';
					krsort($array_obavjesti);					
					foreach($array_obavjesti as $obavjest) {
						echo ' <tr>
								<td>'.$obavjest['id'].'</td>
								<td>'.$obavjest['heading'].'</td>
								<td>'.$obavjest['created'].'</td>
								<td> <a href="edit.php?id='.$obavjest['id'].'">Izmjeni</a></td>
								<td> <a href="dashboard.php?id='.$obavjest['id'].'">Obriši</a></td>
							  </tr>';
					}										
					echo'	</tbody>
						</table>
						<table class="table table-hover>
						<thead>
							<tr></tr>
						</thead>
						<tbody>
							<tr>
							<td>'?>
							<div class="panel panel-primary" >
								<div class="panel-heading">
									<h3 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" onclick="reset()" href="#novost">
									Objavi novost</a>
									</h3>
								</div>
								<div id="novost" class="collapse ">
									<div class="panel-body">
										<form id="input" method="post" enctype="multipart/form-data">
											<label class="radio-inline" style="padding:10px">
											  <input type="radio" name="objava" checked="checked" value="1">Novost
											</label>
											<label class="radio-inline">
											  <input type="radio" name="objava" value="2">Galerija
											</label>
											<label class="radio-inline">
											  <input type="radio" name="objava" value="3">Događaj
											</label>									
											<input type="hidden" name="_csrf" value="<?php echo Token::generate() ?>">
											<div class="form-group <?php echo ($validation->hasError('naziv')) ? 'has-error' : '' ?>">
												<label for="naziv" class="control-label">Naziv</label>
												<textarea type="text" class="form-control" name="naziv" rows="1" id="naziv" value="<?php echo escape(Input::get('naziv'))?>"></textarea>
												<?php echo ($validation->hasError('naziv')) ? '<p class="text-danger">' . $validation->hasError('naziv') . '</p>' : '' ?>
											</div>
											<div class="form-group <?php echo ($validation->hasError('sadr')) ? 'has-error' : '' ?>">
												<label for="sadr" class="control-label">Sadržaj</label>
												<textarea  type="text" class="form-control" name="sadr" id="sadr" rows="5" value="<?php echo escape(Input::get('sadr'))?>"></textarea>
												<?php echo ($validation->hasError('sadr')) ? '<p class="text-danger">' . $validation->hasError('sadr') . '</p>' : '' ?>
											</div>
											<div class="row"> 
												  <div class="col-md-6">
													  <input type="file" class="form-control" id="images" name="files[]" value="<?php echo escape(Input::get('images'))?>" onchange="preview_images();" multiple/>
													  <?php echo ($validation->hasError('images')) ? '<p class="text-danger">' . $validation->hasError('images') . '</p>' : '' ?>
												  </div>
											</div>
											<div class="row" id="image_preview"></div>
											<br>
											<div class="form-group">
												<button type="submit" class="btn btn-primary" name='submit_image'>Objavi</button>
											</div>
										</form>
									</div>
								</div>
							</div>
			<?php   echo'	</td>
							</tr>
							</tbody>
						</table>
					</div>';
					?>
					
				</div>
			</div>
		</div>
	</div>
</body>
<?php

	Helper::getFooter();

?>	
	
