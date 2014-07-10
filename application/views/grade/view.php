<div class="well">
	<h4><div class='label label-info'>Year : <?=$student->year;?> </div>|<div class='label label-info'> Course : <?=$student->course?></div>|<div class='label label-info'> School Year : <?=$student->sy_from?>-<?=$student->sy_to?></div></h4>
</div>
<table>
  <tr>
    <th>Subject Code</th>
    <th>Section Code</th>
    <th>Description</th>
    <th>Preliminary</th>
    <th>Midterm</th>
    <th>Finals</th>
    <th>Remarks</th>
  </tr>
  <? $num=0 ?>
	<?if($student_grades) :?>
    <? foreach($student_grades as $sg ) :?>
    <tr>
      <td><?= $sg['sc_id'] ?></td>
      <td><?= $sg['code'] ?></td>
      <td><?= $sg['subject_desc'] ?></td>
      <? foreach($sg['grades'] as $sgg ) :?>
      <td><?=($sgg);?></td>
      <? endforeach ;?>
      <td><?= $sg['remarks'] ?></td>
    </tr>
    <? endforeach ;?>
    <? endif ;?>
</table>

