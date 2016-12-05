<!DOCTYPE html>
<html>
<head>
	<title>%title%</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="%meta_desc%" />
	<meta name="keywords" content="%meta_key%" />
	<link type="text/css" rel="stylesheet" href="%address%css/main.css" />	
</head>
<body>
    <div id="content">
        <div id="header">
            <h2>Шапка сайта</h2>
        </div>
        <hr />
    </div><!-- end content-->
	
    <div id="main_content">
        <div id="left">
            <h2>Меню</h2>
            <ul>%menu%</ul>
            %auth_user%
        </div><!-- end left-->
        %sort%
        <div id="center">
            %top%
            %middle%
            %bottom%
        </div><!-- end center-->
        <div class="clear"></div>
        <hr />
		
        <div id="footer">
            <p>Все права защищены &copy; 2016</p>
        </div><!-- end footer-->
		
    </div><!-- end main_content-->
</body>
</html>