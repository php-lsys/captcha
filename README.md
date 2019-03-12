#封装验证码接口
> 封装验证码,使程序调用时保持一致接口
> 为了更换变更验证吗时尽可能少修改代码


示例代码请参考:/dome/目录 


> 默认未实现任何可用的验证方式,请根据实际需求引入以下包:

	"lsys/captcha-geetest":"~2.0.0" #基于geetest的验证码包
	"lsys/captcha-image":"~2.0.0" #基于图片的验证码包

> 验证码数据存放已实现以下可用包,默认存放于session中:

	"lsys/captcha-stroage-memcache":"~2.0.0",
	"lsys/captcha-stroage-memcached":"~2.0.0",
	"lsys/captcha-stroage-redis":"~2.0.0"