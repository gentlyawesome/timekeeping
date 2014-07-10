<div class="row">

	<!-- NEWS -->
  <div class="col-md-6">
		<ul class="nav nav-pills nav-stacked">
		  <li class="active">
			<a href="<?=base_url()?>announcements">
			  <span class="badge pull-right">Read All</span>
			  News
			</a>
		  </li>
		  <?if(isset($news)):?>
			<?foreach($news as $obj):?>
				<li>
					
					<div class='well'>
					  <?=$obj->message;?>
					  <br/>
					   <span class="badge pull-right">By : <?=$obj->name;?></span><br/>
					</div>
					
					
				 </li>
			<?endforeach;?>
		  <?endif;?>
		  
		</ul>
  </div>
  
  <!-- EVENTS -->
  <div class="col-md-6">
		<ul class="nav nav-pills nav-stacked">
		  <li class="active">
			<a href="<?=base_url()?>events">
			  <span class="badge pull-right">Read All</span>
			  Events
			</a>
		  </li>
		   <?if(isset($events)):?>
			<?foreach($events as $obj):?>
				<li>
					
					<div class='well'>
						<a class='label label-info' href="#">
							<?=$obj->title;?>
							<?if($obj->is_holiday == 1):?>
							<span class="badge pull-right">Holiday</span><br/>
						   <?endif;?>
						</a><br/>
					  <?=$obj->description;?>
					  <br/>
					   <span class="badge pull-right">From : <?=date('M d, Y', strtotime($obj->start_date));?>&nbsp;to&nbsp;<?=date('M d, Y',strtotime($obj->end_date));?></span><br/>
					</div>
					
					
				 </li>
			<?endforeach;?>
		  <?endif;?>
		</ul>
  </div>
</div>