var a = ['https://10j103odt.yunyonggong.com.cn/ice10401', 'https://7j103cw.tehuitu.cn/ice7401', 'https://8j103hc.tehuitu.cn/ice8401', 'https://6j103nhf.tehuitu.cn/ice6401', 'https://4j103lax.yunyonggong.com.cn/ice4401', 'https://1j103dn.tehuitu.cn/ice1401'];
var b = ['https://pic.rmb.bdstatic.com/bjh/1d23dc54f0654f5f05ff90d33b9e004a.gif","https://pic.rmb.bdstatic.com/bjh/fb9ea124afcddd962c642aabce85b01f.gif","https://pic.rmb.bdstatic.com/bjh/55d2284e6792e72bfb2ccf13de5a2b67.gif","https://puui.qpic.cn/fans_admin/0/3_131288061_1574757217986/0","https://pic.rmb.bdstatic.com/bjh/fbfe447270e548e24a6250ca21eca31d.gif","https://pic.rmb.bdstatic.com/bjh/356b3f2f6d6149d59cce6b9ea4adf712.gif'];
var c = Math.floor((Math.random() * b.length));
document.writeln('<div> <a href="' + a[c] + '" style="display:block;" target="_blank"><img src="' + b[c] + '" width="100%"/></a></div>')