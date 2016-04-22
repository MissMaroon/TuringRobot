<?php
/**
  * wechat php test wdf
  */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();

if($_GET['echostr'])
{
	$wechatObj->valid();
}else
{
	$wechatObj->responseMsg();
}
class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
		    	$Event = $postObj->Event;
			    $EventKey = $postObj->EventKey;
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
				$imgTpl = "	<xml>
                       	<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>1</ArticleCount>
						<Articles>
						<item>
						<Title><![CDATA[欢迎参加极客学院]]></Title>
						<Description><![极客学院微信公众平台开发视频教程]]></Description>
						<PicUrl><![CDATA[http://www.sinaimg.cn/dy/slidenews/4_img/2015_11/704_1575962_849639.jpg]]></PicUrl>
						<Url><![CDATA[http://www.jikexueyuan.com]]></Url>
						</item>
						</Articles>
						</xml>";
			    if($Event == "CLICK" and $EventKey == "V1001_TODAY_MUSIC"){
					$msgType = "text";
					$contentStr = "欢迎查看天气";
					$resultStr = sprintf($imgTpl, $fromUsername, $toUsername, $time);
					echo $resultStr;
				}
			    if($Event == 'subscribe'){
					$msgType = "text";
					$contentStr = "欢迎关注";
					$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
					echo $resultStr;
				}
			    //关键字回复
				if(!empty( $keyword ))
                {
              		$msgType = "news";
                	$contentStr = "hello world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>
