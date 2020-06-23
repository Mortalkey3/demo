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
                       <h1 class="page-header">Import Purchase Order</h1>

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
                                        class="import_exl" >Import</button>
																				<div class="loader" id="loader" style="float: right;"></div>
                                      </div>
                                    </div>
                                </div>

                            </form>
                          </div>
                           <!-- /.panel-heading -->
													 <form action="<?php echo base_url();?>Home/import_form"
															 name="import_form" id="import_form" method="post" class="form-horizontal">

                           <div class="panel-body table-responsive">
														 <a href="<?php echo base_url(); ?>assets/example/Contoh Table Purchase Order.xlsx" download>Contoh Import Excel Purchase Order</a>

														 <table class="table table-striped table-bordered table-hover">

																	 <thead>
                                       <tr>
                                           <th>Nomor PO</th>
                                           <th>Tanggal</th>
                                           <th>Cabang</th>
                                           <th>Product</th>
                                           <th>QTY</th>
                                           <th>UOM</th>
                                           <th>Order Type</th>
                                           <th>Pricelist</th>
                                           <th>Status</th>
																					 <th>Action</th>
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

		function check_line(id)
		{
				var orderType=[];
				$('select[name="orderType[]"] option:selected').each(function() {
						orderType.push($(this).text());
				});
				console.log(orderType);
				var pricelist=[];
				$('select[name="pricelist[]"] option:selected').each(function() {
						pricelist.push($(this).text());
				});
				console.log(pricelist);
				product = $('input[name="product[]"]').eq(id).val();
				noPO = $('input[name="noPO[]"]').eq(id).val();
		    $.ajax({
		        url : "<?php echo site_url('Home/ajax_check/')?>" + id  ,
						data: {'product':product,'orderType':orderType[id],'pricelist':pricelist[id],'noPO':noPO},
		        type: "POST",
		        dataType: "JSON",
		        success: function(data)
		        {
								console.log(noPO);
		            $('input[name="status[]"]').eq(id).val(data.res_status);
								$('input[name="uom[]"]').eq(id).val(data.uom);
								var index = $('select[name="pricelist[]"] option').filter(function(){
    								return $.trim($(this).text()) === data.pricelist}).index();;
								$('select[name="pricelist[]"]').eq(id).prop("selectedIndex",index).change();

								var index1 = $('select[name="orderType[]"] option').filter(function(){
    								return $.trim($(this).text()) === data.order_type}).index();;
								$('select[name="orderType[]"]').eq(id).prop("selectedIndex",index1).change();
								if(data.res_status==''){
									alert('Status Salah'  );
								}
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
							$('input[name="status[]"]').eq(id).val('');
		            alert('Status Salah' );
		        }
		    });
		}

		function setVisible(selector, visible) {
  			document.querySelector(selector).style.display = visible ? 'block' : 'none';
		}


		$('#form').on('submit', function(event){
				event.preventDefault();
				setVisible('#loader', true);

				$('#import_exl').attr("disabled", true);
				//Ajax Load data from ajax
				$.ajax({
						url : "<?php echo site_url('Home/import')?>",
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
								console.log(res);
								var html = '';
								var i;
								var today = new Date();
								var dd = today.getDate();
								var mm = today.getMonth()+1;
								var yy = today.getFullYear();
								if(dd<10)
								{
									dd='0'+dd
								}
								if(mm<10)
								{
									mm='0'+mm
								}
								var today1 = yy+'-'+mm+'-'+dd;

								for(i=0; i<res.value.length; i++){
										if(res.value[i].tanggal> today){ today2 = convert(res.value[i].tanggal) }else{ today2 = today1}
										html += '<tr >'
										+ '<td><input type="text" name="noPO[]"  value="'+ res.value[i].noPO +'"></input></td>'
										+ '<td><input type="date" name="tanggal[]" value="'+  today2 +'" min="'+ today1 +'"></input></td>'
										+ '<td><select name="branch[]" class="form-control" id="branch" style="width:200px;">';
										for(a=0; a<res.tujuan.length; a++) {
											html += '<option value="' + res.tujuan[a].NAME + '"' ;
											if(res.tujuan[a].NAME==res.value[i].branch)
											{
														html += 'selected="selected"';
											}
											html +='>'
											+ res.tujuan[a].NAME + '</option>';
										};
										html += '</select></td>'
										+ '<td><input type="text" name="product[]" value="'+ res.value[i].product +'"></input></td>'
										+ '<td><input type="number" name="qty[]" value="'+ res.value[i].qty +'"></input></td>'+
										'<td><input class="readonly" type="text" name="uom[]" value="'+ res.value[i].uom +'" required onchange="event.preventDefault()" onkeydown="event.preventDefault()" onpaste="event.preventDefault()" autocomplete="off"></input></td>'+
										'<td><select name="orderType[]" class="form-control" id="orderType" style="width:200px;">' ;
												for(a=0; a<res.orderType.length; a++) {
													html += '<option value="' + res.orderType[a].ORDER_TYPE + '"' ;
													if(res.orderType[a].ORDER_TYPE==res.value[i].orderType)
													{
																html += 'selected="selected"';
													}
													html +='>'
													+ res.orderType[a].ORDER_TYPE + '</option>';
												};

										html += '</select></td>';
										html +='<td><select name="pricelist[]" class="form-control" id="pricelist" style="width:200px;">'
										for(a=0; a<res.pricelist.length; a++) {
											html += '<option value="' + res.pricelist[a].PRICE_LIST + '"' ;
											if(res.pricelist[a].DESCRIPTION==res.value[i].pricelist)
											{
														html += 'selected="selected"';
											}
											html +='>'
											+ res.pricelist[a].DESCRIPTION + '</option>';
										};

										html += '</select></td>'
										+ '<td><input class="readonly" autocomplete="off" name="status[]" value="'+ res.status[i].status +'" required onchange="event.preventDefault()" onkeydown="event.preventDefault()" onpaste="event.preventDefault()" autocomplete="off"></input></td>'
										+'<td><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Check" onclick="check_line('+i+')"><i class="glyphicon glyphicon-pencil"></i> Check</a></td>' +
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
							//

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
