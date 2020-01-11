<?php
class Entity extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function get_entity_value_from_entity_name(){
        $where = array(
            "entity_name" => $this->input->post("entity_name"),
            "status_aktif_entity" => 1
        );
        $field = array(
            "id_submit_entity","entity_value"
        );
        $result = selectRow("tbl_entity",$where,$field);
        $result_array = $result->result_array();
        echo json_encode($result_array);
    }
}
?>