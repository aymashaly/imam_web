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
 * Platforms Block
 *
 * @package   block_platforms
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_platforms extends block_base {
    
    function init() {
        $this->title = get_string('pluginname', 'block_platforms');
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
            $this->title = get_string('newplatformsblock', 'block_platforms');
        }
    }

    function instance_allow_config() {
        return true;
    }

    function instance_allow_multiple() {
        return true;
    }

    function config_save($data) {
        // Validate and clean the data before saving
        if (isset($data->platforms_count)) {
            $data->platforms_count = intval($data->platforms_count);
            if ($data->platforms_count < 1) $data->platforms_count = 1;
            if ($data->platforms_count > 10) $data->platforms_count = 10;
        }
        
        // Clean platform data
        for ($i = 0; $i < 10; $i++) {
            if (isset($data->{'platform_' . $i . '_name'})) {
                $data->{'platform_' . $i . '_name'} = trim($data->{'platform_' . $i . '_name'});
            }
            if (isset($data->{'platform_' . $i . '_image_url'})) {
                $data->{'platform_' . $i . '_image_url'} = trim($data->{'platform_' . $i . '_image_url'});
            }
            if (isset($data->{'platform_' . $i . '_svg_path'})) {
                $data->{'platform_' . $i . '_svg_path'} = trim($data->{'platform_' . $i . '_svg_path'});
            }
            if (isset($data->{'platform_' . $i . '_alt_text'})) {
                $data->{'platform_' . $i . '_alt_text'} = trim($data->{'platform_' . $i . '_alt_text'});
            }
        }
        
        return parent::config_save($data);
    }

    function get_content() {
        global $CFG, $PAGE;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->footer = '';
        
        // Get configuration
        $section_title = isset($this->config->section_title) ? $this->config->section_title : 'المنصات المحلية والعالمية';
        
        // Get platforms from configuration
        $platforms = $this->get_platforms_from_config();
        
        // Generate the platforms section HTML
        $this->content->text = $this->generate_platforms_section($section_title, $platforms);

        return $this->content;
    }

    private function get_platforms_from_config() {
        $platforms = array();
        
        if (isset($this->config->platforms_count)) {
            $count = intval($this->config->platforms_count);
            
            for ($i = 0; $i < $count; $i++) {
                $name = isset($this->config->{'platform_' . $i . '_name'}) ? $this->config->{'platform_' . $i . '_name'} : '';
                $type = isset($this->config->{'platform_' . $i . '_type'}) ? $this->config->{'platform_' . $i . '_type'} : 'image';
                $image_url = isset($this->config->{'platform_' . $i . '_image_url'}) ? $this->config->{'platform_' . $i . '_image_url'} : '';
                $svg_path = isset($this->config->{'platform_' . $i . '_svg_path'}) ? $this->config->{'platform_' . $i . '_svg_path'} : '';
                $alt_text = isset($this->config->{'platform_' . $i . '_alt_text'}) ? $this->config->{'platform_' . $i . '_alt_text'} : $name;
                
                if (!empty($name)) {
                    if ($type === 'svg' && !empty($svg_path)) {
                        $platforms[] = array(
                            'name' => $name,
                            'is_svg' => true,
                            'svg_path' => $svg_path,
                            'alt_text' => $alt_text
                        );
                    } elseif ($type === 'image' && !empty($image_url)) {
                        $platforms[] = array(
                            'name' => $name,
                            'image_url' => $image_url,
                            'alt_text' => $alt_text
                        );
                    }
                }
            }
        }
        
        // If no platforms configured, use defaults
        if (empty($platforms)) {
            $platforms = $this->get_default_platforms();
        }
        
        return $platforms;
    }

    private function get_default_platforms() {
        return array(
            array(
                'name' => 'OERx',
                'image_url' => 'https://api.builder.io/api/v1/image/assets/TEMP/f8485c990cad47a3720619a46d20a6c2836e7637?width=280',
                'alt_text' => 'OERx'
            ),
            array(
                'name' => 'OpenLearn',
                'image_url' => '',
                'alt_text' => 'OpenLearn',
                'is_svg' => true,
                'svg_path' => 'M0 0.408081H22.4582V7.39379H8.29338V15.2524H22.4582V22.0457H8.34491V34.3679H0.00343908V0.408081H0Z'
            ),
            array(
                'name' => 'MicroX',
                'image_url' => 'https://api.builder.io/api/v1/image/assets/TEMP/5402ddb4f3e96472ed80b2695321aae2c1cb35a2?width=312',
                'alt_text' => 'MicroX'
            ),
            array(
                'name' => 'IBM',
                'image_url' => 'https://api.builder.io/api/v1/image/assets/TEMP/3ab6edee3645bbdee13ba9837ad464c51a06b3ec?width=226',
                'alt_text' => 'IBM'
            )
        );
    }

    private function generate_platforms_section($title, $platforms) {
        $html = '
        <style>
        .platforms-block {
            font-family: "DIN Next LT Arabic", "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            direction: rtl;
            text-align: right;
        }
        .platforms-container {
            color: rgb(2, 8, 23);
            direction: rtl;
            background-color: rgb(255, 255, 255);
            padding-top: 5rem;
            padding-bottom: 5rem;
            box-sizing: border-box;
        }
        .platforms-content {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 2rem;
            padding-left: 2rem;
            box-sizing: border-box;
            @media (min-width: 1400px) {
                max-width: 1400px;
            }
        }
        .platforms-header {
            margin-bottom: 4rem;
            text-align: center;
            box-sizing: border-box;
        }
        .platforms-title {
            margin: 0px;
            font-size: 48px;
            line-height: 1;
            font-weight: 700;
            color: rgb(16, 82, 162);
            box-sizing: border-box;
        }
        .platforms-grid {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 4rem;
            box-sizing: border-box;
            @media (min-width: 768px) {
                gap: 6rem;
            }
        }
        .platform-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }
        .platform-item:hover {
            transform: translateY(-4px);
        }
        .platform-image {
            height: 4rem;
            object-fit: contain;
            opacity: 0.6;
            transition-property: opacity;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
            display: block;
            vertical-align: middle;
            max-width: 100%;
            box-sizing: border-box;
        }
        .platform-image:hover {
            opacity: 1;
        }
        .platform-svg {
            height: 2rem;
            fill: currentcolor;
            color: rgb(75, 85, 99);
            display: block;
            vertical-align: middle;
            box-sizing: border-box;
        }
        .platform-name {
            font-size: 0.875rem;
            color: rgb(75, 85, 99);
            text-align: center;
            margin: 0;
            opacity: 0.8;
        }
        @media (max-width: 768px) {
            .platforms-title {
                font-size: 2.5rem;
            }
            .platforms-grid {
                gap: 3rem;
            }
            .platform-image {
                height: 3rem;
            }
            .platform-svg {
                height: 1.5rem;
            }
        }
        </style>
        
        <div class="platforms-block">
            <div class="platforms-container">
                <div class="platforms-content">
                    <div class="platforms-header">
                        <h2 class="platforms-title">' . htmlspecialchars($title) . '</h2>
                    </div>
                    <div class="platforms-grid">';
        
        foreach ($platforms as $platform) {
            $html .= '
                        <div class="platform-item">
                            <div class="platform-logo">';
            
            if (isset($platform['is_svg']) && $platform['is_svg']) {
                // Render SVG logo
                $html .= '<svg viewBox="0 0 182 35" class="platform-svg">
                                <path d="' . htmlspecialchars($platform['svg_path']) . '" class="path-0"></path>
                            </svg>';
            } else {
                // Render image logo
                $html .= '<img src="' . htmlspecialchars($platform['image_url']) . '" alt="' . htmlspecialchars($platform['alt_text']) . '" class="platform-image" />';
            }
            
            $html .= '</div>
                            <div class="platform-name">' . htmlspecialchars($platform['name']) . '</div>
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
