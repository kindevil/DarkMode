<?php

namespace TypechoPlugin\DarkMode;

use Typecho\Plugin\PluginInterface;
use Typecho\Widget\Helper\Form;
use Typecho\Widget\Helper\Form\Element\Text;
use Typecho\Widget\Helper\Form\Element\Radio;
use Widget\Options;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * Dark Mode 网站暗黑模式
 *
 * @package DarkMode
 * @author chenai
 * @version 1.0.0
 * @link https://kindevil.com
 */
class Plugin implements PluginInterface
{     
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     */
    public static function activate()
    {
        \Typecho\Plugin::factory('Widget_Archive')->header = array('DarkMode_Plugin', 'header');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @param Form $form 配置面板
     */
    public static function config(Form $form)
    {
        $script = new Radio('script', array(1=>_t('本地'),2=>_t('CDN')), 2, _t('Darkmode-js使用CDN还是本插件提供'), _t('默认CDN'));
        $form->addInput($script);

        $bottom = new Text('bottom', null, '32px', _t('距离底部位置'), _t('默认32px'));
        $form->addInput($bottom);

        $right = new Text('right', null, '32px', _t('距离右边位置'), _t('默认32px'));
        $form->addInput($right);

        $left = new Text('left', null, 'unset', _t('距离左边位置'), _t('默认32px'));
        $form->addInput($left);

        $time = new Text('time', null, '0.3s', _t('动画时间'), _t('默认0.3s'));
        $form->addInput($time);

        $mixColor = new Text('mixColor', null, '#fff', _t('mixColor'), _t('默认#fff'));
        $form->addInput($mixColor);

        $backgroundColor = new Text('backgroundColor', null, '#fff', _t('背景颜色'), _t('默认#fff'));
        $form->addInput($backgroundColor);

        $buttonColorDark = new Text('buttonColorDark', null, '#100f2c', _t('暗黑模式按钮颜色'), _t('默认#100f2c'));
        $form->addInput($buttonColorDark);

        $buttonColorLight = new Text('buttonColorLight', null, '#fff', _t('正常模式按钮颜色'), _t('默认#fff'));
        $form->addInput($buttonColorLight);

        $saveInCookies = new Radio('saveInCookies', array(true=>_t('是'),false=>_t('否')), true, _t('保存到Cookies'), _t('默认‘是’'));
        $form->addInput($saveInCookies);

        $label = new Text('label', null, '🌓', _t('切换按钮'), _t('默认🌓'));
        $form->addInput($label);

        $autoMatchOsTheme = new Radio('autoMatchOsTheme', array(true=>_t('是'),false=>_t('否')), true, _t('根据操作系统设置自动切换'), _t('默认‘是’'));
        $form->addInput($autoMatchOsTheme);
    }

    /**
     * 个人用户的配置面板
     *
     * @param Form $form
     */
    public static function personalConfig(Form $form)
    {
    }

    /**
     * 顶部输出JS
     *
     * @access public
     * @return void
     */
    public static function header()
    {
        $jqUrl = Options::alloc()->siteUrl."/usr/plugins/DarkMode/lib/darkmode-js.min.js";

        if (Options::alloc()->plugin('DarkMode')->script == 1) {
?>
<script src="<?php echo $jqUrl; ?>"></script>
<?php
        } else {
?>
<script src="https://cdn.jsdelivr.net/npm/darkmode-js@latest/lib/darkmode-js.min.js"></script>
<?php
        }
?>
<script>
    function addDarkmodeWidget() {
    const options = <?php echo json_encode(array(
        'bottom'=>Options::alloc()->plugin('DarkMode')->bottom,
        'right'=>Options::alloc()->plugin('DarkMode')->right,
        'left'=>Options::alloc()->plugin('DarkMode')->left,
        'time'=>Options::alloc()->plugin('DarkMode')->time,
        'mixColor'=>Options::alloc()->plugin('DarkMode')->mixColor,
        'backgroundColor'=>Options::alloc()->plugin('DarkMode')->backgroundColor,
        'buttonColorDark'=>Options::alloc()->plugin('DarkMode')->buttonColorDark,
        'buttonColorLight'=>Options::alloc()->plugin('DarkMode')->buttonColorLight,
        'saveInCookies'=>Options::alloc()->plugin('DarkMode')->saveInCookies,
        'label'=>Options::alloc()->plugin('DarkMode')->label,
        'autoMatchOsTheme'=>Options::alloc()->plugin('DarkMode')->autoMatchOsTheme
    ));?>

    const darkmode = new Darkmode(options);
    darkmode.showWidget();
    }
    window.addEventListener('load', addDarkmodeWidget);
</script>

<?php
    }
}
