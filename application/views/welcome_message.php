<?php if($this->session->status_login == "success"):?>
<div class = "alert alert-success">
    <?php echo $this->session->msg_login;?>
</div>
<?php elseif($this->session->status_login == "error"):?>
<div class = "alert alert-danger">
    <?php echo $this->session->msg_login;?>
</div>
<?php endif;?>
<h2>WELCOME TO <i>KNOWLEDGE MANAGEMENT SERVICE</i> ADMINISTRATIVE PAGE</h2>
<br/>
<h3>Quick Brief</h3>
<hr/>
<h4>The main purpose of <i>Knowledge Management Service</i> is to manage the mapping between the <i>intent & entity combination</i> and <i>dataset</i>.</h4>
<h5>This Service is intended to memorize every intent & entity combination and dataset mapping in <i>database with MySQL engine</i>. The module will generates dataset query and other related dataset if <i>mapping key is found</i></h5>