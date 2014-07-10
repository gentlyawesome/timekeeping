<?$this->load->view('layouts/menu_creator/_header');?>
	
	<script>
		function Save(){
			
			var controller = 'ajax';
			var base_url = '<?php echo base_url(); ?>'; 
			var department = $('#department').val().trim();
			var men_grp_str = 1;
			var men_sup_str = 1;
			var men_grp_str_hr = 0;
			var men_sup_str_hr = 0;
			var ord = 0;
			var ord_s = 0;
			var order = 1;
			var savecount = 0;
			$('#menus a').each(function(){
				var href = $(this).attr("href");
				var cap = $(this).text();
				
				if(href == "#"){
					var con = "#";
					var men_lvl = 1;
					ord++;
					men_grp_str_hr++;
					order = 1;
					men_grp_ = men_grp_str_hr;
					men_sub_ = men_grp_str_hr+"_sub";
					
					
					var xparam = {
					'department' : department,
					'controller' : con,
					'caption' : cap,
					'menu_lvl' : men_lvl,
					'menu_grp' : men_grp_,
					'menu_sub' : men_sub_,
					'menu_num' : ord,
					}
					
					$.ajax({
						'url' : base_url + '' + controller + '/save_menu',
						'type' : 'POST', 
						'async': false,
						'data' : xparam,
						'dataType' : 'json',
						'success' : function(data){ 
							savecount++;
						}
					});
					
				}else{
					var con = href.replace("http://localhost/ci_system/","");
					var men_lvl = 2;
					men_sup_str_hr++;
					ord_s++;
					men_grp_ = men_grp_str_hr+"_sub";
					men_sub_ = "";
					
					var xparam = {
					'department' : department,
					'controller' : con,
					'caption' : cap,
					'menu_lvl' : men_lvl,
					'menu_grp' : men_grp_,
					'menu_sub' : men_sub_,
					'menu_num' : order,
					}
					
					$.ajax({
						'url' : base_url + '' + controller + '/save_menu',
						'type' : 'POST', 
						'async': false,
						'data' : xparam,
						'dataType' : 'json',
						'success' : function(data){ 
							savecount++;
						}
					});
					order++;
				}
			});
			if(save_count > 0)
			{
				alert('Menus saved.');
			}
			else{
				alert('Menu adding failed.');
			}
		}
	</script>
	
	
	<div id='menus'>
	
	<input class='btn btn-success' type="button" id="btn" name="btn" value="SAVE" placeHolder="Department" onclick='Save()' /><br/><br/>
	<input type="text" id="department" name="department" value="" placeHolder="Department" /><br/>
	
	<!--PUT YOUR LIST OF A TAG LINK HERE -->
	
 <div class="acc_con">
	  <a href="#">Student Menus</a><br>
	  <a href="<?=base_url()?>message">Message</a><br>
	  <a href="<?=base_url()?>section_offering">Section Offering</a><br />
	  <a href="<?=base_url()?>registration">Registration</a><br />
	  <a href="<?=base_url()?>profile">Profile</a><br />
	  <a href="<?=base_url()?>schedule">Schedule</a>
	  <a href="<?=base_url()?>grades">Grades</a><br />
	</div>
	
	<!-- END OF A TAG LINK -->
	
	</div>
<?$this->load->view('layouts/menu_creator/_footer');?>
