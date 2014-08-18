<?
function per_page()
{
	return 10;
}
function url_exists($url) {
	$hdrs = @get_headers($url);

	//echo @$hdrs[1]."\n";

	return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
}

function show_money($money)
{
	if($money > 100000000)
		return number_format($money, 0);
	else 
		return number_format($money, 1);
}

function _wordwrap($text)   {
    $split = explode(" ", $text);
    foreach($split as $key=>$value)   {
        if (strlen($value) > 10)    {
            $split[$key] = chunk_split($value, 5, "&#8203;");
        }
    }
    return implode(" ", $split);
}

function node_link($type, $node,$type_redirect=null)
{
   
	if ($type == 'video')
	{
		if($type_redirect == 'upload'){
			$link = '/video/view?id='. $node['id'];
		}else{
			$link = '/video/'. $node['iid'].'-' . $node['slug'] .'.html';
		}
	}elseif ($type == 'new')
	{
		if($type_redirect == 'upload'){
			$link = '/new/view?id='. $node['id'];
		}else{
			$link = '/new/'. $node['iid'].'-' . $node['slug'] .'.html';
		}
	}
	
	elseif ($type == 'tag')
		$link = "/tagged/" . $node['slug'];
	else
		$link = "/$type/{$node['id']}";
	return $link;
}

function category_link($category){
	return "/category/{$category['iid']}-{$category['slug']}.html";
}

// custom functions for demo
function display_avatar ($imgUrl, $size = 50, $atype = AS3_AVATAR_FOLDER)
{
	if(empty($imgUrl)) {
		return ($atype == AS3_AVATAR_FOLDER ? DEFAULT_AVATAR_URL : DEFAULT_ITEM_AVATAR_URL);
	}

	//remote url
	if(preg_match("/^(http|https)/", $imgUrl)) {
		return $imgUrl;
	}

	//local url
	if(strpos($imgUrl, dirname(APPLICATION_PATH)) !== false) {
		//local file, then strip the root dir
		$root = dirname(APPLICATION_PATH) . "/public";
		return str_replace($root, '', $imgUrl);
	}

	//$avatar = $atype . '/' . $size .'/'. $imgUrl;
	$avatar = AS3_ITEM_IMAGE_FOLDER . '/' . $size .'/'. $imgUrl;

	return AVATAR_PREFIX . '/' . str_replace("//", "/", $avatar);
}

function get_default_perms()
{
	return array('new_comment');
}

function use_static_server($img)
{
	if (strpos($img , "http://") === 0 || strpos($img , "https://") === 0)
		return $img;
	$img = str_replace('/ustore/', '/ufiles/', $img);
	if (strpos($img, '/ufiles/') === 0)
		$img = str_replace('/ufiles/', '', $img);
	//$img = str_replace('/ufiles/', STATIC_CDN, $img);
	if(!(strpos($img , "http://") === 0 && strpos($img , "https://") === 0))
		$img = STATIC_CDN . $img;
	return $img;
}

function remove_ufiles_from_images_url_tmp($img)
{
	if (strpos($img , "http://") === 0 || strpos($img , "https://") === 0)
		return $img;
	$img = str_replace('/ustore/', '/ufiles/', $img);
	if (strpos($img, '/ufiles/') === 0)
		$img = str_replace('/ufiles/', '', $img);
	//$img = str_replace('/ufiles/', STATIC_CDN, $img);
	if(!(strpos($img , "http://") === 0 && strpos($img , "https://") === 0))
		$img =  $img;
	return $img;
}

function remove_ufiles_from_images_url($img)
{
	$img = str_replace('/ufiles/', '', $img);
	return $img;
}
?>
