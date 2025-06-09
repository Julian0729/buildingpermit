<template>
  <div
    class="d-flex justify-center align-center min-h-screen bg-grey-lighten-5"
  >
    <v-card class="pa-12 pb-8 custom-width" elevation="8" rounded="lg">
      <v-img
        class="mx-auto my-6"
        max-width="120"
        src="https://www2.naga.gov.ph/wp-content/uploads/2022/05/Naga_City_Official_Seal-1.png"
      ></v-img>

      <div class="text-subtitle-1 text-medium-emphasis mb-2">Email</div>
      <v-text-field
        density="compact"
        placeholder="Email address"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
      ></v-text-field>

      <div
        class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between mb-2"
      >
        Password
        <a
          class="text-caption text-decoration-none text-blue"
          href="#"
          rel="noopener noreferrer"
          target="_blank"
        >
          Forgot password?
        </a>
      </div>
      <v-text-field
        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visible ? 'text' : 'password'"
        density="compact"
        placeholder="Enter your password"
        prepend-inner-icon="mdi-lock-outline"
        variant="outlined"
        @click:append-inner="visible = !visible"
      ></v-text-field>

      <v-btn
        class="mb-8"
        color="blue"
        size="large"
        variant="tonal"
        block
        to="/UnifiedApplicationForm"
      >
        Log In
      </v-btn>

      <v-card-text class="text-center">
        <a
          class="text-blue text-decoration-none"
          href="#"
          rel="noopener noreferrer"
          target="_blank"
        >
          Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
        </a>
      </v-card-text>
    </v-card>
  </div>
</template>

<script setup>
import { ref } from "vue";
const visible = ref(false);
</script>

<style scoped>
.custom-width {
  max-width: 450px;
  width: 100%;
  margin-top: 50px;
}
</style>
