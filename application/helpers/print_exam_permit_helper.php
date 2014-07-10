<?php

function print_html($enrollments,$setting,$permit_setting,$gmdate,$max){
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

<div>';

$ctr = 0;

foreach($enrollments as $enrollment):

$ctr++;

$html .= '<table style="width:100%; font-size:10px; text-align:center;">
<tr>
<td>
<img src='.base_url().'assets/images/kcplogo.png" style="width:40px;" />
</td>
</tr>
<tr>
<td>
<div style="font-size:10px; text-align:center;">
'.$setting->school_name.'
</div>
<div style="font-size:7px; text-align:center;">
'.$setting->school_name.'
</div>
<div style="font-size:7px; text-align:center;">
'.$setting->school_address.'
</div>
<div style="font-size:7px; text-align:center;">
'.$setting->school_telephone.'
</div>
<div style="font-size:7px; text-align:center;">
'.$setting->email.'
</div>
</td>
</tr>
<tr>
<td style="font-size:7px; text-align:center;">
'.$permit_setting->name.'
</td>
</tr>
<tr>
<td style="text-align:left; width:100%;">

<table style="width:100%;">
<tr>
<td style="font-size:7px; text-align:left;">
Time: '.date("h:i A",$gmdate).',
</td>
<td style="font-size:7px; text-align:left;">
Date: '.date("F d, Y",$gmdate).',
</td>
<td style="font-size:7px; text-align:left;">
Term: '.$enrollment->name.' Sem,
</td>
<td style="font-size:7px; text-align:left;">
SY: '.$enrollment->sy_from.' - '.$enrollment->sy_to.',
<td style="font-size:7px; text-align:left;">
Admission Status: '.$enrollment->status.'
</td>
</tr>
<tr>
<td colspan="2" style="font-size:8px; text-align:left; font-weight:bold;">
ID No#: '.$enrollment->studid.'
</td>
<td colspan="3" style="font-size:8px; text-align:left; font-weight:bold;">
Student Name: '.ucfirst($enrollment->name).'
</td>
</tr>
<tr>
<td colspan="2" style="font-size:7px; text-align:left;">
Course: '.$enrollment->course.',
</td>
<td colspan="3" style="font-size:7px; text-align:left;">
Year: '.$enrollment->year.' Year
</td>
</tr>
</table>

</td>
</td>
<tr>
<td style="width:100%; font-size:7px; text-align:left;">

<table cellpadding="0" cellspacing="0" style="width:100%;">
<tr>
<td style="border-bottom:#000 2px solid;">
Subject Code
</td>
<td style="border-bottom:#000 2px solid;">
Section Code
</td>
<td style="border-bottom:#000 2px solid;">
Subject Description 
</td>
<td style="border-bottom:#000 2px solid;">
Units
</td>
<td style="border-bottom:#000 2px solid;">
Lab
</td>
<td style="border-bottom:#000 2px solid;">
Instructor\'s Signature
</td>
<td style="border-bottom:#000 2px solid;">
Date
</td>
<td style="border-bottom:#000 2px solid;">
Remarks
</td>
</tr>
</table>

</td>
</tr>
</table>';

if($ctr<=$max){
$html .= '<pagebreak />';
}
endforeach;

$html .= '</div>


</body>
';
return $html;
}