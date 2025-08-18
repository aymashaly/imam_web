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
 * Hero Landing Block
 *
 * @package   block_hero_landing
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_hero_landing extends block_base {
    
    function init() {
        $this->title = get_string('pluginname', 'block_hero_landing');
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
            $this->title = get_string('newherolandingblock', 'block_hero_landing');
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
        $hero_title = isset($this->config->hero_title) ? $this->config->hero_title : 'نحو إتقان المستقبل';
        $hero_subtitle = isset($this->config->hero_subtitle) ? $this->config->hero_subtitle : 'بُعد منصة تعليمية رائدة تختصر لك المسافة نحو التميز تقدم دورات وبرامج تدريبية عالية الجودة في عدة مجالات';
        $hero_description = isset($this->config->hero_description) ? $this->config->hero_description : 'إحدى مبادرات عمادة تقنية المعلومات والتعلم الإلكتروني بجامعة الإمام محمد بن سعود الإسلامية';
        $cta_text = isset($this->config->cta_text) ? $this->config->cta_text : 'ابدأ رحلتك التعليمية';
        $cta_url = isset($this->config->cta_url) ? $this->config->cta_url : '#';
        
        // Generate the hero section HTML
        $this->content->text = $this->generate_hero_section($hero_title, $hero_subtitle, $hero_description, $cta_text, $cta_url);

        return $this->content;
    }

    private function generate_hero_section($title, $subtitle, $description, $cta_text, $cta_url) {
        $html = '
        <style>
        .hero-landing-block {
            font-family: "DIN Next LT Arabic", "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            direction: rtl;
            text-align: right;
        }
        .hero-container {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background-color: rgb(255, 255, 255);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .hero-background {
            position: absolute;
            inset: 0;
            background-image: url("https://i.ibb.co/235t4dYn/image.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(to right bottom, rgba(18, 48, 113, 0.95), rgba(18, 48, 113, 0.95));
        }
        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: rgb(255, 255, 255);
            max-width: 56rem;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .hero-logo {
            position: relative;
            margin: 0 auto 2rem;
            height: 12rem;
            width: 12rem;
            color: rgb(255, 255, 255);
            fill: currentColor;
        }
        .hero-logo svg {
            height: 100%;
            width: 100%;
        }
        .hero-title {
            margin: 0;
            font-size: 60px;
            line-height: 1;
            font-weight: 700;
            margin-bottom: 5rem;
            color: #fff;
        }
        .hero-subtitle {
            margin: 0;
            max-width: 32rem;
            font-size: 24px;
            line-height: 1.75rem;
            margin-bottom: 5rem;
            opacity: 0.9;
        }
        .hero-description {
            margin: 0;
            max-width: 36rem;
            font-size: 14px;
            line-height: 1.25rem;
            opacity: 0.9;
            margin: 0 auto;
        }
        .hero-cta {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: white;
            padding: 1rem 2rem;
            border-radius: 1.25rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-top: 2rem;
        }
        .hero-cta:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }
        @media (min-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            .hero-subtitle {
                font-size: 1.5rem;
                line-height: 2rem;
            }
        }
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.25rem;
            }
            .hero-logo {
                height: 8rem;
                width: 8rem;
            }
        }
        </style>
        
        <div class="hero-landing-block">
            <div class="hero-container">
                <div class="hero-background"></div>
                <div class="hero-overlay"></div>
                <div class="hero-content">
                                         <div class="hero-logo">
                         <svg width="116" height="207" viewBox="0 0 116 207" fill="none" xmlns="http://www.w3.org/2000/svg" style="height: 100%; width: 100%;">
                             <g clip-path="url(#clip0_4902_28461)">
                                 <path d="M98.48 62.11C101.76 63.88 105.1 66.82 107.59 69.66C115.64 78.83 117 90.42 114.94 102.2C112.01 118.91 99.37 128.42 83.04 130.46L2.17999 130.32C1.31999 129.87 0.749988 129.16 0.409988 128.25C0.0199881 87.01 0.359988 45.7 0.229988 4.44001C0.469988 1.80001 2.31999 0.330007 4.89999 0.250007C26.18 0.870007 47.9 -0.539993 69.13 0.250007C82.14 0.730007 90.92 4.06001 99.55 13.92C110.12 25.99 111.11 45.37 101.44 58.25C101.04 58.78 98.2 61.76 98.47 62.11H98.48ZM68.72 15.19C51.48 15.34 34.1 15.24 16.88 15.59C14.96 16.38 14.2 18.29 14.13 20.27V111.87C14.22 113.93 15.39 115.77 17.61 115.83L82.52 115.79C104.48 112.07 108.64 85.6 89.69 74.15C88.29 73.3 85.59 71.66 84.1 72.53C72.45 78.69 61.19 86.85 49.53 92.84C44.64 95.35 39.72 93.68 38.58 88.13V38.73C39.35 34.04 44.39 31.12 48.81 33.06C59.62 39.12 69.9 46.13 80.68 52.23C82.45 53.23 85.17 55.59 86.87 53.96C98.5 42.84 93.74 21 78.3 16.25C74.94 15.21 72.2 15.15 68.72 15.18V15.19ZM53.49 54.5C53.22 54.77 53.22 55.38 53.18 55.75C52.84 59.76 52.81 67.6 53.18 71.59C53.42 74.22 54.64 73.26 56.23 72.46C60.63 70.24 64.87 67.13 69.33 64.95C69.95 64.59 70.44 64 70.18 63.23C69.9 62.4 56.72 55.66 55.05 54.38C54.64 54.12 53.84 54.16 53.5 54.5H53.49Z" fill="white"/>
                                 <path d="M37.38 176.47H52C48.58 169.41 49.71 161.76 55.83 156.69C61.35 152.11 71.33 151.04 77.73 154.21C81.98 156.31 83.07 160.43 79.65 163.98C77.48 166.24 77.39 164.79 75.41 163.72C69.26 160.42 61.02 162.78 61.83 170.83C62.08 173.29 64.64 176.47 67.22 176.47H113.58V186.78H0V176.47H25.16C25.43 168 21.07 162.8 12.34 163.29C11.02 163.36 7.01 164.48 6.23 164.12C4.51 163.33 3.3 159.15 3.75 157.34C5.38 150.81 19.07 152.16 23.77 154C30.59 156.65 37.36 165.01 37.36 172.52V176.48L37.38 176.47Z" fill="white"/>
                                 <path d="M103.51 167.12C103.42 167 104.33 164.43 104.46 164.34C104.72 164.16 109.16 165.79 109.02 162.57C104.73 162.97 100.78 161.42 101.35 156.45C101.98 151.04 111.84 150.59 112.79 156.27C113.07 157.93 113.02 162.92 112.41 164.41C110.95 168.01 106.74 168.41 103.5 167.12H103.51ZM109.02 159.45C108.95 158.65 109.13 157.73 109 156.95C108.66 154.74 105.18 154.77 104.94 157.2C104.7 159.63 107.31 159.54 109.01 159.46L109.02 159.45Z" fill="white"/>
                                 <path d="M108.46 195.02C112.71 194.96 115.61 199.76 113.29 203.4C110.97 207.04 105.16 206.86 103.3 202.69C101.65 199.01 104.55 195.08 108.46 195.02Z" fill="white"/>
                                 <path d="M53.4901 54.5C53.8301 54.16 54.6301 54.13 55.0401 54.38C56.7101 55.66 69.8901 62.4 70.1701 63.23C70.4301 64 69.9501 64.59 69.3201 64.95C64.8601 67.14 60.6201 70.25 56.2201 72.46C54.6301 73.26 53.4101 74.22 53.1701 71.59C52.8001 67.6 52.8301 59.76 53.1701 55.75C53.2001 55.38 53.2101 54.77 53.4801 54.5H53.4901Z" fill="#61EDFC"/>
                             </g>
                             <defs>
                                 <clipPath id="clip0_4902_28461">
                                     <rect width="115.79" height="206.05" fill="white"/>
                                 </clipPath>
                             </defs>
                         </svg>
                     </div>
                    <h1 class="hero-title">' . htmlspecialchars($title) . '</h1>
                    <p class="hero-subtitle">' . htmlspecialchars($subtitle) . '</p>
                    <p class="hero-description">' . htmlspecialchars($description) . '</p>
                </div>
            </div>
        </div>';
        
        return $html;
    }
}
