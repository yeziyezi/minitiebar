
$(function(){
    var validate = $("#register_form").validate({
        debug: true, //调试模式取消submit的默认提交功能   
        //errorClass: "label.error", //默认为错误的样式类为：error   
        focusInvalid: false, //当为false时，验证无效时，没有焦点响应  
        onkeyup: false,   
        submitHandler: function(form){   //表单提交句柄,为一回调函数，带一个参数：form   
            alert("确认注册？");   
            form.submit();   //提交表单   
        },   
        
        rules:{
            username:{
                required:true,
                rangelength:[6,20],
                remote:{
                    url:"../../linkup_db/validation/username_validate.php",
                    type:"post",
                    data:{
                        username:function(){
                            return $("#username").val();
                        }
                    }
                }
            },
            password:{
                required:true,
                rangelength:[6,20]
            },
            repeat_password:{
                required:true,
                rangelength:[6,20],
                equalTo:"#password"
            },
            email:{
                required:true,
                email:true
            }                    
        },
        messages:{
            username:{
                remote:"用户名已存在！"
            }
                                      
        }
                  
    });    

});