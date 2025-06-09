/**
 * router/index.ts
 *
 * Automatic routes for `./src/pages/*.vue`
 */

// Composables
import { createRouter, createWebHistory } from "vue-router/auto";

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),

  routes: [
    {
      path: "/",
      name: "Login",
      component: () => import("@/pages/Login.vue"), // Or any other component for the root
    },

    {
      path: "/index",
      name: "page",
      component: () => import("@/pages/index.vue"),
    },

    {
      path: "/UnifiedApplicationForm",
      name: "UnfiedApplicationForm",
      component: () => import("@/pages/UnifiedApplicationForm.vue"),
    },

    // ADD MORE IN HERE USING THE {  Path: ‘/’},
  ],
});

export default router;
