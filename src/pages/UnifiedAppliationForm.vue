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
              onkeypress="return (event.charCode > 47 && event.charCode < 58 || event.charCode === 46)"
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
              v-model="costBuildingFormatted"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costBuilding.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              label="Electrical"
              v-model="costElectricalFormatted"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costElectrical.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              label="Mechanical"
              v-model="costMechanicalFormatted"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costMechanical.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Electronics"
              v-model="costElectronicsFormatted"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costElectronics.errorMessage.value"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Plumbing"
              v-model="costPlumbingFormatted"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costPlumbing.errorMessage.value"
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
              v-model="costEquipmentFormatted"
              density="compact"
              variant="outlined"
              prefix="₱"
              :error-messages="costEquipment.errorMessage.value"
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
            <v-btn color="primary" @click="continueToDocumentForms" class="mr-2"
              >Continue to Document Forms</v-btn
            >
            <v-btn color="secondary" @click="handleDownload"
              >Download Form</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
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
const scopeOfWork = useField("scopeOfWork", requiredArray, {
  initialValue: [],
});
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

// TOTAL ESTIMATED COST
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
// const architectCivilEngineerName = useField("architectCivilEngineerName"); // This field doesn't appear to be directly in the template
// const architectEngineerSignatureDate = useField(
//   "architectEngineerSignatureDate"
// ); // This field doesn't appear to be directly in the template
const prcNo = useField("prcNo");
// const prcValidity = useField("prcValidity"); // This field doesn't appear to be directly in the template
const ptrNo = useField("ptrNo");
const ptrDateIssued = useField("ptrDateIssued");
const ptrIssuedAt = useField("ptrIssuedAt");
const inspectorTin = useField("inspectorTin");

// const box3ApplicantName = useField("box3ApplicantName"); // This field doesn't appear to be directly in the template
const box3ApplicantSignatureDate = useField("box3ApplicantSignatureDate");
const box3ApplicantAddress = useField("box3ApplicantAddress");
const box3ApplicantGovtIdNo = useField("box3ApplicantGovtIdNo");
const box3ApplicantIdDateIssued = useField("box3ApplicantIdDateIssued");
const box3ApplicantIdPlaceIssued = useField("box3ApplicantIdPlaceIssued");

// const box4LotOwnerRepName = useField("box4LotOwnerRepName"); // This field doesn't appear to be directly in the template
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
const occupancyGroupOptions = computed(() =>
  Object.keys(occupancyTypesByGroup)
);
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
  "San Martin",
  "Molave St",
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
  "Peninsula",
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
    const cleanedStreet = street.replace(/\s*\(\d+\)$/, "").trim();
    uniqueStreets.add(cleanedStreet);
  });
  return Array.from(uniqueStreets).sort();
});

// Function to generate a random numeric string for application number
const generateRandomNumber = (length) => {
  const characters = "0123456789";
  let result = "";
  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * characters.length));
  }
  return result;
};

// Function to generate a random alphanumeric string for password
const generateRandomAlphanumericString = (length) => {
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  let result = "";
  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * characters.length));
  }
  return result;
};

// --- Local Storage Logic ---
// Save form values to local storage whenever they change
watch(formValues, (newValues) => {
  try {
    // Combine vee-validate form values with other reactive refs like isEnterpriseOwned
    const combinedState = {
      ...newValues,
      isEnterpriseOwned: isEnterpriseOwned.value,
    };
    localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(combinedState));
  } catch (e) {
    console.error("Error saving to localStorage:", e);
  }
}, { deep: true }); // Use deep watch for nested objects

// Load form values from local storage when the component is mounted
onMounted(() => {
  try {
    const savedForm = localStorage.getItem(LOCAL_STORAGE_KEY);
    if (savedForm) {
      const parsedForm = JSON.parse(savedForm);
      setValues(parsedForm); // Set all form values from local storage

      // Special handling for isEnterpriseOwned as it's a separate ref
      if (typeof parsedForm.isEnterpriseOwned !== 'undefined') {
        isEnterpriseOwned.value = parsedForm.isEnterpriseOwned;
      }
    }
  } catch (e) {
    console.error("Error loading from localStorage:", e);
    // Optionally, clear invalid data from local storage if parsing fails
    localStorage.removeItem(LOCAL_STORAGE_KEY);
  }
});

// Custom handleReset function to clear both the form and local storage
const customHandleReset = () => {
  resetForm(); // Reset form values using vee-validate's resetForm
  isEnterpriseOwned.value = false; // Manually reset other refs if needed
  localStorage.removeItem(LOCAL_STORAGE_KEY); // Clear local storage
  console.log("Form has been reset and local storage cleared.");
};


// Handle form submission
const submitUnifiedApplication = handleSubmit(async (values) => {
  // This block will only be executed if the form is valid according to the defined rules
  console.log("Unified Application Form Submitted:", values);

  // Generate application number (numeric) and password (alphanumeric)
  generatedApplicationNumber.value = generateRandomNumber(10); // e.g., 10-digit number
  generatedPassword.value = generateRandomAlphanumericString(8);

  // Prepare the data to be sent to the backend
  const dataToSend = {
    generatedApplicationNumber: generatedApplicationNumber.value,
    generatedPassword: generatedPassword.value,
    applicationDetails: {
      applicationType: values.applicationType,
      applicationStatus: values.applicationStatus,
      // For multi-select, vee-validate `values` already gives an array
      scopeOfWork: values.scopeOfWork,
      otherScopeOfWork: values.otherScopeOfWork,
      occupancyGroup: values.occupancyGroup,
      occupancyType: values.occupancyType,
      otherOccupancyType: values.otherOccupancyType,
    },
    ownerApplicantInfo: {
      firstName: values.firstName,
      middleName: values.middleName,
      lastName: values.lastName,
      tin: values.tin,
      isEnterpriseOwned: isEnterpriseOwned.value, // This is a separate ref, not part of `values`
      formOwnership: values.formOwnership,
      ownerAddressNo: values.ownerAddressNo,
      ownerAddressStreet: values.ownerAddressStreet,
      ownerAddressBarangay: values.ownerAddressBarangay,
      ownerAddressMunicipal: values.ownerAddressMunicipal,
      ownerAddressZipCode: values.ownerAddressZipCode,
      contactNumber: values.contactNumber,
    },
    constructionLocation: {
      lotNo: values.lotNo,
      blkNo: values.blkNo,
      tctNo: values.tctNo,
      taxDecNo: values.taxDecNo,
      constructionStreet: values.constructionStreet,
      constructionBarangay: values.constructionBarangay,
      constructionMunicipal: values.constructionMunicipal,
    },
    occupancyDetails: {
      occupancyClassified: values.occupancyClassified,
      numberOfUnits: values.numberOfUnits,
      numberOfStorey: values.numberOfStorey,
      totalFloorArea: values.totalFloorArea,
      lotArea: values.lotArea,
    },
    estimatedCosts: {
      costBuilding: values.costBuilding,
      costElectrical: values.costElectrical,
      costMechanical: values.costMechanical,
      costElectronics: values.costElectronics,
      costPlumbing: values.costPlumbing,
      costEquipment: values.costEquipment,
    },
    projectTimeline: {
      proposedDate: values.proposedDate,
      expectedDate: values.expectedDate,
    },
    // Include the acknowledgment/notary public fields.
    // Ensure these useField names match the 'name' attribute in your HTML template
    inspectorAddress: values.inspectorAddress,
    // architectCivilEngineerName: values.architectCivilEngineerName, // Not directly in template with v-model, skipped
    // architectEngineerSignatureDate: values.architectEngineerSignatureDate, // Not directly in template with v-model, skipped
    prcNo: values.prcNo,
    // prcValidity: values.prcValidity, // Not directly in template with v-model, skipped
    ptrNo: values.ptrNo,
    ptrDateIssued: values.ptrDateIssued,
    ptrIssuedAt: values.ptrIssuedAt,
    inspectorTin: values.inspectorTin,

    // box3ApplicantName: values.box3ApplicantName, // Not directly in template with v-model, skipped
    box3ApplicantSignatureDate: values.box3ApplicantSignatureDate,
    box3ApplicantAddress: values.box3ApplicantAddress,
    box3ApplicantGovtIdNo: values.box3ApplicantGovtIdNo,
    box3ApplicantIdDateIssued: values.box3ApplicantIdDateIssued,
    box3ApplicantIdPlaceIssued: values.box3ApplicantIdPlaceIssued,

    // box4LotOwnerRepName: values.box4LotOwnerRepName, // Not directly in template with v-model, skipped
    box4LotOwnerRepSignatureDate: values.box4LotOwnerRepSignatureDate,
    box4LotOwnerRepAddress: values.box4LotOwnerRepAddress,
    box4LotOwnerRepGovtIdNo: values.box4LotOwnerRepGovtIdNo,
    box4LotOwnerRepIdDateIssued: values.box4LotOwnerRepIdDateIssued,
    box4LotOwnerRepIdPlaceIssued: values.box4LotOwnerRepIdPlaceIssued,

    // Acknowledgment/Notary Public fields from Box 5 are currently not bound to `useField`
    // in your template, so they won't be in `values`. If you need to send them,
    // you would need to add `v-model` and corresponding `useField` definitions.
    // Example:
    // municipalityOfSS: values.municipalityOfSS,
    // beforeMeMunicipality: values.beforeMeMunicipality,
    // beforeMeDate: values.beforeMeDate,
    // applicantGovtIdNoAck: values.applicantGovtIdNoAck,
    // ...etc.
  };

  try {
    const response = await fetch(
      "http://localhost/buildingpermitapplication/src/pages/Unified-Backend/unifiedbackend.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(dataToSend),
      }
    );

    const result = await response.json();

    if (result.success) {
      console.log("Backend success:", result.message);
      // Show the completion dialog upon successful submission
      showCompletionDialog.value = true;
      // *** IMPORTANT CHANGE: Removed localStorage.removeItem(LOCAL_STORAGE_KEY) here ***
      // This ensures data persists even after successful submission.
      // The user can now manually clear it with the "Reset Form" button if they wish.

      // *** ONLY NAVIGATE AFTER SUCCESSFUL BACKEND SAVE ***
      // Call continueToDocumentForms here, after the await for response
      // This ensures the data is in the database before the next page tries to fetch it.
      // This will be triggered once the dialog is closed or by a separate action.
    } else {
      console.error("Backend error:", result.message);
      // In a real application, you would show a user-friendly modal or message
      console.error("Error submitting application: " + result.message);
    }
  } catch (error) {
    console.error("Network or fetch error:", error);
    // In a real application, you would show a user-friendly modal or message
    console.error("Could not connect to the server. Please try again.");
  }
});

// Function to handle downloading the main form data (optional, but good for completeness)
const handleDownload = () => {
  // Use formValues directly for download, as it holds the current state of all bound fields
  const dataToDownload = {
    applicationDetails: {
      applicationType: formValues.applicationType,
      applicationStatus: formValues.applicationStatus,
      scopeOfWork: formValues.scopeOfWork,
      otherScopeOfWork: formValues.otherScopeOfWork,
      occupancyGroup: formValues.occupancyGroup,
      occupancyType: formValues.occupancyType,
      otherOccupancyType: formValues.otherOccupancyType,
    },
    ownerApplicantInfo: {
      firstName: formValues.firstName,
      middleName: formValues.middleName,
      lastName: formValues.lastName,
      tin: formValues.tin,
      isEnterpriseOwned: isEnterpriseOwned.value, // Use the ref directly
      formOwnership: formValues.formOwnership,
      ownerAddressNo: formValues.ownerAddressNo,
      ownerAddressStreet: formValues.ownerAddressStreet,
      ownerAddressBarangay: formValues.ownerAddressBarangay,
      ownerAddressMunicipal: formValues.ownerAddressMunicipal,
      ownerAddressZipCode: formValues.ownerAddressZipCode,
      contactNumber: formValues.contactNumber,
    },
    constructionLocation: {
      lotNo: formValues.lotNo,
      blkNo: formValues.blkNo,
      tctNo: formValues.tctNo,
      taxDecNo: formValues.taxDecNo,
      constructionStreet: formValues.constructionStreet,
      constructionBarangay: formValues.constructionBarangay,
      constructionMunicipal: formValues.constructionMunicipal,
    },
    occupancyDetails: {
      occupancyClassified: formValues.occupancyClassified,
      numberOfUnits: formValues.numberOfUnits,
      numberOfStorey: formValues.numberOfStorey,
      totalFloorArea: formValues.totalFloorArea,
      lotArea: formValues.lotArea,
    },
    estimatedCosts: {
      costBuilding: formValues.costBuilding,
      costElectrical: formValues.costElectrical,
      costMechanical: formValues.costMechanical,
      costElectronics: formValues.costElectronics,
      costPlumbing: formValues.costPlumbing,
      costEquipment: formValues.costEquipment,
    },
    projectTimeline: {
      proposedDate: formValues.proposedDate,
      expectedDate: formValues.expectedDate,
    },
    // Include acknowledgment fields from formValues if they are bound via useField
    inspectorAddress: formValues.inspectorAddress,
    prcNo: formValues.prcNo,
    ptrNo: formValues.ptrNo,
    ptrDateIssued: formValues.ptrDateIssued,
    ptrIssuedAt: formValues.ptrIssuedAt,
    inspectorTin: formValues.inspectorTin,
    box3ApplicantSignatureDate: formValues.box3ApplicantSignatureDate,
    box3ApplicantAddress: formValues.box3ApplicantAddress,
    box3ApplicantGovtIdNo: formValues.box3ApplicantGovtIdNo,
    box3ApplicantIdDateIssued: formValues.box3ApplicantIdDateIssued,
    box3ApplicantIdPlaceIssued: formValues.box3ApplicantIdPlaceIssued,
    box4LotOwnerRepSignatureDate: formValues.box4LotOwnerRepSignatureDate,
    box4LotOwnerRepAddress: formValues.box4LotOwnerRepAddress,
    box4LotOwnerRepGovtIdNo: formValues.box4LotOwnerRepGovtIdNo,
    box4LotOwnerRepIdDateIssued: formValues.box4LotOwnerRepIdDateIssued,
    box4LotOwnerRepIdPlaceIssued: formValues.box4LotOwnerRepIdPlaceIssued,
  };

  const jsonString = JSON.stringify(dataToDownload, null, 2);
  const blob = new Blob([jsonString], { type: "application/json" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "unified_application_data.json";
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);
};

const continueToDocumentForms = () => {
  showCompletionDialog.value = false;
  // Navigate to the next page or section of the application
  router.push({
    name: "DocumentForms",
    params: {
      applicationNumber: generatedApplicationNumber.value,
      password: generatedPassword.value,
    },
  });
};

const copyToClipboard = (text) => {
  document.execCommand('copy');
  console.log("Copied to clipboard!");
};
</script>


<style scoped>
/* Your existing styles */
.acknowledgment-line {
  display: inline-block;
  border-bottom: 1px solid black;
  min-width: 50px;
  text-align: center;
  margin: 0 5px;
}

.acknowledgment-line-short {
  display: inline-block;
  border-bottom: 1px solid black;
  min-width: 30px;
  text-align: center;
  margin: 0 5px;
}

.acknowledgment-line-long {
  display: inline-block;
  border-bottom: 1px solid black;
  min-width: 200px;
  text-align: center;
  margin: 0 5px;
}

/* Enhanced styles for acknowledgment fields as text-fields */
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
  color: grey;
}

.stepper-text {
  font-size: 0.9em;
  color: grey;
  margin-top: 5px;
  white-space: nowrap;
  /* Keep text on one line */
}

.stepper-item.active .stepper-icon {
  color: #1976d2;
  /* Primary color for active icon */
}

.stepper-item.active .stepper-text {
  color: #000;
  /* Darker text for active step */
  font-weight: bold;
}

.stepper-line {
  flex-grow: 1;
  height: 2px;
  background-color: grey;
  margin: 0 10px;
}

/* Your existing styles continue... */
</style>
