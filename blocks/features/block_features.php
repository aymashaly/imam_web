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
 * Features Block
 *
 * @package   block_features
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_features extends block_base {
    
    function init() {
        $this->title = get_string('pluginname', 'block_features');
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
            $this->title = get_string('newfeaturesblock', 'block_features');
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
        $section_title = isset($this->config->section_title) ? $this->config->section_title : 'مميزات بُعد';
        $section_subtitle = isset($this->config->section_subtitle) ? $this->config->section_subtitle : 'تدريبٌ يُحدِثُ القَفزة';
        
        // Features data
        $features = isset($this->config->features) ? $this->config->features : $this->get_default_features();
        
        // Generate the features section HTML
        $this->content->text = $this->generate_features_section($section_title, $section_subtitle, $features);

        return $this->content;
    }

    private function get_default_features() {
        return array(
            // Row 1, Left Item
            array(
                'title' => 'دورات مجانية / مدفوعة',
                'subtitle' => 'مع شهادة إتمام مجانية / مدفوعة',
                'icon_color' => 'light-blue',
                'icon_type' => 'laptop'
            ),
            // Row 1, Right Item
            array(
                'title' => 'المؤتمرات الوطنية والدولية',
                'subtitle' => 'مع شهادة مجانية / مدفوعة',
                'icon_color' => 'red',
                'icon_type' => 'presentation'
            ),
            // Row 2, Left Item
            array(
                'title' => 'البرامج المهنية المدفوعة',
                'subtitle' => 'الدرجات المصغرة',
                'icon_color' => 'orange',
                'icon_type' => 'documents'
            ),
            // Row 2, Right Item
            array(
                'title' => 'البرامج المهنية المدفوعة',
                'subtitle' => 'الدرجات المصغرة',
                'icon_color' => 'yellow',
                'icon_type' => 'graduation'
            ),
            // Row 3, Left Item
            array(
                'title' => 'دورات مخصصة',
                'subtitle' => 'مع شهادة مجانية / مدفوعة',
                'icon_color' => 'orange',
                'icon_type' => 'group'
            ),
            // Row 3, Right Item
            array(
                'title' => 'مدونات الخبراء',
                'subtitle' => 'مع شهادة مجانية / مدفوعة',
                'icon_color' => 'brown',
                'icon_type' => 'chat'
            )
        );
    }

    private function generate_features_section($title, $subtitle, $features) {
        $html = '
        <style>
        .features-block {
            font-family: "DIN Next LT Arabic", "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            direction: rtl;
            text-align: right;
        }
        
        /* Hide from home page container */
        .d-print-block .bottom-region-main-box .features-block {
            display: none !important;
        }
        .features-container {
            background: #ffffff;
            padding: 4rem 2rem;
            position: relative;
        }
        .features-content {
        }
        .features-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        .features-title {
            font-size: 3rem;
            font-weight: 700;
            color: #123071;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        .features-subtitle {
            color: #7B7B7B;
            font-weight: 700;
            font-size: 1.25rem;
            line-height: 1.6;
        }
        .features-main-grid {
            display: grid;
            grid-template-columns: 1.5fr 2fr;
            gap: 4rem;
            align-items: start;
        }
        .features-text {
           display: grid
;
    grid-template-columns: 2fr 2fr;
    gap: 4rem;
        }
        .feature-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            text-align: right;
            gap: 1rem;
        }
        .feature-icon {
            width: 4rem;
            height: 4rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            flex-shrink: 0;
        }
        .feature-icon.red {
            background: #FF6B6B;
        }
        .feature-icon.yellow {
            background: #FFD93D;
        }
        .feature-icon.light-blue {
            background: #87CEEB;
        }
        .feature-icon.light-brown {
            background: #D2691E;
        }
        .feature-icon.orange {
            background: #FF8C42;
        }
        .feature-icon.brown {
            background: #8B4513;
        }
        .feature-icon.dark-brown {
            background: #654321;
        }
        .feature-icon-content {
            width: 2.5rem;
            height: 2.5rem;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .feature-content {
            flex: 1;
        }
        .feature-content h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #123071;
            margin: 0 0 0.5rem 0;
            line-height: 1.4;
        }
        .feature-content p {
            color: #7B7B7B;
            font-size: 0.875rem;
            margin: 0;
            line-height: 1.4;
        }
        .features-image {
            position: relative;
            overflow: visible;
        }
        .features-image img {
            width: 80%;
            height: auto;
            object-fit: cover;
            border-radius: 0;
            position: relative;
            z-index: 3;
            transform: translate(0px, -150px) scale(1.2);
        }
        .features-blue-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 20px;
            z-index: 1;
        }
        .features-blue-corner {
            position: absolute;
            bottom: -1rem;
            left: -1rem;
            height: 4rem;
            width: 4rem;
            z-index: 2;
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        .features-blue-corner:hover {
            transform: scale(1.1);
            opacity: 1;
        }
        @media (max-width: 1024px) {
            .features-main-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .features-text {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
        @media (max-width: 768px) {
            .features-title {
                font-size: 2rem;
            }
            .features-subtitle {
                font-size: 1.125rem;
            }
        }
        </style>
        
        <div class="features-block">
            <div class="features-container">
                <div class="features-content">
                    <div class="features-header">
                        <h2 class="features-title">' . htmlspecialchars($title) . '</h2>
                        <p class="features-subtitle">' . htmlspecialchars($subtitle) . '</p>
                    </div>
                    <div class="features-main-grid">
                        <div class="features-image">
                            <div class="features-blue-background"></div>
                            <img src="https://i.ibb.co/whRCW50x/image-13.png" alt="منصة بُعد التعليمية">
                        </div>
                        <div class="features-text">';
        
        foreach ($features as $feature) {
            $html .= '
                                <div class="feature-item">
                                    <div class="feature-icon ' . htmlspecialchars($feature['icon_color']) . '">
                                        <div class="feature-icon-content">';
            
            // Add icons that match the first image exactly
            switch ($feature['icon_type']) {
                case 'presentation':
                    $html .= '<span style="font-size: 20px; color: #123071;">📊</span>';
                    break;
                case 'laptop':
                    $html .= '<span style="font-size: 20px; color: #123071;">💻</span>';
                    break;
                case 'graduation':
                    $html .= '<span style="font-size: 20px; color: #123071;">🎓</span>';
                    break;
                case 'documents':
                    $html .= '<span style="font-size: 20px; color: #123071;">📄</span>';
                    break;
                case 'chat':
                    $html .= '<span style="font-size: 20px; color: #123071;">💬</span>';
                    break;
                case 'group':
                    $html .= '<span style="font-size: 20px; color: #123071;">👥</span>';
                    break;
                default:
                    $html .= '<span style="font-size: 20px; color: #123071;">📋</span>';
            }
            
            $html .= '
                                        </div>
                                    </div>
                                    <div class="feature-content">
                                        <h3>' . htmlspecialchars($feature['title']) . '</h3>
                                        <p>' . htmlspecialchars($feature['subtitle']) . '</p>
                                    </div>
                                </div>';
        }
        
        $html .= '
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        
        return $html;
    }
}
