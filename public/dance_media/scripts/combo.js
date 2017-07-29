/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.8.2r1
*/
(function(){var A=YAHOO.util;A.Selector={_foundCache:[],_regexCache:{},_re:{nth:/^(?:([-]?\d*)(n){1}|(odd|even)$)*([-+]?\d*)$/,attr:/(\[.*\])/g,urls:/^(?:href|src)/},document:window.document,attrAliases:{},shorthand:{"\\#(-?[_a-z]+[-\\w]*)":"[id=$1]","\\.(-?[_a-z]+[-\\w]*)":"[class~=$1]"},operators:{"=":function(B,C){return B===C;},"!=":function(B,C){return B!==C;},"~=":function(B,D){var C=" ";return(C+B+C).indexOf((C+D+C))>-1;},"|=":function(B,C){return B===C||B.slice(0,C.length+1)===C+"-";},"^=":function(B,C){return B.indexOf(C)===0;},"$=":function(B,C){return B.slice(-C.length)===C;},"*=":function(B,C){return B.indexOf(C)>-1;},"":function(B,C){return B;}},pseudos:{"root":function(B){return B===B.ownerDocument.documentElement;},"nth-child":function(B,C){return A.Selector._getNth(B,C);},"nth-last-child":function(B,C){return A.Selector._getNth(B,C,null,true);},"nth-of-type":function(B,C){return A.Selector._getNth(B,C,B.tagName);},"nth-last-of-type":function(B,C){return A.Selector._getNth(B,C,B.tagName,true);},"first-child":function(B){return A.Selector._getChildren(B.parentNode)[0]===B;},"last-child":function(C){var B=A.Selector._getChildren(C.parentNode);return B[B.length-1]===C;},"first-of-type":function(B,C){return A.Selector._getChildren(B.parentNode,B.tagName)[0];},"last-of-type":function(C,D){var B=A.Selector._getChildren(C.parentNode,C.tagName);return B[B.length-1];},"only-child":function(C){var B=A.Selector._getChildren(C.parentNode);return B.length===1&&B[0]===C;},"only-of-type":function(B){return A.Selector._getChildren(B.parentNode,B.tagName).length===1;},"empty":function(B){return B.childNodes.length===0;},"not":function(B,C){return !A.Selector.test(B,C);},"contains":function(B,D){var C=B.innerText||B.textContent||"";return C.indexOf(D)>-1;},"checked":function(B){return B.checked===true;}},test:function(F,D){F=A.Selector.document.getElementById(F)||F;if(!F){return false;}var C=D?D.split(","):[];if(C.length){for(var E=0,B=C.length;E<B;++E){if(A.Selector._test(F,C[E])){return true;}}return false;}return A.Selector._test(F,D);},_test:function(D,G,F,E){F=F||A.Selector._tokenize(G).pop()||{};if(!D.tagName||(F.tag!=="*"&&D.tagName!==F.tag)||(E&&D._found)){return false;}if(F.attributes.length){var B,H,C=A.Selector._re.urls;if(!D.attributes||!D.attributes.length){return false;}for(var I=0,K;K=F.attributes[I++];){H=(C.test(K[0]))?2:0;B=D.getAttribute(K[0],H);if(B===null||B===undefined){return false;}if(A.Selector.operators[K[1]]&&!A.Selector.operators[K[1]](B,K[2])){return false;}}}if(F.pseudos.length){for(var I=0,J=F.pseudos.length;I<J;++I){if(A.Selector.pseudos[F.pseudos[I][0]]&&!A.Selector.pseudos[F.pseudos[I][0]](D,F.pseudos[I][1])){return false;}}}return(F.previous&&F.previous.combinator!==",")?A.Selector._combinators[F.previous.combinator](D,F):true;},filter:function(E,D){E=E||[];var G,C=[],H=A.Selector._tokenize(D);if(!E.item){for(var F=0,B=E.length;F<B;++F){if(!E[F].tagName){G=A.Selector.document.getElementById(E[F]);if(G){E[F]=G;}else{}}}}C=A.Selector._filter(E,A.Selector._tokenize(D)[0]);return C;},_filter:function(E,G,H,D){var C=H?null:[],I=A.Selector._foundCache;for(var F=0,B=E.length;F<B;F++){if(!A.Selector._test(E[F],"",G,D)){continue;}if(H){return E[F];}if(D){if(E[F]._found){continue;}E[F]._found=true;I[I.length]=E[F];}C[C.length]=E[F];}return C;},query:function(C,D,E){var B=A.Selector._query(C,D,E);return B;},_query:function(H,M,N,F){var P=(N)?null:[],E;if(!H){return P;}var D=H.split(",");if(D.length>1){var O;for(var I=0,J=D.length;I<J;++I){O=A.Selector._query(D[I],M,N,true);P=N?O:P.concat(O);}A.Selector._clearFoundCache();return P;}if(M&&!M.nodeName){M=A.Selector.document.getElementById(M);if(!M){return P;}}M=M||A.Selector.document;if(M.nodeName!=="#document"){A.Dom.generateId(M);H=M.tagName+"#"+M.id+" "+H;E=M;M=M.ownerDocument;}var L=A.Selector._tokenize(H);var K=L[A.Selector._getIdTokenIndex(L)],B=[],C,G=L.pop()||{};if(K){C=A.Selector._getId(K.attributes);}if(C){E=E||A.Selector.document.getElementById(C);if(E&&(M.nodeName==="#document"||A.Dom.isAncestor(M,E))){if(A.Selector._test(E,null,K)){if(K===G){B=[E];}else{if(K.combinator===" "||K.combinator===">"){M=E;}}}}else{return P;}}if(M&&!B.length){B=M.getElementsByTagName(G.tag);}if(B.length){P=A.Selector._filter(B,G,N,F);}return P;},_clearFoundCache:function(){var E=A.Selector._foundCache;for(var C=0,B=E.length;C<B;++C){try{delete E[C]._found;}catch(D){E[C].removeAttribute("_found");}}E=[];},_getRegExp:function(D,B){var C=A.Selector._regexCache;B=B||"";if(!C[D+B]){C[D+B]=new RegExp(D,B);}return C[D+B];},_getChildren:function(){if(document.documentElement.children&&document.documentElement.children.tags){return function(C,B){return(B)?C.children.tags(B):C.children||[];};}else{return function(F,C){var E=[],G=F.childNodes;for(var D=0,B=G.length;D<B;++D){if(G[D].tagName){if(!C||G[D].tagName===C){E.push(G[D]);}}}return E;};}}(),_combinators:{" ":function(C,B){while((C=C.parentNode)){if(A.Selector._test(C,"",B.previous)){return true;}}return false;},">":function(C,B){return A.Selector._test(C.parentNode,null,B.previous);},"+":function(D,C){var B=D.previousSibling;while(B&&B.nodeType!==1){B=B.previousSibling;}if(B&&A.Selector._test(B,null,C.previous)){return true;}return false;},"~":function(D,C){var B=D.previousSibling;while(B){if(B.nodeType===1&&A.Selector._test(B,null,C.previous)){return true;}B=B.previousSibling;}return false;}},_getNth:function(C,L,N,G){A.Selector._re.nth.test(L);var K=parseInt(RegExp.$1,10),B=RegExp.$2,H=RegExp.$3,I=parseInt(RegExp.$4,10)||0,M=[],E;var J=A.Selector._getChildren(C.parentNode,N);if(H){K=2;E="+";B="n";I=(H==="odd")?1:0;}else{if(isNaN(K)){K=(B)?1:0;}}if(K===0){if(G){I=J.length-I+1;}if(J[I-1]===C){return true;}else{return false;}}else{if(K<0){G=!!G;K=Math.abs(K);}}if(!G){for(var D=I-1,F=J.length;D<F;D+=K){if(D>=0&&J[D]===C){return true;}}}else{for(var D=J.length-I,F=J.length;D>=0;D-=K){if(D<F&&J[D]===C){return true;}}}return false;},_getId:function(C){for(var D=0,B=C.length;D<B;++D){if(C[D][0]=="id"&&C[D][1]==="="){return C[D][2];
}}},_getIdTokenIndex:function(D){for(var C=0,B=D.length;C<B;++C){if(A.Selector._getId(D[C].attributes)){return C;}}return -1;},_patterns:{tag:/^((?:-?[_a-z]+[\w-]*)|\*)/i,attributes:/^\[([a-z]+\w*)+([~\|\^\$\*!=]=?)?['"]?([^\]]*?)['"]?\]/i,pseudos:/^:([-\w]+)(?:\(['"]?(.+)['"]?\))*/i,combinator:/^\s*([>+~]|\s)\s*/},_tokenize:function(B){var D={},H=[],I,G=false,F=A.Selector._patterns,C;B=A.Selector._replaceShorthand(B);do{G=false;for(var E in F){if(YAHOO.lang.hasOwnProperty(F,E)){if(E!="tag"&&E!="combinator"){D[E]=D[E]||[];}if((C=F[E].exec(B))){G=true;if(E!="tag"&&E!="combinator"){if(E==="attributes"&&C[1]==="id"){D.id=C[3];}D[E].push(C.slice(1));}else{D[E]=C[1];}B=B.replace(C[0],"");if(E==="combinator"||!B.length){D.attributes=A.Selector._fixAttributes(D.attributes);D.pseudos=D.pseudos||[];D.tag=D.tag?D.tag.toUpperCase():"*";H.push(D);D={previous:D};}}}}}while(G);return H;},_fixAttributes:function(C){var D=A.Selector.attrAliases;C=C||[];for(var E=0,B=C.length;E<B;++E){if(D[C[E][0]]){C[E][0]=D[C[E][0]];}if(!C[E][1]){C[E][1]="";}}return C;},_replaceShorthand:function(C){var D=A.Selector.shorthand;var E=C.match(A.Selector._re.attr);if(E){C=C.replace(A.Selector._re.attr,"REPLACED_ATTRIBUTE");}for(var G in D){if(YAHOO.lang.hasOwnProperty(D,G)){C=C.replace(A.Selector._getRegExp(G,"gi"),D[G]);}}if(E){for(var F=0,B=E.length;F<B;++F){C=C.replace("REPLACED_ATTRIBUTE",E[F]);}}return C;}};if(YAHOO.env.ua.ie&&YAHOO.env.ua.ie<8){A.Selector.attrAliases["class"]="className";A.Selector.attrAliases["for"]="htmlFor";}})();YAHOO.register("selector",YAHOO.util.Selector,{version:"2.8.2r1",build:"7"});/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.8.2r1
*/
(function(){var A=YAHOO.util.Event,C=YAHOO.lang,B=[],D=function(H,E,F){var G;if(!H||H===F){G=false;}else{G=YAHOO.util.Selector.test(H,E)?H:D(H.parentNode,E,F);}return G;};C.augmentObject(A,{_createDelegate:function(F,E,G,H){return function(I){var J=this,N=A.getTarget(I),L=E,P=(J.nodeType===9),Q,K,O,M;if(C.isFunction(E)){Q=E(N);}else{if(C.isString(E)){if(!P){O=J.id;if(!O){O=A.generateId(J);}M=("#"+O+" ");L=(M+E).replace(/,/gi,(","+M));}if(YAHOO.util.Selector.test(N,L)){Q=N;}else{if(YAHOO.util.Selector.test(N,((L.replace(/,/gi," *,"))+" *"))){Q=D(N,L,J);}}}}if(Q){K=Q;if(H){if(H===true){K=G;}else{K=H;}}return F.call(K,I,Q,J,G);}};},delegate:function(F,J,L,G,H,I){var E=J,K,M;if(C.isString(G)&&!YAHOO.util.Selector){return false;}if(J=="mouseenter"||J=="mouseleave"){if(!A._createMouseDelegate){return false;}E=A._getType(J);K=A._createMouseDelegate(L,H,I);M=A._createDelegate(function(P,O,N){return K.call(O,P,N);},G,H,I);}else{M=A._createDelegate(L,G,H,I);}B.push([F,E,L,M]);return A.on(F,E,M);},removeDelegate:function(F,J,I){var K=J,H=false,G,E;if(J=="mouseenter"||J=="mouseleave"){K=A._getType(J);}G=A._getCacheIndex(B,F,K,I);if(G>=0){E=B[G];}if(F&&E){H=A.removeListener(E[0],E[1],E[3]);if(H){delete B[G][2];delete B[G][3];B.splice(G,1);}}return H;}});}());YAHOO.register("event-delegate",YAHOO.util.Event,{version:"2.8.2r1",build:"7"});/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.8.2r1
*/
(function(){var B=YAHOO.util;var A=function(D,C,E,F){if(!D){}this.init(D,C,E,F);};A.NAME="Anim";A.prototype={toString:function(){var C=this.getEl()||{};var D=C.id||C.tagName;return(this.constructor.NAME+": "+D);},patterns:{noNegatives:/width|height|opacity|padding/i,offsetAttribute:/^((width|height)|(top|left))$/,defaultUnit:/width|height|top$|bottom$|left$|right$/i,offsetUnit:/\d+(em|%|en|ex|pt|in|cm|mm|pc)$/i},doMethod:function(C,E,D){return this.method(this.currentFrame,E,D-E,this.totalFrames);},setAttribute:function(C,F,E){var D=this.getEl();if(this.patterns.noNegatives.test(C)){F=(F>0)?F:0;}if(C in D&&!("style" in D&&C in D.style)){D[C]=F;}else{B.Dom.setStyle(D,C,F+E);}},getAttribute:function(C){var E=this.getEl();var G=B.Dom.getStyle(E,C);if(G!=="auto"&&!this.patterns.offsetUnit.test(G)){return parseFloat(G);}var D=this.patterns.offsetAttribute.exec(C)||[];var H=!!(D[3]);var F=!!(D[2]);if("style" in E){if(F||(B.Dom.getStyle(E,"position")=="absolute"&&H)){G=E["offset"+D[0].charAt(0).toUpperCase()+D[0].substr(1)];}else{G=0;}}else{if(C in E){G=E[C];}}return G;},getDefaultUnit:function(C){if(this.patterns.defaultUnit.test(C)){return"px";}return"";},setRuntimeAttribute:function(D){var I;var E;var F=this.attributes;this.runtimeAttributes[D]={};var H=function(J){return(typeof J!=="undefined");};if(!H(F[D]["to"])&&!H(F[D]["by"])){return false;}I=(H(F[D]["from"]))?F[D]["from"]:this.getAttribute(D);if(H(F[D]["to"])){E=F[D]["to"];}else{if(H(F[D]["by"])){if(I.constructor==Array){E=[];for(var G=0,C=I.length;G<C;++G){E[G]=I[G]+F[D]["by"][G]*1;}}else{E=I+F[D]["by"]*1;}}}this.runtimeAttributes[D].start=I;this.runtimeAttributes[D].end=E;this.runtimeAttributes[D].unit=(H(F[D].unit))?F[D]["unit"]:this.getDefaultUnit(D);return true;},init:function(E,J,I,C){var D=false;var F=null;var H=0;E=B.Dom.get(E);this.attributes=J||{};this.duration=!YAHOO.lang.isUndefined(I)?I:1;this.method=C||B.Easing.easeNone;this.useSeconds=true;this.currentFrame=0;this.totalFrames=B.AnimMgr.fps;this.setEl=function(M){E=B.Dom.get(M);};this.getEl=function(){return E;};this.isAnimated=function(){return D;};this.getStartTime=function(){return F;};this.runtimeAttributes={};this.animate=function(){if(this.isAnimated()){return false;}this.currentFrame=0;this.totalFrames=(this.useSeconds)?Math.ceil(B.AnimMgr.fps*this.duration):this.duration;if(this.duration===0&&this.useSeconds){this.totalFrames=1;}B.AnimMgr.registerElement(this);return true;};this.stop=function(M){if(!this.isAnimated()){return false;}if(M){this.currentFrame=this.totalFrames;this._onTween.fire();}B.AnimMgr.stop(this);};var L=function(){this.onStart.fire();this.runtimeAttributes={};for(var M in this.attributes){this.setRuntimeAttribute(M);}D=true;H=0;F=new Date();};var K=function(){var O={duration:new Date()-this.getStartTime(),currentFrame:this.currentFrame};O.toString=function(){return("duration: "+O.duration+", currentFrame: "+O.currentFrame);};this.onTween.fire(O);var N=this.runtimeAttributes;for(var M in N){this.setAttribute(M,this.doMethod(M,N[M].start,N[M].end),N[M].unit);}H+=1;};var G=function(){var M=(new Date()-F)/1000;var N={duration:M,frames:H,fps:H/M};N.toString=function(){return("duration: "+N.duration+", frames: "+N.frames+", fps: "+N.fps);};D=false;H=0;this.onComplete.fire(N);};this._onStart=new B.CustomEvent("_start",this,true);this.onStart=new B.CustomEvent("start",this);this.onTween=new B.CustomEvent("tween",this);this._onTween=new B.CustomEvent("_tween",this,true);this.onComplete=new B.CustomEvent("complete",this);this._onComplete=new B.CustomEvent("_complete",this,true);this._onStart.subscribe(L);this._onTween.subscribe(K);this._onComplete.subscribe(G);}};B.Anim=A;})();YAHOO.util.AnimMgr=new function(){var C=null;var B=[];var A=0;this.fps=1000;this.delay=1;this.registerElement=function(F){B[B.length]=F;A+=1;F._onStart.fire();this.start();};this.unRegister=function(G,F){F=F||E(G);if(!G.isAnimated()||F===-1){return false;}G._onComplete.fire();B.splice(F,1);A-=1;if(A<=0){this.stop();}return true;};this.start=function(){if(C===null){C=setInterval(this.run,this.delay);}};this.stop=function(H){if(!H){clearInterval(C);for(var G=0,F=B.length;G<F;++G){this.unRegister(B[0],0);}B=[];C=null;A=0;}else{this.unRegister(H);}};this.run=function(){for(var H=0,F=B.length;H<F;++H){var G=B[H];if(!G||!G.isAnimated()){continue;}if(G.currentFrame<G.totalFrames||G.totalFrames===null){G.currentFrame+=1;if(G.useSeconds){D(G);}G._onTween.fire();}else{YAHOO.util.AnimMgr.stop(G,H);}}};var E=function(H){for(var G=0,F=B.length;G<F;++G){if(B[G]===H){return G;}}return -1;};var D=function(G){var J=G.totalFrames;var I=G.currentFrame;var H=(G.currentFrame*G.duration*1000/G.totalFrames);var F=(new Date()-G.getStartTime());var K=0;if(F<G.duration*1000){K=Math.round((F/H-1)*G.currentFrame);}else{K=J-(I+1);}if(K>0&&isFinite(K)){if(G.currentFrame+K>=J){K=J-(I+1);}G.currentFrame+=K;}};this._queue=B;this._getIndex=E;};YAHOO.util.Bezier=new function(){this.getPosition=function(E,D){var F=E.length;var C=[];for(var B=0;B<F;++B){C[B]=[E[B][0],E[B][1]];}for(var A=1;A<F;++A){for(B=0;B<F-A;++B){C[B][0]=(1-D)*C[B][0]+D*C[parseInt(B+1,10)][0];C[B][1]=(1-D)*C[B][1]+D*C[parseInt(B+1,10)][1];}}return[C[0][0],C[0][1]];};};(function(){var A=function(F,E,G,H){A.superclass.constructor.call(this,F,E,G,H);};A.NAME="ColorAnim";A.DEFAULT_BGCOLOR="#fff";var C=YAHOO.util;YAHOO.extend(A,C.Anim);var D=A.superclass;var B=A.prototype;B.patterns.color=/color$/i;B.patterns.rgb=/^rgb\(([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)\)$/i;B.patterns.hex=/^#?([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})$/i;B.patterns.hex3=/^#?([0-9A-F]{1})([0-9A-F]{1})([0-9A-F]{1})$/i;B.patterns.transparent=/^transparent|rgba\(0, 0, 0, 0\)$/;B.parseColor=function(E){if(E.length==3){return E;}var F=this.patterns.hex.exec(E);if(F&&F.length==4){return[parseInt(F[1],16),parseInt(F[2],16),parseInt(F[3],16)];}F=this.patterns.rgb.exec(E);if(F&&F.length==4){return[parseInt(F[1],10),parseInt(F[2],10),parseInt(F[3],10)];}F=this.patterns.hex3.exec(E);if(F&&F.length==4){return[parseInt(F[1]+F[1],16),parseInt(F[2]+F[2],16),parseInt(F[3]+F[3],16)];
}return null;};B.getAttribute=function(E){var G=this.getEl();if(this.patterns.color.test(E)){var I=YAHOO.util.Dom.getStyle(G,E);var H=this;if(this.patterns.transparent.test(I)){var F=YAHOO.util.Dom.getAncestorBy(G,function(J){return !H.patterns.transparent.test(I);});if(F){I=C.Dom.getStyle(F,E);}else{I=A.DEFAULT_BGCOLOR;}}}else{I=D.getAttribute.call(this,E);}return I;};B.doMethod=function(F,J,G){var I;if(this.patterns.color.test(F)){I=[];for(var H=0,E=J.length;H<E;++H){I[H]=D.doMethod.call(this,F,J[H],G[H]);}I="rgb("+Math.floor(I[0])+","+Math.floor(I[1])+","+Math.floor(I[2])+")";}else{I=D.doMethod.call(this,F,J,G);}return I;};B.setRuntimeAttribute=function(F){D.setRuntimeAttribute.call(this,F);if(this.patterns.color.test(F)){var H=this.attributes;var J=this.parseColor(this.runtimeAttributes[F].start);var G=this.parseColor(this.runtimeAttributes[F].end);if(typeof H[F]["to"]==="undefined"&&typeof H[F]["by"]!=="undefined"){G=this.parseColor(H[F].by);for(var I=0,E=J.length;I<E;++I){G[I]=J[I]+G[I];}}this.runtimeAttributes[F].start=J;this.runtimeAttributes[F].end=G;}};C.ColorAnim=A;})();
/*
TERMS OF USE - EASING EQUATIONS
Open source under the BSD License.
Copyright 2001 Robert Penner All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name of the author nor the names of contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
YAHOO.util.Easing={easeNone:function(B,A,D,C){return D*B/C+A;},easeIn:function(B,A,D,C){return D*(B/=C)*B+A;},easeOut:function(B,A,D,C){return -D*(B/=C)*(B-2)+A;},easeBoth:function(B,A,D,C){if((B/=C/2)<1){return D/2*B*B+A;}return -D/2*((--B)*(B-2)-1)+A;},easeInStrong:function(B,A,D,C){return D*(B/=C)*B*B*B+A;},easeOutStrong:function(B,A,D,C){return -D*((B=B/C-1)*B*B*B-1)+A;},easeBothStrong:function(B,A,D,C){if((B/=C/2)<1){return D/2*B*B*B*B+A;}return -D/2*((B-=2)*B*B*B-2)+A;},elasticIn:function(C,A,G,F,B,E){if(C==0){return A;}if((C/=F)==1){return A+G;}if(!E){E=F*0.3;}if(!B||B<Math.abs(G)){B=G;var D=E/4;}else{var D=E/(2*Math.PI)*Math.asin(G/B);}return -(B*Math.pow(2,10*(C-=1))*Math.sin((C*F-D)*(2*Math.PI)/E))+A;},elasticOut:function(C,A,G,F,B,E){if(C==0){return A;}if((C/=F)==1){return A+G;}if(!E){E=F*0.3;}if(!B||B<Math.abs(G)){B=G;var D=E/4;}else{var D=E/(2*Math.PI)*Math.asin(G/B);}return B*Math.pow(2,-10*C)*Math.sin((C*F-D)*(2*Math.PI)/E)+G+A;},elasticBoth:function(C,A,G,F,B,E){if(C==0){return A;}if((C/=F/2)==2){return A+G;}if(!E){E=F*(0.3*1.5);}if(!B||B<Math.abs(G)){B=G;var D=E/4;}else{var D=E/(2*Math.PI)*Math.asin(G/B);}if(C<1){return -0.5*(B*Math.pow(2,10*(C-=1))*Math.sin((C*F-D)*(2*Math.PI)/E))+A;}return B*Math.pow(2,-10*(C-=1))*Math.sin((C*F-D)*(2*Math.PI)/E)*0.5+G+A;},backIn:function(B,A,E,D,C){if(typeof C=="undefined"){C=1.70158;}return E*(B/=D)*B*((C+1)*B-C)+A;},backOut:function(B,A,E,D,C){if(typeof C=="undefined"){C=1.70158;}return E*((B=B/D-1)*B*((C+1)*B+C)+1)+A;},backBoth:function(B,A,E,D,C){if(typeof C=="undefined"){C=1.70158;}if((B/=D/2)<1){return E/2*(B*B*(((C*=(1.525))+1)*B-C))+A;}return E/2*((B-=2)*B*(((C*=(1.525))+1)*B+C)+2)+A;},bounceIn:function(B,A,D,C){return D-YAHOO.util.Easing.bounceOut(C-B,0,D,C)+A;},bounceOut:function(B,A,D,C){if((B/=C)<(1/2.75)){return D*(7.5625*B*B)+A;}else{if(B<(2/2.75)){return D*(7.5625*(B-=(1.5/2.75))*B+0.75)+A;}else{if(B<(2.5/2.75)){return D*(7.5625*(B-=(2.25/2.75))*B+0.9375)+A;}}}return D*(7.5625*(B-=(2.625/2.75))*B+0.984375)+A;},bounceBoth:function(B,A,D,C){if(B<C/2){return YAHOO.util.Easing.bounceIn(B*2,0,D,C)*0.5+A;}return YAHOO.util.Easing.bounceOut(B*2-C,0,D,C)*0.5+D*0.5+A;}};(function(){var A=function(H,G,I,J){if(H){A.superclass.constructor.call(this,H,G,I,J);}};A.NAME="Motion";var E=YAHOO.util;YAHOO.extend(A,E.ColorAnim);var F=A.superclass;var C=A.prototype;C.patterns.points=/^points$/i;C.setAttribute=function(G,I,H){if(this.patterns.points.test(G)){H=H||"px";F.setAttribute.call(this,"left",I[0],H);F.setAttribute.call(this,"top",I[1],H);}else{F.setAttribute.call(this,G,I,H);}};C.getAttribute=function(G){if(this.patterns.points.test(G)){var H=[F.getAttribute.call(this,"left"),F.getAttribute.call(this,"top")];}else{H=F.getAttribute.call(this,G);}return H;};C.doMethod=function(G,K,H){var J=null;if(this.patterns.points.test(G)){var I=this.method(this.currentFrame,0,100,this.totalFrames)/100;J=E.Bezier.getPosition(this.runtimeAttributes[G],I);}else{J=F.doMethod.call(this,G,K,H);}return J;};C.setRuntimeAttribute=function(P){if(this.patterns.points.test(P)){var H=this.getEl();var J=this.attributes;var G;var L=J["points"]["control"]||[];var I;var M,O;if(L.length>0&&!(L[0] instanceof Array)){L=[L];}else{var K=[];for(M=0,O=L.length;M<O;++M){K[M]=L[M];}L=K;}if(E.Dom.getStyle(H,"position")=="static"){E.Dom.setStyle(H,"position","relative");}if(D(J["points"]["from"])){E.Dom.setXY(H,J["points"]["from"]);
}else{E.Dom.setXY(H,E.Dom.getXY(H));}G=this.getAttribute("points");if(D(J["points"]["to"])){I=B.call(this,J["points"]["to"],G);var N=E.Dom.getXY(this.getEl());for(M=0,O=L.length;M<O;++M){L[M]=B.call(this,L[M],G);}}else{if(D(J["points"]["by"])){I=[G[0]+J["points"]["by"][0],G[1]+J["points"]["by"][1]];for(M=0,O=L.length;M<O;++M){L[M]=[G[0]+L[M][0],G[1]+L[M][1]];}}}this.runtimeAttributes[P]=[G];if(L.length>0){this.runtimeAttributes[P]=this.runtimeAttributes[P].concat(L);}this.runtimeAttributes[P][this.runtimeAttributes[P].length]=I;}else{F.setRuntimeAttribute.call(this,P);}};var B=function(G,I){var H=E.Dom.getXY(this.getEl());G=[G[0]-H[0]+I[0],G[1]-H[1]+I[1]];return G;};var D=function(G){return(typeof G!=="undefined");};E.Motion=A;})();(function(){var D=function(F,E,G,H){if(F){D.superclass.constructor.call(this,F,E,G,H);}};D.NAME="Scroll";var B=YAHOO.util;YAHOO.extend(D,B.ColorAnim);var C=D.superclass;var A=D.prototype;A.doMethod=function(E,H,F){var G=null;if(E=="scroll"){G=[this.method(this.currentFrame,H[0],F[0]-H[0],this.totalFrames),this.method(this.currentFrame,H[1],F[1]-H[1],this.totalFrames)];}else{G=C.doMethod.call(this,E,H,F);}return G;};A.getAttribute=function(E){var G=null;var F=this.getEl();if(E=="scroll"){G=[F.scrollLeft,F.scrollTop];}else{G=C.getAttribute.call(this,E);}return G;};A.setAttribute=function(E,H,G){var F=this.getEl();if(E=="scroll"){F.scrollLeft=H[0];F.scrollTop=H[1];}else{C.setAttribute.call(this,E,H,G);}};B.Scroll=D;})();YAHOO.register("animation",YAHOO.util.Anim,{version:"2.8.2r1",build:"7"});