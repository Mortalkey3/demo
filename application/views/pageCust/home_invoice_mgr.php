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
                       <h1 class="page-header">Table Pending Invoice</h1>
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
                                           <th>Nomor Invoice</th>
                                           <th>Tanggal Invoice</th>
                                           <th>Nomor PO</th>
                                           <th>Nomor Sale Order</th>
                                           <th>Nomor DO</th>
																					 <th>Amount Remaining</th>
																					 <th>Jatuh Tempo</th>
																					 <th>Telat</th>
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
            "orderable": true, //set not orderable
        },
        ],

    });




});

function refresh()
{
		location.reload();
}


function reload_table()
{
			$.ajax({
							url   : '<?php echo base_url('Home/ajax_select_invoice')?>',
							async : false,
							dataType : 'JSON',
							success : function(data){
									var html = '';
									var i;
									for(i=0; i<data.length; i++){
											html += '<tr >'
											+ '<td>'+ data[i].TRX_NUMBER +'</td>'
											+ '<td>'+ data[i].TRX_DATE  +'</td>'
											+ '<td>'+ data[i].PURCHASE_ORDER +'</td>'
											+ '<td>'+ data[i].SALES_ORDER +'</td>'
											+ '<td>'+ data[i].NOMOR_DO +'</td>'
											+ '<td style="float:right;text-align: right;">'+ parseFloat(data[i].AMOUNT).toLocaleString()  +'</td>'
											+ '<td>'+ data[i].DUE_DATE +'</td>'
											+ '<td>';
											if(data[i].TELAT>0)
												html += data[i].TELAT;
											html +='</td>'
											+ '</tr>';
									}
									$('#show_data').html(html);
							}

					});
}
</script>
</html>
