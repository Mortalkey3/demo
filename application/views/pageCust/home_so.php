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
                   <div class="col-lg-11">
                       <h1 class="page-header">Table Purchase Order</h1>
                   </div>
									 <div class="col-lg-1">
										  <h1 class="page-header">
										 		<div style="position:absolute;bottom:0">
                       	<a class="btn btn-sm btn-info" href="javascript:void(0)"  title="Reload" onclick="refresh()">
													Reload</a>
										 		</div>
									 		</h1>
									 </div>
                   <!-- /.col-lg-12 -->
               </div>
               <!-- /.row -->
               <div class="row">
                   <div class="col-lg-12">
                       <div class="panel panel-default">

                           <!-- /.panel-heading -->

                           <div class="panel-body table-responsive">

														 <table class="table table-striped table-bordered table-hover" id="dataTables-example">

																	 <thead>
                                       <tr>
                                           <th>Nomor PO</th>
                                           <th>Tanggal Order</th>
                                           <th>Status</th>
                                           <th>Tanggal Dibuat</th>
                                           <th>Tanggal Update</th>
                                           <th>Details</th>
                                       </tr>
                                   </thead>
                                   <tbody name="show_data" id="show_data">

                                   </tbody>

                               </table>

                           </div>
                           <!-- /.panel-body -->
                       </div>
                       <!-- /.panel -->
                   </div>
                   <!-- /.col-lg-12 -->
               </div>
               <!-- /.row -->
							 <div class="row">
									 <div class="col-lg-12">
											 <h1 class="page-header">Details</h1>
									 </div>
									 <!-- /.col-lg-12 -->
							 </div>
							 <!-- /.row -->
							 <div class="row">
									 <div class="col-lg-12">
											 <div class="panel panel-default">

													 <!-- /.panel-heading -->

													 <div class="panel-body table-responsive">

														 <table class="table table-striped table-bordered table-hover" id="dataTables-so">

																	 <thead>
																			 <tr>
																					 <th>Nomor PO</th>
																					 <th>Tanggal Order</th>
																					 <th>Cabang</th>
																					 <th>Product</th>
																					 <th>Product Name</th>
																					 <th>QTY</th>
																					  <th>UOM</th>
																					 <th>Order Type</th>
																					 <th>Pricelist</th>
																			 </tr>
																	 </thead>
																	 <tbody name="show_data_detail" id="show_data_detail">

																	 </tbody>

															 </table>

													 </div>
													 <!-- /.panel-body -->
											 </div>
											 <!-- /.panel -->
									 </div>
									 <!-- /.col-lg-12 -->
							 </div>
           </div>
					 <div id="page-wrapper">

					 						<!-- /.row -->

					 				</div>

</body>

<?php echo $js?>


<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {

			reload_table()
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


function detail_so(po_no,create_date)
{
			$.ajax({
							url   : '<?php echo base_url('Home/ajax_select_detail/')?>'+po_no.split("/").join("").split(" ").join("").split("-").join("") +'/' + create_date,
							async : false,
							dataType : 'JSON',
							success : function(data){
									var html = '';
									var i;

									for(i=0; i<data.length; i++){
											html += '<tr >'
											+ '<td>'+ data[i].PO_NO +'</td>'
											+ '<td>'+ data[i].DATE_ORDER  +'</td>'
											+ '<td>'+ data[i].BRANCH +'</td>'
											+ '<td>'+ data[i].PRODUCT +'</td>'
											+ '<td>'+ data[i].NAME_PRODUCT +'</td>'
											+ '<td>'+ data[i].QUANTITY +'</td>'
											+ '<td>'+ data[i].UOM +'</td>'
											+ '<td>'+ data[i].ORDER_TYPE +'</td>'
											+ '<td>'+ data[i].PRICELIST.replace(/[0-9].*/, "") +'</td>'
											+ '</tr>';
									}
									$('#show_data_detail').html(html);
							}

					});
}

function refresh()
{
		location.reload();
}


function reload_table()
{
			$.ajax({
							url   : '<?php echo base_url('Home/ajax_select_so')?>',
							async : false,
							dataType : 'JSON',
							success : function(data){
									var html = '';
									var i;
									for(i=0; i<data.length; i++){
											html += '<tr >'
											+ '<td>'+ data[i].PO_NO +'</td>'
											+ '<td>'+ data[i].DATE_ORDER  +'</td>'
											+ '<td>';
											if(data[i].FLAG==0){
												html+= 'Dalam Proses Persetujuan Manager';
											}
											else if(data[i].FLAG==1){
													html+= 'Sudah Disetujui Manager.';
											}
											else if(data[i].FLAG==2){
													html+= 'Sudah Masuk Ke Sistem.';
											}
											else if(data[i].FLAG==3){
												html+= 'Ditolak Oleh Manager.';
											}
											else{
												html+= 'Ditolak Oleh Sistem.';
											}

											html+='</td>'
											+ '<td>'+ data[i].CREATE_DATE +'</td>'
											+ '<td>'+ data[i].UPDATE_DATE +'</td>'
											+ '<td>'+
											'<a class="btn btn-sm btn-info" href="javascript:void(0)" title="Details" onclick="detail_so('+"'"+data[i].PO_NO+"'"+','+"'"+data[i].IDENTIFICATION+"'"+')">Detail</a>'
											+'</td>'
											+ '</tr>';
									}
									$('#show_data').html(html);
							}

					});
}
</script>
</html>
