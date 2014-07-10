<?php

function print_html($setting,$profiler){
$ci =& get_instance();

$html = '
<head>
<style>

html, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, blockquote, pre,a, abbr, acronym, address, big, cite, code,del, dfn, em, img, ins, kbd, q, s, samp,small, strike, strong, sub, sup, tt, var,b, u, i, center,dl, dt, dd, ol, ul, li,fieldset, form, label, legend,table, caption, tbody, tfoot, thead, tr, th, td,article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary,time, mark, audio, video 
{
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 12px;
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
font-size:12px;
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
<table align="center" style="width:600px; text-align:center;">
<tr>
<td>
<img src="'.base_url().'/assets/images/kcplogo.png" style="display:block; margin:0px; padding:0px;" />
</td>
</tr>
<tr>
<td style="font-size:18px; font-weight:bold;">
'.$setting->school_name.'
</td>
</tr>
<tr>
<td style="font-size:8px;">
'.$setting->school_address.'
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td style="text-align:right;">
____________
</td>
</tr>
<tr>
<td style="text-align:right; padding-right:20px;">
Date
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td style="font-weight:bold;">
ACKNOWLEDGEMENT OF LIABILITY
</td>
</tr>
<tr>
<td style="font-weight:bold;">
PROMISSORY NOTE
</td>
</tr>
<tr>
<td style="border:#000 1px solid; text-align:left;">
NAME OF STUDENT: '.ucfirst($profiler->last_name).', '.ucfirst($profiler->first_name).' '.ucfirst($profiler->middle_name).'
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td style="border:#000 1px solid; text-align:left;">
AMOUNT OF FINANCIAL OBLIGATION:
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td >

<table style="width:500px; border:#000 1px solid; text-align:left;">
<tr>
<td>
a
</td>
</tr>
</table>

</td>
</tr>
<tr>
<td style="text-align:left;">
NATURE OF FINANCIAL OBLIGATION (Please check appropriate description of obligation):
</td>
</tr>
<tr>
<td style="text-align:left;">
[ ] Unpaid marticulation fee (i.e. tuition, miscellaneous and other fees) as at-
</td>
</tr>
<tr>
<td>
[ ] Preliminary [ ] Midterm [ ] Semi-Finals [ ] Finals
</td>
</tr>
<tr>
<td style="text-align:left;">
[ ] Other forms of financial obligation: ___________________________________________________________________
</td>
</tr>
<tr>
<td>
COLLEGE OF-
</td>
</tr>
<tr>
<td>

<table>
<tr>
<td style="text-align:left;">
[ ] Arts and Sciences
</td>
<td style="text-align:left;">
[ ] Health Sciences
</td>
</tr>
<tr>
<td style="text-align:left;">
[ ] Business and Accountancy
</td>
<td style="text-align:left;">
[ ] Maritime Education
</td>
</tr>
<tr>
<td style="text-align:left;">
[ ] Computer Sciences
</td>
<td style="text-align:left;">
[ ] Mechanical Engineering
</td>
</tr>
<tr>
<td style="text-align:left;">
[ ] Education
</td>
<td style="text-align:left;">
[ ] Hospitality Mngt and Tourism
</td>
</tr>
</table>

</td>
</tr>
<tr>
<td style="text-align:left;">
I promise to pay the above written financial obligation on or before _________________________.
</td>
</tr>
<tr>
<td>

<table>
<tr>
<td>
<table>
<tr>
<td>
<table style="width:200px; border:#000 1px solid;">
<tr>
<td style="font-weight:bold; font-size:20px;">
VALID AS PERMIT FOR _______ EXAMINATION
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td style="font-weight:bold; text-align:center;">
Not Valid <br /> Without <br /> Seal
</td>
</tr>
</table>
</td>
<td>
<table>
<tr>
<td style="text-align:center;">
___________________________________________________________
</td>
</tr>
<tr>
<td style="text-align:center;">
SIGNATURE OVER PRINTED NAME
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td style="text-align:center;">
[ ] Mother [ ] Father [ ] Guardian [ ] Student
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td style="text-align:center;">
_____________________________________
</td>
</tr>
<tr>
<td style="text-align:center;">
ADDRESS
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td style="text-align:center;">
_____________________________________
</td>
</tr>
<tr>
<td style="text-align:center;">
CELLPHONE NUMBER
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td style="text-align:center; font-weight:bold;">
PILOT SHEET(Pilot Test up to 00 March 2013)
</td>
</tr>
</table>
</td>
</tr>
</table>

</td>
</tr>
</table>
</body>
';

return $html;
}