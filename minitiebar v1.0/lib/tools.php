<?php

function create_uuid($prefix = ""){    //得到一个uuid,可以指定前缀
    $str = md5(uniqid(mt_rand(), true));   
    $uuid  = substr($str,0,8) . '-';   
    $uuid .= substr($str,8,4) . '-';   
    $uuid .= substr($str,12,4) . '-';   
    $uuid .= substr($str,16,4) . '-';   
    $uuid .= substr($str,20,12);   
    return $prefix . $uuid;
}

function post_editor(){//发帖使用的简易编辑器
?>
    <form action="/linkup_db/post/post_submit.php" method="post">
        <div name="post_editor">
            标题<br/>
            <input name="post_title" style="width:100%"><br/>
            正文<textarea  style="width:100%; height:20%" name="post_content">
            </textarea>
            <input type="submit" value="发帖">
        </div>
    </form>        
<?php    
}
function post_digest(array $post_columns){//吧页面上的贴子摘要
?>

    <div  name="post_digest" id="<?php echo $post_columns['post_id']?>" style="border-style: solid ;border-color:gray">
    <a href="/tie.php?bar_id=<?php echo $post_columns['bar_id']?>&post_id=<?php echo $post_columns['post_id']?>">
    <strong><h3><?php echo $post_columns['post_title']?></h3></strong>
    </a>
        <p>发布者：<?php echo $post_columns['username']?></p>
        <p><?php echo $post_columns['post_content']?></p>
        <p>发布时间 <?php echo $post_columns['publish_time']?>|
            最后回复时间<?php echo $post_columns['last_reply_time']?>|
            回复数<?php echo $post_columns['reply_num']?>
        </p>
    </div>

<?php
}
function post_view($post_array){//贴子页面内的一楼
$post_title=$post_array['post_title'];
$post_content=$post_array['post_content'];
$publish_time=$post_array['publish_time'];
$post_owner=$post_array['post_owner'];
?>
    <div name="post_view" style="border:1px solid #000;width:100%" >
        <p><h3><?php echo $post_title?></h3></p>
        <p><?php echo $post_owner?> | <?php echo $publish_time?></p>
<?php
//如果长度超过98
    if(strlen($post_content)>100){
        $post_content_short=substr($post_content,0,98)."...";
?>

        <p id="content"><?php echo $post_content_short?></p>
        <a onclick="showAllContent()" id="show_click">查看全文</a><br/>
        <script>
            function showAllContent(){
                //用js替换为全文内容
                document.getElementById("content").innerHTML="";
                document.getElementById("content").innerHTML="<?php echo $post_content?>";
                //删掉查看全文超链接
                var click_a=document.getElementById("show_click");
                var div=document.getElementsByName("post_view")[0];
                div.removeChild(click_a);
            }

        </script>
        
<?php
    }else{
        echo "<p>".$post_content."</p>";
    }
?>        
    </div>
<?php    
}
function reply_editor($user_id){//生成回复编辑器
?>
    <div>
        <form method="post" action="/linkup_db/post/reply_submit.php" >
            <textarea name="content"  style="width:100%; height:20%"></textarea>
            <input type="hidden" name="replyer_id" value="<?php echo $user_id?>">
            <input type="submit" value="回复"><br/>
        </form>
    </div>
<?php    
}
function reply_view(bool $reply_enable,array $reply,array $inner_reply=null){//贴中楼层view
    $r_id=$reply["reply_id"];
    $r_content=$reply['reply_content'];
    $r_time=$reply['reply_time'];
    $r_username=$reply['username'];
    $r_to_id=$r_id;//由于回复的目标时层主，所以两个值一致
?>
    <div style="border:1px solid #000;width:100%" id="<?php echo $r_id?>" class="ir">
        <p><?php echo $r_username?> | <?php echo $r_time?>|
<?php       
    if($reply_enable){
?>            
            <button  name="reply" onclick="create_ir_submit_form('<?php echo $r_id?>','<?php echo $r_to_id?>')">回复</button>
        </p>
    <script>
        function create_ir_submit_form(r_id,r_to_id){
            
            var div=$("#"+r_id);
            $("#irdiv-"+r_id).remove();
            div.append("<div id='irdiv-"+r_id+"'></div>")
            $("#irdiv-"+r_id).append(
                "<form action='/linkup_db/post/inner_reply_submit.php' method='post'>"
                +"<input name='content'>"
                +"<input name='reply_id' value='"+r_id+"' type='hidden'>"
                +"<input name='reply_to_id'  type='hidden' value='"+r_to_id+"'>"
                +"<input type='submit' value='回复'>"
                +"</form>"
            );

        }
    </script>
<?php
    }
?>
        <p><?php echo $r_content?></p>
                <?php
                if($inner_reply!=null){
                ?>
                <div style="border:1px solid #000;margin:10px;">
                <?php
                    foreach($inner_reply as $ir){
                        inner_reply_view($ir);
                    }      
                ?>
                </div>
                <?php
                }
                ?>
        </div>
<?php        
}
function inner_reply_view(array $inner_reply){
    $button="<button onclick=\"create_ir_submit_form('".$inner_reply['reply_id'].
    "','".$inner_reply['inner_reply_id']."')\">回复</button>";
    if(strpos($inner_reply["reply_to_id"],"ir")===false){//回复层主
        echo "<p>".$inner_reply['from_username'].": ".$inner_reply['ir_content'].$button."</p>";
    }else{
        echo "<p>".$inner_reply['from_username']."回复".$inner_reply['to_username'].": ".$inner_reply['ir_content'].$button."</p>";
    }
    
}

?>

