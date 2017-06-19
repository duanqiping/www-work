<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2016/3/9
 * Time: 16:52
 */

echo "<title>推送信息</title><br/>";

echo "<form action='addAction.php' method='post'>";

echo "标题: <input type='text' name='title' /><br/><br/>";

echo "内容: <textarea cols='40' rows='5' name='content'></textarea><br/><br/>";
echo "推送设备  所有<input type='radio' name='device' value='0' checked> &nbsp;安卓<input type='radio' name='device' value='1'>  &nbsp;ios<input type='radio' name='device' value='2'> <br/><br/>";
//echo "推荐给谁  群体<input type='radio' name='people' checked> &nbsp;个人<input type='radio' name='people'><br/><br/>";
echo "<input type='submit' value='提交' />&nbsp;&nbsp;";
echo "<input type='reset' value='重置' /><br/>";
echo "</form>";