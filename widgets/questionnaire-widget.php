<?php
/**
 * Elementor Questionnaire Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Prüfen ob Elementor aktiv ist
if (!did_action('elementor/loaded')) {
    return;
}

// Elementor-Klassen laden
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

class Questionnaire_Widget extends Widget_Base {

    public function get_name() {
        return 'questionnaire';
    }

    public function get_title() {
        return __('Interactive Questionnaire', 'questionnaire-plugin');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_script_depends() {
        return ['questionnaire-widget'];
    }

    public function get_style_depends() {
        return ['questionnaire-widget'];
    }

    protected function register_controls() {
        $defaults = include __DIR__ . '/../defaults/questionnaire-defaults.php';

        // Content Section - Fragen verwalten
        $this->start_controls_section(
            'questions_section',
            [
                'label' => __('Questions', 'questionnaire-plugin'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'question_text',
            [
                'label' => __('Question Text', 'questionnaire-plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Your question here...', 'questionnaire-plugin'),
            ]
        );

        $repeater->add_control(
            'result_mappings',
            [
                'label' => __('Result Mapping', 'questionnaire-plugin'),
                'type' => Controls_Manager::TEXT,
                'description' => __('Has to match the mapping value in one of the results', 'questionnaire-plugin'),
                'default' => 'leadership',
            ]
        );

        $this->add_control(
            'questions',
            [
                'label' => __('Questions List', 'questionnaire-plugin'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $defaults['questions'],
                'title_field' => '{{{ question_text }}}',
            ]
        );

        $this->end_controls_section();

        // Results Section
        $this->start_controls_section(
            'results_section',
            [
                'label' => __('Result Types', 'questionnaire-plugin'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $results_repeater = new Repeater();

        $results_repeater->add_control(
            'result_id',
            [
                'label' => __('Mapping', 'questionnaire-plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => 'leadership',
            ]
        );

        $results_repeater->add_control(
            'result_title',
            [
                'label' => __('Result Title', 'questionnaire-plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Ueberschrift',
            ]
        );

        $this->add_control(
            'result_types',
            [
                'label' => __('Available Results', 'questionnaire-plugin'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $results_repeater->get_controls(),
                'default' => $defaults['result_types'],
                'title_field' => '{{{ result_title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section - Allgemeine Styles
        $this->start_controls_section(
            'general_style',
            [
                'label' => __('General Style', 'questionnaire-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'progress_margin',
            [
                'label' => __('Progress Bar Margin', 'questionnaire-plugin'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .questionnaire-progress-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );        

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'questionnaire_typography',
                'label' => __('Questionnaire Font', 'questionnaire-plugin'),
                'selector' => '{{WRAPPER}} .questionnaire-question',
            ]
        );

        $this->end_controls_section();

        // Button Style Section
        $this->start_controls_section(
            'button_style',
            [
                'label' => __('Rating Buttons', 'questionnaire-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Button Color', 'questionnaire-plugin'),
                'type' => Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .rating-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );        

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Button Text Color', 'questionnaire-plugin'),
                'type' => Controls_Manager::COLOR,
                'default' => '#eee',
                'selectors' => [
                    '{{WRAPPER}} .rating-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => __('Button Size', 'questionnaire-plugin'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rating-button' => 'min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_spacing',
            [
                'label' => __('Button Spacing', 'questionnaire-plugin'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rating-button' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'questionnaire_rating_label_typography',
                'label' => __('Rating Labels Font', 'questionnaire-plugin'),
                'selector' => '{{WRAPPER}} .rating-label',
            ]
        );

        $this->add_control(
            'rating_label_padding',
            [
                'label' => __('Rating Labels Padding', 'questionnaire-plugin'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rating-label' => 'padding: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );        

        $this->end_controls_section();

        // Result Styles
        $this->start_controls_section(
            'result_style',
            [
                'label' => __('Result', 'questionnaire-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'result_bar_font',
                'label' => __('Result Claims Font', 'questionnaire-plugin'),
                'selector' => '{{WRAPPER}} .questionnaire-results-bar-label',
            ]
        );

        $this->add_control(
            'results_bar_color',
            [
                'label' => __('Result Bars Color', 'questionnaire-plugin'),
                'type' => Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .questionnaire-results-bar-value' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_value_color',
            [
                'label' => __('Result Values Font Color', 'questionnaire-plugin'),
                'type' => Controls_Manager::COLOR,
                'default' => '#C8E1F8',
                'selectors' => [
                    '{{WRAPPER}} .questionnaire-results-bar-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'result_title_padding',
            [
                'label' => __('Result Title Bottom Spacing', 'questionnaire-plugin'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .questionnaire-result-title' => 'padding-bottom: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'result_title_font',
                'label' => __('Result Title Font', 'questionnaire-plugin'),
                'selector' => '{{WRAPPER}} .questionnaire-result-title',
            ]
        );
        
        $this->end_controls_section();        
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        $editMode = \Elementor\Plugin::$instance->editor->is_edit_mode();
        ?>
        
        <div class="questionnaire-container"
             id="questionnaire-<?php echo esc_attr($widget_id); ?>"
             data-questions="<?php echo esc_attr(wp_json_encode($settings['questions'])); ?>"
             data-result-types="<?php echo esc_attr(wp_json_encode($settings['result_types'])); ?>">
            
            <!-- Progress Bar -->
            <div class="questionnaire-progress-wrapper">
                <div class="questionnaire-progress-bar" style="width: 0%"></div>
            </div>
            
            <!-- Questions Container -->
            <div class="questionnaire-questions" style="display: block;">
                <?php foreach ($settings['questions'] as $index => $question): ?>
                    <div class="questionnaire-question-wrapper" 
                         data-question="<?php echo esc_attr($index); ?>"
                         style="<?php echo $index === 0 ? 'display: block;' : 'display: none;'; ?>">
                        
                        <div class="questionnaire-question">
                            <?php echo esc_html($question['question_text']); ?>
                        </div>
                        
                        <div class="rating-grid-auto-container">
                            <?php for ($i = 0; $i <= 3; $i++): ?>
                                <button type="button" 
                                        class="rating-button" 
                                        data-value="<?php echo $i; ?>"
                                        data-question="<?php echo esc_attr($index); ?>"
                                        data-mappings="<?php echo esc_attr($question['result_mappings']); ?>">
                                    <?php echo $i; ?>
                                </button>
                            <?php endfor; ?>
                            <div class="rating-grid-auto-text">
                                <span class="rating-label" style="text-align:left;">Trifft nicht zu</span>
                                <span class="rating-label" style="text-align:right;">Trifft voll zu</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Results Display -->
            <div class="questionnaire-results" <?php if (!$editMode) echo " style=\"display: none;\""?>>
                <h3 class="elementor-heading-title questionnaire-result-title">Dein Ergebnis</h3>
                <div class="results-content elementor-text-editor">
                <div class="questionnaire-results-chart">
                    <div class="questionnaire-results-bar-container">
                        <span class="questionnaire-results-bar-label">Die innere Stimme der Kämpferin</span>
                        <div class="questionnaire-results-bar-value" style="width: 100%;">11 Punkte</div>
                    </div>
                    <div class="questionnaire-results-bar-container">
                        <span class="questionnaire-results-bar-label">Die innere Stimme der Planerin</span>
                        <div class="questionnaire-results-bar-value" style="width: 91%;">10 Punkte</div>
                    </div>
                    <div class="questionnaire-results-bar-container">
                        <span class="questionnaire-results-bar-label">Die innere Stimme der Unabhängigen</span>
                        <div class="questionnaire-results-bar-value" style="width: 82%;">9 Punkte</div>
                    </div>
                    <div class="questionnaire-results-bar-container">
                        <span class="questionnaire-results-bar-label">Die innere Stimme der Harmonie-Sucherin</span>
                        <div class="questionnaire-results-bar-value" style="width: 55%;">6 Punkte</div>
                    </div>
                    <div class="questionnaire-results-bar-container">
                        <span class="questionnaire-results-bar-label">Die innere Stimme der Perfektionistin</span>
                        <div class="questionnaire-results-bar-value" style="width: 5%;">1 Punkt</div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <# 
        const widgetId = 'preview-' + Math.random().toString(36).substr(2, 9);
        #>
        
        <div class="questionnaire-container">
            <div class="questionnaire-progress-wrapper">
                <div class="questionnaire-progress-bar" style="width: 0%"></div>
            </div>
            
            <div class="questionnaire-questions">
                <# _.each(settings.questions, function(question, index) { #>
                    <div class="questionnaire-question-wrapper" style="<# print(index === 0 ? 'display: block;' : 'display: none;') #>">
                        <div class="questionnaire-question">{{{ question.question_text }}}</div>
                        
                        <div class="rating-grid-auto-container">
                            <# for(let i = 0; i <= 3; i++) { #>
                                <button type="button" class="rating-button">
                                    {{{ i }}}
                                </button>
                            <# } #>
                            <div class="rating-grid-auto-text">
                                <span class="rating-label" style="text-align:left;">Trifft nicht zu</span>
                                <span class="rating-label" style="text-align:right;">Trifft voll zu</span>
                            </div>
                        </div>
                    </div>
                <# }); #>
            </div>
            
            <div class="questionnaire-results" style="margin-top:30px;">
                <h3 class="elementor-heading-title questionnaire-result-title">Dein Ergebnis</h3>
                <div class="results-content elementor-text-editor">
                    <div class="questionnaire-results-chart">
                        <div class="questionnaire-results-bar-container">
                            <span class="questionnaire-results-bar-label">Die innere Stimme der Kämpferin</span>
                            <div class="questionnaire-results-bar-value" style="width: 100%;">11 Punkte</div>
                        </div>
                        <div class="questionnaire-results-bar-container">
                            <span class="questionnaire-results-bar-label">Die innere Stimme der Planerin</span>
                            <div class="questionnaire-results-bar-value" style="width: 91%;">10 Punkte</div>
                        </div>
                        <div class="questionnaire-results-bar-container">
                            <span class="questionnaire-results-bar-label">Die innere Stimme der Unabhängigen</span>
                            <div class="questionnaire-results-bar-value" style="width: 82%;">9 Punkte</div>
                        </div>
                        <div class="questionnaire-results-bar-container">
                            <span class="questionnaire-results-bar-label">Die innere Stimme der Harmonie-Sucherin</span>
                            <div class="questionnaire-results-bar-value" style="width: 55%;">6 Punkte</div>
                        </div>
                        <div class="questionnaire-results-bar-container">
                            <span class="questionnaire-results-bar-label">Die innere Stimme der Perfektionistin</span>
                            <div class="questionnaire-results-bar-value" style="width: 5%;">1 Punkt</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

?>