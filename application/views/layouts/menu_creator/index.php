<?$this->load->view('layouts/menu_creator/_header');?>
<table>
	<tr>
		<th>Department</th>
		<th>Menus</th>
	</tr>
<?if($departments):?>
	<?foreach($departments as $dep):?>
		<tr>
			<td><?=strtoupper($dep->department)?></td>
			<td>
				<table>
					<tr>
						<th>Header Menu</th>
						<th>Submenu</th>
					</tr>
					<?if(isset($headers[$dep->department])):?>
						<?foreach($headers[$dep->department] as $head):?>
							<tr>
								<td><?=$head->caption;?></td>
								<td>
									<table>
										<tr>
											<th>Caption</th>
											<th>Controller</th>
											<th>Menu Group</th>
											<th>Menu Sub</th>
											<th>Menu Number</th>
											<th>Menu Level</th>
											<th>Action</th>
										</tr>
										<?if(isset($user_menus[$dep->department][$head->menu_sub])):?>
										<?foreach($user_menus[$dep->department][$head->menu_sub] as $menus):?>
											<tr>
												<td><?=$menus->caption?></td>
												<td><?=$menus->controller?></td>
												<td><?=$menus->menu_grp?></td>
												<td><?=$menus->menu_sub?></td>
												<td><?=$menus->menu_num?></td>
												<td><?=$menus->menu_lvl?></td>
												<td></td>
											</tr>
										<?endforeach;?>
										<?endif;?>
									</table>
								</td>
							</tr>
						<?endforeach;?>
					<?endif;?>
				</table>
			</td>
		</tr>
	<?endforeach;?>
	
<?endif;?>
</table>
<?$this->load->view('layouts/menu_creator/_footer');?>
