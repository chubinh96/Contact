<?php
  /*=====================================================
  �V�X�e�����FIWD CMS
  �������@�@�F�t�H�[���m�F��ʁi�ėp�j
  �J���J�n���F2009-04-21
  �X�V�����@�F
  �J���ҁ@�@�F
  =====================================================*/
header('Content-type: text/html; charset=UTF-8');
  ?>
  <?php

  //�m�F��ʂ�html�t�@�C��
  $wrkTEMPLATEFILE = $_POST["iHTMLNM"];

  //�F
  //2010-01-20
  $wrkCCOLOR = $_POST["iCCOLOR"];

  //�ݖ␔
  $wrkSETSUQTTY    = $_POST["iINPUTMAX"];

  //�ݖ�v�f
  $wrkSETSUMON     = $_POST["iINPUTELE"];

  //����
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
    //�K�{���͂̐����J�E���g����
    if($aryBUF2[3]==1){
      $wrkHISSUCNT++;
    }
  }

  //HTML�e���v���[�g��ϐ��ɓǂݍ���
  $fname = $wrkTEMPLATEFILE;
  $h = fopen($fname, "r");
  $wrkHTML = fread($h, filesize($fname));
  fclose($h);

  //FORM��HTML���擾
  $wrkKEYFR = "<!--[FORM]-->";
  $wrkKEYTO = "<!--[/FORM]-->";
  $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
  $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
  $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
  $wrkFORMHTML = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);

  //main��HTML���폜
  $wrkKEYFR = "<!--[main]-->";
  $wrkKEYTO = "<!--[/main]-->";
  $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
  $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
  $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
  $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
  $wrkTO = '<!--FORMHERE-->';
  $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);

  //FORM��HTML��}��
  $wrkFR = "<!--FORMHERE-->";
  $wrkTO = "<!--[main]-->\n<div id=\"main\">" . $wrkFORMHTML . "</div><hr />\n<!--[/main]-->\n";
  $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);

  //2010-03-06
  if($wrkFRMLANGUAGE=='JPN'){
    header('Content-Type: text/html;charset=utf-8');
    $wrkFR = "<!--[FORM]-->";
    $wrkTO = "<p class='send'><font color='" . $wrkCCOLOR . "'>���L�̓��e�ő��M����܂��B</font></p>\n";
    $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
    $wrkFR = "<!--[SUBMIT]-->";
    $wrkTO = "<p class='send'><font color='" . $wrkCCOLOR . "'>���͓��e�ɊԈႢ���Ȃ����<br>�u��L���e�ő��M����v�{�^�����N���b�N���Ă��������B</font></p>\n";
    $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
    $wrkFR = "<div id=\"side\">";
    $wrkTO = "<div id=\"side\" style=\"background: url('../images/wrapper.gif') left top repeat;\">\n";
    $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
  }else{
    $wrkFR = "<!--[FORM]-->";
    $wrkTO = "<p class='send'><font color='" . $wrkCCOLOR . "'>You will be registered with the following entry.</font></p>\n";
    $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
    $wrkFR = "<!--[SUBMIT]-->";
    $wrkTO = "<p class='send'><font color='" . $wrkCCOLOR . "'>Confirm the entry and click SUBMIT to register.</font></p>\n";
    $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
    $wrkFR = "<div id=\"side\">";
    $wrkTO = "<div id=\"side\" style=\"background: url('../images/wrapper.gif') left top repeat;\">\n";
    $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
  }
  for($i=0;$i<$wrkSQTTY;$i++){

    switch($wrkSTYPE[$i]){
      case "RADIO":
      $wrkVALUE = ($_POST["iINPUT" . $i]);
      if($wrkVALUE==''){
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = "�I���Ȃ�\n";
        }else{
          $wrkVALUE = "EMPTY\n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "SELECT":
      $wrkVALUE = ($_POST["iINPUT" . $i]);
      if($wrkVALUE==''){
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = "�I���Ȃ�\n";
        }else{
          $wrkVALUE = "EMPTY\n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "CHECK":
      $wrkVALUE = '';
      $checkbox = $_REQUEST["iINPUT" . $i];
        //$checkbox = ($_REQUEST["iINPUT" . $i]);
      for($j=0; $j<sizeof($checkbox); $j++){
        $wrkVALUE.= "${checkbox[$j]}  / \n";
        $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "[]' value='" . "${checkbox[$j]}" . "'>\n";
      }
      $wrkVALUE = ($wrkVALUE);
      if($wrkVALUE==''){
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = "�I���Ȃ�\n";
        }else{
          $wrkVALUE = "EMPTY\n";
        }
      }
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "TEXT":
      $wrkVALUE = ($_POST["iINPUT" . $i]);
      if($wrkVALUE==''){
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = "EMPTY\n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "TEXTAREA":
        //$wrkVALUE = $_POST["iINPUT" . $i];
      $wrkVALUE = ($_POST["iINPUT" . $i]);
      if($wrkVALUE==''){
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = "EMPTY\n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "ADDRESS":
      if($wrkFRMLANGUAGE=='JPN'){
        $wrkVALUE = '';
        $wrkVALUE.= "�X�֔ԍ��F";
        if($_POST["iINPUT" . $i . "_zip"]==''){
          $wrkVALUE.= "<br>\n";
        }else{
          $wrkVALUE.= $_POST["iINPUT" . $i . "_zip"] . "<br>\n";
        }
        $wrkVALUE.= "�s���{���F";
        if($_POST["iINPUT" . $i . "_pref"]==''){
          $wrkVALUE.= "<br>\n";
        }else{
          $wrkVALUE.= ($_POST["iINPUT" . $i . "_pref"]) . "<br>\n";
        }
        $wrkVALUE.= "�s�撬���F";
        if($_POST["iINPUT" . $i . "_city"]==''){
          $wrkVALUE.= "<br>\n";
        }else{
          $wrkVALUE.= ($_POST["iINPUT" . $i . "_city"]) . "<br>\n";
        }
        $wrkVALUE.= "�@�Ԓn���F";
        if($_POST["iINPUT" . $i . "_town"]==''){
          $wrkVALUE.= "<br>\n";
        }else{
          $wrkVALUE.= ($_POST["iINPUT" . $i . "_town"]) . "<br>\n";
        }
        $wrkVALUE.= "�@�������F";
        if($_POST["iINPUT" . $i . "_buil"]==''){
          $wrkVALUE.= "<br>\n";
        }else{
          $wrkVALUE.= ($_POST["iINPUT" . $i . "_buil"]) . "<br>\n";
        }
        $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "_zip' value='" . ($_POST["iINPUT" . $i . "_zip"]) . "'>\n";
        $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "_pref' value='" . ($_POST["iINPUT" . $i . "_pref"]) . "'>\n";
        $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "_city' value='" . ($_POST["iINPUT" . $i . "_city"]) . "'>\n";
        $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "_town' value='" . ($_POST["iINPUT" . $i . "_town"]) . "'>\n";
        $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "_buil' value='" . ($_POST["iINPUT" . $i . "_buil"]) . "'>\n";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      }else{
        $wrkVALUE = $_POST["iINPUT" . $i];
        if($wrkVALUE==''){
          $wrkVALUE = "EMPTY\n";
        }
        $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
        $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
        $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
        $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
        $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
        $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
        $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
        $wrkTO = $wrkVALUE;
        $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      }
      break;

      case "ZIPCODE":
      case "AREA":
      case "PREFCD":
      case "TEL":
      case "FAX":
      case "MAIL":
      case "URL":
      $wrkVALUE = ($_POST["iINPUT" . $i]);
      if($wrkVALUE==''){
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = "EMPTY\n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "NAME":
      case "KANA":
      $wrkVALUE = ($_POST["iINPUT" . $i]);
      if($wrkVALUE==''){
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = "EMPTY\n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      if($wrkFRMLANGUAGE=='JPN'){
        $wrkTO = $wrkVALUE . " �l";
      }else{
        $wrkTO = "Dear Sir or Madam:" . $wrkVALUE . " ";
      }
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "MAILCHECK":
      $wrkVALUE = $_POST["iINPUT" . $i . "_mail1"];
      if($wrkVALUE==''){
        if($wrkFRMLANGUAGE=='JPN'){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = "EMPTY\n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "_mail1' value='" . ($_POST["iINPUT" . $i . "_mail1"]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "SEX":
      $wrkVALUE = $_POST["iINPUT" . $i];
      if($wrkFRMLANGUAGE=='JPN'){
        if($wrkVALUE==''){
          $wrkVALUE = "������\n";
        }elseif($wrkVALUE=='M'){
          $wrkVALUE = "�j��\n";
        }elseif($wrkVALUE=='F'){
          $wrkVALUE = "����\n";
        }
      }else{
        if($wrkVALUE==''){
          $wrkVALUE = "EMPTY\n";
        }elseif($wrkVALUE=='M'){
          $wrkVALUE = "Male\n";
        }elseif($wrkVALUE=='F'){
          $wrkVALUE = "Female\n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "BIRTHDAY":
      if($wrkFRMLANGUAGE=='JPN'){
        $wrkVALUE = '';
        if($_POST["iINPUT" . $i . "_year"]==''){
          $wrkVALUE.= "�@�@�N\n";
        }else{
          $wrkVALUE.= $_POST["iINPUT" . $i . "_year"] . "�N\n";
        }
        if($_POST["iINPUT" . $i . "_month"]==''){
          $wrkVALUE.= "�@�@��\n";
        }else{
          $wrkVALUE.= $_POST["iINPUT" . $i . "_month"] . "��\n";
        }
        if($_POST["iINPUT" . $i . "_day"]==''){
          $wrkVALUE.= "�@�@��\n";
        }else{
          $wrkVALUE.= $_POST["iINPUT" . $i . "_day"] . "��\n";
        }
      }else{
        $wrkVALUE = '';
        if($_POST["iINPUT" . $i . "_month"]==''){
          $wrkVALUE.= "&nbsp;&nbsp;&nbsp;&nbsp; /\n";
        }else{
          $wrkVALUE.= $_POST["iINPUT" . $i . "_month"] . " /\n";
        }
        if($_POST["iINPUT" . $i . "_day"]==''){
          $wrkVALUE.= "&nbsp;&nbsp;&nbsp;&nbsp; \n";
        }else{
          $wrkVALUE.= $_POST["iINPUT" . $i . "_day"] . " \n";
        }
        if($_POST["iINPUT" . $i . "_year"]==''){
          $wrkVALUE.= "&nbsp;&nbsp;&nbsp;&nbsp; \n";
        }else{
          $wrkVALUE.= $_POST["iINPUT" . $i . "_year"] . " \n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "_year' value='" . ($_POST["iINPUT" . $i . "_year"]) . "'>\n";
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "_month' value='" . ($_POST["iINPUT" . $i . "_month"]) . "'>\n";
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "_day' value='" . ($_POST["iINPUT" . $i . "_day"]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "AGE":
      if($wrkFRMLANGUAGE=='JPN'){
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = ($_POST["iINPUT" . $i]) . " ��\n";
        }
      }else{
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "EMPTY\n";
        }else{
          $wrkVALUE = ($_POST["iINPUT" . $i]) . " \n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . $_POST["iINPUT" . $i] . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "YEAR":
      if($wrkFRMLANGUAGE=='JPN'){
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = $_POST["iINPUT" . $i] . " �N\n";
        }
      }else{
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "EMPTY\n";
        }else{
          $wrkVALUE = $_POST["iINPUT" . $i] . " \n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "MONTH":
      if($wrkFRMLANGUAGE=='JPN'){
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = $_POST["iINPUT" . $i] . " ��\n";
        }
      }else{
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "EMPTY\n";
        }else{
          $wrkVALUE = $_POST["iINPUT" . $i] . " \n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "DAY":
      if($wrkFRMLANGUAGE=='JPN'){
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = $_POST["iINPUT" . $i] . " ��\n";
        }
      }else{
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "EMPTY\n";
        }else{
          $wrkVALUE = $_POST["iINPUT" . $i] . " \n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "DATE":
      if($_POST["iINPUT" . $i]==''){
        $wrkVALUE = "������\n";
      }else{
        $wrkVALUE = $_POST["iINPUT" . $i] . "\n";
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "HOUR":
      if($_POST["iINPUT" . $i]==''){
        $wrkVALUE = "������\n";
      }else{
        $wrkVALUE = $_POST["iINPUT" . $i] . " ��\n";
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "MINUTE":
      if($_POST["iINPUT" . $i]==''){
        $wrkVALUE = "������\n";
      }else{
        $wrkVALUE = $_POST["iINPUT" . $i] . " ��\n";
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "SECOND":
      if($_POST["iINPUT" . $i]==''){
        $wrkVALUE = "������\n";
      }else{
        $wrkVALUE = $_POST["iINPUT" . $i] . " �b\n";
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      case "TIME":
      if($_POST["iINPUT" . $i]==''){
        $wrkVALUE = "������\n";
      }else{
        $wrkVALUE = $_POST["iINPUT" . $i] . "\n";
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

      default:
      if($wrkFRMLANGUAGE=='JPN'){
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "������\n";
        }else{
          $wrkVALUE = $_POST["iINPUT" . $i] . "\n";
        }
      }else{
        if($_POST["iINPUT" . $i]==''){
          $wrkVALUE = "EMPTY\n";
        }else{
          $wrkVALUE = $_POST["iINPUT" . $i] . "\n";
        }
      }
      $wrkVALUE.="<input type=hidden name='iINPUT" . $i . "' value='" . ($_POST["iINPUT" . $i]) . "'>\n";
      $wrkKEYFR = "<!--[iINPUT" . $i . "]-->";
      $wrkKEYTO = "<!--[/iINPUT" . $i . "]-->";
      $wrkPOSFR = strpos($wrkHTML,$wrkKEYFR);
      $wrkPOSTO = strpos($wrkHTML,$wrkKEYTO);
      $wrkLENGTH = $wrkPOSTO-$wrkPOSFR + strlen($wrkKEYTO);
      $wrkFR = substr($wrkHTML,$wrkPOSFR,$wrkLENGTH);
      $wrkTO = $wrkVALUE;
      $wrkHTML = str_replace($wrkFR,$wrkTO,$wrkHTML);
      break;

    }

  }

  echo $wrkHTML;

  ?>