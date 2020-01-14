
<div class = "row">
    <div class = "col-lg-12">  
        <br/><br/>
        <h3 align = "center">KNOWLEDGE MANAGEMENT SERVICE ADMINISTRATION PAGE</h3>
    </div>
</div>
<br/><br/>
<?php if($this->session->status_login == "error"):?>
<div class = "col-lg-6 offset-lg-3 alert alert-danger">
    <button type = "button" class = "close">&times;</button>
    <?php echo $this->session->msg_login;?>
</div>
    <?php endif;?>
<div class = "row">
    <div class = "col-lg-6 offset-lg-3">
        <form action = "<?php echo base_url();?>welcome/auth" method = "POST">
            <div class = "form-group">
                <h5>User Email</h5>
                <input type = "text" name = "email_user" class = "form-control">
            </div>
            <div class = "form-group">
                <h5>Password</h5>
                <input type = "password" name = "password_user" class = "form-control">
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm">AUTHENTICATE</button>
        </form>
    </div>
</div>
</div>