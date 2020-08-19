<?php
error_reporting(0);
include "./inc/function.php";
include "./inc/config.php";
$id = $_SESSION['id'];
$max = 10;
$p = isset($_GET['p'])? (int)$_GET["p"]:1;
$start = ($p>1) ? ($p * $max) - $max : 0;
$co = $db->prepare("select * from t_transaksi");
$co->execute();
$total = count($co->fetchAll());
$pages = ceil($total/$max); 
?>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active"><?php echo ucfirst($page) ; ?></li>
</ul>
<div class="btn-group" >
  <a href="?page=transaksi&aksi=tambah" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a>
</div>

<br/><br/>
<?php 
  if ($action == ""){
?>
<table class="table table-hover table-bordered table-striped">
	<thead>
	    <tr class="info">
	      <th>#</th>
	      <th>No Invoice</th>
	      <th>Tgl Bayar</th>
	      <th>Tgl Validasi</th>
	      <th>Total</th>
	      <th>Status</th>
        <th>File</th>                          
	      <th>Aksi</th>       
	    </tr>
  	</thead>
  	<tbody align="center">
  		<?php
        include "./inc/config.php";
        if($_SESSION['level'] == 'admin'){
        $query = $db->prepare("SELECT * from t_transaksi ORDER by tgl_bayar DESC LIMIT $start, $max");  
        $query->execute();
		}else{
        $query=$db->prepare("SELECT * from t_transaksi WHERE id_pelanggan='$_SESSION[id]' ORDER by tgl_bayar DESC LIMIT $start, $max");  
        $query->execute();
		}
        $no=1;                 
        while($lihat=$query->fetch(PDO::FETCH_ASSOC)){   
        ?>    
      <tr>
        <td><?php echo $no++; ?></td>    
        <td><?php echo $lihat['id_transaksi'] ?></td>   
        <td><?php echo TanggalIndo($lihat['tgl_bayar']); ?></td>  
        <td><?php
        if ($lihat['tgl_validasi'] == '0000-00-00'){
        echo '<a href="?page=transaksi&aksi=edit&id='.$lihat['id_transaksi'].'#validate" class="label label-warning">'.ucwords("belum validasi").'</a>';
        }else{
        echo TanggalIndo($lihat['tgl_validasi']); 
        }?></td>     
        <td><?php echo "Rp." . number_format( $lihat['nominal'] , 0 , ',' , '.' ); ?></td>   
        <td><?php if ($lihat['status']=='lunas'){ ?>
          <span class="label label-success"><?php echo ucfirst($lihat['status']) ?></span>
          <?php }else{ ?>
          <span class="label label-danger"><?php echo ucfirst($lihat['status']) ?></span>
          <?php }?>
        </td>     
        <td><?php if(strlen($lihat['bukti']) > 20){
				echo '<a href="'.$lihat['bukti'].'" target="_blank">'.substr($lihat['bukti'],7,20).'&hellip;</a>';
			}elseif(empty($lihat['bukti'])){
				echo 'Missing';
			}else{
				echo '<a href="'.$lihat['bukti'].'" target="_blank">'.$lihat['bukti'].'</a>';
			}
			?></td>  
        
        <td align="center">          
  				<a href="?page=transaksi&aksi=detail&id=<?php echo $lihat['id_transaksi'] ;?>" class="btn btn-success btn-sm" title="Lihat Data"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> 
  				<a href="?page=transaksi&aksi=edit&id=<?php echo $lihat['id_transaksi'] ;?>" class="btn btn-info btn-sm" title="Edit Data"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> 
  				<a href="?page=transaksi&aksi=delete&id=<?php echo $lihat['id_transaksi'] ;?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-danger btn-sm" title="Hapus Data"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>  		    
          <?php if($lihat['status']=='lunas'){
          ?>
          <a href="view/cetak_invoice.php?&id=<?php echo $lihat['id_transaksi'] ;?>" name="cetak" target="_blank" class="btn btn-info btn-sm" title="Cetak"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
          <?php
          }else{
          ?>
          <a href="#" target="_blank" class="btn btn-info btn-sm disabled" title="Cetak"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
          <?php
          }
          ?>
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
$hapus=$db->prepare("DELETE from t_transaksi WHERE id_transaksi='$_GET[id]'");
$hapus->execute();
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=?page=transaksi">';
}else{
  echo "maaf aksi tidak ditemukan";
}
?>
