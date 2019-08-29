<?php

#=================================================[������롼����]====

#�����Х��ѿ��ν����
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

if(!isset($act)) {
	$act = "home";
}

	$step = GetVal("step");
	$substep = GetVal("substep");



#�ӣѣ���³
ConnectSQL();



#�ۡ���
if($act == "home") {

	$K = ConvVal(ReadFileData("html/user_home.html",3));

} elseif($act == "w") {

	if($step == "") {
		$step = "view";
	}


	if($step == "xxx") {


		$K = ConvVal(ReadFileData("html/user_weeklychoosegroup.html",3));
	} elseif($step == "view") {

		$q_orderby = "";
		$f4	= GetVal("f4");
		$fc 	= GetVal("fc");
		$ar 	= GetVal("ar");
		$al 	= GetVal("al");
		$ac 	= GetVal("ac");
		$gid 	= GetVal("gid");
		$pcode 	= GetVal("pcode");
		$qPosSort = GetVal("qPosSort");
		$s	= GetVal("s");


		if($gid == "") {
			$gid = "101";
		}


		#���롼��̾����
		$grpname = GetGrpNameByGrpId($gid);

		#pcode�μ���
		if($pcode == "") {
			ExecSQL("SELECT MAX(CONCAT(pyear,pmon,pweek) + 0) AS pcode FROM nettb");
			$pcode = GetValueFromSTH(1,"pcode");
		}

		#ǯ������μ���
		list($pyear,$pmon,$pweek) = SetPcode($pcode);

		#SELECTʸ���� ---
		$q_where = " WHERE grpid = '" . $gid . "' AND CONCAT(pyear,pmon,pweek) = '" . $pcode . "' ";

		if($qPosSort != "") {

			if($s == "") {
				$s = "b";
				$qDESC = "DESC";
			} else {
				$s = "";
				$qDESC = "";
			}

			$q_orderby = " ORDER BY $qPosSort $qDESC";
		}

		$q = "SELECT (subid + 0) AS subid,name,net FROM nettb $q_where $q_orderby";


		#�ǥХ���
		#Err_Admin($q);

		ExecSQL($q);

		$qfld = array("subid","name","net");
		SetFieldToArray($qfld);

		$subid 	= GetVal("subid");	#�ɣ�
		$name 	= GetVal("name");	#̾��
		$net 	= GetVal("net");	#�Σ��

		$strhtml = "";
		$nettotal = 0;
		for($i = 0; $i < sizeof($subid); $i++) {

			$nettotal = $nettotal + $net[$i];

			$strhtml .= "<tr bgcolor=\"" . Parapara("#EFE8EF") . "\">
					<td $ac>$subid[$i]</td>
					<td $al>$name[$i]</td>
					<td $ar>$net[$i]</td>
				     </tr>
				";
		}


		#¾��pcode�Υ��ʸ������� ---

		$q = "SELECT CONCAT(pyear,pmon,pweek) + 0 AS pcodearray FROM nettb GROUP BY pcodearray";
		ExecSQL($q);
		$qfld = array("pcodearray");
		SetFieldToArray($qfld);
		$pcodearray 	= GetVal("pcodearray");	#�Σ��

		$pcodearray2 = array();
		for($i = 0; $i < sizeof($pcodearray); $i++) {
			list($pyear2,$pmon2,$pweek2) = SetPcode($pcodearray[$i]);
			array_push($pcodearray2,$pyear2 . "ǯ" . ($pmon2 + 0) . "����" . $pweek2 . "��");
		}

		$GLOBALS["pselected"] = $pcode;
		$StrPCodeSelection = MakeSelectionByStrArray(2,"pcode",$pcodearray,$pcodearray2);




		#¾�Υ��롼�פΥ��ʸ������� ---
		$strothersnet = "";
		$gidarray = GetGrpArray("grpid");
		$gnamearray = GetGrpArray("name");

		for($i = 0; $i < sizeof($gidarray); $i++) {

			if($gidarray[$i] == $gid) {
				$strothersnet .= "<FONT CLASS='selectedFont'>$gnamearray[$i]</FONT>��";
			} else {
				$strothersnet .= "<a href=\"$ThisFile?act=w&step=view&gid=$gidarray[$i]&pcode=$pcode\">$gnamearray[$i]</a>��";
			}

			if($i % 5 == 0 and $i != 0) {
				$strothersnet .= "<br> <br>";
			}
		}






		$K = "

			<center>

			 <h3> $pyear ǯ $pmon �� �� $pweek ���� Weekly Net Report </h3> 

			<p>

			<table border=\"1\" cellpadding=\"5\">
			<form name=\"FrmAdmin2\" action=\"$ThisFile\" method=\"post\">
				<tr>
				<td bgcolor=\"#96D698\"> $StrPCodeSelection <input type=\"submit\" value=\"����\"></td>
				<td bgcolor=\"pink\">$f4<b>$nettotal</b>$fc</td>
				</tr>
			<input type=\"hidden\" name=\"act\" value=\"w\">
			<input type=\"hidden\" name=\"step\" value=\"view\">
			<input type=\"hidden\" name=\"gid\" value=\"$gid\">
			</form>
			</table>

			<p>

			<font class=\"sFont\">
			$strothersnet
			</font>

			<p>

			<table class=\"sTable\" border=\"0\" width=\"50%\" cellspacing=\"1\" cellpadding=\"5\" bgcolor='#000000'>
			 <tr bgcolor=\"#FFCC00\">
			  <td width=\"33%\" $ac><a href=\"$ThisFile?act=w&step=view&gid=$gid&pcode=$pcode&qPosSort=subid&s=$s\">IDNO</a></td>
			  <td width=\"33%\" $ac><a href=\"$ThisFile?act=w&step=view&gid=$gid&pcode=$pcode&qPosSort=name&s=$s\">Name</a></td>
			  <td width=\"33%\" $ac><a href=\"$ThisFile?act=w&step=view&gid=$gid&pcode=$pcode&qPosSort=net&s=$s\">Net</a></td>
			 </tr>
			$strhtml
			 <tr bgcolor=\"pink\">
			  <td> &nbsp; </td>
			  <td> &nbsp; </td>
			  <td $ar> $f4<b>$nettotal</b>$fc </td>
			 </tr>
			</table>

			<p>

			<font class=\"sFont\">
			$strothersnet
			</font>

			</center>
			";

	}



#---------------------------------------
# Bulletin
#---------------------------------------
} elseif($act == "b") {

	Bulletin();

#---------------------------------------
# Monthly
#---------------------------------------
} elseif($act == "m") {

	Monthly();

#---------------------------------------
# Comment
#---------------------------------------
} elseif($act == "comment") {

	Comment();

} else {

}

PB();

#�ӣѣ���³
DisconnectSQL();


exit;

#====================================================================================[���֥롼����]==
#����������������������������������������������������������������������������������������������������
#====================================================================================================

function Bulletin() {

	global $ThisFile,$step,$substep,$pcode,$K,$IsLocal,$com1,$com2;





	#�ѿ������ ---
	$q_orderby = "";
	$f4	= GetVal("f4");
	$fc 	= GetVal("fc");
	$ar 	= GetVal("ar");
	$al 	= GetVal("al");
	$ac 	= GetVal("ac");
	$act 	= GetVal("act");

	$kmsg 	= GetVal("kmsg");


	$gid 	= GetVal("gid");
	$sid 	= GetVal("sid");
	$pcode 	= GetVal("pcode");
	$qPosSort = GetVal("qPosSort");
	$s	= GetVal("s");



	if($step == "") {
		$step = "view";
	}


	if($step == "") {
	} elseif($step == "view") {

		#pcode�μ��� ---
		if($pcode == "") {
			ExecSQL("SELECT MAX(CONCAT(pyear,pmon,pweek) + 0) AS pcode FROM nettb");
			$pcode = GetValueFromSTH(1,"pcode");
		}
		#ǯ������μ��� ---
		list($pyear,$pmon,$pweek) = SetPcode($pcode);


		#WHEREʸ���� ---
		$q_where = " WHERE
							CONCAT(n.pyear,n.pmon,n.pweek) = '" . $pcode . "'
						AND n.net > 3
					";

		#GROUP BYʸ���� ---
		$q_groupby = " GROUP BY n.subid";

		#ORDER BYʸ���� ---
		if($qPosSort != "") {

			if($s == "") {
				$s = "b";
				$qDESC = "DESC";
			} else {
				$s = "";
				$qDESC = "";
			}

			$q_orderby = " ORDER BY $qPosSort $qDESC";
		} else {
			$q_orderby = " ORDER BY net DESC";
		}

		#SELECTʸ���� ---
		$q = "
			SELECT 
				(n.subid + 0) AS subid
				,n.name AS name
				,n.net AS net
				,ROUND(SUM(n.net),3) AS pnet
			FROM
				nettb n
			$q_where
			$q_groupby
			$q_orderby
		";

		#�ǥХ��� ---
		#Err_Admin($q);

		#SQL�¹� ---
		ExecSQL($q);

		$qfld = array("subid","name","net");
		SetFieldToArray($qfld);

		$subid 	= GetVal("subid");	#�ɣ�
		#$csubid 	= GetVal("csubid");	#�ɣ�
		$name 	= GetVal("name");	#̾��
		$net 	= GetVal("net");	#�Σ��



		#�����Ȥ�����Ȥ����ȴ�� --- ��������
		$q = "
			SELECT
				c.subid AS csubid
				,CONCAT(n.pyear,n.pmon,n.pweek) AS cpcode
			FROM nettb n,comtb c
			WHERE
				n.pyear 	= c.pyear
				AND n.pmon 	= c.pmon
				AND n.pweek 	= c.pweek
				AND n.subid	= c.subid
		";
		
		ExecSQL($q);
		
		$qfld = array("csubid","cpcode");
		SetFieldToArray($qfld);
		
		$csubid 	= GetVal("csubid");	#csubid
		$cpcode 	= GetVal("cpcode");	#cpcode

		$hascom1 = array();
		for($i = 0; $i < sizeof($csubid); $i++) {
			#print "$cpcode[$i]_$csubid[$i]<br>";
			$hascom1["$cpcode[$i]_$csubid[$i]"] = "1";
		}


		#�����Ȥ�����Ȥ����ȴ�� --- �����ޤ�


		$strhtml = "";
		$nettotal = 0;
		for($i = 0; $i < sizeof($subid); $i++) {

			$nettotal = $nettotal + $net[$i];

			#�����ȥޡ�������
			if(!isset($hascom1[$pcode . "_" . $subid[$i]])) {
				$com1mark = "&nbsp;";
			} else {
				$com1mark = "<a href='$ThisFile?act=comment&m=b&step=v&pcode=$pcode&sid=$subid[$i]'><img src='../images/comfly.gif' border='0'></a>";
			}

			$strhtml .= "<tr bgcolor=\"" . Parapara("#EFE8EF") . "\">
					<td $ac>$subid[$i]</td>
					<td $al>$name[$i]</td>
					<td $ar>$net[$i]</td>
					<td $ac>$com1mark</td>
					<td $ac><a href=\"home.php?act=b&step=w&pcode=$pcode&net=$net[$i]&sid=$subid[$i]\">��</a></td>
				     </tr>
				";
		}


		#¾��pcode�Υ��ʸ������� ---

		$q = "SELECT CONCAT(pyear,pmon,pweek) + 0 AS pcodearray FROM nettb GROUP BY pcodearray";
		ExecSQL($q);
		$qfld = array("pcodearray");
		SetFieldToArray($qfld);
		$pcodearray 	= GetVal("pcodearray");	#�Σ��

		$pcodearray2 = array();
		for($i = 0; $i < sizeof($pcodearray); $i++) {
			list($pyear2,$pmon2,$pweek2) = SetPcode($pcodearray[$i]);
			array_push($pcodearray2,$pyear2 . "ǯ" . ($pmon2 + 0) . "����" . $pweek2 . "��");
		}

		$GLOBALS["pselected"] = $pcode;
		$StrPCodeSelection = MakeSelectionByStrArray(2,"pcode",$pcodearray,$pcodearray2);


		#¾��pcode�Υ��ʸ������� ---

		$q = "SELECT CONCAT(pyear,pmon,pweek) + 0 AS pcodearray FROM nettb GROUP BY pcodearray";
		ExecSQL($q);
		$qfld = array("pcodearray");
		SetFieldToArray($qfld);
		$pcodearray 	= GetVal("pcodearray");	#�Σ��

		$pcodearray2 = array();
		for($i = 0; $i < sizeof($pcodearray); $i++) {
			list($pyear2,$pmon2,$pweek2) = SetPcode($pcodearray[$i]);
			array_push($pcodearray2,$pyear2 . "ǯ" . ($pmon2 + 0) . "����" . $pweek2 . "��");
		}

		$GLOBALS["pselected"] = $pcode;
		$StrPCodeSelection = MakeSelectionByStrArray(2,"pcode",$pcodearray,$pcodearray2);







		$K = "

			<center>

			<h3> $pyear ǯ $pmon �� �� $pweek ���� Bulletin </h3>

			$kmsg

			<table border=\"1\" cellpadding=\"5\">
			<form name=\"FrmAdmin2\" action=\"$ThisFile\" method=\"post\">
				<tr>
				<td bgcolor=\"#96D698\"> $StrPCodeSelection <input type=\"submit\" value=\"����\"></td>
				<td bgcolor=\"pink\">$f4<b>$nettotal</b>$fc</td>
				</tr>
			<input type=\"hidden\" name=\"act\" value=\"b\">
			<input type=\"hidden\" name=\"step\" value=\"view\">
			</form>
			</table>

			<p>

			<table class=\"sTable\" border=\"0\" width=\"50%\" cellspacing=\"1\" cellpadding=\"5\" bgcolor=\"#000000\">
			 <tr bgcolor=\"#FFCC00\">
			  <td width='20%' $ac><a href=\"$ThisFile?act=$act&step=view&gid=$gid&pcode=$pcode&qPosSort=subid&s=$s\">IDNO</a></td>
			  <td width='40%' $ac><a href=\"$ThisFile?act=$act&step=view&gid=$gid&pcode=$pcode&qPosSort=name&s=$s\">Name</a></td>
			  <td width='20%' $ac><a href=\"$ThisFile?act=$act&step=view&gid=$gid&pcode=$pcode&qPosSort=net&s=$s\">Net</a></td>
			  <td width='10%' $ac>��</td>
			  <td width='10%' $ac>��</td>
			 </tr>
			$strhtml
			 <tr bgcolor=\"pink\">
			  <td> &nbsp; </td>
			  <td> &nbsp; </td>
			  <td $ar> $f4<b>$nettotal</b>$fc </td>
			  <td> &nbsp; </td>
			  <td> &nbsp; </td>
			 </tr>
			</table>

			</center>
			";




	}
	elseif($step == "w") {

		#�ѿ������ ---
		$femail 	= GetVal("femail");


		#�᡼�빹���ξ�� ---
		if($femail != "") {
			$q = "
				UPDATE subtb
				SET email = '$femail'
				WHERE subid = '$sid'
			";

			#�ǥХ���
			#Err_Admin($q);


			ExecSQL($q);



		}




		#�����Ȥ�������ͤξ���򥻥åȤ���
		SetSubDataBySudId($sid);



		$name = GetVal("name");
		$email = GetVal("email");

		#pcode����
		list($GLOBALS["pyear"],$GLOBALS["pmon"],$GLOBALS["pweek"]) = SetPcode($pcode);

		$pyear = $GLOBALS["pyear"];
		$pmon = $GLOBALS["pmon"];
		$pweek = $GLOBALS["pweek"];





		if(!preg_match("/@/",$email)) {

			#$K = "$name ����Υ᡼�륢�ɥ쥹�����ꤵ��Ƥ��ޤ���<br> �������̤ˤ����ꤷ�Ʋ�������";
			$K = ConvVal(ReadFileData("html/user_bulletin_w_inputemail.html",3));

		}
		#�񤭹��ߥե����� ----------------
		elseif($substep == "") {





			#$where = " WHERE repid = 'b' AND pyear = '$pyear' AND pmon = '$pmon' AND pweek = '$pweek' AND subid = '$sid'";

			
			#if(GetRows("SELECT repid FROM comtb $where")) {
			#	#Err_Admin("������");
			#	ExecSQL("SELECT com1 FROM comtb $where");
			#	$GLOBALS["com1"] = GetValueFromSTH(1,"com1");
			#}

			if(ComExist(1,'b',$pyear,$pmon,$pweek,$sid)) {
				$GLOBALS["com1"] = GetSpecCom('1','b',$pyear,$pmon,$pweek,$sid);
			}







			#�ȣԣ̺ͣ���
			$K = ConvVal(ReadFileData("html/user_bulletin_w_form.html",3));

		}
		#�������� ------------------------
		elseif($substep == "do_write") {

			#�᡼������
			if(function_exists("mail") and $IsLocal == 0) {
				#Err_Admin($com1);
				mail($email, JJ("��å�����������ޤ�"), JJ($com1));
			}



			$GLOBALS["subid"] = $sid;
			$GLOBALS["grpid"] = GetGrpIdBySubId($sid);
			$GLOBALS["repid"] = "b";



			$where = " WHERE repid = 'b' AND pyear = '$pyear' AND pmon = '$pmon' AND pweek = '$pweek' AND subid = '$sid'";

			if(ComExist(1,'b',$pyear,$pmon,$pweek,$sid)) {
				UpdateFromHash("comtb",$GLOBALS,$where);
			} else {
				InsertFromHash("comtb",$GLOBALS);
			}



			#�ȣԣ̺ͣ���
			$GLOBALS["kmsg"] = Impact("$name ��������Τ��ޤ����� <p>");

			$GLOBALS["step"] = "";


			Bulletin();

		}
	}
	elseif($step == "v") {

		#�����Ȥ�������ͤξ���򥻥åȤ���
		SetSubDataBySudId($sid);


		#pcode����
		list($GLOBALS["pyear"],$GLOBALS["pmon"],$GLOBALS["pweek"]) = SetPcode($pcode);

		$pyear = $GLOBALS["pyear"];
		$pmon = $GLOBALS["pmon"];
		$pweek = $GLOBALS["pweek"];




		#�Ρ��ޥ�⡼��
		if($substep == "") {

			$where = " WHERE repid = 'b' AND pyear = '$pyear' AND pmon = '$pmon' AND pweek = '$pweek' AND subid = '$sid'";

			
			$qfld = array("com1","com2");
			$q = "SELECT com1,com2 FROM comtb $where";
			ExecSQL($q);

			GetValueFromSTH(3,"",$qfld,$GLOBALS);


			if($GLOBALS["com2"] == "") {
				$GLOBALS["com2"] = "�ֻ��ʤ�";
			}


			$GLOBALS["com1"] = preg_replace("/\n/","<br>",$GLOBALS["com1"]);
			$GLOBALS["com2"] = preg_replace("/\n/","<br>",$GLOBALS["com2"]);



			#�ȣԣ̺ͣ���
			$K = ConvVal(ReadFileData("html/user_bulletin_v_comment.html",3));


		}

	}
}





function Monthly() {

	global $ThisFile,$K,$kmsg;


		$q_orderby = "";
		$f4	= GetVal("f4");
		$fc 	= GetVal("fc");
		$ar 	= GetVal("ar");
		$al 	= GetVal("al");
		$ac 	= GetVal("ac");
		$act 	= GetVal("act");
		$gid 	= GetVal("gid");
		$pcode 	= GetVal("pcode");
		$wcnt 	= GetVal("wcnt");
		$qPosSort = GetVal("qPosSort");
		$s	= GetVal("s");




		#pcode�μ���
		if($pcode == "") {
			ExecSQL("SELECT MAX(CONCAT(pyear,pmon) + 0) AS pcode FROM nettb");
			$pcode = GetValueFromSTH(1,"pcode");
		}

		#ǯ������μ���
		$pcode .= "0";
		list($pyear,$pmon,$pweek) = SetPcode($pcode);
		$pcode = $pyear . $pmon;


		#���η�ν��ο������
		if($wcnt == "") {

			#�ǥХ���
			#Err_Admin("SELECT COUNT(*) AS c FROM nettb WHERE CONCAT(pyear,pmon) = '" . $pcode . "' GROUP BY pyear,pmon,pweek");
	
			$wcnt = GetRows("SELECT COUNT(*) AS c FROM nettb WHERE CONCAT(pyear,pmon) = '" . $pcode . "' GROUP BY pyear,pmon,pweek");
	
			#$wcnt = GetValueFromSTH(1,"c");
		}



		#SELECTʸ���� ---
		$q_where = " WHERE CONCAT(pyear,pmon) = '" . $pcode . "' AND net > " . $wcnt;
		$q_groupby = " GROUP BY subid ";

		if($qPosSort != "") {

			if($s == "") {
				$s = "b";
				$qDESC = "DESC";
			} else {
				$s = "";
				$qDESC = "";
			}

			$q_orderby = " ORDER BY $qPosSort $qDESC";
		} else {
			$q_orderby = " ORDER BY net DESC";
		}

		$q = "SELECT (subid + 0) AS subid,name,net,ROUND(SUM(net),3) AS pnet FROM nettb $q_where $q_groupby $q_orderby";


		#�ǥХ���
		#Err_Admin($q);

		ExecSQL($q);

		$qfld = array("subid","name","net");
		SetFieldToArray($qfld);

		$subid 	= GetVal("subid");	#�ɣ�
		$name 	= GetVal("name");	#̾��
		$net 	= GetVal("net");	#�Σ��

		#�����Ȥ�����Ȥ����ȴ�� --- �������� ������������������������������
		$q = "
			SELECT
				c.subid AS csubid
				,CONCAT(n.pyear,n.pmon) AS cpcode
			FROM nettb n,comtb c
			WHERE
				c.repid 	= 'm'
				AND n.pyear 	= c.pyear
				AND n.pmon 	= c.pmon
				AND n.subid	= c.subid
			GROUP BY csubid
		";


		ExecSQL($q);
		
		$qfld = array("csubid","cpcode");
		SetFieldToArray($qfld);

		$csubid 	= GetVal("csubid");	#csubid
		$cpcode 	= GetVal("cpcode");	#cpcode

		$hascom1 = array();
		for($i = 0; $i < sizeof($csubid); $i++) {
			#print "$cpcode[$i]_$csubid[$i]<br>";
			$hascom1["$cpcode[$i]_$csubid[$i]"] = "1";
		}
		#�����Ȥ�����Ȥ����ȴ�� --- �����ޤ� ������������������������������

		$strhtml = "";
		$bigfonts = "<FONT CLASS='F16B'>";
		$bigfontc = "</FONT>";
		$nettotal = 0;
		for($i = 0; $i < sizeof($subid); $i++) {

			$nettotal = $nettotal + $net[$i];

			if($i == $wcnt) {
				$bigfonts = "";
				$bigfontc = "";
				$strtoprank = $strhtml;
				$topnettotal = $nettotal;
				$strhtml = "";
			}


			#�����ȥޡ�������
			if(!isset($hascom1[$pcode . "_" . $subid[$i]])) {
				$com1mark = "&nbsp;";
			} else {
				$com1mark = "<a href='$ThisFile?act=comment&step=v&m=m&pcode=$pcode&sid=$subid[$i]'><img src='../images/comfly.gif' border='0'></a>";
			}


			$strhtml .= "<tr bgcolor=\"" . Parapara("#EFE8EF") . "\">
					<td $ac>$bigfonts$subid[$i]$bigfontc</td>
					<td $al>$bigfonts$name[$i]$bigfontc</td>
					<td $ar>$bigfonts$net[$i]$bigfontc</td>
					<td $ac>$com1mark</td>
					<td $ac><a href=\"home.php?act=comment&step=w&m=m&pcode=$pcode&net=$net[$i]&sid=$subid[$i]\">��</a></td>
				     </tr>
				";
		}


		#¾��pcode�Υ��ʸ������� ---

		#$q = "SELECT CONCAT(pyear,pmon,pweek) + 0 AS pcodearray FROM nettb GROUP BY pcodearray";
		#ExecSQL($q);
		#$qfld = array("pcodearray");
		#SetFieldToArray($qfld);
		#$pcodearray 	= GetVal("pcodearray");	#�Σ��

		#$pcodearray2 = array();
		#for($i = 0; $i < sizeof($pcodearray); $i++) {
		#	list($pyear2,$pmon2,$pweek2) = SetPcode($pcodearray[$i]);
		#	array_push($pcodearray2,$pyear2 . "ǯ" . ($pmon2 + 0) . "����" . $pweek2 . "��");
		#}

		#$GLOBALS["pselected"] = $pcode;
		#$StrPCodeSelection = MakeSelectionByStrArray(2,"pcode",$pcodearray,$pcodearray2);


		#¾��pcode�Υ��ʸ������� ---

		$q = "SELECT CONCAT(pyear,pmon) + 0 AS pcodearray FROM nettb GROUP BY pyear,pmon";
		ExecSQL($q);
		$qfld = array("pcodearray");
		SetFieldToArray($qfld);
		$pcodearray 	= GetVal("pcodearray");	#�Σ��

		$pcodearray2 = array();
		for($i = 0; $i < sizeof($pcodearray); $i++) {
			list($pyear2,$pmon2,$pweek2) = SetPcode($pcodearray[$i] . "0");
			array_push($pcodearray2,$pyear2 . "ǯ" . ($pmon2 + 0) . "��");
		}

		$GLOBALS["pselected"] = $pcode;
		$StrPCodeSelection = MakeSelectionByStrArray(2,"pcode",$pcodearray,$pcodearray2);







		$K = "

			<center>

			<h3> $pyear ǯ $pmon �� �� Monthly </h3>


			$kmsg

			<table border=\"1\" cellpadding=\"5\">
			<form name=\"FrmAdmin2\" action=\"$ThisFile\" method=\"post\">
				<tr>
				<td bgcolor=\"#96D698\"> $StrPCodeSelection <input type=\"submit\" value=\"����\"></td>
				<td bgcolor=\"pink\">$f4<b>$nettotal</b>$fc</td>
				</tr>
			<input type=\"hidden\" name=\"act\" value=\"m\">
			<input type=\"hidden\" name=\"step\" value=\"view\">
			</form>
			</table>

			<p>

			<table class=\"sTable\" border=\"0\" width=\"50%\" cellspacing=\"1\" cellpadding=\"5\" bgcolor=\"#000000\">
			 <tr bgcolor=\"#FFCC00\">
			  <td width='20%' $ac><a href=\"$ThisFile?act=$act&step=view&gid=$gid&pcode=$pcode&qPosSort=subid&s=$s\">IDNO</a></td>
			  <td width='40%' $ac><a href=\"$ThisFile?act=$act&step=view&gid=$gid&pcode=$pcode&qPosSort=name&s=$s\">Name</a></td>
			  <td width='20%' $ac><a href=\"$ThisFile?act=$act&step=view&gid=$gid&pcode=$pcode&qPosSort=net&s=$s\">Net</a></td>
			  <td width='10%' $ac>��</td>
			  <td width='10%' $ac>��</td>
			 </tr>
			$strtoprank
			 <tr bgcolor=\"pink\">
			  <td> &nbsp; </td>
			  <td> &nbsp; </td>
			  <td $ar> $f4<b>$topnettotal</b>$fc </td>
			  <td> &nbsp; </td>
			  <td> &nbsp; </td>
			 </tr>
			</table>

			<p>

			<table class=\"sTable\" border=\"0\" width=\"50%\" cellspacing=\"1\" cellpadding=\"5\" bgcolor=\"#000000\">
			 <tr bgcolor=\"#FFCC00\">
			  <td width='20%' $ac><a href=\"$ThisFile?act=$act&step=view&gid=$gid&pcode=$pcode&qPosSort=subid&s=$s\">IDNO</a></td>
			  <td width='40%' $ac><a href=\"$ThisFile?act=$act&step=view&gid=$gid&pcode=$pcode&qPosSort=name&s=$s\">Name</a></td>
			  <td width='20%' $ac><a href=\"$ThisFile?act=$act&step=view&gid=$gid&pcode=$pcode&qPosSort=net&s=$s\">Net</a></td>
			  <td width='10%' $ac>��</td>
			  <td width='10%' $ac>��</td>
			 </tr>
			$strhtml
			 <tr bgcolor=\"pink\">
			  <td> &nbsp; </td>
			  <td> &nbsp; </td>
			  <td $ar> $f4<b>$nettotal</b>$fc </td>
			  <td> &nbsp; </td>
			  <td> &nbsp; </td>
			 </tr>
			</table>

			<p>

			</center>
			";


}



#---------------------------------------
# ������
#---------------------------------------
function Comment() {

	global $act,$sid,$pcode,$m,$step,$substep,$com1,$K,$IsLocal,$pyear,$pmon,$pweek;


	if($step == "w") {



		#�ѿ������ ---
		$femail 	= GetVal("femail");

		#�᡼�빹���ξ�� ---
		if($femail != "") {
			$q = "
				UPDATE subtb
				SET email = '$femail'
				WHERE subid = '$sid'
			";

			#�ǥХ���
			#Err_Admin($q);

			ExecSQL($q);

		}

		#�����Ȥ�������ͤξ���򥻥åȤ��� ---
		SetSubDataBySudId($sid);

		$name = GetVal("name");
		$email = GetVal("email");


		#pcode���� ---
		if($m == "m") {
			$pcode .= "0";
		}
		list($GLOBALS["pyear"],$GLOBALS["pmon"],$GLOBALS["pweek"]) = SetPcode($pcode);
		if($m == "m") {
			$GLOBALS["pweek"] = "";
		}


		$pyear = $GLOBALS["pyear"];
		$pmon = $GLOBALS["pmon"];
		$pweek = $GLOBALS["pweek"];


		#sid����Υ᡼�륢�ɥ쥹���ʤ���� ---
		if(!preg_match("/@/",$email)) {
			#$K = "$name ����Υ᡼�륢�ɥ쥹�����ꤵ��Ƥ��ޤ���<br> �������̤ˤ����ꤷ�Ʋ�������";
			$K = ConvVal(ReadFileData("html/user_bulletin_w_inputemail.html",3));
		}
		#�񤭹��ߥե����� ----------------
		elseif($substep == "") {


			if(ComExist(1,'b',$pyear,$pmon,$pweek,$sid)) {
				$GLOBALS["com1"] = GetSpecCom('1','b',$pyear,$pmon,$pweek,$sid);
			}

			#�ȣԣ̺ͣ���
			$K = ConvVal(ReadFileData("html/user_bulletin_w_form.html",3));

		}
		#�������� ------------------------
		elseif($substep == "do_write") {

			#�᡼������
			if(function_exists("mail") and $IsLocal == 0) {
				#Err_Admin($com1);
				mail($email, JJ("��å�����������ޤ�"), JJ($com1));
			}

			$GLOBALS["subid"] = $sid;
			$GLOBALS["grpid"] = GetGrpIdBySubId($sid);
			$GLOBALS["repid"] = $m;

			$where = " WHERE repid = '$m' AND pyear = '$pyear' AND pmon = '$pmon' AND pweek = '$pweek' AND subid = '$sid'";

			if(ComExist(1,'$m',$pyear,$pmon,$pweek,$sid)) {
				UpdateFromHash("comtb",$GLOBALS,$where);
			} else {
				InsertFromHash("comtb",$GLOBALS);
			}

			#�ȣԣ̺ͣ���
			$GLOBALS["kmsg"] = Impact("$name ��������Τ��ޤ����� <p>");

			$GLOBALS["step"] = "";

			if($m == "b") {
				$act = "b";
				Bulletin();
			} elseif($m == "m") {
				$act = "m";
				Monthly();
			}

		}
	}
	elseif($step == "v") {

		#�����Ȥ�������ͤξ���򥻥åȤ���
		SetSubDataBySudId($sid);


		#pcode���� ---
		if($m == "m") {
			$pcode .= "0";
		}
		#pcode����
		list($GLOBALS["pyear"],$GLOBALS["pmon"],$GLOBALS["pweek"]) = SetPcode($pcode);
		if($m == "m") {
			$GLOBALS["pweek"] = "";
			$pcode = substr($pcode,0,strlen($pcode) - 1);
		}

		#$pyear = $GLOBALS["pyear"];
		#$pmon = $GLOBALS["pmon"];
		#$pweek = $GLOBALS["pweek"];

		#�Ρ��ޥ�⡼��
		if($substep == "") {

			$where = " WHERE repid = '$m' AND pyear = '$pyear' AND pmon = '$pmon' AND pweek = '$pweek' AND subid = '$sid'";

			
			$qfld = array("com1","com2");
			$q = "SELECT com1,com2 FROM comtb $where";
			ExecSQL($q);

			GetValueFromSTH(3,"",$qfld,$GLOBALS);

			if($GLOBALS["com2"] == "") {
				$GLOBALS["com2"] = "�ֻ��ʤ�";
			}

			$GLOBALS["com1"] = preg_replace("/\n/","<br>",$GLOBALS["com1"]);
			$GLOBALS["com2"] = preg_replace("/\n/","<br>",$GLOBALS["com2"]);

			#�ȣԣ̺ͣ���
			$K = ConvVal(ReadFileData("html/user_bulletin_v_comment.html",3));

		}

	}

}














?>