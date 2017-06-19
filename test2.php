<?php

// student   score

// 6 ... 查询  所有同学
$sql = "select st.id,st.name,sc.subject,sc.score from student st left join score sc on st.id=sc.stu_id";

// 7..  第一名  姓名 总分
$sql = "select st.id,sc.score_sum from student st left join ( select stu_id,sum(score) score_sum from score group by stu_id ) as sc on st.id=sc.stu_id";

// 8.. 没有有 考试的
$sql = "select * from student id not in (select stu_id from score group by stu_id)";

// 9.. css  设置 块 级元素 居中
text-align:center;
magin: 0px auto;

// 10 ..离左右 都是 20 px；
width: 100%;   不会；
magin-left:20px;
magin-right: 20px;

// 11 .. z-index
上浮，  数字 越大，， 层次越高 ， 嫦用于 遮罩层，， 适用于所有元素， 行内 元素 可以 转 成 块级 元素 使用

//  12.。 ajax  异步请求
也可以同步请求，适用于 前端用来 请求数据，支持 post，get，方式 请求， 支持 jsonp 跨域请求。  对 跨域请求的 方式不是很好，只能支持get方式
其 根本 跨域的功能 居于 <script src=>  这个标签。
总结，很好很方便 请求功能

//  13 .. 判断 是否 存在 id
if( $('#divA') == NULL || $('#divA') == 'undefined' ) alert( 'divA 该id 不存在' );
 
 // 14..  定时 任务 真 几部住




