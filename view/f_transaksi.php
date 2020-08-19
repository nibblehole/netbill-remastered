<?php
error_reporting(0);
include "./inc/config.php";
include "./inc/function.php";
$id = $_SESSION['id'];
?>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li><a href="?page=<?php echo $page ;?>"><?php echo ucfirst($page) ; ?></a></li>
  <li class="active"><?php echo ucfirst($action) ; ?> Data</li>
</ul>

<form class="form-horizontal" method="POST" enctype="multipart/form-data">
  <fieldset>
    <legend>Tambah Data Transaksi</legend>
    <div class="form-group">
      <label class="col-sm-2 control-label">No Invoice</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="id" required placeholder="No Invoice">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tanggal Bayar</label>
      <div class="col-sm-3">
        <input type="text" id="datepicker" class="form-control" name="tgl_bayar" placeholder="Tanggal Bayar">
      </div>
    </div>
    <!-- <?php if($_SESSION['level'] == 'admin'){ ;?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tanggal Validasi</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="tgl_validasi" placeholder="Tanggal Validasi">
      </div>
    </div>
    <?php }; ?> -->
    <div class="form-group">
      <label class="col-sm-2 control-label">Jumlah Bayar</label>
      <div class="col-sm-3">        
        <input type="text" class="form-control" id="inputku" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" name="nominal" placeholder="Jumlah Bayar">
      </div>
    </div>    
    <div class="form-group">
      <label class="col-sm-2 control-label">Bukti Pembayaran</label>
      <div class="col-sm-3">
        <input type="file" id="exampleInputFile" name="file">
      </div>
    </div>
    
   <input type="hidden" name="info" value="1">
   <input type="hidden" name="id_pelanggan" value="<?php echo "$_SESSION[id]" ;?>">
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <button type="reset" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
        <button type="submit" name="simpan" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Tambah</button>
        <a href="?page=transaksi" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal </a>
      </div>
    </div>
  </fieldset>


  <?php  
  /*
  if(isset($_POST['simpan']))
  {
      mysql_query("INSERT INTO t_paket (id_paket, nama, harga) VALUES ('".$_POST['kode']."','".$_POST['nama']."','".$_POST['harga']."')") or die (mysql_error());
      
      echo '<META HTTP-EQUIV="Refresh" Content="0; URL=?page=paket">';
  }*/
  ?>
</form>


  <?php 
  $maxsize = 1024 * 2000; // maksimal 2 MB (1KB = 1024 Byte)
  $valid_ext = array('jpg','jpeg','png','gif','bmp');
  if(isset($_POST['simpan']) && $_FILES['file']['size']<=$maxsize){
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    $cekdata="SELECT COUNT(id_transaksi) from t_transaksi where id_transaksi='".$_POST['id']."'"; 
    $ada = $db->prepare($cekdata); 
	$ada->execute();
    $data="SELECT * from t_transaksi";
    $aya = $db->prepare($data);
	$aya->execute();
	if(!empty($_FILES)){
		if(!in_array($ext, $valid_ext)){
			writeMsg('ekstensi.error');
		}
	}
    if($ada->fetchColumn() > 0){ 
      writeMsg('invoice.sama');
	}else{ 
      $query="INSERT INTO t_transaksi (id_transaksi, id_pelanggan,  tgl_bayar, nominal, bukti) VALUES ('".$_POST['id']."-".strtoupper(uniqid())."','".$_POST['id_pelanggan']."','".$_POST['tgl_bayar']."','".str_replace(".","",$_POST['nominal'])."','upload/".$_FILES['file']['name']."')";
	  move_uploaded_file($_FILES['file']['tmp_name'], 'upload/'.$_FILES['file']['name']);
      $act = $db->prepare($query); 
	  $act->execute();
	  writeMsg('save.sukses');
	  echo '<i>Redirect dalam 3 detik...</i>';
      echo '<META HTTP-EQUIV="Refresh" Content="3; URL=?page=transaksi">';
    } 
  } 

  ?>
