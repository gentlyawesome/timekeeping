<ul class="nav navbar-nav">
  <?if(!$this->is_admin):?>
  <li class="<?=$this->router->class=="task" && $this->router->method=="add_daily_task" ? 'active' : ''?>"><a href="<?=site_url('task/add_daily_task')?>">Add Task For This Day</a></li>
  <?endif;?>
  <li class="<?=$this->router->class=="task" && $this->router->method=="view_task_list" ? 'active' : ''?>"><a href="<?=site_url('task/view_task_list')?>">Daily Task List</a></li>

  <?if($this->is_admin):?>
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master List <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="<?=site_url('client')?>">Client/Customer</a></li>
      <li><a href="<?=site_url('project')?>">Project</a></li>
      <li><a href="<?=site_url('modules')?>">Modules</a></li>
      <li class="divider"></li>
      <li><a href="<?=site_url('employees')?>">Employees</a></li>
    </ul>
  </li>
  <?endif;?>
</ul>