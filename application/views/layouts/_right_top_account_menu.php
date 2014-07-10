<ul class="nav navbar-nav navbar-right">
  <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;<strong><?=$this->user->login?></strong></a></li>
  <li class="dropdown success mybg-success">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$this->user->name?> <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <!-- <li><a href="#">Action</a></li>
      <li><a href="#">Another action</a></li> -->
      <li><a href="<?=site_url('account/change_password')?>">Change Password</a></li>
      <li class="divider"></li>
      <li><a href="<?=site_url('auth/logout')?>"><i class="fa fa-sign-out"></i>&nbsp; Logout</a></li>
    </ul>
  </li>
</ul>