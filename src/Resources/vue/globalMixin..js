import Swal from 'sweetalert2';
import jalaliMoment from 'jalali-moment';
import { en } from './translations/en';
import { fa } from './translations/fa';

const translations = {
  en,
  fa,
};

export const globalMixin = {
  created() {
    this.fetchDefaultLanguage();
  },
  methods: {
    /**
     * Fetch the default language from the HTML tag.
     * If there is an error fetching the default language, fallback to English.
     */
    fetchDefaultLanguage() {
      const defaultLanguage = document.documentElement.lang || 'en';
      this.setDefaultLanguage(defaultLanguage);
    },

    convertDate(gregorianDate,format){
      const jalaliDate = jalaliMoment(gregorianDate).format(format);
      return jalaliDate;
    },

    /**
     * Set the default language for the application.
     * @param {string} defaultLanguage - The default language code.
     */
    setDefaultLanguage(defaultLanguage) {
      this.defaultLanguage = defaultLanguage;
    },

    /**
     * Print the site's origin (http://example.com).
     */
    printSitePath() {
      const origin = window.location.origin;
    },
    // Method to get the CSRF token from the meta tag
    getToken() {
      // Find the meta tag with name "csrf-token"
      const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
      
      // Check if the meta tag exists
      if (csrfTokenMeta) {
        // Return the content of the "csrf-token" meta tag
        return csrfTokenMeta.content;
      }
      
      // If the meta tag doesn't exist, return null or any specific value
      // commonly used to indicate this situation
      return null;
    },
    /**
     * Get the APP_URL from the environment variables.
     * @returns {string} The APP_URL value.
     */
    getAppUrl() {
      const baseElement = document.querySelector('base');
      return baseElement.href;
    },

    /**
     * Show a Swal alert with custom settings.
     * @param {string} titleKey - The translation key for the title of the alert.
     * @param {string} textKey - The translation key for the content of the alert.
     * @param {string} icon - The icon to display in the alert (default: 'error').
     * @param {string} confirmButtonTextKey - The translation key for the confirmation button (default: 'Ok').
     */
    showAlert(titleKey, textKey, icon = 'error', confirmButtonTextKey) {
      const language = translations[this.defaultLanguage] || en;
      const translatedTitle = language[titleKey] || en[titleKey];
      const translatedText = language[textKey] || en[textKey];
      const translatedConfirmButtonText = confirmButtonTextKey
        ? language[confirmButtonTextKey]
        : en[confirmButtonTextKey];

      Swal.fire({
        icon,
        title: translatedTitle,
        text: translatedText,
        confirmButtonText: translatedConfirmButtonText,
      });
    },
    /**
     * Translate the given text based on the default language.
     * If the translation for the given key is not found, fallback to English.
     * @param {string} textKey - The translation key for the text.
     * @returns {string} The translated text.
     */
     translateText(textKey) {
        // Get the translations for the default language or fallback to English
        const language = translations[this.defaultLanguage] || en;
        
        // Return the translated text if available, otherwise return the English version
        return language[textKey] || en[textKey];
    },
    /**
     * Check and show error message based on HTTP status codes.
     * @param {object} error - The error response object from the server.
     */
     checkError(error) {
      const s = "errors";
      
      let title = this.translateText('notFound');
      let text = this.translateText('errorExecutingReque5st');
      switch (error.response.status) {
        case 400:
          title = this.translateText('notFound');
          text = this.translateText('invalidRequest');
          break;
        case 401:
          title = this.translateText('notFound');
          text = this.translateText('userError');
          break;
        case 403:
          title = this.translateText('notFound');
          text = this.translateText('accessError');
          break;
        case 404:
          title = this.translateText('notFound');
          text = this.translateText('notFoundError');
          break;
        case 408:
          title = this.translateText('notFound');
          text = this.translateText('requestTimeoutError');
          break;
        case 422:
          title = this.translateText('notFound');
          text = '';
          if (error.response.data.errors && typeof error.response.data.errors === 'object') {
            for (let key in error.response.data.errors) {
              if (error.response.data.errors.hasOwnProperty(key)) {  
                error.response.data.errors[key][0] !== undefined
                ? text = error.response.data.errors[key][0]+'\n'
                : text += `\n${error.response.data.errors[key][0]}`;                          
              }
              break;
            }
          }
          if(typeof error.response.data.errors === 'string')
          {
            text = this.translateText(error.response.data.errors);
            if(typeof text === 'undefined')
            {
              text = error.response.data.errors
            }
          }                  
          break;
        case 500:
          title = this.translateText('notFound');
          text = this.translateText('systemError');
          break;
        case 503:
          title = this.translateText('notFound');
          text = this.translateText('serviceUnavailable');
          break;
        default:
          break;
      }
    
      Swal.fire({
        icon: 'error',
        title,
        text,
        confirmButtonText: 'Ok',
      });
    },
  },
};
