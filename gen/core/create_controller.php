<?php

$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class " . $c . " extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        \$this->load->model('$m');
        \$this->load->library('form_validation');
    }";


    
    $string .="\n\n    public function index()
    {

        \$this->load->view('$c_url/$v_list');
    }";



    $string.=" public function ajax_get()
    {
        \$list = \$this->" . $m . "->get_datatables();
        \$data = array();
        \$no = \$_POST['start'];
        foreach (\$list as \$$table_name) {
            \$no++;
            \$row = array();

            \$row[] =\$no;
            ";

            foreach ($non_pk as $row) {
                $string .= "\n\$row[] = \$$table_name->" . $row['column_name'] . ";";
            }



            $string.="
            \$row[] = '<a class=\"btn btn-sm btn-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit('.\"'\".\$$table_name->$pk.\"'\".')\"><i class=\"glyphicon glyphicon-pencil\"></i></a>
            <a class=\"btn btn-sm btn-danger\" href=\"javascript:void(0)\" title=\"Hapus\" onclick=\"delete1('.\"'\".\$$table_name->$pk.\"'\".')\"><i class=\"glyphicon glyphicon-trash\"></i></a>';";



            $string.="            \$data[] = \$row;
        }

        \$output = array(
        \"draw\" => \$_POST['draw'],
        \"recordsTotal\" => \$this->" . $m . "->count_all(),
        \"recordsFiltered\" => \$this->" . $m . "->count_filtered(),
        \"data\" => \$data,
        );
        echo json_encode(\$output);
    }
    ";





    $string.="
    public function ajax_add()
    {
        \$data = array(";
        foreach ($non_pk as $row) {
            $string .= "\n'" . $row['column_name'] . "' => \$this->input->post('" . $row['column_name'] . "'),";
        }

  

        $string.="            );
        \$insert = \$this->" . $m . "->save(\$data);
        echo json_encode(array(\"status\" => TRUE));
    }
    ";
  $string.="   public function ajax_edit(\$id)
    {
        \$data =\$this->".$m."->get_by_id(\$id);
        echo json_encode(\$data);
    }





 public function ajax_update()
    {
        \$data = array(";
        foreach ($non_pk as $row) {
            $string .= "\n'" . $row['column_name'] . "' => \$this->input->post('" . $row['column_name'] . "'),";
        }

  

        $string.="  );
        \$this->".$m."->update(array('".$pk."' => \$this->input->post('".$pk."')), \$data);
        echo json_encode(array(\"status\" => TRUE));
    }
 public function ajax_delete(\$id)
    {
        \$this->".$m."->delete_by_id(\$id);
        echo json_encode(array(\"status\" => TRUE));
    }











    ";

    


    if ($export_excel == '1') {
        $string .= "\n\n    public function excel()
        {
            \$this->load->helper('exportexcel');
            \$namaFile = \"$table_name.xls\";
            \$judul = \"$table_name\";
            \$tablehead = 0;
            \$tablebody = 1;
            \$nourut = 1;
        //penulisan header
            header(\"Pragma: public\");
            header(\"Expires: 0\");
            header(\"Cache-Control: must-revalidate, post-check=0,pre-check=0\");
            header(\"Content-Type: application/force-download\");
            header(\"Content-Type: application/octet-stream\");
            header(\"Content-Type: application/download\");
            header(\"Content-Disposition: attachment;filename=\" . \$namaFile . \"\");
            header(\"Content-Transfer-Encoding: binary \");

            xlsBOF();

            \$kolomhead = 0;
            xlsWriteLabel(\$tablehead, \$kolomhead++, \"No\");";
            foreach ($non_pk as $row) {
                $column_name = label($row['column_name']);
                $string .= "\n\txlsWriteLabel(\$tablehead, \$kolomhead++, \"$column_name\");";
            }
            $string .= "\n\n\tforeach (\$this->" . $m . "->get_all() as \$data) {
                \$kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
                xlsWriteNumber(\$tablebody, \$kolombody++, \$nourut);";
                foreach ($non_pk as $row) {
                    $column_name = $row['column_name'];
                    $xlsWrite = $row['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? 'xlsWriteNumber' : 'xlsWriteLabel';
                    $string .= "\n\t    " . $xlsWrite . "(\$tablebody, \$kolombody++, \$data->$column_name);";
                }
                $string .= "\n\n\t    \$tablebody++;
                \$nourut++;
            }

            xlsEOF();
            exit();
        }";
    }

    if ($export_word == '1') {
        $string .= "\n\n    public function word()
        {
            header(\"Content-type: application/vnd.ms-word\");
            header(\"Content-Disposition: attachment;Filename=$table_name.doc\");

            \$data = array(
            '" . $table_name . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
            );

            \$this->load->view('" . $c_url ."/". $v_doc . "',\$data);
        }";
    }

    if ($export_pdf == '1') {
        $string .= "\n\n    function pdf()
        {
            \$data = array(
            '" . $table_name . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
            );

            ini_set('memory_limit', '32M');
            \$html = \$this->load->view('" . $c_url ."/". $v_pdf . "', \$data, true);
            \$this->load->library('pdf');
            \$pdf = \$this->pdf->load();
            \$pdf->WriteHTML(\$html);
            \$pdf->Output('" . $table_name . ".pdf', 'D'); 
        }";
    }

    $string .= "\n\n}\n\n/* End of file $c_file */
    /* Location: ./application/controllers/$c_file */
    /* Please DO NOT modify this information : */
    /* Generated by Harviacode Codeigniter CRUD Generator ".date('Y-m-d H:i:s')." */
    /* http://harviacode.com */";




    $hasil_controller = createFile($string, $target . "controllers/" . $c_file);

    ?>