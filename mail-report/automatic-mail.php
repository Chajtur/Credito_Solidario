<?php
// multiple recipients
$to  = 'dev.honduras@gmail.com';

// subject
$subject = 'Prueba(ya casi)';

// message
$message = '
<html>
<head>
<style>

img {
	width: auto;
    height: 100px;
     display: block;
    margin: 0 auto;
    margin-top: 2px;
}
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    background-color: #fff;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    /*background-color: #dddddd;*/
}
</style>
</head>
<body bgcolor= "#fefefe">
<div style="background-color: #bdbdbd;bottom: 4px;position: relative;right: 4px;">
	<div style="background-color: #FFFFFF;border: 0px solid #000000;color: #000000;padding: 0.5em;bottom: 4px;position: relative;right: 4px;">
		<table>
  <tr>
    <th>Company</th>
    <th>Contact</th>
    <th>Country</th>
  </tr>
  <tr>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
  </tr>
  <tr>
    <td>Centro comercial Moctezuma</td>
    <td>Francisco Chang</td>
    <td>Mexico</td>
  </tr>
  <tr>
    <td>Ernst Handel</td>
    <td>Roland Mendel</td>
    <td>Austria</td>
  </tr>
  <tr>
    <td>Island Trading</td>
    <td>Helen Bennett</td>
    <td>UK</td>
  </tr>
  <tr>
    <td>Laughing Bacchus Winecellars</td>
    <td>Yoshi Tannamuri</td>
    <td>Canada</td>
  </tr>
  <tr>
    <td>Magazzini Alimentari Riuniti</td>
    <td>Giovanni Rovelli</td>
    <td>Italy</td>
  </tr>
</table>
	</div>
</div>


<img src="https://s-media-cache-ak0.pinimg.com/originals/83/90/0a/83900a5b6d403ddbfd4e843ea70828f4.jpg" alt="">
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: Víctor <dev.honduras@gmail.com>' . "\r\n";
$headers .= 'From: prueba <vic_alvarado@outlook.es>' . "\r\n";

// Mail it
if(mail($to, $subject, $message, $headers)){
    echo "enviado";
}else {
    echo "No enviado";
}

?>