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
                       <h1 class="page-header">Data Accounts Manager</h1>
                   </div>
                   <!-- /.col-lg-12 -->
               </div>
               <!-- /.row -->
               <div class="row">
                   <div class="col-lg-12">
                       <div class="panel panel-default">
                          <div class="panel-heading">
                            <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Person</button>
                          </div>
                           <!-- /.panel-heading -->
                           <div class="panel-body">
                              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                   <thead>
                                       <tr>
                                           <th>Username</th>
                                           <th>Password</th>
                                           <th>Customer</th>
                                           <th>Create Date</th>
                                           <th>Last Update </th>
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

           </div>
           <!-- /#page-wrapper -->

       </div>


<!--JavaScript-->
<?php echo $js?>
<!--Ajax-->
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

    //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});



function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Account'); // Set Title to Bootstrap modal title
    $.ajax({
        url : "<?php echo base_url('Admin/ajax_select')?>",
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
						console.log(data);
        }
    });
}

function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Admin/ajax_edit/')?>/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="acc_id"]').val(data.ID);
            $('[name="username"]').val(data.USERNAME);
            $('[name="password"]').val(data.PASS);
            $('[name="customer"]').val(data.CUSTOMER_ID).text(data.CUST_NAME);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}


function save(auth)
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('Admin/ajax_add')?>/"+auth;
    } else {
        url = "<?php echo base_url('Admin/ajax_update')?>/" + auth;
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(res)
        {
					if(res.res_status == 1 && res.result !=0){
						$('#modal_form').modal('hide');
						$('#btnSave').text('save'); //change button text
						$('#btnSave').attr('disabled',false); //set button enable
						console.log(res.result);
						reload_table();
					}
					else if(res.res_status == 0){
						alert('Isi username dan password!');
						$('#btnSave').text('save'); //change button text
						$('#btnSave').attr('disabled',false);
					}
					else{
						alert('Username sudah ada!');
						$('#btnSave').text('save'); //change button text
						$('#btnSave').attr('disabled',false);
					}

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
					alert('Error adding / update data');
					$('#btnSave').text('save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable
        }
    });
}

function delete_person(id)
{
    if(confirm('Are you sure delete this account?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('Admin/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
								reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
								alert('Error deleting data' + textStatus + errorThrown);
            }
        });

    }
}


function reload_table()
{
			$.ajax({
							url   : '<?php echo base_url('Admin/ajax_select_account_mgr')?>',
							async : false,
							dataType : 'JSON',
							success : function(data){
									var html = '';
									var i;
									for(i=0; i<data.length; i++){
											html += '<tr >'
											+ '<td>'+ data[i].USERNAME +'</td>'
											+ '<td>'+ data[i].PASS  +'</td>'
											+ '<td>'+ data[i].ORGANIZATION_NAME +'</td>'
											+ '<td>'+ data[i].CREATE_DATE  +'</td>'
											+ '<td>'+ data[i].UPDATE_DATE +'</td>'
											+ '<td>'+
											'<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('+"'"+data[i].ID+"'"+')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>'
											+ '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('+"'"+data[i].ID+"'"+')"><i class="glyphicon glyphicon-trash"></i> Delete</a>'
											+'</td>'
											+ '</tr>';
									}
									$('#show_data').html(html);
							}

					});
}
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Account Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal" type='POST'>
                    <input type="hidden" value="" name="acc_id" id="acc_id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Username</label>
                            <div class="col-md-9">
                                <input name="username" id="username" placeholder="Username" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Password</label>
                            <div class="col-md-9">
                                <input name="password" id="password" placeholder="Password" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Costumer</label>
                            <div class="col-md-9">
                                <select name="customer" class="form-control" id="customer">
																	<?php
																		foreach ($cust as $row) {
																			echo '<option value="'. $row->CUST_ID .'">'.$row->CUST_NAME.'</option>';
																		}

																	 ?>
																</select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save(2)" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



</body>

</html>
