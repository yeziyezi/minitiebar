<script>
    $(function(){
    var url = window.location.toString();
    var id = url.split("#")[1];
    if(id){
        var t = $("#"+id).offset().top;
        $(window).scrollTop(t);
    }		   
});

function getScrollOffsets(w){  
  w=w || window;  
  //除了IE8以及更早的版本，其它浏览器都能用  
  if(w.pageXOffset != null){  
    return { x:w.pageXOffset, y:w.pageYOffset }  
  }  
    
  //对标准模式下的IE或任何浏览器  
  var d=w.document;  
  if(document.compatMode == "CSS1Compat"){  
    return { x:d.documentElement.scrollLeft ,y:d.documentElement.scrollTop }  
  }  
  
  //对怪异模式下的浏览器  
  return { x:d.body.scrollLeft, y:d.body.scrollTop }  
    
}  
// function alertOffset(){
//     var offset=getScrollOffsets();
//     alert(offset.x+'-'+offset.y);
// }
function scrollTo(offset){
    $("html,body").animate({scrollTop:offset}, 1000);//无法正常漂移，找其他方法

}
function scroll(){
    $("html,body").animate({scrollTop: $("#box").offset().top}, 1000);

}
    </script>
    