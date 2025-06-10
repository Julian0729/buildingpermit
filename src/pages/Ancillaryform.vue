<template>
  <v-container class="pa-5">
    <h1 class="text-h4 mb-4 text-center">Ancillary Form</h1>
    <v-card class="pa-5">
      <v-card-text>
        <p>This is the Ancillary Form page.</p>
        <v-text-field
          label="Ancillary Detail 1"
          outlined
          dense
          class="mb-2"
        ></v-text-field>
        <v-textarea label="Ancillary Description" outlined dense></v-textarea>
      </v-card-text>
      <v-card-actions class="justify-center">
        <v-btn color="primary" @click="saveAncillary"
          >Save Ancillary Data</v-btn
        >
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const saveAncillary = () => {
  alert("Ancillary Data Saved!"); // Use a proper modal in production
  router.push("/index"); // Navigate back to home or relevant page
};
</script>

<style scoped>
/* Specific styles for the Ancillary Form if needed */
</style>
