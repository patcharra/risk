/* ================================================================ 
This copyright notice must be untouched at all times.

The original version of this script and the associated (x)html
is available at http://www.stunicholls.com/menu/tree_frog_vertical.html
Copyright (c) 2005-2007 Stu Nicholls. All rights reserved.
This script and the associated (x)html may be modified in any 
way to fit your requirements.
=================================================================== */


clickMenu = function(menu) {
	var getEls = document.getElementById(menu).getElementsByTagName("LI");
	var getAgn = getEls;


	for (var i=0; i<getEls.length; i++) {
			getEls[i].onclick=function() {
				for (var x=0; x<getAgn.length; x++) {
				getAgn[x].className=getAgn[x].className.replace("unclick", "");
				getAgn[x].className=getAgn[x].className.replace("click", "unclick");
				}
			if ((this.className.indexOf('unclick'))!=-1) {
				this.className=this.className.replace("unclick", "");;
				}
				else {
				this.className+=" click";
				}
			}
			getEls[i].onmouseover=function() {
				this.className+=" hover";
			}
			getEls[i].onmouseout=function() {
				this.className=this.className.replace("hover", "");
			}
		}
	}