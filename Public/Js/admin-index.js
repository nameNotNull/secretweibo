$(function(){var lheight=$('#left').height()
var height=document.documentElement.clientHeight-$('.head').height()
if(height>lheight){$('#left').height(height)}var width=document.documentElement.clientWidth-180
$('#right').width(width)
$('#right').height(height-40)
$('#index-Index p').slideDown();$('#menu-Index-index').addClass('on')
$('#left p').click(function(){$('#left p').removeClass();$(this).addClass('on')
var url=$(this).find('a').attr('href')
$('#right').attr('src',url)
return false;})})
function menu(str){$('#left .menu p').slideUp();if($('#'+str+' p').is(":visible")==false){$('#'+str+' p').slideDown();}}