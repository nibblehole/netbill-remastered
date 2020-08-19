<?php
error_reporting(0);
  session_start();
  if($_SESSION['level']=="pelanggan"){
  header("location:index.php");
}else{
$max = 10;
$p = isset($_GET['p'])? (int)$_GET["p"]:1;
$start = ($p>1) ? ($p * $max) - $max : 0;
$co = $db->prepare("select * from t_pelanggan");
$co->execute();
$total = count($co->fetchAll());
$pages = ceil($total/$max); 
?>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active"><?php echo ucfirst($page) ; ?></li>
</ul>
<div class="btn-group" >
  <a href="?page=pelanggan&aksi=tambah" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a>
</div>
<!--<br/>

      <form class="form-inline" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Cari">
        </div>
        <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Cari</button>
      </form>
-->
<br/><br/>
<?php 
  if ($action == ""){
?>
      <!--
<nav class="navbar navbar-default">
  <div class="container-fluid">
    

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <form class="navbar-form navbar-right" role="search">        
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </div>
  </div>
</nav> -->
<table class="table table-hover table-bordered table-striped">
	<thead>
	    <tr class="info">
	      <th>#</th>
	      <th>ID Pelanggan</th>
	      <th>Nama</th>
	      <th>Alamat</th>
        <th>No HP</th>
	      <th>Aksi</th>
	    </tr>
  	</thead>
  	<tbody>
  		<?php
        include "./inc/config.php";
        $query = $db->prepare("select * from t_pelanggan LIMIT $start, $max");
		$query->execute();
        $no=1;                    
        while($lihat = $query->fetch(PDO::FETCH_ASSOC)){ 
        ?>    
      <tr>
        <td><?php echo $no++; ?></td>      
        <td><?php echo $lihat['id_pelanggan'] ?></td>
        <td><?php echo $lihat['nama'] ?></td>    
        <td><?php echo $lihat['alamat'] ?></td> 
        <td><?php echo $lihat['no_hp'] ?></td>    
        <td align="center">
  				<a href="?page=pelanggan&aksi=detail&id=<?php echo $lihat['id_pelanggan'] ;?>" class="btn btn-success btn-sm" title="Lihat Data"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> 
  				<a href="?page=pelanggan&aksi=edit&id=<?php echo $lihat['id_pelanggan'] ;?>" class="btn btn-info btn-sm" title="Edit Data"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> 
  				<a href="?page=pelanggan&aksi=delete&id=<?php echo $lihat['id_pelanggan'] ;?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-danger btn-sm" title="Hapus Data"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
  		</td>
		<!--
		<td><a href="edit_mhs.php?id_mhs=<?php echo $lihat['id_mhs'] ?>">Edit</a> ||    <!--membuat link ke file dan hapus.php-->
         <!--<a href="hapus_mhs.php?id_mhs=<?php echo $lihat['id_mhs'] ?>">Hapus</a></td>    <!--membuat link ke file dan hapus.php-->
		 
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
$hapus = $db->prepare("DELETE from t_pelanggan WHERE id_pelanggan='$_GET[id]'");
$hapus->execute();
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=?page=pelanggan">';
}else{
  echo "maaf aksi tidak ditemukan";
}
?>
  <?php 
}
  ?>