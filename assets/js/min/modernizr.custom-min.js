window.Modernizr=function(e,t,n){function r(e){v.cssText=e}function o(e,t){return r(x.join(e+";")+(t||""))}function i(e,t){return typeof e===t}function a(e,t){return!!~(""+e).indexOf(t)}function c(e,t){for(var r in e){var o=e[r];if(!a(o,"-")&&v[o]!==n)return"pfx"==t?o:!0}return!1}function l(e,t,r){for(var o in e){var a=t[e[o]];if(a!==n)return r===!1?e[o]:i(a,"function")?a.bind(r||t):a}return!1}function s(e,t,n){var r=e.charAt(0).toUpperCase()+e.slice(1),o=(e+" "+w.join(r+" ")+r).split(" ");return i(t,"string")||i(t,"undefined")?c(o,t):(o=(e+" "+S.join(r+" ")+r).split(" "),l(o,t,n))}function u(){d.input=function(n){for(var r=0,o=n.length;o>r;r++)T[n[r]]=n[r]in y;return T.list&&(T.list=!!t.createElement("datalist")&&!!e.HTMLDataListElement),T}("autocomplete autofocus list placeholder max min multiple pattern required step".split(" ")),d.inputtypes=function(e){for(var r=0,o,i,a,c=e.length;c>r;r++)y.setAttribute("type",i=e[r]),o="text"!==y.type,o&&(y.value=b,y.style.cssText="position:absolute;visibility:hidden;",/^range$/.test(i)&&y.style.WebkitAppearance!==n?(m.appendChild(y),a=t.defaultView,o=a.getComputedStyle&&"textfield"!==a.getComputedStyle(y,null).WebkitAppearance&&0!==y.offsetHeight,m.removeChild(y)):/^(search|tel)$/.test(i)||(o=/^(url|email)$/.test(i)?y.checkValidity&&y.checkValidity()===!1:y.value!=b)),N[e[r]]=!!o;return N}("search tel url email datetime date month week time datetime-local number range color".split(" "))}var f="2.8.3",d={},p=!0,m=t.documentElement,h="modernizr",g=t.createElement(h),v=g.style,y=t.createElement("input"),b=":)",E={}.toString,x=" -webkit- -moz- -o- -ms- ".split(" "),C="Webkit Moz O ms",w=C.split(" "),S=C.toLowerCase().split(" "),j={svg:"http://www.w3.org/2000/svg"},k={},N={},T={},F=[],M=F.slice,L,O=function(e,n,r,o){var i,a,c,l,s=t.createElement("div"),u=t.body,f=u||t.createElement("body");if(parseInt(r,10))for(;r--;)c=t.createElement("div"),c.id=o?o[r]:h+(r+1),s.appendChild(c);return i=["&#173;",'<style id="s',h,'">',e,"</style>"].join(""),s.id=h,(u?s:f).innerHTML+=i,f.appendChild(s),u||(f.style.background="",f.style.overflow="hidden",l=m.style.overflow,m.style.overflow="hidden",m.appendChild(f)),a=n(s,e),u?s.parentNode.removeChild(s):(f.parentNode.removeChild(f),m.style.overflow=l),!!a},z={}.hasOwnProperty,D;D=i(z,"undefined")||i(z.call,"undefined")?function(e,t){return t in e&&i(e.constructor.prototype[t],"undefined")}:function(e,t){return z.call(e,t)},Function.prototype.bind||(Function.prototype.bind=function(e){var t=this;if("function"!=typeof t)throw new TypeError;var n=M.call(arguments,1),r=function(){if(this instanceof r){var o=function(){};o.prototype=t.prototype;var i=new o,a=t.apply(i,n.concat(M.call(arguments)));return Object(a)===a?a:i}return t.apply(e,n.concat(M.call(arguments)))};return r}),k.flexbox=function(){return s("flexWrap")},k.flexboxlegacy=function(){return s("boxDirection")},k.canvas=function(){var e=t.createElement("canvas");return!!e.getContext&&!!e.getContext("2d")},k.canvastext=function(){return!!d.canvas&&!!i(t.createElement("canvas").getContext("2d").fillText,"function")},k.touch=function(){var n;return"ontouchstart"in e||e.DocumentTouch&&t instanceof DocumentTouch?n=!0:O(["@media (",x.join("touch-enabled),("),h,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(e){n=9===e.offsetTop}),n},k.geolocation=function(){return"geolocation"in navigator},k.rgba=function(){return r("background-color:rgba(150,255,150,.5)"),a(v.backgroundColor,"rgba")},k.hsla=function(){return r("background-color:hsla(120,40%,100%,.5)"),a(v.backgroundColor,"rgba")||a(v.backgroundColor,"hsla")},k.backgroundsize=function(){return s("backgroundSize")},k.borderimage=function(){return s("borderImage")},k.borderradius=function(){return s("borderRadius")},k.boxshadow=function(){return s("boxShadow")},k.textshadow=function(){return""===t.createElement("div").style.textShadow},k.opacity=function(){return o("opacity:.55"),/^0.55$/.test(v.opacity)},k.cssanimations=function(){return s("animationName")},k.csscolumns=function(){return s("columnCount")},k.cssgradients=function(){var e="background-image:",t="gradient(linear,left top,right bottom,from(#9f9),to(white));",n="linear-gradient(left top,#9f9, white);";return r((e+"-webkit- ".split(" ").join(t+e)+x.join(n+e)).slice(0,-e.length)),a(v.backgroundImage,"gradient")},k.csstransitions=function(){return s("transition")},k.fontface=function(){var e;return O('@font-face {font-family:"font";src:url("https://")}',function(n,r){var o=t.getElementById("smodernizr"),i=o.sheet||o.styleSheet,a=i?i.cssRules&&i.cssRules[0]?i.cssRules[0].cssText:i.cssText||"":"";e=/src/i.test(a)&&0===a.indexOf(r.split(" ")[0])}),e},k.generatedcontent=function(){var e;return O(["#",h,"{font:0/0 a}#",h,':after{content:"',b,'";visibility:hidden;font:3px/1 a}'].join(""),function(t){e=t.offsetHeight>=3}),e},k.svg=function(){return!!t.createElementNS&&!!t.createElementNS(j.svg,"svg").createSVGRect},k.inlinesvg=function(){var e=t.createElement("div");return e.innerHTML="<svg/>",(e.firstChild&&e.firstChild.namespaceURI)==j.svg},k.svgclippaths=function(){return!!t.createElementNS&&/SVGClipPath/.test(E.call(t.createElementNS(j.svg,"clipPath")))};for(var A in k)D(k,A)&&(L=A.toLowerCase(),d[L]=k[A](),F.push((d[L]?"":"no-")+L));return d.input||u(),d.addTest=function(e,t){if("object"==typeof e)for(var r in e)D(e,r)&&d.addTest(r,e[r]);else{if(e=e.toLowerCase(),d[e]!==n)return d;t="function"==typeof t?t():t,"undefined"!=typeof p&&p&&(m.className+=" "+(t?"":"no-")+e),d[e]=t}return d},r(""),g=y=null,function(e,t){function n(e,t){var n=e.createElement("p"),r=e.getElementsByTagName("head")[0]||e.documentElement;return n.innerHTML="x<style>"+t+"</style>",r.insertBefore(n.lastChild,r.firstChild)}function r(){var e=y.elements;return"string"==typeof e?e.split(" "):e}function o(e){var t=g[e[m]];return t||(t={},h++,e[m]=h,g[h]=t),t}function i(e,n,r){if(n||(n=t),v)return n.createElement(e);r||(r=o(n));var i;return i=r.cache[e]?r.cache[e].cloneNode():d.test(e)?(r.cache[e]=r.createElem(e)).cloneNode():r.createElem(e),!i.canHaveChildren||f.test(e)||i.tagUrn?i:r.frag.appendChild(i)}function a(e,n){if(e||(e=t),v)return e.createDocumentFragment();n=n||o(e);for(var i=n.frag.cloneNode(),a=0,c=r(),l=c.length;l>a;a++)i.createElement(c[a]);return i}function c(e,t){t.cache||(t.cache={},t.createElem=e.createElement,t.createFrag=e.createDocumentFragment,t.frag=t.createFrag()),e.createElement=function(n){return y.shivMethods?i(n,e,t):t.createElem(n)},e.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+r().join().replace(/[\w\-]+/g,function(e){return t.createElem(e),t.frag.createElement(e),'c("'+e+'")'})+");return n}")(y,t.frag)}function l(e){e||(e=t);var r=o(e);return y.shivCSS&&!p&&!r.hasCSS&&(r.hasCSS=!!n(e,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),v||c(e,r),e}var s="3.7.0",u=e.html5||{},f=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,d=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,p,m="_html5shiv",h=0,g={},v;!function(){try{var e=t.createElement("a");e.innerHTML="<xyz></xyz>",p="hidden"in e,v=1==e.childNodes.length||function(){t.createElement("a");var e=t.createDocumentFragment();return"undefined"==typeof e.cloneNode||"undefined"==typeof e.createDocumentFragment||"undefined"==typeof e.createElement}()}catch(n){p=!0,v=!0}}();var y={elements:u.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:s,shivCSS:u.shivCSS!==!1,supportsUnknownElements:v,shivMethods:u.shivMethods!==!1,type:"default",shivDocument:l,createElement:i,createDocumentFragment:a};e.html5=y,l(t)}(this,t),d._version=f,d._prefixes=x,d._domPrefixes=S,d._cssomPrefixes=w,d.testProp=function(e){return c([e])},d.testAllProps=s,d.testStyles=O,m.className=m.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(p?" js "+F.join(" "):""),d}(this,this.document),function(e,t,n){function r(e){return"[object Function]"==m.call(e)}function o(e){return"string"==typeof e}function i(){}function a(e){return!e||"loaded"==e||"complete"==e||"uninitialized"==e}function c(){var e=h.shift();g=1,e?e.t?d(function(){("c"==e.t?N.injectCss:N.injectJs)(e.s,0,e.a,e.x,e.e,1)},0):(e(),c()):g=0}function l(e,n,r,o,i,l,s){function u(t){if(!m&&a(f.readyState)&&(E.r=m=1,!g&&c(),f.onload=f.onreadystatechange=null,t)){"img"!=e&&d(function(){b.removeChild(f)},50);for(var r in S[n])S[n].hasOwnProperty(r)&&S[n][r].onload()}}var s=s||N.errorTimeout,f=t.createElement(e),m=0,v=0,E={t:r,s:n,e:i,a:l,x:s};1===S[n]&&(v=1,S[n]=[]),"object"==e?f.data=n:(f.src=n,f.type=e),f.width=f.height="0",f.onerror=f.onload=f.onreadystatechange=function(){u.call(this,v)},h.splice(o,0,E),"img"!=e&&(v||2===S[n]?(b.insertBefore(f,y?null:p),d(u,s)):S[n].push(f))}function s(e,t,n,r,i){return g=0,t=t||"j",o(e)?l("c"==t?x:E,e,t,this.i++,n,r,i):(h.splice(this.i++,0,e),1==h.length&&c()),this}function u(){var e=N;return e.loader={load:s,i:0},e}var f=t.documentElement,d=e.setTimeout,p=t.getElementsByTagName("script")[0],m={}.toString,h=[],g=0,v="MozAppearance"in f.style,y=v&&!!t.createRange().compareNode,b=y?f:p.parentNode,f=e.opera&&"[object Opera]"==m.call(e.opera),f=!!t.attachEvent&&!f,E=v?"object":f?"script":"img",x=f?"script":E,C=Array.isArray||function(e){return"[object Array]"==m.call(e)},w=[],S={},j={timeout:function(e,t){return t.length&&(e.timeout=t[0]),e}},k,N;N=function(e){function t(e){var e=e.split("!"),t=w.length,n=e.pop(),r=e.length,n={url:n,origUrl:n,prefixes:e},o,i,a;for(i=0;r>i;i++)a=e[i].split("="),(o=j[a.shift()])&&(n=o(n,a));for(i=0;t>i;i++)n=w[i](n);return n}function a(e,o,i,a,c){var l=t(e),s=l.autoCallback;l.url.split(".").pop().split("?").shift(),l.bypass||(o&&(o=r(o)?o:o[e]||o[a]||o[e.split("/").pop().split("?")[0]]),l.instead?l.instead(e,o,i,a,c):(S[l.url]?l.noexec=!0:S[l.url]=1,i.load(l.url,l.forceCSS||!l.forceJS&&"css"==l.url.split(".").pop().split("?").shift()?"c":n,l.noexec,l.attrs,l.timeout),(r(o)||r(s))&&i.load(function(){u(),o&&o(l.origUrl,c,a),s&&s(l.origUrl,c,a),S[l.url]=2})))}function c(e,t){function n(e,n){if(e){if(o(e))n||(s=function(){var e=[].slice.call(arguments);u.apply(this,e),f()}),a(e,s,t,0,c);else if(Object(e)===e)for(p in d=function(){var t=0,n;for(n in e)e.hasOwnProperty(n)&&t++;return t}(),e)e.hasOwnProperty(p)&&(!n&&!--d&&(r(s)?s=function(){var e=[].slice.call(arguments);u.apply(this,e),f()}:s[p]=function(e){return function(){var t=[].slice.call(arguments);e&&e.apply(this,t),f()}}(u[p])),a(e[p],s,t,p,c))}else!n&&f()}var c=!!e.test,l=e.load||e.both,s=e.callback||i,u=s,f=e.complete||i,d,p;n(c?e.yep:e.nope,!!l),l&&n(l)}var l,s,f=this.yepnope.loader;if(o(e))a(e,0,f,0);else if(C(e))for(l=0;l<e.length;l++)s=e[l],o(s)?a(s,0,f,0):C(s)?N(s):Object(s)===s&&c(s,f);else Object(e)===e&&c(e,f)},N.addPrefix=function(e,t){j[e]=t},N.addFilter=function(e){w.push(e)},N.errorTimeout=1e4,null==t.readyState&&t.addEventListener&&(t.readyState="loading",t.addEventListener("DOMContentLoaded",k=function(){t.removeEventListener("DOMContentLoaded",k,0),t.readyState="complete"},0)),e.yepnope=u(),e.yepnope.executeStack=c,e.yepnope.injectJs=function(e,n,r,o,l,s){var u=t.createElement("script"),f,m,o=o||N.errorTimeout;u.src=e;for(m in r)u.setAttribute(m,r[m]);n=s?c:n||i,u.onreadystatechange=u.onload=function(){!f&&a(u.readyState)&&(f=1,n(),u.onload=u.onreadystatechange=null)},d(function(){f||(f=1,n(1))},o),l?u.onload():p.parentNode.insertBefore(u,p)},e.yepnope.injectCss=function(e,n,r,o,a,l){var o=t.createElement("link"),s,n=l?c:n||i;o.href=e,o.rel="stylesheet",o.type="text/css";for(s in r)o.setAttribute(s,r[s]);a||(p.parentNode.insertBefore(o,p),d(n,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};