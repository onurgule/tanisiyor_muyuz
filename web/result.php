<?php
include "nav.php";
?>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">Seçtiğiniz iki kişinin tanışma olasılıkları</h1>
        <p class="lead">Aşağıda bu iki kişinin varsa birlikte resimleri ve olasılıkları yer alır.</p>
		<div class="row">
        <?php
		$p1 = $_GET["p1"];
		$p2 = $_GET["p2"];
		include "api/getPeople.php";
		//$l işe yarar.
		//print_r($l);
		foreach($l as $kisi){
			//echo($kisi["FaceImagePath"]);
			if($kisi["PID"] == $p1 || $kisi["PID"] == $p2){
			echo "<div class='col-lg-6 col-md-6 col-sm-6 face' id='".$kisi["PID"]."' style='border:3px grey;' onclick='secimYap(".$kisi["PID"].")'>
			<div style='width:100%;height:30px;'></div>
			<img style='width:150px;height:150px;' src='http://127.0.0.1:800/getPhoto?path=".$kisi["FaceImagePath"]."' />
			<div style='width:100%;height:30px;'></div>
			</div>";
			}
		}
		include "api/calculate.php";
		$gecerli = "";
		if($olasilik == 0) $gecerli = "Birbirlerini kesinlikle tanımıyorlar.";
		else if($olasilik < 0.1) $gecerli = "Birbirlerini muhtemelen tanımıyorlar.";
		else if($olasilik < 0.4) $gecerli = "Birbirlerini biraz tanıyor olabilirler.";
		else if($olasilik < 0.8) $gecerli = "Birbirlerini muhtemelen tanıyorlar.";
		else $gecerli = "Birbirlerini kesinlikle tanıyorlar.";
		$yuzde = 100*$olasilik;
		?>
		<div style="text-align:center;">
		<h1>İki kişinin birbirini tanıma olasılığı: %<?=$yuzde ?></h1>
		<h2><?=$gecerli?></h2>
		<h3>Birlikte olan fotoğrafları aşağıda listelenmiştir.</h3>
		<div class="row">
		<?php
		include "api/getRelatePhotos.php";
		 foreach($photos as $photo){
			//echo($kisi["FaceImagePath"]);
			echo "<div class='col-lg-6 col-md-6 col-sm-6 face' style='border:3px grey;'>
			<div style='width:100%;height:30px;'></div>
			<img style='width:250px;height:250px;' src='http://127.0.0.1:800/getPhoto?path=".$photo["path"]."' />
			<div style='width:100%;height:30px;'></div>
			</div>";
		}
		
		?>
		</div>
		</div>
		</div>
      </div>
    </div>
  </div>
<?php
include "footer.php";
?>
