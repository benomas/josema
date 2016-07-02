/*
 HTML5 Shiv v3.6.2 | @afarkas @jdalton @jon_neal @rem | MIT/GPL2 Licensed
*/
(function(l,f){function m(){var a=e.elements;return"string"==typeof a?a.split(" "):a}function i(a){var b=n[a[o]];b||(b={},h++,a[o]=h,n[h]=b);return b}function p(a,b,c){b||(b=f);if(g)return b.createElement(a);c||(c=i(b));b=c.cache[a]?c.cache[a].cloneNode():r.test(a)?(c.cache[a]=c.createElem(a)).cloneNode():c.createElem(a);return b.canHaveChildren&&!s.test(a)?c.frag.appendChild(b):b}function t(a,b){if(!b.cache)b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag();
a.createElement=function(c){return!e.shivMethods?b.createElem(c):p(c,a,b)};a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/\w+/g,function(a){b.createElem(a);b.frag.createElement(a);return'c("'+a+'")'})+");return n}")(e,b.frag)}function q(a){a||(a=f);var b=i(a);if(e.shivCSS&&!j&&!b.hasCSS){var c,d=a;c=d.createElement("p");d=d.getElementsByTagName("head")[0]||d.documentElement;c.innerHTML="x<style>article,aside,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}</style>";
c=d.insertBefore(c.lastChild,d.firstChild);b.hasCSS=!!c}g||t(a,b);return a}var k=l.html5||{},s=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,r=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,j,o="_html5shiv",h=0,n={},g;(function(){try{var a=f.createElement("a");a.innerHTML="<xyz></xyz>";j="hidden"in a;var b;if(!(b=1==a.childNodes.length)){f.createElement("a");var c=f.createDocumentFragment();b="undefined"==typeof c.cloneNode||
"undefined"==typeof c.createDocumentFragment||"undefined"==typeof c.createElement}g=b}catch(d){g=j=!0}})();var e={elements:k.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup main mark meter nav output progress section summary time video",version:"3.6.2",shivCSS:!1!==k.shivCSS,supportsUnknownElements:g,shivMethods:!1!==k.shivMethods,type:"default",shivDocument:q,createElement:p,createDocumentFragment:function(a,b){a||(a=f);if(g)return a.createDocumentFragment();
for(var b=b||i(a),c=b.frag.cloneNode(),d=0,e=m(),h=e.length;d<h;d++)c.createElement(e[d]);return c}};l.html5=e;q(f)})(this,document);

/* Placeholders.js http://jamesallardice.github.io/Placeholders.js/ The MIT License */
(function(t){"use strict";function e(t,e,r){return t.addEventListener?t.addEventListener(e,r,!1):t.attachEvent?t.attachEvent("on"+e,r):void 0}function r(t,e){var r,n;for(r=0,n=t.length;n>r;r++)if(t[r]===e)return!0;return!1}function n(t,e){var r;t.createTextRange?(r=t.createTextRange(),r.move("character",e),r.select()):t.selectionStart&&(t.focus(),t.setSelectionRange(e,e))}function a(t,e){try{return t.type=e,!0}catch(r){return!1}}t.Placeholders={Utils:{addEventListener:e,inArray:r,moveCaret:n,changeType:a}}})(this),function(t){"use strict";function e(t){var e;return t.value===t.getAttribute(S)&&"true"===t.getAttribute(I)?(t.setAttribute(I,"false"),t.value="",t.className=t.className.replace(R,""),e=t.getAttribute(P),e&&(t.type=e),!0):!1}function r(t){var e;return""===t.value?(t.setAttribute(I,"true"),t.value=t.getAttribute(S),t.className+=" "+k,e=t.getAttribute(P),e?t.type="text":"password"===t.type&&H.changeType(t,"text")&&t.setAttribute(P,"password"),!0):!1}function n(t,e){var r,n,a,u,i;if(t&&t.getAttribute(S))e(t);else for(r=t?t.getElementsByTagName("input"):r,n=t?t.getElementsByTagName("textarea"):n,i=0,u=r.length+n.length;u>i;i++)a=r.length>i?r[i]:n[i-r.length],e(a)}function a(t){n(t,e)}function u(t){n(t,r)}function i(t){return function(){f&&t.value===t.getAttribute(S)&&"true"===t.getAttribute(I)?H.moveCaret(t,0):e(t)}}function l(t){return function(){r(t)}}function c(t){return function(e){return p=t.value,"true"===t.getAttribute(I)?!(p===t.getAttribute(S)&&H.inArray(C,e.keyCode)):void 0}}function o(t){return function(){var e;"true"===t.getAttribute(I)&&t.value!==p&&(t.className=t.className.replace(R,""),t.value=t.value.replace(t.getAttribute(S),""),t.setAttribute(I,!1),e=t.getAttribute(P),e&&(t.type=e)),""===t.value&&(t.blur(),H.moveCaret(t,0))}}function s(t){return function(){t===document.activeElement&&t.value===t.getAttribute(S)&&"true"===t.getAttribute(I)&&H.moveCaret(t,0)}}function d(t){return function(){a(t)}}function g(t){t.form&&(x=t.form,x.getAttribute(U)||(H.addEventListener(x,"submit",d(x)),x.setAttribute(U,"true"))),H.addEventListener(t,"focus",i(t)),H.addEventListener(t,"blur",l(t)),f&&(H.addEventListener(t,"keydown",c(t)),H.addEventListener(t,"keyup",o(t)),H.addEventListener(t,"click",s(t))),t.setAttribute(j,"true"),t.setAttribute(S,y),r(t)}var v,b,f,h,p,m,A,y,E,x,T,N,L,w=["text","search","url","tel","email","password","number","textarea"],C=[27,33,34,35,36,37,38,39,40,8,46],B="#ccc",k="placeholdersjs",R=RegExp("\\b"+k+"\\b"),S="data-placeholder-value",I="data-placeholder-active",P="data-placeholder-type",U="data-placeholder-submit",j="data-placeholder-bound",V="data-placeholder-focus",q="data-placeholder-live",z=document.createElement("input"),D=document.getElementsByTagName("head")[0],F=document.documentElement,G=t.Placeholders,H=G.Utils;if(void 0===z.placeholder){for(v=document.getElementsByTagName("input"),b=document.getElementsByTagName("textarea"),f="false"===F.getAttribute(V),h="false"!==F.getAttribute(q),m=document.createElement("style"),m.type="text/css",A=document.createTextNode("."+k+" { color:"+B+"; }"),m.styleSheet?m.styleSheet.cssText=A.nodeValue:m.appendChild(A),D.insertBefore(m,D.firstChild),L=0,N=v.length+b.length;N>L;L++)T=v.length>L?v[L]:b[L-v.length],y=T.getAttribute("placeholder"),y&&H.inArray(w,T.type)&&g(T);E=setInterval(function(){for(L=0,N=v.length+b.length;N>L;L++)T=v.length>L?v[L]:b[L-v.length],y=T.getAttribute("placeholder"),y&&H.inArray(w,T.type)&&(T.getAttribute(j)||g(T),(y!==T.getAttribute(S)||"password"===T.type&&!T.getAttribute(P))&&("password"===T.type&&!T.getAttribute(P)&&H.changeType(T,"text")&&T.setAttribute(P,"password"),T.value===T.getAttribute(S)&&(T.value=y),T.setAttribute(S,y)));h||clearInterval(E)},100)}G.disable=a,G.enable=u}(this);