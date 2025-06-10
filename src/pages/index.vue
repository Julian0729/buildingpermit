<template>
  <v-container class="fill-height align-center justify-center">
    <v-card class="pa-5" width="600">
      <v-card-title class="text-h4 text-center">Welcome Home!</v-card-title>
      <v-card-text class="text-center">
        <p>This is your main dashboard or landing page after logging in.</p>
        <p>You can navigate to other forms using the links in the App Bar.</p>
      </v-card-text>
      <v-card-actions class="justify-center">
        <v-btn color="secondary" to="/UnifiedApplicationForm"
          >Go to Unified Application Form</v-btn
        >
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script setup>
// No specific logic needed for this simple placeholder
</script>

<style scoped>
/* Specific styles for the Index page if needed */
</style>
