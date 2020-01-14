<?php
class Wsdl extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $where = array(
            "status_aktif_endpoint" => 1
        );
        $field = array(
            "endpoint_name"
        );
        $result = selectRow("endpoint_documentation",$where,$field);
        $data["endpoint"] = $result->result_array();
        $this->page_generator->req();
        $this->page_generator->head_close();
        $this->page_generator->content_open();
        $this->load->view("ws/wsdl_index",$data);
        $this->page_generator->close();
    }
    public function get_dataset(){
        $where = array(
            "status_aktif_endpoint" => 1,
            "endpoint_name" => "get_dataset"
        );
        $field = array(
            "endpoint_name","endpoint_http_method","endpoint_uri","endpoint_input","endpoint_output"
        );
        $result = selectRow("endpoint_documentation",$where,$field)->row();
        $array = array(
            "endpoint_name" => $result->endpoint_name,
            "endpoint_method" => $result->endpoint_http_method,
            "endpoint_uri" => $result->endpoint_uri,
            "endpoint_input" => $result->endpoint_input,
            "endpoint_output" => $result->endpoint_output,
            "request" => array(
                "header" => array(
                    "client_token" => "client_token_here"
                ),
                "body" => array(
                    "text_entity_list" => json_encode(array(
                        "intent" => "Request Intent",
                        "entity" => array(
                            "entity1" => array(
                                "value1","value2"
                            ),
                            "entity2" => array(
                                "value1"
                            )
                        )
                    )),
                    "text_entity_list_decoded" => array(
                        "intent" => "Request Intent",
                        "entity" => array(
                            "entity1" => array(
                                "value1","value2"
                            ),
                            "entity2" => array(
                                "value1"
                            )
                        )
                    ),
                )
            ),
            "response" => array(
                "status" => "success",
                "msg" => "Elements value found",
                "dataset_result" => array(
                    array(
                        "dataset_name" => "dataset_name1",
                        "dataset_desc" => "Dataset 1",
                        "value" => array(
                            "header" => array("Information About"),
                            "content" => array("15")
                        )
                    ),
                    array(
                        "dataset_name" => "dataset_name2",
                        "dataset_desc" => "Dataset 2",
                        "value" => array(
                            "header" => array("kolom1","kolom2","kolom3","kolom4","kolom5"),
                            "content" => array(
                                array("baris_1_kolom_1","baris_1_kolom_2","baris_1_kolom_3","baris_1_kolom_4","baris_1_kolom_5"), //baris1
                                array("baris_2_kolom_1","baris_2_kolom_2","baris_2_kolom_3","baris_2_kolom_4","baris_2_kolom_5"), //baris2
                                array("baris_3_kolom_1","baris_3_kolom_2","baris_3_kolom_3","baris_3_kolom_4","baris_3_kolom_5"), //baris3
                            )
                        )
                    ),
                    array(
                        "dataset_name" => "dataset_name3",
                        "dataset_desc" => "Dataset 3",
                        "value" => array(
                            "header" => array("key1","key2","key3","key4"),
                            "content" => array("100","1200","1300","400")
                        )
                    )
                )
            ),
            "response_error" => array(
                "error" => "true",
                "status" => "errors",
                "msg" => "Elements value found",
                "dataset_result" => "-"
            )

        );
        header("Content-type:application/json");
        echo json_encode($array);
    }
    public function get_dataset_repository(){
        $where = array(
            "status_aktif_endpoint" => 1,
            "endpoint_name" => "get_dataset_repository"
        );
        $field = array(
            "endpoint_name","endpoint_http_method","endpoint_uri","endpoint_input","endpoint_output"
        );
        $result = selectRow("endpoint_documentation",$where,$field)->row();
        $array = array(
            "endpoint_name" => $result->endpoint_name,
            "endpoint_method" => $result->endpoint_http_method,
            "endpoint_uri" => $result->endpoint_uri,
            "endpoint_input" => $result->endpoint_input,
            "endpoint_output" => $result->endpoint_output,
            "request" => array(
                "header" => array(
                    "client_token" => "client_token_here"
                ),
            ),
            "response" => array(
                "status" => "success",
                "msg" => "Dataset Repository is Found",
                "result" => array(
                    array(
                        "id_submit_dataset" => 1,
                        "dataset_key" => "datasetKey",
                        "dataset_name" => "Dataset Name"
                    )
                )
            ),
            "response_error" => array(
                "error" => "true",
                "status" => "error",
                "msg" => "Elements value found",
                "result" => "-"
            )

        );
        header("Content-type:application/json");
        echo json_encode($array);
    }
    
}
?>