
CREATE VIEW v_entity_dataset_mapping  AS  
select id_submit_entity_combination,
id_entity,
entity,
entity_category,
tbl_entity_combination_list.id_entity_combination,
dataset_key,
dataset_name,
dataset_query,
id_db_connection,
status_aktif_entity_combination_list,
status_aktif_entity,
status_aktif_dataset,
status_aktif_entity_combination,
id_submit_entity_combination_list,
tgl_entity_combination_list_last_modified,
id_user_entity_combination_list_last_modified,
id_submit_entity,
tgl_entity_last_modified,
id_user_entity_last_modified,
tgl_entity_combination_last_modified,
id_user_entity_combination_last_modified,
id_submit_dataset,
tgl_dataset_last_modified,
id_user_dataset_last_modified from tbl_dataset join tbl_entity_combination on tbl_entity_combination.id_submit_entity_combination = tbl_dataset.id_entity_combination  left join tbl_entity_combination_list on tbl_entity_combination_list.id_entity_combination = tbl_entity_combination.id_submit_entity_combination left join tbl_entity on tbl_entity.id_submit_entity = tbl_entity_combination_list.id_entity;

drop view v_endpoint_intent_dataset_mapping;
CREATE  VIEW `v_endpoint_intent_dataset_mapping`  AS  
select 
id_submit_entity_combination,
id_submit_dataset,
group_concat(
    entity order by entity ASC separator ','
) AS entity,
group_concat(
    entity_category order by entity ASC separator ','
) AS entity_category,
dataset_key,
dataset_name,
dataset_query,
id_db_connection,
db_hostname,
status_aktif_dataset,
tgl_dataset_last_modified,
db_name
from (
    v_entity_dataset_mapping join tbl_db_connection on tbl_db_connection.id_submit_db_connection = v_entity_dataset_mapping.id_db_connection
) 
group by id_submit_entity_combination ;


CREATE VIEW v_detail_entity_mapping  AS  
select id_submit_entity_combination_list AS id_submit_entity_combination_list,
id_entity AS id_entity,
id_entity_combination AS id_entity_combination,
tgl_entity_combination_list_last_modified AS tgl_entity_combination_list_last_modified,
id_submit_entity AS id_submit_entity,
entity AS entity,
entity_category AS entity_category 
from (tbl_entity_combination_list 
join tbl_entity on((tbl_entity.id_submit_entity = tbl_entity_combination_list.id_entity))) 
where ((tbl_entity.status_aktif_entity = 1) and (tbl_entity_combination_list.status_aktif_entity_combination_list = 1)) ;

CREATE VIEW v_detail_dataset  AS  
select id_submit_dataset,
dataset_name,
dataset_query,
id_db_connection,
status_aktif_dataset,
tgl_dataset_last_modified,
id_user_dataset_last_modified,
id_submit_db_connection,
db_hostname,
db_username,
db_password,
db_name,
status_aktif_db_connection,
tgl_db_connection_last_modified,
id_user_db_connection_last_modified
from
 (tbl_dataset join tbl_db_connection on((tbl_db_connection.id_submit_db_connection = tbl_dataset.id_db_connection))) ;
 
CREATE  VIEW v_related_dataset  AS  
select 
id_submit_dataset_related,
id_dataset,
id_dataset_related,
id_submit_dataset,
dataset_key,
dataset_name,
dataset_query,
id_entity_combination,
id_db_connection,
status_aktif_dataset_related,
tgl_dataset_related_last_modified,
id_user_dataset_related_last_modified,
status_aktif_dataset,
tgl_dataset_last_modified,
id_user_dataset_last_modified
from (tbl_dataset_related join tbl_dataset on((tbl_dataset.id_submit_dataset = tbl_dataset_related.id_dataset_related))) ;
