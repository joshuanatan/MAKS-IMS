<?php
class Database extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $config = array(
            'cipher' => 'aes-256',
            'mode' => 'cbc',
            'key' => 'THWmuoIc87a4AvugOywNLUJ0yYPD1ggH'
        );
        $this->load->library("encryption",$config);
    }
    public function get_table_list(){
        $where = array(
            "id_submit_db_connection" => $this->input->post("id_db_connection")
        );
        $field = array(
            "db_hostname","db_username","db_password","db_name"
        );
        $result = selectRow("tbl_db_connection",$where,$field);
        $result_array = $result->result_array();

        $config['hostname'] = $result_array[0]["db_hostname"];
        $config['username'] = $result_array[0]["db_username"];
        $config['password'] = $this->encryption->decrypt($result_array[0]["db_password"]);
        $config['database'] = $result_array[0]["db_name"];
        $config['dbdriver'] = 'mysqli';

        $db = $this->load->database($config,TRUE);
        $result = $db->list_tables();
        $db->close();
        $response = array();
        $count = 0;
        foreach($result as $a){
            $response[$count]["nama_table"] = $a;
            $count++;
        }
        echo json_encode($response);
    }
    public function get_list_kolom(){
        
        $table_name = $this->input->post("table_name");
        $where = array(
            "id_submit_db_connection" => $this->input->post("id_db_connection")
        );
        $field = array(
            "db_hostname","db_username","db_password","db_name"
        );
        
        $result = selectRow("tbl_db_connection",$where,$field);
        $result_array = $result->result_array();

        $config['hostname'] = $result_array[0]["db_hostname"];
        $config['username'] = $result_array[0]["db_username"];
        $config['password'] = $this->encryption->decrypt($result_array[0]["db_password"]);
        $config['database'] = $result_array[0]["db_name"];
        $config['dbdriver'] = 'mysqli';

        $db = $this->load->database($config,TRUE);
        $fields = $db->list_fields($table_name);
        $db->close();
        
        $response = array();
        $counter = 0;
        foreach ($fields as $field){
            $response[$counter]["column_name"] = $field;
            $counter++;
        }
        echo json_encode($response);
        
    }
}
?>