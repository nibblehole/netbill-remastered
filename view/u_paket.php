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
      <?php
        include "./inc/config.php";
        $query = $db->prepare("SELECT * from t_paket WHERE id_paket='$_GET[id]' " ); 
        $query->execute();
		$no=1;                  
        while($lihat=$query->fetch(PDO::FETCH_ASSOC)){  
      ?> 
<form class="form-horizontal" method="POST">
  <fieldset>
    <legend>Update Data Paket</legend>
    <div class="form-group">
      <label class="col-sm-2 control-label">ID Paket</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="id" value="<?php echo $lihat['id_paket'] ;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nama Paket</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="nama" value="<?php echo $lihat['nama'] ;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Harga Paket</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="harga" value="<?php echo $lihat['harga'] ;?>">
      </div>
    </div>
   
   <input type="hidden" name="id_paket" value="<?php echo "$_SESSION[id]" ;?>">
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <button type="reset" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
        <button type="submit" name="simpan" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Simpan</button>
        <a href="?page=paket" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal </a>
      </div>
    </div>
  </fieldset>


</form>
<?php
};
?>

  <?php 
  if(isset($_POST['simpan'])){
    $query=$db->prepare("UPDATE t_paket SET nama='$_POST[nama]', harga='$_POST[harga]' WHERE id_paket='$_POST[id]'");
	$query->execute();
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=?page=paket">';
    } 


  ?>