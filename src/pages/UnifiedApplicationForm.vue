<template>
  <v-container>
    <v-stepper v-model="step" class="mb-8" flat>
      <v-stepper-header>
        <v-stepper-step
          step="1"
          :complete="step > 1"
          :editable="true"
          @click="step = 1"
        >
          Application Type
        </v-stepper-step>
        <v-divider></v-divider>
        <v-stepper-step
          step="2"
          :complete="step > 2"
          :editable="true"
          @click="step = 2"
        >
          Applicant Details
        </v-stepper-step>
        <v-divider></v-divider>
        <v-stepper-step step="3" :editable="true" @click="step = 3">
          Construction Details
        </v-stepper-step>
      </v-stepper-header>
    </v-stepper>

    <h2 class="text-h4 text-center mb-8 text-blue-darken-3">
      UNIFIED APPLICATION FORM
    </h2>

    <v-form @submit.prevent="submit">
      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4">Application Type</v-card-title>
        <v-row>
          <v-col cols="12" md="4">
            <v-card variant="outlined" class="pa-4 h-100">
              <v-card-subtitle class="mb-2"
                >Type of Application</v-card-subtitle
              >
              <v-radio-group
                v-model="group1"
                :rules="[(v) => !!v || 'Please select an option']"
                hide-details="auto"
              >
                <v-radio label="Simple" value="simple"></v-radio>
                <v-radio label="Complex" value="complex"></v-radio>
              </v-radio-group>
            </v-card>
          </v-col>
          <v-col cols="12" md="4">
            <v-card variant="outlined" class="pa-4 h-100">
              <v-card-subtitle class="mb-2">Application Status</v-card-subtitle>
              <v-radio-group
                v-model="group2"
                :rules="[(v) => !!v || 'Please select an option']"
                hide-details="auto"
              >
                <v-radio label="New" value="new"></v-radio>
                <v-radio label="Renew" value="renew"></v-radio>
              </v-radio-group>
            </v-card>
          </v-col>
          <v-col cols="12" md="4">
            <v-card variant="outlined" class="pa-4 h-100">
              <v-card-subtitle class="mb-2">Amendatory</v-card-subtitle>
              <v-radio-group
                v-model="group3"
                :rules="[(v) => !!v || 'Please select an option']"
                hide-details="auto"
              >
                <v-radio label="Yes" value="yes"></v-radio>
              </v-radio-group>
            </v-card>
          </v-col>
        </v-row>
      </v-card>

      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4"
          >Owner/Applicant Information</v-card-title
        >
        <v-row dense>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Last Name"
              v-model="lastName.value.value"
              :error-messages="lastName.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="First Name"
              v-model="firstName.value.value"
              :error-messages="firstName.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="2">
            <v-text-field
              label="M.I."
              v-model="middleName.value.value"
              :error-messages="middleName.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="2">
            <v-text-field
              label="TIN"
              v-model="tin.value.value"
              :error-messages="tin.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row dense>
          <v-col cols="12" sm="6">
            <v-text-field
              label="For Construction Owned by an Enterprise"
              v-model="enterpriseOwner.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              label="Form of Ownership"
              v-model="formOwnership.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row dense>
          <v-col cols="12" sm="2">
            <v-text-field
              label="No."
              v-model="ownerAddressNo.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Street"
              v-model="ownerAddressStreet.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="3">
            <v-text-field
              label="Barangay"
              v-model="ownerAddressBarangay.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="3">
            <v-text-field
              label="City/Municipal"
              v-model="ownerAddressMunicipal.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="3">
            <v-text-field
              label="Zip Code"
              v-model="ownerAddressZipCode.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Contact Number"
              v-model="contactNumber.value.value"
              :error-messages="contactNumber.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card>

      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4"
          >Location of Construction</v-card-title
        >
        <v-row dense>
          <v-col cols="12" sm="2">
            <v-text-field
              label="Lot No."
              v-model="lotNo.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="2">
            <v-text-field
              label="Blk No."
              v-model="blkNo.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="TCT No."
              v-model="tctNo.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Current Tax Dec No."
              v-model="taxDecNo.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Street"
              v-model="constructionStreet.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Barangay"
              v-model="constructionBarangay.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="City/Municipal"
              v-model="constructionMunicipal.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card>

      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4">Scope of Work</v-card-title>
        <v-row>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="NEW CONSTRUCTION"
              value="new_construction"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="RENOVATION"
              value="renovation"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="RAISING"
              value="raising"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="ERECTION"
              value="erection"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="CONVERSION"
              value="conversion"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="ACCESSORY BUILDING/STRUCTURE"
              value="accessory_building"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="ADDITION"
              value="addition"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="REPAIR"
              value="repair"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="LEGALIZATION OF EXISTING BUILDING"
              value="legalization"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="ALTERATION"
              value="alteration"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="MOVING"
              value="moving"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" sm="6" md="4" lg="3">
            <v-checkbox
              label="OTHERS (Specify)"
              value="others"
              v-model="scopeOfWork"
              density="compact"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" v-if="scopeOfWork.includes('others')">
            <v-text-field
              label="Please specify other scope of work"
              v-model="otherScopeOfWork.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card>

      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4"
          >Use or Character of Occupancy</v-card-title
        >
        <v-row dense>
          <v-col cols="12" md="6">
            <v-card variant="outlined" class="pa-4 h-100">
              <v-card-subtitle class="mb-2"
                >GROUP A: RESIDENTIAL (DWELLINGS)</v-card-subtitle
              >
              <v-checkbox
                label="Single"
                value="single"
                v-model="occupancyGroupA"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Duplex"
                value="duplex"
                v-model="occupancyGroupA"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Residential R-1, R-2"
                value="residential_r1_r2"
                v-model="occupancyGroupA"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Others"
                value="others"
                v-model="occupancyGroupA"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-text-field
                v-if="occupancyGroupA.includes('others')"
                label="Please specify Group A"
                v-model="otherOccupancyGroupA.value.value"
                density="compact"
                variant="outlined"
                class="mt-2"
              ></v-text-field>
            </v-card>
          </v-col>

          <v-col cols="12" md="6">
            <v-card variant="outlined" class="pa-4 h-100">
              <v-card-subtitle class="mb-2"
                >GROUP B: RESIDENTIAL</v-card-subtitle
              >
              <v-checkbox
                label="Hotel"
                value="hotel"
                v-model="occupancyGroupB"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Motel"
                value="motel"
                v-model="occupancyGroupB"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Dormitory"
                value="dormitory"
                v-model="occupancyGroupB"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Townhouse"
                value="townhouse"
                v-model="occupancyGroupB"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Boardinghouse"
                value="boardinghouse"
                v-model="occupancyGroupB"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Lodging House"
                value="lodging_house"
                v-model="occupancyGroupB"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Residential R-3, R-4, R-5"
                value="residential_r345"
                v-model="occupancyGroupB"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-checkbox
                label="Others"
                value="others"
                v-model="occupancyGroupB"
                density="compact"
                hide-details
              ></v-checkbox>
              <v-text-field
                v-if="occupancyGroupB.includes('others')"
                label="Please specify Group B"
                v-model="otherOccupancyGroupB.value.value"
                density="compact"
                variant="outlined"
                class="mt-2"
              ></v-text-field>
            </v-card>
          </v-col>
        </v-row>
        <v-row dense class="mt-6">
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Occupancy Classified"
              v-model="occupancyClassified.value.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Number of Units"
              v-model="numberOfUnits.value.value"
              :error-messages="numberOfUnits.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Number of Storey"
              v-model="numberOfStorey.value.value"
              :error-messages="numberOfStorey.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Total Floor Area (sq.m.)"
              v-model="totalFloorArea.value.value"
              :error-messages="totalFloorArea.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Lot Area (sq.m.)"
              v-model="lotArea.value.value"
              :error-messages="lotArea.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card>

      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4"
          >TOTAL ESTIMATED COST (₱)</v-card-title
        >
        <v-row dense>
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Building"
              v-model="costBuilding.value.value"
              :error-messages="costBuilding.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Electrical"
              v-model="costElectrical.value.value"
              :error-messages="costElectrical.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Mechanical"
              v-model="costMechanical.value.value"
              :error-messages="costMechanical.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Electronics"
              v-model="costElectronics.value.value"
              :error-messages="costElectronics.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              label="Plumbing"
              v-model="costPlumbing.value.value"
              :error-messages="costPlumbing.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card>

      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4"
          >COST OF EQUIPMENT INSTALLED (₱)</v-card-title
        >
        <v-row dense>
          <v-col cols="12" sm="6">
            <v-text-field
              label="P (Equipment)"
              v-model="costEquipment.value.value"
              :error-messages="costEquipment.errorMessage.value"
              density="compact"
              variant="outlined"
              type="number"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card>

      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4">Project Timeline</v-card-title>
        <v-row dense>
          <v-col cols="12" sm="6">
            <v-text-field
              label="Proposed Date of Construction"
              v-model="proposedDate.value.value"
              density="compact"
              variant="outlined"
              type="date"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              label="Expected Date of Completion"
              v-model="expectedDate.value.value"
              density="compact"
              variant="outlined"
              type="date"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card>

      <v-row justify="end" class="mt-4">
        <v-col cols="auto">
          <v-btn color="primary" type="submit">Submit Application</v-btn>
        </v-col>
        <v-col cols="auto">
          <v-btn color="grey-darken-1" @click="handleReset">Reset Form</v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-container>
</template>

<script setup>
import { ref } from "vue";
import { useField, useForm } from "vee-validate";

const step = ref(1);

// Radio Group Refs
const group1 = ref(null);
const group2 = ref(null);
const group3 = ref(null);

// Checkbox Group Refs
const scopeOfWork = ref([]);
const otherScopeOfWork = useField("otherScopeOfWork");
const occupancyGroupA = ref([]);
const otherOccupancyGroupA = useField("otherOccupancyGroupA");
const occupancyGroupB = ref([]);
const otherOccupancyGroupB = useField("otherOccupancyGroupB");

// Form Field Refs and Validation
const { handleSubmit, handleReset } = useForm({
  validationSchema: {
    firstName(value) {
      if (value && value.length >= 2) return true;
      return "First Name needs to be at least 2 characters.";
    },
    middleName(value) {
      if (!value || value.length >= 1) return true;
      return "Middle Name must be at least 1 character if provided.";
    },
    lastName(value) {
      if (value && value.length >= 2) return true;
      return "Last Name needs to be at least 2 characters.";
    },
    tin(value) {
      if (!value || /^\d{3}-\d{3}-\d{3}-\d{3}$|^\d{9}$/.test(value))
        return true; // Basic TIN format (e.g., XXX-XXX-XXX-XXX or XXXXXXXXX)
      return "TIN must be a valid format (e.g., 123-456-789-000 or 123456789).";
    },
    contactNumber(value) {
      if (!value || /^\d{7,}$/.test(value)) return true;
      return "Contact number needs to be at least 7 digits and contain only numbers.";
    },
    numberOfUnits(value) {
      if (!value || (/^\d+$/.test(value) && value >= 0)) return true;
      return "Number of Units must be a non-negative number.";
    },
    numberOfStorey(value) {
      if (!value || (/^\d+$/.test(value) && value >= 0)) return true;
      return "Number of Storey must be a non-negative number.";
    },
    totalFloorArea(value) {
      if (!value || (/^\d+(\.\d+)?$/.test(value) && value >= 0)) return true;
      return "Total Floor Area must be a non-negative number.";
    },
    lotArea(value) {
      if (!value || (/^\d+(\.\d+)?$/.test(value) && value >= 0)) return true;
      return "Lot Area must be a non-negative number.";
    },
    costBuilding(value) {
      if (!value || (/^\d+(\.\d+)?$/.test(value) && value >= 0)) return true;
      return "Building cost must be a non-negative number.";
    },
    costElectrical(value) {
      if (!value || (/^\d+(\.\d+)?$/.test(value) && value >= 0)) return true;
      return "Electrical cost must be a non-negative number.";
    },
    costMechanical(value) {
      if (!value || (/^\d+(\.\d+)?$/.test(value) && value >= 0)) return true;
      return "Mechanical cost must be a non-negative number.";
    },
    costElectronics(value) {
      if (!value || (/^\d+(\.\d+)?$/.test(value) && value >= 0)) return true;
      return "Electronics cost must be a non-negative number.";
    },
    costPlumbing(value) {
      if (!value || (/^\d+(\.\d+)?$/.test(value) && value >= 0)) return true;
      return "Plumbing cost must be a non-negative number.";
    },
    costEquipment(value) {
      if (!value || (/^\d+(\.\d+)?$/.test(value) && value >= 0)) return true;
      return "Equipment cost must be a non-negative number.";
    },
  },
});

const firstName = useField("firstName");
const middleName = useField("middleName");
const lastName = useField("lastName");
const tin = useField("tin");
const enterpriseOwner = useField("enterpriseOwner");
const formOwnership = useField("formOwnership");
const ownerAddressNo = useField("ownerAddressNo");
const ownerAddressStreet = useField("ownerAddressStreet");
const ownerAddressBarangay = useField("ownerAddressBarangay");
const ownerAddressMunicipal = useField("ownerAddressMunicipal");
const ownerAddressZipCode = useField("ownerAddressZipCode");
const contactNumber = useField("contactNumber");
const lotNo = useField("lotNo");
const blkNo = useField("blkNo");
const tctNo = useField("tctNo");
const taxDecNo = useField("taxDecNo");
const constructionStreet = useField("constructionStreet");
const constructionBarangay = useField("constructionBarangay");
const constructionMunicipal = useField("constructionMunicipal");
const occupancyClassified = useField("occupancyClassified");
const numberOfUnits = useField("numberOfUnits");
const numberOfStorey = useField("numberOfStorey");
const totalFloorArea = useField("totalFloorArea");
const lotArea = useField("lotArea");
const costBuilding = useField("costBuilding");
const costElectrical = useField("costElectrical");
const costMechanical = useField("costMechanical");
const costElectronics = useField("costElectronics");
const costPlumbing = useField("costPlumbing");
const costEquipment = useField("costEquipment");
const proposedDate = useField("proposedDate");
const expectedDate = useField("expectedDate");

const submit = handleSubmit((values) => {
  alert(
    JSON.stringify(
      {
        ...values,
        group1: group1.value,
        group2: group2.value,
        group3: group3.value,
        step: step.value,
        scopeOfWork: scopeOfWork.value,
        occupancyGroupA: occupancyGroupA.value,
        occupancyGroupB: occupancyGroupB.value,
      },
      null,
      2
    )
  );
});
</script>

<style scoped>
/* You can add custom styles here if needed */
.v-stepper-header {
  box-shadow: none !important;
}
</style>
