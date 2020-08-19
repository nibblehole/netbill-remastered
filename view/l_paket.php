<?php
error_reporting(0);
  session_start();
  include "./inc/function.php";
  $_SESSION['info'];
  if($_SESSION['level']=="pelanggan"){
  header("location:index.php");
}else{
$max = 10;
$p = isset($_GET['p'])? (int)$_GET["p"]:1;
$start = ($p>1) ? ($p * $max) - $max : 0;
$co = $db->prepare("select * from t_paket");
$co->execute();
$total = count($co->fetchAll());
$pages = ceil($total/$max); 
?>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active"><?php echo ucfirst($page) ; ?></li>
</ul>
<div class="btn-group" >
  <a href="?page=paket&aksi=tambah" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a>
</div>

<br/><br/>
<?php 
  if ($action == ""){
?>
<table class="table table-hover table-bordered table-striped">
	<thead>
	    <tr class="info">
	      <th>#</th>
	      <th>Kode Paket</th>
	      <th>Nama Paket</th>
	      <th>Harga</th>
	      <th>Aksi</th>
	    </tr>
  	</thead>
  	<tbody>
  		<?php
        include "./inc/config.php";
        $query=$db->prepare("select * from t_paket LIMIT $start, $max"); 
        $query->execute();
		$no=1;                  
        while($lihat=$query->fetch(PDO::FETCH_ASSOC)){   
        ?>    
      <tr>
        <td><?php echo $no++; ?></td>         
        <td><?php echo $lihat['id_paket'] ?></td>    
        <td><?php echo $lihat['nama'] ?></td>     
        <td><?php echo "Rp ". number_format($lihat['harga'], 0, ',', '.'); ?></td>     
        <td align="center">
  				<!-- <a href="?page=paket&aksi=detail&id=<?php echo $lihat['id_paket'] ;?>" class="btn btn-success btn-sm" title="Lihat Data"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>  -->
  				<a href="?page=paket&aksi=edit&id=<?php echo $lihat['id_paket'] ;?>" class="btn btn-info btn-sm" title="Edit Data"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> 
  				<a href="?page=paket&aksi=delete&id=<?php echo $lihat['id_paket'] ;?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-danger btn-sm" title="Hapus Data"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
  		</td>
		 
      </tr>
      <?php
        }
      ?>
  	</tbody>

</table>
	<ul class="pagination">
	<?php 
	for($i=1; $i<=$pages ; $i++){ ?>
		<li><a href="?page=transaksi&p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
  <?php } ?>
	</ul>
<?php
}else if($action == "delete"){
$hapus=$db->prepare("DELETE from t_paket WHERE id_paket='$_GET[id]'");
$hapus->execute();
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=?page=paket">';
}else{
  echo "maaf aksi tidak ditemukan";
}
?>
  <?php 
}
  ?>