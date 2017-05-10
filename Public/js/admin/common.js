/**
 * Created by Administrator on 2017/4/21.
 */

//添加按钮
$("#button-add").click(function () {
    var url = SCOPE.add_url;
    window.location.href = url;
});


//提交菜单
$("#singcms-button-submit").click(function () {
    //获取表单的值
    var formData = $("#singcms-form").serializeArray();
    // console.log(formData);
    var postData = {};
    $(formData).each(function () {
        postData[this.name] = this.value;
    })
     //console.log(postData);
    var url = SCOPE.save_url;
    var success_url = SCOPE.jump_url;
    //使用ajax 提交数据到后台
    $.post(url, postData, function(result){
        //console.log(result);
        if(result.status == 0) {
            dialog.error(result.msg);
        }
        if(result.status == 1) {
            dialog.success(result.msg, success_url);
        }
    },'JSON');


});

//编辑模式
$(".singcms-table #singcms-edit").on("click", function() {
    var menuId = $(this).attr("attr-id");
    var url = SCOPE.edit_url+"&id="+menuId;
    window.location.href = url;
});


// 删除 实际是改变status为-1 让其不想
$(".singcms-table #singcms-delete").on("click", function() {
    var menuId = $(this).attr("attr-id");
    var msg = $(this).attr("attr-message");
    var url = SCOPE.set_status_url;

    data = {};
    data['id'] = menuId;
    data['status'] = -1;

    layer.open({
        icon : 3,
        content : "是否确认"+msg,
        btn : ['是','否'],
        yes : function() {
            //执行相关操作
            delData(url, data);
        },
    });

});


function delData(url, data) {
    console.log(data);
    $.post(url, data, function(result){
        if(result.status == 0) {
            dialog.error(result.msg);
        }
        if(result.status == 1) {
            dialog.success(result.msg, '');
        }
    }, 'JSON');
}


//排序
$("#button-listorder").on("click", function() {
    //点击后获取表单中的值
    var formData = $("#singcms-listorder").serializeArray();
    var postData = {};
    $(formData).each(function(i) {
        postData[this.name] = this.value;
    });
    var url = SCOPE.listorder_url;
    $.post(url, postData, function(result) {
        console.log(result);
        if(result.status == 0) {
            dialog.error(result.msg);
        } else if(result.status == 1) {
            dialog.success(result.msg, result['data']['ref_url']);
        }
    }, 'JSON');
});