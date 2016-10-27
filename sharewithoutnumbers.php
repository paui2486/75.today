<!-- share-start -->                    
<div class="span8" style="display: block; overflow:hidden;">


    <!-- FB fanpage like-start -->
    <div style="float:left; width:0px;">
        <div class="fb-like" data-href="https://www.facebook.com/iwine" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
    </div>
      <!-- FB fanpage like-end -->
    
    <!-- G+ share button-start -->
    <div style="float:left; padding-left:0px;">
        <!--div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div-->
        <a href="https://plus.google.com/share?url=<?php echo $cur_url; ?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img
  src="https://www.gstatic.com/images/icons/gplus-32.png" alt="Share on Google+"/></a>
    </div>
      <!-- G+ share button-end -->
    
    
    <!-- G+ share js-start -->
    <script type="text/javascript">
          window.___gcfg = {lang: 'zh-TW'};

          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/platform.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
    </script>
        <!-- G+ share js-end -->
    

    <!-- current page fb like-start -->
    
    <div style="float:left; padding-left:10px; width:80px;">
        <div class="fb-like" data-href="<?php echo $cur_url; ?>" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
    </div>
    
    <?php
    //Detect special conditions devices
    $iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
    if(stripos($_SERVER['HTTP_USER_AGENT'],"Android") && stripos($_SERVER['HTTP_USER_AGENT'],"mobile")){
            $Android = true;
    }else if(stripos($_SERVER['HTTP_USER_AGENT'],"Android")){
            $Android = false;
            $AndroidTablet = true;
    }else{
            $Android = false;
            $AndroidTablet = false;
    }

    $webOS = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $BlackBerry = stripos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $RimTablet= stripos($_SERVER['HTTP_USER_AGENT'],"RIM Tablet");
 
//do something with this information
    if( $iPhone || $Android){ ?>
                <div style="float:left; padding-left:10px;">
                 <a href="http://line.naver.jp/R/msg/text/?<? echo $row_article['title']; ?>：<?php echo $row_article['title'] ?>%0D%0A<?php echo $cur_url; ?>"><img src="images/linebutton_20x20.png"></a>
                </div>
    <?php } ?> 
        <!-- current page fb like-end -->
    
    
    <!-- plurk share -->
    <div style="float:left; padding-left:10px; height:70px;">
        <a title="分享在我的 plurk" href="javascript:void(window.open('http://www.plurk.com/?qualifier=shares&status='.concat(encodeURIComponent(window.location.href)).concat('').concat(' (').concat(encodeURIComponent(document.title)).concat(')')));"><image src="http://www.iwine.com.tw/webimages/plurk.png" width="30px" height="30px" border="0"></a>
    </div>
       <!-- plurk share-end -->
    
    
    <!-- weibo-start -->
    <div style="float:left; padding-left:10px; padding-right:10px; height:70px;">
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $row_article['title']; ?>&url=<?php echo $cur_url;?>" target="_blank" title="分享到新浪微博">
            <image src="http://www.iwine.com.tw/webimages/sinaweibo.gif" width="30px" height="30px" border="0" title="分享到我的 weibo">
        </a>
    </div>
        <!-- weibo-end -->
    
    
    <!-- Twitter-start -->
    <div style="float:left;">
        
        <a class="twitter-share-button" href="https://twitter.com/share"
  data-related="twitterdev"
  data-size="large"
  data-count="none">
Tweet
</a>
<script>
window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
</script>
    </div>
        <!-- Twitter-end -->
    
    
    </div>
    
<!-- share-end--> 