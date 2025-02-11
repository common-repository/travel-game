<?php

class wscg_game_widget extends WP_Widget{

    function __construct() {
        parent::__construct(
            'wscg_game_widget',
            __('Travel Game','wscg_lang'),
            array( 'description' => __( 'Travel Game', 'wscg_lang' ), )
        );
    }
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
// This is where you run the code and display the output
        $game=new wscg_Main();
        $game->card_game_small();
        echo $args['after_widget'];
    }
// Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Card Game', 'wpb_widget_domain' );
        }

// Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
    <?php
    }

// Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here

// Register and load the widget
function wscg_load_widget() {
    register_widget( 'wscg_game_widget' );
}
add_action( 'widgets_init', 'wscg_load_widget' );
