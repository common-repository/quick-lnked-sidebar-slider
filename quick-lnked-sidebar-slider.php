<?php

/*

Plugin Name: Quick Lnked Sidebar Slider

Plugin URI: http://geniusextensions.com/wpdemo/

Description: Thank you for installing Quick Lnked Sidebar Slider.

Author: geniusextensions

Version: 1.0

Author URI: http://geniusextensions.com/wpdemo/

*/

class RealLinkedinSlider{



    public $options;



    public function __construct() {

        $this->options = get_option('real_linkedin_plugin_options');

        $this->real_linkedin_register_settings_and_fields();

    }



    public static function add_real_linkedin_plugin_options_page(){

        add_options_page('Quick Lnked Sidebar Slider', 'Quick Lnked Sidebar Slider', 'administrator', __FILE__, array('RealLinkedinSlider','real_linkedin_plugin_options'));

    }


public static function real_linkedin_plugin_options(){?>

    <div class="wrap">

        <?php screen_icon(); ?>

        <h2>LinkedIn Configuration</h2>

        <form method="post" action="options.php" enctype="multipart/form-data">

            <?php settings_fields('real_linkedin_plugin_options'); ?>

            <?php do_settings_sections(__FILE__); ?>

            <p class="submit">

                <input name="submit" type="submit" class="button-primary" value="Save Changes"/>

            </p>

        </form>

    </div>

    <?php }

    public function real_linkedin_register_settings_and_fields(){

        register_setting('real_linkedin_plugin_options', 'real_linkedin_plugin_options',array($this,'real_linkedin_validate_settings'));

        add_settings_section('real_linkedin_main_section', 'Settings', array($this,'real_linkedin_main_section_cb'), __FILE__);

        add_settings_field('linkedin_pub_id', 'Linkedin ID', array($this,'pageURL_settings'), __FILE__,'real_linkedin_main_section');

        //alignment option

         add_settings_field('alignment', 'Alignment Position', array($this,'position_settings'),__FILE__,'real_linkedin_main_section');

        //marginTop

        add_settings_field('marginTop', 'Margin Top', array($this,'marginTop_settings'), __FILE__,'real_linkedin_main_section');

        //width

        add_settings_field('width', 'Width', array($this,'width_settings'), __FILE__,'real_linkedin_main_section');

        //height

        add_settings_field('height', 'Height', array($this,'height_settings'), __FILE__,'real_linkedin_main_section');



        //jQuery options

    }

    public function real_linkedin_validate_settings($plugin_options){

        return($plugin_options);

    }

    public function real_linkedin_main_section_cb(){

        //optional

    }


    //pageURL_settings

    public function pageURL_settings() {

        if(empty($this->options['linkedin_pub_id'])) $this->options['linkedin_pub_id'] = "linkedin";

        echo "<input name='real_linkedin_plugin_options[linkedin_pub_id]' type='text' value='{$this->options['linkedin_pub_id']}' />";

    }



    //marginTop_settings

    public function marginTop_settings() {

        if(empty($this->options['marginTop'])) $this->options['marginTop'] = "100";

        echo "<input name='real_linkedin_plugin_options[marginTop]' type='text' value='{$this->options['marginTop']}' />";

    }

    //alignment_settings

    public function position_settings(){

        if(empty($this->options['alignment'])) $this->options['alignment'] = "left";

        $items = array('left','right');

        echo "<select name='real_linkedin_plugin_options[alignment]'>";

        foreach($items as $item){

            $selected = ($this->options['alignment'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }

    //width_settings

    public function width_settings() {

        if(empty($this->options['width'])) $this->options['width'] = "350";

        echo "<input name='real_linkedin_plugin_options[width]' type='text' value='{$this->options['width']}' />";

    }

    //height_settings

    public function height_settings() {

        if(empty($this->options['height'])) $this->options['height'] = "150";

        echo "<input name='real_linkedin_plugin_options[height]' type='text' value='{$this->options['height']}' />";

    }

}

add_action('admin_menu', 'real_linkedin_trigger_options_function');



function real_linkedin_trigger_options_function(){

    RealLinkedinSlider::add_real_linkedin_plugin_options_page();

}



add_action('admin_init','real_linkedin_trigger_create_object');

function real_linkedin_trigger_create_object(){

    new RealLinkedinSlider();

}

add_action('wp_footer','real_linkedin_add_content_in_footer');

function real_linkedin_add_content_in_footer(){
    $o = get_option('real_linkedin_plugin_options');
    extract($o);
    $total_height=$height-110;
    $total_width=$width+40;
    $print_linkedin = '';
    $print_linkedin .= '<script type="IN/MemberProfile" data-id="http://www.linkedin.com/in/'.$linkedin_pub_id.'"data-format="inline" data-related="false"></script>';
    $imgURL = plugin_dir_url(__FILE__).'assets/linkedin-icon.png';
?>
    <!-- <script src="//platform.linkedin.com/in.js" type="text/javascript"></script> -->

<?php if($alignment=='left'){?>

<div id="linkedin_display">
    <div id="lbox1" style="left: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+15);?>px;">
        <div id="lbox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">
            <a class="open" id="llink" href="#"></a><img style="top: 0px;right:-50px;" src="<?php echo $imgURL;?>" alt="">
            <?php echo $print_linkedin; ?>
        </div>
    </div>
</div>

<script type="text/javascript">

jQuery.noConflict();

jQuery(function (){

jQuery(document).ready(function()

{

jQuery.noConflict();

jQuery(function (){

jQuery("#lbox1").hover(function(){

jQuery('#lbox1').css('z-index',101009);

jQuery(this).stop(true,false).animate({left:  0}, 500); },

function(){

    jQuery('#lbox1').css('z-index',10000);

    jQuery("#lbox1").stop(true,false).animate({left: -<?php echo trim($width+10); ?>}, 500); });

});}); });

jQuery.noConflict();

</script>

<?php } else { ?>

<div id="linkedin_display">

    <div id="lbox1" style="right: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+15);?>px;">

        <div id="lbox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">

            <a class="open" id="llink" href="#"></a><img style="top: 0px;left:-50px;" src="<?php echo $imgURL;?>" alt="">

            <?php echo $print_linkedin; ?>
        </div>

    </div>

</div>



<script type="text/javascript">

jQuery.noConflict();

jQuery(function (){

jQuery(document).ready(function()

{

jQuery.noConflict();

jQuery(function (){

jQuery("#lbox1").hover(function(){

jQuery('#lbox1').css('z-index',101009);

jQuery(this).stop(true,false).animate({right:  0}, 500); },

function(){

    jQuery('#lbox1').css('z-index',10000);



    jQuery("#lbox1").stop(true,false).animate({right: -<?php echo trim($width+10); ?>}, 500); });

});}); });

jQuery.noConflict();

</script>

<?php } ?>

<?php

}

add_action( 'wp_enqueue_scripts', 'register_real_linkedin_slider_styles' );

 function register_real_linkedin_slider_styles() {
    wp_register_style( 'register_real_linkedin_slider_styles', plugins_url( 'assets/style.css' , __FILE__ ) );
    wp_enqueue_style( 'register_real_linkedin_slider_styles' );
    wp_enqueue_script('jquery');
    wp_enqueue_script('ps_linkdin_js','//platform.linkedin.com/in.js');

 }

 $real_linkedin_plugin_options = array(

     'sidebarImage' => 'linkedin-icon.png',

     'marginTop' => 100,

     'pinterest_username' => 'linkedin',

     'width' => '350',

     'height' => '150',

     'alignment' => 'left'

 );

 add_option('real_linkedin_plugin_options', $real_linkedin_plugin_options);
