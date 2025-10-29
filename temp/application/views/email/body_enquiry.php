<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Email from <?php echo $name;?></title>

<style type="text/css">
html,body {
   margin:0;
   padding:0;
   height:100%;
   width:100%;
   background-color: #FFFFFF;
   text-align:center;
}


h1,h2,h3{
   font-family:Arial, Helvetica, sans-serif;
   font-style:italic;
   font-weight:800;
   color: #666;
   font-size:21px;

}
	
.main{
border:1px solid #666666;
}	
.body_text {
   font-family:Arial, Helvetica, sans-serif;
   font-size:14px;
   font-weight:600;
   font-stretch:expanded;
   line-height:18px;
   color: #999999;
		}

.body_text  a { color: #999999; text-decoration: none; }
.body_text  a:hover { color: #47C7EA; text-decoration:none;  }
.body_text  a:visted { color:#47C7EA; text-decoration: none;}

.normaltxt {
   font-family:Arial, Helvetica, sans-serif;
   font-size:14px;
   font-weight:400;
   color: #999999;
		}

.normaltxt  a { color: #999999; text-decoration: none; }
.normaltxt  a:hover { color: #CC6600; text-decoration:none;  }
.normaltxt  a:visted { color:#CC6600; text-decoration: none;}

.links {
    color: #CC0000;
	font-size:10px;
	font-weight: 600;
	font-family: Arial, Helvetica, sans-serif;
	line-height:5px;
	text-align:justify;
		}

.links  a { color: #CC0000; text-decoration: none; }
.links  a:hover { color:#47C7EA; text-decoration:none;  }
.links  a:visted { color:#47C7EA; text-decoration: none;}	

.info {
    color: #999999;
	font-size:10px;
	font-weight:300;
	font-family: Arial, Helvetica, sans-serif;
	line-height:5px;
	text-align:justify;
		}

.info  a { color: #CC0000; text-decoration: none; }
.info  a:hover { color:#47C7EA; text-decoration:none;  }
.info  a:visted { color:#47C7EA; text-decoration: none;}	

.toplinks {
    color: #999999;
	font-size:13px;
	font-weight: 800;
	font-family: Arial, Helvetica, sans-serif;
	text-align: right;
		}

.toplinks  a { color: #47C7EA; text-decoration: none; }
.toplinks  a:hover { color:#CC0000; text-decoration:none;  }
.toplinks  a:visted { color:#47C7EA; text-decoration: none;}	

.footerlinks {
    color: #FFFFFF;
	font-size:10px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
		}

.footerlinks  a { color: #FFFFFF; text-decoration: underline; }
.footerlinks  a:hover { color: #FF0000; text-decoration:none;  }
.footerlinks  a:visted { color:#47C7EA; text-decoration: none;}	

.style1 {font-size: 12px}
.style2 {
	font-size: 11px;
	font-style: italic;
}
.style3 {color: #47C7EA}
.style4 {
	color: #990000;
	font-style: italic;
}
</style>
</head>

<body bgcolor="#f1f1f1">

<table width="100%"  bgcolor="#f1f1f1" border="0" cellspacing="0" cellpadding="0">
   <?php if (isset($link)){?>
  <?php }else{?>
   <tr>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;text-align:center;color:#FFFFFF; vertical-align:top">&nbsp;</td>
  </tr>
   <?php }?>
  <tr>
    <td><table width="700px" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" align="center" style="border: 1px solid #999999">
  
  <tr>
    <td bgcolor="#DBDBDB" style="background-color: #DBDBDB"><img src="<?php echo base_url('/');?>/img/logo_nav.png.png" style="float:left;width:auto;margin:10px 20px 15px 20px" /></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="630" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr >
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;" align="center"></td>
  </tr>
  
</table></td>
  </tr>
  <tr>
    <td><table width="593" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="593" colspan="2">&nbsp;</td>
      </tr>
     
<tr>
  <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px;text-align:left;color:#666666; vertical-align:top"><?php echo $msg;?> </td>
  </tr>
  <tr>
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">Name: <em><?php echo $name;?></em></td>
  </tr>
  <tr>
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">Email address: <em><?php echo $email;?></em></td>
  </tr>
  <tr>
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">You have received this enquiry via your website.</td>
  </tr>
  <tr>
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">&nbsp;</td>
  </tr>
 
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">Have a great day.</td>
  </tr>
  <tr>
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">&nbsp;</td>
  </tr>

  
      <tr>
        <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; text-align:left"></td>
      </tr>
      </table></td>
  </tr>
  
  
  <tr>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px; " align="center">&nbsp;</td>
  </tr>
   <tr style="background-color: #f9f9f9">
     <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;" align="center"></td>
   </tr>
   <tr style="background-color: #f9f9f9">
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;" align="center"><img src="http://my.na/NEW/img/bground/my-na-bottom.png" style="float:none;width:600px;margin:5px 20px 5px 0px" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="center" style="text-align:center;width:100%"><div style="text-align:center">
      <div style="margin:auto;width:600px;font-size:10px;color:#fff; font-family:Arial, Helvetica, sans-serif; text-align:center">You have received this email because you have received an enquiry via your website.  If you really want to change this and unsubscribe from the updates please click on the following link. <a href="#" style="font-size:10px; color: #000; text-decoration: underline; font-weight:bold;" >unsubscribe</a> <br />
    This email was sent with your permission.</div></div></td>
  </tr>
</table>

</body>
</html>
