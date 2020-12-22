<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	function fy_backend($total,$row,$url,$page=10,$num_links=5,$url_type=1){
		//$total数据总数
		//$row数据第几个开始
		//$page每页显示几篇文章
		//$num_links左右两边显示个数
		if($row==0){$cur_page=1;}else{$cur_page=($row/$page)+1;}//当前页
		$yeshu=ceil($total/$page);//总页数
		$prev_row=$row-$page;//上一页的$row数据第几个开始
		$next_row=$row+$page;//下一页的$row数据第几个开始
		
		$first_open='<span class="page">';
		$first_close='</span>&nbsp;';
		$last_open='<span class="page">';
		$last_close='</span>&nbsp;';
		
		$omission='<span style="color:black;">...</span>&nbsp;';                        //省略显示的内容   通常是 " ... "
		$next='<span style="color:black;padding:2px 5px 2px 5px;border:1px solid #bababa;">'.lang('cy_next_page').'</span>';                       //自定义上一页的内容   通常是 "&gt;&gt;"
		$next_open='<span class="go_b" style="color:black;">';                       //自定义上一页的内容   通常是 "&gt;&gt;"
		$next_close='</span>&nbsp;';                       //自定义上一页的内容   通常是 "&gt;&gt;"
		$prev='<span style="color:black;padding:2px 5px 2px 5px;border:1px solid #bababa;">'.lang('cy_prev_page').'</span>';                       //自定义下一页的内容  通常是 "&lt;&lt;"
		$prev_open='<span class="go_b" style="color:black;">';                       //自定义下一页的内容  通常是 "&lt;&lt;"
		$prev_close='</span>&nbsp;';                       //自定义下一页的内容  通常是 "&lt;&lt;"
		$tag_open='<span style="color:black;padding:2px 5px 2px 5px;border:1px solid #bababa;">';                          //数字的打开标签  通常是 "["
		$tag_close='</span>&nbsp;';                         //数字的关闭标签  通常是 "]"
		$cur_tag_open='<span style="background:black;color:white;padding:2px 5px 2px 5px;border:1px solid #bababa;font-weight:bold;">';    //当前页的打开标签  通常是 "<font color="red">["
		$cur_tag_close='</span>&nbsp;';              //当前页的关闭标签  通常是 "]</font>"
		
		$linkstyle='text-decoration: none;color:black;'; //链接的样式  通常是 "text-decoration: none;color:black;"

		if($url_type==2){
			$url_type_text='&row=';
		}else{
			$url_type_text='/';
		}
		//  echo $yeshu;exit;
		if($yeshu>$num_links){
			for($i=1;$i<=$num_links+1;$i++){
				${"linkl_".$i}=$cur_page-$i;
					$link_l=${"linkl_".$i};
				${"linkr_".$i}=$cur_page+$i;
					$link_r=${"linkr_".$i};

				$row_prev=($link_l-1)*$page;
				$row_next=($link_r-1)*$page;

				if($i<=$num_links){
					if($link_l>0){$number_l='<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$row_prev.'">'.$tag_open.$link_l.$tag_close.'</a>';}else{$number_l='';}
					if($link_r<=$yeshu){$number_r='<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$row_next.'">'.$tag_open.$link_r.$tag_close.'</a>';}else{$number_r='';}
				}else{
					if($link_l>0){$number_l=$first_open.'<a style="'.$linkstyle.'" href="'.$url.'">1</a>'.$first_close.$omission;}else{$number_l='';} //显示第1页
					if($link_r<=$yeshu){$number_r=$omission.$first_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.($yeshu-1)*$page.'">'.$yeshu.'</a>'.$first_close;}else{$number_r='';}//显示最后1页

					if($cur_page>1){
						$number_l =$prev_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$prev_row.'">'.$prev.'</a>'.$prev_close.$number_l;
					}else{
						$number_l =''.$number_l;
					}
					if($cur_page<$yeshu){
						$number_r .=$next_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$next_row.'">'.$next.'</a>'.$next_close;
					}else{
						$number_r .='';
					}
				}
				${"contentl_".$i}=$number_l;
				${"contentr_".$i}=$number_r;
			}

			$data['create_line']='';
			for($i=$num_links+1;$i>=1;$i--){
				$row_prev=$row-$page;
				$data['create_line'] .=${"contentl_".$i};//输出左边页
			}
			$data['create_line'] .=$cur_tag_open.$cur_page.$cur_tag_close;  //输出当前页

			for($i=1;$i<=$num_links+1;$i++){
				$row_next=$row+$page;
				$data['create_line'] .=${"contentr_".$i};//输出右边页
			}
		}else{
			$data['create_line']='';
			if($cur_page>1){
				$data['create_line'] .=$prev_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$prev_row.'">'.$prev.'</a>'.$prev_close;
			}
			if($yeshu>1){
				for($i=1;$i<=$yeshu;$i++){
					$row_prev=($i-1)*$page;

					if($i==$cur_page){
						$data['create_line'] .=$cur_tag_open.$i.$cur_tag_close;
					}else{
						$data['create_line'] .='<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$row_prev.'">'.$tag_open.$i.$tag_close.'</a>';
					}
				}
			}
			if($cur_page<$yeshu){
				$data['create_line'] .=$next_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$next_row.'">'.$next.'</a>'.$next_close;
			}
		}
		return $data['create_line'];
	}
	
	
	function fy_frontend($total,$row,$url,$page=10,$num_links=5,$url_type=1){
		//$total数据总数
		//$row数据第几个开始
		//$page每页显示几篇文章
		//$num_links左右两边显示个数
		if($row==0){$cur_page=1;}else{$cur_page=($row/$page)+1;}//当前页
		$yeshu=ceil($total/$page);//总页数
		$prev_row=$row-$page;//上一页的$row数据第几个开始
		$next_row=$row+$page;//下一页的$row数据第几个开始
		
		$first_open='<span class="page">';
		$first_close='</span>&nbsp;';
		$last_open='<span class="page">';
		$last_close='</span>&nbsp;';
		
		$omission='<span style="color:black;">...</span>&nbsp;';                        //省略显示的内容   通常是 " ... "
		$next='<span style="color:black;padding:2px 5px 2px 5px;border:1px solid #bababa;">'.lang('cy_next_page').'</span>';                       //自定义上一页的内容   通常是 "&gt;&gt;"
		$next_open='<span class="go_b" style="color:black;">';                       //自定义上一页的内容   通常是 "&gt;&gt;"
		$next_close='</span>&nbsp;';                       //自定义上一页的内容   通常是 "&gt;&gt;"
		$prev='<span style="color:black;padding:2px 5px 2px 5px;border:1px solid #bababa;">'.lang('cy_prev_page').'</span>';                       //自定义下一页的内容  通常是 "&lt;&lt;"
		$prev_open='<span class="go_b" style="color:black;">';                       //自定义下一页的内容  通常是 "&lt;&lt;"
		$prev_close='</span>&nbsp;';                       //自定义下一页的内容  通常是 "&lt;&lt;"
		$tag_open='<span style="color:black;padding:2px 5px 2px 5px;border:1px solid #bababa;">';                          //数字的打开标签  通常是 "["
		$tag_close='</span>&nbsp;';                         //数字的关闭标签  通常是 "]"
		$cur_tag_open='<span style="background:#006db7;color:white;padding:2px 5px 2px 5px;border:1px solid #bababa;font-weight:bold;">';    //当前页的打开标签  通常是 "<font color="red">["
		$cur_tag_close='</span>&nbsp;';              //当前页的关闭标签  通常是 "]</font>"
		
		$linkstyle='text-decoration: none;color:black;'; //链接的样式  通常是 "text-decoration: none;color:black;"

		if($url_type==2){
			$url_type_text='&row=';
		}else{
			$url_type_text='/';
		}
		//  echo $yeshu;exit;
		if($yeshu>$num_links){
			for($i=1;$i<=$num_links+1;$i++){
				${"linkl_".$i}=$cur_page-$i;
					$link_l=${"linkl_".$i};
				${"linkr_".$i}=$cur_page+$i;
					$link_r=${"linkr_".$i};

				$row_prev=($link_l-1)*$page;
				$row_next=($link_r-1)*$page;

				if($i<=$num_links){
					if($link_l>0){$number_l='<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$row_prev.'">'.$tag_open.$link_l.$tag_close.'</a>';}else{$number_l='';}
					if($link_r<=$yeshu){$number_r='<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$row_next.'">'.$tag_open.$link_r.$tag_close.'</a>';}else{$number_r='';}
				}else{
					if($link_l>0){$number_l=$first_open.'<a style="'.$linkstyle.'" href="'.$url.'">1</a>'.$first_close.$omission;}else{$number_l='';} //显示第1页
					if($link_r<=$yeshu){$number_r=$omission.$first_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.($yeshu-1)*$page.'">'.$yeshu.'</a>'.$first_close;}else{$number_r='';}//显示最后1页

					if($cur_page>1){
						$number_l =$prev_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$prev_row.'">'.$prev.'</a>'.$prev_close.$number_l;
					}else{
						$number_l =''.$number_l;
					}
					if($cur_page<$yeshu){
						$number_r .=$next_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$next_row.'">'.$next.'</a>'.$next_close;
					}else{
						$number_r .='';
					}
				}
				${"contentl_".$i}=$number_l;
				${"contentr_".$i}=$number_r;
			}

			$data['create_line']='';
			for($i=$num_links+1;$i>=1;$i--){
				$row_prev=$row-$page;
				$data['create_line'] .=${"contentl_".$i};//输出左边页
			}
			$data['create_line'] .=$cur_tag_open.$cur_page.$cur_tag_close;  //输出当前页

			for($i=1;$i<=$num_links+1;$i++){
				$row_next=$row+$page;
				$data['create_line'] .=${"contentr_".$i};//输出右边页
			}
		}else{
			$data['create_line']='';
			if($cur_page>1){
				$data['create_line'] .=$prev_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$prev_row.'">'.$prev.'</a>'.$prev_close;
			}
			if($yeshu>1){
				for($i=1;$i<=$yeshu;$i++){
					$row_prev=($i-1)*$page;

					if($i==$cur_page){
						$data['create_line'] .=$cur_tag_open.$i.$cur_tag_close;
					}else{
						$data['create_line'] .='<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$row_prev.'">'.$tag_open.$i.$tag_close.'</a>';
					}
				}
			}
			if($cur_page<$yeshu){
				$data['create_line'] .=$next_open.'<a style="'.$linkstyle.'" href="'.$url.$url_type_text.$next_row.'">'.$next.'</a>'.$next_close;
			}
		}
		return $data['create_line'];
	}
	
	function fy_ajax($total,$row,$page=10,$fangfa,$fangfa_canshu=''){
	  //$total数据总数
	  //$row数据第几个开始
	  //$page每页显示几篇文章
	  if($row==0){$cur_page=1;}else{$cur_page=($row/$page)+1;}//当前页
	  $yeshu=ceil($total/$page);//总页数
	  $prev_row=$row-$page;//上一页的$row数据第几个开始
	  $next_row=$row+$page;//下一页的$row数据第几个开始
	  
		$next='<div style="float:left;background-color: #a6593f;color: white;font-size: 16px;height: 30px;width: auto;padding: 0px 10px 0px 10px;line-height: 30px;text-transform: uppercase;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">'.lang('cy_next_page').'</div>';                       //自定义上一页的内容   通常是 "&gt;&gt;"
		$prev='<div style="float:left;background-color: #a6593f;color: white;font-size: 16px;height: 30px;width: auto;padding: 0px 10px 0px 10px;line-height: 30px;text-transform: uppercase;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">'.lang('cy_prev_page').'</div>';                       //自定义下一页的内容  通常是 "&lt;&lt;"
		$linkstyle='text-decoration: none;color:white;'; //链接的样式  通常是 "text-decoration: none;color:black;"
	//  echo $yeshu;exit;
  	    $data['create_line']='';
  		if($cur_page>1){
	  		$data['create_line'] .='<a onclick="'.$fangfa.'('.$fangfa_canshu.$prev_row.')" style="'.$linkstyle.'" href="javascript:;">'.$prev.'</a>';
	  	}
  		if($cur_page<$yeshu){
	  	    $data['create_line'] .='<a onclick="'.$fangfa.'('.$fangfa_canshu.$next_row.')" style="'.$linkstyle.'" href="javascript:;">'.$next.'</a>';
  	    }
	  return $data['create_line'];
  }
	
	/*
	 * 判断客户登录客户端
	 * */
	function checkagent(){
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);  
	    $is_pc = (strpos($agent, 'windows nt')) ? true : false;  
	    $is_iphone = (strpos($agent, 'iphone')) ? true : false;  
	    $is_ipad = (strpos($agent, 'ipad')) ? true : false;  
	    $is_android = (strpos($agent, 'android')) ? true : false;  
	   
	    if($is_ipad){  
	        return 'ipad';
	    }else{
	     	if($is_iphone){  
	        	return 'iphone';
		    }else{
				if($is_android){
			    	return 'android';
			    }else{
			    	return 'pc';
			    }
		    }
	    }
	}
	
	//获取 all
	function randkey($num){
    	$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$randkey='';
		for($i = 0;$i < $num;$i++){
			$str = $string[rand(0,61)];
			$randkey.= $str;
		}
		return $randkey;
    }
    
    //获取 数字
	function randkey_number($num){
    	$string = "123456789";
		$randkey='';
		for($i = 0;$i < $num;$i++){
			$str = $string[rand(0,8)];
			$randkey.= $str;
		}
		return $randkey;
    }
	/**
	 * 获取字符串长度(汉字算2个字符)
	 */
    function getstrlen($str=''){
    	$str=strip_tags($str);
	    $length = strlen(preg_replace('/[x00-x7F]/', '', $str));
	    if ($length){
	        return strlen($str) - $length + intval($length / 3) * 2;
	    }else{
	        return strlen($str);
	    }
	}
	/**
	 * 截取字符串(汉字算2个字符并且防止截出乱码--目前只支持从第0位开始截取)
	 *
	 * @param String $string 要截取的字符串
	 * @param Int $start 从第几位开始截
	 * @param Int $length 要截取的长度
	 * @param String $fixStr 当字符长度大于$end时，给字符追加的字符
	 */
	function get_substr($string,$start,$length = null,$fixStr = 0){
		$string=strip_tags($string);
		$strRes='';
	    if (!$string || empty($string)) {
	        return $string;
	    }
 
	    $maxLen = ($length) ? $length - $start : $start;
	    $j=$start;
	    for ($i = $start; $i < $maxLen; $i++){
	        if (ord(mb_substr($string, $j, 1,'UTF-8')) > 0xa0) {
	            if ($i + 1 == $maxLen) {
	                //如果截取的最后一字是汉字，那么舍弃该汉字，结束截取
	                break;
	            }else {
	                //如果是中文，截取2个字符
//	                $strRes .= mb_substr($string, $i, 2,'UTF-8');
//	                $i++;
	                $strRes .= mb_substr($string, $j, 1,'UTF-8');
	                $i++;
	            }
	        }else {
	            //如果是英文，截取1个字符
	            $strRes .= mb_substr($string, $j, 1,'UTF-8');
	        }
	        $j++;
	    }
	    if($fixStr==1){
		     if(getstrlen($string)>$maxLen){
		    	 $strRes .= '…';
		   	 }
	    }
	    return $strRes;
	}
	
	//添加订单的记录
	function addorder_log($con){
		if(isset($con['order_id'])&&isset($con['content'])){
			$CI =& get_instance();
			$CI->OrderModel->addorder_log($con);
		}
	}
	//获取语言的列表
	function languagelist() {
		$CI =& get_instance();
		$lan = $CI->WelModel->getlanguage_list(array('status'=>1,'orderby'=>'sort','orderby_res'=>'ASC'));
	    return $lan;
	}
	/*替换内容*/
	function replace_content($reparr,$content) {
		if(!empty($reparr)){
			
		}else{
			$reparr = array();
		}
		$reparr[] = array('name'=>"\"", 'value'=>"&quot;");
		
		$reparr[] = array('name'=>"´", 'value'=>"&acute;");
		$reparr[] = array('name'=>"©", 'value'=>"&copy;");
// 		$reparr[] = array('name'=>">", 'value'=>"&gt;");
		$reparr[] = array('name'=>"µ", 'value'=>"&micro;");
		$reparr[] = array('name'=>"®", 'value'=>"&reg;");
		$reparr[] = array('name'=>" & ", 'value'=>" &amp; ");
		$reparr[] = array('name'=>"°", 'value'=>"&deg;");
		$reparr[] = array('name'=>"¡", 'value'=>"&iexcl;");
// 		$reparr[] = array('name'=>" ", 'value'=>"&nbsp;");
		$reparr[] = array('name'=>"»", 'value'=>"&raquo;");
		$reparr[] = array('name'=>"¦", 'value'=>"&brvbar;");
		$reparr[] = array('name'=>"÷", 'value'=>"&divide;");
		$reparr[] = array('name'=>"¿", 'value'=>"&iquest;");
		$reparr[] = array('name'=>"¬", 'value'=>"&not;");
		$reparr[] = array('name'=>"§", 'value'=>"&sect;");
		$reparr[] = array('name'=>"•", 'value'=>"&bull;");
		$reparr[] = array('name'=>"½", 'value'=>"&frac12;");
		$reparr[] = array('name'=>"«", 'value'=>"&laquo;");
		$reparr[] = array('name'=>"¶", 'value'=>"&para;");
		$reparr[] = array('name'=>"¨", 'value'=>"&uml;");
		$reparr[] = array('name'=>"¸", 'value'=>"&cedil;");
		$reparr[] = array('name'=>"¼", 'value'=>"&frac14;");
// 		$reparr[] = array('name'=>"<", 'value'=>"&lt;");
		$reparr[] = array('name'=>"±", 'value'=>"&plusmn;");
		$reparr[] = array('name'=>"×", 'value'=>"&times;");
		$reparr[] = array('name'=>"¢", 'value'=>"&cent;");
		$reparr[] = array('name'=>"¾", 'value'=>"&frac34;");
		$reparr[] = array('name'=>"¯", 'value'=>"&macr;");
// 		$reparr[] = array('name'=>"“", 'value'=>"&quot;");
		$reparr[] = array('name'=>"™", 'value'=>"&trade;");
		
		
		
		$reparr[] = array('name'=>"€", 'value'=>"&euro;");
		$reparr[] = array('name'=>"£", 'value'=>"&pound;");
		$reparr[] = array('name'=>"¥", 'value'=>"&yen;");
		
		
		$reparr[] = array('name'=>"„", 'value'=>"&bdquo;");
		$reparr[] = array('name'=>"…", 'value'=>"&hellip;");
// 		$reparr[] = array('name'=>"·", 'value'=>"&middot;");
		$reparr[] = array('name'=>"›", 'value'=>"&rsaquo;");
		$reparr[] = array('name'=>"ª", 'value'=>"&ordf;");
		$reparr[] = array('name'=>"ˆ", 'value'=>"&circ;");
// 		$reparr[] = array('name'=>"“", 'value'=>"&ldquo;");
		$reparr[] = array('name'=>"—", 'value'=>"&mdash;");
		$reparr[] = array('name'=>"’", 'value'=>"&rsquo;");
		$reparr[] = array('name'=>"º", 'value'=>"&ordm;");
		$reparr[] = array('name'=>"†", 'value'=>"&dagger;");
		$reparr[] = array('name'=>"‹", 'value'=>"&lsaquo;");
		$reparr[] = array('name'=>"–", 'value'=>"&ndash;");
// 		$reparr[] = array('name'=>"‚", 'value'=>"&sbquo;");
// 		$reparr[] = array('name'=>"”", 'value'=>"&rdquo;");
		$reparr[] = array('name'=>"‡", 'value'=>"&Dagger;");
// 		$reparr[] = array('name'=>"‘", 'value'=>"&lsquo;");
		$reparr[] = array('name'=>"‰", 'value'=>"&permil;");
// 		$reparr[] = array('name'=>"", 'value'=>"&shy;");//看不懂该符号
		$reparr[] = array('name'=>"˜", 'value'=>"&tilde;");
		
		$reparr[] = array('name'=>"≈", 'value'=>"&asymp;");
// 		$reparr[] = array('name'=>"⁄", 'value'=>"&frasl;");//此符号与平时输入的斜杠有区别的。/ 与 ⁄
		$reparr[] = array('name'=>"←", 'value'=>"&larr;");
		$reparr[] = array('name'=>"∂", 'value'=>"&part;");
		$reparr[] = array('name'=>"♠", 'value'=>"&spades;");
		$reparr[] = array('name'=>"∩", 'value'=>"&cap;");
		$reparr[] = array('name'=>"≥", 'value'=>"&ge;");
		$reparr[] = array('name'=>"≤", 'value'=>"&le;");
		$reparr[] = array('name'=>"″", 'value'=>"&Prime;");
		$reparr[] = array('name'=>"∑", 'value'=>"&sum;");
		$reparr[] = array('name'=>"♣", 'value'=>"&clubs;");
		$reparr[] = array('name'=>"↔", 'value'=>"&harr;");
		$reparr[] = array('name'=>"◊", 'value'=>"&loz;");
		$reparr[] = array('name'=>"′", 'value'=>"&prime;");
		$reparr[] = array('name'=>"↑", 'value'=>"&uarr;");
		$reparr[] = array('name'=>"↓", 'value'=>"&darr;");
		$reparr[] = array('name'=>"♥", 'value'=>"&hearts;");
		$reparr[] = array('name'=>"−", 'value'=>"&minus;");
		$reparr[] = array('name'=>"∏", 'value'=>"&prod;");
// 		$reparr[] = array('name'=>"", 'value'=>"&zwj;");//看不懂该符号
		$reparr[] = array('name'=>"♦", 'value'=>"&diams;");
		$reparr[] = array('name'=>"∞", 'value'=>"&infin;");
		$reparr[] = array('name'=>"≠", 'value'=>"&ne;");
		$reparr[] = array('name'=>"√", 'value'=>"&radic;");
// 		$reparr[] = array('name'=>"", 'value'=>"&zwnj;");//看不懂该符号
		$reparr[] = array('name'=>"≡", 'value'=>"&equiv;");
		$reparr[] = array('name'=>"∫", 'value'=>"&int;");
		$reparr[] = array('name'=>"‾", 'value'=>"&oline;");
		$reparr[] = array('name'=>"→", 'value'=>"&rarr;");
		
		
		$reparr[] = array('name'=>"α", 'value'=>"&alpha;");
		$reparr[] = array('name'=>"η", 'value'=>"&eta;");
		$reparr[] = array('name'=>"μ", 'value'=>"&mu;");
		$reparr[] = array('name'=>"π", 'value'=>"&pi;");
		$reparr[] = array('name'=>"θ", 'value'=>"&theta;");
		$reparr[] = array('name'=>"β", 'value'=>"&beta;");
		$reparr[] = array('name'=>"γ", 'value'=>"&gamma;");
		$reparr[] = array('name'=>"ν", 'value'=>"&nu;");
		$reparr[] = array('name'=>"ψ", 'value'=>"&psi;");
		$reparr[] = array('name'=>"υ", 'value'=>"&upsilon;");//此符号与平时输入的有区别的。υ 与 u
		$reparr[] = array('name'=>"χ", 'value'=>"&chi;");
		$reparr[] = array('name'=>"ι", 'value'=>"&iota;");
		$reparr[] = array('name'=>"ω", 'value'=>"&omega;");
		$reparr[] = array('name'=>"ρ", 'value'=>"&rho;");
		$reparr[] = array('name'=>"ξ", 'value'=>"&xi;");
		$reparr[] = array('name'=>"δ", 'value'=>"&delta;");
		$reparr[] = array('name'=>"κ", 'value'=>"&kappa;");
// 		$reparr[] = array('name'=>"ο", 'value'=>"&omicron;");
		$reparr[] = array('name'=>"σ", 'value'=>"&sigma;");
		$reparr[] = array('name'=>"ζ", 'value'=>"&zeta;");
		$reparr[] = array('name'=>"ε", 'value'=>"&epsilon;");
		$reparr[] = array('name'=>"λ", 'value'=>"&lambda;");
		$reparr[] = array('name'=>"φ", 'value'=>"&phi;");
		$reparr[] = array('name'=>"τ", 'value'=>"&tau;");
		
		if(!empty($reparr)){
			for($i=0;$i<count($reparr);$i++){
				$content=str_replace($reparr[$i]['name'],$reparr[$i]['value'],$content);
			}
		}
		
	    return $content;
	}
	
	//默认替换内容
	function defaultreparr(){
		$reparr = array();
		$reparr[] = array('name'=>"{sign_douhao}", 'value'=>"'");
		$reparr[] = array('name'=>"<br />", 'value'=>"\n");
		$reparr[] = array('name'=>base_url(), 'value'=>"{base_url}");
		$reparr[] = array('name'=>'/(width:(\s)*(\d){1,3}(%|(px));(\s)height:(\s)*(\d){1,3}(%|(px));)/', 'value'=>"max-width:100%;");
		return $reparr;
	}
	/*文件或图片的路径*/
	function enable_filepath($filepath) {
		$filepathsp = explode("http", $filepath);
		if(count($filepathsp)>=2){
			$fileshowpath = $filepath;
		}else{
			$fileshowpath = CDN_URL().$filepath;
		}
		return $fileshowpath;
	}
	/*编译转化{base_url}*/
	function enbaseurlcontent($content) {
		$reparr=array();
		$reparr[]=array('name'=>base_url(),'value'=>'{base_url}');
		for($i=0;$i<count($reparr);$i++){
			$content=str_replace($reparr[$i]['name'],$reparr[$i]['value'],$content);
		}
	    return $content;
	}
	/*解编译转化base_url()*/
	function debaseurlcontent($content) {
		$reparr=array();
		$reparr[]=array('name'=>'{base_url}','value'=>base_url());
		for($i=0;$i<count($reparr);$i++){
			$content=str_replace($reparr[$i]['name'],$reparr[$i]['value'],$content);
		}
	    return $content;
	}
	
	// js, css, 音频, 图片等使用的缓存标记
	function CACHE_USETIME(){
		$CI = & get_instance();
		$cache_usetime = $CI->config->item('cache_usetime');
		return $cache_usetime;
	}
	
	//CDN URL
	function CDN_URL(){
		$CI = & get_instance();
		$cdn_url = $CI->config->item('cdn_url');
		if($cdn_url!=""){
			return $cdn_url;
		}else{
			return base_url();
		}
	}
	
		/*修改图片路径 2014-06-10*/
	function autotofilepath($section,$arr_pic){
		$CI =& get_instance();
		
		$uploaddir = "upload/".$section;
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "upload/".$section."/".date('Y');
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "upload/".$section."/".date('Y')."/".date('m');
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$arr=array();
		if(!empty($arr_pic)){
			for($i=0;$i<count($arr_pic);$i++){
				$CI->WelModel->delete_file_interim($arr_pic[$i]['value']);//删除临时文件表中信息
				$old_pic=$arr_pic[$i]['value'];
				$check_oldpic=explode('/',$old_pic);
				$ispass=1;
				if(isset($check_oldpic[1])){
					if($check_oldpic[1]==$section){
						$ispass=0;
					}
				}
				if(!empty($old_pic)&&$ispass==1){
					$old_arr=explode('.',$old_pic);
					$pic_type=end($old_arr);
					$copy_url = $uploaddir.'/'.$section.'_'.$arr_pic[$i]['num'].'_'.date('Y_m_d_H_i_s').'.'.$pic_type;
					$res=copy($old_pic, $copy_url);
					$arr[$arr_pic[$i]['item']]=$copy_url;
					//生成缩略图开始
					if(isset($arr_pic[$i]['isThumb'])&&$arr_pic[$i]['isThumb']==1){
						$copy_Thumb = $uploaddir.'/'.$section.'_'.$arr_pic[$i]['num'].'_small_'.date('Y_m_d_H_i_s').'.'.$pic_type;
						$res=copy($old_pic, $copy_Thumb);
						
						$oldpic_width=getImgWidth($old_pic);
						$oldpic_height=getImgHeight($old_pic);
						
						$scale = $arr_pic[$i]['Thumb_width']/$oldpic_width;
						resizeImage($copy_Thumb,$oldpic_width,$oldpic_height,$scale);//等比例缩放
						
						$arr[$arr_pic[$i]['Thumb_item']]=$copy_Thumb;
					}
					//生成缩略图结束
					$filename="".$old_pic;  //只能是相对路径
				    @unlink($filename);
				}
			}
		}
		return $arr;
	}
	//删除文件夹
	function file_todeldir($dir){
		$dh = opendir($dir);
		while ($file = readdir($dh)){
			if ($file != "." && $file != ".."){
				$fullpath = $dir . "/" . $file;
				if (!is_dir($fullpath)){
					unlink($fullpath);
				}else{
					file_todeldir($fullpath);
				}
			}
		}
		closedir($dh);
		if (rmdir($dir)){
			return true;
		}else{
			return false;
		}
	}
	//数据库前缀
	function DB_PRE(){
		$CI =& get_instance();
		$DB_PRE=$CI->config->item('DB_PRE');
		return $DB_PRE;
	}
	/*获取高度*/
	function getImgHeight($image) {
		$size = getimagesize($image);
		$height = $size[1];
		return $height;
	}
	
	/*获取宽度*/
	function getImgWidth($image) {
		$size = getimagesize($image);
		$width = $size[0];
		return $width;
	}
	
	/*验证图片*/
	function resizeImage($image,$width,$height,$scale) {
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		imagealphablending($newImage,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
		imagesavealpha($newImage,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image); 
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image); 
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image); 
				break;
	  	}
		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
		
		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$image); 
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$image,90); 
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$image);  
				break;
	    }
		
		chmod($image, 0777);
		return $image;
	}
	
	//判断列表的排序
	function doactionorderby($parameter){
		$contion=array('orderby');
		$parameter=explode('-',$parameter);
		$orderby='';
		$orderby_res='';
		if(!empty($parameter)){
			for($i=0;$i<count($parameter);$i++){
				for($j=0;$j<count($contion);$j++){
					if($parameter[$i]==$contion[$j]){
						$orderby=$parameter[$i+1];
						$orderby=explode('_',$orderby);
						$orderby=$orderby[1];
						$orderby_res=$parameter[$i+2];
						$orderby_res=explode('_',$orderby_res);
						$orderby_res=$orderby_res[2];
					}
				}
			}
		}
		return array('orderby'=>$orderby,'orderby_res'=>$orderby_res);
	}
	//判断列表的是否直接跳入下一节
	function doactionisnext($parameter){
		$parameter=explode('-',$parameter);
		$is_next=0;
		if(!empty($parameter)){
			for($i=0;$i<count($parameter);$i++){
				if($parameter[$i]=='next'){
					$is_next=1;
				}
			}
		}
		return $is_next;
	}
	
	/**
	 把用户输入的文本转义（主要针对特殊符号和emoji表情）
	 */
	function userTextEncode($text){
// 		//可以为收到的微信消息，可能包含二进制emoji表情字符串
		$tmpStr = json_encode($text); //暴露出unicode
// 		$tmpStr = preg_replace("#(\\\ue[0-9a-f]{3})#ie","addslashes('\\1')",$tmpStr); //将emoji的unicode留下，其他不动
		$tmpStr = preg_replace("#(\\\ue[0-9a-f]{3})#ie",addslashes($text[0]),$tmpStr); //将emoji的unicode留下，其他不动
		$text = json_decode($tmpStr);
		
		return  $text;//你好 \ue415 hello 123
		
		
		
// 		if(!is_string($str))return $str;
// 		if(!$str || $str=='undefined')return '';
	
// 		$text = json_encode($str); //暴露出unicode
// 		$text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
// 			return addslashes($str[0]);
// 		},$text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
		
// 		$text = preg_replace("/(\\\u[ed][0-9a-f]{3})/i", '$str[\'\\0\']', $text) ;
		
		
// 		return json_decode($text);
	}
	
	/**
	 解码上面的转义
	 */
	function userTextDecode($text){
// 		//可以为将要发送的微信消息，包含emoji表情unicode字符串，需要转为utf8二进制字符串
// 		$text = preg_replace("#\\\u([0-9a-f]+)#ie","iconv('UCS-2','UTF-8', pack('H4', '\\1'))",$text); //对emoji unicode进行二进制pack并转utf8
// 		return $text;//你好  hello 123
		
// 		$text = json_encode($str); //暴露出unicode
// 		$text = preg_replace_callback('/\\\\\\\\/i',function($str){
// 			return '\\';
// 		},$text); //将两条斜杠变成一条，其他不动
// 		return json_decode($text);
		
		$text = json_encode($text); //暴露出unicode
// 		$text = preg_replace('/\\\\\\\\/i',function($str){
// 			return '\\';
// 		},$text); //将两条斜杠变成一条，其他不动
		
		$text = preg_replace('/\\\\\\\\/i', '\\', $text) ;
		
		return json_decode($text);
		
		
// 		看例子来说吧
// 		$content = preg_replace("/{#(.+?)}/eis", '$lang[\'\\1\']', $content) ;
// 		这是原来的代码，在php7里不能被正确执行。
		
// 		$content = preg_replace_callback("/{#(.+?)}/is", function($r)use($lang){ return $lang[$r[1]]; }, $content);
		
// 		这是改过之后的代码
	}

	//校验手机号码格式
	function isMobile($val){
		return (preg_match('/^(13|14|15|18|17)[0-9]{9}$/', $val) != 0 );
	}
	//转化成大小写，，，，search
	function actionsearchdaxiaoxiezimu($searchname, $thisname){
		if($thisname != $searchname && $searchname != ''){
			$searchname_low = strtolower($searchname);//转化为小写
			$thisname_low = strtolower($thisname);//转化为小写
		
			$thisnamezm = array();
			
			$thisnameisdaxie = array();
			if(mb_strlen($thisname, 'UTF8') > 0){
				for($i = 0; $i < mb_strlen($thisname, 'UTF8'); $i++){
					$thisnamezm[] = mb_substr($thisname, $i, 1,'UTF-8');
					
					if(strtoupper(mb_substr($thisname, $i, 1,'UTF-8')) === mb_substr($thisname, $i, 1,'UTF-8')){
						$thisnameisdaxie[] = 1;//大写字母
					}else{
						$thisnameisdaxie[] = 0;//小写字母
					}
				}
			}
			$testsplit = explode($searchname_low, $thisname_low);
			if(count($testsplit) > 1){
				$thisnamelast = '';
				
				$thisname_low = str_ireplace($searchname_low,'<font style="font-weight:bold;color:rgb(171,16,50);">'.$searchname_low.'</font>', $thisname_low);

				$thisname_low_split = explode('<font', $thisname_low);
				$start_start = mb_strlen($thisname_low_split[0], 'UTF8');
				
				$thisname_low_split = explode('0);">', $thisname_low);
				$start_end = mb_strlen($thisname_low_split[0], 'UTF8');
				
				
				$thisname_low_split = explode('</fo', $thisname_low);
				$end_start = mb_strlen($thisname_low_split[0], 'UTF8');
				
				$thisname_low_split = explode('nt>', $thisname_low);
				$end_end = mb_strlen($thisname_low_split[0], 'UTF8');
				
// 				$start_start = strpos($thisname_low, '<font');
// 				$start_end = strpos($thisname_low, '0);">');
				
// 				$end_start = strpos($thisname_low, '</fo');
// 				$end_end = strpos($thisname_low, 'nt>');

				$tt = 0;
				
				for($jj = 0; $jj < mb_strlen($thisname_low, 'UTF8'); $jj++){
					if($start_start >= 0){
						if($jj >= $start_start && $jj <= ($start_end + 4)){
							$thisnamelast = $thisnamelast.mb_substr($thisname_low, $jj, 1,'UTF-8');
						}else if($jj >= $end_start && $jj <= ($end_end + 2)){
							$thisnamelast = $thisnamelast.mb_substr($thisname_low, $jj, 1,'UTF-8');
						}else{
							if(isset($thisnameisdaxie[$tt]) && $thisnameisdaxie[$tt] == 1){//转化为大写
								$thisnamelast = $thisnamelast.strtoupper(mb_substr($thisname_low, $jj, 1,'UTF-8'));
							}else{//转化为小写
								$thisnamelast = $thisnamelast.strtolower(mb_substr($thisname_low, $jj, 1,'UTF-8'));
							}
							$tt++;
						}
					}else{
						if($thisnameisdaxie[$tt] == 1){//转化为大写
							$thisnamelast = $thisnamelast.strtoupper(mb_substr($thisname_low, $jj, 1,'UTF-8'));
						}else{//转化为小写
							$thisnamelast = $thisnamelast.strtolower(mb_substr($thisname_low, $jj, 1,'UTF-8'));
						}
						$tt++;
					}
				}
			}else{
				$thisnamelast = $thisname;
			}
		}else{
			$thisnamelast = str_ireplace($searchname,'<span style="color:red">'.$searchname.'</span>', $thisname);
		}
		return $thisnamelast;
	}
	
	
	//配置URL中get参数需要获取的内容
	function geturlparmersGETS(){
		$arr = array('keyword', 'row', 'backurl', 'subbackurl', 'user_type', 'admin_type');
		return $arr;
	}
	
	function getlancodelist(){
		$arr = array();
		$arr[] = array('langtype'=>'_en', 'langfolder'=>'english', 'langname'=>'English');
		$arr[] = array('langtype'=>'_ch', 'langfolder'=>'chinese', 'langname'=>'简体中文');
		return $arr;
	}
	//curl Post 数据
	function do_post_request($url,$post_Data){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_Data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$data = curl_exec($ch);
		//		var_dump($data);
		return $data;
	}
	