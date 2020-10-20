<?php
  /*=====================================================
  システム名：IWD CMS
  処理名　　：フォーム送信処理
  開発開始日：2009-04-20
  更新履歴　：
  開発者　　：
  =====================================================*/
header('Content-type: text/html; charset=UTF-8');
?>
<?php

  //確認画面のhtmlファイル
  $wrkTEMPLATEFILE = $_POST["iHTMLNM"];

  //色
  //2010-01-20
  $wrkCCOLOR = $_POST["iCCOLOR"];

  //設問数
  $wrkSETSUQTTY    = $_POST["iINPUTMAX"];

  //設問要素
  $wrkSETSUMON     = $_POST["iINPUTELE"];

  //言語
  $wrkFRMLANGUAGE  = $_POST[iFRMLANGUAGE];
  if($wrkFRMLANGUAGE==''){
    $wrkFRMLANGUAGE = 'JPN';
  }

  //$aryBUF = explode("~",$wrkSETSUMON);
  $aryBUF = explode("#",$wrkSETSUMON);
  $wrkSQTTY = count($aryBUF)-1;
  for($i=0;$i<count($aryBUF);$i++){
    $aryBUF2 = explode("|",$aryBUF[$i]);
    $wrkSTYPE[$i]     = $aryBUF2[0];
    $wrkSSETSUMON[$i] = $aryBUF2[1];
    $wrkSSELECT[$i]   = $aryBUF2[2];
    $wrkSHISSU[$i]    = $aryBUF2[3];
    //必須入力の数をカウントする
    if($aryBUF2[3]==1){
      $wrkHISSUCNT++;
    }
  }

  //HTMLテンプレートを変数に読み込む
  $fname = $wrkTEMPLATEFILE;
  $h = fopen($fname, "r");
  $wrkHTML = fread($h, filesize($fname));
  fclose($h);

	// 2013-07-05
	// taishin専用
	if($_POST["iOWNERID"]=='taishin'){
		$fname = "taishin_tag.txt";
		if(file_exists($fname)){
			$h = fopen($fname, "r");
			$wrkTAISHINTAG = fread($h, filesize($fname));
			fclose($h);
			$wrkTAISHINTAG.="\n</body>\n";
			$wrkHTML = str_replace("</body>",$wrkTAISHINTAG,$wrkHTML);
		}
	}

  $wrkDBHEADER   = '';
  $wrkDBDETAIL   = '';
  $wrkMAILTO     = '';
  $wrkMAILNM     = '';
  $wrkMAILDETAIL = '';
  for($i=0;$i<$wrkSQTTY;$i++){

    $wrkDBHEADER.=$wrkSSETSUMON[$i] . ",";
    $wrkMAILDETAIL.=($wrkSSETSUMON[$i]) . " : ";
/*
echo $i . " " . $wrkSTYPE[$i];
echo "<br>";
*/
    switch($wrkSTYPE[$i]){
      case "RADIO":
        $wrkVALUE = ($_POST["iINPUT" . $i]);
        if($wrkVALUE==''){
          if($wrkFRMLANGUAGE=='JPN'){
            $wrkVALUE = "選択なし";
          }else{
            $wrkVALUE = "EMPTY";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "SELECT":
        $wrkVALUE = ($_POST["iINPUT" . $i]);
        if($wrkVALUE==''){
          if($wrkFRMLANGUAGE=='JPN'){
            $wrkVALUE = "選択なし";
          }else{
            $wrkVALUE = "EMPTY";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "CHECK":
        $wrkVALUE = '';
        $checkbox = $_REQUEST["iINPUT" . $i];
        for($j=0; $j<sizeof($checkbox); $j++){
          $wrkVALUE.= "${checkbox[$j]}/";
        }
        if($wrkVALUE==''){
          if($wrkFRMLANGUAGE=='JPN'){
            $wrkVALUE = "選択なし";
          }else{
            $wrkVALUE = "EMPTY";
          }
        }
        $wrkDBDETAIL.= "\"" . str_replace("/","|",$wrkVALUE) . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = ($wrkVALUE);
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=($wrkVALUE) . "\n";
        break;

      case "TEXT":
        $wrkVALUE = ($_POST["iINPUT" . $i]);
        if($wrkVALUE==''){
          if($wrkFRMLANGUAGE=='JPN'){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = "EMPTY";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = ($wrkVALUE);
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "TEXTAREA":
        $wrkVALUE = ($_POST["iINPUT" . $i]);
        if($wrkVALUE==''){
          if($wrkFRMLANGUAGE=='JPN'){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = "EMPTY";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "ADDRESS":
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = '';
          $wrkVALUE.= "\n郵便番号：";
          if($_POST["iINPUT" . $i . "_zip"]==''){
            $wrkVALUE.= "<br>\n";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_zip"]) . "<br>\n";
          }
          $wrkVALUE.= "都道府県：";
          if($_POST["iINPUT" . $i . "_pref"]==''){
            $wrkVALUE.= "<br>\n";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_pref"]) . "<br>\n";
          }
          $wrkVALUE.= "市区町村：";
          if($_POST["iINPUT" . $i . "_city"]==''){
            $wrkVALUE.= "<br>\n";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_city"]) . "<br>\n";
          }
          $wrkVALUE.= "　番地等：";
          if($_POST["iINPUT" . $i . "_town"]==''){
            $wrkVALUE.= "<br>\n";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_town"]) . "<br>\n";
          }
          $wrkVALUE.= "　建物名：";
          if($_POST["iINPUT" . $i . "_buil"]==''){
            $wrkVALUE.= "<br>\n";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_buil"]) . "<br>\n";
          }
          $wrkDBDETAIL.="\"" . ($_POST["iINPUT" . $i . "_zip"]) . "|";
          $wrkDBDETAIL.=($_POST["iINPUT" . $i . "_pref"]) . "|";
          $wrkDBDETAIL.=($_POST["iINPUT" . $i . "_city"]) . "|";
          $wrkDBDETAIL.=($_POST["iINPUT" . $i . "_town"]) . "|";
          $wrkDBDETAIL.=($_POST["iINPUT" . $i . "_buil"]) . "|\",";
          $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
          $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
          $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
          $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
          $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
          $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
          $wrkTO = $wrkVALUE;
          $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
          $wrkMAILDETAIL.=str_replace("<br>","",$wrkVALUE) . "\n";
        }else{
          $wrkVALUE = ($_POST["iINPUT" . $i]);
          if($wrkVALUE==''){
            $wrkVALUE = "EMPTY";
          }
          $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
          $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
          $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
          $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
          $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
          $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
          $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
          $wrkTO = $wrkVALUE;
          $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
          $wrkMAILDETAIL.=$wrkVALUE . "\n";
        }
        break;

      case "ZIPCODE":
      case "AREA":
      case "PREFCD":
      case "TEL":
      case "FAX":
      case "URL":
        $wrkVALUE = ($_POST["iINPUT" . $i]);
        if($wrkVALUE==''){
          if($wrkFRMLANGUAGE=='JPN'){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = "EMPTY";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "MAIL":
        $wrkVALUE  = ($_POST["iINPUT" . $i]);
        $wrkMAILTO = $wrkVALUE;
        if($wrkVALUE==''){
          if($wrkFRMLANGUAGE=='JPN'){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = "EMPTY";
          }
          $wrkMAILTO = '';
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "MAILCHECK":
        $wrkVALUE  = ($_POST["iINPUT" . $i . "_mail1"]);
        $wrkMAILTO = $wrkVALUE;
        if($wrkVALUE==''){
          if($wrkFRMLANGUAGE=='JPN'){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = "EMPTY";
          }
          $wrkMAILTO = '';
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "NAME":
      case "KANA":
        $wrkVALUE = ($_POST["iINPUT" . $i]);
        if($wrkMAILNM==''){
          $wrkMAILNM = $wrkVALUE;
        }
        if($wrkVALUE==''){
          if($wrkFRMLANGUAGE=='JPN'){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = "EMPTY";
          }
          $wrkMAILNM = '';
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkTO = $wrkVALUE . " 様";
          $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
          $wrkMAILDETAIL.=$wrkVALUE . " 様\n";
        }else{
          $wrkTO = "Dear Sir or Madam:" . $wrkVALUE . " ";
          $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
          $wrkMAILDETAIL.="Dear Sir or Madam:" . $wrkVALUE . " \n";
        }
        break;

      case "SEX":
        $wrkVALUE = ($_POST["iINPUT" . $i]);
        if($wrkFRMLANGUAGE=='JPN'){
          if($wrkVALUE==''){
            $wrkVALUE = "未入力";
          }elseif($wrkVALUE=='M'){
            $wrkVALUE = "男性";
          }elseif($wrkVALUE=='F'){
            $wrkVALUE = "女性";
          }
        }else{
          if($wrkVALUE==''){
            $wrkVALUE = "EMPTY";
          }elseif($wrkVALUE=='M'){
            $wrkVALUE = "Male";
          }elseif($wrkVALUE=='F'){
            $wrkVALUE = "Female";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "BIRTHDAY":
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = '';
          if($_POST["iINPUT" . $i . "_year"]==''){
            $wrkVALUE.= "　　年";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_year"]) . "年";
          }
          if($_POST["iINPUT" . $i . "_month"]==''){
            $wrkVALUE.= "　　月";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_month"]) . "月";
          }
          if($_POST["iINPUT" . $i . "_day"]==''){
            $wrkVALUE.= "　　日";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_day"]) . "日";
          }
        }else{
          $wrkVALUE = '';
          if($_POST["iINPUT" . $i . "_month"]==''){
            $wrkVALUE.= "&nbsp;&nbsp;&nbsp;&nbsp; /";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_month"]) . " /";
          }
          if($_POST["iINPUT" . $i . "_day"]==''){
            $wrkVALUE.= "&nbsp;&nbsp;&nbsp;&nbsp; ";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_day"]) . " ";
          }
          if($_POST["iINPUT" . $i . "_year"]==''){
            $wrkVALUE.= "&nbsp;&nbsp;&nbsp;&nbsp; ";
          }else{
            $wrkVALUE.= ($_POST["iINPUT" . $i . "_year"]) . " ";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "AGE":
        if($wrkFRMLANGUAGE=='JPN'){
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . " 才";
          }
        }else{
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "EMPTY";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . " ";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "YEAR":
        if($wrkFRMLANGUAGE=='JPN'){
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . " 年";
          }
        }else{
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "EMPTY";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . " ";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "MONTH":
        if($wrkFRMLANGUAGE=='JPN'){
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . " 月";
          }
        }else{
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "EMPTY";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . " ";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "DAY":
        if($wrkFRMLANGUAGE=='JPN'){
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . " 日";
          }
        }else{
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "EMPTY";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . " ";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "DATE":
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "未入力";
        }else{
          $wrkVALUE = ($_POST["iINPUT" . $i]) . "";
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "HOUR":
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "未入力";
        }else{
          $wrkVALUE = ($_POST["iINPUT" . $i]) . " 時";
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "MINUTE":
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "未入力";
        }else{
          $wrkVALUE = ($_POST["iINPUT" . $i]) . " 分";
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "SECOND":
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "未入力";
        }else{
          $wrkVALUE = ($_POST["iINPUT" . $i]) . " 秒";
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      case "TIME":
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "未入力";
        }else{
          $wrkVALUE = ($_POST["iINPUT" . $i]) . "";
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

      default:
        if($wrkFRMLANGUAGE=='JPN'){
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "未入力";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . "";
          }
        }else{
          if($_POST["iINPUT" . $i]==''){
            $wrkVALUE = "EMPTY";
          }else{
            $wrkVALUE = ($_POST["iINPUT" . $i]) . "";
          }
        }
        $wrkDBDETAIL.="\"" . $wrkVALUE . "\",";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
        $wrkMAILDETAIL.=$wrkVALUE . "\n";
        break;

    }

  }

  $wrkKEYFR = "<!--[SUBMIT]-->";
  $wrkKEYTO = "<!--[/SUBMIT]-->";
  $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
  $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
  $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
  $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
  $wrkTO = "";
  $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);

  //FORMのHTMLを取得
  $wrkKEYFR = "<!--[FORM]-->";
  $wrkKEYTO = "<!--[/FORM]-->";
  $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
  $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
  $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
  $wrkFORMHTML = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);

  //mainのHTMLを削除
  $wrkKEYFR = "<!--[main]-->";
  $wrkKEYTO = "<!--[/main]-->";
  $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
  $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
  $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
  $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
  $wrkTO = '<!--FORMHERE-->';
  $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);

  //FORMのHTMLを挿入
  $wrkFR = "<!--FORMHERE-->";
  $wrkTO = "<!--[main]-->\n<div id=\"main\">" . $wrkFORMHTML . "</div><hr />\n<!--[/main]-->\n";
  $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);

  //2010-02-20
  $wrkFR = "<!--[FORM]-->";
  if($wrkFRMLANGUAGE=='JPN'){
    $wrkTO = "<p class='send'><font color='" . $wrkCCOLOR . "'>下記の内容で送信いたしました。</font></p>\n";
  }else{
    $wrkTO = "<p class='send'><font color='" . $wrkCCOLOR . "'>You have been registered with the following entry.</font></p>\n";
  }
  $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);

  $wrkFR = "<div id=\"side\">";
  $wrkTO = "<div id=\"side\" style=\"background: url('../images/wrapper.gif') left top repeat;\">\n";
  $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);


  $ip = getenv("REMOTE_ADDR");
  $host = getenv("REMOTE_HOST");
  $wrkDBHEADER.="投稿日付,IP,HOST,削除,";
  $wrkDBDETAIL.="\"" . date('Y-m-d H:i:s') . "\",\"" . $ip . "\",\"" . $host . "\",\"0\",";
  $wrkDBNAME = "./files/" . $_POST[iDBNAME] . ".csv";
  if (!file_exists("$wrkDBNAME")) {
    if ($fh=fopen("$wrkDBNAME","a")) {
      if (flock($fh,LOCK_EX)) {
        fwrite($fh,$wrkDBHEADER . "\n");
        fwrite($fh,$wrkDBDETAIL . "\n");
        flock($fh,LOCK_UN);
      } else {
        echo "flock error!!";
      }
      fclose($fh);
    } else {
      echo "open error!!";
    }
  } else {
    if ($fh=fopen("$wrkDBNAME","a")) {
      if (flock($fh,LOCK_EX)) {
        fwrite($fh,$wrkDBDETAIL . "\n");
        flock($fh,LOCK_UN);
      } else {
        echo "flock error!!";
      }
      fclose($fh);
    } else {
      echo "open error!!";
    }
  }

  $wrkFRMMAILTITLE  = ($_POST['iFRMMAILTITLE']);
  $wrkFRMMAILSENDER = ($_POST['iFRMMAILSENDER']);
  $wrkFRMMAILADRTO  = $_POST['iFRMMAILADR1'];
  $wrkFRMMAILADR    = $_POST['iFRMMAILADR2'];
  $wrkFRMMAILHEADER = ($_POST['iFRMMAILHEADER']);
  $wrkFRMMAILFOOTER = ($_POST['iFRMMAILFOOTER']);

  //メールを送信する
  $wrkHEADER = "From:" . mb_encode_mimeheader(mb_convert_encoding($wrkFRMMAILSENDER,"JIS","SJIS"))."<" . $wrkFRMMAILADR . ">\r\n";
  $wrkHEADER.= "Return-Path: " . $wrkFRMMAILADR . "\r\n";
  $wrkHEADER.= "Date: ".date("r")."\r\n";
  $wrkHEADER.= "Reply-To: " . $wrkFRMMAILADR . "\r\n";
  $wrkHEADER.= "MIME-Version: 1.0\n";
  $wrkHEADER.= "Content-Type: text/plain; charset=iso-2022-jp\n";
  $wrkHEADER.= "Content-Transfer-Encoding: 7bit\n";
  $wrkHEADER.= "X-Mailer: PHP/" . phpversion() . "\r\n";
  mb_language("Ja");
  mb_internal_encoding ("SJIS");

  //運営者へメールを送信する
  $mailto  = $wrkFRMMAILADRTO;
  $subject = $wrkFRMMAILTITLE;
  if($wrkFRMLANGUAGE=='JPN'){
    $body = "管理者　様\n\n";
  }else{
    $body = "Dear Administrator \n\n";
  }
  $body.= $wrkFRMMAILHEADER . "\n\n";
  $body.= ($wrkMAILDETAIL) . "\n";
  $body.= $wrkFRMMAILFOOTER;
  //$body    = i18n_convert($body, "JIS", "SJIS");
  $body = mb_convert_encoding($body,"JIS","AUTO");
  if($mailto!=''){
    mb_send_mail($mailto,$subject,$body,$wrkHEADER,"-f" . $wrkFRMMAILADR);
  }

  //送信者へメールを送信する
  if($wrkMAILTO!=''){
    $mailto  = $wrkMAILTO;
    $subject = $wrkFRMMAILTITLE;
    $body = '';
    if($wrkMAILNM!=''){
      if($wrkFRMLANGUAGE=='JPN'){
        $body.= $wrkMAILNM . "　様\n\n";
      }else{
        $body.= "Dear Sir or Madam:" . $wrkMAILNM . " \n\n";
      }
    }
    $body.= $wrkFRMMAILHEADER . "\n\n";
    $body.= ($wrkMAILDETAIL) . "\n";
    $body.= $wrkFRMMAILFOOTER;
    //$subject = i18n_convert($subject, "JIS", "auto");
    //$body    = i18n_convert($body, "JIS", "SJIS");
    $body = mb_convert_encoding($body,"JIS","AUTO");
    if($mailto!=''){
      mb_send_mail($mailto,$subject,$body,$wrkHEADER,"-f" . $wrkFRMMAILADR);
    }
  }

  echo $wrkHTML;

?>