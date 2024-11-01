<?php

if ( ! class_exists( 'wscg_Settings' ) ) {

    /**
     *
     */
    class wscg_Settings{

        public static $wscg_cards;
       public function __construct() {
           self::$wscg_cards=$this->set_cards();

       }
        public static function set_cards()
        {
            $cards=array(
                array('mallorca',18),array('madeira',22),array('costa-rica',24),array('prague',9),array('paris',12),
                array('black-forest',11),array('borneo',30),array('bali',31),array('hawaii',27),array('chamonix',7),array('monte-carlo',15),
                array('maldives',28),array('queenstown',10),array('zanzibar',27),array('agra',26),array('stockholm',7),array('athens',19),
                array('zurich',10),array('madrid',16),array('istanbul',14),array('copenhagen',8),array('bora-bora',27),array('menorca',18),array('sicily',14),
                array('tenerife',21),array('glacier-bay',4),array('spitsbergen',-4),array('reykjavik',5),array('bahamas',25),array('havana',23),array('whistler',6),
                array('new-york',13),array('sankt-petersburg',6),array('bangkok',29),array('amsterdam',11),array('puerto-rico',26),array('budapest',11),array('ibiza',18),
                array('crete',22),array('barbados',28),array('corsica',14),array('florida-keys',23));
            return $cards;
        }

    }
}
