
drop table if exists tbl_dataset;
CREATE TABLE `tbl_dataset` (
  `id_submit_dataset` int(11) NOT NULL primary key auto_increment,
  `dataset_key` varchar(50) DEFAULT NULL,
  `dataset_name` varchar(200) DEFAULT NULL,
  `dataset_query` text,
  `entity_combination_notes` varchar(400) DEFAULT NULL,
  `id_entity_combination` int(11) DEFAULT NULL,
  `id_db_connection` int(11) DEFAULT NULL,
  `status_aktif_dataset` varchar(1) DEFAULT NULL,
  `tgl_dataset_last_modified` datetime DEFAULT NULL,
  `id_user_dataset_last_modified` int(11) DEFAULT NULL
); 
drop table if exists tbl_dataset_dbfield_mapping;
CREATE TABLE `tbl_dataset_dbfield_mapping` (
  `id_submit_dataset_dbfield_mapping` int(11) NOT NULL primary key auto_increment,
  `id_dataset` int(11) DEFAULT NULL,
  `db_field` varchar(400) DEFAULT NULL,
  `db_field_alias` varchar(100) DEFAULT NULL,
  `tbl_name` varchar(400) DEFAULT NULL,
  `status_aktif_dataset_dbfield_mapping` varchar(1) DEFAULT NULL,
  `tgl_dataset_dbfield_mapping_last_modified` datetime DEFAULT NULL,
  `id_user_dataset_dbfield_mapping_last_modified` int(11) DEFAULT NULL
);
drop table if exists tbl_dataset_related;
CREATE TABLE `tbl_dataset_related` (
  `id_submit_dataset_related` int(11) NOT NULL primary key auto_increment,
  `id_dataset` int(11) DEFAULT NULL,
  `id_dataset_related` int(11) DEFAULT NULL,
  `status_aktif_dataset_related` varchar(1) DEFAULT NULL,
  `tgl_dataset_related_last_modified` datetime DEFAULT NULL,
  `id_user_dataset_related_last_modified` int(11) DEFAULT NULL
);
drop table if exists tbl_db_connection;
CREATE TABLE `tbl_db_connection` (
  `id_submit_db_connection` int(11) NOT NULL primary key auto_increment,
  `db_hostname` varchar(400) DEFAULT NULL,
  `db_username` varchar(400) DEFAULT NULL,
  `db_password` varchar(1000) DEFAULT NULL,
  `db_name` varchar(100) DEFAULT NULL,
  `status_aktif_db_connection` varchar(1) DEFAULT NULL,
  `tgl_db_connection_last_modified` datetime DEFAULT NULL,
  `id_user_db_connection_last_modified` int(11) DEFAULT NULL
);
drop table if exists tbl_entity;
CREATE TABLE `tbl_entity` (
  `id_submit_entity` int(11) NOT NULL primary key auto_increment,
  `entity` varchar(400) DEFAULT NULL,
  `entity_category` varchar(100) DEFAULT NULL COMMENT 'INTENT/ENTITY',
  `status_aktif_entity` varchar(1) DEFAULT NULL,
  `tgl_entity_last_modified` datetime DEFAULT NULL,
  `id_user_entity_last_modified` int(11) DEFAULT NULL
);
drop table if exists tbl_entity_combination;
CREATE TABLE `tbl_entity_combination` (
  `id_submit_entity_combination` int(11) NOT NULL primary key auto_increment,
  `status_aktif_entity_combination` varchar(1) DEFAULT NULL,
  `tgl_entity_combination_last_modified` datetime DEFAULT NULL,
  `id_user_entity_combination_last_modified` int(11) DEFAULT NULL
);
drop table if exists tbl_entity_combination_list;
CREATE TABLE `tbl_entity_combination_list` (
  `id_submit_entity_combination_list` int(11) NOT NULL primary key auto_increment,
  `id_entity` int(11) DEFAULT NULL,
  `id_entity_combination` int(11) DEFAULT NULL,
  `status_aktif_entity_combination_list` varchar(1) DEFAULT NULL,
  `tgl_entity_combination_list_last_modified` datetime DEFAULT NULL,
  `id_user_entity_combination_list_last_modified` int(11) DEFAULT NULL
);
drop table if exists tbl_token;
CREATE TABLE `tbl_token` (
  `id_submit_token` int(11) NOT NULL primary key auto_increment,
  `token` varchar(255) DEFAULT NULL,
  `nama_client` varchar(300) DEFAULT NULL,
  `status_aktif_token` varchar(1) DEFAULT NULL,
  `tgl_token_last_modified` datetime DEFAULT NULL,
  `id_user_token_last_modified` int(11) DEFAULT NULL
);
drop table if exists tbl_user;
CREATE TABLE `tbl_user` (
  `id_submit_user` int(11) NOT NULL primary key auto_increment,
  `nama_user` varchar(200) DEFAULT NULL,
  `password_user` varchar(300) DEFAULT NULL,
  `email_user` varchar(200) DEFAULT NULL,
  `status_aktif_user` varchar(1) DEFAULT NULL,
  `tgl_user_last_modified` datetime DEFAULT NULL,
  `id_user_user_last_modified` int(11) DEFAULT NULL
);
INSERT INTO `tbl_user` (`id_submit_user`, `nama_user`, `password_user`, `email_user`, `status_aktif_user`, `tgl_user_last_modified`, `id_user_user_last_modified`) VALUES
(1, 'Joshua Natan', 'e10adc3949ba59abbe56e057f20f883e', 'joshuanatan.jn@gmail.com', '1', now(), 0)