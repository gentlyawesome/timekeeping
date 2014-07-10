<?$this->load->view('layouts/menu_creator/_header');?>
<!-- MENU CREATOR FORM -->
<?echo form_open('menu_creator/create','class="form-horizontal" role="form"');?>
  <div class="form-group">
	<label for="inputEmail3" class="col-sm-2 control-label"><h3>Menu Creator</h3></label>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Check Department that can access the menu</label>
    <div class="col-sm-10">
		<?if($departments):?>
			<?foreach($departments as $dep):?>
				<input type="checkbox" id='dep_<?=$dep->department?>' name='department[]' value='<?=$dep->department?>'> <?=$dep->description;?> <br/>
			<?endforeach;?>
		<?endif;?>
    </div>
  </div>
  <div class="form-group">
    <label for="controller" class="col-sm-2 control-label">Controller for the menu</label>
    <div class="col-sm-10">
       <input type="text" class="form-control" name="menu[controller]" placeholder="Controller" />
    </div>
  </div>
  <div class="form-group">
    <label for="caption" class="col-sm-2 control-label">Caption for the menu</label>
    <div class="col-sm-10">
       <input type="text" class="form-control" name="menu[caption]" placeholder="Caption" />
    </div>
  </div>
  <div class="form-group">
    <label for="menu_grp" class="col-sm-2 control-label">Grouping of the Menu</label>
    <div class="col-sm-10">
       <input type="text" class="form-control" name="menu[menu_grp]" placeholder="Menu Group" />
    </div>
   </div>
   
	<div class="form-group">
    <label for="menu_sub" class="col-sm-2 control-label">Menu Sub : Menu Group of its sub-menu</label>
    <div class="col-sm-10">
       <input type="text" class="form-control" name="menu[menu_sub]" placeholder="Menu Sub" />
    </div>
	</div>
	
	<div class="form-group">
    <label for="menu_num" class="col-sm-2 control-label">Menu Number : Order or sorting</label>
    <div class="col-sm-10">
       <input type="text" class="form-control" name="menu[menu_num]" placeholder="Order" />
    </div>
	</div>
	
	<div class="form-group">
    <label for="menu_lvl" class="col-sm-2 control-label">Menu Levels : Leveling or Class</label>
    <div class="col-sm-10">
       <input type="text" class="form-control" name="menu[menu_lvl]" placeholder="Level" />
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>
</form>
<!-- END OF MENU CREATOR FORM -->

<?$this->load->view('layouts/menu_creator/_footer');?>
