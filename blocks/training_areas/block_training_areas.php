<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Training Areas Block
 *
 * @package   block_training_areas
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_training_areas extends block_base {
    
    function init() {
        $this->title = get_string('pluginname', 'block_training_areas');
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function specialization() {
        if (isset($this->config->title)) {
            $this->title = format_string($this->config->title, true, ['context' => $this->context]);
        } else {
            $this->title = get_string('newtrainingareasblock', 'block_training_areas');
        }
    }

    function instance_allow_multiple() {
        return true;
    }

    function get_content() {
        global $CFG;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->footer = '';
        
        // Get configuration
        $section_title = isset($this->config->section_title) ? $this->config->section_title : 'مجالات التدريب';
        $section_description = isset($this->config->section_description) ? $this->config->section_description : 'نسعى لتمكينك بأحدث المعارف والمهارات التي تُحدث فارقًا في مسارك المهني والأكاديمي';
        
        // Get training areas from configuration
        $training_areas = $this->get_training_areas_from_config();
        
        // Generate the training areas section HTML
        $this->content->text = $this->generate_training_areas_section($section_title, $section_description, $training_areas);

        return $this->content;
    }

    private function get_training_areas_from_config() {
        $training_areas = array();
        
        if (isset($this->config->training_areas_count)) {
            $count = intval($this->config->training_areas_count);
            
            for ($i = 0; $i < $count; $i++) {
                $title = isset($this->config->{'training_area_' . $i . '_title'}) ? $this->config->{'training_area_' . $i . '_title'} : '';
                $subtitle = isset($this->config->{'training_area_' . $i . '_subtitle'}) ? $this->config->{'training_area_' . $i . '_subtitle'} : 'دورات معتمدة';
                $image_url = isset($this->config->{'training_area_' . $i . '_image_url'}) ? $this->config->{'training_area_' . $i . '_image_url'} : '';
                $alt_text = isset($this->config->{'training_area_' . $i . '_alt_text'}) ? $this->config->{'training_area_' . $i . '_alt_text'} : $title;
                
                if (!empty($title) && !empty($image_url)) {
                    $training_areas[] = array(
                        'title' => $title,
                        'subtitle' => $subtitle,
                        'image_url' => $image_url,
                        'alt_text' => $alt_text
                    );
                }
            }
        }
        
        // If no training areas configured, use defaults
        if (empty($training_areas)) {
            $training_areas = $this->get_default_training_areas();
        }
        
        return $training_areas;
    }

    private function get_default_training_areas() {
        return array(
            array(
                'title' => 'برامج التعليم الالكتروني',
                'subtitle' => 'دورات معتمدة',
                'image_url' => 'https://i.ibb.co/97S4fKG/image-2.png',
                'alt_text' => 'Electronic Education Programs'
            ),
            array(
                'title' => 'تقنيات الذكاء الاصطناعي',
                'subtitle' => 'دورات متقدمة',
                'image_url' => 'https://i.ibb.co/n87KXSZv/image-3.png',
                'alt_text' => 'Artificial Intelligence Technologies'
            ),
            array(
                'title' => 'برنامج ذوي الاعاقة',
                'subtitle' => 'دورات متخصصة',
                'image_url' => 'https://i.ibb.co/yFYDJrwx/image-6.png',
                'alt_text' => 'People with Disabilities Program'
            ),
            array(
                'title' => 'مجالات أخرى',
                'subtitle' => 'دورات متنوعة',
                'image_url' => 'https://i.ibb.co/kghtY6bH/image-10.png',
                'alt_text' => 'Other Areas'
            ),
            array(
                'title' => 'التعليم والتعلم الجامعي',
                'subtitle' => 'دورات أكاديمية',
                'image_url' => 'https://i.ibb.co/5gfBdmyh/image-9.png',
                'alt_text' => 'University Education and Learning'
            ),
            array(
                'title' => 'البرامج الجامعية القصيرة',
                'subtitle' => 'دورات مكثفة',
                'image_url' => 'https://i.ibb.co/tMmLx47M/image-8.png',
                'alt_text' => 'Short University Programs'
            ),
            array(
                'title' => 'مهارات الحياة',
                'subtitle' => 'دورات تطويرية',
                'image_url' => 'https://i.ibb.co/zVq2nphg/image-7.png',
                'alt_text' => 'Life Skills'
            ),
            array(
                'title' => 'مهارات الأمن السيبراني',
                'subtitle' => 'دورات أمنية',
                'image_url' => 'https://i.ibb.co/k2cvyLFT/image-4.png',
                'alt_text' => 'Cybersecurity Skills'
            )
        );
    }

    private function generate_training_areas_section($title, $description, $training_areas) {
        $html = '
        <style>
        .training-areas-block {
            font-family: "DIN Next LT Arabic", "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            direction: rtl;
            text-align: right;
        }
        .training-container {
            color: rgb(2, 8, 23);
            direction: rtl;
            background-color: rgba(249, 250, 251, 0.8);
            position: relative;
            padding-top: 5rem;
            padding-bottom: 5rem;
            box-sizing: border-box;
        }
        .training-background {
            position: absolute;
            right: 0px;
            top: 0px;
            height: 24rem;
            width: 24rem;
            opacity: 0.3;
            box-sizing: border-box;
        }
        .training-background::before {
            content: "";
            height: 100%;
            width: 100%;
            border-radius: 9999px;
            background-color: rgba(97, 239, 255, 0.3);
            filter: blur(64px);
            box-sizing: border-box;
            position: absolute;
            inset: 0;
        }
        .training-content {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 2rem;
            padding-left: 2rem;
            position: relative;
            z-index: 10;
            box-sizing: border-box;
            @media (min-width: 1400px) {
                max-width: 1400px;
            }
        }
        .training-header {
            margin-bottom: 4rem;
            text-align: center;
            box-sizing: border-box;
        }
        .training-title {
            margin: 0px;
            font-size: 48px;
            line-height: 1;
            font-weight: 700;
            color: rgb(16, 82, 162);
            box-sizing: border-box;
        }
        .training-description {
            margin: 0px;
            max-width: 42rem;
            font-size: 18px;
            line-height: 1.75rem;
            color: rgb(113, 114, 132);
            box-sizing: border-box;
            margin: 0 auto;
        }
        .training-grid-top {
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: repeat(1, minmax(0px, 1fr));
            gap: 2rem;
            box-sizing: border-box;
            @media (min-width: 768px) {
                grid-template-columns: repeat(2, minmax(0px, 1fr));
            }
            @media (min-width: 1024px) {
                grid-template-columns: repeat(4, minmax(0px, 1fr));
            }
        }
        .training-grid-bottom {
            display: grid;
            grid-template-columns: repeat(1, minmax(0px, 1fr));
            gap: 2rem;
            box-sizing: border-box;
            @media (min-width: 768px) {
                grid-template-columns: repeat(2, minmax(0px, 1fr));
            }
            @media (min-width: 1024px) {
                grid-template-columns: repeat(4, minmax(0px, 1fr));
            }
        }
        .training-card {
            position: relative;
            border-radius: 32px;
            padding: 1.5rem;
            background-color: #f9fafb;
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
            animation-duration: 300ms;
            box-sizing: border-box;
        }
        .training-card:hover {
            box-shadow: rgba(0, 0, 0, 0) 0px 0px, rgba(0, 0, 0, 0) 0px 0px, rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.1) 0px 8px 10px -6px;
        }
        .training-icon {
            position: relative;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 1.5rem;
            height: 5rem;
            width: 5rem;
            box-sizing: border-box;
        }
        .training-icon img {
            height: 100%;
            width: 100%;
            object-fit: contain;
            display: block;
            vertical-align: middle;
            max-width: 100%;
            box-sizing: border-box;
            filter: grayscale(100%);
            transition: filter 0.3s ease;
        }
        .training-card:hover .training-icon img {
            filter: grayscale(0%);
        }
        .training-card-content {
            text-align: center;
            box-sizing: border-box;
        }
        .training-card-title {
            margin: 0px;
            font-size: 18px;
            line-height: 1.75rem;
            font-weight: 500;
            color: rgb(16, 82, 162);
            box-sizing: border-box;
        }
        .training-card-subtitle {
            font-size: 14px;
            line-height: 1.25rem;
            color: rgb(113, 114, 132);
            margin: 0px;
            box-sizing: border-box;
        }
        .training-card-decoration {
    position: absolute;
    top: 1rem;
    right: 1rem;
    height: 3rem;
    width: 3rem;
    border-top-left-radius: 9999px;
    background-color: rgba(97, 239, 255, 0.1);
    opacity: 0;
    transition-property: opacity;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
    box-sizing: border-box;
        }
        .training-card:hover .training-card-decoration {
            opacity: 1;
        }
        .training-card-animated-corner {
            position: absolute;
            bottom: -1rem;
            left: -1rem;
            height: 4rem;
            width: 4rem;
            opacity: 0;
            transform: scale(0.8) rotate(-10deg);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
            pointer-events: none;
        }
        .training-card:hover .training-card-animated-corner {
            opacity: 1;
            transform: scale(1.8) rotate(0deg) translate(7px, -8px);
        }
        @media (max-width: 768px) {
            .training-title {
                font-size: 2.5rem;
            }
            .training-description {
                font-size: 1rem;
            }
        }
        </style>
        
        <div class="training-areas-block">
            <div class="training-container">
                <div class="training-background"></div>
                <div class="training-content">
                    <div class="training-header">
                        <h2 class="training-title">' . htmlspecialchars($title) . '</h2>
                        <p class="training-description">' . htmlspecialchars($description) . '</p>
                    </div>
                    
                    <!-- Top row - 4 cards -->
                    <div class="training-grid-top">';
        
        // First 4 training areas
        for ($i = 0; $i < min(4, count($training_areas)); $i++) {
            $area = $training_areas[$i];
            $html .= '
                        <div class="training-card">
                            <div class="training-icon">
                                <img src="' . htmlspecialchars($area['image_url']) . '" alt="' . htmlspecialchars($area['alt_text']) . '" />
                            </div>
                            <div class="training-card-content">
                                <h3 class="training-card-title">' . htmlspecialchars($area['title']) . '</h3>
                                <p class="training-card-subtitle">' . htmlspecialchars($area['subtitle']) . '</p>
                            </div>
                            <div class="training-card-decoration"></div>
                            <img src="https://i.ibb.co/93fdLxNg/image-11.png" alt="Animated Corner" class="training-card-animated-corner" />
                        </div>';
        }
        
        $html .= '
                    </div>
                    
                    <!-- Bottom row - remaining cards -->
                    <div class="training-grid-bottom">';
        
        // Remaining training areas
        for ($i = 4; $i < count($training_areas); $i++) {
            $area = $training_areas[$i];
            $html .= '
                        <div class="training-card">
                            <div class="training-icon">
                                <img src="' . htmlspecialchars($area['image_url']) . '" alt="' . htmlspecialchars($area['alt_text']) . '" />
                            </div>
                            <div class="training-card-content">
                                <h3 class="training-card-title">' . htmlspecialchars($area['title']) . '</h3>
                                <p class="training-card-subtitle">' . htmlspecialchars($area['subtitle']) . '</p>
                            </div>
                            <div class="training-card-decoration"></div>
                            <img src="https://i.ibb.co/93fdLxNg/image-11.png" alt="Animated Corner" class="training-card-animated-corner" />
                        </div>';
        }
        
        $html .= '
                    </div>
                </div>
            </div>
        </div>';
        
        return $html;
    }
}
