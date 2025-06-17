// router/index.ts

// Composables
import { createRouter, createWebHistory } from "vue-router/auto";

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),

  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("@/pages/index.vue"),
    },
    {
      path: "/page",
      name: "page",
      component: () => import("@/pages/page.vue"),
    },
    {
      path: "/UnifiedAppliationForm",
      name: "UnifiedAppliationForm",
      component: () => import("@/pages/UnifiedAppliationForm.vue"),
    },

    {
      path: "/UploadDocuments",
      name: "UploadDocuments",
      component: () => import("@/pages/UploadDocuments.vue"),
    },

    {
      path: "/DocumentForms",
      name: "DocumentForms",
      component: () => import("@/pages/DocumentForms.vue"),
    },
    {
      path: "/SignupForm",
      name: "SignupForm",
      component: () => import("@/pages/SignupForm.vue"),
    },

    // DOCUMENT FORMS BELOW - ADD DYNAMIC PARAMETERS

    {
      path: "/electrical/:applicationNumber?", // Added dynamic parameter
      name: "electrical",
      component: () => import("@/document/electrical.vue"),
    },

    {
      path: "/sanitary", // Added dynamic parameter
      name: "sanitary",
      component: () => import("@/document/sanitary.vue"),
    },
{
  path: "/architectural/:applicationNumber?",
  name: "architectural",
  component: () => import("@/document/architectural.vue"),
},
    {
      path: "/structural/:applicationNumber?", // Added dynamic parameter
      name: "structural",
      component: () => import("@/document/structural.vue"),
    },

    {
      path: "/mechanical/:applicationNumber?", // Added dynamic parameter
      name: "mechanical",
      component: () => import("@/document/mechanical.vue"),
    },

    {
      path: "/electronics/:applicationNumber?", // Added dynamic parameter
      name: "electronics",
      component: () => import("@/document/electronics.vue"),
    },
  ],
});

export default router;
