<template>
  <v-container>
    <!-- Main Stepper for the Application Flow -->
    <v-stepper v-model="step" class="mb-8" flat>
      <v-stepper-header>
        <v-stepper-item
          title="Unified Application Form"
          value="1"
          :complete="step > 1"
          :editable="true"
          @click="step = 1"
        ></v-stepper-item>

        <v-divider></v-divider>

        <v-stepper-item
          title="Document Forms"
          value="2"
          :complete="step > 2"
          :editable="true"
          @click="step = 2"
        ></v-stepper-item>

        <v-divider></v-divider>

        <v-stepper-item
          title="Uploading of Documents"
          value="3"
          :editable="true"
          @click="step = 3"
        ></v-stepper-item>
      </v-stepper-header>
    </v-stepper>

    <h2 class="text-h4 text-center mb-8 text-blue-darken-3">
      BUILDING PERMIT APPLICATION
    </h2>

    <!-- Content for Stepper 1 (Unified Application Form) -->
    <v-form @submit.prevent="submitUnifiedApplication" v-show="step === 1">
      <!-- Application Type -->
      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4">Application Type</v-card-title>
        <v-row>
          <v-col cols="12" md="6">
            <v-card
              variant="outlined"
              class="pa-4 h-100 d-flex flex-column align-center justify-center"
            >
              <v-card-subtitle class="mb-2"
                >Type of Application</v-card-subtitle
              >
              <v-radio-group
                v-model="group1.value.value"
                :error-messages="group1.errorMessage.value"
                hide-details="auto"
                inline
                class="d-flex justify-center"
              >
                <v-radio label="Simple" value="simple"></v-radio>
                <v-radio label="Complex" value="complex"></v-radio>
              </v-radio-group>
            </v-card>
          </v-col>
          <v-col cols="12" md="6">
            <v-card
              variant="outlined"
              class="pa-4 h-100 d-flex flex-column align-center justify-center"
            >
              <v-card-subtitle class="mb-2">Application Status</v-card-subtitle>
              <v-radio-group
                v-model="group2.value.value"
                :error-messages="group2.errorMessage.value"
                hide-details="auto"
                inline
                class="d-flex justify-center"
              >
                <v-radio label="New" value="new"></v-radio>
                <v-radio label="Renew" value="renew"></v-radio>
                <v-radio label="Amendatory" value="amendatory"></v-radio>
              </v-radio-group>
            </v-card>
          </v-col>
        </v-row>
      </v-card>

      <!-- Owner/Applicant Details -->
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

      <!-- Location of Construction -->
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

      <!-- Scope of Work -->
      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4">Scope of Work</v-card-title>
        <v-row>
          <v-col cols="12">
            <v-select
              label="Select Scope of Work"
              :items="scopeOfWorkOptions"
              v-model="scopeOfWork.value.value"
              :error-messages="scopeOfWork.errorMessage.value"
              multiple
              chips
              closable-chips
              density="compact"
              variant="outlined"
            ></v-select>
          </v-col>
          <v-col cols="12" v-if="scopeOfWork.value.value.includes('Others')">
            <v-text-field
              label="Please specify other scope of work"
              v-model="otherScopeOfWork.value.value"
              :error-messages="otherScopeOfWork.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card>

      <!-- Use or Character of Occupancy -->
      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4"
          >Use or Character of Occupancy</v-card-title
        >
        <v-row dense>
          <v-col cols="12" md="6">
            <v-select
              label="Select Occupancy Group"
              :items="occupancyGroupOptions"
              v-model="occupancyGroup.value.value"
              :error-messages="occupancyGroup.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-select>
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              label="Select Occupancy Type"
              :items="currentOccupancyTypeOptions"
              v-model="occupancyType.value.value"
              :error-messages="occupancyType.errorMessage.value"
              density="compact"
              variant="outlined"
              :disabled="!occupancyGroup.value.value"
            ></v-select>
          </v-col>
          <v-col cols="12" v-if="occupancyType.value.value === 'Others'">
            <v-text-field
              label="Please specify other occupancy type"
              v-model="otherOccupancyType.value.value"
              :error-messages="otherOccupancyType.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
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

      <!-- Estimated Cost -->
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

      <!-- Equipment Installed -->
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

      <!-- Dates -->
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

      <!-- FULL-TIME INSPECTOR AND SUPERVISOR OF CONSTRUCTION WORKS / APPLICANT / LOT OWNER / NOTARIAL Acknowledgment -->
      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4"
          >AFFIDAVIT OF FULL-TIME INSPECTOR AND SUPERVISOR OF CONSTRUCTION
          WORKS</v-card-title
        >

        <!-- BOX 2: FULL-TIME INSPECTOR AND SUPERVISOR OF CONSTRUCTION WORKS (REPRESENTING THE OWNER) -->
        <v-card-subtitle class="mt-4 mb-2 font-weight-bold"
          >BOX 2: FULL-TIME INSPECTOR AND SUPERVISOR OF CONSTRUCTION WORKS
          (REPRESENTING THE OWNER)</v-card-subtitle
        >
        <v-row dense>
          <v-col cols="12">
            <v-text-field
              label="Address (Inspector/Supervisor)"
              v-model="inspectorAddress.value.value"
              :error-messages="inspectorAddress.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Architect or Civil Engineer (Printed Name)"
              v-model="architectCivilEngineerName.value.value"
              :error-messages="architectCivilEngineerName.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
            <p class="text-caption mt-n2 mb-2 text-center">
              Signature Over Printed Name
            </p>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Date (of Signature)"
              v-model="architectEngineerSignatureDate.value.value"
              :error-messages="
                architectEngineerSignatureDate.errorMessage.value
              "
              density="compact"
              variant="outlined"
              type="date"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="3">
            <v-text-field
              label="PRC No."
              v-model="prcNo.value.value"
              :error-messages="prcNo.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="3">
            <v-text-field
              label="Validity"
              v-model="prcValidity.value.value"
              :error-messages="prcValidity.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="3">
            <v-text-field
              label="PTR No."
              v-model="ptrNo.value.value"
              :error-messages="ptrNo.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="3">
            <v-text-field
              label="Date Issued (PTR)"
              v-model="ptrDateIssued.value.value"
              :error-messages="ptrDateIssued.errorMessage.value"
              density="compact"
              variant="outlined"
              type="date"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              label="Issued at (PTR)"
              v-model="ptrIssuedAt.value.value"
              :error-messages="ptrIssuedAt.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              label="TIN (Inspector/Supervisor)"
              v-model="inspectorTin.value.value"
              :error-messages="inspectorTin.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-divider class="my-6"></v-divider>

        <!-- BOX 3 APPLICANT -->
        <v-card-subtitle class="mt-4 mb-2 font-weight-bold"
          >BOX 3: APPLICANT</v-card-subtitle
        >
        <v-row dense>
          <v-col cols="12" md="6">
            <v-text-field
              label="Applicant Name (Printed Name)"
              v-model="box3ApplicantName.value.value"
              :error-messages="box3ApplicantName.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
            <p class="text-caption mt-n2 mb-2 text-center">
              Signature Over Printed Name
            </p>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Date (Applicant Signature)"
              v-model="box3ApplicantSignatureDate.value.value"
              :error-messages="box3ApplicantSignatureDate.errorMessage.value"
              density="compact"
              variant="outlined"
              type="date"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Address (Applicant)"
              v-model="box3ApplicantAddress.value.value"
              :error-messages="box3ApplicantAddress.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Gov't ID No."
              v-model="box3ApplicantGovtIdNo.value.value"
              :error-messages="box3ApplicantGovtIdNo.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Date Issued"
              v-model="box3ApplicantIdDateIssued.value.value"
              :error-messages="box3ApplicantIdDateIssued.errorMessage.value"
              density="compact"
              variant="outlined"
              type="date"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Place Issued"
              v-model="box3ApplicantIdPlaceIssued.value.value"
              :error-messages="box3ApplicantIdPlaceIssued.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-divider class="my-6"></v-divider>

        <!-- BOX 4 WITH MY CONSENT: LOT OWNER / AUTHORIZED REPRESENTATIVE -->
        <v-card-subtitle class="mt-4 mb-2 font-weight-bold"
          >BOX 4: WITH MY CONSENT: LOT OWNER / AUTHORIZED
          REPRESENTATIVE</v-card-subtitle
        >
        <v-row dense>
          <v-col cols="12" md="6">
            <v-text-field
              label="Lot Owner / Authorized Representative (Printed Name)"
              v-model="box4LotOwnerRepName.value.value"
              :error-messages="box4LotOwnerRepName.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
            <p class="text-caption mt-n2 mb-2 text-center">
              Signature Over Printed Name
            </p>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Date (Lot Owner/Rep Signature)"
              v-model="box4LotOwnerRepSignatureDate.value.value"
              :error-messages="box4LotOwnerRepSignatureDate.errorMessage.value"
              density="compact"
              variant="outlined"
              type="date"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Address (Lot Owner/Rep)"
              v-model="box4LotOwnerRepAddress.value.value"
              :error-messages="box4LotOwnerRepAddress.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Gov't ID No."
              v-model="box4LotOwnerRepGovtIdNo.value.value"
              :error-messages="box4LotOwnerRepGovtIdNo.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Date Issued"
              v-model="box4LotOwnerRepIdDateIssued.value.value"
              :error-messages="box4LotOwnerRepIdDateIssued.errorMessage.value"
              density="compact"
              variant="outlined"
              type="date"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="Place Issued"
              v-model="box4LotOwnerRepIdPlaceIssued.value.value"
              :error-messages="box4LotOwnerRepIdPlaceIssued.errorMessage.value"
              density="compact"
              variant="outlined"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-divider class="my-6"></v-divider>

        <!-- BOX 5 REPUBLIC OF THE PHILIPPINES ... (Acknowledgment/Notary) - Purely text -->
        <v-card-subtitle class="mt-4 mb-2 font-weight-bold"
          >BOX 5: ACKNOWLEDGMENT / NOTARY PUBLIC</v-card-subtitle
        >
        <v-card-text class="py-0">
          <p class="mb-2">REPUBLIC OF THE PHILIPPINES</p>
          <p class="mb-2">
            CITY/MUNICIPALITY OF
            <span class="underline-static" style="min-width: 200px"></span> S.S
          </p>
          <p class="mb-2">
            BEFORE ME, at the City/Municipality of
            <span class="underline-static" style="min-width: 200px"></span>, on
            <span class="underline-static" style="min-width: 150px"></span>,
            personally appeared the following:
          </p>
          <p class="mb-1 ml-4 font-weight-medium">
            APPLICANT (Signature Over Printed Name)
          </p>
          <v-row dense class="ml-4 mb-2">
            <v-col cols="12">
              <p class="mb-1">
                Full Name:
                <span class="underline-static" style="min-width: 300px"></span>
              </p>
            </v-col>
            <v-col cols="12" sm="4">
              <p class="mb-1">
                Gov't ID No.:
                <span class="underline-static" style="min-width: 150px"></span>
              </p>
            </v-col>
            <v-col cols="12" sm="4">
              <p class="mb-1">
                Date Issued:
                <span class="underline-static" style="min-width: 100px"></span>
              </p>
            </v-col>
            <v-col cols="12" sm="4">
              <p class="mb-1">
                Place Issued:
                <span class="underline-static" style="min-width: 100px"></span>
              </p>
            </v-col>
          </v-row>
          <p class="mb-1 ml-4 font-weight-medium">
            LICENSED ARCHITECT OR CIVIL ENGINEER (Full-Time Inspector and
            Supervisor of Construction Works)
          </p>
          <v-row dense class="ml-4 mb-2">
            <v-col cols="12">
              <p class="mb-1">
                Full Name:
                <span class="underline-static" style="min-width: 300px"></span>
              </p>
            </v-col>
            <v-col cols="12" sm="4">
              <p class="mb-1">
                Gov't ID No.:
                <span class="underline-static" style="min-width: 150px"></span>
              </p>
            </v-col>
            <v-col cols="12" sm="4">
              <p class="mb-1">
                Date Issued:
                <span class="underline-static" style="min-width: 100px"></span>
              </p>
            </v-col>
            <v-col cols="12" sm="4">
              <p class="mb-1">
                Place Issued:
                <span class="underline-static" style="min-width: 100px"></span>
              </p>
            </v-col>
          </v-row>
          <p class="mb-2">
            whose signatures appear hereinabove, known to me to be the same
            persons who executed this standard prescribed form and acknowledged
            to me that the same is their free and voluntary act and deed.
          </p>
          <p class="mb-4">
            WITNESS MY HAND AND SEAL on the date and place above written.
          </p>
        </v-card-text>

        <v-row dense class="px-6">
          <v-col cols="12" sm="3">
            <p class="mb-1">
              Doc. No.:
              <span class="underline-static" style="min-width: 80px"></span>
            </p>
          </v-col>
          <v-col cols="12" sm="3">
            <p class="mb-1">
              Page No.:
              <span class="underline-static" style="min-width: 80px"></span>
            </p>
          </v-col>
          <v-col cols="12" sm="3">
            <p class="mb-1">
              Book No.:
              <span class="underline-static" style="min-width: 80px"></span>
            </p>
          </v-col>
          <v-col cols="12" sm="3">
            <p class="mb-1">
              Series of:
              <span class="underline-static" style="min-width: 80px"></span>
            </p>
          </v-col>
          <v-col cols="12">
            <p class="mb-1">
              NOTARY PUBLIC (Until December
              <span class="underline-static" style="min-width: 100px"></span>)
            </p>
          </v-col>
        </v-row>
      </v-card>

      <!-- Buttons for Stepper 1 -->
      <v-row justify="end" class="mt-4">
        <v-col cols="auto">
          <v-btn color="grey-darken-1" @click="handleReset">Reset Form</v-btn>
        </v-col>
        <v-col cols="auto">
          <!-- Button to submit the form and advance to next step -->
          <v-btn color="primary" type="submit">Next Step</v-btn>
        </v-col>
      </v-row>
    </v-form>

    <!-- Content for Stepper 2 (Document Forms Checklist and Conditional Forms) -->
    <div v-show="step === 2">
      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4"
          >Select Required Documents</v-card-title
        >
        <v-card-text>
          <p class="mb-4">
            Please select the types of documents you will be submitting:
          </p>
          <v-row justify="center">
            <v-col
              cols="12"
              sm="6"
              md="4"
              v-for="docTypeOption in documentChecklistOptions"
              :key="docTypeOption.value"
            >
              <v-checkbox
                :label="docTypeOption.label"
                :value="docTypeOption.value"
                v-model="selectedDocuments"
                class="d-flex justify-center"
              ></v-checkbox>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <!-- Conditional Forms based on Checklist Selection -->
      <v-form @submit.prevent="downloadForms">
        <v-card
          v-if="selectedDocuments.includes('architectural')"
          class="mb-8 pa-6"
          elevation="2"
        >
          <v-card-title class="text-h6 mb-4"
            >Architectural Document Form</v-card-title
          >
          <v-row dense>
            <v-col cols="12" md="6">
              <v-text-field
                label="Applicant Name"
                v-model="prepopulatedData.applicantFullName"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Project Address"
                v-model="prepopulatedData.projectFullAddress"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Architectural Project Type"
                v-model="architecturalProjectType.value.value"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-textarea
                label="Architectural Scope Details"
                v-model="architecturalScopeDetails.value.value"
                density="compact"
                variant="outlined"
              ></v-textarea>
            </v-col>
          </v-row>
        </v-card>

        <v-card
          v-if="selectedDocuments.includes('civil_structural')"
          class="mb-8 pa-6"
          elevation="2"
        >
          <v-card-title class="text-h6 mb-4"
            >Civil/Structural Documents Form</v-card-title
          >
          <v-row dense>
            <v-col cols="12" md="6">
              <v-text-field
                label="Applicant Name"
                v-model="prepopulatedData.applicantFullName"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Project Address"
                v-model="prepopulatedData.projectFullAddress"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Structural Type"
                v-model="structuralType.value.value"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-textarea
                label="Civil/Structural Notes"
                v-model="civilStructuralNotes.value.value"
                density="compact"
                variant="outlined"
              ></v-textarea>
            </v-col>
          </v-row>
        </v-card>

        <v-card
          v-if="selectedDocuments.includes('electrical')"
          class="mb-8 pa-6"
          elevation="2"
        >
          <v-card-title class="text-h6 mb-4"
            >Electrical Documents Form</v-card-title
          >
          <v-row dense>
            <v-col cols="12" md="6">
              <v-text-field
                label="Applicant Name"
                v-model="prepopulatedData.applicantFullName"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Project Address"
                v-model="prepopulatedData.projectFullAddress"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Electrical Load (kW)"
                v-model="electricalLoad.value.value"
                type="number"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Number of Outlets"
                v-model="numberOfOutlets.value.value"
                type="number"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card>

        <v-card
          v-if="selectedDocuments.includes('sanitary')"
          class="mb-8 pa-6"
          elevation="2"
        >
          <v-card-title class="text-h6 mb-4"
            >Sanitary Documents Form</v-card-title
          >
          <v-row dense>
            <v-col cols="12" md="6">
              <v-text-field
                label="Applicant Name"
                v-model="prepopulatedData.applicantFullName"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Project Address"
                v-model="prepopulatedData.projectFullAddress"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Water Supply Source"
                v-model="waterSupplySource.value.value"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Waste Disposal Method"
                v-model="wasteDisposalMethod.value.value"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card>

        <v-card
          v-if="selectedDocuments.includes('plumbing')"
          class="mb-8 pa-6"
          elevation="2"
        >
          <v-card-title class="text-h6 mb-4"
            >Plumbing Documents Form</v-card-title
          >
          <v-row dense>
            <v-col cols="12" md="6">
              <v-text-field
                label="Applicant Name"
                v-model="prepopulatedData.applicantFullName"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Project Address"
                v-model="prepopulatedData.projectFullAddress"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Number of Fixtures"
                v-model="numberOfFixtures.value.value"
                type="number"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Plumbing System Type"
                v-model="plumbingSystemType.value.value"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card>

        <v-card
          v-if="selectedDocuments.includes('mechanical')"
          class="mb-8 pa-6"
          elevation="2"
        >
          <v-card-title class="text-h6 mb-4"
            >Mechanical Documents Form</v-card-title
          >
          <v-row dense>
            <v-col cols="12" md="6">
              <v-text-field
                label="Applicant Name"
                v-model="prepopulatedData.applicantFullName"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Project Address"
                v-model="prepopulatedData.projectFullAddress"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="HVAC System Type"
                v-model="hvacSystemType.value.value"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Elevator/Escalator Count"
                v-model="elevatorEscalatorCount.value.value"
                type="number"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card>

        <v-card
          v-if="selectedDocuments.includes('electronics')"
          class="mb-8 pa-6"
          elevation="2"
        >
          <v-card-title class="text-h6 mb-4"
            >Electronics Documents Form</v-card-title
          >
          <v-row dense>
            <v-col cols="12" md="6">
              <v-text-field
                label="Applicant Name"
                v-model="prepopulatedData.applicantFullName"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Project Address"
                v-model="prepopulatedData.projectFullAddress"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="CCTV Camera Count"
                v-model="cctvCameraCount.value.value"
                type="number"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Fire Alarm System Type"
                v-model="fireAlarmSystemType.value.value"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card>

        <v-card
          v-if="selectedDocuments.includes('geodetic')"
          class="mb-8 pa-6"
          elevation="2"
        >
          <v-card-title class="text-h6 mb-4"
            >Geodetic Documents Form</v-card-title
          >
          <v-row dense>
            <v-col cols="12" md="6">
              <v-text-field
                label="Applicant Name"
                v-model="prepopulatedData.applicantFullName"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Project Address"
                v-model="prepopulatedData.projectFullAddress"
                readonly
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Survey Type"
                v-model="surveyType.value.value"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-textarea
                label="Boundary Descriptions"
                v-model="boundaryDescriptions.value.value"
                density="compact"
                variant="outlined"
              ></v-textarea>
            </v-col>
          </v-row>
        </v-card>

        <!-- Buttons for Stepper 2 -->
        <v-row justify="end" class="mt-4">
          <v-col cols="auto">
            <v-btn color="grey-darken-1" @click="handleResetDocumentForms"
              >Reset Forms</v-btn
            >
          </v-col>
          <v-col cols="auto">
            <v-btn color="primary" type="submit">Download Forms</v-btn>
          </v-col>
        </v-row>
      </v-form>
    </div>

    <!-- Content for Stepper 3 (Uploading of Documents) -->
    <div v-show="step === 3">
      <v-card class="mb-8 pa-6" elevation="2">
        <v-card-title class="text-h6 mb-4">Upload Documents</v-card-title>
        <v-card-text>
          <p>
            This is where you will upload the actual files for the documents you
            selected in the previous step.
          </p>
          <!-- Specific input for uploading the Unified Application Form PDF (now supports multiple) -->
          <v-file-input
            label="Upload Notarized Unified Application Form (PDF)"
            accept="application/pdf"
            v-model="unifiedApplicationPdf"
            multiple
            variant="outlined"
            prepend-icon="mdi-file-pdf-box"
            clearable
            class="mb-4"
          ></v-file-input>

          <!-- Dynamically generated file inputs based on selectedDocuments (now supports multiple) -->
          <div v-for="docType in selectedDocuments" :key="docType" class="mb-4">
            <v-file-input
              :label="`Upload ${docType
                .replace('_', ' ')
                .split(' ')
                .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ')} (PDFs)`"
              accept="application/pdf"
              multiple
              variant="outlined"
              prepend-icon="mdi-paperclip"
              clearable
            ></v-file-input>
          </div>
          <p v-if="selectedDocuments.length === 0 && !unifiedApplicationPdf">
            Please select documents in the Document Forms step to enable
            uploads, or upload the Notarized Unified Application Form PDF.
          </p>
        </v-card-text>
      </v-card>
    </div>

    <!-- Buttons for Overall Stepper Navigation -->
    <v-row justify="end" class="mt-4">
      <v-col cols="auto">
        <v-btn v-if="step > 1" @click="step--" color="grey-darken-1"
          >Previous Step</v-btn
        >
      </v-col>
      <v-col cols="auto">
        <!-- Removed "Next Step" button from here as per request -->
        <v-btn v-if="step === 3" color="success" @click="finalizeApplication"
          >Finalize Application</v-btn
        >
      </v-col>
    </v-row>

    <!-- Application Number Dialog -->
    <v-dialog v-model="showApplicationDialog" max-width="500">
      <v-card>
        <v-card-title class="headline text-h5"
          >Application Submitted!</v-card-title
        >
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
import { ref, reactive, computed, watch } from "vue";
import { useField, useForm } from "vee-validate";

const step = ref(1); // Controls the current stepper step
const showApplicationDialog = ref(false); // Controls dialog visibility
const applicationNumber = ref(""); // Stores the generated application number

// Reactive object to store pre-populated data from Unified Application Form (Step 1)
const prepopulatedData = reactive({
  applicantFullName: "",
  projectFullAddress: "",
  // Add other fields you want to pre-populate from Step 1 here
});

// --- Stepper 2 Checklist for Documents ---
const selectedDocuments = ref([]); // Stores selected document types (e.g., ['architectural', 'electrical'])

// Define document options for checklist
const documentChecklistOptions = [
  { label: "Architectural Document", value: "architectural" },
  { label: "Civil/Structural Documents", value: "civil_structural" },
  { label: "Electrical Documents", value: "electrical" },
  { label: "Sanitary Documents", value: "sanitary" },
  { label: "Plumbing Documents", value: "plumbing" },
  { label: "Mechanical Documents", value: "mechanical" },
  { label: "Electronics Documents", value: "electronics" },
  { label: "Geodetic Documents", value: "geodetic" },
];

// --- File upload for Unified Application Form PDF (now accepts multiple) ---
const unifiedApplicationPdf = ref([]); // Changed to array to hold multiple files

// --- Form Fields and Validation for Step 1 ---
const { handleSubmit, handleReset } = useForm({
  validationSchema: {
    group1(value) {
      return !!value || "Application Type is required.";
    },
    group2(value) {
      return !!value || "Application Status is required.";
    },
    scopeOfWork(value) {
      return (
        (value && value.length > 0) ||
        "Please select at least one Scope of Work."
      );
    },
    otherScopeOfWork(value, { form }) {
      // Use form for conditional validation
      if (form.scopeOfWork && form.scopeOfWork.includes("Others") && !value) {
        return "Specification is required when 'Others' is selected.";
      }
      return true;
    },
    occupancyGroup(value) {
      return !!value || "Occupancy Group is required.";
    },
    occupancyType(value) {
      return !!value || "Occupancy Type is required.";
    },
    otherOccupancyType(value, { form }) {
      // Use form for conditional validation
      if (form.occupancyType === "Others" && !value) {
        return "Specification is required when 'Others' is selected.";
      }
      return true;
    },
    firstName(value) {
      return (
        (value && value.length >= 2) ||
        "First Name needs to be at least 2 characters."
      );
    },
    middleName(value) {
      return (
        !value ||
        value.length >= 1 ||
        "Middle Name must be at least 1 character if provided."
      );
    },
    lastName(value) {
      return (
        (value && value.length >= 2) ||
        "Last Name needs to be at least 2 characters."
      );
    },
    tin(value) {
      return (
        !value ||
        /^\d{3}-\d{3}-\d{3}-\d{3}$|^\d{9}$/.test(value) ||
        "TIN must be a valid format (e.g., 123-456-789-000 or 123456789)."
      );
    },
    contactNumber(value) {
      return (
        !value ||
        /^\d{7,}$/.test(value) ||
        "Contact number needs to be at least 7 digits and contain only numbers."
      );
    },
    numberOfUnits(value) {
      return (
        !value ||
        (/^\d+$/.test(value) && value >= 0) ||
        "Number of Units must be a non-negative number."
      );
    },
    numberOfStorey(value) {
      return (
        !value ||
        (/^\d+$/.test(value) && value >= 0) ||
        "Number of Storey must be a non-negative number."
      );
    },
    totalFloorArea(value) {
      return (
        !value ||
        (/^\d+(\.\d+)?$/.test(value) && value >= 0) ||
        "Total Floor Area must be a non-negative number."
      );
    },
    lotArea(value) {
      return (
        !value ||
        (/^\d+(\.\d+)?$/.test(value) && value >= 0) ||
        "Lot Area must be a non-negative number."
      );
    },
    costBuilding(value) {
      return (
        !value ||
        (/^\d+(\.\d+)?$/.test(value) && value >= 0) ||
        "Building cost must be a non-negative number."
      );
    },
    costElectrical(value) {
      return (
        !value ||
        (/^\d+(\.\d+)?$/.test(value) && value >= 0) ||
        "Electrical cost must be a non-negative number."
      );
    },
    costMechanical(value) {
      return (
        !value ||
        (/^\d+(\.\d+)?$/.test(value) && value >= 0) ||
        "Mechanical cost must be a non-negative number."
      );
    },
    costElectronics(value) {
      return (
        !value ||
        (/^\d+(\.\d+)?$/.test(value) && value >= 0) ||
        "Electronics cost must be a non-negative number."
      );
    },
    costPlumbing(value) {
      return (
        !value ||
        (/^\d+(\.\d+)?$/.test(value) && value >= 0) ||
        "Plumbing cost must be a non-negative number."
      );
    },
    costEquipment(value) {
      return (
        !value ||
        (/^\d+(\.\d+)?$/.test(value) && value >= 0) ||
        "Equipment cost must be a non-negative number."
      );
    },
    inspectorAddress(value) {
      return !!value || "Inspector Address is required.";
    },
    architectCivilEngineerName(value) {
      return !!value || "Architect/Civil Engineer Name is required.";
    },
    architectEngineerSignatureDate(value) {
      return !!value || "Architect/Civil Engineer Signature Date is required.";
    },
    prcNo(value) {
      return !!value || "PRC No. is required.";
    },
    prcValidity(value) {
      return !!value || "PRC Validity is required.";
    },
    ptrNo(value) {
      return !!value || "PTR No. is required.";
    },
    ptrDateIssued(value) {
      return !!value || "Date Issued is required.";
    },
    ptrIssuedAt(value) {
      return !!value || "Issued at is required.";
    },
    inspectorTin(value) {
      return !!value || "TIN is required.";
    },
    box3ApplicantName(value) {
      return !!value || "Applicant Name is required.";
    },
    box3ApplicantSignatureDate(value) {
      return !!value || "Applicant Signature Date is required.";
    },
    box3ApplicantAddress(value) {
      return !!value || "Applicant Address is required.";
    },
    box3ApplicantGovtIdNo(value) {
      return !!value || "Gov't ID No. is required.";
    },
    box3ApplicantIdDateIssued(value) {
      return !!value || "Date Issued is required.";
    },
    box3ApplicantIdPlaceIssued(value) {
      return !!value || "Place Issued is required.";
    },
    box4LotOwnerRepName(value) {
      return !!value || "Lot Owner/Rep Name is required.";
    },
    box4LotOwnerRepSignatureDate(value) {
      return !!value || "Lot Owner/Rep Signature Date is required.";
    },
    box4LotOwnerRepAddress(value) {
      return !!value || "Lot Owner/Rep Address is required.";
    },
    box4LotOwnerRepGovtIdNo(value) {
      return !!value || "Gov't ID No. is required.";
    },
    box4LotOwnerRepIdDateIssued(value) {
      return !!value || "Date Issued is required.";
    },
    box4LotOwnerRepIdPlaceIssued(value) {
      return !!value || "Place Issued is required.";
    },
  },
});

// --- UseField for all form models ---
const group1 = useField("group1");
const group2 = useField("group2");

const scopeOfWork = useField("scopeOfWork", undefined, { initialValue: [] }); // Multi-select starts as empty array
const otherScopeOfWork = useField("otherScopeOfWork");

const occupancyGroup = useField("occupancyGroup");
const occupancyType = useField("occupancyType");
const otherOccupancyType = useField("otherOccupancyType");

// Applicant and Construction Details Fields
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

// Occupancy and Cost Details Fields
const occupancyClassified = useField("occupancyClassified");
const numberOfUnits = useField("numberOfUnits");
const numberOfStorey = useField("numberOfStorey");
const totalFloorArea = useField("totalFloorArea");
const lotArea = useField("lotArea");
const costBuilding = useField("costBuilding");
const costElectrical = useField("costElectrical");
const costMechanical = useField("costMechanical");
const costElectronics = useField("electronics");
const costPlumbing = useField("plumbing");
const costEquipment = useField("costEquipment");
const proposedDate = useField("proposedDate");
const expectedDate = useField("expectedDate");

// NEW FIELDS from image_8dce7a.png
const inspectorAddress = useField("inspectorAddress");
const architectCivilEngineerName = useField("architectCivilEngineerName");
const architectEngineerSignatureDate = useField(
  "architectEngineerSignatureDate"
);
const prcNo = useField("prcNo");
const prcValidity = useField("prcValidity");
const ptrNo = useField("ptrNo");
const ptrDateIssued = useField("ptrDateIssued");
const ptrIssuedAt = useField("ptrIssuedAt");
const inspectorTin = useField("inspectorTin");
const box3ApplicantName = useField("box3ApplicantName");
const box3ApplicantSignatureDate = useField("box3ApplicantSignatureDate");
const box3ApplicantAddress = useField("box3ApplicantAddress");
const box3ApplicantGovtIdNo = useField("box3ApplicantGovtIdNo");
const box3ApplicantIdDateIssued = useField("box3ApplicantIdDateIssued");
const box3ApplicantIdPlaceIssued = useField("box3ApplicantIdPlaceIssued");
const box4LotOwnerRepName = useField("box4LotOwnerRepName");
const box4LotOwnerRepSignatureDate = useField("box4LotOwnerRepSignatureDate");
const box4LotOwnerRepAddress = useField("box4LotOwnerRepAddress");
const box4LotOwnerRepGovtIdNo = useField("box4LotOwnerRepGovtIdNo");
const box4LotOwnerRepIdDateIssued = useField("box4LotOwnerRepIdDateIssued");
const box4LotOwnerRepIdPlaceIssued = useField("box4LotOwnerRepIdPlaceIssued");

// --- NEW FIELDS for Document Forms (Stepper 2) ---
const architecturalProjectType = useField("architecturalProjectType");
const architecturalScopeDetails = useField("architecturalScopeDetails");
const structuralType = useField("structuralType");
const civilStructuralNotes = useField("civilStructuralNotes");
const electricalLoad = useField("electricalLoad");
const numberOfOutlets = useField("numberOfOutlets");
const waterSupplySource = useField("waterSupplySource");
const wasteDisposalMethod = useField("wasteDisposalMethod");
const numberOfFixtures = useField("numberOfFixtures");
const plumbingSystemType = useField("plumbingSystemType");
const hvacSystemType = useField("hvacSystemType");
const elevatorEscalatorCount = useField("elevatorEscalatorCount");
const cctvCameraCount = useField("cctvCameraCount");
const fireAlarmSystemType = useField("fireAlarmSystemType");
const surveyType = useField("surveyType");
const boundaryDescriptions = useField("boundaryDescriptions");

// --- Options for Combo Boxes ---
const scopeOfWorkOptions = [
  "NEW CONSTRUCTION",
  "RENOVATION",
  "RAISING",
  "ERECTION",
  "CONVERSION",
  "ACCESSORY BUILDING/STRUCTURE",
  "ADDITION",
  "REPAIR",
  "LEGALIZATION OF EXISTING BUILDING",
  "ALTERATION",
  "MOVING",
  "DEMOLITION",
  "Others",
];

const occupancyGroupOptions = [
  "GROUP A: RESIDENTIAL (DWELLINGS)",
  "GROUP B: RESIDENTIAL",
  "GROUP C: EDUCATIONAL & RECREATIONAL",
  "GROUP D: INSTITUTIONAL",
  "GROUP E: COMMERCIAL",
  "GROUP F: LIGHT INDUSTRIAL",
  "GROUP G: MEDIUM INDUSTRIAL",
  "GROUP H: ASSEMBLY (OCCUPANT LOAD LESS THAN 1,000)",
  "GROUP I: ASSEMBLY (OCCUPANT LOAD 1,000 OR MORE)",
  "GROUP J: (J-1) AGRICULTURAL",
  "GROUP J: (J-2) ACCESSORIES",
];

const occupancyTypesByGroup = {
  "GROUP A: RESIDENTIAL (DWELLINGS)": [
    "Single",
    "Duplex",
    "Residential R-1, R-2",
    "Others",
  ],
  "GROUP B: RESIDENTIAL": [
    "Hotel",
    "Motel",
    "Dormitory",
    "Townhouse",
    "Boardinghouse",
    "Lodging House",
    "Residential R-3, R-4, R-5",
    "Others",
  ],
  "GROUP C: EDUCATIONAL & RECREATIONAL": [
    "School Building",
    "School Auditorium",
    "Civic Center",
    "Gymnasium",
    "Clubhouse",
    "Church, Mosque, Temple, Chapel",
    "Others",
  ],
  "GROUP D: INSTITUTIONAL": [
    "Hospital or Similar Structure",
    "Home for the Aged",
    "Government Office",
    "Others",
  ],
  "GROUP E: COMMERCIAL": [
    "Bank",
    "Store",
    "Shopping Center/Mall",
    "Drinking/Dining Establishment",
    "Shop (i.e. Dress Shop, Tailoring, Barbershop, etc.)",
    "Others",
  ],
  "GROUP F: LIGHT INDUSTRIAL": [
    "Factory/Plant (Using Incombustible/Non-Explosive Materials)",
    "Others",
  ],
  "GROUP G: MEDIUM INDUSTRIAL": [
    "Storage/Warehouse (For Hazardous/Highly Flammable Materials)",
    "Factory (For Hazardous/Highly Flammable Materials)",
    "Others",
  ],
  "GROUP H: ASSEMBLY (OCCUPANT LOAD LESS THAN 1,000)": [
    "Theater, Auditorium, Convention Hall",
    "Grandstand/Bleacher",
    "Others",
  ],
  "GROUP I: ASSEMBLY (OCCUPANT LOAD 1,000 OR MORE)": [
    "Coliseum, Sports Complex",
    "Convention Center and Similar Structure",
    "Others",
  ],
  "GROUP J: (J-1) AGRICULTURAL": [
    "Barn, Granary, Poultry House",
    "Piggery, Grain Mill, Grain Silo",
    "Others",
  ],
  "GROUP J: (J-2) ACCESSORIES": [
    "Private Carport/Garage, Tower",
    "Swimming Pool, Fence Over 1.80m",
    "Steel/Concrete Tank",
    "Others",
  ],
};

const currentOccupancyTypeOptions = computed(() => {
  return occupancyGroup.value.value
    ? occupancyTypesByGroup[occupancyGroup.value.value]
    : [];
});

// Watch for changes in occupancyGroup to reset occupancyType
watch(
  () => occupancyGroup.value.value,
  (newGroup, oldGroup) => {
    if (newGroup !== oldGroup) {
      occupancyType.value.value = null; // Reset type when group changes
      otherOccupancyType.value.value = ""; // Clear other specification
    }
  }
);
watch(
  () => occupancyType.value.value,
  (newType) => {
    if (newType !== "Others") {
      otherOccupancyType.value.value = ""; // Clear other specification if "Others" is deselected
    }
  }
);

// Function to handle submission of Unified Application Form (Step 1)
const submitUnifiedApplication = handleSubmit((values) => {
  console.log("Unified Application Form Submitted:", values);

  // Populate prepopulatedData for AncillaryForms in Step 2
  prepopulatedData.applicantFullName = `${values.firstName || ""} ${
    values.middleName || ""
  } ${values.lastName || ""}`.trim();
  prepopulatedData.projectFullAddress = `${values.constructionStreet || ""}, ${
    values.constructionBarangay || ""
  }, ${values.constructionMunicipal || ""}`.trim();

  // Generate and show application number (can be moved to final submission if preferred)
  const timestamp = Date.now();
  const randomSuffix = Math.floor(Math.random() * 1000);
  applicationNumber.value = `BP-UAF-${timestamp}-${randomSuffix}`; // Example: Building Permit Unified Application Form

  showApplicationDialog.value = true;
  step.value++; // Advance to the next step (Document Forms)
});

// Function to close the application number dialog
const closeApplicationDialog = () => {
  showApplicationDialog.value = false;
};

// Function to handle downloading of Document Forms (Step 2)
const handleResetDocumentForms = () => {
  // Reset all fields in the ancillary document forms
  architecturalProjectType.value.value = "";
  architecturalScopeDetails.value.value = "";
  structuralType.value.value = "";
  civilStructuralNotes.value.value = "";
  electricalLoad.value.value = null;
  numberOfOutlets.value.value = null;
  waterSupplySource.value.value = "";
  wasteDisposalMethod.value.value = "";
  numberOfFixtures.value.value = null;
  plumbingSystemType.value.value = "";
  hvacSystemType.value.value = "";
  elevatorEscalatorCount.value.value = null;
  cctvCameraCount.value.value = null;
  fireAlarmSystemType.value.value = "";
  surveyType.value.value = "";
  boundaryDescriptions.value.value = "";
  selectedDocuments.value = []; // Clear selected checkboxes for document types
};

const downloadForms = async () => {
  // Manual validation for conditional forms if needed, otherwise VeeValidate's handleSubmit will handle it.
  // For this consolidated App.vue, we'll just proceed with generating the JSON.
  if (selectedDocuments.value.length === 0) {
    alert("Please select at least one document type to download forms.");
    return;
  }

  const formData = {
    unifiedApplication: {
      group1: group1.value.value,
      group2: group2.value.value,
      firstName: firstName.value.value,
      middleName: middleName.value.value,
      lastName: lastName.value.value,
      tin: tin.value.value,
      enterpriseOwner: enterpriseOwner.value.value,
      formOwnership: formOwnership.value.value,
      ownerAddressNo: ownerAddressNo.value.value,
      ownerAddressStreet: ownerAddressStreet.value.value,
      ownerAddressBarangay: ownerAddressBarangay.value.value,
      ownerAddressMunicipal: ownerAddressMunicipal.value.value,
      ownerAddressZipCode: ownerAddressZipCode.value.value,
      contactNumber: contactNumber.value.value,
      lotNo: lotNo.value.value,
      blkNo: blkNo.value.value,
      tctNo: tctNo.value.value,
      taxDecNo: taxDecNo.value.value,
      constructionStreet: constructionStreet.value.value,
      constructionBarangay: constructionBarangay.value.value,
      constructionMunicipal: constructionMunicipal.value.value,
      scopeOfWork: scopeOfWork.value.value,
      otherScopeOfWork: otherScopeOfWork.value.value,
      occupancyGroup: occupancyGroup.value.value,
      occupancyType: occupancyType.value.value,
      otherOccupancyType: otherOccupancyType.value.value,
      occupancyClassified: occupancyClassified.value.value,
      numberOfUnits: numberOfUnits.value.value,
      numberOfStorey: numberOfStorey.value.value,
      totalFloorArea: totalFloorArea.value.value,
      lotArea: lotArea.value.value,
      costBuilding: costBuilding.value.value,
      costElectrical: costElectrical.value.value,
      costMechanical: costMechanical.value.value,
      costElectronics: costElectronics.value.value,
      costPlumbing: costPlumbing.value.value,
      costEquipment: costEquipment.value.value,
      proposedDate: proposedDate.value.value,
      expectedDate: expectedDate.value.value,
      inspectorAddress: inspectorAddress.value.value,
      architectCivilEngineerName: architectCivilEngineerName.value.value,
      architectEngineerSignatureDate:
        architectEngineerSignatureDate.value.value,
      prcNo: prcNo.value.value,
      prcValidity: prcValidity.value.value,
      ptrNo: ptrNo.value.value,
      ptrDateIssued: ptrDateIssued.value.value,
      ptrIssuedAt: ptrIssuedAt.value.value,
      inspectorTin: inspectorTin.value.value,
      box3ApplicantName: box3ApplicantName.value.value,
      box3ApplicantSignatureDate: box3ApplicantSignatureDate.value.value,
      box3ApplicantAddress: box3ApplicantAddress.value.value,
      box3ApplicantGovtIdNo: box3ApplicantGovtIdNo.value.value,
      box3ApplicantIdDateIssued: box3ApplicantIdDateIssued.value.value,
      box3ApplicantIdPlaceIssued: box3ApplicantIdPlaceIssued.value.value,
      box4LotOwnerRepName: box4LotOwnerRepName.value.value,
      box4LotOwnerRepSignatureDate: box4LotOwnerRepSignatureDate.value.value,
      box4LotOwnerRepAddress: box4LotOwnerRepAddress.value.value,
      box4LotOwnerRepGovtIdNo: box4LotOwnerRepGovtIdNo.value.value,
      box4LotOwnerRepIdDateIssued: box4LotOwnerRepIdDateIssued.value.value,
      box4LotOwnerRepIdPlaceIssued: box4LotOwnerRepIdPlaceIssued.value.value,
    },
    ancillaryDocuments: {},
  };

  for (const docType of selectedDocuments.value) {
    let docData = {
      applicantName: prepopulatedData.applicantFullName,
      projectAddress: prepopulatedData.projectFullAddress,
    };

    // Add specific data for each document type
    switch (docType) {
      case "architectural":
        docData.projectType = architecturalProjectType.value.value;
        docData.scopeDetails = architecturalScopeDetails.value.value;
        break;
      case "civil_structural":
        docData.structuralType = structuralType.value.value;
        docData.notes = civilStructuralNotes.value.value;
        break;
      case "electrical":
        docData.electricalLoad = electricalLoad.value.value;
        docData.numberOfOutlets = numberOfOutlets.value.value;
        break;
      case "sanitary":
        docData.waterSupplySource = waterSupplySource.value.value;
        docData.wasteDisposalMethod = wasteDisposalMethod.value.value;
        break;
      case "plumbing":
        docData.numberOfFixtures = numberOfFixtures.value.value;
        docData.systemType = plumbingSystemType.value.value;
        break;
      case "mechanical":
        docData.hvacSystemType = hvacSystemType.value.value;
        docData.elevatorEscalatorCount = elevatorEscalatorCount.value.value;
        break;
      case "electronics":
        docData.cctvCameraCount = cctvCameraCount.value.value;
        docData.fireAlarmSystemType = fireAlarmSystemType.value.value;
        break;
      case "geodetic":
        docData.surveyType = surveyType.value.value;
        docData.boundaryDescriptions = boundaryDescriptions.value.value;
        break;
    }
    formData.ancillaryDocuments[docType] = docData;
  }

  const filename = `Building_Permit_Application_Data_${Date.now()}.json`;
  const jsonStr = JSON.stringify(formData, null, 2);
  const blob = new Blob([jsonStr], { type: "application/json" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = filename;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);

  alert(
    "Selected forms data downloaded successfully as JSON! For visually complete, pre-filled forms, a backend service or specialized client-side library with templates would be needed."
  );
};

// Function to handle advancing to the next step
const advanceStep = () => {
  // Only allow advancing if current step 1 is submitted (handled by submitUnifiedApplication)
  // or if current step 2 has at least one document selected.
  if (step.value === 2 && selectedDocuments.value.length === 0) {
    alert("Please select at least one document type to proceed to uploads.");
  } else {
    step.value++;
  }
};

// Placeholder for finalizing the overall application (after all steps are done)
const finalizeApplication = () => {
  alert(
    "Overall application finalized! This would trigger final submission logic for all steps."
  );
  // In a real app, gather data from all steps and send to backend
  // You might want to reset the entire process or redirect after this.
};
</script>

<style scoped>
.v-stepper-header {
  box-shadow: none !important;
}
.border {
  border: 1px solid #e0e0e0; /* Light grey border */
}
.underline-static {
  border-bottom: 1px solid black;
  display: inline-block;
  min-width: 80px; /* Default width, adjust as needed */
  vertical-align: middle; /* Align the underline with the text baseline */
  height: 1em; /* Ensure sufficient height for the underline to be visible below text */
}

/* Specific adjustments for longer underlines if needed */
.underline-static[style*="min-width: 150px;"] {
  min-width: 150px;
}
.underline-static[style*="min-width: 200px;"] {
  min-width: 200px;
}
.underline-static[style*="min-width: 300px;"] {
  min-width: 300px;
}
</style>
