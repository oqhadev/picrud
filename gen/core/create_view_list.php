<?php 

$string = "<!doctype html>
<html>
    <head>
        <title>harviacode.com - zzz</title>
       <!-- Bootstrap Core CSS -->
	<link href=\"assets/css/bootstrap.min.css\" rel=\"stylesheet\">
	
	<link href=\"assets/font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\">


	<script src=\"assets/js/jquery.js\"></script>


	<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/js/datatable/datatables.min.css\"/>

    <script type=\"text/javascript\" src=\"assets/js/datatable/datatables.min.js\"></script>
    <script src=\"assets/js/bootstrap.js\"></script>

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
        \"url\": \"<?php echo site_url('p_pengelola/ajax_list')?>\",
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
        
    </script>

    </head>
    <body>
        <h2 style=\"margin-top:0px\">".ucfirst($table_name)." List</h2>
        <div class=\"row\" style=\"margin-bottom: 10px\">
            <div class=\"col-md-4\">
                <?php echo anchor(site_url('".$c_url."/create'),'Create', 'class=\"btn btn-primary\"'); ?>
            </div>
            <div class=\"col-md-4 text-center\">
                <div style=\"margin-top: 8px\" id=\"message\">
                    <?php echo \$this->session->userdata('message') <> '' ? \$this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class=\"col-md-1 text-right\">
            </div>
            <div class=\"col-md-3 text-right\">
                <form action=\"<?php echo site_url('$c_url/index'); ?>\" class=\"form-inline\" method=\"get\">
                    <div class=\"input-group\">
                        <input type=\"text\" class=\"form-control\" name=\"q\" value=\"<?php echo \$q; ?>\">
                        <span class=\"input-group-btn\">
                            <?php 
                                if (\$q <> '')
                                {
                                    ?>
                                    <a href=\"<?php echo site_url('$c_url'); ?>\" class=\"btn btn-default\">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class=\"btn btn-primary\" type=\"submit\">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table id=\"table\" class=\"table table-bordered\" style=\"margin-bottom: 10px\">
            <tr>
                <th>No</th>";
foreach ($non_pk as $row) {
    $string .= "\n\t\t<th>" . label($row['column_name']) . "</th>";
}
$string .= "\n\t\t<th>Action</th>
            </tr>

        </table>
        <div class=\"row\">
            <div class=\"col-md-6\">
                <a href=\"#\" class=\"btn btn-primary\">Total Record : <?php echo \$total_rows ?></a>";
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
            <div class=\"col-md-6 text-right\">
                <?php echo \$pagination ?>
            </div>
        </div>
    </body>
</html>";


$hasil_view_list = createFile($string, $target."views/" . $c_url . "/" . $v_list_file);

?>