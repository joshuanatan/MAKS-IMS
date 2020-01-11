<div class="page-header">
    <h1 class="page-title">MASTER USER</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">User</a></li>
        <li class="breadcrumb-item active">Reupdate</li>
    </ol>
</div>
<br/>
<div class = "alert alert-danger alert-dismissible">
    <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
    <?php echo validation_errors();?>
</div>
<div class="page-body">
    <form action = "<?php echo base_url();?>user/update" method = "POST">
        <input type = "hidden" name = "id_submit_user" value = "<?php echo set_value("id_submit_user");?>">
        <div class = "form-group">
            <h5>Nama User</h5>
            <input type = "text" class = "form-control" value = "<?php echo set_value("nama_user");?>" name = "nama_user">
        </div>
        <div class = "form-group">
            <h5>Email User</h5>
            <input type = "text" class = "form-control" value = "<?php echo set_value("email_user");?>" name = "email_user">
        </div>
        <div class = "form-group">
            <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
        </div>
    </form>
</div>
