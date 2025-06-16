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

      <h2 class="text-h5 text-center mb-6">Create Your Account</h2>

      <div class="text-subtitle-1 text-medium-emphasis mb-2">First Name</div>
      <v-text-field
        v-model="firstName"
        density="compact"
        placeholder="First Name"
        prepend-inner-icon="mdi-account-outline"
        variant="outlined"
      ></v-text-field>

      <div class="text-subtitle-1 text-medium-emphasis mb-2">Last Name</div>
      <v-text-field
        v-model="lastName"
        density="compact"
        placeholder="Last Name"
        prepend-inner-icon="mdi-account-outline"
        variant="outlined"
      ></v-text-field>

      <div class="text-subtitle-1 text-medium-emphasis mb-2">Email</div>
      <v-text-field
        v-model="email"
        density="compact"
        placeholder="Email address"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
      ></v-text-field>

      <div class="text-subtitle-1 text-medium-emphasis mb-2">Password</div>
      <v-text-field
        v-model="password"
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
        color="green-darken-2"
        size="large"
        variant="tonal"
        block
        @click="handleSignup"
      >
        Sign Up
      </v-btn>

      <v-card-text class="text-center">
        <a
          class="text-blue text-decoration-none"
          href="#"
          @click.prevent="router.push('/')"
        >
          Already have an account? Log In <v-icon icon="mdi-chevron-right"></v-icon>
        </a>
      </v-card-text>

      <!-- Snackbar for messages -->
      <v-snackbar
        v-model="snackbar.show"
        :timeout="snackbar.timeout"
        :color="snackbar.color"
      >
        {{ snackbar.message }}
        <template v-slot:actions>
          <v-btn
            color="white"
            variant="text"
            @click="snackbar.show = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </v-card>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const visible = ref(false);
const firstName = ref('');
const lastName = ref('');
const email = ref('');
const password = ref('');
const router = useRouter();

const snackbar = ref({
  show: false,
  message: '',
  color: '',
  timeout: 3000,
});

const handleSignup = async () => {
  if (!firstName.value || !lastName.value || !email.value || !password.value) {
    snackbar.value = { show: true, message: 'All fields are required.', color: 'error', timeout: 3000 };
    return;
  }

  try {
    const response = await axios.post(
      'http://localhost/buildingpermitapplication/src/pages/signup.php', // <--- IMPORTANT: Verify this URL matches your signup.php location
      {
        firstName: firstName.value,
        lastName: lastName.value,
        email: email.value,
        password: password.value,
        // role: 'applicant' // You can send a default role or let backend assign it
      },
      {
        headers: {
          'Content-Type': 'application/json',
        }
      }
    );

    const data = response.data;

    if (data.success) {
      snackbar.value = { show: true, message: data.message, color: 'success', timeout: 3000 };
      // Redirect to login page after successful registration
      setTimeout(() => {
        router.push('/');
      }, 1500);
    } else {
      snackbar.value = { show: true, message: data.message, color: 'error', timeout: 3000 };
    }
  } catch (error) {
    console.error('Signup error:', error);
    let errorMessage = 'An unexpected error occurred during signup.';
    if (axios.isAxiosError(error) && error.response) {
      errorMessage = error.response.data.message || `Server error: ${error.response.status}`;
    } else if (error.request) {
      errorMessage = 'No response from server. Check network connection.';
    } else {
      errorMessage = `Request setup error: ${error.message}`;
    }
    snackbar.value = { show: true, message: `Signup failed: ${errorMessage}`, color: 'error', timeout: 3000 };
  }
};
</script>

<style scoped>
.custom-width {
  max-width: 450px;
  width: 100%;
  margin-top: 50px;
}
.min-h-screen {
  min-height: 100vh;
}
.bg-grey-lighten-5 {
  background-color: #f5f5f5; /* Example light grey */
}
</style>