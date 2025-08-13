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
 * Hero Landing Block Edit Form
 *
 * @package   block_hero_landing
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/edit_form.php');

class block_hero_landing_edit_form extends block_edit_form {
    
    protected function specific_definition($mform) {
        global $CFG;
        
        // Section header
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        
        // Block title
        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_hero_landing'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('newherolandingblock', 'block_hero_landing'));
        
        // Hero title
        $mform->addElement('text', 'config_hero_title', get_string('configherotitle', 'block_hero_landing'));
        $mform->setType('config_hero_title', PARAM_TEXT);
        $mform->setDefault('config_hero_title', 'منصة بُعد التعليمية');
        $mform->addHelpButton('config_hero_title', 'configherotitle', 'block_hero_landing');
        
        // Hero subtitle
        $mform->addElement('text', 'config_hero_subtitle', get_string('configherosubtitle', 'block_hero_landing'));
        $mform->setType('config_hero_subtitle', PARAM_TEXT);
        $mform->setDefault('config_hero_subtitle', 'تدريبٌ يُحدِثُ القَفزة');
        $mform->addHelpButton('config_hero_subtitle', 'configherosubtitle', 'block_hero_landing');
        
        // Hero description
        $mform->addElement('textarea', 'config_hero_description', get_string('configherodescription', 'block_hero_landing'));
        $mform->setType('config_hero_description', PARAM_TEXT);
        $mform->setDefault('config_hero_description', 'نقدم برامج تدريبية معتمدة من أفضل الجامعات والمؤسسات العالمية مع شهادات موثقة تعزز مسارك المهني');
        $mform->addHelpButton('config_hero_description', 'configherodescription', 'block_hero_landing');
        
        // CTA text
        $mform->addElement('text', 'config_cta_text', get_string('configctatext', 'block_hero_landing'));
        $mform->setType('config_cta_text', PARAM_TEXT);
        $mform->setDefault('config_cta_text', 'ابدأ رحلتك التعليمية');
        $mform->addHelpButton('config_cta_text', 'configctatext', 'block_hero_landing');
        
        // CTA URL
        $mform->addElement('text', 'config_cta_url', get_string('configctaurl', 'block_hero_landing'));
        $mform->setType('config_cta_url', PARAM_URL);
        $mform->setDefault('config_cta_url', '#');
        $mform->addHelpButton('config_cta_url', 'configctaurl', 'block_hero_landing');
    }
}
