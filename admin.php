<?php

#=================================================[������롼����]====

#�������Х��ѿ��ν����
$StdLib 	= "lib/kstd.php";
$SqlLib 	= "lib/ksql.php";
$JcodeLib 	= "lib/jcode.php";
$Mimelib	= "lib/mimew.php";
$Glib		= "lib/hlib.php";
$MainINIFile	= "ini/h.ini";
$ThisFile	= $SCRIPT_NAME;

#---------------------------------------------------------------------

require "$StdLib";	#���ꥸ�ʥ�ɸ��饤�֥������
require "$SqlLib";	#�ӣѣ̥饤�֥������
#require "$JcodeLib";	#ʸ���������Ѵ��饤�֥������
#require "$Mimelib";	#�ͣɣͣť饤�֥������
require "$Glib";	#hamada-r�饤�֥������

Init_Form("euc");
Init_Tag();

$INI = array();
$INI = InitINIData(1,$MainINIFile);

#�ӣѣ̽����
Init_SQL();

Init_H();

#==================================================================================[�ᥤ��롼����]==
#����������������������������������������������������������������������������������������������������
#====================================================================================================

#�����
$act = GetVal("act");
if($act == "") {
	$act = "menu";
}

if(file_exists("lib/admin/" . $act . ".php")) {
	require "lib/admin/" . $act . ".php";
}






#�ӣѣ���³
ConnectSQL();

#�ۡ���
if($act == "menu") {

	$K = ConvVal(ReadFileData("html/admin_menu.html",3));

} elseif($act == "db") {

	DB();

} elseif($act == "sub") {

	SUB();

} elseif($act == "csvupload") {

	CSVUpload();

} else {

	$K = "$AdminTitle";

}

PB_ADMIN();

#�ӣѣ���³
DisconnectSQL();



exit;

#====================================================================================[���֥롼����]==
#����������������������������������������������������������������������������������������������������
#====================================================================================================


#======================================================================================[�饤�֥��]==
#����������������������������������������������������������������������������������������������������
#====================================================================================================






?>