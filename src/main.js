/**
 * src/main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App
 */

// Plugins
// This imports the function that registers Vuetify and potentially other global plugins.
import { registerPlugins } from "@/plugins";

// Router
// This imports your router instance defined in src/router/index.ts
import router from "@/router";

// Components
// This imports your root Vue component.
import App from "./App.vue";

// Composables
// This imports the core Vue function to create your application instance.
import { createApp } from "vue";

// Styles
// This imports 'unfonts.css', likely for custom font loading.
// Add any other global CSS imports here if needed.
import "unfonts.css";

// Create the Vue application instance.
const app = createApp(App);

// Register all plugins (Vuetify, etc.) with the app instance.
registerPlugins(app);

// Use the router plugin, making routing functionalities available throughout your app.
app.use(router);

// Mount the application to the DOM element with the ID 'app'.
// This is typically found in your public/index.html file.
app.mount("#app");
