<?php

class Elementoreshapewidget extends \Elementor\Widget_Base {

	public function get_name() {
        return "shapewidget";
    }

	public function get_title() {
        return __( "Themeshape Widget","elementortheshape");
    }

	public function get_icon() {
		return 'fa fa-code';
	}

	public function get_categories() {
        return array('general');
    }

	protected function _register_controls() {
        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'elementortheshape' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => __( 'Type your heading', 'elementortheshape' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				
				'placeholder' => __( 'Enter Your heading', 'elementortheshape' ),
			]
        );
        
		$this->add_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'elementortheshape' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default'=>'left',
                'options' => [
					'center'  => __( 'Center', 'elementortheshape' ),
					'left'  => __( 'Left', 'elementortheshape' ),
					'right'  => __( 'Right', 'elementortheshape' ),
				],
			]
		);

		$this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        $heading = $settings['heading'];
        $alignment = $settings['alignment'];

        echo "<h4 style='text-align:".esc_attr("$alignment")."'>".esc_html($heading)."</h4>";
		
    }

	protected function _content_template() {}

}