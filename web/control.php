<?php

include "nav.php";
?>

  <!-- Page Content -->
  
  <script>
  var secim1 = 0, secim2 = 0;
  function secimYap(id){
	  if($('#'+id).css("border-color") == "rgb(128, 128, 128)"){
	  if(secim1 != 0 && secim2 == 0) {secim2 = id; $('#'+id).css("border-color","red");}
	  else if(secim1 == 0) {secim1 = id; $('#'+id).css("border-color","red");}
	  
	  }
	  else{
			$('#'+id).css("border-color","grey");
			if(secim1 == id) secim1 = 0;
			else if(secim2 == id) secim2 = 0;
	  }
	  
  }
  function karsilastir(){
	  if(secim1 != 0 && secim2 != 0){
	  window.location = "http://onurgule.com.tr/yapayzeka/result.php?p1="+secim1+"&p2="+secim2;
	  }
	  else{
		alert("İki kişi seçmelisiniz.");
	  }
	  //idsi secim1 ve secim2 leri database ile karşılaştır. ajaxla çağır ve result.php'ye git.
  }
  function pMerge(){
if(secim1 != 0 && secim2 != 0){
	  var r = confirm("Seçtiğiniz iki yüz aynı kişiye aitse devam edin. Aksi takdirde uygulamada sorun çıkabilir.");
if (r == true) {
	
	  fetch("http://onurgule.com.tr/yapayzeka/api/personMerge.php?fpid="+secim1+"&spid="+secim2).then(function(){location.reload();});
	}
	
}
else{
 alert("İki kişi seçmelisiniz.");
}
  
  }
  function sil(){
	  if(secim2!=0){
		  alert("Yalnızca 1 kişi seçiniz.");
	  }
	  else if(secim1==0){
		  alert("Bir kişi seçmelisiniz.");
	  }
	  else{
		   var r = confirm("Seçtiğiniz kişinin tüm verileri silinecektir. Emin misiniz?");
if (r == true) {
	fetch("http://onurgule.com.tr/yapayzeka/api/personDelete.php?fpid="+secim1).then(function(){location.reload();});
}
	  }
  }
  
  //document.getElementsByClassName('face').addEventListener("click", secimYap);
  </script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">İki Kişinin tanışıp tanışmadığını kontrol edin.</h1>
        <p class="lead">Aşağıdan daha önce tespit edilen iki kişi seçin ve kontrol edin.</p>
		<div class="row">
        <?php
		include "api/getPeople.php";
		//$l işe yarar.
		//print_r($l);
		foreach($l as $kisi){
			//echo($kisi["FaceImagePath"]);
			echo "<div class='col-lg-4 col-md-3 col-sm-6 face' id='".$kisi["PID"]."' style='border:3px dotted grey;' onclick='secimYap(".$kisi["PID"].")'>
			<div style='width:100%;height:30px;'></div>
			<img style='width:50px;height:50px;' src='http://127.0.0.1:800/getPhoto?path=".$kisi["FaceImagePath"]."' />
			<div style='width:100%;height:30px;'></div>
			</div>";
		}
		?>
		</div><br>
		<button class="btn btn-primary" onclick="karsilastir()">KARŞILAŞTIR</button>
		<button class="btn btn-warning" style="width:50%;" onclick="pMerge()">YÜZLERİ MANUEL BİRLEŞTİR</button>
		<button class="btn btn-danger" onclick="sil()">Kişiyi Sil</button>
      </div>
    </div>
  </div>
<?php
include "footer.php";
?>
