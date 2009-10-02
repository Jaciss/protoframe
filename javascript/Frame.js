var Frame = {
	subdir: 'protoframe',		//the name of the directory protoframe is in, and the only thing you need to edit
	debug: 4,	//levels: 0=off, 1=errors, 2=warnings, 3=major events, 4=verbose
	lastURL: window.location.href,
	uri: '/',
	section: '',	
	modules: new Array(),
	activeModule: '',
	
	init: function(){
		Frame.start_time = new Date();
		Frame.log("<b>Frame:</b> initiating...",3);
		Behaviour.registerBehaviours('default',Behaviour.defaultBehaviours);
		//start the periodical executer that watches for URL changes:
		new PeriodicalExecuter(function(){Frame.checkLocation();},.2);
		//make the "working" image appear when ajax calls are occurring
		Ajax.Responders.register(Frame.ajaxHandlers);
		Frame.modifyView();
		Frame.updateBreadcrumbs();
		Behaviour.updateBehaviours('default','container');
		Frame.log("...init done.",3);
	},

	checkLocation: function(){
		if (window.location.href != Frame.lastURL) {
			Frame.start_time = new Date();
			Frame.log("Current URL doesn't match last URL.",4);
			Frame.lastURL = window.location.href;
			Frame.modifyView();
		}
	},
	
	modifyView: function(url){
 		if(!url) url = "" + document.location;	//Silly Safari needs "" to work in many cases.
 		//url = url.escapeHTML();		//just in case (IE doesn't like this?)
 		//split the url to find the area we're in and any request strings
		var urlArgs = url.split('/');
		Frame.uri = urlArgs[urlArgs.length-1];
		//if we aren't requesting something specific, get the index page
		if(Frame.uri==""){
			Frame.uri = 'index';
			module='home';
			Frame.activeModule='home';
			Frame.section='';
		}else{
			var module = urlArgs[urlArgs.length-2].sub('#', '', 1);
			Frame.section = '';
			if(urlArgs[urlArgs.length-3]) Frame.section = urlArgs[urlArgs.length-3].sub('#', '', 1);
			
			Frame.activeModule = module;
		}
		Frame.log("<b>URI: </b>"+Frame.uri+" ("+Frame.section+") and module "+module,1);
 		Frame.log("<b>View:</b> getting " + url,3);
 		
		//set the page title based on the URI (but not for silly IE)
		if(!Prototype.Browser.IE) title = document.domain + " : " + Frame.activeModule + " : " + Frame.uri;
		if(!Prototype.Browser.IE) document.title = title.gsub('/',' : ').gsub('_',' ');	//and make it pretty
		//execute or load the area's js (it will automatically initalize when loaded)
		Frame.modules[module] ? Frame.modules[module].execute(Frame.uri) : Frame.loadModule(module);
	
	},

	loadModule: function(module){
		if(Frame.modules[module]||Frame.uri=='') return;
		Frame.log("<b>Module:</b> " + module + " not loaded. Loading now...",3);
		Frame.modules[module] = new Module(module);
		var test = new Ajax.Request("javascript/" + module + ".js",{
			method: "get",
			onFailure: function(){
				Frame.log('<b>Module:</b> no JS found for '+module+', going with defaults.',1);
				Frame.modules[module].execute(Frame.uri);
			},
			onSuccess: function(req){
				eval(req.responseText);
				Frame.log('<b>Module</b>: '+module+' loaded, executing. ('+Frame.uri+')',1);
				Frame.modules[module].execute(Frame.uri);
			}
		});
	},
	
	log: function(message,level){
		if(Frame.debug>=level){
			//add the message to the debug area: 
			$('debug').innerHTML += (message + "<br/>\n");
			//"scroll" the debug frame to the bottom, so recent lines are always visible:
			$('debug').scrollTop = $('debug').scrollHeight;
		}
	},
	
	setContent: function(text){
		Frame.log('setting content...',1);
		$('content').update(text);
	},

	updateBreadcrumbs: function(){
		var breadcrumbs = '<a href="/">'+document.domain+'</a> : ';
		if(Frame.uri||!Frame.activeModule==document.domain) breadcrumbs += '<a href="./#'+Frame.activeModule+'/index">'+Frame.activeModule.gsub('_',' ')+'</a> : '+Frame.uri.gsub('_', ' ');
		else breadcrumbs += 'index';
		$('breadcrumbs').innerHTML = breadcrumbs;
	},
	toggle: function(element, method){
		//"method" can be appear, slide, or blind - cookies can be added here to 'remember'
		Effect.toggle(element, method);
	},
	updateTimer: function(){
		end_time = new Date();
		gen_time = end_time.getTime() - Frame.start_time.getTime();
		$('js_exe_time').innerHTML = gen_time+' ms';
		return gen_time;
	},

	ajaxHandlers: {
		onCreate: function(){
			//document.body.style.cursor = "wait";
			$('working').innerHTML = 'Working...';
			Element.show('working');
		},
	
		onComplete: function() {
			if(Ajax.activeRequestCount == 0){
				//document.body.style.cursor = "default";
				Element.hide('working');
			}
		}
	}
};

//this is a default module for ease of use.  It's methods can be overwritten.
var Module = Class.create();
Module.prototype = {
	initialize: function(name){
		this.name = name;
		Frame.log('<b>'+this.name+' module ready</b>...',4);
	},
	execute: function(url){
		Frame.log('<b>'+this.name+' module executing</b>.',4);
		if(this.name==url) url="index";
		if(Frame.section && !Frame.section.match(Frame.subdir)) this.url = Frame.section+'/'+this.name;
		else this.url = this.name;
		Frame.log('<b>'+this.name+'</b> ajaxing in views/'+this.url+'/'+url,1);
		var page = "views/"+this.url+"/"+url+".php";
		new Ajax.Request(page, {
			evalScripts:true, 
			onSuccess: function(req){
				Frame.updateBreadcrumbs();
				Frame.setContent(req.responseText);
				if(Frame.modules[Frame.activeModule].behaviours){
					Behaviour.registerBehaviours(Frame.activeModule,Frame.modules[Frame.activeModule].behaviours);
					Behaviour.updateBehaviours(Frame.activeModule,'content');
				}
				Behaviour.updateBehaviours('default','content');
				var gen_time = Frame.updateTimer();
				Frame.log('...done! ('+gen_time+' ms)',3);
			}
		});
	}
}


var Behaviour = {
	behaviours: new Array(),
    	
	registerBehaviours: function(module,behaviours){
		if(Behaviour.behaviours[module]) return;
		Frame.log('<b>Behaviour:</b> registering new behaviour(s) for: '+module,3);
		Behaviour.behaviours[module] = behaviours;
	},

	updateBehaviours: function(module,location){
 		Frame.log('<b>Behaviour:</b> applying behaviours for '+module+' to '+location,3);
		for (selector in Behaviour.behaviours[module]){
			var eles = $(location).getElementsBySelector(selector);
			//Frame.log('<b>Behaviour:</b> applying <i>'+selector+'</i> to '+eles.size()+ 'element(s)',1);
			eles.each(function(element){Behaviour.behaviours[module][selector](element);});

		}
		Frame.log('...behaviours updated.',3);
	},
	submitForm: function(el,cereal){
		Frame.log("<b>Behaviour:</b> form cereal: " + cereal,4);
		//disable the button while it's working
		el.disabled= true;
		Frame.log("<b>Behaviour:</b> ajax cereal to: " + Frame.activeModule + '.php',4);
		//a(pple)jax the form info to the section's controller file, PHP in my case
		new Ajax.Request("controllers/"+Frame.activeModule+".php",{
			postBody:cereal,
			onFailure: function(){
				el.value= 'error';
				el.disabled=false;
				Frame.log('Failed with post cereal! '+cereal+'-'+Frame.activeModule,1);
			},
			onSuccess: function(req){
				el.disabled = false;
				//get the 'output' area in the same div this form is in, and put response there
				Frame.log('Success: '+Frame.activeModule+' got post cereal. (Yum!)'+cereal,1);
				Frame.log('Said: '+req.responseText,1);
				el.up('div').down('.output').innerHTML = req.responseText;
				Behaviour.updateBehaviours('default', el.up('div').down('.output'));
				if(el.className=='reload') window.location.reload( true );
			}
		});
	},

	defaultBehaviours: {
		'a[href^="?"]' : function(el){
			//if it's a local link change PHP style links to AJAX style links
			el.href = ''+el.href.sub(/\?/,'#');	//again, add "" for Safari
		},
		'input[type="text"]': function(el){
			el.onkeypress = function(event){
				//have they hit enter?
				var keycode;
				if (window.event) keycode = window.event.keyCode;
				else if (event) keycode = event.which;
				else return true;
				
				if (keycode == 13){
					Frame.log("<b>Behaviour:</b> enter on input " + el.toString(),4);
					//serialize the form this element belongs to and assign the action
					var cereal = el.parentNode.serialize()+'&action='+el.parentNode.name;
					Behaviour.submitForm(el,cereal);
					if(el.type=="text") el.value='';
					return false;
				}else return true;
			}
		},
		'input[type="button"]': function(el){
			if(!el.onclick) el.onclick = function(event){
				Frame.log("<b>Behaviour:</b> clicked button element " + el.name,4);
				//serialize information in the form the button belongs to
				var cereal = el.up('form').serialize()+'&action='+el.name;
				Behaviour.submitForm(el,cereal);
			}
		},
		'input[type="submit"]':function(el){
			el.onclick = function(){
				el.parentNode.submit();
			}
		},
		'.alphanumeric': function(el){
			Event.observe(el, 'blur', function(event){
				var regex = /^[A-Za-z0-9\ ]+$/;
				if(!regex.test(el.value) && el.value!=''){
					el.style.backgroundColor = "#f00";
					new Insertion.After(el,' Alphanumeric characters only');
				}else el.style.backgroundColor = '';
			});
		},
		'.numeric': function(el){
			Event.observe(el, 'keyup', function(event){
				var regex = /^[0-9]+$/;
				if(!regex.test(el.value) && el.value!=''){
					el.style.backgroundColor = "#f00";
					new Insertion.After(el,' Numeric characters only');
				}else el.style.backgroundColor = '';
			});
		},
		'.required': function(el){
			Event.observe(el, 'blur', function(event){
				if(el.value==''||!el.value){
					el.style.backgroundColor = "#f00";
					new Insertion.After(el,' This is a required field');
				}else el.style.backgroundColor = '';
			});
		},
		'navigation<li': function(el){
			//if people weren't using IE, this wouldn't be necessary
			Event.observe(el, 'mouseover', function() {
				el.addClassName("sfhover");
			});
			Event.observe(el, 'mouseout', function() {
				el.removeClassName("sfhover");
			});
		}
	}
}


