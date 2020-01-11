<div class="site-menubar">
    <div class="site-menubar-header">
        <div class="cover overlay">
            <div class="overlay-panel vertical-align overlay-background">
                <div class="vertical-align-middle">
                    <a class="avatar avatar-lg" href="javascript:void(0)">
                        <img src="<?php echo base_url();?>assets/images/default.jpg" alt="...">
                    </a>
                    <div class="site-menubar-info">
                        <h5 class="site-menubar-user"><?php echo $this->session->nama_user;?></h5>
                        <p class="site-menubar-email"><?php echo $this->session->email_user;?> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-item">
                        <a href="<?php echo base_url();?>user">
                            <i class="site-menu-icon wb-memory" aria-hidden="true"></i>
                            <span class="site-menu-title">User Administrator</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="<?php echo base_url();?>token">
                            <i class="site-menu-icon wb-check-circle" aria-hidden="true"></i>
                            <span class="site-menu-title">Tokenization</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="<?php echo base_url();?>database">
                            <i class="site-menu-icon wb-link" aria-hidden="true"></i>
                            <span class="site-menu-title">Database Connection</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="<?php echo base_url();?>intent_entity">
                            <i class="site-menu-icon wb-library" aria-hidden="true"></i>
                            <span class="site-menu-title">Intent & Entity</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="<?php echo base_url();?>dataset">
                            <i class="site-menu-icon wb-grid-9" aria-hidden="true"></i>
                            <span class="site-menu-title">Dataset</span>
                        </a>
                    </li>
                </ul> 
            </div>
        </div>
    </div>
</div>