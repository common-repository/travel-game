<?php

if ( ! class_exists( 'wscg_Main' ) ) {

	/**
	 * Main / front controller class
	 */
	class wscg_Main{

		const VERSION    = '1.0.0';
		const PREFIX     = 'wscg_';
        const REQUIRED_CAPABILITY = 'administrator';

        /**
         * Plugin directory path value. set in constructor
         * @access public
         * @var string
         */
        public static $plugin_dir;
        /**
         * Plugin url. set in constructor
         * @access public
         * @var string
         */
        public static $plugin_url;

        /**
         * Plugin name. set in constructor
         * @access public
         * @var string
         */
        public static $plugin_name;
        /*
         * initialize time option
         * */
        public static $settings;


		/**
		 * Constructor
		 */
		public function __construct() {

            self::$plugin_dir = plugin_dir_path(__FILE__);
            self::$plugin_url = plugins_url('', __FILE__);
            self::$plugin_name = plugin_basename(__FILE__);
            $this->register_hook_callbacks();
            add_shortcode('card_game_normal',array($this,'card_game_normal'));
            add_shortcode('card_game_small' , array($this, 'card_game_small'));
            if(get_option('WSCG_SETTING')!==false)
            {
                self::$settings=get_option('WSCG_SETTING');
            }
            else{
                self::$settings['init_dt']=time();
                self::$settings['chck_author']='0';
                self::$settings['set_time_check']='0';
                update_option('WSCG_SETTING',self::$settings);
            }

		}

		public function register_hook_callbacks() {

			add_action( 'wp_enqueue_scripts',   array($this ,'wscg_front_enqueue_scripts') );
			add_action( 'admin_enqueue_scripts',array($this, 'wscg_enqueue_scripts') );
            add_action( 'admin_init',             array($this, 'admin_init'));
            add_action('admin_menu',              array($this, 'wscg_plugin_menu'));
            add_action('admin_notices',array($this, 'show_admin_notice'));
        }



        public function admin_init() {

            add_action('wp_ajax_wscg_get_card_random', array( $this, 'wscg_get_card_random'));
			add_action('wp_ajax_nopriv_wscg_get_card_random', array( $this, 'wscg_get_card_random'));
            add_action('wp_ajax_wscg_get_card_random_small', array( $this, 'wscg_get_card_random_small'));
			add_action('wp_ajax_nopriv_wscg_get_card_random_small', array( $this, 'wscg_get_card_random_small'));
            add_action('wp_ajax_wscg_set_support_time',array($this,'wscg_set_support_time'));
            add_action('wp_ajax_wscg_set_support_link',array($this,'wscg_set_support_link'));
            add_action('wp_ajax_wscg_set_support_link_check',array($this, 'wscg_set_support_link_check'));


        }

        /**
         * Register CSS, JavaScript, etc
         */
     public function wscg_front_enqueue_scripts(){
        wp_register_style(self::PREFIX.'front_stylesheet',plugins_url('/css/wscg-user.css',dirname(__FILE__)),array(),self::VERSION,'all');
         wp_register_script(self::PREFIX.'front_js',plugins_url('/js/wscg-user.js',dirname(__FILE__)),array('jquery'),self::VERSION,true);
         wp_enqueue_style(self::PREFIX.'front_stylesheet');
         wp_enqueue_script(self::PREFIX.'front_js');
         wp_localize_script(self::PREFIX . 'front_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
         wp_localize_script(self::PREFIX.'front_js','message_object' , array('image_url' =>plugins_url('../images', __FILE__)));
     }
        public function wscg_enqueue_scripts()
        {
            wp_register_script(self::PREFIX.'admin_js',plugins_url('js/wscg_admin.js',dirname(__FILE__)),array('jquery'),self::VERSION,true);
            wp_register_style(self::PREFIX.'admin_css',plugins_url('/css/wscg_admin.css',dirname(__FILE__)),array(),self::VERSION,'all');
            wp_enqueue_script(self::PREFIX.'admin_js');
            wp_enqueue_style(self::PREFIX.'admin_css');
            wp_localize_script(self::PREFIX . 'admin_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );


        }
        function wscg_plugin_menu(){
            add_options_page('Travel Game Options', 'Travel Game', 'manage_options', 'wscg-plugin-menu', array($this,'wscg_game_options'));
        }
        function wscg_game_options(){
            include(ABSPATH.'wp-content/plugins/travel-game/settings.php');
        }
        /**
         * Creates the markup for the Settings header
         */

        public function card_game_normal(){
            $back=plugins_url('../images/back.png',__FILE__);
            $message=plugins_url('../images/winner.png', __FILE__);
            $play_game=plugins_url('../images/play.png', __FILE__);
            $html_string='<center><div class="card_game_panel" style="max-width: 700px; height: 500px;">
                      <div class="wscg_player_panel"><a id="wscg_player_link" href="#"><img id="wscg_player_image" src="'.$back.'"/></a> </div>
                      <div class="wscg_dealer_panel"><a id="wscg_dealer_link" href="#"><img id="wscg_dealer_image" src="'.$back.'"/></a></div>
                      <div class="wscg_control_panel">
                      <div class="wscg_result_message"><img id="wscg_result_message"  style="display:none"/></div>
                      <div class="wscg_control_button"><a id="wscg_start_game"><img id="wscg_start_image" src="'.$play_game.'"/> </a></div>
                      </div></div></center>';
            if(self::$settings['chck_author'] == '1')
            {
                $html_string.='<div style="text-align: center ;max-width: 700px;"> <p>Best Vacation Ideas – <a href="http://ideal-escapes.com/"> Ideal-Escapes.com</a> </p></div>';
            }


            echo $html_string;
        }
        public function card_game_small(){
            $back=plugins_url('../images/back.png',__FILE__);
            $message=plugins_url('../images/winner.png', __FILE__);
            $play_game=plugins_url('../images/play.png', __FILE__);
            $html_string='<center><div class="card_game_panel_small" style="max-width: 300px;height: 280px;">
                      <div class="wscg_player_panel_small"><a id="wscg_player_link_small" href="#"><img id="wscg_player_image_small" src="'.$back.'"/></a> </div>
                      <div class="wscg_dealer_panel_small"><a id="wscg_dealer_link_small" href="#"><img id="wscg_dealer_image_small" src="'.$back.'"/></a></div>
                      <div class="wscg_control_panel_small">
                      <div class="wscg_result_message_small"><img id="wscg_result_message_small" style="display:none"/></div>
                      <div class="wscg_control_button_small"><a id="wscg_start_game_small"><img id="wscg_start_image_small" src="'.$play_game.'"/> </a></div>
                      </div>

              </div></center>';
            if(self::$settings['chck_author'] == '1')
            {
                $html_string.='<div style="max-width: 300px; text-align: center ; font-size: 10px;"> <p>Best Vacation Ideas – <a href="http://ideal-escapes.com/"> Ideal-Escapes.com</a> </p></div>';
            }
            echo $html_string;
        }

        public function wscg_get_card_random()
        {
            $trigger=$_POST['wscg_start'];
            if($trigger=='1')
            {
                $card_group=wscg_Settings::set_cards();
                $length=count($card_group);
                $index_1=mt_rand(0,$length-1);

                $index_2=mt_rand(0,$length-1);
                $cards=array(
                    'player'=>array('image'=>plugins_url('../images/card'.$index_1.'.png', __FILE__),
                                     'link'=>'https://ideal-escapes.com/project/'.$card_group[$index_1][0].'/',
                                      'index'=>$card_group[$index_1][1]
                                    ),
                    'dealer'=>array('image'=>plugins_url('../images/card'.$index_2.'.png', __FILE__),
                        'link'=>'https://ideal-escapes.com/project/'.$card_group[$index_2][0].'/',
                        'index'=>$card_group[$index_2][1]
                    )
                );
                echo json_encode($cards);
                wp_die();
            }
        }
        public function wscg_get_card_random_small()
        {
            $trigger=$_POST['wscg_start'];
            if($trigger=='1')
            {
                $card_group=wscg_Settings::set_cards();
                $length=count($card_group);
                $index_1=mt_rand(0,$length-1);

                $index_2=mt_rand(0,$length-1);
                $cards=array(
                    'player'=>array('image'=>plugins_url('../images/card'.$index_1.'.png', __FILE__),
                        'link'=>'https://ideal-escapes.com/project/'.$card_group[$index_1][0].'/',
                        'index'=>$card_group[$index_1][1]
                    ),
                    'dealer'=>array('image'=>plugins_url('../images/card'.$index_2.'.png', __FILE__),
                        'link'=>'https://ideal-escapes.com/project/'.$card_group[$index_2][0].'/',
                        'index'=>$card_group[$index_2][1]
                    )
                );
                echo json_encode($cards);
                wp_die();
            }
        }

        public function show_admin_notice()
        {
            ?>

        <div class="updated" id="wscg_notice_support_view" style="<?php

          if(self::$settings['chck_author'] == '0')
          {
              if((time() - self::$settings['init_dt'])<24*60*60)
              {
                  if(self::$settings['set_time_check'] == '0')
                  {
                      echo 'display:block;';
                  }
                  else if(self::$settings['set_time_check'] == '1')
                  {
                      echo 'display:none;';
                  }
              }
              else{
                  echo 'display: block;';
                  self::$settings['set_time_check']='0';
                  update_option('WSCG_SETTING',self::$settings);
              }
          }
        else
        {
            echo 'display: none;';
        }

        ?>">
             <div class="wscg_support_click_title wscg_support_click_common" id="wscg_support_title_1">
                 Thank you for using our Travel Game,
                 <a href="#" id="wscg_notice_support_click">
                     if you like our plugin please activate the author credits by clicking here!
                 </a>
             </div>
            <div class="wscg_support_click_title wscg_support_click_common" id="wscg_support_title_2" style="display: none;">
                Thank you for supporting Travel Game
            </div>
            <div style="float: right;" id="wscg_support_title_3">
                <a href="#" id="wscg_notice_support_close">Hide</a>
            </div>
            </div>
        <?php

        }

        public function wscg_set_support_time(){
            self::$settings['init_dt']=time();
            self::$settings['set_time_check']= $_POST['set_time_check'];
            update_option('WSCG_SETTING',self::$settings);
            die();

        }
        public function wscg_set_support_link(){
            self::$settings['chck_author'] = '1';
            update_option('WSCG_SETTING',self::$settings);
            die();

        }
        public function wscg_set_support_link_check()
        {
            self::$settings['chck_author'] = $_POST['state'];
            update_option('WSCG_SETTING',self::$settings);
            die();
        }
    } // end wscg_Main

}
