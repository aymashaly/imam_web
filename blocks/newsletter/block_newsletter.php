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
        $section_title = isset($this->config->section_title) ? $this->config->section_title : ' وعروض مميزة أخرى حول بعد اشترك للحصول على معلومات وأحدث الأخبار '  ;
        $section_subtitle = isset($this->config->section_subtitle) ? $this->config->section_subtitle : 'وعروض مميزة أخرى حول بعد';
        $button_text = isset($this->config->button_text) ? $this->config->button_text : 'Subscribe';
        $placeholder_text = isset($this->config->placeholder_text) ? $this->config->placeholder_text : 'Your email';
        
        // Generate the newsletter section HTML
        $this->content->text = $this->generate_newsletter_section($section_title, $section_subtitle, $button_text, $placeholder_text);

        return $this->content;
    }

    private function generate_newsletter_section($title, $subtitle, $button_text, $placeholder_text) {
        $html = '
        <style>
        .newsletter-block {
            font-family: "DIN Next LT Arabic", "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            direction: rtl;
            text-align: center;
            position: relative;
        }
        
        .newsletter-container {
            height: 600px;
    position: relative;
    padding: 4rem 2rem;
    border-radius: 20px;
    overflow: hidden;
            
        }
        
        .newsletter-background {
            position: absolute;
            inset: 0;
            background-image: url("https://i.ibb.co/hxVN1kpX/image-14.png");
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 20px;
        }
        
        .newsletter-overlay {
            position: absolute;
            inset: 0;
            opacity: 0;
            background: linear-gradient(135deg, rgba(18, 48, 113, 0.9) 0%, rgba(9, 112, 182, 0.8) 100%);
            border-radius: 20px;
        }
        
        .newsletter-content {
            position: relative;
            z-index: 10;
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
            color: white;
        }
        
        .newsletter-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5rem;
            line-height: 1.2;
            color: #767777;
        }
        
        .newsletter-subtitle {
            font-size: 1.25rem;
            line-height: 1.6;
            margin-bottom: 3rem;
            color: #e9ecef;
            font-weight: 400;
        }
        
        .newsletter-form {
            display: flex;
            gap: 1rem;
            max-width: 500px;
            margin: 0 auto;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .newsletter-input-group {
            position: relative;
            flex: 1;
            min-width: 300px;
        }
        
        .newsletter-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.95);
            color: #123071;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .newsletter-input::placeholder {
            color: #6c757d;
            font-weight: 400;
        }
        
        .newsletter-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(97, 241, 255, 0.3);
            background: rgba(255, 255, 255, 1);
        }
        
        .newsletter-input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.125rem;
        }
        
        .newsletter-button {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #61F1FF 0%, #02A9F5 100%);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(97, 241, 255, 0.3);
            white-space: nowrap;
            min-width: 140px;
        }
        
        .newsletter-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(97, 241, 255, 0.4);
            background: linear-gradient(135deg, #02A9F5 0%, #61F1FF 100%);
        }
        
        @media (max-width: 768px) {
            .newsletter-container {
                padding: 3rem 1.5rem;
                margin: 1rem;
            }
            
            .newsletter-title {
                font-size: 2rem;
            }
            
            .newsletter-subtitle {
                font-size: 1.125rem;
                margin-bottom: 2rem;
            }
            
            .newsletter-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .newsletter-input-group {
                min-width: 100%;
            }
            
            .newsletter-button {
                width: 100%;
            }
        }
        
        @media (max-width: 480px) {
            .newsletter-title {
                font-size: 1.75rem;
            }
            
            .newsletter-subtitle {
                font-size: 1rem;
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
                    handleNewsletterSubmit();
                });
                
                submitButton.addEventListener("click", function(e) {
                    e.preventDefault();
                    handleNewsletterSubmit();
                });
                
                function handleNewsletterSubmit() {
                    const email = emailInput.value.trim();
                    if (email && isValidEmail(email)) {
                        // Show success message
                        showMessage("شكراً لك! تم الاشتراك بنجاح في النشرة الإخبارية.", "success");
                        emailInput.value = "";
                    } else {
                        showMessage("يرجى إدخال بريد إلكتروني صحيح.", "error");
                    }
                }
                
                function isValidEmail(email) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);
                }
                
                function showMessage(message, type) {
                    // Remove existing messages
                    const existingMessage = document.querySelector(".newsletter-message");
                    if (existingMessage) {
                        existingMessage.remove();
                    }
                    
                    // Create new message
                    const messageDiv = document.createElement("div");
                    messageDiv.className = "newsletter-message";
                    messageDiv.style.cssText = `
                        position: fixed;
                        top: 20px;
                        left: 50%;
                        transform: translateX(-50%);
                        padding: 1rem 2rem;
                        border-radius: 8px;
                        color: white;
                        font-weight: 600;
                        z-index: 10000;
                        background: ${type === "success" ? "#28a745" : "#dc3545"};
                        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                    `;
                    messageDiv.textContent = message;
                    
                    document.body.appendChild(messageDiv);
                    
                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        if (messageDiv.parentNode) {
                            messageDiv.remove();
                        }
                    }, 3000);
                }
            }
        });
        </script>
        
        <div class="newsletter-block">
            <div class="newsletter-container">
                <div class="newsletter-background"></div>
                <div class="newsletter-overlay"></div>
                
                <div class="newsletter-content">
                    <h2 class="newsletter-title">' . htmlspecialchars($title) . '</h2>
                    <form class="newsletter-form">
                        <div class="newsletter-input-group">
                            <div class="newsletter-input-icon">📧</div>
                            <input type="email" class="newsletter-input" placeholder="' . htmlspecialchars($placeholder_text) . '" required>
                        </div>
                        <button type="submit" class="newsletter-button">' . htmlspecialchars($button_text) . '</button>
                    </form>
                </div>
            </div>
        </div>';
        
        return $html;
    }
}
