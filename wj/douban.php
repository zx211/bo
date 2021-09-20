<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE"); 
header('content-type:application/json;charset=utf8');
$echojsons = '
{
	"status": "200",
	"data": {
		"vod_cid": 1,
		"vod_reurl": "https:\/\/movie.douban.com\/subject\/24773958\/",
		"vod_inputer": "douban",
		"vod_hits": "7388",
		"vod_state": "正片",
		"vod_total": 0,
		"vod_continu": 0,
		"vod_isend": 1,
		"vod_name": "复仇者联盟3：无限战争",
		"vod_title": "复联3 \/ 复仇者联盟：无限之战(台) \/ 复仇者联盟3：无尽之战 \/ Avengers: Infinity War - Part I \/ The Avengers 3: Part 1",
		"vod_pic": "http:\/\/img3.doubanio.com\/view\/photo\/s_ratio_poster\/public\/p2517753454.jpg",
		"vod_gold": "8.4",
		"vod_filmtime": "2018-05-11",
		"vod_year": 2018,
		"vod_area": "美国",
		"vod_language": "英语",
		"vod_type": "动作,科幻,奇幻,冒险",
		"vod_actor": "小罗伯特·唐尼,克里斯·海姆斯沃斯,克里斯·埃文斯,马克·鲁弗洛,乔什·布洛林,佐伊·索尔达娜,本尼迪克特·康伯巴奇,克里斯·帕拉特,汤姆·赫兰德,伊丽莎白·奥尔森,保罗·贝坦尼,斯嘉丽·约翰逊,查德维克·博斯曼,塞巴斯蒂安·斯坦,唐·钱德尔,汤姆·希德勒斯顿,安东尼·麦凯,本尼迪克特·王,戴夫·巴蒂斯塔,布莱德利·库珀,范·迪塞尔,凯伦·吉兰,利蒂希娅·赖特,庞·克莱门捷夫,凯莉·库恩,汤姆-沃恩-劳勒,海登·瓦尔希,迈克尔·詹姆斯·肖,泰瑞·诺塔里,本尼西奥·德尔·托罗,彼特·丁拉基,罗斯·马昆德,丹娜·奎里拉,温斯顿·杜克,弗洛伦丝·卡松巴,塞缪尔·杰克逊,雅各布·巴特朗,斯坦·李",
		"vod_director": "安东尼·罗素,乔·罗素",
		"vod_length": 150,
		"vod_content": "《复仇者联盟3：无限战争》是漫威电影宇宙10周年的历史性集结，将为影迷们带来史诗版的终极对决。面对灭霸突然发起的闪电袭击，复仇者联盟及其所有超级英雄盟友必须全力以赴，才能阻止他对全宇宙造成毁灭性的打击。",
		"vod_keywords": "漫威,超级英雄,科幻,美国,2018,动作,漫画改编,欧美",
		"vod_douban_id": "24773958",
		"vod_douban_score": "8.4"
	}
}
';
$api = 'https://api.douban.com/v2/movie/subject/';
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}else{
	exit('no id');
}
//$id = '26336252';
if($id){
	$jsons = json_decode(Curl_get($api.$id));
}else{
	exit('err id');
}
function Curl_get($url,$data = null){
    $cookie = dirname(__FILE__).'/cookie.txt';//Cookie
    $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36';
    $host = array("Host:api.douban.com");
    $ref = 'http://api.douban.com/';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);//Cookie值
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);//Cookie值
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_REFERER, $ref);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
$htmltmp = Curl_get('https://movie.douban.com/subject/'.$id.'/');

preg_match('|<meta name="keywords" content="(.*),|iUs',$htmltmp,$res);
$name= $res[1];

preg_match('|<span property="v:runtime" content="(.*)">|iUs',$htmltmp,$res);
$length2= $res[1];
preg_match('|单集片长:</span> (.*)<br/>|iUs',$htmltmp,$res);
$length3 = $res[1];
//单集片长
if(!empty($length2)){
	$length = $length2;
}else{
	$length = $length3;
}//end

preg_match('|<span class="pl">制片国家/地区:</span> (.*)<br/>|iUs',$htmltmp,$res);
$country = str_replace(' / ', ',', $res[1]);

preg_match('|<span class="pl">语言:</span> (.*)<br/>|iUs',$htmltmp,$res);
$language = str_replace(' / ', ',', $res[1]);

preg_match('|<span class="pl">又名:</span> (.*)<br/>|iUs',$htmltmp,$res);
$title1 = $res[1];
preg_match('|<meta name="keywords" content="(.*),(.*),|iUs',$htmltmp,$res);
$title2= $res[2];
if(!empty($title1)){
	$title= $title2." / ".$title1;
}else{
	$title= $title2;
}
preg_match('|//www.imdb.com/title/(.*)"|iUs',$htmltmp,$res);
$imdb= $res[1];

preg_match('|<span class="year">(.*)</span>|iUs',$htmltmp,$res);
$wen = array('(',')');
$year = str_replace($wen, '', $res[1]);

preg_match('|v:initialReleaseDate" content="(.*)">|iUs',$htmltmp,$res);
$sytime1 = $res[1];
if(!empty($sytime1)){
	$sytime = $sytime1;
}else{
	$sytime = $year;
}

preg_match_all('|<span class=\'pl\'>导演</span>: <span class=\'attrs\'>(.*)</span></span><br/>|iUs',$htmltmp,$res);
$attrsz = $res[1][0];
preg_match_all('|<a href="(.*)" rel="v:directedBy">(.*)</a>|iUs',$attrsz,$res);
$director = implode(',', $res[2]);

preg_match_all('|<span class=\'pl\'>编剧</span>: <span class=\'attrs\'>(.*)</span></span><br/>|iUs',$htmltmp,$res);
$attrsb = $res[1][0];
preg_match_all('|<a href="(.*)">(.*)</a>|iUs',$attrsb,$res);
$writer = implode(',', $res[2]);

preg_match_all('|<span class=\'pl\'>主演</span>: <span class=\'attrs\'>(.*)</span></span><br/>|iUs',$htmltmp,$res);
$attrs = $res[1][0];
preg_match_all('|<a href="(.*)" rel="v:starring">(.*)</a>|iUs',$attrs,$res);
$actor = implode(',', $res[2]);

preg_match_all('|<span class="pl">集数:</span> (.*)<br/>|iUs',$htmltmp,$res);
$jishu = $res[1][0];

preg_match_all('|<span class="pl">类型:</span> (.*)<br/>|iUs',$htmltmp,$res);
$attrlx = $res[1][0];

preg_match('|property="v:average">(.*)</strong>|iUs',$htmltmp,$res);
$pfen = $res[1];

preg_match_all('|<span property="v:genre">(.*)</span>|iUs',$attrlx,$res);
$type = implode(',', $res[1]);

preg_match_all('|format=html5; url=(.*)"|iUs',$htmltmp,$res);
$lailu = $res[1][0]; 

preg_match_all('|<div class="tags-body">(.*)</div>|iUs',$htmltmp,$res);
$keywords = $res[1][0];
preg_match_all('|<a href="/tag/(.*)" class="">(.*)</a>|iUs',$keywords,$res);
$keywordss = implode(',', $res[2]);

preg_match_all('|<span property="v:votes">(.*)</span>|iUs',$htmltmp,$res);
$hits = $res[1][0];

preg_match_all('|data-image="(.*)"|iUs',$htmltmp,$res);
$pic = $res[1][0];
preg_match_all('|<span property="v:summary" class="(.*)">(.*)</span>(.*)</div>|iUs',$htmltmp,$res);
$content1 = $res[2][0];
preg_match_all('|<span class="all hidden">(.*)</span>|iUs',$htmltmp,$res);
$content2 = $res[1][0];
$stars = '1';
if(!empty($content1)){
	$content = $content1;
}else{
	$content = $content2;
}
if ($jsons) {
	$echoArr = json_decode($echojsons,true);
	$echoArr['data']['vod_reurl'] = str_replace('m.douban.com/movie','movie.douban.com',$lailu);
	$echoArr['data']['vod_name'] = $name;
	$echoArr['data']['vod_title'] = $title;
	$echoArr['data']['vod_total'] = $jishu;
	$echoArr['data']['vod_pic'] = str_replace('https://','http://',$pic);
	$echoArr['data']['vod_gold'] = $pfen;
	$echoArr['data']['vod_filmtime'] = str_replace(array('/','(',')',' '),'',preg_replace('/[\x80-\xff,a-z,A-Z]/','',$sytime));
	$echoArr['data']['vod_year'] = $year;
	$echoArr['data']['vod_hits'] = $hits;
	$echoArr['data']['vod_area'] = str_replace(array('中国大陆','美国','中国香港','中国台湾','日本','韩国','英国','法国','德国','意大利','西班牙','印度','泰国','俄罗斯','伊朗','加拿大','澳大利亚','爱尔兰','瑞典','巴西','丹麦'),array('中国内地','美国','中国香港','中国台湾','日本','韩国','英国','法国','德国','意大利','西班牙','印度','泰国','俄罗斯','伊朗','加拿大','澳大利亚','爱尔兰','瑞典','巴西','丹麦'),$country);
	$echoArr['data']['vod_language'] = str_replace(array('汉语普通话','粤语','普通话/国语','法语','德语','日语','韩语','泰语','俄语','葡萄牙','波兰语','印度语','意大利语','波斯语','罗马尼亚语','挪威语','西班牙语','捷克语','冰岛语'),array('国语','粤语','国语','法语','德语','日语','韩语','泰语','俄语','葡萄牙语','波兰语','印度语','意大利语','波斯语','罗马尼亚语','挪威语','西班牙语','捷克语','冰岛语'),$language);
    $echoArr['data']['vod_type'] = $type;
	$echoArr['data']['vod_actor'] = $actor;
	$echoArr['data']['vod_writer'] = $writer;
	$echoArr['data']['vod_director'] = $director;
	$echoArr['data']['vod_length'] = str_replace(array('分钟','分','min','日本','德国','美国','(',')',' '),'',$length);
    $search = array("　","\n","\r","\t","<br/>","<br />");
    $strbb = array("","","","","","");
	$echoArr['data']['vod_content'] = str_replace($search, $replace, $content);
	$echoArr['data']['vod_keywords'] = $keywordss;
	$echoArr['data']['vod_douban_id'] = $id;
	$echoArr['data']['vod_douban_score'] = $pfen;
	$echoArr['data']['vod_imdb_id'] = $imdb;
	$echoArr['data']['vod_stars'] = $stars;
	echo 'DouBan('.json_encode($echoArr).');';
	unset($echoArr);
	unset($jsons);
	exit;
}