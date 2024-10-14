!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&module.exports?module.exports=function(e,n){return void 0===n&&(n="undefined"!=typeof window?require("jquery"):require("jquery")(e)),t(n),n}:t(jQuery)}(function(t){"use strict";var e,n="drawsvg",a={duration:1e3,stagger:200,easing:"swing",reverse:!1,callback:t.noop},o=((e=function e(o,i){var r=this,s=t.extend(a,i);r.$elm=t(o),r.$elm.is("svg")&&(r.options=s,r.$paths=r.$elm.find("path, circle, rect, polygon"),r.totalDuration=s.duration+s.stagger*r.$paths.length,r.duration=s.duration/r.totalDuration,r.$paths.each(function(t,e){var n=e.getTotalLength();e.pathLen=n,e.delay=s.stagger*t/r.totalDuration,e.style.strokeDasharray=[n,n].join(" "),e.style.strokeDashoffset=n}),r.$elm.attr("class",function(t,e){return[e,n+"-initialized"].join(" ")}))}).prototype.getVal=function(e,n){return 1-t.easing[n](e,e,0,1,1)},e.prototype.progress=function t(e){var n=this,a=n.options,o=n.duration;n.$paths.each(function(t,i){var r=i.style;if(1===e)r.strokeDashoffset=0;else if(0===e)r.strokeDashoffset=i.pathLen+"px";else if(e>=i.delay&&e<=o+i.delay){var s=(e-i.delay)/o;r.strokeDashoffset=n.getVal(s,a.easing)*i.pathLen*(a.reverse?-1:1)+"px"}})},e.prototype.animate=function e(){var a=this;a.$elm.attr("class",function(t,e){return[e,n+"-animating"].join(" ")}),t({len:0}).animate({len:1},{easing:"linear",duration:a.totalDuration,step:function(t,e){a.progress.call(a,t/e.end)},complete:function(){a.options.callback.call(this),a.$elm.attr("class",function(t,e){return e.replace(n+"-animating","")})}})},e);t.fn[n]=function(e,a){return this.each(function(){var i=t.data(this,n);i&&""+e===e&&i[e]?i[e](a):t.data(this,n,new o(this,e))})}});!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=28)}({28:function(e,t){var r=function(e,t){var r,n,o=t(".eael-svg-draw-container",e),l=t("svg",o),a=o.data("settings"),s=a.speed,i=a.loop,f=a.pause,u=a.direction,c=a.offset,d=0,p=t(document),v=t(window),g=t("path, circle, rect, polygon",l),h=p.height()-v.height();function y(){var e=0,r="";if(t("path",l).each((function(){var n=t(this).css("stroke-dasharray"),o=parseInt(n);o>e&&(e=o,r=t(this))})),e<3999&&e/2>600&&"fill-svg"===a.fill){var n=r.css("stroke-dashoffset");(n=parseInt(n))<e/2&&o.addClass(a.fill)}}function w(){return y(),n?(d+=.01)>=1&&(n=!1,"fill-svg"===a.fill&&o.removeClass("fillout-svg").addClass(a.fill)):"restart"===u?(d=0,n=!0):(d-=.01)<=0&&(n=!0),d}if("yes"===a.excludeStyle&&g.attr("style",""),l.parent().hasClass("page-scroll"))v.on("scroll",(function(){var e=(v.scrollTop()-c)/h,t=l.offset().top,r=v.innerHeight(),n=t-r;t>v.scrollTop()&&n<v.scrollTop()&&(e=(v.scrollTop()-c-n)/r,l.drawsvg("progress",e)),y()}));else if(l.parent().hasClass("page-load"))var m="",b=setInterval((function(){var e=l.html();l.drawsvg("progress",w()),"no"===i&&w(),e===m&&"no"===i&&(o.addClass(a.fill),clearInterval(b)),m=e}),s);else if(l.parent().hasClass("hover")){var C="";l.hover((function(){"yes"!==f&&void 0!==r||(r=window.setInterval((function(){var e=l.html();l.drawsvg("progress",w()),e===C&&"no"===i&&(o.addClass(a.fill),window.clearInterval(r)),C=e}),s))}),(function(){"yes"===f&&window.clearInterval(r)}))}};jQuery(window).on("elementor/frontend/init",(function(){if(eael.elementStatusCheck("eaelDrawSVG"))return!1;elementorFrontend.hooks.addAction("frontend/element_ready/eael-svg-draw.default",r)}))}});