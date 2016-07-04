<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
	<html>
	<body>
	<xsl:for-each select= "mixedteams/basketball" >
	   <xsl:variable name = "Color" select="Color" />
        <xsl:variable name = "BColor" select="BColor" />
        <xsl:variable name = "Image" select="Image" />
        <xsl:variable name = "Video" select="Video" />
		
		<table border="1" align="center" width="1000" height="800" bgcolor="{$BColor}" style="text-align:center;color:{$Color};" >
	
		<strong>
	
			<tr>
            <th colspan="4" width="1000" height="160" style="font-size:30px" ><xsl:value-of select="Team"/></th>
            </tr>
			
			<tr   height="40" style="font-size:20px">
			<td>Image</td>
			<td>All-star</td>
			<td>Coach</td>
			<td>Stadium</td>
			</tr>
		</strong>	
			<tr  height="180"  style="font-size:25px">
			<td  height="100"><img src="{$Image}" width="100px"></img></td>
			<td>
				<table border="1" align="center" width="100%" height="100%" style="text-align:center;color:{$Color}">
				
				<tr>
				<td><xsl:value-of select="All-star/name"/></td>
				<td>AGE:<xsl:value-of select="All-star/age"/></td>
				<td><xsl:value-of select="All-star/position"/></td>
				</tr>
					
				</table>
			</td>
			 <td><xsl:value-of select="Coach"/></td>
            <td><xsl:value-of select="Stadium"/></td>
			</tr>
		<tr height="800"><td colspan="4"><iframe width="100%" height="100%"  src="{$Video}"></iframe></td>
		</tr>
		
		</table>
		
		
		<br/>
		<br/>
		
	</xsl:for-each>
	</body>
	</html>
	
  </xsl:template>
</xsl:stylesheet>