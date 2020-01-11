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
<div class="page-body">

    <div class = "col-lg-10 offset-lg-1">
        <button type = "button" class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#tambahToken">+ ADD TOKEN</button>
        <a href = "<?php echo base_url();?>token/recycle_bin" class = "btn btn-light btn-sm"><i class = "icon wb-trash"></i></a>
        <br/><br/>
        <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable">
            <thead>
                <th style = "width:5%">#</th>
                <th>Nama Client</th>
                <th>Token token</th>
                <th>Last Modified</th>
                <th style = "width:15%">Status Token</th>
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
                        <?php if($token[$a]["status_aktif_token"] == 1):?>
                        <button type = "button" class = "btn btn-primary btn-sm col-lg-12">ACTIVE</button>
                        <?php else:?>
                        <button type = "button" class = "btn btn-danger btn-sm col-lg-12">NOT ACTIVE</button>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if($token[$a]["status_aktif_token"] == 1):?>
                        <a href = "<?php echo base_url();?>token/deactive/<?php echo $token[$a]["id_submit_token"];?>" class = "btn btn-danger btn-sm col-lg-12">DEACTIVE TOKEN</a>
                        <?php else:?>
                        <a href = "<?php echo base_url();?>token/activate/<?php echo $token[$a]["id_submit_token"];?>" class = "btn btn-light btn-sm col-lg-12">ACTIVATE TOKEN</a>
                        <?php endif;?>
                        <a href = "<?php echo base_url();?>token/delete/<?php echo $token[$a]["id_submit_token"];?>" class = "btn btn-dark btn-sm col-lg-12">DELETE TOKEN</a>
                        <button type = "button" data-toggle = "modal" class = "btn btn-primary btn-sm col-lg-12" data-target = "#editToken<?php echo $token[$a]["id_submit_token"];?>">EDIT TOKEN</button>
                    </td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
    </div>
</div>
<div class = "modal fade" id = "tambahToken">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Add Token</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>token/insert" method = "POST">
                    <div class = "form-group">
                        <h5>Nama Client</h5>
                        <input required type = "text" class = "form-control" name = "nama_client">
                    </div>
                    <div class = "form-group">
                        <h5>Token</h5>
                        <input required type = "text" class = "form-control" name = "token" value = "<?php echo $new_token;?>" readonly>
                    </div>
                    <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php for($a = 0; $a<count($token); $a++):?>
<div class = "modal fade" id = "editToken<?php echo $token[$a]["id_submit_token"];?>">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Edit token</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>token/update" method = "POST">
                    <input type = "hidden" name = "id_submit_token" value = "<?php echo $token[$a]["id_submit_token"];?>">
                    <div class = "form-group">
                        <h5>Nama Client</h5>
                        <input required type = "text" class = "form-control" value = "<?php echo $token[$a]["nama_client"];?>" name = "nama_client">
                    </div>
                    <div class = "form-group">
                        <h5>Token</h5>
                        <input required readonly type = "text" class = "form-control" value = "<?php echo $token[$a]["token"];?>" name = "token">
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endfor;?>