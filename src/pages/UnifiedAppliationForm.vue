<template>
  <v-container>
    <v-row class="mb-8">
      <v-col cols="12">
        <div class="d-flex align-center justify-center stepper-container">
          <div class="stepper-item active">
            <v-icon class="stepper-icon">mdi-numeric-1-circle</v-icon>
            <span class="stepper-text">Unified Application Form</span>
          </div>
          <div class="stepper-line"></div>
          <div class="stepper-item">
            <v-icon class="stepper-icon">mdi-pencil-circle</v-icon>
            <span class="stepper-text">Document Forms</span>
          </div>
          <div class="stepper-line"></div>
          <div class="stepper-item">
            <v-icon class="stepper-icon">mdi-numeric-3-circle</v-icon>
            <span class="stepper-text">Uploading of Documents</span>
          </div>
        </div>
      </v-col>
    </v-row>

    <v-card class="mb-8 pa-6" elevation="2">
      <v-card-title class="text-h5 text-center text-blue-darken-2 mb-4">
        BUILDING PERMIT APPLICATION
      </v-card-title>
      <v-divider class="mb-6"></v-divider>

      <v-form @submit.prevent="submitUnifiedApplication">
        <v-row dense>
          <v-col cols="12">
            <v-row dense class="mb-4">
              <v-col cols="12" md="6">
                <v-card flat border>
                  <v-card-title class="text-subtitle-1 pb-0 text-grey-darken-1">
                    Application Type
                  </v-card-title>
                  <v-card-text>
                    <v-radio-group
                      v-model="applicationType.value.value"
                      density="compact"
                      hide-details="auto"
                      row
                    >
                      <v-row>
                        <v-col>
                          <v-radio label="Simple" value="Simple"></v-radio>
                        </v-col>
                        <v-col>
                          <v-radio label="Complex" value="Complex"></v-radio>
                        </v-col>
                      </v-row>
                    </v-radio-group>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col cols="12" md="6">
                <v-card flat border>
                  <v-card-title class="text-subtitle-1 pb-0 text-grey-darken-1">
                    Application Status
                  </v-card-title>
                  <v-card-text>
                    <v-radio-group
                      v-model="applicationStatus.value.value"
                      density="compact"
                      hide-details="auto"
                      row
                    >
                      <v-row>
                        <v-col>
                          <v-radio label="New" value="NEW"></v-radio>
                        </v-col>
                        <v-col>
                          <v-radio label="Renewal" value="RENEWAL"></v-radio>
                        </v-col>
                        <v-col>
                          <v-radio label="Amended" value="AMENDED"></v-radio>
                        </v-col>
                      </v-row>
                    </v-radio-group>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-col>

          <v-col cols="12" class="text-h6 mb-2"
            >Owner/Applicant Information</v-col
          >
          <v-divider class="mb-4"></v-divider>
          <v-col cols="12" md="3">
            <v-text-field
              label="Last Name"
              v-model="lastName.value.value"
              density="compact"
              variant="outlined"
              :error-messages="lastName.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field
              label="First Name"
              v-model="firstName.value.value"
              density="compact"
              variant="outlined"
              :error-messages="firstName.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field
              label="M.I."
              v-model="middleName.value.value"
              density="compact"
              variant="outlined"
              :error-messages="middleName.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field
              label="TIN"
              v-model="tin.value.value"
              placeholder="e.g., 123-456-789-000"
              density="compact"
              variant="outlined"
              :error-messages="tin.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-checkbox
              label="For Construction Owned by an Enterprise"
              v-model="isEnterpriseOwned"
              density="compact"
              hide-details="auto"
            ></v-checkbox>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Form of Ownership"
              v-model="formOwnership.value.value"
              density="compact"
              variant="outlined"
              :disabled="!isEnterpriseOwned"
              :error-messages="formOwnership.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="2">
            <v-text-field
              label="No."
              v-model="ownerAddressNo.value.value"
              density="compact"
              variant="outlined"
              :error-messages="ownerAddressNo.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-autocomplete
              label="Street"
              :items="streetOptions"
              v-model="ownerAddressStreet.value.value"
              density="compact"
              variant="outlined"
              :error-messages="ownerAddressStreet.errorMessage.value"
            ></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3">
            <v-select
              label="Barangay"
              :items="barangayOptions"
              v-model="ownerAddressBarangay.value.value"
              density="compact"
              variant="outlined"
              :error-messages="ownerAddressBarangay.errorMessage.value"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field
              label="City/Municipal"
              v-model="ownerAddressMunicipal.value.value"
              density="compact"
              variant="outlined"
              placeholder="Naga City"
              readonly
              :error-messages="ownerAddressMunicipal.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Zip Code"
              v-model="ownerAddressZipCode.value.value"
              density="compact"
              variant="outlined"
              :error-messages="ownerAddressZipCode.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Contact Number"
              v-model="contactNumber.value.value"
              density="compact"
              variant="outlined"
              :error-messages="contactNumber.errorMessage.value"
            ></v-text-field>
          </v-col>

          <v-col cols="12" class="text-h6 mb-2">Location of Construction</v-col>
          <v-divider class="mb-4"></v-divider>
          <v-col cols="12" md="3">
            <v-text-field
              label="Lot No."
              v-model="lotNo.value.value"
              density="compact"
              variant="outlined"
              :error-messages="lotNo.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field
              label="Blk No."
              v-model="blkNo.value.value"
              density="compact"
              variant="outlined"
              :error-messages="blkNo.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field
              label="TCT No."
              v-model="tctNo.value.value"
              density="compact"
              variant="outlined"
              :error-messages="tctNo.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field
              label="Current Tax Dec No."
              v-model="taxDecNo.value.value"
              density="compact"
              variant="outlined"
              :error-messages="taxDecNo.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-autocomplete
              label="Street"
              :items="streetOptions"
              v-model="constructionStreet.value.value"
              density="compact"
              variant="outlined"
              :error-messages="constructionStreet.errorMessage.value"
            ></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3">
            <v-select
              label="Barangay"
              :items="barangayOptions"
              v-model="constructionBarangay.value.value"
              density="compact"
              variant="outlined"
              :error-messages="constructionBarangay.errorMessage.value"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field
              label="City/Municipal"
              v-model="constructionMunicipal.value.value"
              density="compact"
              variant="outlined"
              placeholder="Naga City"
              readonly
              :error-messages="constructionMunicipal.errorMessage.value"
            ></v-text-field>
          </v-col>

          <v-col cols="12" class="text-h6 mb-2">Scope of Work</v-col>
          <v-divider class="mb-4"></v-divider>
          <v-col cols="12">
            <v-select
              label="Select Scope of Work"
              :items="scopeOfWorkOptions"
              v-model="scopeOfWork.value.value"
              density="compact"
              variant="outlined"
              multiple
              chips
              :error-messages="scopeOfWork.errorMessage.value"
            ></v-select>
          </v-col>
          <v-col
            cols="12"
            v-if="
              scopeOfWork.value.value &&
              scopeOfWork.value.value.includes('Others')
            "
          >
            <v-text-field
              label="Specify other Scope of Work"
              v-model="otherScopeOfWork.value.value"
              density="compact"
              variant="outlined"
              :error-messages="otherScopeOfWork.errorMessage.value"
            ></v-text-field>
          </v-col>

          <v-col cols="12" class="text-h6 mb-2"
            >Use or Character of Occupancy</v-col
          >
          <v-divider class="mb-4"></v-divider>
          <v-col cols="12" md="6">
            <v-select
              label="Select Occupancy Group"
              :items="occupancyGroupOptions"
              v-model="occupancyGroup.value.value"
              density="compact"
              variant="outlined"
              :error-messages="occupancyGroup.errorMessage.value"
            ></v-select>
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              label="Select Occupancy Type"
              :items="currentOccupancyTypeOptions"
              v-model="occupancyType.value.value"
              density="compact"
              variant="outlined"
              :disabled="!occupancyGroup.value.value"
              :error-messages="occupancyType.errorMessage.value"
            ></v-select>
          </v-col>
          <v-col cols="12" v-if="occupancyType.value.value === 'Others'">
            <v-text-field
              label="Specify other Occupancy Type"
              v-model="otherOccupancyType.value.value"
              density="compact"
              variant="outlined"
              :error-messages="otherOccupancyType.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              label="Occupancy Classified"
              v-model="occupancyClassified.value.value"
              density="compact"
              variant="outlined"
              :error-messages="occupancyClassified.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              label="Number of Units"
              v-model="numberOfUnits.value.value"
              onkeypress="return (event.charCode > 47 && event.charCode < 58)"
              inputmode="numeric"
              pattern="\d*"
              density="compact"
              variant="outlined"
              :error-messages="numberOfUnits.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              label="Number of Storey"
              v-model="numberOfStorey.value.value"
              onkeypress="return (event.charCode > 47 && event.charCode < 58)"
              inputmode="numeric"
              pattern="\d*"
              density="compact"
              variant="outlined"
              :error-messages="numberOfStorey.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Total Floor Area (sq.m.)"
              v-model="totalFloorArea.value.value"
              onkeypress="return (event.charCode > 47 && event.charCode < 58 ||
                event.charCode === 46)"
              inputmode="numeric"
              pattern="[0-9]*[.]?[0-9]*"
              density="compact"
              variant="outlined"
              :error-messages="totalFloorArea.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Lot Area (sq.m.)"
              v-model="lotArea.value.value"
              onkeypress="return (event.charCode > 47 && event.charCode < 58 || event.charCode === 46)"
              inputmode="numeric"
              pattern="[0-9]*[.]?[0-9]*"
              density="compact"
              variant="outlined"
              :error-messages="lotArea.errorMessage.value"
            ></v-text-field>
          </v-col>

          <v-col cols="12" class="text-h6 mb-2">TOTAL ESTIMATED COST (₱)</v-col>
          <v-divider class="mb-4"></v-divider>
          <v-col cols="12" md="4">
            <v-text-field
              label="Building"
              v-model="displayCostBuilding"
              @focus="onCostFocus(costBuilding, displayCostBuilding)"
              @blur="onCostBlur(costBuilding, displayCostBuilding)"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costBuilding.errorMessage.value"
              inputmode="decimal"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              label="Electrical"
              v-model="displayCostElectrical"
              @focus="onCostFocus(costElectrical, displayCostElectrical)"
              @blur="onCostBlur(costElectrical, displayCostElectrical)"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costElectrical.errorMessage.value"
              inputmode="decimal"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              label="Mechanical"
              v-model="displayCostMechanical"
              @focus="onCostFocus(costMechanical, displayCostMechanical)"
              @blur="onCostBlur(costMechanical, displayCostMechanical)"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costMechanical.errorMessage.value"
              inputmode="decimal"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Electronics"
              v-model="displayCostElectronics"
              @focus="onCostFocus(costElectronics, displayCostElectronics)"
              @blur="onCostBlur(costElectronics, displayCostElectronics)"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costElectronics.errorMessage.value"
              inputmode="decimal"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Plumbing"
              v-model="displayCostPlumbing"
              @focus="onCostFocus(costPlumbing, displayCostPlumbing)"
              @blur="onCostBlur(costPlumbing, displayCostPlumbing)"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costPlumbing.errorMessage.value"
              inputmode="decimal"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Total Estimated Cost"
              :model-value="totalEstimatedCostFormatted"
              density="compact"
              variant="outlined"
              prefix="₱"
              readonly
            ></v-text-field>
          </v-col>

          <v-col cols="12" class="text-h6 mb-2"
            >COST OF EQUIPMENT INSTALLED (₱)</v-col
          >
          <v-divider class="mb-4"></v-divider>
          <v-col cols="12" md="6">
            <v-text-field
              label="P (Equipment)"
              v-model="displayCostEquipment"
              @focus="onCostFocus(costEquipment, displayCostEquipment)"
              @blur="onCostBlur(costEquipment, displayCostEquipment)"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costEquipment.errorMessage.value"
              inputmode="decimal"
            ></v-text-field>
          </v-col>

          <v-col cols="12" class="text-h6 mb-2">Project Timeline</v-col>
          <v-divider class="mb-4"></v-divider>
          <v-col cols="12" md="6">
            <v-text-field
              label="Proposed Date of Construction"
              v-model="proposedDate.value.value"
              type="date"
              density="compact"
              variant="outlined"
              :error-messages="proposedDate.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Expected Date of Completion"
              v-model="expectedDate.value.value"
              type="date"
              density="compact"
              variant="outlined"
              :error-messages="expectedDate.errorMessage.value"
            ></v-text-field>
          </v-col>

          <v-col cols="12" class="text-h6 mb-2 text-center">
            AFFIDAVIT OF FULL-TIME INSPECTOR AND SUPERVISOR OF CONSTRUCTION
            WORKS
          </v-col>
          <v-col cols="12">
            <v-card class="mb-4 pa-4" elevation="1">
              <v-card-title class="text-subtitle-1 mb-2">
                BOX 2: FULL-TIME INSPECTOR AND SUPERVISOR OF CONSTRUCTION WORKS
                (REPRESENTING THE OWNER)
              </v-card-title>
              <v-row dense>
                <v-col cols="12" md="6">
                  <div class="d-flex flex-column mt-16">
                    <span
                      class="acknowledgment-line-long d-block mb-1 mx-auto"
                    ></span>
                    <p class="text-body-2 text-center">Architect or Engineer</p>
                    <p class="text-body-2 text-center">
                      (Signed and Sealed Over Printed Name)
                    </p>

                    <div class="d-flex align-baseline mt-4">
                      <span class="text-body-2 mr-2">Date</span>
                      <v-text-field variant="underlined"></v-text-field>
                    </div>
                  </div>
                </v-col>

                <v-col cols="12" md="6">
                  <div class="d-flex flex-column mb-4">
                    <div class="d-flex align-baseline mb-2">
                      <span class="text-body-2 mr-2">Address</span>
                      <v-text-field
                        v-model="inspectorAddress.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                        class="flex-grow-1"
                      ></v-text-field>
                    </div>
                    <div class="d-flex align-baseline mb-2">
                      <span class="text-body-2 mr-2">PRC No.</span>
                      <v-text-field
                        v-model="prcNo.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                        class="flex-grow-1 mr-4"
                      ></v-text-field>
                      <span class="text-body-2 mr-2">Validity</span>
                      <v-text-field variant="underlined"></v-text-field>
                    </div>
                    <div class="d-flex align-baseline mb-2">
                      <span class="text-body-2 mr-2">PTR No.</span>
                      <v-text-field
                        v-model="ptrNo.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                        class="flex-grow-1 mr-4"
                      ></v-text-field>
                      <span class="text-body-2 mr-2">Date Issued</span>
                      <v-text-field
                        v-model="ptrDateIssued.value.value"
                        variant="underlined"
                      ></v-text-field>
                    </div>
                    <div class="d-flex align-baseline">
                      <span class="text-body-2 mr-2">Issued at</span>
                      <v-text-field
                        v-model="ptrIssuedAt.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                        class="flex-grow-1 mr-4"
                      ></v-text-field>
                      <span class="text-body-2 mr-2">TIN</span>
                      <v-text-field
                        v-model="inspectorTin.value.value"
                        placeholder="e.g., 123-456-789-000"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                        class="flex-grow-1"
                      ></v-text-field>
                    </div>
                  </div>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="12">
            <v-card class="mb-4 pa-4" elevation="1">
              <v-card-title class="text-subtitle-1 mb-2">
                BOX 3: APPLICANT
              </v-card-title>
              <v-row dense>
                <v-col cols="12" md="6">
                  <div class="d-flex flex-column mt-4">
                    <span
                      class="acknowledgment-line-long d-block mb-1 mx-auto"
                    ></span>
                    <p class="text-body-2 text-center">
                      (Signature Over Printed Name)
                    </p>
                    <div class="d-flex align-baseline mt-4">
                      <span class="text-body-2 mr-2">Date</span>
                      <v-text-field
                        v-model="box3ApplicantSignatureDate.value.value"
                        variant="underlined"
                      ></v-text-field>
                    </div>
                  </div>
                </v-col>

                <v-col cols="12" md="6">
                  <div class="d-flex flex-column mb-4">
                    <v-text-field
                      label="Address"
                      v-model="box3ApplicantAddress.value.value"
                      density="compact"
                      variant="underlined"
                      hide-details="auto"
                      class="my-3"
                    ></v-text-field>
                    <div class="d-flex align-baseline mb-2">
                      <v-text-field
                        label="Gov’t Issued ID No."
                        v-model="box3ApplicantGovtIdNo.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                        class="flex-grow-1 mr-2"
                      ></v-text-field>
                      <v-text-field
                        label="Date Issued"
                        v-model="box3ApplicantIdDateIssued.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                        class="mr-2"
                      ></v-text-field>
                      <v-text-field
                        label="Place Issued"
                        v-model="box3ApplicantIdPlaceIssued.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                      ></v-text-field>
                    </div>
                  </div>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="12">
            <v-card class="mb-4 pa-4" elevation="1">
              <v-card-title class="text-subtitle-1 mb-2">
                BOX 4: WITH MY CONSENT: LOT OWNER / AUTHORIZED REPRESENTATIVE
              </v-card-title>
              <v-row dense>
                <v-col cols="12" md="6">
                  <div class="d-flex flex-column mt-4">
                    <span
                      class="acknowledgment-line-long d-block mb-1 mx-auto"
                    ></span>
                    <p class="text-body-2 text-center">
                      (Signature Over Printed Name)
                    </p>
                    <div class="d-flex align-baseline mt-4">
                      <span class="text-body-2 mr-2">Date</span>
                      <v-text-field
                        v-model="box4LotOwnerRepSignatureDate.value.value"
                        variant="underlined"
                      ></v-text-field>
                    </div>
                  </div>
                </v-col>

                <v-col cols="12" md="6">
                  <div class="d-flex flex-column mb-4">
                    <v-text-field
                      label="Address"
                      v-model="box4LotOwnerRepAddress.value.value"
                      density="compact"
                      variant="underlined"
                      hide-details="auto"
                      class="my-3"
                    ></v-text-field>

                    <div class="d-flex align-baseline mb-2">
                      <v-text-field
                        label="Gov’t Issued ID No."
                        v-model="box4LotOwnerRepGovtIdNo.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                        class="flex-grow-1 mr-2"
                      ></v-text-field>
                      <v-text-field
                        label="Date Issued"
                        v-model="box4LotOwnerRepIdDateIssued.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                        class="mr-2"
                      ></v-text-field>
                      <v-text-field
                        label="Place Issued"
                        v-model="box4LotOwnerRepIdPlaceIssued.value.value"
                        density="compact"
                        variant="underlined"
                        hide-details="auto"
                      ></v-text-field>
                    </div>
                  </div>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="12">
            <v-card class="mb-4 pa-4" elevation="1">
              <v-card-title class="text-subtitle-1 mb-2">
                BOX 5: ACKNOWLEDGMENT / NOTARY PUBLIC
              </v-card-title>
              <v-card-text>
                <p class="text-body-2 mb-2 text-center">
                  <span class="font-weight-bold"
                    >REPUBLIC OF THE PHILIPPINES</span
                  ><br />
                </p>
                <p class="text-body-2 mb-2">
                  CITY/MUNICIPALITY OF
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field"
                  ></v-text-field>
                  S.S.
                </p>
                <p class="text-body-2 mb-2">
                  BEFORE ME, at the City/Municipalities of
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field"
                  ></v-text-field>
                  on
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field-short"
                  ></v-text-field>
                  personally appeared the following:
                </p>
                <p class="text-body-2 mb-2">
                  <span class="font-weight-bold"
                    >APPLICANT (Signature Over Printed Name)</span
                  ><br />
                  Full Name:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field-long"
                  ></v-text-field
                  ><br />
                  Gov't ID No.:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field"
                  ></v-text-field>
                  Date Issued:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field"
                  ></v-text-field>
                  Place Issued:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field"
                  ></v-text-field>
                </p>
                <p class="text-body-2 mb-2">
                  <span class="font-weight-bold"
                    >LICENSED ARCHITECT OR CIVIL ENGINEER (Full-Time Inspector
                    and Supervisor of Construction Works)</span
                  ><br />
                  Full Name:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field-long"
                  ></v-text-field
                  ><br />
                  Gov't ID No.:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field"
                  ></v-text-field>
                  Date Issued:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field"
                  ></v-text-field>
                  Place Issued:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field"
                  ></v-text-field>
                </p>
                <p class="text-body-2 mb-2">
                  whose signatures appear hereinabove, known to me to be the
                  same persons who executed this standard prescribed form and
                  acknowledged to me that the same is their free and voluntary
                  act and deed.
                </p>
                <p class="text-body-2 mb-2">
                  WITNESS MY HAND AND SEAL, on the date and place above written.
                </p>
                <p class="text-body-2 mb-2">
                  Doc. No.:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field-short"
                  ></v-text-field>
                  Page No.:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field-short"
                  ></v-text-field>
                  Book No.:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field-short"
                  ></v-text-field>
                  Series of:
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field-short"
                  ></v-text-field>
                </p>
                <p class="text-body-2 mb-2">
                  NOTARY PUBLIC (Until December
                  <v-text-field
                    variant="underlined"
                    hide-details="auto"
                    class="acknowledgment-field-short"
                  ></v-text-field>
                  )
                </p>
              </v-card-text>
            </v-card>
          </v-col>
          <v-row justify="end" class="mt-4">
            <v-col cols="auto">
              <v-btn color="grey-darken-1" @click="handleReset"
                >Reset Form</v-btn
              >
            </v-col>
            <v-col cols="auto">
              <v-btn color="primary" type="submit">Submit Application</v-btn>
            </v-col>
          </v-row>
        </v-row>
      </v-form>
    </v-card>
    <v-dialog v-model="showCompletionDialog" max-width="500px" persistent>
      <v-card class="pa-6 text-center">
        <v-card-title class="text-h5 text-blue-darken-2 mb-4">
          <v-icon color="success" size="48">mdi-check-circle-outline</v-icon>
          Application Complete!
        </v-card-title>
        <v-card-text>
          <p class="text-h6 mb-2">Your Application Number is</p>
          <p class="text-h4 font-weight-bold text-blue-darken-2 mb-6">
            {{ generatedApplicationNumber }}
          </p>
        </v-card-text>
        <v-card-actions class="justify-end">
          <v-btn
            color="primary"
            @click="continueToDocumentForms"
            class="mr-2"
            >Continue to Document Forms</v-btn
          >
          <v-btn color="secondary" @click="handleDownload"
            >Download Form</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { ref, computed, watch, onMounted, watchEffect } from "vue";
import { useField, useForm } from "vee-validate";
import { useRouter } from "vue-router";

const router = useRouter();

// Controls the visibility of the completion dialog
const showCompletionDialog = ref(false);
const generatedApplicationNumber = ref("");
const generatedPassword = ref("");

// Reactive variable for the checkbox
const isEnterpriseOwned = ref(false);

// Validation rule for required fields
const required = (value) => !!value || "This field is required.";
const requiredSelect = (value) =>
  (value !== null && value !== undefined && value !== "") ||
  "Please select an option.";
const requiredArray = (value) =>
  (value && value.length > 0) || "At least one option is required.";

// --- Form Fields (with validation rules) ---
// Destructure 'values' and 'meta' from useForm to easily access form data and validation status
const {
  handleSubmit,
  resetForm, // Use resetForm for more control
  values: formValues, // `values` from useForm will contain all fields bound with useField
  setValues, // Import setValues to programmatically set form field values
  meta, // Added meta for form-wide validation status
} = useForm({
  validationSchema: {}, // Validation rules are directly applied to useField
});

// Define a key for local storage to prevent conflicts
const LOCAL_STORAGE_KEY = 'buildingPermitForm';

// --- UseField for all form models ---
// Owner/Applicant Information
const applicationType = useField("applicationType", required, { initialValue: 'Simple' });
const applicationStatus = useField("applicationStatus", required, { initialValue: 'NEW' });
const lastName = useField("lastName", required);
const firstName = useField("firstName", required);
const middleName = useField("middleName", required);
const tin = useField("tin", required);
const formOwnership = useField("formOwnership", (value) => {
  if (isEnterpriseOwned.value && !value) {
    return "Form of Ownership is required if enterprise-owned.";
  }
  return true;
});
const ownerAddressNo = useField("ownerAddressNo", required);
const ownerAddressStreet = useField("ownerAddressStreet", requiredSelect);
const ownerAddressBarangay = useField("ownerAddressBarangay", requiredSelect);
const ownerAddressMunicipal = useField("ownerAddressMunicipal", required, {
  initialValue: "Naga City",
});
const ownerAddressZipCode = useField("ownerAddressZipCode", required);
const contactNumber = useField("contactNumber", required);

// Location of Construction
const lotNo = useField("lotNo", required);
const blkNo = useField("blkNo", required);
const tctNo = useField("tctNo", required);
const taxDecNo = useField("taxDecNo", required);
const constructionStreet = useField("constructionStreet", requiredSelect);
const constructionBarangay = useField("constructionBarangay", requiredSelect);
const constructionMunicipal = useField("constructionMunicipal", required, {
  initialValue: "Naga City",
});

// Scope of Work
const scopeOfWork = useField("scopeOfWork", requiredArray, { initialValue: [], });
const otherScopeOfWork = useField("otherScopeOfWork", (value) => {
  if (
    scopeOfWork.value.value &&
    scopeOfWork.value.value.includes("Others") &&
    !value
  ) {
    return "Please specify other Scope of Work.";
  }
  return true;
});

// Use or Character of Occupancy
const occupancyGroup = useField("occupancyGroup", requiredSelect);
const occupancyType = useField("occupancyType", requiredSelect);
const otherOccupancyType = useField("otherOccupancyType", (value) => {
  if (occupancyType.value.value === "Others" && !value) {
    return "Please specify other Occupancy Type.";
  }
  return true;
});
const occupancyClassified = useField("occupancyClassified", required);
const numberOfUnits = useField("numberOfUnits", required);
const numberOfStorey = useField("numberOfStorey", required);
const totalFloorArea = useField("totalFloorArea", required);
const lotArea = useField("lotArea", required);

// TOTAL ESTIMATED COST - These are the internal numeric values managed by VeeValidate
const costBuilding = useField("costBuilding", required);
const costElectrical = useField("costElectrical", required);
const costMechanical = useField("costMechanical", required);
const costElectronics = useField("costElectronics", required);
const costPlumbing = useField("costPlumbing", required);

// COST OF EQUIPMENT INSTALLED
const costEquipment = useField("costEquipment", required);

// Project Timeline
const proposedDate = useField("proposedDate", required);
const expectedDate = useField("expectedDate", required);

// These fields are not part of the "required sections" for initial submission but are kept for completeness
// Ensure they are properly bound in the template with v-model and reflect their useField names.
const inspectorAddress = useField("inspectorAddress");
const prcNo = useField("prcNo");
const ptrNo = useField("ptrNo");
const ptrDateIssued = useField("ptrDateIssued");
const ptrIssuedAt = useField("ptrIssuedAt");
const inspectorTin = useField("inspectorTin");

const box3ApplicantSignatureDate = useField("box3ApplicantSignatureDate");
const box3ApplicantAddress = useField("box3ApplicantAddress");
const box3ApplicantGovtIdNo = useField("box3ApplicantGovtIdNo");
const box3ApplicantIdDateIssued = useField("box3ApplicantIdDateIssued");
const box3ApplicantIdPlaceIssued = useField("box3ApplicantIdPlaceIssued");

const box4LotOwnerRepSignatureDate = useField("box4LotOwnerRepSignatureDate");
const box4LotOwnerRepAddress = useField("box4LotOwnerRepAddress");
const box4LotOwnerRepGovtIdNo = useField("box4LotOwnerRepGovtIdNo");
const box4LotOwnerRepIdDateIssued = useField("box4LotOwnerRepIdDateIssued");
const box4LotOwnerRepIdPlaceIssued = useField("box4LotOwnerRepIdPlaceIssued");

// --- Options for Combo Boxes (from your original code) ---
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
    "Barn, Granary,",
    "Poultry House",
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

const occupancyGroupOptions = computed(() => Object.keys(occupancyTypesByGroup));
const currentOccupancyTypeOptions = computed(() => {
  return occupancyGroup.value.value
    ? occupancyTypesByGroup[occupancyGroup.value.value]
    : [];
});

watch(
  () => occupancyGroup.value.value,
  (newGroup, oldGroup) => {
    if (newGroup !== oldGroup) {
      occupancyType.value.value = null;
      otherOccupancyType.value.value = "";
    }
  }
);

watch(
  () => occupancyType.value.value,
  (newType) => {
    if (newType !== "Others") {
      otherOccupancyType.value.value = "";
    }
  }
);

const barangayOptions = [
  "Abella",
  "Bagumbayan Norte",
  "Bagumbayan Sur",
  "Balatas",
  "Calauag",
  "Cararayan",
  "Carolina",
  "Concepcion Grande",
  "Concepcion Pequeña",
  "Dayangdang",
  "Del Rosario",
  "Dinaga",
  "Igualdad",
  "Lerma ",
  "Liboton",
  "Mabolo",
  "Pacol",
  "Peñafrancia",
  "Sabang",
  "San Felipe",
  "San Francisco ",
  "San Isidro",
  "Sta. Cruz",
  "Tabuco ",
  "Tinago",
  "Triangulo ",
];

const rawStreetOptions = [
  "Magsaysay Highway (3)",
  "Riversway Street",
  "Maharlika Hiway (1)",
  "Rosal",
  "Maharlika Hiway (3)",
  "Rotonda Street (2)",
  "Main Ave",
  "Rotunda",
  "Main Avenue",
  "Ruby",
  "Main Gate of Villakarangahan Subdivision calauag/san felipe Naga City, Cam SUR (1)",
  "S. Ola St",
  "Mangga",
  "Maria Concepcion",
  "Sacred Heart",
  "Maria Cristina",
  "sacred heart street (1)",
  "Maria Peñafrancia",
  "Saint Jude",
  "Mart",
  "Saint Jude Drive",
  "Mayflower (1)",
  "Sampaloc",
  "Mayon Avenue (3)",
  "San Antonio",
  "Mayon Avenue Extension",
  "San Felipe, Naga",
  "City, Bicol, Philippines (1)",
  "Mercedes",
  "San Felipe-Pacol-Carolina-Panicuason Road (1)",
  "Metro Homes",
  "San Jose",
  "Michael",
  "San Jose",
  "Miguel",
  "San Juan",
  "Minneapolis St",
  "San Juan",
  "Molave",
  "San Leandro City",
  "Molave Road",
  "Molave St",
  "San Martin",
  "San Martin",
  "Mother Francisca",
  "Naga Central Road",
  "Naga City Peoples mall (1)",
  "San Mateo",
  "Naga Rotonda",
  "Naples St",
  "Narra",
  "Narra Road",
  "Narra St",
  "Nicolasa",
  "Ninoy & Cory Avenue",
  "Ocampo",
  "Ocampo 2",
  "Ojeda",
  "Onyx",
  "Onyx Street",
  "Opal (1)",
  "P. Santos (1)",
  "P. Santos St.",
  "pacol naga city (2)",
  "Padre Gracia Street (1)",
  "Pandan",
  "Panganiban Avenue",
  "Panganiban Drive (8)",
  "Panicuason Road (1)",
  "Parañaque City",
  "Taal Avenue (2)",
  "Taculod Road",
  "Pearl",
  "Tanlad",
  "Pearl Dr",
  "tapaz (1)",
  "Pedro Santos Avenue (2)",
  "Temporo Dy",
  "Penafrancia Av. Ext (1)",
  "Tindalo",
  "Peniafrancia Av. (1)",
  "Topaz",
  "V. Belarmino St",
  "Perpetual Help",
  "V. Lukban St",
  "Peñafrancia Avenue (4)",
  "Victoria",
  "Peñafrancia Avenue",
  "Villa Francia",
  "Villacorazon Subd. II (1)",
  "Pisces",
  "Virgo",
  "PNR Road (1)",
  "Waling-waling",
  "Yakal",
  "Princeton",
];

const streetOptions = computed(() => {
  const uniqueStreets = new Set();
  rawStreetOptions.forEach((street) => {
    uniqueStreets.add(street.replace(/\s*\(\d+\)$/, ""));
  });
  return Array.from(uniqueStreets).sort();
});

// Utility functions for currency formatting and parsing
const formatCurrency = (value) => {
  // If the value is effectively zero, null, undefined, or NaN, return an empty string
  if (value === null || value === undefined || isNaN(Number(value)) || Number(value) === 0) return "";
  
  const numberValue = Number(value);

  // Check if the number has a fractional part (i.e., not an integer)
  if (numberValue % 1 !== 0) {
    // If it has a fractional part, format with 2 decimal places
    return numberValue.toLocaleString("en-US", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
  } else {
    // If it's a whole number, format with no decimal places
    return numberValue.toLocaleString("en-US", {
      minimumFractionDigits: 0,
      maximumFractionDigits: 0,
    });
  }
};

const parseCurrency = (formattedValue) => {
  if (!formattedValue) return 0;
  // Remove commas and parse to float
  const numberValue = parseFloat(formattedValue.toString().replace(/,/g, ""));
  return isNaN(numberValue) ? 0 : numberValue;
};

// Refs for the values displayed in the input fields (string format)
const displayCostBuilding = ref(null);
const displayCostElectrical = ref(null);
const displayCostMechanical = ref(null);
const displayCostElectronics = ref(null);
const displayCostPlumbing = ref(null);
const displayCostEquipment = ref(null);

// Function to handle focus event on cost inputs
const onCostFocus = (fieldRef, displayRef) => {
  const rawValue = parseCurrency(fieldRef.value.value);
  // Show empty string if rawValue is 0, otherwise show the raw number as string
  displayRef.value = rawValue === 0 ? '' : rawValue.toString();
};

// Function to handle blur event on cost inputs
const onCostBlur = (fieldRef, displayRef) => {
  // Parse the display value and update the actual field's value (VeeValidate field)
  const parsedValue = parseCurrency(displayRef.value);
  fieldRef.value.value = parsedValue;

  // Then, format the display value for presentation
  displayRef.value = formatCurrency(parsedValue);
};

// Initialize display values on component mount and whenever the underlying useField values change
watchEffect(() => {
  // This ensures that when the form loads or resets, the display fields show formatted numbers
  displayCostBuilding.value = formatCurrency(costBuilding.value.value);
  displayCostElectrical.value = formatCurrency(costElectrical.value.value);
  displayCostMechanical.value = formatCurrency(costMechanical.value.value);
  displayCostElectronics.value = formatCurrency(costElectronics.value.value);
  displayCostPlumbing.value = formatCurrency(costPlumbing.value.value);
  displayCostEquipment.value = formatCurrency(costEquipment.value.value);
});


// Updated totalEstimatedCost to include costEquipment
const totalEstimatedCost = computed(() => {
  return (
    parseCurrency(costBuilding.value.value) +
    parseCurrency(costElectrical.value.value) +
    parseCurrency(costMechanical.value.value) +
    parseCurrency(costElectronics.value.value) +
    parseCurrency(costPlumbing.value.value) +
    parseCurrency(costEquipment.value.value) // Include costEquipment here
  );
});

const totalEstimatedCostFormatted = computed(() =>
  formatCurrency(totalEstimatedCost.value)
);

// Function to generate a random alphanumeric string for application number and password
const generateRandomString = (length) => {
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0987654321";
  let result = "";
  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * characters.length));
  }
  return result;
};

// Handle form submission
const submitUnifiedApplication = handleSubmit(async (values) => {
  console.log("Form submitted successfully!", values);

  // Generate application number and password
  generatedApplicationNumber.value = generateRandomString(10);
  generatedPassword.value = generateRandomString(8);

  // Show the completion dialog
  showCompletionDialog.value = true;

  // Clear form data from local storage after successful submission
  clearFormData();

  // Reset the form after successful submission (this will use the explicit values in handleReset)
  handleReset();
});


// Function to save form data to local storage (not called on submit anymore, only if you intend to save draft)
const saveFormData = () => {
  localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(formValues));
};

// Function to load form data from local storage
const loadFormData = () => {
  const savedData = localStorage.getItem(LOCAL_STORAGE_KEY);
  if (savedData) {
    const parsedData = JSON.parse(savedData);
    // Use setValues to populate the form fields
    setValues(parsedData);
  }
};

// Function to clear form data from local storage
const clearFormData = () => {
  localStorage.removeItem(LOCAL_STORAGE_KEY);
};

// Handle Reset Form button click and also called after submission
const handleReset = () => {
  resetForm({
    values: {
      applicationType: 'Simple', // Set to desired initial value
      applicationStatus: 'NEW',  // Set to desired initial value
      lastName: null,
      firstName: null,
      middleName: null,
      tin: null,
      // isEnterpriseOwned is a ref, so reset it directly
      formOwnership: null,
      ownerAddressNo: null,
      ownerAddressStreet: null,
      ownerAddressBarangay: null,
      ownerAddressMunicipal: "Naga City", // Keep default or set to null if truly empty
      ownerAddressZipCode: null,
      contactNumber: null,
      lotNo: null,
      blkNo: null,
      tctNo: null,
      taxDecNo: null,
      constructionStreet: null,
      constructionBarangay: null,
      constructionMunicipal: "Naga City", // Keep default or set to null if truly empty
      scopeOfWork: [], // Empty array for multi-select
      otherScopeOfWork: null,
      occupancyGroup: null,
      occupancyType: null,
      otherOccupancyType: null,
      occupancyClassified: null,
      numberOfUnits: null,
      numberOfStorey: null,
      totalFloorArea: null,
      lotArea: null,
      costBuilding: null,
      costElectrical: null,
      costMechanical: null,
      costElectronics: null,
      costPlumbing: null,
      costEquipment: null,
      proposedDate: null,
      expectedDate: null,
      inspectorAddress: null,
      prcNo: null,
      ptrNo: null,
      ptrDateIssued: null,
      ptrIssuedAt: null,
      inspectorTin: null,
      box3ApplicantSignatureDate: null,
      box3ApplicantAddress: null,
      box3ApplicantGovtIdNo: null,
      box3ApplicantIdDateIssued: null,
      box3ApplicantIdPlaceIssued: null,
      box4LotOwnerRepSignatureDate: null,
      box4LotOwnerRepAddress: null,
      box4LotOwnerRepGovtIdNo: null,
      box4LotOwnerRepIdDateIssued: null,
      box4LotOwnerRepIdPlaceIssued: null,
    },
  });
  // Also explicitly reset isEnterpriseOwned if it's not managed by useField
  isEnterpriseOwned.value = false;
};

// Continue to Document Forms button action
const continueToDocumentForms = () => {
  showCompletionDialog.value = false;
  // Navigate to the next step or route
  router.push({
    name: "DocumentForms",
    query: {
      applicationNumber: generatedApplicationNumber.value,
      password: generatedPassword.value,
    },
  });
};

// Handle form download (placeholder)
const handleDownload = () => {
  alert("Downloading form (feature not yet implemented).");
  showCompletionDialog.value = false;
};

// Load form data when the component is mounted
onMounted(() => {
  loadFormData();
});
</script>

<style scoped>
/* Stepper styles (from your original code) */
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
  flex-shrink: 0; /* Prevent shrinking */
  padding: 0 10px; /* Add some padding */
}

.stepper-icon {
  font-size: 40px; /* Adjust icon size */
  color: #cccccc;
  transition: color 0.3s;
}

.stepper-item.active .stepper-icon {
  color: #1976d2; /* Active color */
}

.stepper-text {
  font-size: 14px;
  color: #888888;
  margin-top: 5px;
  transition: color 0.3s;
}

.stepper-item.active .stepper-text {
  color: #1976d2; /* Active color */
  font-weight: bold;
}

.stepper-line {
  flex-grow: 1;
  height: 2px;
  background-color: #cccccc;
  margin: 0 -10px; /* Overlap with padding of items */
}

/* Acknowledgment section field styling */
.acknowledgment-field {
  display: inline-block;
  width: auto; /* Adjust width as needed */
  vertical-align: middle;
  min-width: 150px; /* Base minimum width */
  margin: 0 5px;
}

.acknowledgment-field-short {
  display: inline-block;
  width: auto;
  vertical-align: middle;
  min-width: 80px; /* Smaller minimum width for short fields */
  margin: 0 5px;
}

.acknowledgment-field-long {
  display: inline-block;
  width: auto;
  vertical-align: middle;
  min-width: 250px; /* Larger minimum width for long fields */
  margin: 0 5px;
}

/* Stepper styles or the stepper */
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
  flex-shrink: 0; /* Prevent shrinking */
  padding: 0 10px; /* Add some padding */
}

.stepper-icon {
  font-size: 40px;
  /* Adjust icon size */
  color: #cccccc;
  transition: color 0.3s;
}

.stepper-item.active .stepper-icon {
  color: #1976d2; /* Active color */
}

.stepper-text {
  font-size: 14px;
  color: #888888;
  margin-top: 5px;
  transition: color 0.3s;
}

.stepper-item.active .stepper-text {
  color: #1976d2; /* Active color */
  font-weight: bold;
}

.stepper-line {
  flex-grow: 1;
  height: 2px;
  background-color: #cccccc;
  margin: 0 -10px; /* Overlap with padding of items */
}

/* Acknowledgment section field styling */
.acknowledgment-line-long {
  border-bottom: 1px solid #000;
  /* Dark line for signature */
  display: inline-block;
  width: auto;
  min-width: 200px;
  /* Minimum width for the line */
  vertical-align: middle;
}

.acknowledgment-field {
  display: inline-block;
  width: auto; /* Adjust width as needed */
  vertical-align: middle;
  min-width: 150px; /* Base minimum width */
  margin: 0 5px;
}

.acknowledgment-field-short {
  display: inline-block;
  width: auto;
  vertical-align: middle;
  min-width: 80px; /* Smaller minimum width for short fields */
  margin: 0 5px;
}

.acknowledgment-field-long {
  display: inline-block;
  width: auto;
  vertical-align: middle;
  min-width: 250px; /* Larger minimum width for long fields */
  margin: 0 5px;
}

/* Stepper styles or the stepper */
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
  flex-shrink: 0; /* Prevent shrinking */
  padding: 0 10px; /* Add some padding */
}

.stepper-icon {
  font-size: 40px;
  /* Adjust icon size */
  color: #cccccc;
  transition: color 0.3s;
}
</style>