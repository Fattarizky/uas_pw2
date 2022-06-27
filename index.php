<?php
	include "config.php";
?>
<html>
	<head>
		<title>CRUD Application HP</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		
		<!-- JUDUL APLIKASI -->
	<div class="container">
		<h3 class='text-center'>CRUD DATA HANDPHONE</h3><hr>

		<!-- MEMBUAT FORM TABEL INPUT DATA -->
		<div class='row'>
			<div class="col-md-5">
				<form id='frm'>
				  <div class="form-group">
					<label>Merk HP</label>
					<input type="merk" class="form-control" name="merk" id='merk' required placeholder="Ketik Merk HP">
				  </div>
				  <div class="form-group">
					<label>Tipe HP</label>
					<input type="tipe" class="form-control" name="tipe" id='tipe' required placeholder="Ketik Tipe HP">
				  </div>
				  <div class="form-group">
					<label>Tahun Produksi</label>
					<input type="tahun" class="form-control"  name="tahun" id='tahun' required placeholder="Ketik Tahun Produksi">
				  </div>
				  
				  <input type="hidden" class="form-control" name="id" id='id' required value='0' placeholder="">
				  
				  <button type="submit" name="submit" id="but" class="btn btn-success">Tambah Data</button>
				  <button type="button" id="clear" class="btn btn-warning">Reset</button>
				</form> 
			</div>

			<!-- MEMBUAT TABEL DATA -->
			<div class="col-md-7">
				<table class="table table-bordered" id='table'>
					<thead>
						<tr>
							<th>Merk HP</th>
							<th>Tipe HP</th>
							<th>Tahun produksi</th>
							<th>Ubah</th>
							<th>Hapus</th>
						</tr>
					</thead>

					<!-- VALIDASI DATA TABEL DENGAN TABEL DI DB  -->
					<tbody>
						<?php
							$sql="select * from data_hp";
							$res=$con->query($sql);
							if($res->num_rows>0)
							{
								while($row=$res->fetch_assoc())
								{	
									echo"<tr class='{$row["id"]}'>
										<td>{$row["merk"]}</td>
										<td>{$row["tipe"]}</td>
										<td>{$row["tahun"]}</td>
										<td><a href='#' class='btn btn-primary edit' id='{$row["id"]}'>Ubah</a></td>
										<td><a href='#' class='btn btn-danger del' id='{$row["id"]}'>Hapus</a></td>					
									</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>	
	<script>
		$(document).ready(function(){
			
			//RESET INPUTAN DATA PADA MENU EDIT
			$("#clear").click(function(){
				$("#merk").val("");
				$("#tipe").val("");
				$("#tahun").val("");
				$("#id").val("0");
				$("#but").text("Tambah Data");
			});
			
			//MENGUPDATE DATA 
			$("#but").click(function(e){
				e.preventDefault();
				var btn=$(this);
				var id=$("#id").val();
				
				
				var required=true;
				$("#frm").find("[required]").each(function(){
					if($(this).val()==""){
						alert($(this).attr("placeholder"));
						$(this).focus();
						required=false;
						return false;
					}
				});
				if(required){
					$.ajax({
						type:'POST',
						url:'ajax_action.php',
						data:$("#frm").serialize(),
						beforeSend:function(){
							$(btn).text("Wait...");
						},
						success:function(res){
							
							var id=$("#id").val();
							if(id=="0"){
								$("#table").find("tbody").append(res);
							}else{
								$("#table").find("."+id).html(res);
							}
							
							$("#clear").click();
							$("#but").text("Tambah Data");
						}
					});
				}
			});
			
			//MENGHAPUS DATA
			$("body").on("click",".del",function(e){
				e.preventDefault();
				var id=$(this).attr("id");
				var btn=$(this);
				if(confirm("Are You Sure ? ")){
					$.ajax({
						type:'POST',
						url:'ajax_delete.php',
						data:{id:id},
						beforeSend:function(){
							$(btn).text("Deleting...");
						},
						success:function(res){
							if(res){
								btn.closest("tr").remove();
							}
						}
					});
				}
			});
			
			//mengisi form input data ssesuai tabel db
			$("body").on("click",".edit",function(e){
				e.preventDefault();
				var id=$(this).attr("id");
				$("#id").val(id);
				var row=$(this);
				var merk=row.closest("tr").find("td:eq(0)").text();
				$("#merk").val(merk);
				var tipe=row.closest("tr").find("td:eq(1)").text();
				$("#tipe").val(tipe);
				var tahun=row.closest("tr").find("td:eq(2)").text();
				$("#tahun").val(tahun);
				$("#but").text("Ubah Data");
			});
		});
	</script>
	</body>
</html>