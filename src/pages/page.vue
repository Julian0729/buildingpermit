<template>
  <v-container class="py-8">
    <h2 class="text-h4 mb-6 text-center text-blue-darken-3">
      Building Permit Application
    </h2>
    <v-stepper :items="['Application Details', 'Document Forms', 'Upload Documents']" v-model="step" show-actions class="elevation-2 mb-8">
      <template v-slot:item.1>
        <unified-application-form
          @update:prepopulated-data="updatePrepopulatedData"
          @next-step="advanceStep"
        ></unified-application-form>
      </template>

      <template v-slot:item.2>
        <document-forms
          :prepopulated-data="prepopulatedData"
          v-model:selected-documents="selectedDocuments"
          @next-step="advanceStep"
          @previous-step="step--"
        ></document-forms>
      </template>

      <template v-slot:item.3>
        <upload-documents
          :selected-documents="selectedDocuments"
          @previous-step="step--"
          @finalize-application="finalizeApplication"
        ></upload-documents>
      </template>
    </v-stepper>

    <v-dialog v-model="showApplicationDialog" max-width="500">
      <v-card>
        <v-card-title class="headline text-h5">Application Submitted!</v-card-title>
        <v-card-text class="text-center text-h6 py-4">
          Your Application Number is: <br />
          <strong class="text-blue-darken-3">{{ applicationNumber }}</strong>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="closeApplicationDialog">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { ref, reactive } from 'vue';
import UnifiedApplicationForm from './components/UnifiedApplicationForm.vue';
import DocumentForms from './components/DocumentForms.vue';
import UploadDocuments from './components/UploadDocuments.vue';

const step = ref(1);
const showApplicationDialog = ref(false);
const applicationNumber = ref("");

// Data that needs to be shared between steps
const prepopulatedData = reactive({
  applicantFullName: "",
  projectFullAddress: "",
});

const selectedDocuments = ref([]);

// Handlers for child component events
const updatePrepopulatedData = (data) => {
  prepopulatedData.applicantFullName = data.applicantFullName;
  prepopulatedData.projectFullAddress = data.projectFullAddress;

  // Simulate application submission and number generation here (from original submitUnifiedApplication)
  const timestamp = Date.now();
  const randomSuffix = Math.floor(Math.random() * 1000);
  applicationNumber.value = `BP-UAF-${timestamp}-${randomSuffix}`;
  showApplicationDialog.value = true;
};

const advanceStep = () => {
  if (step.value === 2 && selectedDocuments.value.length === 0) {
    alert("Please select at least one document type to proceed to uploads.");
    return;
  }
  step.value++;
};

const closeApplicationDialog = () => {
  showApplicationDialog.value = false;
  // Potentially advance step here if dialog closes means successful submission
  // Or handle it within updatePrepopulatedData
};

const finalizeApplication = () => {
  alert("Overall application finalized! This would trigger final submission logic for all steps.");
  // Here, you'd collect all data from all forms and send it to your backend
};
</script>

<style scoped>
.v-stepper-header {
  box-shadow: none !important;
}
</style>