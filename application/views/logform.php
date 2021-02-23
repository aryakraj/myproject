<!DOCTYPE html>
<html>
	<head>
		<title></title>
        <style>
        	fieldset{
        		width:50px;
        		margin-top:15%;
        		margin-left:35%; 
        	}

        </style>
	</head>
	<body>
		<form method="post" action="<?php echo base_url()?>main/login">
			<fieldset>
				<legend>login</legend>
			<table>

			<tr>
				<td><h2>Email id:<h2></td>
			    <td><input type="email" name="email"></td>
			<tr>
				<td><h2>Password:</h2></td>
			   <td><input type="password" name="password"></td>
			</tr>  
			<tr>			
				<td ><input type="submit" name="submit" value="login" ></td>
			</tr>
			</table>
            </fieldset>
	</form>
	</body>	
</html>  