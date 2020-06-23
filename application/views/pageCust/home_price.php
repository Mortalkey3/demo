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
                       <h1 class="page-header">Table Price</h1>
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
                                           <th>No Product</th>
																					 <th>Product</th>
                                           <th>Pricelist</th>
                                           <th>Order Type</th>
                                           <th>Harga</th>
                                           <th>UOM</th>
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


    });




});



function refresh()
{
		location.reload();
}


function reload_table()
{
			$.ajax({
							url   : '<?php echo base_url('Home/ajax_select_price')?>',
							async : false,
							dataType : 'JSON',
							success : function(data){
									var html = '';
									var i;
									console.log(data);

									for(i=0; i<data.length; i++){
										var price = data[i].PRICELIST;
											html += '<tr >'
											+ '<td>'+ data[i].PRODUCT +'</td>'
											+ '<td>'+ data[i].NAME +'</td>'
											+ '<td>'+ price.replace(/(\d+).*/,"")  +'</td>'
											+ '<td>'+ data[i].ORDER_TYPE +'</td>'
											+ '<td>'+ data[i].HARGA +'</td>'
											+ '<td>'+ data[i].UOM +'</td>'
											+ '</tr>';
									}
									$('#show_data').html(html);
							}

					});
}
</script>
</html>
