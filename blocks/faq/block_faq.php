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
 * FAQ Block
 *
 * @package   block_faq
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_faq extends block_base {
    
    function init() {
        $this->title = get_string('pluginname', 'block_faq');
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
            $this->title = get_string('newfaqblock', 'block_faq');
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
        $section_title = isset($this->config->section_title) ? $this->config->section_title : 'الأسئلة الشائعة';
        
        // FAQ data
        $faqs = isset($this->config->faqs) ? $this->config->faqs : $this->get_default_faqs();
        
        // Generate the FAQ section HTML
        $this->content->text = $this->generate_faq_section($section_title, $faqs);

        return $this->content;
    }

    private function get_default_faqs() {
        return array(
            array(
                'question' => 'كيف يمكنني التسجيل في الدورات التدريبية؟',
                'answer' => 'يمكنك التسجيل في الدورات التدريبية من خلال إنشاء حساب على منصتنا واختيار الدورة المناسبة لك، ثم إتمام عملية الدفع والبدء في التعلم فوراً.'
            ),
            array(
                'question' => 'هل الشهادات معتمدة رسمياً؟',
                'answer' => 'نعم، جميع الشهادات التي نقدمها معتمدة من أفضل الجامعات والمؤسسات العالمية، ويمكن استخدامها في السيرة الذاتية والترقيات المهنية.'
            ),
            array(
                'question' => 'ما هي مدة الدورات التدريبية؟',
                'answer' => 'تختلف مدة الدورات حسب نوعها ومستواها، وتتراوح من عدة ساعات إلى عدة أسابيع. يمكنك التعلم بالوتيرة التي تناسبك.'
            ),
            array(
                'question' => 'هل يمكنني الوصول للمحتوى بعد انتهاء الدورة؟',
                'answer' => 'نعم، يمكنك الوصول للمحتوى التعليمي لمدة سنة كاملة بعد انتهاء الدورة، مما يتيح لك المراجعة والاستفادة من المحتوى.'
            ),
            array(
                'question' => 'كيف يمكنني التواصل مع المدربين؟',
                'answer' => 'يمكنك التواصل مع المدربين من خلال منصة التعلم التفاعلية، حيث نوفر لك قنوات اتصال مباشرة مع المدربين والخبراء.'
            ),
            array(
                'question' => 'هل تقدمون دورات مجانية؟',
                'answer' => 'نعم، نقدم مجموعة من الدورات المجانية كعينة من محتوانا التعليمي، كما نقدم خصومات للطلاب والمؤسسات التعليمية.'
            )
        );
    }

    private function generate_faq_section($title, $faqs) {
        $html = '
        <style>
        .faq-block {
            font-family: "DIN Next LT Arabic", "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            direction: rtl;
            text-align: right;
        }
        .faq-container {
            background: white;
            padding: 5rem 1rem;
        }
        .faq-content {
            max-width: 80rem;
            margin: 0 auto;
        }
        .faq-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        .faq-title {
            font-size: 3rem;
            font-weight: 700;
            color: #123071;
        }
        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .faq-item {
            background: #f8fafc;
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .faq-item:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .faq-question {
            background: white;
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .faq-question:hover {
            background: #f1f5f9;
        }
        .faq-question-text {
            font-size: 1.125rem;
            font-weight: 600;
            color: #123071;
            flex: 1;
        }
        .faq-toggle {
            width: 1.5rem;
            height: 1.5rem;
            position: relative;
            transition: transform 0.3s ease;
        }
        .faq-toggle::before,
        .faq-toggle::after {
            content: "";
            position: absolute;
            background: #61F1FF;
            transition: all 0.3s ease;
        }
        .faq-toggle::before {
            width: 100%;
            height: 2px;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
        }
        .faq-toggle::after {
            width: 2px;
            height: 100%;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        .faq-item.active .faq-toggle::after {
            transform: translateX(-50%) rotate(90deg);
        }
        .faq-answer {
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #f8fafc;
        }
        .faq-item.active .faq-answer {
            padding: 1.5rem;
            max-height: 200px;
        }
        .faq-answer-text {
            color: #7B7B7B;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
        }
        @media (max-width: 768px) {
            .faq-title {
                font-size: 2rem;
            }
            .faq-question-text {
                font-size: 1rem;
            }
        }
        </style>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const faqItems = document.querySelectorAll(".faq-item");
            
            faqItems.forEach(function(item) {
                const question = item.querySelector(".faq-question");
                
                question.addEventListener("click", function() {
                    const isActive = item.classList.contains("active");
                    
                    // Close all other items
                    faqItems.forEach(function(otherItem) {
                        otherItem.classList.remove("active");
                    });
                    
                    // Toggle current item
                    if (!isActive) {
                        item.classList.add("active");
                    }
                });
            });
        });
        </script>
        
        <div class="faq-block">
            <div class="faq-container">
                <div class="faq-content">
                    <div class="faq-header">
                        <h2 class="faq-title">' . htmlspecialchars($title) . '</h2>
                    </div>
                    <div class="faq-list">';
        
        foreach ($faqs as $faq) {
            $html .= '
                        <div class="faq-item">
                            <div class="faq-question">
                                <div class="faq-question-text">' . htmlspecialchars($faq['question']) . '</div>
                                <div class="faq-toggle"></div>
                            </div>
                            <div class="faq-answer">
                                <p class="faq-answer-text">' . htmlspecialchars($faq['answer']) . '</p>
                            </div>
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
