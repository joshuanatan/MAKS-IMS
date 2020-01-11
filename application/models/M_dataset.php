<?php
class M_dataset extends CI_Model{
    public function get_list_dataset($where,$field){
        $this->db->select($field);
        $this->db->Where($where);
        $this->db->group_by("id_submit_dataset");
        return $this->db->get("v_master_dataset");
    }
    public function get_dataset_info_category($where,$field){
        $this->db->select($field);
        $this->db->Where($where);
        $this->db->group_by("id_submit_dataset_info_category");
        return $this->db->get("v_master_dataset");
    }
}
?>