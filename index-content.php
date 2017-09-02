<div class="am-g">
    <h1 style="text-align:center; margin:0;"><?php require_once 'config.php';
        print($CONTEST_NAME); ?></h1>
</div>

<div class="am-g">
    <h4 style="text-align:center; margin:0; color:red;"><?php require_once 'config.php';
        print($BEGIN_TIME . '——' . $END_TIME); ?></h4>
</div>
<hr/>
<marquee style="background-color: lightblue"><?php print($NOTICE) ?></marquee>
<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <table class="am-table am-table-bordered am-table-radius am-table-centered">
            <tr>
                <td><strong>点击右侧按钮下载试题压缩包</strong></td>
                <td><a class="am-btn am-btn-primary" href="<?php require_once 'config.php';
                    print($PROBLEM_RAR); ?>">点击下载</a>
                </td>
            </tr>
            <!--
            <tr>
                <td><strong>点击右侧按钮下载浏览器</strong></td>
                <td><a class="am-btn am-btn-primary" href="<?php require_once 'config.php';
                    //print("Chrome.exe"); ?>">浏览器</a>
                </td>
            </tr>
            <tr>
                <td><strong>点击右侧按钮下载编译器</strong></td>
                <td><a class="am-btn am-btn-primary" href="<?php require_once 'config.php';
                    //print("Dev-Cpp5.4.exe"); ?>">Dev</a>
                </td>
            </tr>
            -->
            <?php
            require_once 'DBCN.php';
            require_once 'config.php';
            $db = new DB();
            //查询
            $data['contest_code'] = $CONTEST_CODE;
            $judge['contest_code'] = '=';
            $data['user_id'] = $_SESSION['user_id'];
            $judge['user_id'] = '=';
            $judge['pid'] = '=';
            foreach ($problemArray as $key => $value) {
                if ($key != '0') {
                    $des = $value['des'];
                    print("<tr><td>$key.$des</td>");
                    $data['pid'] = $key;
                    list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
                    $mData = $db->fetch('select * from blueSySSubmit where ' . $conSql . ' order by `submit_id` desc', $mapConData);
                    if ($mData && isset($mData['submit_id']) && $mData['submit_id'] != '') {
                        $submitid = $mData['submit_id'];
                        $js = "getans('#btn" . $key . "',$submitid)";
                    };
                    print("<td><button class='am-btn am-btn-primary' id='btn$key' onclick='showSubmit(this,$key);'>提 交</button></td>");
                    if (isset($js)) print("<script type='text/javascript'>$js</script>");
                }
            }
            ?>
        </table>
        <?php
        $current_time = time();
        if (($current_time > strtotime($END_TIME)) || isset($_SESSION['administrator'])) {
            print("<button type='button' class='am-btn am-btn-primary am-btn-block' onclick=\"location.href='ranklist.php'\">查看排名</button>");
        }
        ?>
    </div>
</div>
<?php include_once "blue-footer.php" ?>

<div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">提交窗口</div>
        <div class="am-modal-bd">
            <!--            <p style="color:red;">结果填空只需要填结果和空缺代码，请不要有多余的空格。</p>-->
            <textarea style="width:100%;" id="ansarea" cols="65" rows="5"></textarea>
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span class="am-modal-btn" data-am-modal-confirm>提交</span>
        </div>
    </div>
</div>
