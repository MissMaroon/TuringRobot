<?php
   echo header("Content-type: text/html; charset=utf-8");
?>
<html>
<head>
   <title></title>
   <link rel="stylesheet" type="text/css" href="./css/c.css" />
   <script type="text/javascript" src="./js/jquery-1.12.3.js"></script>
</head>
<body>
<div class="phone">
<div class="p_top"></div>
<div class="p_info"></div>
<div class="p_title">图灵机器人-智能客服</div>
<div class="p_content">
   <div class="p_msg" id="msg">

      <div class="p_msg_left">
         <div class="img_div_left"><img src="./images/1.png" /></div>
         <div class="text_div_left">周润涛好帅啊!</div>
      </div>

      <div class="p_msg_right">
         <div class="img_div_right"><img src="./images/nv.png" /></div>
         <div class="text_div_right">那是当然呀!我超喜欢他了</div>
      </div>
   </div>
   <div class="p_input">
      <input type="text" class="p_text" id="text"/>
      <input type="button" value="发送" class="p_btn" id="btn"/>
   </div>
</div>
<div class="p_buttom"></div>

</div>
<script>
   $("#btn").click(function() {
      var value = $("#text").val();
      $("#text").val("");
      $("#msg").append("<div class='p_msg_left'>"+
      "<div class='img_div_left'><img src='./images/1.png'/></div>"+
      "<div class='text_div_left'>"+value+"</div></div>");
      $.post("./common.php",
          {
             value:value,
          },
          function(data){
             var obj = jQuery.parseJSON(data);
             if(obj.code == 100000){
                $("#msg").append("<div class='p_msg_right'>"+"<div class='img_div_right'><img src='./images/nv.png'></div>"+
                    "<div class='text_div_right'>"+obj.text+"</div></div>");
             }else if(obj.code == 200000){
                $("#msg").append("<div class='p_msg_right'>"+"<div class='img_div_right'><img src='./images/nv.png'></div>"+
                    "<div class='text_div_right'>"+obj.text+obj.url+"</div></div>");
             }else if(obj.code == 302000){
                var v="";
                $.each(obj.list,function(a,b){
                   v += b.article;
                   v += b.detailurl;
                   v += "  ";
                });
                $("#msg").append("<div class='p_msg_right'>"+"<div class='img_div_right'><img src='./images/nv.png'></div>"+
                    "<div class='text_div_right'>"+v+"</div></div>");
             }

          });




   });

</script>
</body>
</html>