<?php

function print_html($students,$setting,$b,$studentsubjects){
$ci =& get_instance();

$html = '
<head>
<style>

html, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, blockquote, pre,a, abbr, acronym, address, big, cite, code,del, dfn, em, img, ins, kbd, q, s, samp,small, strike, strong, sub, sup, tt, var,b, u, i, center,dl, dt, dd, ol, ul, li,fieldset, form, label, legend,table, caption, tbody, tfoot, thead, tr, th, td,article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary,time, mark, audio, video 
{
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 10px;
	font: inherit;
	vertical-align: top;
}

/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section 
{
	display: block;
}

td
{
padding: 3px;
}

th
{
border-bottom: 1px solid #000;
font-weight: bold;
font-size:10px;
padding: 3px;
margin: 0px;
text-align: center;
}

td.title
{
border-top: 1px solid #000;
border-right: 1px solid #000;
border-left: 1px solid #000;
font-weight: bold;
}

td.title2
{
border-bottom: #000 1px solid;
}

</style>
</head>
<body>

<div>

<div style="font-size:10px; font-weight:bold; text-align:center;">
'.$setting->school_name.'
</div>
<div style="font-size:10px; font-weight:bold; text-align:center;">
'.$setting->school_address.'
</div>
<div style="font-size:10px; font-weight:bold; text-align:center;">
&nbsp;
</div>
<div style="font-size:10px; font-weight:bold; text-align:center;">
Ched Report
</div>
<div>
<table style="border-top:#000 1px solid; border-left:#000 1px solid; width:100%; border-right:#000 1px solid;" cellpadding="0" cellspacing="0">
<tr>
<td style="border-bottom:#000 1px solid; border-right:#000 1px solid;" colspan=2>
Student Name
</td> ';

for($i=1;$i<=$b;$i++){
    $html .= '<td style="border-bottom:#000 1px solid; border-right:#000 1px solid;">Subject Code</td>
			  <td style="border-bottom:#000 1px solid; border-right:#000 1px solid;">Earned Units</td>';
}

$html .= '<td style="border-bottom:#000 1px solid;">Total Earned Units</td></tr>';

$num=1;
if($students){

foreach($students as $student): 
$show = 0; 
	foreach($studentsubjects as $studentsubject): 
		if($student->id == $studentsubject->enrollmentid && $studentsubject->code != '' && $studentsubject->units != ''){ 
			$show = 1; 
		} 
	endforeach; 
	if($show == 1){
	
$html .= '<tr>
    <td style="border-bottom:#000 1px solid; border-right:#000 1px solid;">'.$num++.'</td>
    <td style="border-bottom:#000 1px solid; border-right:#000 1px solid;">'.$student->name.'</td>';

$total_units = 0;
$ctr = 0;

	foreach($studentsubjects as $studentsubject):
		if($student->id == $studentsubject->enrollmentid){ 
	
$html .= '<td style="border-bottom:#000 1px solid; border-right:#000 1px solid;">'.$studentsubject->code.'</td>
		  <td style="border-bottom:#000 1px solid; border-right:#000 1px solid;">'.$studentsubject->units.'</td>';

		$total_units = $total_units + $studentsubject->units;
		$ctr++; 
		}
	endforeach;
	
	for($i=$ctr+1;$i<=$b;$i++){ 
$html .= '<td style="border-bottom:#000 1px solid; border-right:#000 1px solid;">&nbsp;</td>
		  <td style="border-bottom:#000 1px solid; border-right:#000 1px solid;">&nbsp;</td>';
	}
$html .= '<td style="border-bottom:#000 1px solid;">'.$total_units.'</td>
  </tr>';
	}
	
endforeach; 

}else{

$html .= '<tr><td colspan="3" style="border-bottom:#000 1px solid;">no record to display</td>';

}

$html .= '</table>
</div>

</div>


</body>
';
return $html;
}