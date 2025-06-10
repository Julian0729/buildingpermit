/**
 * src/router/index.ts
 *
 * Defines the application's routes and creates the Vue Router instance.
 * Using "vue-router/auto" suggests you might have some automatic route generation
 * configured, but for clarity, we're explicitly defining them here based on your pages.
 */

// Composables from vue-router to create the router and manage browser history.
import { createRouter, createWebHistory } from "vue-router"; // Changed to 'vue-router' as 'vue-router/auto' might imply specific setup

const router = createRouter({
  // Use createWebHistory for standard HTML5 history mode (clean URLs).
  // process.env.BASE_URL is often used for deploying to a sub-directory.
  history: createWebHistory(process.env.BASE_URL),

  // Define your application's routes as an array of route objects.
  routes: [
    {
      path: "/", // The root path of your application
      name: "Login", // A unique name for this route
      component: () => import("@/pages/Login.vue"), // Dynamically import the Login component
    },
    {
      path: "/index", // Path for your main index page
      name: "Home", // More descriptive name than "page"
      component: () => import("@/pages/index.vue"), // Dynamically import the Home/Index component
    },
    {
      path: "/UnifiedApplicationForm", // Path for the Unified Application Form
      name: "UnifiedApplicationForm", // Corrected typo in the name
      component: () => import("@/pages/UnifiedApplicationForm.vue"), // Dynamically import the component
    },
    {
      path: "/AncillaryForm", // Path for the Ancillary Form
      name: "AncillaryForm", // Unique name for this route
      component: () => import("@/pages/Ancillaryform.vue"), // Dynamically import the Ancillary Form component
    },
    // You can add more routes here as your application grows,
    // following the same structure.
    // Example:
    // {
    //   path: "/about",
    //   name: "About",
    //   component: () => import("@/pages/About.vue"),
    // },
  ],
});

// Export the router instance so it can be used in main.js
export default router;
