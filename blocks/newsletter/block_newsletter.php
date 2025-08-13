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
 * Newsletter Block
 *
 * @package   block_newsletter
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_newsletter extends block_base {
    
    function init() {
        $this->title = get_string('pluginname', 'block_newsletter');
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
            $this->title = get_string('newnewsletterblock', 'block_newsletter');
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
        $section_title = isset($this->config->section_title) ? $this->config->section_title : 'انضم إلى قائمة البريد الإلكتروني';
        $section_description = isset($this->config->section_description) ? $this->config->section_description : 'احصل على آخر الأخبار والتحديثات حول الدورات الجديدة والعروض الخاصة';
        $button_text = isset($this->config->button_text) ? $this->config->button_text : 'اشترك الآن';
        $placeholder_text = isset($this->config->placeholder_text) ? $this->config->placeholder_text : 'أدخل بريدك الإلكتروني';
        
        // Generate the newsletter section HTML
        $this->content->text = $this->generate_newsletter_section($section_title, $section_description, $button_text, $placeholder_text);

        return $this->content;
    }

    private function generate_newsletter_section($title, $description, $button_text, $placeholder_text) {
        $html = '
        <style>
        .newsletter-block {
            font-family: "DIN Next LT Arabic", "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            direction: rtl;
            text-align: right;
        }
        .newsletter-container {
            position: relative;
            padding: 6rem 1.5rem;
            overflow: hidden;
        }
        .newsletter-background {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #123071 0%, #0970B6 100%);
        }
        .newsletter-background::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\' fill=\'%2361F1FF\' fill-opacity=\'0.1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E");
            opacity: 0.3;
        }
        .newsletter-content {
            position: relative;
            z-index: 10;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            color: white;
        }
        .newsletter-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        .newsletter-description {
            font-size: 1.25rem;
            line-height: 1.6;
            margin-bottom: 3rem;
            opacity: 0.9;
        }
        .newsletter-form {
            display: flex;
            gap: 1rem;
            max-width: 500px;
            margin: 0 auto;
            flex-wrap: wrap;
            justify-content: center;
        }
        .newsletter-input {
            flex: 1;
            min-width: 250px;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.95);
            color: #123071;
            backdrop-filter: blur(0.5rem);
        }
        .newsletter-input::placeholder {
            color: #7B7B7B;
        }
        .newsletter-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(97, 241, 255, 0.3);
        }
        .newsletter-button {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, #61F1FF 0%, #02A9F5 100%);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(97, 241, 255, 0.3);
        }
        .newsletter-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(97, 241, 255, 0.4);
        }
        .newsletter-decoration {
            position: absolute;
            top: 2rem;
            right: 2rem;
            width: 8rem;
            height: 8rem;
            background: rgba(97, 241, 255, 0.1);
            border-radius: 50%;
            filter: blur(2rem);
        }
        .newsletter-decoration-2 {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            width: 6rem;
            height: 6rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(2rem);
        }
        @media (max-width: 768px) {
            .newsletter-title {
                font-size: 2rem;
            }
            .newsletter-description {
                font-size: 1.125rem;
            }
            .newsletter-form {
                flex-direction: column;
                align-items: center;
            }
            .newsletter-input {
                min-width: 100%;
            }
        }
        </style>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const newsletterForm = document.querySelector(".newsletter-form");
            const emailInput = document.querySelector(".newsletter-input");
            const submitButton = document.querySelector(".newsletter-button");
            
            if (newsletterForm && emailInput && submitButton) {
                newsletterForm.addEventListener("submit", function(e) {
                    e.preventDefault();
                    
                    const email = emailInput.value.trim();
                    if (email) {
                        // Here you can add AJAX call to submit the email
                        alert("شكراً لك! تم الاشتراك بنجاح في النشرة الإخبارية.");
                        emailInput.value = "";
                    } else {
                        alert("يرجى إدخال بريد إلكتروني صحيح.");
                    }
                });
                
                submitButton.addEventListener("click", function(e) {
                    e.preventDefault();
                    newsletterForm.dispatchEvent(new Event("submit"));
                });
            }
        });
        </script>
        
        <div class="newsletter-block">
            <div class="newsletter-container">
                <div class="newsletter-background"></div>
                <div class="newsletter-decoration"></div>
                <div class="newsletter-decoration-2"></div>
                <div class="newsletter-content">
                    <h2 class="newsletter-title">' . htmlspecialchars($title) . '</h2>
                    <p class="newsletter-description">' . htmlspecialchars($description) . '</p>
                    <form class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="' . htmlspecialchars($placeholder_text) . '" required>
                        <button type="submit" class="newsletter-button">' . htmlspecialchars($button_text) . '</button>
                    </form>
                </div>
            </div>
        </div>';
        
        return $html;
    }
}
