function getans(thix, x) {
    var gethttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        gethttp = new XMLHttpRequest();
    }
    else {
        // code for IE6, IE5
        gethttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    gethttp.open("POST", 'checkans.php', true);
    gethttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    gethttp.send("submit_id=" + x);
    gethttp.onreadystatechange = function () {
        if (gethttp.readyState == 4 && gethttp.status == 200) {
            var res = gethttp.responseText;
            //$(thix).html(res);
            if (res == 'panding') {
                $(thix).html("<i class='am-icon-spinner am-icon-spin'></i>判题中");
                $(thix).attr("class", "am-btn am-btn-warning");
                $(thix).attr("disabled", "disabled");
                setTimeout(function () {
                    getans(thix, x);
                }, refreshTime());
            } else if (res == 'AC') {
                $(thix).html("<i class='am-icon am-icon-check-square'></i>正确");
                $(thix).attr("class", "am-btn am-btn-success");
                $(thix).removeAttr("disabled");
            } else if (res.substring(0, 2) == 'WA') {
                if (res.substring(4) == '' || res.substring(4) == '00')msg = '错误';
                else msg = "部分正确  " + res.substring(4) + "%";
                $(thix).html("<i>" + msg + "</i>");
                $(thix).attr("class", "am-btn am-btn-danger");
                $(thix).removeAttr("disabled");
            } else if (res.substring(0, 2) == 'CP') {
                msg = '编译错误';
                $(thix).html("<i>" + msg + "</i>");
                $(thix).attr("class", "am-btn am-btn-danger");
                $(thix).removeAttr("disabled");
            } else if (res.substring(0, 3) == 'TLE') {
                msg = '时间超限';
                if (res.substring(5) == '' || res.substring(5) == '00');
                else if (res.substring(5) != '##') {
                    msg += "," + res.substring(5) + "%正确";
                    $(thix).html("<i>" + msg + "</i>");
                    $(thix).attr("class", "am-btn am-btn-danger");
                    $(thix).removeAttr("disabled");
                } else {
                    $(thix).html("<i>" + msg + "</i>");
                    $(thix).attr("class", "am-btn am-btn-danger");
                    $(thix).removeAttr("disabled");
                    setTimeout(function () {
                        getans(thix, x);
                    }, refreshTime());
                }
            } else if (res.substring(0, 3) == 'MLE') {
                msg = '内存超限';
                if (res.substring(5) == '' || res.substring(5) == '00');
                else msg += "," + res.substring(5) + "%正确";
                $(thix).html("<i>" + msg + "</i>");
                $(thix).attr("class", "am-btn am-btn-danger");
                $(thix).removeAttr("disabled");
            } else if (res == "wait") {
                $(thix).html("比赛模式");
                $(thix).attr("class", "am-btn am-btn-warning");
                $(thix).removeAttr("disabled");
            }
        }
    }
}
function showSubmit(thix, x) {
    var getcodehttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        getcodehttp = new XMLHttpRequest();
    }
    else {
        // code for IE6, IE5
        getcodehttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    getcodehttp.onreadystatechange = function () {
        if (getcodehttp.readyState == 4 && getcodehttp.status == 200) {
            $("#ansarea").val(getcodehttp.responseText);
            var xmlhttp;
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if (xmlhttp.responseText.substring(0, 2) != 'ok') {
                        $(thix).attr("class", "am-btn am-btn-default");
                        $(thix).attr("disabled", "disabled");
                        $(thix).html(xmlhttp.responseText);
                        $.AMUI.progress.done();
                    }
                    else {
                        $(thix).html("<i class='am-icon-spinner am-icon-spin'></i> 提交成功");
                        $(thix).attr("class", "am-btn am-btn-warning");
                        $(thix).attr("disabled", "disabled");
                        $.AMUI.progress.done();
                        setTimeout(getans(thix, xmlhttp.responseText.substring(3)), refreshTime());
                    }

                }
            }
            $('#my-prompt').modal();
            $(function () {
                var $prompt = $('#my-prompt');
                var $confirmBtn = $prompt.find('[data-am-modal-confirm]');
                var $cancelBtn = $prompt.find('[data-am-modal-cancel]');
                $confirmBtn.unbind("click");
                $confirmBtn.on('click', function (e) {
                    // do something
                    xmlhttp.open("POST", 'submit.php', true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    //alert(encodeURIComponent($("#ansarea").val()));
                    xmlhttp.send("pid=" + x + "&ans=" + encodeURIComponent($("#ansarea").val()));
                    $("#ansarea").val("");
                    $.AMUI.progress.start();
                });

                //$cancelBtn.off('click.cancel.modal.amui').on('click', function() {
                // do something
                // });
            });
            $.AMUI.progress.done();
        }
    }
    getcodehttp.open("GET", "showcode.php?pid=" + x, true);
    getcodehttp.send();
    $.AMUI.progress.start();
}