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
                       	<a class="btn btn-sm btn-info" href="javascript:void(0)"  title="Reload" onclick="refresh()">Reload</a>
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
																				   <th></th>
                                           <th>Nomor PO</th>
                                           <th>Order</th>
                                           <th>Dibuat</th>
                                           <th>Update</th>
																					 <th>Admin</th>
																					 <th>Status</th>
																					 <th style="display:none;">Index</th>

																					 <th>Details</th>
																					 <th>Action</th>
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
				"dom": 'Bfrtip',
				"order": [],
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1,-2 ], //last column
            "orderable": false, //set not orderable
        },
				{
            "orderable": false,
            "className": "select-checkbox",
            "targets":   0
        },
        ],
				"select": {
            "style":    "multi",
            "selector": "td:first-child"
        },
				"buttons": [
            {
                "text": "HAPUS",
                "action": function () {
                    var data = table.rows( { selected: true } ).data();
										var count = table.rows( { selected: true } ).count();
										var arr = [];
										for(ind = 0;ind<count;ind++)
									  {
											var array = [data[ind][1].split("/").join("").split(" ").join("").split("-").join(""),data[ind][7]];
											arr.push(array);
										}
										console.log(arr);
										delete_so(arr);
                }
            },
						{
                "text": "DITERIMA",
                "action": function () {
                    var data = table.rows( { selected: true } ).data();
										var count = table.rows( { selected: true } ).count();
										var arr = [];
										for(ind = 0;ind<count;ind++)
									  {
											var array = [data[ind][1].split("/").join("").split(" ").join("").split("-").join(""),data[ind][7]];
											arr.push(array);
										}
										console.log(arr);
										accept_so_all(arr);
                }
            },
						{
                "text": "DITOLAK",
                "action": function () {
                    var data = table.rows( { selected: true } ).data();
										var count = table.rows( { selected: true } ).count();
										var arr = [];
										for(ind = 0;ind<count;ind++)
									  {
											var array = [data[ind][1].split("/").join("").split(" ").join("").split("-").join(""),data[ind][7]];
											arr.push(array);
										}
										console.log(arr);
										cancel_so_all(arr);
                }
            },
						'selectAll',
        		'selectNone'
        ],
				language: {
        	buttons: {
            selectAll: "Select all items",
            selectNone: "Select none"
        	}
    		}
    });




});

function refresh()
{
		location.reload();
}

function detail_so(po_no,create_date)
{
			$.ajax({
							url   : '<?php echo base_url('Home/ajax_select_detail/')?>'+po_no.split("/").join("").split(" ").join("").split("-").join("") +'/' +create_date,
							async : false,
							dataType : 'JSON',
							success : function(data){
									var html = '';
									var i;

									console.log(data);
									for(i=0; i<data.length; i++){
											html += '<tr >'
											+ '<td>'+ data[i].PO_NO +'</td>'
											+ '<td>'+ data[i].DATE_ORDER  +'</td>'
											+ '<td>'+ data[i].BRANCH +'</td>'
											+ '<td>'+ data[i].PRODUCT +'</td>'
											+ '<td>'+ data[i].NAME_PRODUCT +'</td>'
											+ '<td>'+ data[i].QUANTITY +'</td>'
											+ '<td>'+ data[i].UOM+'</td>'
											+ '<td>'+ data[i].ORDER_TYPE +'</td>'
											+ '<td>'+ data[i].PRICELIST.replace(/[0-9].*/, "") +'</td>'
											+ '</tr>';
									}
									$('#show_data_detail').html(html);
							}

					});
}


function accept_so(po_no,create_date)
{
    if(confirm('Are you sure accept this sale order?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('Home/ajax_accept')?>/"+po_no.split("/").join("").split(" ").join("").split("-").join("") +'/' +create_date,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
								 location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
								alert('Error accept data' + textStatus + errorThrown);
            }
        });

    }
}

function cancel_so(po_no,create_date)
{
    if(confirm('Are you sure reject this sale order?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('Home/ajax_cancel')?>/"+po_no.split("/").join("").split(" ").join("").split("-").join("") +'/' +create_date,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
								 location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
								alert('Error accept data' + textStatus + errorThrown);
            }
        });

    }
}

function delete_so(info)
{
    if(confirm('Are you sure delete this sale order?'))
    {
        // ajax delete data to database
        $.ajax({
						data :{ "info" : info},
            url : "<?php echo site_url('Home/ajax_delete_so')?>",
						type : "POST",
						dataType: "JSON",
            success: function(msg)
            {
                //if success reload ajax table
								//console.log(msg);
								 location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
								alert('Error accept data' + textStatus + errorThrown);
            }
        });

    }
}


function accept_so_all(info)
{
    if(confirm('Are you sure accept this sale order?'))
    {
        // ajax delete data to database
        $.ajax({
						data :{ "info" : info},
            url : "<?php echo site_url('Home/ajax_accept_so_all')?>",
						type : "POST",
						dataType: "JSON",
            success: function(msg)
            {
                //if success reload ajax table
								//console.log(msg);
								 location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
								alert('Error accept data' + textStatus + errorThrown);
            }
        });

    }
}

function cancel_so_all(info)
{
    if(confirm('Are you sure reject this sale order?'))
    {
        // ajax delete data to database
        $.ajax({
						data :{ "info" : info},
            url : "<?php echo site_url('Home/ajax_cancel_so_all')?>",
						type : "POST",
						dataType: "JSON",
            success: function(msg)
            {
                //if success reload ajax table
								//console.log(msg);
								 location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
								alert('Error accept data' + textStatus + errorThrown);
            }
        });

    }
}





function reload_table()
{
			$.ajax({
							url   : '<?php echo base_url('Home/ajax_select_so_mgr')?>',
							async : false,
							dataType : 'JSON',
							success : function(data){
									var html = '';
									var i;

									console.log(data);
									for(i=0; i<data.length; i++){
											html += '<tr >'
											+ '<td></td>'
											+ '<td>'+ data[i].PO_NO +'</td>'
											+ '<td>'+ data[i].DATE_ORDER  +'</td>'

											+ '<td>'+ data[i].CREATE_DATE +'</td>'
											+ '<td>'+ data[i].UPDATE_DATE +'</td>'
											+ '<td>'+ data[i].USERNAME +'</td>'
											+ '<td>';
											if(data[i].FLAG==0){
												html+= 'Belum Diproses';
											}
											else if(data[i].FLAG==1){
													html+= 'Telah Disetujui.';
											}
											else if(data[i].FLAG==2){
													html+= 'Sudah Masuk Ke Sistem.';
											}
											else if(data[i].FLAG==3){
												html+= 'Ditolak.';
											}
											else{
												html+= 'Ditolak Oleh Sistem.';
											}

											html+='</td>'
											+ '<td style="display:none;">'+ data[i].IDENTIFICATION + '</td>'
											+ '<td>'+
											'<a class="btn btn-sm btn-info" href="javascript:void(0)" title="Details" onclick="detail_so('+"'"+data[i].PO_NO+"'"+','+"'"+data[i].IDENTIFICATION+"'"+')">Detail</a>'
											+'</td>'
											+ '<td>';
											if(data[i].FLAG==0)
											html+='<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Diterima" onclick="accept_so('+"'"+data[i].PO_NO+"'"+','+"'"+data[i].IDENTIFICATION+"'"+')">Diterima</a>'
											+ '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Ditolak" onclick="cancel_so('+"'"+data[i].PO_NO+"'"+','+"'"+data[i].IDENTIFICATION+"'"+')"><i class="glyphicon glyphicon-trash"></i> Ditolak</a>';

											html +='</td>'
											+ '</tr>';
									}
									$('#show_data').html(html);
							}

					});
}
</script>
</html>
