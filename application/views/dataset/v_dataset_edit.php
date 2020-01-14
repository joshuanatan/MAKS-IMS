<div class="page-header">
    <h1 class="page-title">MASTER DATASET</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dataset</a></li>
        <li class="breadcrumb-item">Edit</li>
    </ol>
</div>
<br/>
<?php if($this->session->status_dataset == "success"):?>
    <div class = "alert alert-success alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_dataset;?>
    </div>
<?php elseif($this->session->status_dataset == "error"):?>
    <div class = "alert alert-danger alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_dataset;?>
    </div>
<?php endif;?>
<div class="page-body col-lg-12">
    <div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Entity Mapping</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#buildQuery" aria-controls="primaryData" role="tab">Manage Dataset Info</a></li>

                    </ul>
                    <form action = "<?php echo base_url();?>dataset/update" method = "post" enctype = "multipart/form-data">    
                        <input type = "hidden" name = "id_submit_dataset" value = "<?php echo $main[0]["id_submit_dataset"];?>">
                        <input type = "hidden" name = "id_submit_entity_combination" value = "<?php echo $main[0]["id_entity_combination"];?>">
                        <div class="tab-content">
                            
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                
                            <button type = "button" class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#changeEntity">CHANGE INTENT & ENTITY COMBINATION</button>
                                <br/><br/>
                                <div class = "modal fade" id = "changeEntity">
                                    <div class = "modal-dialog modal-center modal-lg">
                                        <div class = "modal-content">
                                            <div class = "modal-header">
                                                <h4 class = "modal-title">CHANGE INTENT & ENTITY</h4>
                                            </div>
                                            <div class = "modal-body" style = 'max-height: calc(100vh - 210px);overflow-y: auto;'>
                                                <div class = "form-group">
                                                    <h5>What user's intention does this dataset provide?</h5>
                                                    <select class = "form-control" name = "intent" data-plugin ="select2">
                                                        <?php for($a =0; $a<count($intent); $a++):?>
                                                        <option value = "<?php echo $intent[$a]["id_submit_entity"];?>"<?php if(count($registered_intent)>0){if($registered_intent[0]["id_submit_entity"] == $intent[$a]["id_submit_entity"]) echo "selected";}?>><?php echo $intent[$a]["entity"];?></option>
                                                        <?php endfor;?>
                                                    </select>
                                                </div>
                                                <h5>New <i>Entity / Attributes</i></h5>
                                                <table class = "table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <th style = "width:10%">#</th>
                                                        <th>Entity</th>
                                                    </thead>
                                                    <tbody id = "entity_list">
                                                        <tr id="entity_button_container">
                                                            <td colspan =3><button type = "button" class="btn btn-primary btn-sm col-lg-12" onclick = "new_entity_row()">ADD NEW ENTITY</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5>Registered Entity</h5>
                                <table class = "table table-bordered table-hover table-stripped">
                                    <thead>
                                        <th>Delete</th>
                                        <th>Entity</th>
                                        <th>Category</th>
                                    </thead>
                                    <tbody>
                                        <?php for($a = 0; $a<count($registered_entity); $a++):?>
                                        <tr>
                                            <td>
                                                <div class = "checkbox-custom checkbox-primary">
                                                    <input type = "checkbox" name = "delete_registered_entity_check[]" value = "<?php echo $registered_entity[$a]["id_submit_entity_combination_list"];?>"> 
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td><?php echo $registered_entity[$a]["entity"];?></td>
                                            <td><?php echo $registered_entity[$a]["entity_category"];?></td>
                                        </tr>
                                        <?php endfor;?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="buildQuery" role="tabpanel">
                                <div class = "form-group">
                                    <h5>Dataset Key</h5>
                                    <input type = "text" class = "form-control" value = "<?php echo $main[0]["dataset_key"];?>" name = "dataset_key" required>
                                </div>
                                <div class = "form-group">
                                    <h5>Dataset Friendly Name</h5>
                                    <input type = "text" class = "form-control" value = "<?php echo $main[0]["dataset_name"];?>" name = "dataset_name" required>
                                </div>
                                <div class = "form-group">
                                    <h5>Dataset Query <i>use prefix '&' to replace value with user request. Ex: tahun_produk = &tahunProduk1, Request: tahunProduk = ['2019'], result: tahun_produk = 2019</i></h5>
                                    <textarea required class = "form-control" rows = "10" name = "dataset_query" placeholder = "select * from table_database where kolom_database = &entity11 and kolom_database2 = &entity21 and kolom_database = &entity12"><?php echo $main[0]['dataset_query'];?></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5>Database Connection</h5>
                                    <select onchange = "activate_mapping_container()" id = "id_db_connection" class = "form-control" name = "id_db_connection">
                                        <option selected disabled>Choose Database Connection</option>
                                        <?php for($a = 0; $a<count($database); $a++):?>
                                        <option <?php if($database[$a]["id_submit_db_connection"] == $main[0]["id_db_connection"]) echo "selected"; ?> value = "<?php echo $database[$a]["id_submit_db_connection"];?>"><?php echo $database[$a]["db_hostname"];?>/<?php echo $database[$a]["db_name"];?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <h5>Registered Database Field</h5>
                                <table class = "table table-stripped table-bordered table-hover" style = "width:100%">
                                    <thead>
                                        <td style = "width:5%">Edit</td>
                                        <td style = "width:5%">Remove</td>
                                        <td style = "width:30%">Database Field</td>
                                        <td style = "width:30%">Field Origin</td>
                                        <td style = "width:30%">Field Alias</td>
                                    </thead>
                                    <?php //ambil yang entity dalam kategori informasi tersebut ?>
                                    <tbody id = "tableRegisteredEntity">
                                        <?php for($a = 0; $a<count($dbfield); $a++):?>
                                        <tr>
                                            <td>
                                                <div class = "checkbox-custom checkbox-primary">
                                                    <input type = "checkbox" name = "db_field_edit[]" value = "<?php echo $dbfield[$a]["id_submit_dataset_dbfield_mapping"];?>">
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class = "checkbox-custom checkbox-primary">
                                                    <input type = "checkbox" name = "db_field_remove[]" value = "<?php echo $dbfield[$a]["id_submit_dataset_dbfield_mapping"];?>">
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td>
                                                <input type = 'text' class = 'form-control' value = '<?php echo $dbfield[$a]["db_field"];?>' name = 'db_field<?php echo $dbfield[$a]["id_submit_dataset_dbfield_mapping"];?>'></td>
                                            <td>
                                                <input type = 'text' class = 'form-control' value = '<?php echo $dbfield[$a]["tbl_name"];?>' name = 'tbl_name<?php echo $dbfield[$a]["id_submit_dataset_dbfield_mapping"];?>'></td>
                                            <td>
                                                <input type = "text" value = "<?php echo $dbfield[$a]["db_field_alias"];?>" class = "form-control" name = "db_field_alias<?php echo $dbfield[$a]["id_submit_dataset_dbfield_mapping"];?>">
                                            </td>
                                        </tr>
                                        <?php endfor;?>
                                    </tbody>
                                </table>
                                <div class = "form-group">
                                    <h5>New Database Field</h5>
                                </div>
                                <table class = "table table-stripped table-bordered table-hover" style = "width:100%">
                                    <thead>
                                        <td style = "width:5%">#</td>
                                        <td style = "width:30%">Database Field</td>
                                        <td style = "width:30%">Field Origin</td>
                                        <td style = "width:30%">Field Alias</td>
                                    </thead>
                                    <?php //ambil yang entity dalam kategori informasi tersebut ?>
                                    <tbody id = "tableEntity">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr id = "buttonContainer">
                                            <td colspan = 4><button type = "button" class = "col-lg-12 btn btn-primary btn-sm" onclick = "addCustomField()">+ Add Custom Field</button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class = "form-group">
                <a href = "<?php echo base_url();?>dataset" class = "btn btn-outline btn-primary btn-sm">BACK</a>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>

<div class = "modal fade" id = "tableList">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Related Table / View</h4>
            </div>
            <div class = "modal-body" style = 'max-height: calc(100vh - 210px);overflow-y: auto;'>
                <table class = "table table-striped table-hover table-bordered" style = 'width:100%'>
                    <thead>
                        <th>#</th>
                        <th>Table / View</th>
                        <th>Action</th>
                    </thead>
                    <tbody id = "tableListContainer">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>