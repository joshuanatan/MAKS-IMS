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
    <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable">
        <thead>
            <th style = "width:5%">#</th>
            <th>Database Name/Hostname</th>
            <th>Dataset Name</th>
            <th>Dataset Query</th>
            <th style = "width:15%">Last Modified</th>
            <th style = "width:15%">Action</th>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($dataset); $a++):?>
            <tr>
                <td><?php echo ($a+1);?></td>
                <td><?php echo $dataset[$a]["db_name"];?>/<?php echo $dataset[$a]["db_hostname"];?></td>
                <td><?php echo $dataset[$a]["dataset_name"];?></td>
                <td><?php echo $dataset[$a]["dataset_query"];?></td>
                <td><?php echo $dataset[$a]["tgl_dataset_last_modified"];?></td>
                <td>
                    <a href = "<?php echo base_url();?>dataset/activate/<?php echo $dataset[$a]["id_submit_dataset"];?>" class = "btn btn-primary btn-sm col-lg-12">ACTIVATE</a>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
    <a href = "<?php echo base_url();?>dataset" class = "btn btn-primary btn-sm">BACK</a>
</div>