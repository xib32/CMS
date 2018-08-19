<?php

	require_once 'core/init.php';
	
	$user = new User();
	$_db = DB::getInstance();
	
	if(!$user->check()) {
		Redirect::to('login');
	}
	
	$validation = new Validation();
	$upload = new Upload();
	
	$_db->find($_GET["id"],'novosti');
	$array_obavjesti = $_db->results();	
	$_db->get('path','novosti',array('id','=',$_GET["id"]));
	$array_paht=$_db->results();
	$img_folder=$array_paht[0]['path'];
	$images = glob($img_folder.'/*.*');
	
	
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
					if(!$upload->upload_files($img_folder)){
						exit;
					}	
					$_db->update(
						'novosti',
						array(
							'heading' => Input::get('naziv'),
							'content' => Input::get('sadr'),),
						array(
							'id',
							'=',
							$_GET["id"]
					));															
				}  catch(Exception $e) {
					Session::flash('danger', $e->getMessage());
					exit;
				}
				$obrisi_slike = Input::get('obrisi');
				var_dump($obrisi_slike);
				if(isset($obrisi_slike)){
					foreach($obrisi_slike as $slika){
						unlink($slika);
					}
					header("Location: ".$_SERVER['REQUEST_URI']);
				}							
				//Session::flash('success', 'Novost izmjenjena!');
			}	
		} else {
			Session::flash('danger', 'CSRF Token missmatch');
		}
	}
	Helper::getHeader('Dashboard', 'header', $user);	
	require_once 'notifications.php';
	
?>
<head>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://www.expertphp.in/js/jquery.form.js"></script>
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
		<div class="col-md-15 col-md-offset-0" id="accordion">
			<div class="jumbotron">
				<h1 class="text-center">Admin panel</h1>
			</div>
		</div>
		<div class="col-md-10 col-md-offset-1">
		<a href="dashboard.php"><--Povratak</a>
		</div>
		<div class="panel-group col-md-10 col-md-offset-1">
			<div class="panel panel-primary" >
				<div class="panel-heading">
					<h3 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#novost">
						Izmjeni novost</a>
					</h3>
				</div>

					<div class="panel-body">
						<form  method="post"  enctype="multipart/form-data">
							<input type="hidden" name="_csrf" value="<?php echo Token::generate() ?>">
							<div class="form-group <?php echo ($validation->hasError('naziv')) ? 'has-error' : '' ?>">
								<label for="naziv" class="control-label">Naziv</label>
								<textarea rows="1" type="text" class="form-control" name="naziv" id="naziv" value="<?php echo escape(Input::get('naziv'))?>"><?php echo $array_obavjesti[0]['heading']?></textarea>
								<?php echo ($validation->hasError('naziv')) ? '<p class="text-danger">' . $validation->hasError('naziv') . '</p>' : '' ?>
							</div>
							<div class="form-group <?php echo ($validation->hasError('sadr')) ? 'has-error' : '' ?>">
								<label for="sadr" class="control-label">Sadržaj</label>
								<textarea  type="text" class="form-control" name="sadr" id="sadr" rows="5" value="<?php echo escape(Input::get('sadr'))?>"><?php echo $array_obavjesti[0]['content']?></textarea>
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
							<div class="panel-body">
								<div class="form-check">
								<?php
								$i=2;
								echo'<table class="table table-hover">
									<tbody>
									<tr>';
								foreach($images as $image) {									
									$i++;
									if($i==3){
										echo'</tr>
											<tr>';
										$i=0;
									}	
									echo'<td><img src="'.$image.'" style="width:300px;height:200px;" /><label class="form-check-label"><input class="form-check-input" type="checkbox" name="obrisi[]" value="'.$image.'">Obriši</label></td>';									
								}
								
								echo'</tr>
									</tbody>
									</table>';
								?>
								</div>
							</div>
							<br>
							<div class="form-group">
								<button type="submit" class="btn btn-primary" name='submit_image'>Izmjeni</button>
							</div>
						</form>
					</div>

			</div>
		</div>
	</div>

</body>
<?php

	Helper::getFooter();

?>	