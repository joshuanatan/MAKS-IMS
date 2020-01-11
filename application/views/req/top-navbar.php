<nav class="site-navbar navbar navbar-default navbar-inverse navbar-fixed-top navbar-mega" role="navigation" style = "background-color:#3B464C">
        
    <div class="navbar-header">
        <button type="butwhitesmoketon" style = "color:white" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided" data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
            <i class="icon wb-more-horizontal" aria-hidden="true" style = "color:white"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
            <img class="navbar-brand-logo" src="<?php echo base_url();?>assets/images/logo.png" title="Remark">
        </div>
    </div>
    
    <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <ul class="nav navbar-toolbar">
                
                <li class="nav-item hidden-float" id="toggleMenubar">
                    <a style = "color:white" class="nav-link" data-toggle="menubar" href="#" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                            <span class="sr-only">Toggle menubar</span>
                            <span class="hamburger-bar"></span>
                        </i>
                    </a>
                </li>
                
                <li class="nav-item hidden-sm-down" id="toggleFullscreen">
                    <a class="nav-link icon icon-fullscreen" style = "color:white" data-toggle="fullscreen" href="#" role="button">
                        <span class="sr-only">Toggle fullscreen</span>
                    </a>
                </li>
                
            </ul>
          <!-- End Navbar Toolbar -->
    
          <!-- Navbar Toolbar Right -->
            <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
            
                <li class="nav-item dropdown">
                    <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                        data-animation="scale-up" role="button">
                        <span class="avatar avatar-online">
                        <img src="<?php echo base_url();?>assets/images/default.jpg" alt="...">
                        <i></i>
                        </span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <button data-toggle = "modal" data-target = "#changePassword" class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Change Password</button>

                        
                        <a class="dropdown-item" href="<?php echo base_url();?>welcome/logout" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
                    </div>
                </li>
            </ul>
          <!-- End Navbar Toolbar Right -->
    
          <div class="navbar-brand navbar-brand-center">
            <a href="<?php echo base_url();?>">
                <img class="navbar-brand-logo navbar-brand-logo-normal" src="<?php echo base_url();?>assets/images/logo.png" title="Remark">
                <img class="navbar-brand-logo navbar-brand-logo-special" src="<?php echo base_url();?>assets/images/logo.png" title="Remark">
            </a>
            </div>
        </div>
    </div>
</nav> 
<div class = "modal fade" id = "changePassword">
    <div class = "modal-dialog">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">CHANGE PASSWORD</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>welcome/change_password" method = "POST">
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">NEW PASSWORD</h5>
                        <input type = "password" name = "password" class = "form-control">
                    </div>    
                    <div class = "form-group">
                        <input type = "submit" class = "btn btn-sm btn-primary btn-outline">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>