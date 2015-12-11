<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<meta content="<?php echo C('WEB_SITE_KEYWORD');?>" name="keywords"/>
<meta content="<?php echo C('WEB_SITE_DESCRIPTION');?>" name="description"/>
<link rel="shortcut icon" href="<?php echo SITE_URL;?>/favicon.ico">
<title><?php echo empty($page_title) ? C('WEB_SITE_TITLE') : $page_title; ?></title>
<link href="/Public/static/font-awesome/css/font-awesome.min.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
<link href="/Public/Home/css/base.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
<link href="/Public/Home/css/module.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
<link href="/Public/Home/css/weiphp.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Public/static/bootstrap/js/html5shiv.js?v=<?php echo SITE_VERSION;?>"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="/Public/static/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/Public/static/zclip/ZeroClipboard.min.js?v=<?php echo SITE_VERSION;?>"></script>
<script type="text/javascript" src="/Public/Home/js/dialog.js?v=<?php echo SITE_VERSION;?>"></script>
<script type="text/javascript" src="/Public/Home/js/admin_common.js?v=<?php echo SITE_VERSION;?>"></script>
<script type="text/javascript" src="/Public/Home/js/admin_image.js?v=<?php echo SITE_VERSION;?>"></script>
<script type="text/javascript" src="/Public/static/masonry/masonry.pkgd.min.js"></script>
<script type="text/javascript">
var  IMG_PATH = "/Public/Home/images";
var  STATIC = "/Public/static";
var  ROOT = "";
var  UPLOAD_PICTURE = "<?php echo U('home/File/uploadPicture',array('session_id'=>session_id()));?>";
var  UPLOAD_FILE = "<?php echo U('File/upload',array('session_id'=>session_id()));?>";
</script>
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<style type="text/css">
  .public_title{
    position: relative;
    top: -18px;
    color: #666;
    font-size: 18px;
    left: 10px;
  }
</style>

<!-- 提示 -->
<div id="top-alert" class="top-alert-tips alert-error" style="display: none;">
  <a class="close" href="javascript:;"><b class="fa fa-times-circle"></b></a>
  <div class="alert-content">这是内容</div>
</div>
<!-- 导航条
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
 	<?php if ($mid ) { $link = M ( 'public_link' )->where ( 'uid=' . $mid )->order ( 'is_use desc' )->select (); foreach ( $link as $l ) { $mp_ids [] = $l ['mp_id']; $is_use [$l ['mp_id']] = $l ['is_use']; } $mp_ids = getSubByKey ( $link, 'mp_id' ); if (! empty ( $mp_ids )) { $mp_ids_list = count ( $mp_ids ); $mp_ids = implode ( ',', $mp_ids ); $map ['id'] = array ( 'in', $mp_ids ); $public_list = M ( 'public' )->where ( $map )->order ( 'FIND_IN_SET(id,"' . $mp_ids . '")' )->select (); $public = $public_list [0]; $token = get_token (); if ($public ['public_id'] && ($is_use [$public ['id']] == 0 || $token == '' || $token == - 1)) { get_token ( $public ['public_id'] ); } unset ( $public_list [0] ); } else { $mp_ids_list=0; } $publicInfo=M('public')->where(array('uid'=>$mid))->find(); $userInfo=getUserInfo($mid); $nowPublicInfo = M('public')->where(array('token'=>get_token()))->find(); } ?>
    <div class="wrap">
    
       <a class="brand" title="<?php echo C('WEB_SITE_TITLE');?>" href="<?php echo U('index/index');?>">
       <?php if($nowPublicInfo['headface_url'] != NULL): ?><img height="52" src="<?php echo (get_cover_url($nowPublicInfo["headface_url"])); ?>"/>
       	<?php else: ?>
       		<img height="52" src="/Public/Home/images/logo.png"/><?php endif; ?>
      <span class="public_title"><?php echo empty($page_title) ? C('WEB_SITE_TITLE') : $nowPublicInfo['public_name']; ?></span>
       </a>
       
       
            <div class="top_nav">
                <?php if(is_login()): ?><ul class="nav" style="margin-right:0">
                    	<?php if($myinfo["is_init"] == 0 ): ?><li><p>该账号配置信息尚未完善，功能还不能使用</p></li>
                    		<?php elseif($myinfo["is_audit"] == 0 and !$reg_audit_switch): ?>
                    		<li><p>该账号配置信息已提交，请等待审核</p></li>
                    		<?php else: ?> 
                    		<?php if(is_array($core_top_menu)): $i = 0; $__LIST__ = $core_top_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ca): $mod = ($i % 2 );++$i;?><li data-id="<?php echo ($ca["id"]); ?>" class="<?php echo ($ca["class"]); ?>"><a href="<?php echo ($ca["url"]); ?>" target="_blank"><?php echo ($ca["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    	
                    	
                        
                        <li class="dropdown admin_nav">
                            <a href="#" class="dropdown-toggle login-nav" data-toggle="dropdown" style="">
                                <?php if(!empty($userInfo[headface_url])): ?><img class="admin_head" src="<?php echo (get_cover_url($userInfo["headface_url"])); ?>"/>
                                <?php else: ?>
                                    <img class="admin_head" src="/Public/Home/images/default.png"/><?php endif; ?>
                                <?php echo (getShort(get_username($mid),4)); ?><b class="pl_5 fa fa-sort-down"></b>
                            </a>
                            <ul class="dropdown-menu" style="display:none">
                            	<li><a href="<?php echo U ('Home/Public/add',array('id'=>$publicInfo[id]));?>">账号配置</a></li>
                                <li><a href="<?php echo U ('Home/Public/lists');?>">公众号配置</a></li>
                                <li><a href="<?php echo U('User/profile');?>">修改密码</a></li>
                                <li><a href="<?php echo U('User/logout');?>">退出</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="nav" style="margin-right:0">
                    	<li style="padding-right:20px">你好!欢迎来到<?php echo C('WEB_SITE_TITLE');?></li>
                        <li>
                            <a href="<?php echo U('User/login');?>">登录</a>
                        </li>
                        <li>
                            <a href="<?php echo U('User/register');?>">注册</a>
                        </li>
                        <li>
                            <a href="<?php echo U('admin/index/index');?>" style="padding-right:0">后台入口</a>
                        </li>
                    </ul><?php endif; ?>
            </div>
        </div>
</div>

<script type="text/javascript">
  $(function(){
    $("a[href='http://demo.idouly.com/weiphp3.0/index.php?s=/home/index/main.html&mdm=172']").attr("target","_self");
   
  })
</script>
	<!-- /头部 -->
	
	<!-- 主体 -->
	
<!-- <?php  if(!is_login()){ Cookie ( '__forward__', $_SERVER ['REQUEST_URI'] ); redirect(U('home/user/login',array('from'=>4))); } ?>
 -->
  <?php $m = strtolower(MODULE_NAME); $c = strtolower(CONTROLLER_NAME); $a = strtolower(ACTION_NAME); if(!is_login()){ redirect(U('home/user/login')); } $ad = ucfirst ( parse_name ( $_REQUEST['_addons'], 1 ) ); $navClass[$ad] = 'active'; $navClass[$m.'_'.$c.'_'.$a] = 'active'; $addonList = D ( 'Addons' )->getWeixinList (false, array(), true); $categorys = M ( 'addon_category' )->order ( 'sort asc, id desc' )->select (); foreach($categorys as &$cate){ foreach($addonList as $k=>$a){ if($cate['id']==intval($a['cate_id'])){ $cate['addons'][] = $a; unset($addonList[$k]); } } } ?>
<div id="main-container" class="admin_container">
  
    <div class="sidebar">

     

      <ul class="sidenav">

        <li>
          <a class="sidenav_parent" href="javascript:;"> 
            <img src="https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_function.png"/>
            管理</a>
          <ul class="sidenav_sub">
            
              <li class="" data-id=""> <a href="<?php echo U('Home/Public/lists');?>">公众号管理</a><b class="active_arrow"></b></li>
              <li class="" data-id=""> <a href="<?php echo U('Home/WeixinMessage/lists');?>">消息管理</a><b class="active_arrow"></b></li>
              <li class="" data-id=""> <a href="<?php echo addons_url('UserCenter://UserCenter/lists'); ?>">用户管理</a><b class="active_arrow"></b></li>
              <li class="" data-id=""> <a href="<?php echo U('Home/Material/material_lists');?>">素材管理</a><b class="active_arrow"></b></li>
              <li class="" data-id=""> <a href="<?php echo U('Home/Message/add');?>">群发管理</a><b class="active_arrow"></b></li>
            
          </ul>
        </li>  
        
        <?php if(is_array($categorys)): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ca): $mod = ($i % 2 );++$i; if($ca['addons'] != ''): ?><li>
          <a class="sidenav_parent" href="javascript:;"> 
            <img src="https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_function.png"/>
            <?php echo ($ca["title"]); ?></a>
          <ul class="sidenav_sub">
            <?php if(is_array($ca["addons"])): $i = 0; $__LIST__ = $ca["addons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($vo["class"]); ?>" data-id="<?php echo ($vo["id"]); ?>"> <a href="<?php echo ($vo[addons_url]); ?>"><?php echo ($vo["title"]); ?></a><b class="active_arrow"></b></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

        <!-- <li>
          <?php if(!empty($now_top_menu_name)): ?><a class="sidenav_parent" href="javascript:;"> 
            <img src="https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_function.png"/>
            <?php echo ($now_top_menu_name); ?></a><?php endif; ?>
          <ul class="sidenav_sub">
            <?php if(is_array($core_side_menu)): $i = 0; $__LIST__ = $core_side_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($vo["class"]); ?>" data-id="<?php echo ($vo["id"]); ?>"> <a href="<?php echo ($vo["url"]); ?>"> <?php echo ($vo["title"]); ?> </a><b class="active_arrow"></b></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </li> -->
        
      </ul>
    </div>
 
  <div class="main_body">
    
  
  <!-- 标签页导航 -->
  <div class="span9 page_message">
    <section id="contents">
      <ul class="tab-nav nav">
  <?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($vo["class"]); ?>"><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?><span class="arrow fa fa-sort-up"></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php if(!empty($sub_nav)): ?><div class="sub-tab-nav">
       <ul class="sub_tab">
       <?php if(is_array($sub_nav)): $i = 0; $__LIST__ = $sub_nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a class="<?php echo ($vo["class"]); ?>" href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?><span class="arrow fa fa-sort-up"></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
<!--          <li><a class="cur" href="<?php echo addons_url('WeiSite://footer/lists');?>">底部菜单配置</a></li>
          <li><a href="<?php echo addons_url('WeiSite://footer/template');?>">底部菜单模板</a></li>-->
      </ul>
</div><?php endif; ?>
<?php if(!empty($normal_tips)): ?><p class="normal_tips"><b class="fa fa-info-circle"></b> <?php echo ($normal_tips); ?></p><?php endif; ?>
      <div class="tab-content"> 
        <!-- 表单 -->
        <?php $post_url || $post_url = U('edit?model='.$model['id'], $get_param); ?>
        <form id="form" action="<?php echo $post_url;?>" method="post" class="form-horizontal form-center">
          
              <?php if(is_array($fields)): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i; if($field['is_show'] == 4): ?><input type="hidden" class="text input-large" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"><?php endif; ?>
                <?php if($field['is_show'] == 1 || $field['is_show'] == 3 || ($field['is_show'] == 5 && I($field['name']) )): ?><div class="form-item cf toggle-<?php echo ($field["name"]); ?>">
                    <label class="item-label">
                    <?php if(!empty($field["is_must"])): ?><span class="need_flag">*</span><?php endif; ?>
                    <?php echo ($field['title']); ?>
                    <span class="check-tips">
                      <?php if(!empty($field['remark'])): ?>（<?php echo ($field['remark']); ?>）<?php endif; ?>
                      </span></label>
                    <div class="controls">
                      <?php switch($field["type"]): case "num": ?><input type="number" class="text input-large" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"><?php break;?>
                        <?php case "string": ?><input type="text" class="text input-large" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"><?php break;?>
                        <?php case "textarea": ?><label class="textarea input-large">
                            <textarea name="<?php echo ($field["name"]); ?>"><?php echo ($data[$field['name']]); ?></textarea>
                          </label><?php break;?>
                        <?php case "datetime": ?><input type="datetime" name="<?php echo ($field["name"]); ?>" class="text input-large time" value="<?php echo (time_format($data[$field['name']])); ?>" placeholder="请选择时间" /><?php break;?>
                        <?php case "date": ?><input type="datetime" name="<?php echo ($field["name"]); ?>" class="text input-large date" value="<?php echo (time_format($data[$field['name']],'Y-m-d')); ?>" placeholder="请选择时间" /><?php break;?>                        
                        <?php case "bool": ?><select name="<?php echo ($field["name"]); ?>">
                            <?php $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" class="toggle-data" toggle-data="<?php echo (get_hide_attr($vo)); ?>"
                              <?php if(($data[$field['name']]) == $key): ?>selected<?php endif; ?>
                              ><?php echo (clean_hide_attr($vo)); ?>
                              </option><?php endforeach; endif; else: echo "" ;endif; ?>
                          </select><?php break;?>
                        <?php case "select": ?><select name="<?php echo ($field["name"]); ?>">
                            <?php $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" class="toggle-data" toggle-data="<?php echo (get_hide_attr($vo)); ?>"
                              <?php if(($data[$field['name']]) == $key): ?>selected<?php endif; ?>
                              ><?php echo (clean_hide_attr($vo)); ?>
                              </option><?php endforeach; endif; else: echo "" ;endif; ?>
                          </select><?php break;?>
                        <?php case "cascade": ?><div id="cascade_<?php echo ($field["name"]); ?>"></div>
                        <?php echo hook('cascade', array('name'=>$field['name'],'value'=>$data[$field['name']],'extra'=>$field['extra'])); break;?>                      
                        <?php case "dynamic_select": ?><div id="dynamic_select_<?php echo ($field["name"]); ?>"></div>
                        <?php echo hook('dynamic_select', array('name'=>$field['name'],'value'=>$data[$field['name']],'extra'=>$field['extra'])); break;?>   
                        <?php case "news": ?><div id="news_<?php echo ($field["name"]); ?>"></div>
                        <?php echo hook('news', array('name'=>$field['name'],'value'=>$data[$field['name']],'extra'=>$field['extra'])); break;?> 
                        <?php case "image": ?><div id="image_<?php echo ($field["name"]); ?>"></div>
                        <?php echo hook('image', array('name'=>$field['name'],'value'=>$data[$field['name']],'extra'=>$field['extra'])); break;?>                                                    
                        <?php case "radio": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="check-item">
							<!--[if !IE]><!-->  
								  <input type="radio" class="regular-radio toggle-data" value="<?php echo ($key); ?>" id="<?php echo ($field["name"]); ?>_<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>" toggle-data="<?php echo (get_hide_attr($vo)); ?>"
								  <?php if(($data[$field['name']]) == $key): ?>checked="checked"<?php endif; ?> />
								  <label for="<?php echo ($field["name"]); ?>_<?php echo ($key); ?>"></label><?php echo (clean_hide_attr($vo)); ?> 
							  <!--<![endif]-->
							   <!--[if IE]>
							       <input type="radio" value="<?php echo ($key); ?>" 
								   id="<?php echo ($field["name"]); ?>_<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>" class="toggle-data" toggle-data="<?php echo (get_hide_attr($vo)); ?>"
								  <?php if(($data[$field['name']]) == $key): ?>checked="checked"<?php endif; ?>/> 
								  <label for="<?php echo ($field["name"]); ?>_<?php echo ($key); ?>"></label><?php echo (clean_hide_attr($vo)); ?>
							   <![endif]-->
                             </div><?php endforeach; endif; else: echo "" ;endif; break;?>
                        <?php case "checkbox": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="check-item">
                              <input type="checkbox" class="regular-checkbox toggle-data" value="<?php echo ($key); ?>" id="<?php echo ($field["name"]); ?>_<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>[]" toggle-data="<?php echo (get_hide_attr($vo)); ?>"
                              <?php if(in_array(($key), is_array($data[$field['name']])?$data[$field['name']]:explode(',',$data[$field['name']]))): ?>checked="checked"<?php endif; ?> >
                              <label for="<?php echo ($field["name"]); ?>_<?php echo ($key); ?>"></label><?php echo (clean_hide_attr($vo)); ?> 
                             </div><?php endforeach; endif; else: echo "" ;endif; break;?>
                        <?php case "editor": ?><label class="textarea">
                            <textarea name="<?php echo ($field["name"]); ?>" style="width:405px; height:100px;"><?php echo ($data[$field['name']]); ?></textarea>
                            <?php echo hook('adminArticleEdit', array('name'=>$field['name'],'value'=>$data[$field['name']]));?> </label><?php break;?>
                        <?php case "picture": ?><div class="controls uploadrow2" title="点击修改图片" rel="<?php echo ($field["name"]); ?>">
                            <input type="file" id="upload_picture_<?php echo ($field["name"]); ?>">
                            <input type="hidden" name="<?php echo ($field["name"]); ?>" id="cover_id_<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"/>
                            <div class="upload-img-box">
                              <?php if(!empty($data[$field['name']])): ?><div class="upload-pre-item2"><img width="100" height="100" src="<?php echo (get_cover_url($data[$field['name']])); ?>"/></div>
                                <em class="edit_img_icon">&nbsp;</em><?php endif; ?>
                            </div>
                          </div><?php break;?>
                        <?php case "mult_picture": ?><div class="mult_imgs">
                                <div class="upload-img-view" id='mutl_picture_<?php echo ($field["name"]); ?>'>
                                  <?php if(!empty($data[$field['name']])): if(is_array($data[$field['name']])): $i = 0; $__LIST__ = $data[$field['name']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="upload-pre-item22">
                                    <img width="100" height="100" src="<?php echo (get_cover_url($vo)); ?>"/>
                                    <input type="hidden" name="<?php echo ($field["name"]); ?>[]" value="<?php echo ($vo); ?>"/>
                                    <em>&nbsp;</em>
                                    </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                </div>
                                <div class="controls uploadrow2 mult" title="点击上传图片" rel="<?php echo ($field["name"]); ?>">
                                  <input type="file" id="upload_picture_<?php echo ($field["name"]); ?>">
                                </div>
                            </div><?php break;?>
                        <?php case "file": ?><div class="controls upload_file" rel="<?php echo ($field["name"]); ?>">
                            <input type="file" id="upload_file_<?php echo ($field["name"]); ?>">
                            <input type="hidden" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"/>
                            <div class="upload-img-box">
                              <?php if(isset($data[$field['name']])): ?><div class="upload-pre-file"><span class="upload_icon_all"></span><?php echo (get_table_field($data[$field['name']],'id','name','File')); ?></div><?php endif; ?>
                            </div>
                          </div><?php break;?>
                        <?php default: ?>
                        <input type="text" class="text input-large" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"><?php endswitch;?>
                    </div>
                  </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
           
        </div>
        <div class="form-item form_bh" style="text-align:center">
            <?php if(!empty($data["id"])): ?><input type="hidden" name="id" value="<?php echo ($data["id"]); ?>"><?php endif; ?>
            <button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal"><?php echo ((isset($submit_name) && ($submit_name !== ""))?($submit_name):'确 定'); ?></button>
          </div>
      </form>
      </div>
    </section>
  </div>

  </div>
</div>

<script type="text/javascript">
    $(function(){
       
      $("ul.nav li[class='active'] a").attr("target","_self");
       
      var now_url = "<?php echo GetCurUrl(); ?>";  // 获取当前浏览地址
      // alert(now_url);
      $(".sidenav_sub a[href='"+now_url+"']").parent().addClass("active");
       
    })
</script>

	<!-- /主体 -->

	<!-- 底部 -->
	<div class="wrap bottom" style="background:#fff; border-top:#ddd;">
    <p class="copyright">本系统由<a href="http://weiphp.cn" target="_blank">WeiPHP</a>强力驱动</p>
</div>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "", //当前网站地址
		"APP"    : "/index.php?s=", //当前项目地址
		"PUBLIC" : "/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>

  <link href="/Public/static/datetimepicker/css/datetimepicker.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
  <?php if(C('COLOR_STYLE')=='blue_color') echo '
    <link href="/Public/static/datetimepicker/css/datetimepicker_blue.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
    '; ?>
  <link href="/Public/static/datetimepicker/css/dropdown.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script> 
  <script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js?v=<?php echo SITE_VERSION;?>" charset="UTF-8"></script> 
  <script type="text/javascript">
  $(function(){
	 initUploadImg();
	initUploadFile();
	 })
$(function(){    $('.time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:"zh-CN",
        minView:0,
        autoclose:true
    });
    $('.date').datetimepicker({
        format: 'yyyy-mm-dd',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });	
    showTab();
	
	$('.toggle-data').each(function(){
		var data = $(this).attr('toggle-data');
		if(data=='') return true;		
		
	     if($(this).is(":selected") || $(this).is(":checked")){
			 change_event(this)
		 }
	});
	
	$('.toggle-data').bind("click",function(){ change_event(this) });
});
</script> 
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<?php echo ($tongji_code); ?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>