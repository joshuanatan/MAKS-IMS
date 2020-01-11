<div class="page-header">
    <h1 class="page-title">INTENT & ENTITY REPOSITORY</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Intent & Entity</li>
    </ol>
</div>
<br/>
<?php if($this->session->status_intent_entity == "success"):?>
    <div class = "alert alert-success alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_intent_entity;?>
    </div>
<?php elseif($this->session->status_intent_entity == "error"):?>
    <div class = "alert alert-danger alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_intent_entity;?>
    </div>
<?php endif;?>
<div class="page-body col-lg-10 offset-lg-1 col-sm-12">
    <button type = "button" class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#newEntity">+ ADD NEW INTENT/ENTITY</button>
    <a href = "<?php echo base_url();?>intent_entity/recycle_bin" class = "btn btn-light btn-sm"><i class = "icon wb-trash"></i></a>
    <br/><br/>
    <form action = "<?php echo base_url();?>intent_entity/update_intent_entity_batch" method = "POST">
        <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable" style = "table-layout:fixed">
            <thead>
                <th style = "width:5%">#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Last Modified</th>
                <th style = "width:15%">Status Intent</th>
                <th style = "width:15%">Action</th>
            </thead>
            <tbody>
                <?php for($a = 0; $a<count($entity); $a++):?>
                <tr>
                    <td style = "overflow-wrap:break-word"><?php echo $a+1;?></td>
                    <td style = "overflow-wrap:break-word"><?php echo $entity[$a]["entity"];?></td>
                    <td style = "overflow-wrap:break-word"><?php echo $entity[$a]["entity_category"];?></td>
                    <td style = "overflow-wrap:break-word"><?php echo $entity[$a]["tgl_entity_last_modified"];?></td>
                    <td style = "overflow-wrap:break-word">
                        <?php if($entity[$a]["status_aktif_entity"] == 1):?>
                        <button type = "button" class = "btn btn-primary btn-sm col-lg-12">IN USE</button>
                        <?php else:?>
                        <button type = "button" class = "btn btn-danger btn-sm col-lg-12">NOT IN USE</button>
                        <?php endif;?>
                    </td>
                    <td style = "overflow-wrap:break-word">
                        <button type = "button" class = "btn btn-primary btn-sm col-lg-12" data-toggle = "modal" data-target = "#updateIntent<?php echo $a;?>">EDIT INTENT</button>
                        
                        <?php if($entity[$a]["status_aktif_entity"] == 1):?>
                        <a href = "<?php echo base_url();?>intent_entity/deactive/<?php echo $entity[$a]["id_submit_entity"];?>" class = "btn btn-danger btn-sm col-lg-12">DEACTIVE</a>
                        <?php else:?>
                        <a href = "<?php echo base_url();?>intent_entity/activate/<?php echo $entity[$a]["id_submit_entity"];?>" class = "btn btn-light btn-sm col-lg-12">ACTIVATE</a>
                        <?php endif;?>
                        <a href = "<?php echo base_url();?>intent_entity/delete/<?php echo $entity[$a]["id_submit_entity"];?>" class = "btn btn-dark btn-sm col-lg-12">DELETE</a>
                    </td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
    </form>
</div>
<div class = "modal fade" id = "newEntity">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>New Entity Registration</h4>
            </div>
            <div class = "modal-body" style = "max-height: calc(100vh - 210px);overflow-y: auto;">
                <form action = "<?php echo base_url();?>intent_entity/insert_entity" method = "POST">
                    <table class = "table table-stripped table-hover table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Category</th>
                        </thead>
                        <tbody>
                            <tr id = "addButtonContainer">
                                <td colspan = 3>
                                    <button type = "button" class = "btn btn-primary btn-sm col-lg-12" onclick = "addCategoryRow()">+ADD NEW ROW</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php for($a = 0; $a<count($entity); $a++):?>
<div class = "modal fade" id = "updateIntent<?php echo $a;?>">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Update Entity</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>intent_entity/update_intent_entity" method = "POST">
                    <input type = "hidden" name = "id_submit_entity" value = "<?php echo $entity[$a]["id_submit_entity"];?>">
                    <div class = "form-group">
                        <h5>Name</h5>
                        <input type = "text" class = "form-control" name = "entity" value = "<?php echo $entity[$a]["entity"];?>">
                    </div>
                    <div class = "form-group">
                        <h5>Category</h5>
                        <select class = "form-control" name = "entity_category">
                            <option value = "INTENT">INTENT</option>
                            <option value = "ENTITY" <?php if(strtoupper($entity[$a]["entity_category"]) == "ENTITY") echo "selected";?>>ENTITY</option>
                        </select>
                    </div>
                    <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endfor;?>