<div class="page-header">
    <h1 class="page-title">MASTER DATASET</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Dataset</li>
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
<div class="page-body">
    <a href = "<?php echo base_url();?>dataset/add" class = "btn btn-primary btn-sm">+ ADD DATASET</a>
    <a href = "<?php echo base_url();?>dataset/recycle_bin" class = "btn btn-light btn-sm"><i class = "icon wb-trash"></i></a>
    <button type = "button" data-toggle = "modal" data-target = "#try_dataset" class = "btn btn-primary btn-sm">TRY <i>get_dataset</i> REQUEST</button>
    <br/><br/>
    <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable" style = "table-layout:fixed">
        <thead>
            <th style = "width:5%">#</th>
            <th>Database Name/Hostname</th>
            <th>Dataset Name</th>
            <th>Dataset Query</th>
            <th>Dataset Notes</th>
            <th>Last Modified</th>
            <th style = "width:15%">Status Dataset</th>
            <th style = "width:15%">Action</th>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($dataset); $a++):?>
            <tr>
                <td style = "overflow-wrap:break-word"><?php echo ($a+1);?></td>
                <td style = "overflow-wrap:break-word"><?php echo $dataset[$a]["db_name"];?>/<?php echo $dataset[$a]["db_hostname"];?></td>
                <td style = "overflow-wrap:break-word"><?php echo $dataset[$a]["dataset_key"]."/".$dataset[$a]["dataset_name"];?></td>
                <td style = "overflow-wrap:break-word"><?php echo $dataset[$a]["dataset_query"];?></td>
                <td style = "overflow-wrap:break-word"><?php echo str_replace(",","<br/>",$dataset[$a]["entity"]);?></td>
                <td style = "overflow-wrap:break-word"><?php echo $dataset[$a]["tgl_dataset_last_modified"];?></td>
                <td style = "overflow-wrap:break-word">
                    <?php if($dataset[$a]["status_aktif_dataset"] == 0):?>
                    <button class = "btn btn-danger btn-sm col-lg-12">NOT ACTIVE</button>
                    <?php else:?>
                    <button class = "btn btn-primary btn-sm col-lg-12">ACTIVE</button>
                    <?php endif;?>
                </td>
                <td style = "overflow-wrap:break-word">
                    <?php if($dataset[$a]["status_aktif_dataset"] == 1):?>
                    <a href = "<?php echo base_url();?>dataset/deactive/<?php echo $dataset[$a]["id_submit_dataset"];?>" class = "btn btn-danger btn-sm col-lg-12">DEACTIVE</a>
                    <?php else:?>
                    <a href = "<?php echo base_url();?>dataset/activate/<?php echo $dataset[$a]["id_submit_dataset"];?>" class = "btn btn-light btn-sm col-lg-12">ACTIVATE</a>
                    <?php endif;?>
                    <a href = "<?php echo base_url();?>dataset/delete/<?php echo $dataset[$a]["id_submit_dataset"];?>" class = "btn btn-dark btn-sm col-lg-12">DELETE</a>
                    <a class = "btn btn-primary btn-sm col-lg-12" href = "<?php echo base_url();?>dataset/edit/<?php echo $dataset[$a]["id_submit_dataset"];?>">EDIT DATASET</a>
                    <a class = "btn btn-light btn-sm col-lg-12" href = "<?php echo base_url();?>dataset/related/<?php echo $dataset[$a]["id_submit_dataset"];?>">RELATED DATASET</a>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
<div class = "modal fade" id = "try_dataset">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">TRY get_dataset REQUEST</h4>
            </div>
            <div class = "modal-body" style = "max-height: calc(100vh - 210px);overflow-y: auto;">
                <form action = "<?php echo base_url();?>dataset/trial" method = "post" target = "_blank">
                    <div class = "form-group">
                        <h5>Intent</h5>
                        <input type = "text" class = "form-control" name = "intent">
                    </div>
                    <table class = "table table-bordered table-hover table-striped">
                        <thead>
                            <th>#</th>
                            <th>Entity</th>
                            <th>Values (Comma Separated)</th>
                        </thead>
                        <tbody>
                            <?php for($a = 0; $a<10; $a++):?>
                            <tr>
                                <td>
                                    <div class = "checkbox-custom checkbox-primary">
                                        <input type = "checkbox" name = "check[]" value = "<?php echo $a;?>">
                                        <label></label>
                                    </div>
                                </td>
                                <td>
                                    <input type = "text" class = "form-control" name = "entity<?php echo $a;?>">
                                </td>
                                <td>
                                    <textarea class = "form-control" name = "value<?php echo $a;?>"></textarea>
                                </td>
                            </tr>
                            <?php endfor;?>
                        </tbody>
                    </table>
                    <button type = "submit" class = "btn btn-primary btn-sm">Make Request</button>
                </form>
            </div>
        </div>
    </div>
</div>