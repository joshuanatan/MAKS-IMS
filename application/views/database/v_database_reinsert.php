<div class="page-header">
    <h1 class="page-title">MASTER DATABASE CONNECTION</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Database Connection</li>
    </ol>
</div>
<br/>
<div class = "alert alert-danger alert-dismissible">
    <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
    <?php echo validation_errors();?>
</div>
<div class="page-body">
    <form action = "<?php echo base_url();?>database/insert" method = "POST">
        <div class = "form-group">
            <h5>Database Hostname</h5>
            <input type = "text" class = "form-control" value = "<?php echo set_value("db_hostname");?>" name = "db_hostname">
        </div>
        <div class = "form-group">
            <h5>Database Name</h5>
            <input type = "text" class = "form-control" value = "<?php echo set_value("db_name");?>" name = "db_name">
        </div>
        <div class = "form-group">
            <h5>Database Username</h5>
            <input type = "text" class = "form-control" value = "<?php echo set_value("db_username");?>" name = "db_username">
        </div>
        <div class = "form-group">
            <h5>Database Password</h5>
            <input type = "password" class = "form-control" value = "<?php echo set_value("db_password");?>" name = "db_password">
        </div>
        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
        <a href = "<?php echo base_url();?>database" class = "btn btn-primary btn-sm">BACK</a>
    </form>
</div>
