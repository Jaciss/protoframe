<h3>Prototype Behaviour System</h3>
<p>The prototype library has everything needed to create a behaviour system...and then some.  Protoframe focuses on event bubbling, in what could be called the "Observer Pattern".  When an action is performed on a web page (like clicking  a link or button) that event bubbles up to any behaviours registered as observers, who can then react accordingly.  Prototype has built-in methods ala Event.observe() that take care of the nitpicky things, like unhooking event handlers.  We are left to focus on writing the behaviours, and defining when and where we'd like to use them.  The work is mostly done by the following loop:</p>

<pre class="code">
$(location).select(selector).each(function(element){
	Frame.behaviours[name][selector](element);
});
</pre>

<p>This will find all elements in 'location' (something like 'content') that match the CSS selector 'selector' (something like 'h1' or '.class') and loop through each one, adding a function to it.  In this way, we can register and apply behaviours wherever and whenever we'd like, with no inline javascript in sight!  Behaviours are defined like so:</p>

<pre class="code">
var behaviours = {
	'a[href^="?"]' : function(el){
		el.href = el.href.gsub(/\?/,'#');
	}
}
</pre>

<p>The above behaviour changes links prefaced with ? to links prefaced with # - allowing you to write your links in a standard way and modify them via javascript.  Browsers (or spiders) that don't support javascript won't get AJAX links.  Prototype will even emulate the above CSS2 selector for browsers that don't support it.  Not incidentally, this behaviour system plays nicely with the lovely <a href="http://www.bennolan.com/behaviour/">behaviour.js</a> by Ben Nolan and Simon Willison.</p>

<h3>Try It!</h3>
<p>The end idea is that you can use registerBehaviours(name,behaviours) then updateBehaviours(page_element,name) to create and modify behaviours specific to the areas and locations the user's action applies to.  The demo code looks something like this:</p>

<pre class=code>
var Site = {
	behaviours: new Array(),
    	
	registerBehaviours: function(name,behaviours){
		Site.behaviours[name] = behaviours;
	},
	updateBehaviours: function(location,name){
		for (selector in Site.behaviours[name]){
				$(location).select(selector).each(function(element){
				Site.behaviours[name][selector](element);
			});
		}
	},
	behaviours: {
		'a[href^="?"]' : function(el){
			//change local PHP style links to AJAX style links
			el.href = el.href.gsub(/\?/,'#');
			el.onclick = function(event){ 
				alert('Clicked on local link ' + el.toString());
			}
		}
	}
}
</pre>

<p>You could then use something like:</p>
<pre class=code>
Site.registerBehaviours('test_behaviours',Site.behaviours);
Site.updateBehaviours('test_behaviours','content');
</pre>
<p>to register and apply the behaviours defined in 'Site', thus changing all PHP style links to AJAX style links in the content area.  You can see an <a href="views/behaviours/behaviour_example.php">example using the above code here</a> or try <a href="javascript:Behaviour.registerBehaviours('behaviours', Behaviour.defaultBehaviours)">(re)registering the default behaviours</a> and then <a href="javascript:Behaviour.updateBehaviours('behaviours', 'content')">applying them</a>.  You can see these actions in the log at the bottom of the screen (move your mouse over the bar).</p>