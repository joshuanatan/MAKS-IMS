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
<div class="page-body col-lg-10 offset-lg-1">
    <form action = "<?php echo base_url();?>intent_entity/update_intent_entity_batch" method = "POST">
        <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable">
            <thead>
                <th style = "width:5%">#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Last Modified</th>
                <th style = "width:15%">Action</th>
            </thead>
            <tbody>
                <?php for($a = 0; $a<count($entity); $a++):?>
                <tr>
                    <td><?php echo $a+1;?></td>
                    <td><?php echo $entity[$a]["entity"];?></td>
                    <td><?php echo $entity[$a]["entity_category"];?></td>
                    <td><?php echo $entity[$a]["tgl_entity_last_modified"];?></td>
                    <td>
                        <a href = "<?php echo base_url();?>intent_entity/activate/<?php echo $entity[$a]["id_submit_entity"];?>" class = "btn btn-primary btn-sm col-lg-12">ACTIVATE</a>
                    </td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
        <a href = "<?php echo base_url();?>intent_entity" class = "btn btn-primary btn-sm">BACK</a>
    </form>
</div>