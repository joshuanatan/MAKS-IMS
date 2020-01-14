<h4 align = "center">Welcome to MySQL Query Builder WSDL</h4>
<h5 align = "center">Please read our endpoint documentation for integration</h5>
<ul>
    <?php for($a = 0; $a<count($endpoint); $a++):?>
    <li><a target = "_blank" href = "<?php echo base_url();?>ws/wsdl/<?php echo $endpoint[$a]["endpoint_name"];?>"><?php echo $endpoint[$a]["endpoint_name"];?></a></li>
    <?php endfor;?>
</ul>