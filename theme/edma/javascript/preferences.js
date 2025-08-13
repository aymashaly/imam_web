/**
 * User Preferences Handler for EDMA Theme
 * 
 * This file demonstrates how to use the new core_user/repository module
 * to handle user preferences instead of the deprecated user_preference_allow_ajax_update function.
 * 
 * @package   theme_edma
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Example of how to use the new repository module for user preferences
// This is for reference and can be used if the theme needs to handle preferences via JavaScript

/**
 * Set a user preference using the new repository module
 * 
 * @param {string} name The preference name
 * @param {string} value The preference value
 * @returns {Promise}
 */
function setUserPreference(name, value) {
    // This would require the core_user/repository module to be loaded
    // Example usage:
    // import {setUserPreference} from 'core_user/repository';
    // return setUserPreference(name, value);
    
    console.log('To use this function, import the core_user/repository module');
    console.log('Example: import {setUserPreference} from \'core_user/repository\';');
}

/**
 * Get a user preference using the new repository module
 * 
 * @param {string} name The preference name
 * @returns {Promise}
 */
function getUserPreference(name) {
    // This would require the core_user/repository module to be loaded
    // Example usage:
    // import {getUserPreference} from 'core_user/repository';
    // return getUserPreference(name);
    
    console.log('To use this function, import the core_user/repository module');
    console.log('Example: import {getUserPreference} from \'core_user/repository\';');
}

/**
 * Example of how to handle drawer preferences
 * 
 * @param {string} drawerName The drawer name (e.g., 'drawer-open-nav', 'drawer-open-index')
 * @param {boolean} isOpen Whether the drawer should be open
 */
function setDrawerPreference(drawerName, isOpen) {
    const value = isOpen ? 'true' : 'false';
    setUserPreference(drawerName, value);
}

// Export functions if using modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        setUserPreference,
        getUserPreference,
        setDrawerPreference
    };
}
