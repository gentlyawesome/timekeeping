<?php $this->load->view('layouts/_student_data'); ?>
<table>
  <tr>
    <th>Comment</th>
    <th>Resolved</th>
    <th>Issued By</th>
  </tr>
  <? if(!empty($issues)) :?>
  <? foreach($issues as $i ) :?>
  <tr>
    <td><?= $i->comment ?></td>
    <td><?= $i->resolved ?></td>
    <td><?= $i->issued_by ?></td>
  </tr>
  <? endforeach ;?>
  <? else : ?>
  <tr>
    <td colspan=4 class="text-center"> NO ISSUES</td>
  </tr>
  <? endif ;?>
</table>