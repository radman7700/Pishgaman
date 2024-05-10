import '../bootstrap';
import { createApp } from 'vue';
import { globalMixin } from '../globalMixin.';
import App from './component/messages.vue'; 
import Vue3PersianDatetimePicker from 'vue3-persian-datetime-picker'


// Create the Vue app and add the globalMixin to all components
const app = createApp(App);

app.component('DatePicker', Vue3PersianDatetimePicker)

// Add the globalMixin to the app
app.mixin(globalMixin);

// Mount the app to the element with id "LoginApp"
app.mount("#messagesApp");
