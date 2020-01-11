<div class="page-header">
    <h1 class="page-title">MASTER TOKEN</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Token</li>
    </ol>
</div>
<br/>
<?php if($this->session->status == "success"):?>
<div class = "alert alert-success alert-dismissible">
    <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
    <?php echo $this->session->msg;?>
</div>
<?php elseif($this->session->status == "error"):?>
<div class = "alert alert-danger alert-dismissible">
    <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
    <?php echo $this->session->msg;?>
</div>
<?php endif;?>
<div class="page-body col-lg-10 offset-lg-1">
    <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable">
        <thead>
            <th style = "width:5%">#</th>
            <th>Nama Client</th>
            <th>Token</th>
            <th>Last Modified</th>
            <th style = "width:15%">Action</th>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($token); $a++):?>
            <tr>
                <td><?php echo $a+1;?></td>
                <td><?php echo $token[$a]["nama_client"];?></td>
                <td><?php echo $token[$a]["token"];?></td>
                <td><?php echo $token[$a]["tgl_token_last_modified"];?></td>
                <td>
                    <a href = "<?php echo base_url();?>token/activate/<?php echo $token[$a]["id_submit_token"];?>" class = "btn btn-primary btn-sm col-lg-12">ACTIVATE TOKEN</a>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
    <a href = "<?php echo base_url();?>token" class = "btn btn-primary btn-sm">BACK</a>
</div>