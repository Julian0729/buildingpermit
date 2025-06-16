<template>
  <v-container>
    <v-row class="mb-8">
      <v-col cols="12">
        <div class="d-flex align-center justify-center stepper-container">
          <div class="stepper-item">
            <v-icon class="stepper-icon">mdi-numeric-1-circle</v-icon>
            <span class="stepper-text">Unified Application Form</span>
          </div>
          <div class="stepper-line"></div>
          <div class="stepper-item">
            <v-icon class="stepper-icon">mdi-pencil-circle</v-icon>
            <span class="stepper-text">Document Forms</span>
          </div>
          <div class="stepper-line"></div>
          <div class="stepper-item active">
            <v-icon class="stepper-icon">mdi-numeric-3-circle</v-icon>
            <span class="stepper-text">Uploading of Documents</span>
          </div>
        </div>
      </v-col>
    </v-row>

    <v-card class="mb-8 pa-6" elevation="2">
      <v-card-title class="text-h6 mb-4">Upload Documents</v-card-title>
      <v-card-text>
        <p class="mb-4">
          Please upload all required documents for your application. If a document type is not applicable to your project, you may leave that field blank.
        </p>

        <v-file-input
          label="Upload Unified Application Form (PDF)"
          accept="application/pdf"
          v-model="unifiedApplicationPdf"
          multiple
          variant="outlined"
          prepend-icon="mdi-file-pdf-box"
          clearable
          class="mb-4"
        ></v-file-input>

        <v-file-input
          label="Upload General Clearances (PDF)"
          accept="application/pdf"
          v-model="generalClearancesPdf"
          multiple
          variant="outlined"
          prepend-icon="mdi-file-pdf-box"
          clearable
          class="mb-4"
        ></v-file-input>

        <v-divider class="my-6"></v-divider>

        <p class="mb-4 text-subtitle-1">Ancillary Documents</p>

        <div v-for="docOption in allDocumentUploadOptions" :key="docOption.value" class="mb-4">
          <v-file-input
            :label="`Upload ${docOption.label} (PDFs)`"
            accept="application/pdf"
            multiple
            variant="outlined"
            prepend-icon="mdi-paperclip"
            clearable
            v-model="uploadedAncillaryDocuments[docOption.value]"
          ></v-file-input>
        </div>
      </v-card-text>
    </v-card>

    <v-row justify="end" class="mt-4">
      <v-col cols="auto">
        <v-btn color="grey-darken-1" @click="goToPreviousStep" to="/DocumentForms">Previous Step</v-btn>
      </v-col>
      <v-col cols="auto">
        <v-btn color="success" @click="finalizeApplication">Finalize Application</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

// Reactive state for uploaded files
const unifiedApplicationPdf = ref([]);
const generalClearancesPdf = ref([]);
// Reactive object to store files for each ancillary document type
const uploadedAncillaryDocuments = reactive({});

// All possible ancillary document upload options
const allDocumentUploadOptions = [
  { label: "Architectural Documents", value: "architectural" },
  { label: "Civil/Structural Documents", value: "civil_structural" },
  { label: "Electrical Documents", value: "electrical" },
  { label: "Sanitary Documents", value: "sanitary" },
  { label: "Plumbing Documents", value: "plumbing" },
  { label: "Mechanical Documents", value: "mechanical" },
  { label: "Electronics Documents", value: "electronics" },
  { label: "Geodetic Documents", value: "geodetic" },
];

// Initialize all ancillary document upload models on component mount
onMounted(() => {
  allDocumentUploadOptions.forEach(option => {
    uploadedAncillaryDocuments[option.value] = [];
  });
});

const goToPreviousStep = () => {
  // Navigate back to DocumentForms, preserving prepopulated data
  router.push({
    path: '/', // Adjust this path if your DocumentForms component is on a different route, e.g., '/document-forms'
    query: {
      applicantFullName: route.query.applicantFullName,
      projectFullAddress: route.query.projectFullAddress,
      // No need to pass selectedDocuments back for dynamic generation in this approach
    }
  });
};

const finalizeApplication = async () => {
  console.log("Finalizing application and preparing files for upload...");

  const formData = new FormData();

  // Append Unified Application PDF(s)
  if (unifiedApplicationPdf.value.length > 0) {
    unifiedApplicationPdf.value.forEach((file) => {
      formData.append('unifiedApplicationForm', file);
    });
  }

  // Append General Clearances PDF(s)
  if (generalClearancesPdf.value.length > 0) {
    generalClearancesPdf.value.forEach((file) => {
      formData.append('generalClearances', file);
    });
  }

  // Append all Ancillary Documents that have files attached
  for (const docType in uploadedAncillaryDocuments) {
    if (uploadedAncillaryDocuments[docType] && uploadedAncillaryDocuments[docType].length > 0) {
      uploadedAncillaryDocuments[docType].forEach((file) => {
        // Use a consistent naming convention for backend: e.g., 'architecturalFiles[]'
        formData.append(`${docType}Files[]`, file);
      });
    }
  }

  // Optionally, append other data like applicant info if not already sent
  formData.append('applicantFullName', route.query.applicantFullName || '');
  formData.append('projectFullAddress', route.query.projectFullAddress || '');
  // You might still want to send which types were *expected* even if all fields are shown
  // This depends on how your backend processes the submission.
  // If the "selectedDocuments" from the previous step is still relevant for backend logic,
  // ensure it's passed here, or derive it from the uploaded files.

  // --- Example: Sending data to a mock API endpoint ---
  // In a real application, you'd replace this with your actual backend API call.
  try {
    // Replace '/api/upload-documents' with your actual backend endpoint
    const response = await fetch('/api/upload-documents', {
      method: 'POST',
      body: formData,
      // The 'Content-Type': 'multipart/form-data' header is usually
      // automatically set by the browser when you use FormData.
    });

    if (response.ok) {
      const result = await response.json();
      alert("Application submitted successfully!");
      console.log("Upload successful:", result);
      // Redirect to a success page or provide further instructions
      // router.push('/application-success');
    } else {
      const errorData = await response.json();
      alert(`Submission failed: ${errorData.message || response.statusText}`);
      console.error("Upload failed:", errorData);
    }
  } catch (error) {
    alert("An error occurred during submission. Please try again.");
    console.error("Network or submission error:", error);
  }
};
</script>

<style scoped>
/* Stepper styles for consistency */
.stepper-container {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
}

.stepper-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  position: relative;
  flex-shrink: 0;
  padding: 0 10px;
}

.stepper-icon {
  font-size: 40px;
  color: grey;
}

.stepper-text {
  font-size: 0.9em;
  color: grey;
  margin-top: 5px;
  white-space: nowrap;
}

.stepper-item.active .stepper-icon {
  color: #1976D2; /* Primary color for active icon */
}

.stepper-item.active .stepper-text {
  color: #000; /* Darker text for active step */
  font-weight: bold;
}

.stepper-line {
  flex-grow: 1;
  height: 2px;
  background-color: grey;
  margin: 0 10px;
}
</style>