/*!
 * ClockPicker v0.0.3 (http://weareoutman.github.io/clockpicker/)
 * Copyright 2014 Wang Shenwei.
 * Licensed under MIT (https://github.com/weareoutman/clockpicker/blob/master/LICENSE)
 */
!function(){function t(t){return document.createElementNS(a,t)}function i(t){return(10>t?"0":"")+t}function e(t){var i=++g+"";return t?t+i:i}function s(s,n){function a(t,i){var e=l.offset(),s=/^touch/.test(t.type),c=e.left+f,a=e.top+f,p=(s?t.originalEvent.touches[0]:t).pageX-c,u=(s?t.originalEvent.touches[0]:t).pageY-a,v=Math.sqrt(p*p+u*u),g=!1;if(!i||!(b-w>v||v>b+w)){t.preventDefault();var m=setTimeout(function(){o.addClass("clockpicker-moving")},200);h&&l.append(x.canvas),x.setHand(p,u,!i,!0),r.off(d+".clockpicker").on(d+".clockpicker",function(t){t.preventDefault();var i=(s?t.originalEvent.touches[0]:t).pageX-c,e=(s?t.originalEvent.touches[0]:t).pageY-a;(g||i!==p||e!==u)&&(g=!0,x.setHand(i,e,!1,!0))}),r.off(k+".clockpicker").one(k+".clockpicker",function(t){t.preventDefault();var e=(s?t.originalEvent.changedTouches[0]:t).pageX-c,h=(s?t.originalEvent.changedTouches[0]:t).pageY-a;(i||g)&&e===p&&h===u&&x.setHand(e,h),"hours"===x.currentView?x.toggleView("minutes",A/2):n.autoclose&&(x.minutesView.addClass("clockpicker-dial-out"),setTimeout(function(){x.done()},A/2)),l.prepend(z),clearTimeout(m),o.removeClass("clockpicker-moving"),r.off(d+".clockpicker")})}}var p=c(V),l=p.find(".clockpicker-plate"),v=p.find(".clockpicker-hours"),g=p.find(".clockpicker-minutes"),M="INPUT"===s.prop("tagName"),T=M?s:s.find("input"),C=s.find(".input-group-addon"),x=this;this.id=e("cp"),this.element=s,this.options=n,this.isAppended=!1,this.isShown=!1,this.currentView="hours",this.isInput=M,this.input=T,this.addon=C,this.popover=p,this.plate=l,this.hoursView=v,this.minutesView=g,this.spanHours=p.find(".clockpicker-span-hours"),this.spanMinutes=p.find(".clockpicker-span-minutes"),n.autoclose||c('<button type="button" class="btn btn-sm btn-default btn-block clockpicker-button">'+n.donetext+"</button>").click(c.proxy(this.done,this)).appendTo(p),p.addClass(n.placement),p.addClass("clockpicker-align-"+n.align),this.spanHours.click(c.proxy(this.toggleView,this,"hours")),this.spanMinutes.click(c.proxy(this.toggleView,this,"minutes")),T.on("focus.clockpicker",c.proxy(this.show,this)),C.on("click.clockpicker",c.proxy(this.toggle,this));var H,E,S,I=c('<div class="clockpicker-tick"></div>');for(H=0;24>H;H+=1){E=I.clone(),S=H/6*Math.PI;var P=H>0&&13>H,D=P?m:b;E.css({left:f+Math.sin(S)*D-w,top:f-Math.cos(S)*D-w}),P&&E.css("font-size","120%"),E.html(0===H?"00":H),v.append(E),E.on(u,a)}for(H=0;60>H;H+=5)E=I.clone(),S=H/30*Math.PI,E.css({left:f+Math.sin(S)*b-w,top:f-Math.cos(S)*b-w}),E.css("font-size","120%"),E.html(i(H)),g.append(E),E.on(u,a);if(g.on(u,function(t){0===c(t.target).closest(".clockpicker-tick").length&&a(t,!0)}),h){var z=p.find(".clockpicker-canvas"),B=t("svg");B.setAttribute("class","clockpicker-svg"),B.setAttribute("width",y),B.setAttribute("height",y);var L=t("g");L.setAttribute("transform","translate("+f+","+f+")");var U=t("circle");U.setAttribute("class","clockpicker-canvas-bearing"),U.setAttribute("cx",0),U.setAttribute("cy",0),U.setAttribute("r",2);var W=t("line");W.setAttribute("x1",0),W.setAttribute("y1",0);var N=t("circle");N.setAttribute("class","clockpicker-canvas-bg"),N.setAttribute("r",w);var X=t("circle");X.setAttribute("class","clockpicker-canvas-fg"),X.setAttribute("r",3.5),L.appendChild(W),L.appendChild(N),L.appendChild(X),L.appendChild(U),B.appendChild(L),z.append(B),this.hand=W,this.bg=N,this.fg=X,this.bearing=U,this.g=L,this.canvas=z}}var o,c=window.$,n=c(window),r=c(document),a="http://www.w3.org/2000/svg",h="SVGAngle"in window&&function(){var t,i=document.createElement("div");return i.innerHTML="<svg/>",t=(i.firstChild&&i.firstChild.namespaceURI)==a,i.innerHTML="",t}(),p=function(){var t=document.createElement("div").style;return"transition"in t||"WebkitTransition"in t||"MozTransition"in t||"msTransition"in t||"OTransition"in t}(),l="ontouchstart"in window,u=l?"touchstart":"mousedown",d=l?"touchmove":"mousemove",k=l?"touchend":"mouseup",v=navigator.vibrate?"vibrate":navigator.webkitVibrate?"webkitVibrate":null,g=0,f=100,b=80,m=54,w=13,y=2*f,A=p?350:1,V=['<div class="popover clockpicker-popover">','<div class="arrow"></div>','<div class="popover-title">','<span class="clockpicker-span-hours text-primary"></span>'," : ",'<span class="clockpicker-span-minutes"></span>',"</div>",'<div class="popover-content">','<div class="clockpicker-plate">','<div class="clockpicker-canvas"></div>','<div class="clockpicker-dial clockpicker-hours"></div>','<div class="clockpicker-dial clockpicker-minutes clockpicker-dial-out"></div>',"</div>","</div>","</div>"].join("");s.DEFAULTS={"default":"",placement:"bottom",align:"left",donetext:"完成",autoclose:!1,vibrate:!0},s.prototype.toggle=function(){this[this.isShown?"hide":"show"]()},s.prototype.locate=function(){var t=this.element,i=this.popover,e=t.offset(),s=t.outerWidth(),o=t.outerHeight(),c=this.options.placement,n=this.options.align,r={};switch(i.show(),c){case"bottom":r.top=e.top+o;break;case"right":r.left=e.left+s;break;case"top":r.top=e.top-i.outerHeight();break;case"left":r.left=e.left-i.outerWidth()}switch(n){case"left":r.left=e.left;break;case"right":r.left=e.left+s-i.outerWidth();break;case"top":r.top=e.top;break;case"bottom":r.top=e.top+o-i.outerHeight()}i.css(r)},s.prototype.show=function(){if(!this.isShown){var t=this;this.isAppended||(o=c(document.body).append(this.popover),n.on("resize.clockpicker",function(){t.isShown&&t.locate()}),this.isAppended=!0);var e=((this.input.prop("value")||this.options["default"]||"")+"").split(":");this.hours=+e[0]||0,this.minutes=+e[1]||0,this.spanHours.html(i(this.hours)),this.spanMinutes.html(i(this.minutes)),this.toggleView("hours"),this.locate(),this.isShown=!0,r.on("click.clockpicker."+this.id,function(i){var e=c(i.target);0===e.closest(".clockpicker-popover").length&&0===e.closest(t.addon).length&&0===e.closest(t.input).length&&t.hide()}),r.on("keyup.clockpicker."+this.id,function(i){27===i.keyCode&&t.hide()})}},s.prototype.hide=function(){this.isShown=!1,r.off("click.clockpicker."+this.id),r.off("keyup.clockpicker."+this.id),this.popover.hide()},s.prototype.toggleView=function(t,i){var e="hours"===t,s=e?this.hoursView:this.minutesView,o=e?this.minutesView:this.hoursView;this.currentView=t,this.spanHours.toggleClass("text-primary",e),this.spanMinutes.toggleClass("text-primary",!e),o.addClass("clockpicker-dial-out"),s.css("visibility","visible").removeClass("clockpicker-dial-out"),this.resetClock(i),clearTimeout(this.toggleViewTimer),this.toggleViewTimer=setTimeout(function(){o.css("visibility","hidden")},A)},s.prototype.resetClock=function(t){var i=this.currentView,e=this[i],s="hours"===i,o=Math.PI/(s?6:30),c=e*o,n=s&&e>0&&13>e?m:b,r=Math.sin(c)*n,a=-Math.cos(c)*n,p=this;h&&t?(p.canvas.addClass("clockpicker-canvas-out"),setTimeout(function(){p.canvas.removeClass("clockpicker-canvas-out"),p.setHand(r,a)},t)):this.setHand(r,a)},s.prototype.setHand=function(t,e,s,o){var n,r=Math.atan2(t,-e),a="hours"===this.currentView,p=Math.PI/(a||s?6:30),l=Math.sqrt(t*t+e*e),u=(this.options,a&&(b+m)/2>l),d=u?m:b;if(0>r&&(r=2*Math.PI+r),n=Math.round(r/p),r=n*p,a?(12===n&&(n=0),n=u?0===n?12:n:0===n?0:n+12):(s&&(n*=5),60===n&&(n=0)),this[this.currentView]!==n&&v&&(this.vibrateTimer||(navigator[v](10),this.vibrateTimer=setTimeout(c.proxy(function(){this.vibrateTimer=null},this),100))),this[this.currentView]=n,this[a?"spanHours":"spanMinutes"].html(i(n)),!h)return void this[a?"hoursView":"minutesView"].find(".clockpicker-tick").each(function(){var t=c(this);t.toggleClass("active",n===+t.html())});o||!a&&n%5?(this.g.insertBefore(this.hand,this.bearing),this.g.insertBefore(this.bg,this.fg),this.bg.setAttribute("class","clockpicker-canvas-bg clockpicker-canvas-bg-trans")):(this.g.insertBefore(this.hand,this.bg),this.g.insertBefore(this.fg,this.bg),this.bg.setAttribute("class","clockpicker-canvas-bg"));var k=Math.sin(r)*d,g=-Math.cos(r)*d;this.hand.setAttribute("x2",k),this.hand.setAttribute("y2",g),this.bg.setAttribute("cx",k),this.bg.setAttribute("cy",g),this.fg.setAttribute("cx",k),this.fg.setAttribute("cy",g)},s.prototype.done=function(){this.hide();var t=this.input.prop("value"),e=i(this.hours)+":"+i(this.minutes);this.input.prop("value",e),e!==t&&(this.input.triggerHandler("change"),this.isInput||this.element.trigger("change"))},c.fn.clockpicker=function(t){return this.each(function(){var i=c(this),e=i.data("clockpicker");if(!e){var o=c.extend({},s.DEFAULTS,i.data(),"object"==typeof t&&t);i.data("clockpicker",new s(i,o))}})}}();