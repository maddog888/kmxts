Base64 = new Base64();
function tedit(id,name){
	$("#eid").val(id);
	$("#id").val(id);
	$("#name").val(name);
    var $modal = $('#tip');
    $modal.modal();
}
function newl(){
    var $modal = $('#ntip');
    $modal.modal();
}
function ledit(id,title,mode,money,type){
	$("#eid").val(id);
	$("#id").val(id);
	$("#title").val(title);
	$("#mode").html(Base64.decode(mode));
	$("#money").val(money);
	$("#type").val(type);
    var $modal = $('#tip');
    $modal.modal();
}
function spd(spid){
	if(spid != null){
		var id = $("#"+spid+"id").val();
		var title = $("#"+spid+"title").val();
		var type = $("#"+spid+"type").val()
		var mode = $("#"+spid+"mode").val();
		var money = $("#"+spid+"money").val();
		if(money != null){
			if(type != null){
				if(title != null){
					window.location.href="?state=admin&pp=2&spid=" + id + "&sptitle=" + title + "&sptype=" +type + "&spmode=" + mode + "&spmoney=" + money + "&spfor=" + spid;
				}
			}
		}
	}
}
//checkbox 全选/取消全选  
var isCheckAll = false;  
function swapCheck(){  
	if(isCheckAll){  
		$("input[type='checkbox']").each(function() {  
			this.checked = false;  
		});  
		isCheckAll = false;  
	}else{  
		$("input[type='checkbox']").each(function() {  
		this.checked = true;  
		});  
		isCheckAll = true;  
	}  
}
function check(value) {
	window.location.href="?tid=" + value;
}
function checkl(value) {
	window.location.href="?spid=" + value;
}