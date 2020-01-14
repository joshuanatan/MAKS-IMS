<?php
class Dataset extends CI_Controller{
    public function get_dataset_query(){
        $where = array(
            "id_submit_dataset" => $this->input->post("id_submit_dataset")
        );
        $field = array(
            "dataset_query"
        );
        $result = selectRow("tbl_dataset",$where,$field);
        $data = $result->result_array();
        echo json_encode($data);
    }
    public function get_dataset_dbfield(){
        $where = array(
            "id_dataset" => $this->input->post("id_dataset"),
            "status_aktif_dataset_dbfield_mapping" => 1 
        );
        $field = array(
            "id_submit_dataset_dbfield_mapping","db_field",
        );  
        $result = selectRow("tbl_dataset_dbfield_mapping",$where,$field);
        $data = $result->result_array();
        echo json_encode($data);
    }
    public function get_dataset_list(){
        $where = array(
            "status_aktif_dataset" => 1
        );
        $field = array(
            "id_submit_dataset","dataset_name"
        );
        $result = selectRow("tbl_dataset",$where,$field);
        $data = $result->result_array();
        echo json_encode($data);
    }
    public function get_detail_dataset(){
        $id_entity_combination = $this->input->post("id_entity_combination");
        $where = array(
            "id_entity_combination" => $id_entity_combination
        );
        $where += ["status_aktif_entity" => 1];
        $field = array(
            "entity","entity_category"
        );
        $result["entity_list"] = selectRow("v_entity_dataset_mapping",$where,$field)->result_array();

        $field = array(
            "dataset_query","id_submit_dataset"
        );
        $result["query"] = selectRow("v_entity_dataset_mapping",$where,$field,"","","","","id_submit_dataset")->result_array();
        echo json_encode($result);
        
    }
}
?>