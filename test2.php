<?php

// student   score

// 6 ... ��ѯ  ����ͬѧ
$sql = "select st.id,st.name,sc.subject,sc.score from student st left join score sc on st.id=sc.stu_id";

// 7..  ��һ��  ���� �ܷ�
$sql = "select st.id,sc.score_sum from student st left join ( select stu_id,sum(score) score_sum from score group by stu_id ) as sc on st.id=sc.stu_id";

// 8.. û���� ���Ե�
$sql = "select * from student id not in (select stu_id from score group by stu_id)";

// 9.. css  ���� �� ��Ԫ�� ����
text-align:center;
magin: 0px auto;

// 10 ..������ ���� 20 px��
width: 100%;   ���᣻
magin-left:20px;
magin-right: 20px;

// 11 .. z-index
�ϸ���  ���� Խ�󣬣� ���Խ�� �� ������ ���ֲ㣬�� ����������Ԫ�أ� ���� Ԫ�� ���� ת �� �鼶 Ԫ�� ʹ��

//  12.�� ajax  �첽����
Ҳ����ͬ������������ ǰ������ �������ݣ�֧�� post��get����ʽ ���� ֧�� jsonp ��������  �� ��������� ��ʽ���Ǻܺã�ֻ��֧��get��ʽ
�� ���� ����Ĺ��� ���� <script src=>  �����ǩ��
�ܽᣬ�ܺúܷ��� ������

//  13 .. �ж� �Ƿ� ���� id
if( $('#divA') == NULL || $('#divA') == 'undefined' ) alert( 'divA ��id ������' );
 
 // 14..  ��ʱ ���� �� ����ס




