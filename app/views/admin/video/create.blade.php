@extends('admin.layouts.master')

@section('title')新增视频@stop

@section('content')
<div class="page-container">
    <form class="form form-horizontal" id="form-article-add" onsubmit="return false">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>视频名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="请填写视频名称" name="video_name">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>视频链接：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="请填写视频链接。提示：rtmp流不支持ios" name="video_link">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>视频宽度：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="请填写视频宽度" name="width">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>视频高度：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="请填写视频高度" name="height">
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <span class="btn btn-primary radius js-submit" type="button"><i
                            class="Hui-iconfont">&#xe632;</i> 保存</span>
                <span class="btn btn-default radius js-close" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</span>
            </div>
        </div>
    </form>
</div>
@stop

@section('javascript')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    $(function () {


        //表单提交
        $(".js-submit").click(function () {
            var video_name = $("input[name='video_name']").val()
            var video_link = $("input[name='video_link']").val()
            var width = $("input[name='width']").val()
            var height = $("input[name='height']").val()

            video_name = $.trim(video_name)
            video_link = $.trim(video_link)
            width = $.trim(width)
            height = $.trim(height)

            if (video_name.length == 0) {
                layer.alert('请输入视频名称')
                return false
            }

            if (video_link.length == 0) {
                layer.alert('请输入视频链接')
                return false
            }

            if (width.length == 0) {
                layer.alert('请输入视频宽度')
                return false
            }

            if (height.length == 0) {
                layer.alert('请输入视频高度')
                return false
            }

            $.ajax({
                url: "{{ url('admin/video/create') }}",
                data: {
                    'video_name': video_name,
                    'video_link': video_link,
                    'width': width,
                    'height': height
                },
                type: "POST",
                dataType: "JSON",
                success: function (response) {

                    ///成功
                    if (response.errorCode === '10000') {
                        layer.msg(response.data, {icon: 1, time: 3000}, function () {

                            //刷新父级页面
                            parent.location.reload();
                        })
                        return
                    }

                    //失败
                    if (response.errorCode === '20000') {
                        layer.alert(response.data);
                        return
                    }

                    //其他异常
                    layer.alert(response.msg);
                    return

                }
            })
        })

        $(".js-close").click(function () {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        })
    })
</script>
@stop