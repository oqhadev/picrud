<?php
error_reporting(0);
require_once 'core/harviacode.php';
require_once 'core/helper.php';
require_once 'core/process.php';
?>
<!doctype html>
<html>
    <head>
        <title>PiCrud based on harviacode CRUDGEN   </title>
        <link rel="stylesheet" href="core/bootstrap.min.css"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
 
        <div class="row " style="" >
            <div class="col-md-3 " style="background-color: #008080;padding: 10px;padding-top: 20px;margin-top: -20px;" >
                <form action="index.php" method="POST">

                    <div class="form-group">
                        <label>Select Table - <a href="<?php echo $_SERVER['PHP_SELF'] ?>">Refresh</a></label>
                        <select id="table_name" name="table_name" class="form-control" onchange="setname()">
                            <option value="">Please Select</option>
                            <?php
                            $table_list = $hc->table_list();
                            $table_list_selected = isset($_POST['table_name']) ? $_POST['table_name'] : '';
                            foreach ($table_list as $table) {
                                ?>
                                <option value="<?php echo $table['table_name'] ?>" <?php echo $table_list_selected == $table['table_name'] ? 'selected="selected"' : ''; ?>><?php echo $table['table_name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
               <strong>Style</strong> 
                    <div class="form-group">
                        <div class="row">
                            <?php $jenis_tabel = isset($_POST['jenis_tabel']) ? $_POST['jenis_tabel'] : 'reguler_table'; ?>
                            <div class="col-md-6">
                                <div class="radio" style="margin-bottom: 0px; margin-top: 0px">
                                    <label>
                                        <input type="radio" disabled  name="jenis_tabel" value="reguler_table" >
                                        Reguler Table
                                    </label>
                                </div>                            
                            </div>
                            <div class="col-md-6">
                                <div class="radio" style="margin-bottom: 0px; margin-top: 0px">
                                    <label>
                                        <input type="radio" name="jenis_tabel" value="datatables" checked>
                                        Ajax Datatables
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

<strong>Export</strong>            

                    <div class="form-group">
                        <div class="checkbox">
                            <?php $export_excel = isset($_POST['export_excel']) ? $_POST['export_excel'] : ''; ?>
                            <label>
                                <input type="checkbox" name="export_excel" value="1" <?php echo $export_excel == '1' ? 'checked' : '' ?>>
                                Export Excel
                            </label>
                        </div>
                   
                        <div class="checkbox">
                            <?php $export_pdf = isset($_POST['export_pdf']) ? $_POST['export_pdf'] : ''; ?>
                            <label>
                                <input type="checkbox" disabled name="export_pdf" value="1" <?php echo $export_pdf == '1' ? 'checked' : '' ?>>
                                Export PDF
                            </label>
                        </div>
                  
                        <div class="checkbox">
                            <?php $export_word = isset($_POST['export_word']) ? $_POST['export_word'] : ''; ?>
                            <label>
                                <input type="checkbox" name="export_word" value="1" <?php echo $export_word == '1' ? 'checked' : '' ?>>
                                Export Word
                            </label>
                        </div>
                    </div>    
<strong>Others</strong>  
                      <div class="form-group">
                        <div class="checkbox">
                            <?php $tanpa_html = isset($_POST['tanpa_html']) ? $_POST['tanpa_html'] : ''; ?>
                            <label>
                                <input type="checkbox" name="tanpa_html" value="1" <?php echo $tanpa_html == '1' ? 'checked' : '' ?>>
                                Tanpa HTML
                            </label>
                        </div>
                    </div>    
                    <!--                    <div class="form-group">
                                            <div class="checkbox  <?php // echo file_exists('../application/third_party/mpdf/mpdf.php') ? '' : 'disabled';   ?>">
                    <?php // $export_pdf = isset($_POST['export_pdf']) ? $_POST['export_pdf'] : ''; ?>
                                                <label>
                                                    <input type="checkbox" name="export_pdf" value="1" <?php // echo $export_pdf == '1' ? 'checked' : ''   ?>
                    <?php // echo file_exists('../application/third_party/mpdf/mpdf.php') ? '' : 'disabled'; ?>>
                                                    Export PDF
                                                </label>
                    <?php // echo file_exists('../application/third_party/mpdf/mpdf.php') ? '' : '<small class="text-danger">mpdf required, download <a href="http://harviacode.com">here</a></small>'; ?>
                                            </div>
                                        </div>-->


                    <div class="form-group">
                        <label>Custom Controller Name</label>
                        <input type="text" id="controller" name="controller" value="<?php echo isset($_POST['controller']) ? $_POST['controller'] : '' ?>" class="form-control" placeholder="Controller Name" />
                    </div>
                    <div class="form-group">
                        <label>Custom Model Name</label>
                        <input  type="text" id="model" name="model" value="<?php echo isset($_POST['model']) ? $_POST['model'] : '' ?>" class="form-control" placeholder="Controller Name" />
                    </div>
                    <div class="input-group">
                    </div>

                            
                    <input type="submit" value="Generate" name="generate" class="btn btn-primary pull-right" onclick="javascript: return confirm('This will overwrite the existing files. Continue ?')" />
                  
                    <a class="btn btn-success pull-left" href="core/setting.php">Setting</a>
                       
                </form>
                <br>
<br>
                <?php
                foreach ($hasil as $h) {
                    echo '<p>' . $h . '</p>';
                }
                ?>
            </div>
            <div class="col-md-9">
                <h3 style="margin-top: 0px"><b>PiCrud</b> 
<small>designed for ajaxLoadPage/DynamicOnePage Site</small>
                <br>Generator crud for Code Igniter based on harvia code <br>
                </h3>

   
<blockquote>Status  <br><br>

    <div class="btn-group">
    <button type="button" class="btn btn-success" disabled>Create</button>
    <button type="button" class="btn btn-success" disabled>Read</button>
    <button type="button" class="btn btn-success" disabled>Update</button>
    <button type="button" class="btn btn-success" disabled>Delete</button>
    </div>
  
    <div class="btn-group">

    <button type="button" class="btn btn-success" disabled>export excel</button>
    <button type="button" class="btn btn-success" disabled>export word</button>
    <button type="button" class="btn btn-warning" disabled>export pdf <span class="badge">50%</span> </button>
</div>
<br><br>
    <div class="btn-group">
    <button type="button" class="btn btn-success" disabled>Notification</button>
    <button type="button" class="btn btn-success" disabled>More Input type</button>
    <button type="button" class="btn btn-danger" disabled>Validation</button>
    <button type="button" class="btn btn-danger" disabled>Reguler Table</button>
    <button type="button" class="btn btn-danger" disabled>Clean</button>
</div>
<br><br>
Using/Requiment
<ul class="list-group">
    <li class="list-group-item">Jquery.Ajax</li>
    <li class="list-group-item">Datatables.js - Table controller</li>
    <li class="list-group-item">Noty.js - Notification </li>
    <li class="list-group-item">Bootstrap - css </li>
</ul>
Chnagelog
<ul class="list-group">
    <li class="list-group-item"><b>16-11-2016 => </b> 
 
    input_type(Enum,date,number),
    tanpa_html,
    notification   ditambahkan 
   
   </li>
</ul>
</blockquote>
    

            </div>
        </div>
        <script type="text/javascript">
            function capitalize(s) {
                return s && s[0].toUpperCase() + s.slice(1);
            }

            function setname() {
                var table_name = document.getElementById('table_name').value.toLowerCase();
                if (table_name != '') {
                    document.getElementById('controller').value = capitalize(table_name);
                    document.getElementById('model').value = capitalize(table_name) + '_model';
                } else {
                    document.getElementById('controller').value = '';
                    document.getElementById('model').value = '';
                }
            }
        </script>
    </body>
</html>
