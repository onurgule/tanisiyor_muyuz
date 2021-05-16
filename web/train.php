<?php

include "nav.php";
?>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">Bir fotoğraf yükleyin ve uygulamayı eğitin.</h1>
        <p class="lead">Aşağıdan fotoğrafı ekleyin ve uygulamayı insanlarla tanıştırın.</p>
		<?php
		if($_GET["err"] === "0"){ ?>
		<p style="text-align:center; color:green;">Başarıyla Eğitildi.</p>
		<? } ?>
		<?php
		if($_GET["err"] === "1"){ ?>
		<p style="text-align:center; color:red;">Fotoğraf hatalı. Fotoğrafta herhangi biri olduğundan emin olun.</p>
		<? } ?>
		<form action="http://127.0.0.1:800/faceUp" method="post" enctype="multipart/form-data">
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" id="gonder" value="Eğit" name="submit">
		</form><br>
		<div style="display:none;" class="progress">
			<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%"></div>
		</div>
      </div>
    </div>
  </div>
  <script>
$('form').submit(function(e) {
	$('.progress').show();
	setTimeout(() => $('.progress-bar').css("width","35%"),1000);
	setTimeout(() => $('.progress-bar').css("width","75%"),2500);
	setTimeout(() => $('.progress-bar').css("width","95%"),4000);
	
});
</script>
<?php
include "footer.php";
?>
