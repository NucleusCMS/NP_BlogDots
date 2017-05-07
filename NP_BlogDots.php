<?
/*BlogTimesの派生型で、BlogTimesの上にCategoryLinesのドットを乗せたもの*/
/*但し、BlogTimesとは異なり、過去の全記事を対象にポイントする*/
/*設置法、パラメータはNP_BlogTimes 0.30に*/
/*準拠。ちなみに縦軸ルーラは書いてないが、上がカテゴリ１になる*/

class NP_BlogDots extends NucleusPlugin {
  function getName() {	return 'BlogDots';	 }
  function getAuthor()  { return 'type613';	 }
  function getURL() {		return 'http://tankyard.xrea.jp/'; }
  function getVersion() {	return '0.1'; }
  function getDescription() { 
    return 'BlogDots Graphic Generate. use GD.<br />&lt;%BlogDots(CL_blogid,CL_catid,BT_blogid,BT_catid,height,width,padding,bordercolor,basecolor,linecolor,dotcolor,show_text,textcolor,font_id)%&gt; ';
  }

  function supportsFeature($feature) { return in_array ($feature, array ('SqlTablePrefix', 'SqlApi')); }
  /**
  * On plugin install, three options are created
   */
  function install() {
  // create some options
//    $this->createOption('Path','Graphic Generate PHP Path','text','./gdblogtimes.php');
    $this->createOption('CL_BlogId','CategoryLines Display Blog id(0=all,null=current)','text','');
    $this->createOption('CL_CategoryId','CategoryLines Display CategoryId(0=all,null=current)','text','');
    $this->createOption('BT_BlogId','BlogTimes Display Blog id(0=all,null=current)','text','');
    $this->createOption('BT_CategoryId','BlogTimes Display CategoryId(0=all,null=current)','text','');
    $this->createOption('Height','Height','text','30');
    $this->createOption('Width','Width','text','400');
    $this->createOption('Padding','Padding','text','5');
    $this->createOption('BorderColor','BorderColor(#rrggbb)','text','#757575');
    $this->createOption('BaseColor','BaseColor(#rrggbb)','text','#757575');
    $this->createOption('LineColor','LineColor(#rrggbb)','text','#ffffff');
    $this->createOption('DotColor','DotColor(#rrggbb)','text','#FF0000');
    $this->createOption('Show text','Display TextLabel(on/off)','text','on');
    $this->createOption('TextColor','TextColor(#rrggbb)','text','#757575');
    $this->createOption('FontId','Default Font ID(1-5)','text','1');
  }

	function init(){
		$this->php_path = $this->getOption('Path');
		$this->pcblogid = $this->getOption('CL_BlogId');
		$this->pccatid  = $this->getOption('CL_CategoryId');
		$this->pbblogid = $this->getOption('BT_BlogId');
		$this->pbcatid  = $this->getOption('BT_CategoryId');
		$this->height = $this->getOption('Height');
		$this->width  = $this->getOption('Width');
		$this->padding= $this->getOption('Padding');
		$this->bocolor= $this->getOption('BorderColor');
		$this->bscolor= $this->getOption('BaseColor');
		$this->lncolor= $this->getOption('LineColor');
		$this->dtcolor= $this->getOption('DotColor');
		$this->show_text= $this->getOption('Show_text');
		$this->txcolor= $this->getOption('TextColor');
		$this->fontid= $this->getOption('FontId');
	}
  /**
  * skinvar parameters:
  *      - blogname (optional)
  */
	function doSkinVar($skinType,$pcblogid='',$pccatid='',$pbblogid='',$pbcatid='',$height='',$width='',$padding='',$bocolor='',$bscolor='',$lncolor='',$dtcolor='',$show_text='',$txcolor='',$fontid=''){
		global $manager, $blog, $CONF, $catid, $DIR_PLUGINS,$catid,$archive;
		
		if($blog){
			$b =& $blog; 
		}else{
			$b =& $manager->getBlog($CONF['DefaultBlog']);
		}
		$blogid = $b->getID();
                
                switch($skinType){
                  case 'archive':
                    sscanf($archive,'%d-%d-%d',$y,$m,$d);
                    $time = mktime(0,0,0,$m,1,$y);
                    break;
                  default:
                    $time = $b->getCorrectTime(time());
                }
                $date = getDate($time);
                $month = $date['mon'];
                $year = $date['year'];

		//初期化
		if($pcblogid == '') $pcblogid = $this->pcblogid;
		if($pcblogid == '') $pcblogid = $blogid;
		if($pbblogid == '') $pbblogid = $this->pbblogid;
		if($pbblogid == '') $pbblogid = $blogid;
		if($pccatid  == '') $pccatid  = $this->pccatid ;
		if($pccatid  == '') $pccatid  = $catid;
		if($pbcatid  == '') $pbcatid  = $this->pbcatid ;
		if($pbcatid  == '') $pbcatid  = $catid;
		if($height == '') $height = $this->height;
		if($width == '') $width = $this->width;
		if($padding == '') $padding = $this->padding ;
		if($bocolor == '') $bocolor = $this->bocolor;
		if($bscolor == '') $bscolor = $this->bscolor ;
		if($lncolor == '') $lncolor = $this->lncolor;
		if($dtcolor == '') $dtcolor = $this->dtcolor;
		if($txcolor == '') $txcolor = $this->txcolor;
		if($show_text == '') $show_text = $this->show_text;
		if($fontid == '') $fontid = $this->fontid;
		$bocolor = str_replace('#','',$bocolor);
		$bscolor = str_replace('#','',$bscolor);
		$lncolor = str_replace('#','',$lncolor);
		$dtcolor = str_replace('#','',$dtcolor);
		$txcolor = str_replace('#','',$txcolor);

		$php_path = $CONF['PluginURL'] . 'blogtimes/blogtime-'.$pblogid.'-'.$pcatid.'.png';
//		$this->doPNG($pblogid, $pcatid, $height, $width, $padding, $bocolor, $bscolor, $lncolor);

?>
<img src="<?php echo $CONF['ActionURL'];?>?action=plugin&amp;name=BlogDots&amp;pcblogid=<?=$pcblogid?>&amp;pccatid=<?=$pccatid?>&amp;pbblogid=<?=$pbblogid?>&amp;pbcatid=<?=$pbcatid?>&amp;height=<?=$height?>&amp;width=<?=$width?>&amp;padding=<?=$padding?>&amp;bocolor=<?=$bocolor?>&amp;bscolor=<?=$bscolor?>&amp;lncolor=<?=$lncolor?>&amp;dtcolor=<?=$dtcolor?>&amp;show_text=<?=$show_text?>&amp;txcolor=<?=$txcolor?>&amp;month=<?=$month?>&amp;year=<?=$year?>&amp;fontid=<?=$fontid?>" alt="BLOGDOTS" />
<?

//echo '<img src="' . $CONF['PluginURL'].'NP_BlogTimes.php" />';
  }

	function doAction($type) {
		$pcblogid = requestVar('pcblogid');
		$pccatid = requestVar('pccatid');
		$pbblogid = requestVar('pbblogid');
		$pbcatid = requestVar('pbcatid');
		$height = requestVar('height');
		$width = requestVar('width');
		$padding = requestVar('padding');
		$bocolor = requestVar('bocolor');
		$bscolor = requestVar('bscolor');
		$lncolor = requestVar('lncolor');
		$dtcolor = requestVar('dtcolor');
		$show_text = requestVar('show_text');
		$txcolor = requestVar('txcolor');
		$fontid  = requestVar('fontid');
		$month = requestVar('month');
		$year = requestVar('year');
		$this->doPNG($pcblogid, $pccatid, $pbblogid, $pbcatid, $height, $width, $padding, $bocolor, $bscolor, $lncolor,$dtcolor,$show_text,$txcolor,$year,$month,$fontid);
	}

  function doPNG($_cblogid,$_ccatid,$_bblogid,$_bcatid,$_height,$_width,$_padding,$_bordercolor,$_basecolor,$_linecolor,$_dotcolor,$_show_text,$_textcolor,$year,$month,$_font_id){
    global $CONF, $manager, $DIR_PLUGINS;

    $cblogid=0;
    $ccatid=0;
    $bblogid=0;
    $bcatid=0;
    $height='30';
    $width='400';
    $padding='5';
    $bordercolor='';
    $basecolor='#757575';
    $linecolor='#FFffff';
    $dotcolor='#FF0000';
    $show_text='on';
    $textcolor='#757575';
    $font_id  = 1 ; /* default font id(1-5)*/
    if($_cblogid != '') $cblogid  = $_cblogid;
    if($_ccatid != '') $ccatid  = $_ccatid;
    if($_bblogid != '') $bblogid  = $_bblogid;
    if($_bcatid != '') $bcatid  = $_bcatid;
    if($_height != '') $height  = $_height;
    if($_width != '') $width  = $_width;
    if($_padding != '') $padding  = $_padding ;
    if($_bordercolor != '') $bordercolor  = $_bordercolor;
    if($_basecolor != '') $basecolor  = $_basecolor ;
    if($_linecolor != '') $linecolor  = $_linecolor ;
    if($_dotcolor != '') $dotcolor  = $_dotcolor ;
    if($_show_text != '') $show_text  = $_show_text ;
    if($_textcolor != '') $textcolor  = $_textcolor ;
    if($_font_id != '') $font_id  = $_font_id ;
    $query2 = 'SELECT  hour(itime) as hour, minute(itime) as minute FROM '
              .sql_table('item')
              . ' WHERE idraft=0'
              . ' and year(itime) ='.$year
              . ' and month(itime) = '.$month; // don't show draft items
    $query = 'SELECT  hour(itime) as hour, minute(itime) as minute,icat FROM '
              .sql_table('item')
              . ' WHERE idraft=0';
    $category_query = 'SELECT max(catid) FROM '.sql_table('category');
    if($cblogid != 0)
      $query .= ' and iblog='.$cblogid ;
    if($ccatid != 0)
      $query .= ' and icat='.$ccatid ;
    if($bblogid != 0)
      $query2 .= ' and iblog='.$bblogid ;
    if($bcatid != 0)
      $query2 .= ' and icat='.$bcatid ;

    $res = sql_query($category_query);
    if($row =sql_fetch_row($res)) $categorycount = $row[0];


    #オリジナル互換
    $txtpad = ($show_text != 'on')? 0 : imageFontHeight($font_id);
    $scale_width = $width+($padding*2);
    $scale_height= $height+($padding*2)+($txtpad*2);

    $img = ImageCreate($scale_width,$scale_height) or die ("Cannnot Initialize new GD image stream");
    //色設定
    $white = ImageColorAllocate($img,255,255,255);
    ImageColorTransparent($img,$white);
    $bgarray = $this->hex2dec($bordercolor);
    $bocol = ImageColorAllocate($img,$bgarray[0],$bgarray[1],$bgarray[2]);
    $bsarray = $this->hex2dec($basecolor);
    $bscol = ImageColorAllocate($img,$bsarray[0],$bsarray[1],$bsarray[2]);
    $lnarray = $this->hex2dec($linecolor);
    $lncol = ImageColorAllocate($img,$lnarray[0],$lnarray[1],$lnarray[2]);
    $dtarray = $this->hex2dec($dotcolor);
    $dtcol = ImageColorAllocate($img,$dtarray[0],$dtarray[1],$dtarray[2]);
    $txarray = $this->hex2dec($textcolor);
    $txcol = ImageColorAllocate($img,$txarray[0],$txarray[1],$txarray[2]);

    $fill_y1 = $padding+$txtpad;
    $fill_y2 = $padding+$txtpad+$height-1;

    ImageFilledRectangle($img,0,0,$scale_width-1,$scale_height-1,$white);
    if($bordercolor != ''){
      ImageRectangle($img,0,0,$scale_width-1,$scale_height-1,$bocol);
    }
    ImageFilledRectangle($img,$padding,$fill_y1,$padding+$width-1,$fill_y2,$bscol);

    $line_len=$height/$categorycount ;

    $res = sql_query($query2);
    while ($current = sql_fetch_object($res)) {
      $hour = $current->hour ;
      $minute = $current->minute ;
      $cat    = $current->icat;

      $line_y1 = $padding+$txtpad ;
      $line_y2 = $padding+$txtpad+$height-1;
      $line_x= $padding + (round(($hour*60+$minute)/(24*60) * $width)) ;
      ImageLine($img,$line_x,$line_y1,$line_x,$line_y2,$lncol);
    }
    $res = sql_query($query);
    while ($current = sql_fetch_object($res)) {
      $hour = $current->hour ;
      $minute = $current->minute ;
      $cat    = $current->icat;

      $dot_y1 = $padding+$txtpad+(round($cat/$categorycount*$height));
      $dot_y2 = $dot_y1+$line_len-1;
      $line_x= $padding + (round(($hour*60+$minute)/(24*60) * $width)) ;
      ImageLine($img,$line_x,$dot_y1,$line_x,$dot_y2,$dtcol);
    }
		
    sql_free_result($res);

    #text出力
    if($show_text == 'on'){
      if($width >= 140){
        $ruler_y = $padding+$txtpad+$height;
        for($i=0;$i <= 23;$i+=2){
          $ruler_x = $padding+round($i*$width/24);
          ImageString($img,$font_id,$ruler_x,$ruler_y,$i,$txcol);
        }
        ImageString($img,$font_id,$padding+$width-4,$ruler_y,"0",$txcol);
        $caption_x = $padding;
        $caption_y = $padding;
        $caption = "BLOGDOTS";
        imageString($img,$font_id,$caption_x,$caption_y,$caption,$txcol);
      }else{
        $ruler_y = $padding+$txtpad+$height;
        for($i=0;$i<=23;$i+=6){
          $ruler_x = $padding+round($i*$width/24);
          imageString($img,$font_id,$ruler_x,$ruler_y,$i,$txcol);
        }
        imageString($img,$font_id,$padding+$width-4,$ruler_y,"0",$txcol);
        $caption_x = $padding;
        $caption_y = $padding-1;
        $caption = "BLOGDOTS";
        imageString($img,$font_id,$caption_x,$caption_y,$caption,$txcol);
      }
    }
    /* pngの出力 */
    Header("Content-type: image/png");
    Header("Cache-control: no-cache");
    ImagePng($img);
/*
		ob_start(); 
		imagepng($img); 
		$im = ob_get_contents(); 
		ob_end_clean(); 
		return $im;
*/
/*
		$fname = $DIR_PLUGINS . 'blogtimes/blogtime-'.$blogid.'-'.$catid.'.png';
    if(ImagePng($img,$fname)){
//    	echo '<a href="'.$fname.'">here</a>';
    }else{
    	echo $fname.'bad';
    }
*/
    /* メモリの解放 */
    ImageDestroy($img);


  }


  function hex2dec($hex){
    $color = str_replace('#','',$hex);
    $ret = array();
    $ret[0]= hexdec(substr($color,0,2));
    $ret[1]= hexdec(substr($color,2,2));
    $ret[2]= hexdec(substr($color,4,2));
    return $ret;
  }
}
