<html>
<head>
<style type="text/css" media="print">
	table {border: solid 1px #000; border-collapse: collapse; width: 100%}
	tr { border: solid 1px #000; page-break-inside: avoid;}
	td { padding: 7px 5px; font-size: 10px}
	th {
		font-family:Arial;
		color:black;
		font-size: 11px;
		background-color:lightgrey;
	}
	thead {
		display:table-header-group;
	}
	tbody {
		display:table-row-group;
	}
	h3 { margin-bottom: -17px }
	h2 { margin-bottom: 0px }
</style>
<style type="text/css" media="screen">
	table {border: solid 1px #000; border-collapse: collapse; width: 100%}
	tr { border: solid 1px #000}
	th {
		font-family:Arial;
		color:black;
		font-size: 11px;
		background-color: #999;
		padding: 8px 0;
	}
	td { padding: 7px 5px;font-size: 10px}
	h3 { margin-bottom: -17px }
	h2 { margin-bottom: 0px }
</style>
<title>Cetak Rekap Pembayaran</title>
</head>

<body onLoad="window.print()">
<center><b style="font-size: 20px">Rekap Laporan Pembayaran</b><br>
<table class="table table-hover table-bordered table-striped">
	<thead>
	    <tr class="info">
	      <th>#</th>
	      <th>No Invoice</th>
	      <th>Tgl Bayar</th>
	      <th>Tgl Validasi</th>
	      <th>Total</th>
	      <th>Status</th>     
	    </tr>
  	</thead>
  	<tbody align="center">
  		<?php
error_reporting(0);
		require_once('../inc/config.php');
		include"../inc/function.php";
		$dari= $_POST['dari'];
		$sampai= $_POST['sampai']; 
		$id= $_POST['id_pelanggan'];
		$level= $_POST['level'];
		if($level=='admin'){
		$q = "SELECT * FROM t_transaksi  WHERE tgl_bayar >= '$dari' AND tgl_bayar <= '$sampai' ORDER BY id_transaksi DESC";		
		}else{
		$q = "SELECT * FROM t_transaksi  WHERE tgl_bayar >= '$dari' AND tgl_bayar <= '$sampai' AND id_pelanggan = '$id' ORDER BY id_transaksi DESC";
		}
		$result = $db->prepare($q);
		$result->execute();
		$no=1; 
		while ($data = $result->fetch(PDO::FETCH_ASSOC)) { 
		?>
      <tr>
        <td><?php echo $no++; ?></td>       
        <td><?php echo $data['id_transaksi'] ?></td>
        <td><?php echo TanggalIndo($data['tgl_bayar']); ?></td>    
        <td><?php
        if ($data['tgl_validasi'] == '0000-00-00'){
        echo "belum validasi";
        }else{
        echo TanggalIndo($data['tgl_validasi']); 
        }?></td>      
        <td><?php echo "Rp." . number_format( $data['nominal'] , 0 , ',' , '.' ); ?></td>     
        <td><?php echo ucfirst($data['status']) ?></td>    
        
        
      </tr>
      <?php
        }
      ?>
  	</tbody>

</body>
</html>
