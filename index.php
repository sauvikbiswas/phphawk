<html>
<head>
	<title>Dark Project : The Official Site</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<script language="javascript" src="scripts/functionsv8.js"></script>
	<link REL='stylesheet' HREF='scripts/stylev8.css' TYPE='text/css'>
</head>
<body onscroll="menuSwitcher()" onload="masterLoad();" onresize="masterResize()">
<div class="page-header" id="page-header">
	<div class="head-name">
		<div class="head-name-text">Dark Project</div>
		<div class="head-menu" id="head-menu">
			<div class="head-version" id="head-version">Official Website. Version 8.0</div>
			<ul class="head-menu-list">
				<li><a href="#feed" onclick="loadpage('news');">Feed</a></li>
				<li><a href="http://darkproject.bandcamp.com">Music</a></li>
				<li><a href="#band" onclick="loadpage('band');">Band</a></li>
				<li><a href="https://www.youtube.com/user/darkprojectband">Videos</a></li>
				<li><a href="https://www.facebook.com/darkprojectband">Contact</a></li>
			</ul>
		</div>
	</div>
	<div class="header-player">
		<!--<div class="player-info"><img src="images/duality_small.jpg" height="60"><br><small>Duality</small></div>-->
		<!--<div class="soundcloud-player"><object class="playerswf" height="81" width="100%"> <param name="movie" value="http://player.soundcloud.com/player.swf?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F59496970"></param> <param name="allowscriptaccess" value="always"></param>
			<embed class="playerswfembed" allowscriptaccess="always" height="81" src="http://player.soundcloud.com/player.swf?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F59496970&amp;show_comments=true&amp;auto_play=false&amp;color=0d5891" type="application/x-shockwave-flash" width="100%"></embed></object><br></div>
		<div class="player-more"><a href="#" id="playlist-more" onclick="toggleCollapsePlaylist()">More</a></div>
		<div class="player-playlist">
			<table class="playertable" width="94%" border="0" cellpadding="0" cellspacing="0">
			<tr><td><a href="#music" onclick="inloadx('subdir=content&page=player.php&type=p&songid=duality','player');">Duality</a></td><td>Single</td><td><s>Download HQ</s></td></tr>
			<tr><td><a href="#music" onclick="inloadx('subdir=content&page=player.php&type=p&songid=magic','player');">Magic</a></td><td>Single</td><td><a href="http://darkproject.bandcamp.com/track/magic" target="_blank">Download HQ</a> / <a href="http://darkproject.co.in/ext/Dark_Project_-_Magic.mp3" target="_blank">Free</a></td></tr>
			<tr><td><a href="#music" onclick="inloadx('subdir=content&page=player.php&type=p&songid=totl','player');">Tale Of The Liars</a></td><td>Single</td><td><a href="http://darkproject.bandcamp.com/track/tale-of-the-liars" target="_blank">Download HQ</a> / <a href="http://darkproject.co.in/ext/Dark_Project_-_Tale_Of_The_Liars.mp3" target="_blank">Free</a></td></tr>
			<tr><td><a href="#music" onclick="inloadx('subdir=content&page=player.php&type=p&songid=otasl','player');">An Ode To A (Silent Lover)</a></td><td>Liberty & Entropy</td><td><a href="http://darkproject.bandcamp.com/track/an-ode-to-a-silent-lover" target="_blank">Download HQ</a></td></tr>
			<tr><td><a href="#music" onclick="inloadx('subdir=content&page=player.php&type=p&songid=soc','player');">Streak Of Coldness</a></td><td>Liberty & Entropy</td><td><a href="http://darkproject.bandcamp.com/track/streak-of-coldness" target="_blank">Download HQ</a></td></tr>
			<tr><td><a href="#music" onclick="inloadx('subdir=content&page=player.php&type=p&songid=drenched20','player');">Drenched 2.0</a></td><td>Chaos Sessions</td><td><a href="http://darkproject.bandcamp.com/track/drenched-2-0" target="_blank">Download HQ</a></td></tr>
			<tr><td colspan="3" align="right"><small><a href="#music" onclick="loadpage('music');">Click here for Lyrics</a></small></td></tr>
			</table>
		</div>-->
	</div>
</div>
</div>
<div class="main-body">
	<div class="left-menu">
		<ul class="left-menu-list">
			<li><a href="#feed" onclick="loadpage('news');">Feed</a></li>
			<li><a href="http://darkproject.bandcamp.com">Music</a></li>
			<li><a href="#band" onclick="loadpage('band');">Band</a></li>
			<li><a href="https://www.youtube.com/user/darkprojectband">Videos</a></li>
			<li><a href="https://www.facebook.com/darkprojectband">Contact</a></li>
		</ul>
		<!--<div class="facebook">
			<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/darkprojectband" height="450" width="150" show_faces="true" border="0px" border_color="" stream="false" header="true" colorscheme="light" border_color="#FFFFFF"></fb:like-box>
		</div> -->
	</div>
	<div class="main-content" id="main-content">
		<div><iframe class="youtube" id="youtube" height="480" src="//www.youtube.com/embed/MMStG365wZ4" frameborder="0" allowfullscreen></iframe></div>
		<div class="post-header">Latest Facebook Feed</div>
		<!--<div class="post-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</div>-->
		<div class="fb-content" id="fb-content"><?php include('feedgrabber.php'); include('content/fb.php'); ?></div>
		<!--<div class="post-header">Latest Facebook Entry</div>
		<div class="post-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</div>
		<div class="post-header">Latest User Feed</div>
		<div class="post-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</div>
		<div class="post-header">Latest Photographs</div>
		<div class="post-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</div>-->
	</div>
	<div class="right-content">
		<div class="adv-space">
			<a href="https://itunes.apple.com/in/album/long-way-from-home/id890047546" target=_new><img src="images/iTunes.jpg"/><br/>Buy <b><i>Long Way from Home</i></b> on iTunes</a><br/><br/>
			<a href="http://darkproject.bandcamp.com/merch/long-way-from-home-limited-edition-cds-ships-only-within-india" target=_new><img src="images/CDs.jpg"/><br/>Buy <b><i>Long Way from Home</i></b> limited edition CDs.<br/>(Ships only within India)</a><br/><br/>
			<iframe style="border: 0; width: 350px; height: 750px;" src="https://bandcamp.com/EmbeddedPlayer/album=173236859/size=large/bgcol=ffffff/linkcol=0687f5/transparent=true/" seamless><a href="http://darkproject.bandcamp.com/album/long-way-from-home">Long Way From Home by Dark Project</a></iframe><br>
		</div>
		<div class="twitter"><a class="twitter-timeline" href="https://twitter.com/darkprojectband" data-widget-id="416163778376388608" width="350" height="355">Tweets by @darkprojectband</a></div>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<div class="page-footer">
			&copy; 2004-2014 Dark Project and Associates. Dark Project is an alternative band from India. This site is best viewed in 1024x768 or higher resolution on a desktop browser that isn't Internet Explorer. Site created by 54UV1K.
		</div>
	</div>
</div>
</body>