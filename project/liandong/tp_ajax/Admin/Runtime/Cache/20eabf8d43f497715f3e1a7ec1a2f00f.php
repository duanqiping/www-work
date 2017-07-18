<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ThinkPHP二级联动</title>
<script src="__PUBLIC__/js/jquery-1.8.0.min.js"></script>

<script>
$(document).ready(function(){
	 getSection();
    
    $("#sectionid").change(function(){
     getCatid();
    });
    
    
 function getSection()
    {
     $.getJSON("__URL__/getSection", function(data) {
      $.each(data, function(i, item) {
       $("<option></option>").val(item['id']).text(item['title']).appendTo($("#sectionid"));
      });
		getCatid();
     });
    }
  function getCatid()
    {
     $("#catid").empty();
     $.getJSON("__URL__/getCatid",  {id:$("#sectionid").val()}, function(data) {
      $.each(data, function(i, item) {
       $("<option></option>").val(item['id']).text(item['title']).appendTo($("#catid"));
      });
   
     });
    }
    
   
});
	
	
</script>
<link rel="stylesheet" type="text/css" href="../Public/css/index.css" />
</head>
<body>
<h1>ThinkPHP_JQuery_Ajax二级联动</h1>
<form id="myform">
   <select name="sectionid" id="sectionid"></select>
   <select name="catid" id="catid"></select>
</form>
<p>电公子制作</p>
</body>
</html>