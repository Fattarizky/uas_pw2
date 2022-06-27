<!-- Validasi data -->
<?php 
	include "config.php";
	$id=$_POST["id"];
	$merk=mysqli_real_escape_string($con,$_POST["merk"]);
	$tipe=mysqli_real_escape_string($con,$_POST["tipe"]);
	$tahun=mysqli_real_escape_string($con,$_POST["tahun"]);
	if($id=="0"){

		//fungsi tambah data
		$sql="insert into data_hp (merk,tipe,tahun) values ('{$merk}','{$tipe}','{$tahun}')";
		if($con->query($sql)){
			$id=$con->insert_id;
			echo"<tr class='{$id}'>
				<td>{$merk}</td>
				<td>{$tipe}</td>
				<td>{$tahun}</td>
				<td><a href='#' class='btn btn-primary edit' id='{$id}'>Ubah</a></td>
				<td><a href='#' class='btn btn-danger del' id='{$id}'>Hapus</a></td>					
			</tr>";
			
		}
	}else{

		//fungsi update data
		$sql="update data_hp set merk='{$merk}',tipe='{$tipe}',tahun='{$tahun}' where id='{$id}'";
		if($con->query($sql)){
			echo"
				<td>{$merk}</td>
				<td>{$tipe}</td>
				<td>{$tahun}</td>
				<td><a href='#' class='btn btn-primary edit' id='{$id}'>Ubah</a></td>
				<td><a href='#' class='btn btn-danger del' id='{$id}'>Hapus</a></td>					
			";
		}
	}
?>