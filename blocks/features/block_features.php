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
            array(
                'title' => 'دورات معتمدة وشهادات موثقة',
                'description' => 'نقدم برامج تدريبية معتمدة من أفضل الجامعات والمؤسسات العالمية مع شهادات موثقة تعزز مسارك المهني',
                'color' => 'cyan'
            ),
            array(
                'title' => 'مدربون خبراء ومتخصصون',
                'description' => 'فريق من أكفأ المدربين والخبراء في مختلف المجالات يضمن لك تجربة تعليمية متميزة وفعالة',
                'color' => 'blue'
            ),
            array(
                'title' => 'مرونة في التعلم والمواعيد',
                'description' => 'تعلم في أي وقت ومن أي مكان بفضل منصتنا التفاعلية التي تتيح لك المرونة الكاملة في التعلم',
                'color' => 'cyan'
            ),
            array(
                'title' => 'دعم مستمر ومتابعة شخصية',
                'description' => 'نقدم دعماً فنياً وأكاديمياً مستمراً مع متابعة شخصية لضمان تحقيق أهدافك التعليمية بكفاءة',
                'color' => 'blue'
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
        .features-container {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.5) 0%, #ffffff 50%, rgba(243, 244, 246, 0.3) 100%);
            padding: 6rem 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .features-background-1 {
            position: absolute;
            top: 25%;
            left: 0;
            width: 18rem;
            height: 18rem;
            background: rgba(97, 241, 255, 0.05);
            border-radius: 50%;
            filter: blur(3rem);
        }
        .features-background-2 {
            position: absolute;
            bottom: 25%;
            right: 0;
            width: 24rem;
            height: 24rem;
            background: rgba(18, 48, 113, 0.05);
            border-radius: 50%;
            filter: blur(3rem);
        }
        .features-content {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
        }
        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        .features-text {
            order: 2;
        }
        .features-title {
            font-size: 3rem;
            font-weight: 700;
            color: #123071;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        .features-subtitle {
            color: #7B7B7B;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 3rem;
            line-height: 1.6;
        }
        .features-list {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            text-align: right;
        }
        .feature-dot {
            flex-shrink: 0;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            margin-top: 0.75rem;
        }
        .feature-dot.cyan {
            background: #61F1FF;
        }
        .feature-dot.blue {
            background: #123071;
        }
        .feature-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #123071;
            margin-bottom: 0.75rem;
        }
        .feature-content p {
            color: #7B7B7B;
            font-size: 1.125rem;
            line-height: 1.6;
        }
        .features-image {
            order: 1;
            position: relative;
        }
        .features-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 1.5rem;
        }
        .features-image-decoration-1 {
            position: absolute;
            top: -2rem;
            right: -2rem;
            width: 6rem;
            height: 6rem;
            background: linear-gradient(135deg, #61F1FF 0%, #02A9F5 100%);
            border-radius: 50%;
            opacity: 0.2;
            filter: blur(2rem);
        }
        .features-image-decoration-2 {
            position: absolute;
            bottom: -2rem;
            left: -2rem;
            width: 8rem;
            height: 8rem;
            background: linear-gradient(135deg, #123071 0%, #61F1FF 100%);
            border-radius: 50%;
            opacity: 0.15;
            filter: blur(2rem);
        }
        .features-stats {
            position: absolute;
            top: 2rem;
            right: 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(0.5rem);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .features-stats-content {
            text-align: center;
        }
        .features-stats-number {
            font-size: 1.875rem;
            font-weight: 700;
            color: #123071;
            margin-bottom: 0.5rem;
        }
        .features-stats-label {
            font-size: 0.875rem;
            color: #7B7B7B;
        }
        .features-stats-2 {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(0.5rem);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .features-stats-2 .features-stats-number {
            color: #61F1FF;
        }
        @media (max-width: 1024px) {
            .features-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .features-text {
                order: 1;
            }
            .features-image {
                order: 2;
            }
            .features-title {
                font-size: 2.5rem;
            }
        }
        @media (max-width: 768px) {
            .features-title {
                font-size: 2rem;
            }
            .features-subtitle {
                font-size: 1.125rem;
            }
            .feature-content h3 {
                font-size: 1.125rem;
            }
            .feature-content p {
                font-size: 1rem;
            }
        }
        </style>
        
        <div class="features-block">
            <div class="features-container">
                <div class="features-background-1"></div>
                <div class="features-background-2"></div>
                <div class="features-content">
                    <div class="features-grid">
                        <div class="features-text">
                            <h2 class="features-title">' . htmlspecialchars($title) . '</h2>
                            <p class="features-subtitle">' . htmlspecialchars($subtitle) . '</p>
                            <div class="features-list">';
        
        foreach ($features as $feature) {
            $html .= '
                                <div class="feature-item">
                                    <div class="feature-dot ' . htmlspecialchars($feature['color']) . '"></div>
                                    <div class="feature-content">
                                        <h3>' . htmlspecialchars($feature['title']) . '</h3>
                                        <p>' . htmlspecialchars($feature['description']) . '</p>
                                    </div>
                                </div>';
        }
        
        $html .= '
                            </div>
                        </div>
                        <div class="features-image">
                            <img src="data:image/svg+xml,%3Csvg width=\'400\' height=\'300\' viewBox=\'0 0 400 300\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'400\' height=\'300\' fill=\'%23f8fafc\'/%3E%3Ctext x=\'200\' y=\'150\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'16\' fill=\'%237B7B7B\'%3Eمنصة بُعد التعليمية%3C/text%3E%3C/svg%3E" alt="منصة بُعد التعليمية">
                            <div class="features-image-decoration-1"></div>
                            <div class="features-image-decoration-2"></div>
                            <div class="features-stats">
                                <div class="features-stats-content">
                                    <div class="features-stats-number">+15K</div>
                                    <div class="features-stats-label">متدرب نشط</div>
                                </div>
                            </div>
                            <div class="features-stats-2">
                                <div class="features-stats-content">
                                    <div class="features-stats-number">+200</div>
                                    <div class="features-stats-label">دورة تدريبية</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        
        return $html;
    }
}
