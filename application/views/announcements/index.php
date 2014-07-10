<div id="right">
		  
<div id="right_bottom">
<?if($this->session->userdata['userType'] == "admin"):?>
<p><a class='btn btn-success' href="<?php echo base_url(); ?>announcements/create" rel="facebox">New Announcement</a></li></p>
<?endif;?>
<table id="table">

	<tr>
    <th>Message</th>
    <th>Action</th>
  </tr>


<tbody>

  <?php if($announcements){ ?>
  <?php foreach( $announcements as $announcement): ?>
    <tr>
      <td><?php echo $announcement->message ; ?></td>
      <td>
      <a href="<?php echo base_url()."announcements/display/".$announcement->id; ?>" rel="facebox" class="actionlink">Show</a><br/>
	  <?if($this->session->userdata['userType'] == "admin"):?>
      <a href="<?php echo base_url()."announcements/edit/".$announcement->id; ?>" rel="facebox" class="actionlink">Edit</a><br/>
      <a href="<?php echo base_url()."announcements/destroy/".$announcement->id; ?>" rel="facebox" class="actionlink confirm">Destroy</a>
	  <?endif;?>
   	</td>
    </tr>
  <?php endforeach; ?>
  <?php } ?>
  
</tbody>

	<tr>
    <th>Message</th>
    <th>Action</th>
  </tr>

</table>
<?if($this->session->userdata['userType'] == "admin"):?>
<p><a class='btn btn-success' href="<?php echo base_url(); ?>announcements/create" rel="facebox">New Announcement</a></li></p>
<?endif;?>
</div>

</div>
