import '../bootstrap';
import { createApp } from 'vue';
import { globalMixin } from '../globalMixin.';
import App from './component/Login.vue'; 

// Create the Vue app and add the globalMixin to all components
const app = createApp(App);

// Add the globalMixin to the app
app.mixin(globalMixin);

// Mount the app to the element with id "LoginApp"
app.mount("#LoginApp");
