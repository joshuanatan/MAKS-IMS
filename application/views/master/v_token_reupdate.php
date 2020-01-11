<div class="page-header">
    <h1 class="page-title">MASTER TOKEN</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Token</a></li>
        <li class="breadcrumb-item active">Reupdate</li>
    </ol>
</div>
<br/>
<div class = "alert alert-danger alert-dismissible">
    <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
    <?php echo validation_errors();?>
</div>
<div class="page-body">
    <form action = "<?php echo base_url();?>token/update" method = "POST">
        <input type = "hidden" name = "id_submit_token" value = "<?php echo set_value("id_submit_token");?>">
        <div class = "form-group">
            <h5>Nama Client</h5>
            <input type = "text" class = "form-control" value = "<?php echo set_value("nama_client");?>" name = "nama_client">
        </div>
        <div class = "form-group">
            <h5>Token</h5>
            <input readonly type = "text" class = "form-control" value = "<?php echo set_value("token");?>" name = "token">
        </div>
        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
    </form>
</div>