<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>E-Order dan E-Retur</title>
	<meta charset="UTF-8">
	<?php echo $css;?>
</head>
<body>
	 <?php echo $navbar?>
   <div id="page-wrapper">
               <div class="row">
                   <div class="col-lg-12">
                       <h1 class="page-header">Import Retur</h1>
                   </div>
                   <!-- /.col-lg-12 -->
               </div>
               <!-- /.row -->
               <div class="row">
                   <div class="col-lg-12">
                       <div class="panel panel-default">
                          <div class="panel-heading">

                          <label>Choose Excel File</label>
                            <form action="#"
                                name="form" id="form" enctype="multipart/form-data" type='POST'>
                                <div clas="form-group">
                                     <div class="row">

                                        <div class="col-lg-4">
                                         <input type="file" name="file"
                                        id="file" accept=".xls,.xlsx" class="btn btn-secondary  btn-sm" required/>
																				<input type="hidden" value="1" name="acc_id" id="acc_id"/>
																				</div>
                                        <div class="col-lg-2">
                                        <button type="submit" id="import_exl" name="import_exl"
                                        class="import_exl">Import</button>
																				<div class="loader" id="loader" style="float: right;"></div>
                                      </div>
                                    </div>
                                </div>

                            </form>
                          </div>
                           <!-- /.panel-heading -->
													 <form action="<?php echo base_url();?>Home/import_form_retur"
															 name="import_form_retur" id="import_form_retur" method="post" class="form-horizontal">

                           <div class="panel-body table-responsive">
														 <a href="<?php echo base_url(); ?>assets/example/Contoh Table Retur.xlsx" download>Contoh Import Excel Retur</a>

														 <table class="table table-striped table-bordered table-hover">

																	 <thead>
                                       <tr>
                                           <th>Nomor</th>
                                           <th>Tanggal</th>
                                           <th>Cabang</th>
																					 <th>BA</th>
                                           <th>SKB</th>
                                           <th>Product</th>
                                           <th>QTY</th>
																					 <th>UOM</th>
                                           <th>Batch</th>
                                           <th>Expired</th>
                                           <th>Keterangan</th>
                                           <th>Outlet</th>
                                           <th>CN</th>
																					 <th>Tipe</th>
                                       </tr>
                                   </thead>
                                   <tbody name="show_data" id="show_data">

                                   </tbody>

                               </table>

                           </div>
													 <div class="panel-body">
													 		<button type="submit" id="agree" name="agree"
													 class="btn btn-primary m5" style="float: right;">Submit</button>
												 		</div>
												 </form>
                           <!-- /.panel-body -->
                       </div>
                       <!-- /.panel -->
                   </div>
                   <!-- /.col-lg-12 -->
               </div>
               <!-- /.row -->

           </div>
           <!-- /#page-wrapper -->



</body>
<?php echo $js?>
<script type="text/javascript">
		$(document).ready(function() {

				//datatables
				table = $('#dataTables-example').DataTable({

						"order": [],
						//Set column definition initialisation properties.
						"columnDefs": [
						{
								"targets": [ -1 ], //last column
								"orderable": false, //set not orderable
						},
						],

				});



		});


		function setVisible(selector, visible) {
  			document.querySelector(selector).style.display = visible ? 'block' : 'none';
		}


		$('#form').on('submit', function(event){
				event.preventDefault();
				setVisible('#loader', true);

				$('#import_exl').attr("disabled", true);
				//Ajax Load data from ajax
				$.ajax({
						url : "<?php echo site_url('Home/import_retur')?>",
						type: "POST",
						data:new FormData(this),
						contentType:false,
						cache:false,
						processData:false,
						dataType: "JSON",
						success: function(res)
						{
							if(res.res_status == 1)
							{
								var html = '';
								var i;
								for(i=0; i<res.value.length; i++){
										html += '<tr >'
										+ '<td><input type="text" name="noPO[]"  value="'+ res.value[i].noPO +'"></input></td>'
										+ '<td><input type="date" name="tanggal[]" value="'+ convert(res.value[i].tanggal)  +'"></input></td>';
										if(res.cust_id ==1301)
										{
											html += '<td><input type="text" name="branch[]"  value="'+ res.value[i].branch +'"></input></td>';
										}
										else{
											html += '<td><select name="branch[]" class="form-control" id="branch" style="width:200px;">';
											for(a=0; a<res.tujuan.length; a++) {
												html += '<option value="' + res.tujuan[a].NAME + '"' ;
												if(res.tujuan[a].NAME==res.value[i].branch)
												{
															html += 'selected="selected"';
												}
												html +='>'
												+ res.tujuan[a].NAME + '</option>';
											};
											html += '</select></td>';
										}
										html += '<td><input type="text" name="ba[]" value="'+ res.value[i].ba +'"></input></td>'
										+ '<td><input type="text" name="skb[]" value="'+ res.value[i].skb +'"></input></td>'
										+ '<td><input type="text" name="product[]"  value="'+ res.value[i].product +'"></input></td>'
										+ '<td><input type="number" name="qty[]" value="'+ (res.value[i].qty)  +'"></input></td>'
										+ '<td><input class="readonly" type="text" name="uom[]" value="'+ res.value[i].uom +'" required onchange="event.preventDefault()" onkeydown="event.preventDefault()" onpaste="event.preventDefault()" autocomplete="off"></input></td>'
										+ '<td><input type="text" name="batch[]" value="'+ res.value[i].batch +'"></input></td>'
										+ '<td><input type="date" name="exp[]" value="'+ convert(res.value[i].exp) +'"></input></td>'
										+ '<td><select name="ket[]" class="form-control" id="ket" style="width:200px;">' ;
												for(a=0; a<res.ket.length; a++) {
													html += '<option value="' + res.ket[a].KETERANGAN + '"' ;
													if(res.ket[a].KETERANGAN==res.value[i].ket)
													{
																html += 'selected="selected"';
													}
													html +='>'
													+ res.ket[a].KETERANGAN + '</option>';
												};
										html += '</select></td><td><input type="text" name="outlet[]" value="'+ res.value[i].outlet +'"></input></td>'
										+ '<td><input type="text" name="cn[]" value="'+ res.value[i].cn +'"></input></td>'
										+ '<td><select name="orderType[]" class="form-control" id="orderType" style="width:200px;">' ;
												for(a=0; a<res.orderType.length; a++) {
													html += '<option value="' + res.orderType[a].NAME + '"' ;
													if(res.orderType[a].NAME==res.value[i].tipe)
													{
																html += 'selected="selected"';
													}
													html +='>'
													+ res.orderType[a].NAME + '</option>';
												};

										html += '</select></td>'
										+ '<td><input type="hidden" name="file_name[]" value="'+ res.file_name +'"></input></td>'
										+ '</tr>';
								}

								$('#show_data').html(html);
								setVisible('#loader', false);
								$('#import_exl').attr("disabled", false);
							}
							else{
								alert("Masukan file yang ingin diimport!");
								setVisible('#loader', false);
								$('#import_exl').attr("disabled", false);
							}
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
								alert('Error get data from ajax.' + textStatus + '.'+ errorThrown);
								setVisible('#loader', false);
								$('#import_exl').attr("disabled", false);
						}
				});
		});

		function convert(str) {
    		var date = new Date(str),
        mnth = ("0" + (date.getMonth()+1)).slice(-2),
        day  = ("0" + date.getDate()).slice(-2);
    		return [ date.getFullYear(), mnth, day ].join("-");
		}

</script>
</html>
