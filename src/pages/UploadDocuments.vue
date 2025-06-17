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

        <!-- Ancillary document upload options removed as per request -->
      </v-card-text>
    </v-card>

    <v-row justify="end" class="mt-4">
      <v-col cols="auto">
        <v-btn color="grey-darken-1" to="/DocumentForms">Previous Step</v-btn>
      </v-col>
      <v-col cols="auto">
        <v-btn color="success" @click="finalizeApplication">Submit Application</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted, reactive, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

// Reactive state for uploaded files
const unifiedApplicationPdf = ref([]);
const generalClearancesPdf = ref([]);

// Watch for changes in unifiedApplicationPdf and save to localStorage
watch(unifiedApplicationPdf, (newValue) => {
  if (newValue && newValue.length > 0) {
    const fileNames = newValue.map(file => file.name);
    localStorage.setItem('unifiedApplicationPdfNames', JSON.stringify(fileNames));
  } else {
    localStorage.removeItem('unifiedApplicationPdfNames');
  }
}, { deep: true });

// Watch for changes in generalClearancesPdf and save to localStorage
watch(generalClearancesPdf, (newValue) => {
  if (newValue && newValue.length > 0) {
    const fileNames = newValue.map(file => file.name);
    localStorage.setItem('generalClearancesPdfNames', JSON.stringify(fileNames));
  } else {
    localStorage.removeItem('generalClearancesPdfNames');
  }
}, { deep: true });


// Initialize all ancillary document upload models on component mount - Adjusted
onMounted(() => {
  // First, attempt to load file names from localStorage for a "draft" state
  loadDraftFromLocalStorage();
  // Then, load previously uploaded documents from the backend (source of truth)
  loadUploadedDocuments();
});

// Function to load file names from localStorage
const loadDraftFromLocalStorage = () => {
  const savedUnifiedNames = localStorage.getItem('unifiedApplicationPdfNames');
  if (savedUnifiedNames) {
    try {
      const parsedNames = JSON.parse(savedUnifiedNames);
      // Recreate File objects only with the name for display purposes
      unifiedApplicationPdf.value = parsedNames.map(name => new File([], name));
    } catch (e) {
      console.error("Error parsing unifiedApplicationPdfNames from localStorage:", e);
      localStorage.removeItem('unifiedApplicationPdfNames');
    }
  }

  const savedGeneralNames = localStorage.getItem('generalClearancesPdfNames');
  if (savedGeneralNames) {
    try {
      const parsedNames = JSON.parse(savedGeneralNames);
      // Recreate File objects only with the name for display purposes
      generalClearancesPdf.value = parsedNames.map(name => new File([], name));
    } catch (e) {
      console.error("Error parsing generalClearancesPdfNames from localStorage:", e);
      localStorage.removeItem('generalClearancesPdfNames');
    }
  }
};


const goToPreviousStep = () => {
  // Navigate back to DocumentForms, preserving prepopulated data
  router.push({
    path: '/DocumentForms', // Ensure this matches your DocumentForms route
    query: {
      applicantFullName: route.query.applicantFullName,
      projectFullAddress: route.query.projectFullAddress,
      // No need to pass selectedDocuments back for dynamic generation in this approach
    }
  });
};

const loadUploadedDocuments = async () => {
  try {
    const response = await fetch('http://localhost/buildingpermitapplication/src/pages/Upload-Backend/upload.php', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (response.ok) {
      const result = await response.json();
      if (result.success && result.data) {
        const loadedData = result.data;
        console.log("Loaded data from backend:", loadedData);

        // Populate unified and general clearances from backend (overwriting localStorage draft if backend has data)
        if (loadedData.unified_application_pdf_paths && loadedData.unified_application_pdf_paths.length > 0) {
          unifiedApplicationPdf.value = loadedData.unified_application_pdf_paths.map(path => new File([], path.split('/').pop()));
        } else {
          unifiedApplicationPdf.value = []; // Explicitly clear if backend sends empty
        }
        if (loadedData.general_clearances_pdf_paths && loadedData.general_clearances_pdf_paths.length > 0) {
          generalClearancesPdf.value = loadedData.general_clearances_pdf_paths.map(path => new File([], path.split('/').pop()));
        } else {
          generalClearancesPdf.value = []; // Explicitly clear if backend sends empty
        }

        console.log("Documents loaded from backend.");
      } else {
        console.log("No previous upload data found from backend or error:", result.message);
      }
    } else {
      console.error("Failed to load documents from backend:", response.statusText);
    }
  } catch (error) {
    console.error("Error fetching documents:", error);
  }
};

const finalizeApplication = async () => {
  console.log("Finalizing application and preparing files for upload...");

  const formData = new FormData();

  // Append Unified Application PDF(s)
  if (unifiedApplicationPdf.value.length > 0) {
    unifiedApplicationPdf.value.forEach((file) => {
      formData.append('unifiedApplicationForm[]', file); // Use array notation for multiple files
    });
  } else {
    // Explicitly append an empty string if no files are selected to signal backend to clear
    formData.append('unifiedApplicationForm[]', '');
  }

  // Append General Clearances PDF(s)
  if (generalClearancesPdf.value.length > 0) {
    generalClearancesPdf.value.forEach((file) => {
      formData.append('generalClearances[]', file); // Use array notation for multiple files
    });
  } else {
    // Explicitly append an empty string if no files are selected to signal backend to clear
    formData.append('generalClearances[]', '');
  }

  // Append other data like applicant info if not already sent
  formData.append('applicantFullName', route.query.applicantFullName || '');
  formData.append('projectFullAddress', route.query.projectFullAddress || '');

  try {
    const response = await fetch('http://localhost/buildingpermitapplication/src/pages/Upload-Backend/upload.php', {
      method: 'POST',
      body: formData,
      // The 'Content-Type': 'multipart/form-data' header is usually
      // automatically set by the browser when you use FormData, so don't set it manually.
    });

    if (response.ok) {
      const result = await response.json();
      alert("Application submitted successfully!");
      console.log("Upload successful:", result);

      // Clear localStorage for these files upon successful submission
      localStorage.removeItem('unifiedApplicationPdfNames');
      localStorage.removeItem('generalClearancesPdfNames');

      // Optionally, clear the form refs or navigate to a success page here
      // unifiedApplicationPdf.value = [];
      // generalClearancesPdf.value = [];
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
