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
        $query = $db->prepare("SELECT * from t_user WHERE id_pelanggan='$_GET[id]' " ); 
        $query->execute();
		$no=1;           
        while($lihat=$query->fetch(PDO::FETCH_ASSOC)){   
      ?> 
<form class="form-horizontal" method="POST">
  <fieldset>
    <legend>Update Data User</legend>
    <div class="form-group">
      <label class="col-sm-2 control-label">ID Pelanggan</label>
      <div class="col-sm-3">
        <select name="id" class="form-control">
        <?php
          include "./inc/config.php";
          $pos=$db->prepare("select * from t_pelanggan order by id_pelanggan");
          while($r_pos=$pos->fetch(PDO::FETCH_ASSOC) ){
            ?>
            <!--echo "<option value=\"$r_pos[id_paket]\">$r_pos[nama]</option>";-->
            <option <?php if( $lihat['id_pelanggan']==$r_pos['id_pelanggan']) {echo "selected"; } ?> value='<?php echo $r_pos['id_pelanggan'] ;?>'><?php echo $r_pos['id_pelanggan'] ;?> <?php echo $r_pos['nama'] ;?></option>
          <?php
          };
          ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Username</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="username" value="<?php echo $lihat['username'] ;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Password</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="password" value="******">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Level</label>
      <div class="col-sm-3">
        <select name="level" class="form-control">
          <option <?php if( $lihat['level']=='admin'){echo "selected"; } ?> value='admin'>Admin</option>
          <option <?php if( $lihat['level']=='pelanggan'){echo "selected"; } ?> value='pelanggan'>Pelanggan</option>          
        </select>
      </div>
    </div>  
   
   <input type="hidden" name="id_pelanggan" value="<?php echo "$_SESSION[id]" ;?>">
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <button type="reset" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
        <button type="submit" name="simpan" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Simpan</button>
        <a href="?page=user" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal </a>
      </div>
    </div>
  </fieldset>


</form>
<?php
};
?>

  <?php 
  if(isset($_POST['simpan'])){
    $query=$db->prepare("UPDATE t_user SET username='$_POST[username]', password=md5('$_POST[password]'), level='$_POST[level]' WHERE id_pelanggan='$_POST[id]'");
    $query->execute();
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=?page=user">';
    } 


  ?>