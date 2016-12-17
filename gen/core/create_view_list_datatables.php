<?php 
$string='';
if($tanpa_html!=1){


$string = "<!doctype html>
<html>
    <head>
        <title>piCrud - based on harvia</title>
       <!-- CSS -->
    <link href=\"<?= base_url() ?>assets/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link href=\"<?= base_url() ?>assets/font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"<?= base_url() ?>assets/js/datatable/datatables.min.css\"/>

       <!-- JS -->
    <script src=\"<?= base_url() ?>assets/js/jquery.js\"></script>
	<script type=\"text/javascript\" src=\"<?= base_url() ?>assets/js/datatable/datatables.min.js\"></script>
    <script src=\"<?= base_url() ?>assets/js/bootstrap.js\"></script>
	<script src=\"<?= base_url() ?>assets/js/noty.js\"></script>






    </head>
    <body>";

}
$string.="        <div class=\"row\" style=\"margin-bottom: 10px\">
            <div class=\"col-md-4\">
                <h2 style=\"margin-top:0px\">".ucfirst($table_name)." List</h2>
            </div>
            <div class=\"col-md-4 text-center\">
                <div style=\"margin-top: 4px\"  id=\"message\">
                    <?php echo \$this->session->userdata('message') <> '' ? \$this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class=\"col-md-4 text-right\">
           <button class=\"btn btn-primary\" onclick=\"add()\">Tambah</button>";
if ($export_excel == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/excel'), 'Excel', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_word == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/word'), 'Word', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_pdf == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/pdf'), 'PDF', 'class=\"btn btn-primary\"'); ?>";
}
$string .= "\n\t    </div>
        </div>
        <table id=\"table\" class=\"table table-bordered table-striped\" style=\"width:100%\" id=\"mytable\">
            <thead>
                <tr>
                    <th style=\"width:20px\" >No</th>";
foreach ($non_pk as $row) {
    $string .= "\n\t\t    <th>" . label($row['column_name']) . "</th>";
}
$string .= "\n\t\t    <th style=\"width:80px\">Action</th>
                </tr>
            </thead>
        </table>
       
        <script type=\"text/javascript\">
            $(document).ready(function () {
                $(\"#mytable\").dataTable();
            });



        </script>


 <!-- Bootstrap modal -->
        <div class=\"modal fade\" id=\"modal\" role=\"dialog\">
            <div class=\"modal-dialog\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                        <h3 class=\"modal-title\"></h3>
                    </div>
                    <div class=\"modal-body form\" style=\"padding:30px\">
                        <form action=\"#\" id=\"form\" class=\"form-horizontal\">
                            <input type=\"hidden\" value=\"\" name=\"".$pk."\"/>
                           
                              

                              ";




                               foreach ($non_pk as $row) {
    if ($row["data_type"] == 'text')
    {
    $string .= "\n\t    



    <div class=\"form-group\">
            <label for=\"".$row["column_name"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
            <textarea class=\"form-control\" rows=\"3\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\"><?php echo @$".$row["column_name"]."; ?></textarea>
        </div>";
    }
    else if ($row["data_type"] == 'enum')
    {
    $string .= "\n\t    



    <div class=\"form-group\">
            <label for=\"".$row["column_name"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
           <select class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\">";
          
foreach (etoarray($row['column_type']) as  $vvvv) {
    $string.="<option>$vvvv</option>";

}

$string.="           </select>
        </div>";
    }   


    else if ($row["data_type"] == 'date')
    {
    $string .= "\n\t    



    <div class=\"form-group\">
            <label for=\"".$row["column_name"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
           <input type=\"date\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo @$".$row["column_name"]."; ?>\" />
        </div>";
    } 
    else if (($row["data_type"] == 'int')or($row["data_type"] == 'bigint'))
    {
    $string .= "\n\t    



    <div class=\"form-group\">
            <label for=\"".$row["column_name"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
           <input type=\"number\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo @$".$row["column_name"]."; ?>\" />
        </div>";
    } else
    {
    $string .= "\n\t    <div class=\"form-group\">
            <label for=\"".$row["data_type"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
            <input type=\"text\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo @$".$row["column_name"]."; ?>\" />
        </div>";
    }
}



          $string .= "                
                        </form>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" id=\"btnSave\" onclick=\"save()\" class=\"btn btn-primary\">Simpan</button>
                        <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Cancel</button>
                    </div>
                </div>
            </div>
        </div>





<div class=\"modal fade\" id=\"modal_delete\" role=\"dialog\">
            <div class=\"modal-dialog\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span>
                        </button>
                        <h3 class=\"modal-title\">Pengelola</h3>
                    </div>
                    <div class=\"modal-body form\">
                        
                        <button type=\"button\" id=\"btnDelete\" onclick=\"delete2()\" class=\"btn btn-primary\">Hapus</button>
                        <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Cancel</button>
                    </div>
                    
                </div>
            </div>
        </div>

    <script type=\"text/javascript\">

  
        var save_method; //for save method string
        var table;
        
        $(document).ready(function() {
        //datatables
        table = $('#table').DataTable({
        
        \"processing\": true, //Feature control the processing indicator.
        \"serverSide\": true, //Feature control DataTables' server-side processing mode.
        \"order\": [], //Initial no order.
        
        \"language\": {
        \"paginate\": {
        \"first\":      \"Pertama\",
        \"last\":       \"Terakhir\",
        \"next\":       \"Selanjutnya\",
        \"previous\":   \"Sebelumnya\"
        }
        },
        // Load data for the table's content from an Ajax source
        \"ajax\": {
        \"url\": \"<?php echo site_url('".$c_url."/ajax_get')?>\",
        \"global\": false,        
        \"type\": \"POST\"
        },
        
        //Set column definition initialisation properties.
        \"columnDefs\": [
        {
        \"targets\": [ -1 ], //last column
        \"orderable\": false, //set not orderable
        },
        ],
        
        });
        
        } );

         function add()
        {
        save_method = 'add';
        \$('#form')[0].reset(); // reset form on modals
        \$('#modal').modal('show'); // show bootstrap modal
        \$('.modal-title').text('Tambah ".ucfirst($table_name)."'); // Set Title to Bootstrap modal title
       
        }
        

         function reload_table()
        {
        table.ajax.reload(null,false); //reload datatable ajax
        }


        
         function save()
        {
        \$('#btnSave').text('Menyimpan... '); //change button text
        \$('#btnSave').attr('disabled',true); //set button disable
        var url;
        
        if(save_method == 'add') {
        url = \"<?php echo site_url('".$table_name."/ajax_add')?>\";
        } else {
        url = \"<?php echo site_url('".$table_name."/ajax_update')?>\";
        }
        
        // ajax adding data to database
        \$.ajax({
        url : url,
        type: \"POST\",
        global: false,        
        data: \$('#form').serialize(),
        dataType: \"JSON\",
        success: function(data)
        {
        
        if(data.status) //if success close modal and reload ajax table
        {
        \$('#modal').modal('hide');
        reload_table();
         }
        
        \$('#btnSave').text('Simpan'); //change button text
        \$('#btnSave').attr('disabled',false); //set button enable
        
          if(save_method == 'add') {
         notif('Sukses menambahkan data');
        } else {
         notif('Sukses mengubah data');
        }


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        alert('Error adding / update data');
        \$('#btnSave').text('Simpan'); //change button text
        \$('#btnSave').attr('disabled',false); //set button enable
        
        }
        });
        }


         function edit(id)
        {
        save_method = 'update';
        \$('#form')[0].reset(); // reset form on modals
        \$('.form-group').removeClass('has-error'); // clear error class
        \$('.help-block').empty(); // clear error string
        
        //Ajax Load data from ajax
        \$.ajax({
        url : \"<?php echo site_url('".$table_name."/ajax_edit/')?>/\" + id,
        type: \"GET\",
        global: false,   
        dataType: \"JSON\",
        success: function(data)
        {
 

         \$('[name=\"$pk\"]').val(id);";

foreach ($non_pk as $row) {
    $string .= "\n \$('[name=\"".$row['column_name']."\"]').val(data.".$row['column_name'].");";
}
        
       
       



$string.="        \$('#modal').modal('show'); // show bootstrap modal when complete loaded
        \$('.modal-title').text('Ubah ".$table_name."'); // Set title to Bootstrap modal title
        
        },
                error: function (jqXHR, textStatus, errorThrown)
        {
        alert('Error get data from ajax');
        }
        });
        }


 function delete1(id)
        {
        \$('#form')[0].reset(); // reset form on modals
        \$('.form-group').removeClass('has-error'); // clear error class
        \$('.help-block').empty(); // clear error string
        
        
        \$('#btnDelete').val(id);
        \$('#modal_delete').modal('show'); // show bootstrap modal when complete loaded
        \$('.modal-title').text('Apakah anda yakin?'); // Set title to Bootstrap modal title
        
        }
        function delete2()
        {
        \$('#btnDelete').text('Menghapus... '); //change button text
        \$('#btnDelete').attr('disabled',true); //set button disable
        var url;
        
        url = \"<?php echo site_url('".$table_name."/ajax_delete')?>/\"+ document.getElementById('btnDelete').value;
        
        // ajax adding data to database
        \$.ajax({
        url : url,
        type: \"POST\",
        global: false,   
        dataType: \"JSON\",
        success: function(data)
        {
        \$('#modal_delete').modal('hide');
        reload_table();
        \$('#btnDelete').text('Hapus'); //change button text
        \$('#btnDelete').attr('disabled',false); //set button enable
         notif('Sukses menghapus data');
        
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        alert('Error deleting data');
        \$('#btnDelete').text('Hapus'); //change button text
        \$('#btnDelete').attr('disabled',false); //set button enable
        
        }
        });
        }
        
        function notif(msg) {
        var n = noty({
            text        : msg,
            type        : 'success',
            dismissQueue: true,
            layout      : 'bottomLeft',
            theme       : 'defaultTheme'
        });
    }   


    </script>";



if($tanpa_html!=1){
$string.="    </body>
</html>";
}

$hasil_view_list = createFile($string, $target."views/" . $c_url . "/" . $v_list_file);

?>