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
 * Platforms Block Edit Form
 *
 * @package   block_platforms
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/edit_form.php');

class block_platforms_edit_form extends block_edit_form {
    
    protected function specific_definition($mform) {
        global $CFG;
        
        // Section header
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        
        // Block title
        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_platforms'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('newplatformsblock', 'block_platforms'));
        
        // Section title
        $mform->addElement('text', 'config_section_title', get_string('configsectiontitle', 'block_platforms'));
        $mform->setType('config_section_title', PARAM_TEXT);
        $mform->setDefault('config_section_title', 'المنصات المحلية والعالمية');
        $mform->addHelpButton('config_section_title', 'configsectiontitle', 'block_platforms');
        
        // Platforms configuration
        $mform->addElement('header', 'platformsheader', 'إعدادات المنصات');
        
        // Number of platforms
        $mform->addElement('select', 'config_platforms_count', 'عدد المنصات', array(
            1 => '1',
            2 => '2', 
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',
            9 => '9',
            10 => '10'
        ));
        $mform->setDefault('config_platforms_count', 4);
        $mform->addHelpButton('config_platforms_count', 'configplatformscount', 'block_platforms');
        
        // Dynamic platforms fields
        for ($i = 0; $i < 10; $i++) {
            $mform->addElement('header', 'platform' . $i . 'header', 'المنصة ' . ($i + 1));
            
            // Platform name
            $mform->addElement('text', 'config_platform_' . $i . '_name', 'اسم المنصة');
            $mform->setType('config_platform_' . $i . '_name', PARAM_TEXT);
            $mform->setDefault('config_platform_' . $i . '_name', '');
            
            // Platform type (image or SVG)
            $mform->addElement('select', 'config_platform_' . $i . '_type', 'نوع المنصة', array(
                'image' => 'صورة',
                'svg' => 'SVG'
            ));
            $mform->setDefault('config_platform_' . $i . '_type', 'image');
            
            // Platform image URL
            $mform->addElement('text', 'config_platform_' . $i . '_image_url', 'رابط الصورة');
            $mform->setType('config_platform_' . $i . '_image_url', PARAM_URL);
            $mform->setDefault('config_platform_' . $i . '_image_url', '');
            $mform->addHelpButton('config_platform_' . $i . '_image_url', 'configplatformimageurl', 'block_platforms');
            
            // Platform SVG path
            $mform->addElement('textarea', 'config_platform_' . $i . '_svg_path', 'مسار SVG');
            $mform->setType('config_platform_' . $i . '_svg_path', PARAM_RAW);
            $mform->setDefault('config_platform_' . $i . '_svg_path', '');
            $mform->addHelpButton('config_platform_' . $i . '_svg_path', 'configplatformsvgpath', 'block_platforms');
            
            // Platform alt text
            $mform->addElement('text', 'config_platform_' . $i . '_alt_text', 'النص البديل');
            $mform->setType('config_platform_' . $i . '_alt_text', PARAM_TEXT);
            $mform->setDefault('config_platform_' . $i . '_alt_text', '');
            
            // Hide fields by default (will be shown via JavaScript)
            $mform->hideIf('config_platform_' . $i . '_name', 'config_platforms_count', 'neq', $i + 1);
            $mform->hideIf('config_platform_' . $i . '_type', 'config_platforms_count', 'neq', $i + 1);
            $mform->hideIf('config_platform_' . $i . '_image_url', 'config_platforms_count', 'neq', $i + 1);
            $mform->hideIf('config_platform_' . $i . '_svg_path', 'config_platforms_count', 'neq', $i + 1);
            $mform->hideIf('config_platform_' . $i . '_alt_text', 'config_platforms_count', 'neq', $i + 1);
            $mform->hideIf('platform' . $i . 'header', 'config_platforms_count', 'neq', $i + 1);
        }
        
        // Add JavaScript to show/hide fields based on count
        $mform->addElement('html', '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const countSelect = document.getElementById("id_config_platforms_count");
            const platformFields = document.querySelectorAll("[id^=\'id_config_platform_\']");
            const platformHeaders = document.querySelectorAll("[id^=\'id_platform\']");
            
            function updatePlatformFields() {
                const count = parseInt(countSelect.value);
                
                platformFields.forEach(function(field, index) {
                    const platformIndex = Math.floor(index / 5); // 5 fields per platform
                    if (platformIndex < count) {
                        field.closest(".fitem").style.display = "block";
                    } else {
                        field.closest(".fitem").style.display = "none";
                    }
                });
                
                platformHeaders.forEach(function(header, index) {
                    if (index < count) {
                        header.closest(".fitem").style.display = "block";
                    } else {
                        header.closest(".fitem").style.display = "none";
                    }
                });
            }
            
            countSelect.addEventListener("change", updatePlatformFields);
            updatePlatformFields();
        });
        </script>
        ');
    }
}
