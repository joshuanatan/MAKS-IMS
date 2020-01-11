<div class="page-header">
    <h1 class="page-title">MASTER DATABASE CONNECTION</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Database Connection</li>
    </ol>
</div>
<br/>
<?php if($this->session->status_db == "success"):?>
    <div class = "alert alert-success alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_db;?>
    </div>
<?php elseif($this->session->status_db == "error"):?>
    <div class = "alert alert-danger alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_db;?>
    </div>
<?php endif;?>
<div class="page-body col-lg-10 offset-lg-1">
    <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable">
        <thead>
            <th style = "width:5%">#</th>
            <th>Database Name</th>
            <th>Database Hostname</th>
            <th>Database User</th>
            <th>Last Modified</th>
            <th style = "width:15%">Action</th>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($database); $a++):?>
            <tr>
                <td><?php echo $a+1;?></td>
                <td><?php echo $database[$a]["db_name"];?></td>
                <td><?php echo $database[$a]["db_hostname"];?></td>
                <td><?php echo $database[$a]["db_username"];?></td>
                <td><?php echo $database[$a]["tgl_db_connection_last_modified"];?></td>
                <td>
                    <a href = "<?php echo base_url();?>database/activate/<?php echo $database[$a]["id_submit_db_connection"];?>" class = "btn btn-primary btn-sm col-lg-12">ACTIVATE</a>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
    <a href = "<?php echo base_url();?>database" class = "btn btn-primary btn-sm">BACK</a>
</div>
