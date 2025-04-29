function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}
var aa=1;
$(document).ready(function(){
    //click_a=0;
    $(".jp-pause").click(function(){
        setCookie("aa",0,365);
    });
    aa=getCookie("aa");
    if (aa!=null && aa!=""){
        var aa=0;
    }else{
        var aa=1;
    }
    
    // end
	var myPlaylist = new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_N",
		cssSelectorAncestor: "#jp_container_N"
	}, [
		{
			title:"AlFaudzani",
			artist:"AlFaudzani",
			mp3:"http://www.alfaudzani.com/music.mp3",
			//oga:"http://almotahajiba.com/themes/prestashop/audio.ogg",
		}
	], {
		playlistOptions: {
            autoPlay: true,
			enableRemoveControls: true
		},
		swfPath: "js",
		supplied: "webmv, ogv, m4v, oga, mp3"
	});
});