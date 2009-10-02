<h3>A Small Solution</h3>
<p>Welcome to the demo of protoframe - a tiny AJAX-based framework utilizing the <a href="http://prototypejs.org">prototype javascript library</a> and an MVC oriented approach.  Protoframe, in essence, is just a system that responds to user actions with behaviours defined for those actions.  Actions are controlled by registering and applying behaviours - for links, buttons, or any element that can be defined with a CSS selector (like h1, .class, or #id).  E.g., a user clicks on a link and new content is loaded and displayed via AJAX.  To avoid loading massive amounts of javascript, each section of the site (directory) can define behaviours in a section-name.js file in the 'javascript' directory.  These files are 'cached' and only loaded if the user visits that section.  Of course, the framework has defaults so if nothing special is required nothing needs to be defined.</p>

<div class="morelinks">>> <a href="http://github.com/Jaciss/protoframe">Download Protoframe 0.6</a> &nbsp; >> <a href="?about/index">Read More</a></div>

<h4>Features</h4>
<p>
	<ul id="biglinks">
		<li><a href="javascript/Frame.js">View Javascript (/javascript/Frame.js)</a></li>
		<li><a href="index.inc.php">View Base Page (index.php)</a></li>
		<li><a href="models/Frame.inc.php">View PHP (/models/Frame.php)</a></li>
	</ul>
	
	<ul>
		<li>small and simple</li>
		<li>data only loaded as needed</li>
		<li>degrades gracefully (js not required)</li>
		<li><a href="?behaviours/index">behaviour system</a></li>
		<li>log console for easy debugging</li>
		<li>pages require only basic <acronym title="Hypertext Markup Language">HTML</acronym> (<a href="views/index.inc.php">this page</a>)</li>
		<li>menus are automatically generated</li>
		<!--<li>works with javascript disabled</li>-->
		<li>Frame.js can use asp, html, etc</li>
	</ul>
</p>

<h3>Another Approach</h3>
<p>What defines protoframe is perhaps more what it isn't than what it is.  It's small - it doesn't do much, and doesn't get in the way or take months to fully understand.  It doesn't break the way the web works.  Bookmarks, the back button, history, even links are what they were meant to be.  It doesn't use or lend itself to inline javascript.  It doesn't require any specific server-side language (like PHP).  </p>
