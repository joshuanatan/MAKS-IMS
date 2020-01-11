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
<div class="page-body">
    <div class = "col-lg-10 offset-lg-1">
        <button type = "button" class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#tambahDatabase">+ ADD DATABASE CONNECTION</button>
        <a href = "<?php echo base_url();?>database/recycle_bin" class = "btn btn-light btn-sm"><i class = "icon wb-trash"></i></a>
        <br/><br/>
        <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable" style = "table-layout:fixed">
            <thead>
                <th style = "width:5%">#</th>
                <th>Database Name</th>
                <th>Database Hostname</th>
                <th>Database User</th>
                <th>Last Modified</th>
                <th style = "width:15%">Status Connection</th>
                <th style = "width:15%">Action</th>
            </thead>
            <tbody>
                <?php for($a = 0; $a<count($database); $a++):?>
                <tr>
                    <td style = "overflow-wrap:break-word"><?php echo $a+1;?></td>
                    <td style = "overflow-wrap:break-word"><?php echo $database[$a]["db_name"];?></td>
                    <td style = "overflow-wrap:break-word"><?php echo $database[$a]["db_hostname"];?></td>
                    <td style = "overflow-wrap:break-word"><?php echo $database[$a]["db_username"];?></td>
                    <td style = "overflow-wrap:break-word"><?php echo $database[$a]["tgl_db_connection_last_modified"];?></td>
                    <td style = "overflow-wrap:break-word">
                        <?php if($database[$a]["status_aktif_db_connection"] == 1):?>
                        <button type = "button" class = "btn btn-primary btn-sm col-lg-12">IN USE</button>
                        <?php else:?>
                        <button type = "button" class = "btn btn-danger btn-sm col-lg-12">NOT IN USE</button>
                        <?php endif;?>
                    </td>
                    <td style = "overflow-wrap:break-word">
                        <?php if($database[$a]["status_aktif_db_connection"] == 1):?>
                        <a href = "<?php echo base_url();?>database/deactive/<?php echo $database[$a]["id_submit_db_connection"];?>" class = "btn btn-danger btn-sm col-lg-12">DEACTIVE</a>
                        <?php else:?>
                        <a href = "<?php echo base_url();?>database/activate/<?php echo $database[$a]["id_submit_db_connection"];?>" class = "btn btn-light btn-sm col-lg-12">ACTIVATE</a>
                        <?php endif;?>
                        <a href = "<?php echo base_url();?>database/delete/<?php echo $database[$a]["id_submit_db_connection"];?>" class = "btn btn-dark btn-sm col-lg-12">DELETE</a>
                        <button type = "button" class = "btn btn-primary btn-sm col-lg-12" data-toggle = "modal" data-target = "#editDatabase<?php echo $a;?>">EDIT DATABASE</button>
                        <button type = "button" class = "btn btn-light btn-sm col-lg-12" data-toggle = "modal" data-target = "#editPassword<?php echo $a;?>">UPDATE PASSWORD</button>
                    </td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
    </div>
</div>
<div class = "modal fade" id = "tambahDatabase">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Add Database Connection</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>database/insert" method = "POST">
                    <div class = "form-group">
                        <h5>Database Hostname</h5>
                        <input required type = "text" class = "form-control" name = "db_hostname">
                    </div>
                    <div class = "form-group">
                        <h5>Database Name</h5>
                        <input required type = "text" class = "form-control" name = "db_name">
                    </div>
                    <div class = "form-group">
                        <h5>Database Username</h5>
                        <input required type = "text" class = "form-control" name = "db_username">
                    </div>
                    <div class = "form-group">
                        <h5>Database Password</h5>
                        <input type = "password" class = "form-control" name = "db_password">
                    </div>
                    <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php for($a = 0; $a<count($database); $a++):?>
<div class = "modal fade" id = "editDatabase<?php echo $a;?>">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Edit Database Connection</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>database/update" method = "POST">
                    <input type = "hidden" name = "id_submit_db_connection" value = "<?php echo $database[$a]["id_submit_db_connection"];?>">
                    <div class = "form-group">
                        <h5>Database Hostname</h5>
                        <input required type = "text" class = "form-control" name = "db_hostname" value = "<?php echo $database[$a]["db_hostname"];?>">
                    </div>
                    <div class = "form-group">
                        <h5>Database Name</h5>
                        <input required type = "text" class = "form-control" name = "db_name" value = "<?php echo $database[$a]["db_name"];?>">
                    </div>
                    <div class = "form-group">
                        <h5>Database Username</h5>
                        <input required type = "text" class = "form-control" name = "db_username" value = "<?php echo $database[$a]["db_username"];?>">
                    </div>
                    <button type = "button" data-toggle = "modal" data-target = "#confirmPassword<?php echo $a;?>" class = "btn btn-primary btn-sm">DONE</button>

                    <div class = "modal fade" id = "confirmPassword<?php echo $a;?>">
                        <div class = "modal-dialog modal-center">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <h4>Password Confirmation</h4>
                                </div>
                                <div class = "modal-body">
                                    <div class = "form-group">
                                        <h5>Database Password</h5>
                                        <input type = "password" class = "form-control" name = "current_password">
                                    </div>
                                </div>
                                <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "editPassword<?php echo $a;?>">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Edit Database Password</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>database/update_password" method = "POST">
                    <input type = "hidden" name = "id_submit_db_connection" value = "<?php echo $database[$a]["id_submit_db_connection"];?>">
                    <div class = "form-group">
                        <h5>Current Database Password</h5>
                        <input type = "password" class = "form-control" name = "current_password">
                    </div>
                    <div class = "form-group">
                        <h5>New Database Password</h5>
                        <input type = "password" class = "form-control" name = "new_password">
                    </div>
                    <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endfor;?>
