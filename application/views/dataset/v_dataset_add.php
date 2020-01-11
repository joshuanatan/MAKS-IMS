<div class="page-header">
    <h1 class="page-title">MASTER DATASET</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dataset</a></li>
        <li class="breadcrumb-item">Add</li>
    </ol>
</div>
<br/>
<?php if($this->session->status_dataset == "success"):?>
    <div class = "alert alert-success alert-dismissibile">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_dataset;?>
    </div>
<?php elseif($this->session->status_dataset == "error"):?>
    <div class = "alert alert-danger alert-dismissibile">
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
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#buildQuery" aria-controls="primaryData" role="tab">Detail Dataset</a></li>

                    </ul>
                    <form action = "<?php echo base_url();?>dataset/insert" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <div class = "form-group">
                                    <h5>Dataset Key</h5>
                                    <input type = "text" class = "form-control" value = "<?php echo set_value("dataset_key");?>" name = "dataset_key" required placeholder = "What is this dataset unique key?">
                                </div>
                                <div class = "form-group">
                                    <h5>Dataset Friendly Name</h5>
                                    <input type = "text" class = "form-control" value = "<?php echo set_value("dataset_name");?>" name = "dataset_name" required placeholder = "What is this dataset user-friendly name?">
                                </div>
                                <div class = "form-group">
                                    <h5>Database Connection</h5>
                                    <select required data-plugin = "select2" id = "id_db_connection" class = "form-control" name = "id_db_connection" onchange = "activate_mapping_container()">
                                        <option value = 0 selected disabled>Where should I execute this query? :) Choose one of them!</option>
                                        <?php for($a = 0; $a<count($database); $a++):?>
                                        <option value = "<?php echo $database[$a]["id_submit_db_connection"];?>"><?php echo $database[$a]["db_hostname"];?>/<?php echo $database[$a]["db_name"];?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane" id="buildQuery" role="tabpanel">
                                <div class = "form-group">
                                    <h5>Which user intention do you want to answer with this query?</h5>
                                    <select class = "form-control" name = "intent" data-plugin ="select2">
                                        <option value = "0">Not an answer, Just a supporting information</option>
                                        <?php for($a =0; $a<count($intent); $a++):?>
                                        <option value = "<?php echo $intent[$a]["id_submit_entity"];?>"><?php echo $intent[$a]["entity"];?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <h5>Any specific argument? Tell us! Otherwise, You can leave me blank if this query is a general information </h5>
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
                                <div class = "form-group">
                                    <h5>Dataset Query <br/>Let me know if there are needs to put argument inside my query! use prefix '<i>&</i>'+<i>entity_name</i>+'<i>sequence_number</i>'.</h5>
                                    <textarea required class = "form-control" rows = "10" name = "dataset_query" placeholder = "select * from table_database where kolom_database = &entity11 and kolom_database2 = &entity21 and kolom_database = &entity12"><?php echo set_value("dataset_query");?></textarea>
                                </div>
                                <hr/>
                                <div id = "dbfield_mapping_container" style = 'display:none'>
                                    <p>Table below is to help the system to get the selected fields and present the result by using its alias hence the result will be a lot user-friendly.<br/>Please kindly use "_" (underscore) if the alias has more than 1 word. The system will parse the "_" when presenting data. <br/>Ex: product_name [Will be presented as: Product Name]</p>
                                    <div class = "form-group">
                                        <h5>Input view/table Related to This Dataset</h5>
                                        <?php if(false):?>
                                        <button type = "button" class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#tableList" onclick = "loadViewList()">Choose Related Table / View</button>
                                        <?php endif;?>
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