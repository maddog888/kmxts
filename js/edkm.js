if($("#newtype").val()!="请选择要购买的类型"){
    typel($("#newtype").val());
    isSelected($("#newlist").val());
}
function isSelected(value) {
    $("#mode").html(list[value].mode);
    $("#money").html(cc(list[value].money)+ "  ￥");
    $("#time").html(list[value].time+ "  个");
    $("#zj").html(cc(list[value].money)+ "  ￥");
    if(list[value].time<=0){
        $("#sl").val(0);
    }else{
        $("#sl").val(1);
    }
    money = list[value].money;
    title = value;
    time = list[value].time;
    spid = list[value].spid;
    tt = time;
    zj = money;
}
function pay(type){
    if(time!=0){
        var pwd = document.getElementById("pwd").value;
        if(pwd==''){
            $("#tips").html("请先输入您的邮箱或一串密码，用于忘记云端单号查询使用!");
            var $modal = $('#tip');
            $modal.modal();
        }else{
            if($("#sl").val()!=0){
                if(spid!=""){
                    if(type=='zfb'){
                        window.location.href='./pay/?type='+type+'&money='+cc(zj)+'&title='+title+'&pwd='+pwd+'&spid='+spid;
                    }else if(type=='wx'){
                        window.location.href='./pay/?type='+type+'&money='+cc(zj)+'&title='+title+'&pwd='+pwd+'&spid='+spid;
                    }else if(type=='qq'){
                        window.location.href='./pay/?type='+type+'&money='+cc(zj)+'&title='+title+'&pwd='+pwd+'&spid='+spid;
                    }else{
                        $("#tips").html("支付方式出错，请刷新页面重新提交");
                        var $modal = $('#tip');
                        $modal.modal();
                    }
                }else{
                    $("#tips").html("发生内部错误，请勿非法操作后重试！");
                    var $modal = $('#tip');
                    $modal.modal();
                }
            }else{
                $("#tips").html("请设置需要购买的数量");
                var $modal = $('#tip');
                $modal.modal();
            }
        }
    }else{
        $("#tips").html("当前商品资源缺失，暂时无法购买，如急需购买，请联系站长！");
        var $modal = $('#tip');
        $modal.modal();
    } 
}
function lpays(type){
    if(time!=0){
        var pwd = document.getElementById("pwd").value;
        if(pwd==''){
            $("#tips").html("请先输入您的邮箱或一串密码，用于忘记云端单号查询使用!");
            var $modal = $('#tip');
            $modal.modal();
        }else{
            if($("#sl").val()!=0){
                if(spid!=""){
                    Base64 = new Base64();
                    var rurl = window.location.protocol+'//'+document.domain+'/kmxt?tab=b'+'&spid='+spid+'&pwd='+pwd;
                    rurl = Base64.encode(rurl)
                    if(type=='zfb'){
                        window.location.href='https://pay.edlm.cn/?appid='+appid+'&income='+cc(zj)+'&rurl='+rurl+'&type=alipay';
                    }else if(type=='wx'){
                        window.location.href='https://pay.edlm.cn/?appid='+appid+'&income='+cc(zj)+'&rurl='+rurl+'&type=wxpay';
                    }else if(type=='qq'){
                        window.location.href='https://pay.edlm.cn/?appid='+appid+'&income='+cc(zj)+'&rurl='+rurl+'&type=qqpay';
                    }else{
                        $("#tips").html("支付方式出错，请刷新页面重新提交");
                        var $modal = $('#tip');
                        $modal.modal();
                    }
                }else{
                    $("#tips").html("发生内部错误，请勿非法操作后重试！");
                    var $modal = $('#tip');
                    $modal.modal();
                }
            }else{
                $("#tips").html("请设置需要购买的数量");
                var $modal = $('#tip');
                $modal.modal();
            }
        }
    }else{
        $("#tips").html("当前商品资源缺失，暂时无法购买，如急需购买，请联系站长！");
        var $modal = $('#tip');
        $modal.modal();
    } 
}
function accMul(arg1,arg2){
    var m=0,s1=arg1.toString(),s2=arg2.toString();
    try{m+=s1.split(".")[1].length}catch(e){};
    try{m+=s2.split(".")[1].length}catch(e){};
    return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m);
}
Number.prototype.mul = function (arg){ 
    return accMul(arg, this); 
} 
function minus(){
    if($("#sl").val()>0){
        $("#sl").val($("#sl").val() - 1);
        zj = String(accMul(Number($("#sl").val()),Number(money)));
        if(cc(zj)!="invalid value"){
            $("#zj").html(cc(zj) + "  ￥");
        }
    }
}
function plus(){
    if(tt){
        if(Number($("#sl").val())<Number(tt)){
            $("#sl").val(Number($("#sl").val()) + 1);
            zj = String(accMul(Number($("#sl").val()),Number(money)));
            $("#zj").html(cc(zj) + "  ￥");
        }
    }  
}
function changes(sl){
    if(Number(sl)>0){
        if(Number(sl)>Number(tt)){
            zj = String(accMul(Number(tt),Number(money)));
            $("#zj").html(cc(zj) + "  ￥");
            var sl = Number(tt);
        }else{
            zj = String(accMul(Number(sl),Number(money)));
            $("#zj").html(cc(zj) + "  ￥");
        }
    }
    return sl;
}
function cc(s){
    if(/[^0-9\.]/.test(s)) return "invalid value";
    s=s.replace(/^(\d*)$/,"$1.");
    s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");
    var re=/(\d)(\d{3},)/;
    while(re.test(s))
    s=s.replace(re,"$1,$2");
    s=s.replace(/,(\d\d)$/,".$1");
    return s.replace(/^\./,"0.")
}
function typel(value){
    document.getElementById("newlist").options.length=0;
    var y=1;
    for (var i=0;i<typels[value].time;i++){
        document.getElementById("newlist").options.add(new Option(typels[value][y],typels[value][y]));
        y++;
    }
}