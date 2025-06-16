<template>
  <v-container>
    <h2 class="text-h4 text-center mb-8 text-blue-darken-3">
      ARCHITECTURAL PERMIT APPLICATION
    </h2>

    <!-- Display the application number -->
    <v-alert
      v-if="unifiedApplicationNumber"
      type="info"
      class="mb-4"
      variant="tonal"
    >
      Linked to Unified Application Number:
      <span class="font-weight-bold">{{ unifiedApplicationNumber }}</span>
    </v-alert>

    <v-form @submit.prevent="submitArchitecturalForm">
      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >Owner/Applicant Information</v-card-title
        >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="lastName.value.value"
                label="Last Name"
                :rules="[rules.required]"
                clearable
                :error-messages="lastName.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="firstName.value.value"
                label="First Name"
                :rules="[rules.required]"
                clearable
                :error-messages="firstName.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="2">
              <v-text-field
                v-model="middleInitial.value.value"
                label="Middle Initial"
                maxlength="1"
                clearable
                :error-messages="middleInitial.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="2">
              <v-text-field
                v-model="tin.value.value"
                label="TIN"
                type="text"
                :rules="[rules.numericOnly]"
                clearable
                :error-messages="tin.errorMessage.value"
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="2">
              <v-text-field
                v-model="ownerAddressNo.value.value"
                label="NO."
                clearable
                :error-messages="ownerAddressNo.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="ownerAddressStreet.value.value"
                label="STREET"
                clearable
                :error-messages="ownerAddressStreet.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="ownerAddressBarangay.value.value"
                label="BARANGAY"
                clearable
                :error-messages="ownerAddressBarangay.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="ownerAddressCity.value.value"
                label="CITY/MUNICIPALITY"
                :rules="[rules.required]"
                clearable
                :error-messages="ownerAddressCity.errorMessage.value"
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="ownerZip.value.value"
                label="ZIP CODE"
                type="text"
                :rules="[rules.required, rules.numericOnly]"
                clearable
                :error-messages="ownerZip.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="ownerPhone.value.value"
                label="TELEPHONE NO."
                type="text"
                :rules="[rules.numericOnly]"
                clearable
                :error-messages="ownerPhone.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="ownerEmail.value.value"
                label="Email Address"
                :rules="[rules.email]"
                clearable
                :error-messages="ownerEmail.errorMessage.value"
              />
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >Location of Installation</v-card-title
        >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="locationLotNo.value.value"
                label="LOT NO."
                type="text"
                :rules="[rules.numericOnly]"
                clearable
                :error-messages="locationLotNo.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="locationBlkNo.value.value"
                label="BLK NO."
                type="text"
                :rules="[rules.numericOnly]"
                clearable
                :error-messages="locationBlkNo.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="locationTctNo.value.value"
                label="TCT NO."
                clearable
                :error-messages="locationTctNo.errorMessage.value"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="locationTaxDecNo.value.value"
                label="TAX DEC. NO."
                clearable
                :error-messages="locationTaxDecNo.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="locationStreet.value.value"
                label="STREET"
                clearable
                :error-messages="locationStreet.errorMessage.value"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="locationBarangay.value.value"
                label="BARANGAY"
                clearable
                :error-messages="locationBarangay.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="locationCity.value.value"
                label="CITY/MUNICIPALITY"
                :rules="[rules.required]"
                clearable
                :error-messages="locationCity.errorMessage.value"
              />
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >Scope of Work</v-card-title
        >
        <v-card-text>
          <v-radio-group v-model="scope.value.value" :rules="[rules.required]" row
            :error-messages="scope.errorMessage.value"
          >
            <v-radio
              label="NEW INSTALLATION"
              value="newInstallation"
              class="mr-4"
            />
            <v-radio
              label="ADDITION/EXTENSION"
              value="additionExtension"
              class="mr-4"
            />
            <v-radio
              label="REPAIR/RENOVATION"
              value="repairRenovation"
              class="mr-4"
            />
            <v-radio
              label="REMOVAL/DEMOLITION"
              value="removalDemolition"
              class="mr-4"
            />
            <v-radio label="OTHERS (Specify)" value="othersScope" />
          </v-radio-group>

          <v-expand-transition>
            <v-row v-if="showOthersField">
              <v-col cols="12">
                <v-text-field
                  v-model="scopeOtherDetails.value.value"
                  label="Please specify details for 'OTHERS (Specify)'"
                  :rules="[rules.requiredIfOthers(scope.value.value)]"
                  clearable
                  :error-messages="scopeOtherDetails.errorMessage.value"
                />
              </v-col>
            </v-row>
          </v-expand-transition>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >Architectural Facilities</v-card-title
        >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="3">
              <v-checkbox
                label="Stairs"
                v-model="afStairs.value.value"
                hide-details
              />
              <v-checkbox
                label="Walkways"
                v-model="afWalkways.value.value"
                hide-details
              />
              <v-checkbox
                label="Corridors"
                v-model="afCorridors.value.value"
                hide-details
              />
              <v-checkbox
                label="Door/Entrance & Thresholds"
                v-model="afDoorEntranceThresholds.value.value"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-checkbox
                label="Wash Rooms and Toilets"
                v-model="afWashRoomsToilets.value.value"
                hide-details
              />
              <v-checkbox
                label="Lifts/Elevator"
                v-model="afLiftsElevator.value.value"
                hide-details
              />
              <v-checkbox
                label="Ramps"
                v-model="afRamps.value.value"
                hide-details
              />
              <v-checkbox
                label="Parking Areas"
                v-model="afParkingAreas.value.value"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-checkbox
                label="Switch, Controls, Buzzer"
                v-model="afSwitchControlsBuzzer.value.value"
                hide-details
              />
              <v-checkbox
                label="Handrails"
                v-model="afHandrails.value.value"
                hide-details
              />
              <v-checkbox
                label="Thresholds"
                v-model="afStandaloneThresholds.value.value"
                hide-details
              />
              <v-checkbox
                label="Floor Finishes"
                v-model="afFloorFinishes.value.value"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-checkbox
                label="Drinking Fountains"
                v-model="afDrinkingFountains.value.value"
                hide-details
              />
              <v-checkbox
                label="Public Telephones"
                v-model="afPublicTelephones.value.value"
                hide-details
              />
              <v-checkbox
                label="Seating Accommodations"
                v-model="afSeatingAccommodations.value.value"
                hide-details
              />
              <v-checkbox
                label="Others"
                v-model="afOthersArchitectural.value.value"
                hide-details
              />
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >Site Occupancy and Fire Code Conformance</v-card-title
        >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6">
              <h4 class="text-subtitle-1 mb-2">Percentage of Site occupancy</h4>
              <v-text-field
                v-model="soBuildingFootPrint.value.value"
                label="PERCENTAGE OF BUILDING FOOT PRINT (%)"
                type="number"
                suffix="%"
                :rules="[rules.numericAndDecimalOnly]"
                clearable
                :error-messages="soBuildingFootPrint.errorMessage.value"
              />
              <v-text-field
                v-model="soImperviousSurfaceArea.value.value"
                label="PERCENTAGE OF IMPERVIOUS SURFACE AREA (%)"
                type="number"
                suffix="%"
                :rules="[rules.numericAndDecimalOnly]"
                clearable
                :error-messages="soImperviousSurfaceArea.errorMessage.value"
              />
              <v-text-field
                v-model="soUnpavedSurfaceArea.value.value"
                label="PERCENTAGE OF UNPAVED SURFACE AREA (%)"
                type="number"
                suffix="%"
                :rules="[rules.numericAndDecimalOnly]"
                clearable
                :error-messages="soUnpavedSurfaceArea.errorMessage.value"
              />
              <v-text-field
                v-model="soOthers.value.value"
                label="OTHERS (Specify)"
                clearable
                :error-messages="soOthers.errorMessage.value"
              />
            </v-col>
            <v-col cols="12" md="6">
              <h4 class="text-subtitle-1 mb-2">
                Conformance to fire code of the Philippines
              </h4>
              <v-checkbox
                label="NUMBER AND WIDTH OF EXIT DOORS"
                v-model="fccNumWidthExitDoors.value.value"
                hide-details
              />
              <v-checkbox
                label="WIDTH OF CORRIDORS"
                v-model="fccWidthCorridors.value.value"
                hide-details
              />
              <v-checkbox
                label="DISTANCE TO FIRE EXITS"
                v-model="fccDistanceFireExits.value.value"
                hide-details
              />
              <v-checkbox
                label="ACCESS TO PUBLIC STREETS"
                v-model="fccAccessPublicStreets.value.value"
                hide-details
              />
              <v-checkbox
                label="FIRE WALLS"
                v-model="fccFireWalls.value.value"
                hide-details
              />
              <v-checkbox
                label="FIRE FIGHTING AND SAFETY FACILITIES"
                v-model="fccFireFightingSafety.value.value"
                hide-details
              />
              <v-checkbox
                label="SMOKE DETECTORS"
                v-model="fccSmokeDetectors.value.value"
                hide-details
              />
              <v-checkbox
                label="EMERGENCY LIGHTS"
                v-model="fccEmergencyLights.value.value"
                hide-details
              />
              <v-checkbox
                label="OTHERS (Specify)"
                v-model="fccOthers.value.value"
                hide-details
              />
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <!-- BOX 3 & BOX 4 - Non-Interactive Display -->
      <v-row class="mb-6">
        <v-col cols="12" md="6">
          <v-card elevation="2" class="h-100">
            <v-card-title class="text-h6 text-blue-darken-2"
              >BOX 3</v-card-title
            >
            <v-card-subtitle
              >DESIGN PROFESSIONAL, PLANS AND SPECIFICATIONS</v-card-subtitle
            >
            <v-card-text>
              <div class="static-field-group">
                <div class="static-line-label">
                  ARCHITECT (Signed and Sealed Over Printed Name)
                </div>
                <div class="static-line"></div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Date</div>
                <div class="static-line"></div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Address</div>
                <div class="static-line"></div>
              </div>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">IAPOA No.</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Validity</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">PRC No.</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Validity</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">PTR No</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Date Issued</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Issued at</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">TIN</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="6">
          <v-card elevation="2" class="h-100">
            <v-card-title class="text-h6 text-blue-darken-2"
              >BOX 4</v-card-title
            >
            <v-card-subtitle
              >SUPERVISOR / IN-CHARGE OF ARCHITECTURAL WORKS</v-card-subtitle
            >
            <v-card-text>
              <div class="static-field-group">
                <div class="static-line-label">
                  ARCHITECT (Signed and Sealed Over Printed Name)
                </div>
                <div class="static-line"></div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Date</div>
                <div class="static-line"></div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Address</div>
                <div class="static-line"></div>
              </div>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">IAPOA No.</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Validity</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">PRC No.</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Validity</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">PTR No</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Date Issued</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Issued at</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">TIN</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <v-row class="mb-6">
        <v-col cols="12" md="6">
          <v-card elevation="2" class="h-100">
            <v-card-title class="text-h6 text-blue-darken-2"
              >BOX 5</v-card-title
            >
            <v-card-subtitle>BUILDING OWNER</v-card-subtitle>
            <v-card-text>
              <v-text-field
                label="(Signature Over Printed Name)"
                v-model="boSignatureName.value.value"
                class="plain-input"
                hide-details
                :error-messages="boSignatureName.errorMessage.value"
              />
              <v-text-field
                label="Date"
                v-model="boDate.value.value"
                class="plain-input"
                hide-details
                type="date"
                :error-messages="boDate.errorMessage.value"
              />
              <v-text-field
                label="Address"
                v-model="boAddress.value.value"
                class="plain-input"
                hide-details
                :error-messages="boAddress.errorMessage.value"
              />
              <v-row>
                <v-col cols="6">
                  <v-text-field
                    label="C.T.C. No."
                    v-model="boCtcNo.value.value"
                    class="plain-input"
                    hide-details
                    :error-messages="boCtcNo.errorMessage.value"
                  />
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    label="Date Issued"
                    v-model="boDateIssued.value.value"
                    class="plain-input"
                    hide-details
                    type="date"
                    :error-messages="boDateIssued.errorMessage.value"
                  />
                </v-col>
              </v-row>
              <v-text-field
                label="Place Issued"
                v-model="boPlaceIssued.value.value"
                class="plain-input"
                hide-details
                :error-messages="boPlaceIssued.errorMessage.value"
              />
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="6">
          <v-card elevation="2" class="h-100">
            <v-card-title class="text-h6 text-blue-darken-2"
              >BOX 6</v-card-title
            >
            <v-card-subtitle>WITH MY CONSENT: LOT OWNER</v-card-subtitle>
            <v-card-text>
              <div class="static-field-group">
                <div class="static-line-label">
                  (Signature Over Printed Name)
                </div>
                <div class="static-line"></div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Date</div>
                <div class="static-line"></div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Address</div>
                <div class="static-line"></div>
              </div>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">C.T.C. No.</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Date Issued</div>
                    <div class="static-line"></div>
                  </div>
                </v-col>
              </v-row>
              <div class="static-field-group">
                <div class="static-line-label">Place Issued</div>
                <div class="static-line"></div>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2">BOX 7</v-card-title>
        <v-card-text>
          <v-row no-gutters class="border-bottom">
            <v-col cols="6" class="py-2 pl-4 pr-2 border-right">
              <span class="font-weight-bold">RECEIVED BY</span>
            </v-col>
            <v-col cols="6" class="py-2 pl-4">
              <span class="font-weight-bold">DATE</span>
            </v-col>
          </v-row>

          <v-row class="mt-4">
            <v-col cols="12">
              <h4 class="text-subtitle-1 mb-2 text-center">
                FIVE (5) SETS OF ARCHITECTURAL DOCUMENTS
              </h4>
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="6">
              <v-checkbox
                label="VICINITY MAP/LOCATION PLAN WITHIN A TWO-KILOMETER RADIUS"
                v-model="adVicinityMap.value.value"
                hide-details
              />
              <v-checkbox
                label="SITE DEVELOPMENT PLAN"
                v-model="adSiteDevelopmentPlan.value.value"
                hide-details
              />
              <v-checkbox
                label="PERSPECTIVE"
                v-model="adPerspective.value.value"
                hide-details
              />
              <v-checkbox
                label="FLOOR PLANS"
                v-model="adFloorPlans.value.value"
                hide-details
              />
              <v-checkbox
                label="ELEVATIONS, AT LEAST FOUR (4)"
                v-model="adElevations.value.value"
                hide-details
              />
              <v-checkbox
                label="SECTIONS, AT LEAST TWO (2)"
                v-model="adSections.value.value"
                hide-details
              />
              <v-checkbox
                label="CEILING PLANS SHOWING LIGHTING FIXTURES AND DIFFUSERS"
                v-model="adCeilingPlans.value.value"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-checkbox
                label="DETAILS OF RAMPS, PARKING FOR THE DISABLED, STAIRS, FIRE ESCAPES, CABINETS AND PARTITIONS"
                v-model="adDetailsOfRampsEtc.value.value"
                hide-details
              />
              <v-checkbox
                label="SCHEDULE OF DOORS AND WINDOWS"
                v-model="adScheduleDoorsWindows.value.value"
                hide-details
              />
              <v-checkbox
                label="SCHEDULE OF FINISHES FOR FLOORS, CEILINGS AND WALLS"
                v-model="adScheduleFinishes.value.value"
                hide-details
              />
              <v-checkbox
                label="ARCHITECTURAL INTERIOR"
                v-model="adArchitecturalInterior.value.value"
                hide-details
              />
              <v-checkbox
                label="SPECIFICATIONS"
                v-model="adSpecifications.value.value"
                hide-details
              />
              <v-checkbox
                label="COST ESTIMATE"
                v-model="adCostEstimate.value.value"
                hide-details
              />
              <v-checkbox
                label="OTHERS (Specify)"
                v-model="adOthersDocuments.value.value"
                hide-details
              />
              <v-expand-transition>
                <v-text-field
                  v-if="adOthersDocuments.value.value"
                  v-model="adOthersDocumentsDetails.value.value"
                  label="Please specify details for 'OTHERS'"
                  :rules="[rules.requiredIfOthersDocuments(adOthersDocuments.value.value)]"
                  clearable
                  class="mt-2"
                  :error-messages="adOthersDocumentsDetails.errorMessage.value"
                />
              </v-expand-transition>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2 text-center"
          >BOX 8</v-card-title
        >
        <v-card-text class="pa-0">
          <table class="progress-flow-table">
            <thead>
              <tr>
                <th rowspan="2" class="static-th"></th>
                <th colspan="2" class="static-th">IN</th>
                <th colspan="2" class="static-th">OUT</th>
                <th rowspan="2" class="static-th">PROCESSED BY:</th>
              </tr>
              <tr>
                <th class="static-th">DATE</th>
                <th class="static-th">TIME</th>
                <th class="static-th">DATE</th>
                <th class="static-th">TIME</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="static-td-label">ARCHITECTURAL DRAWINGS</td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
              </tr>
              <tr>
                <td class="static-td-label">SPECIFICATIONS</td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
              </tr>
              <tr>
                <td class="static-td-label">OTHERS (Specify)</td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
              </tr>
              <!-- Add 3 more empty rows as per image for data entry -->
              <tr>
                <td class="static-td-label"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
              </tr>
              <tr>
                <td class="static-td-label"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
              </tr>
              <tr>
                <td class="static-td-label"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
                <td class="static-td"></td>
              </tr>
            </tbody>
          </table>
        </v-card-text>
      </v-card>

      <!-- BOX 9: ACTION TAKEN -->
      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2">BOX 9</v-card-title>
        <v-card-text>
          <h4 class="text-subtitle-1 mt-4 mb-2">PERMIT ISSUED BY:</h4>
          <div class="static-field-group text-center">
            <div class="static-line-label">ALEXANDER N. CANING</div>
            <div class="static-line"></div>
            <div class="text-caption mt-1">BUILDING OFFICIAL</div>
            <div class="text-caption">(Signature Over Printed Name)</div>
            <div class="static-line-label">Date</div>
            <div class="static-line"></div>
          </div>
        </v-card-text>
      </v-card>

      <v-row class="mt-6">
        <v-col cols="12" class="d-flex justify-end">
          <v-btn
            color="grey-darken-1"
            variant="outlined"
            class="mr-4"
            @click="customResetForm"
          >
            Reset Form
          </v-btn>
          <v-btn color="blue-darken-3" type="submit">
            Submit Application
          </v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-container>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useField, useForm } from "vee-validate";
import { useRoute } from "vue-router"; // Import useRoute to access route params

const route = useRoute(); // Access the current route object

// Prop received from the router: unified_application_number
// This assumes your router is configured to pass this as a prop,
// e.g., path: '/document-forms/:applicationNumber', props: true
const unifiedApplicationNumber = ref(route.params.applicationNumber || '');

// Define a key for local storage for this specific form using a computed property
// This ensures the key reacts to changes in unifiedApplicationNumber.value
const LOCAL_STORAGE_KEY = computed(() => `architecturalPermitForm_${unifiedApplicationNumber.value}`);

// --- VeeValidate Setup ---
const {
  handleSubmit,
  resetForm, // Use resetForm for more control
  values: formValues,
  setValues, // To set form values programmatically
  meta, // For form validation state
} = useForm({
  validationSchema: {}, // Rules defined directly with useField
});

// --- Validation Rules ---
const rules = {
  required: (value) => !!value || "This field is required.",
  email: (value) => {
    if (!value) return true;
    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-1]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return pattern.test(value) || "Invalid e-mail.";
  },
  numericOnly: (value) => {
    if (value === null || value === "") return true;
    const pattern = /^[0-9]+$/;
    return pattern.test(value) || "Only numbers are allowed.";
  },
  numericAndDecimalOnly: (value) => {
    if (value === null || value === "") return true;
    const pattern = /^[0-9]*(\.[0-9]+)?$/;
    return pattern.test(value) || "Only numbers and decimals are allowed.";
  },
  requiredIfOthers: (scopeValue) => (value) => {
    if (scopeValue === 'othersScope') {
      return !!value || "Please specify details for 'OTHERS (Specify)'.";
    }
    return true;
  },
  requiredIfOthersDocuments: (othersDocumentsChecked) => (value) => {
    if (othersDocumentsChecked) {
      return !!value || "Please specify details for 'OTHERS' documents.";
    }
    return true;
  },
};

// --- Form Fields using useField ---
// Owner/Applicant Information
const lastName = useField("lastName", rules.required);
const firstName = useField("firstName", rules.required);
const middleInitial = useField("middleInitial");
const tin = useField("tin", rules.numericOnly);
const ownerAddressNo = useField("ownerAddressNo");
const ownerAddressStreet = useField("ownerAddressStreet");
const ownerAddressBarangay = useField("ownerAddressBarangay");
const ownerAddressCity = useField("ownerAddressCity", rules.required);
const ownerZip = useField("ownerZip", [rules.required, rules.numericOnly]);
const ownerPhone = useField("ownerPhone", rules.numericOnly);
const ownerEmail = useField("ownerEmail", rules.email);

// Location of Installation
const locationLotNo = useField("locationLotNo", rules.numericOnly);
const locationBlkNo = useField("locationBlkNo", rules.numericOnly);
const locationTctNo = useField("locationTctNo");
const locationTaxDecNo = useField("locationTaxDecNo");
const locationStreet = useField("locationStreet");
const locationBarangay = useField("locationBarangay");
const locationCity = useField("locationCity", rules.required);

// Scope of Work
const scope = useField("scope", rules.required);
// Watch the scope field value to make requiredIfOthers reactive
watch(() => scope.value.value, (newScope) => {
  scopeOtherDetails.validate(newScope); // Re-validate scopeOtherDetails when scope changes
});
const scopeOtherDetails = useField("scopeOtherDetails", (value) => rules.requiredIfOthers(scope.value.value)(value));


// Architectural Facilities (use individual fields for v-model, collect into object for submission)
const afStairs = useField("afStairs", null, { type: 'checkbox', initialValue: false });
const afWalkways = useField("afWalkways", null, { type: 'checkbox', initialValue: false });
const afCorridors = useField("afCorridors", null, { type: 'checkbox', initialValue: false });
const afDoorEntranceThresholds = useField("afDoorEntranceThresholds", null, { type: 'checkbox', initialValue: false });
const afWashRoomsToilets = useField("afWashRoomsToilets", null, { type: 'checkbox', initialValue: false });
const afLiftsElevator = useField("afLiftsElevator", null, { type: 'checkbox', initialValue: false });
const afRamps = useField("afRamps", null, { type: 'checkbox', initialValue: false });
const afParkingAreas = useField("afParkingAreas", null, { type: 'checkbox', initialValue: false });
const afSwitchControlsBuzzer = useField("afSwitchControlsBuzzer", null, { type: 'checkbox', initialValue: false });
const afHandrails = useField("afHandrails", null, { type: 'checkbox', initialValue: false });
const afStandaloneThresholds = useField("afStandaloneThresholds", null, { type: 'checkbox', initialValue: false });
const afFloorFinishes = useField("afFloorFinishes", null, { type: 'checkbox', initialValue: false });
const afDrinkingFountains = useField("afDrinkingFountains", null, { type: 'checkbox', initialValue: false });
const afPublicTelephones = useField("afPublicTelephones", null, { type: 'checkbox', initialValue: false });
const afSeatingAccommodations = useField("afSeatingAccommodations", null, { type: 'checkbox', initialValue: false });
const afOthersArchitectural = useField("afOthersArchitectural", null, { type: 'checkbox', initialValue: false });


// Site Occupancy and Fire Code Conformance
const soBuildingFootPrint = useField("soBuildingFootPrint", rules.numericAndDecimalOnly);
const soImperviousSurfaceArea = useField("soImperviousSurfaceArea", rules.numericAndDecimalOnly);
const soUnpavedSurfaceArea = useField("soUnpavedSurfaceArea", rules.numericAndDecimalOnly);
const soOthers = useField("soOthers");

const fccNumWidthExitDoors = useField("fccNumWidthExitDoors", null, { type: 'checkbox', initialValue: false });
const fccWidthCorridors = useField("fccWidthCorridors", null, { type: 'checkbox', initialValue: false });
const fccDistanceFireExits = useField("fccDistanceFireExits", null, { type: 'checkbox', initialValue: false });
const fccAccessPublicStreets = useField("fccAccessPublicStreets", null, { type: 'checkbox', initialValue: false });
const fccFireWalls = useField("fccFireWalls", null, { type: 'checkbox', initialValue: false });
const fccFireFightingSafety = useField("fccFireFightingSafety", null, { type: 'checkbox', initialValue: false });
const fccSmokeDetectors = useField("fccSmokeDetectors", null, { type: 'checkbox', initialValue: false });
const fccEmergencyLights = useField("fccEmergencyLights", null, { type: 'checkbox', initialValue: false });
const fccOthers = useField("fccOthers", null, { type: 'checkbox', initialValue: false });

// Building Owner (Box 5)
const boSignatureName = useField("boSignatureName");
const boDate = useField("boDate");
const boAddress = useField("boAddress");
const boCtcNo = useField("boCtcNo");
const boDateIssued = useField("boDateIssued");
const boPlaceIssued = useField("boPlaceIssued");

// Architectural Documents
const adVicinityMap = useField("adVicinityMap", null, { type: 'checkbox', initialValue: false });
const adSiteDevelopmentPlan = useField("adSiteDevelopmentPlan", null, { type: 'checkbox', initialValue: false });
const adPerspective = useField("adPerspective", null, { type: 'checkbox', initialValue: false });
const adFloorPlans = useField("adFloorPlans", null, { type: 'checkbox', initialValue: false });
const adElevations = useField("adElevations", null, { type: 'checkbox', initialValue: false });
const adSections = useField("adSections", null, { type: 'checkbox', initialValue: false });
const adCeilingPlans = useField("adCeilingPlans", null, { type: 'checkbox', initialValue: false });
const adDetailsOfRampsEtc = useField("adDetailsOfRampsEtc", null, { type: 'checkbox', initialValue: false });
const adScheduleDoorsWindows = useField("adScheduleDoorsWindows", null, { type: 'checkbox', initialValue: false });
const adScheduleFinishes = useField("adScheduleFinishes", null, { type: 'checkbox', initialValue: false });
const adArchitecturalInterior = useField("adArchitecturalInterior", null, { type: 'checkbox', initialValue: false });
const adSpecifications = useField("adSpecifications", null, { type: 'checkbox', initialValue: false });
const adCostEstimate = useField("adCostEstimate", null, { type: 'checkbox', initialValue: false });
const adOthersDocuments = useField("adOthersDocuments", null, { type: 'checkbox', initialValue: false });
// Watch the adOthersDocuments field value to make requiredIfOthersDocuments reactive
watch(() => adOthersDocuments.value.value, (newVal) => {
  adOthersDocumentsDetails.validate(newVal); // Re-validate adOthersDocumentsDetails when adOthersDocuments changes
});
const adOthersDocumentsDetails = useField("adOthersDocumentsDetails", (value) => rules.requiredIfOthersDocuments(adOthersDocuments.value.value)(value));


// Computed property for conditional rendering of "Others" scope field
const showOthersField = computed(() => scope.value.value === "othersScope");

// --- Local Storage Logic ---
// Save form values to local storage whenever they change
watch(formValues, (newValues) => {
  try {
    // Ensure LOCAL_STORAGE_KEY.value is available before setting
    if (LOCAL_STORAGE_KEY.value) {
      localStorage.setItem(LOCAL_STORAGE_KEY.value, JSON.stringify(newValues));
    }
  } catch (e) {
    console.error("Error saving architectural form to localStorage:", e);
  }
}, { deep: true }); // Use deep watch for nested objects


// Helper function to try loading from local storage
const tryLoadFromLocalStorage = () => {
  try {
    if (LOCAL_STORAGE_KEY.value) { // Ensure the key is available
      const savedForm = localStorage.getItem(LOCAL_STORAGE_KEY.value);
      if (savedForm) {
        const parsedForm = JSON.parse(savedForm);
        setValues(parsedForm); // Set all form values from local storage
        console.log("Architectural form loaded from localStorage:", parsedForm);
      }
    }
  } catch (e) {
    console.error("Error loading architectural form from localStorage:", e);
    // It's safer to remove potentially corrupt data
    if (LOCAL_STORAGE_KEY.value) {
      localStorage.removeItem(LOCAL_STORAGE_KEY.value);
    }
  }
};

// Consolidated onMounted hook for proper initialization
onMounted(async () => {
  console.log("OnMounted hook called. unifiedApplicationNumber:", unifiedApplicationNumber.value);

  if (unifiedApplicationNumber.value) {
    console.log(`Attempting to load data for application number: ${unifiedApplicationNumber.value}`);
    try {
      const response = await fetch(
        `http://localhost/buildingpermitapplication/src/pages/Architect-Backend/architect.php?unified_application_number=${unifiedApplicationNumber.value}`
      );
      const result = await response.json();

      if (result.success && result.data) {
        console.log("Initial data fetched from backend:", result.data);
        const fetchedData = result.data;
        // Map backend data to vee-validate fields using setValues
        setValues({
          // Owner/Applicant Information
          lastName: fetchedData.ownerApplicantInfo.lastName,
          firstName: fetchedData.ownerApplicantInfo.firstName,
          middleInitial: fetchedData.ownerApplicantInfo.mi, // map 'mi' to 'middleInitial'
          tin: fetchedData.ownerApplicantInfo.tin,
          ownerAddressNo: fetchedData.ownerApplicantInfo.address.no,
          ownerAddressStreet: fetchedData.ownerApplicantInfo.address.street,
          ownerAddressBarangay: fetchedData.ownerApplicantInfo.address.barangay,
          ownerAddressCity: fetchedData.ownerApplicantInfo.address.city,
          ownerZip: fetchedData.ownerApplicantInfo.zip,
          ownerPhone: fetchedData.ownerApplicantInfo.phone,
          ownerEmail: fetchedData.ownerApplicantInfo.email,
          // Location of Installation
          locationLotNo: fetchedData.locationOfInstallation.lotNo,
          locationBlkNo: fetchedData.locationOfInstallation.blkNo,
          locationTctNo: fetchedData.locationOfInstallation.tctNo,
          locationTaxDecNo: fetchedData.locationOfInstallation.taxDecNo,
          locationStreet: fetchedData.locationOfInstallation.street,
          locationBarangay: fetchedData.locationOfInstallation.barangay,
          locationCity: fetchedData.locationOfInstallation.city,
          // Scope of Work
          scope: fetchedData.scopeOfWork.scope,
          scopeOtherDetails: fetchedData.scopeOfWork.scopeOtherDetails,
          // Architectural Facilities
          afStairs: fetchedData.architecturalFacilities.stairs,
          afWalkways: fetchedData.architecturalFacilities.walkways,
          afCorridors: fetchedData.architecturalFacilities.corridors,
          afDoorEntranceThresholds: fetchedData.architecturalFacilities.doorEntranceThresholds,
          afWashRoomsToilets: fetchedData.architecturalFacilities.washRoomsToilets,
          afLiftsElevator: fetchedData.architecturalFacilities.liftsElevator,
          afRamps: fetchedData.architecturalFacilities.ramps,
          afParkingAreas: fetchedData.architecturalFacilities.parkingAreas,
          afSwitchControlsBuzzer: fetchedData.architecturalFacilities.switchControlsBuzzer,
          afHandrails: fetchedData.architecturalFacilities.handrails,
          afStandaloneThresholds: fetchedData.architecturalFacilities.standaloneThresholds,
          afFloorFinishes: fetchedData.architecturalFacilities.floorFinishes,
          afDrinkingFountains: fetchedData.architecturalFacilities.drinkingFountains,
          afPublicTelephones: fetchedData.architecturalFacilities.publicTelephones,
          afSeatingAccommodations: fetchedData.architecturalFacilities.seatingAccommodations,
          afOthersArchitectural: fetchedData.architecturalFacilities.othersArchitectural,
          // Site Occupancy and Fire Code Conformance
          // NOTE: Assuming backend sends 'siteOccupancyAndFireCodeConformance' as one object.
          // If separate, adjust to fetchedData.siteOccupancy.buildingFootPrint and fetchedData.fireCodeConformance.numWidthExitDoors
          soBuildingFootPrint: fetchedData.siteOccupancyAndFireCodeConformance.buildingFootPrint,
          soImperviousSurfaceArea: fetchedData.siteOccupancyAndFireCodeConformance.imperviousSurfaceArea,
          soUnpavedSurfaceArea: fetchedData.siteOccupancyAndFireCodeConformance.unpavedSurfaceArea,
          soOthers: fetchedData.siteOccupancyAndFireCodeConformance.others,
          fccNumWidthExitDoors: fetchedData.siteOccupancyAndFireCodeConformance.numWidthExitDoors,
          fccWidthCorridors: fetchedData.siteOccupancyAndFireCodeConformance.widthCorridors,
          fccDistanceFireExits: fetchedData.siteOccupancyAndFireCodeConformance.distanceFireExits,
          fccAccessPublicStreets: fetchedData.siteOccupancyAndFireCodeConformance.accessPublicStreets,
          fccFireWalls: fetchedData.siteOccupancyAndFireCodeConformance.fireWalls,
          fccFireFightingSafety: fetchedData.siteOccupancyAndFireCodeConformance.fireFightingSafety,
          fccSmokeDetectors: fetchedData.siteOccupancyAndFireCodeConformance.smokeDetectors,
          fccEmergencyLights: fetchedData.siteOccupancyAndFireCodeConformance.emergencyLights,
          fccOthers: fetchedData.siteOccupancyAndFireCodeConformance.others,
          // Building Owner (Box 5)
          boSignatureName: fetchedData.buildingOwner.signatureName,
          boDate: fetchedData.buildingOwner.date,
          boAddress: fetchedData.buildingOwner.address,
          boCtcNo: fetchedData.buildingOwner.ctcNo,
          boDateIssued: fetchedData.buildingOwner.dateIssued,
          boPlaceIssued: fetchedData.buildingOwner.placeIssued,
          // Architectural Documents
          adVicinityMap: fetchedData.architecturalDocuments.vicinityMap,
          adSiteDevelopmentPlan: fetchedData.architecturalDocuments.siteDevelopmentPlan,
          adPerspective: fetchedData.architecturalDocuments.perspective,
          adFloorPlans: fetchedData.architecturalDocuments.floorPlans,
          adElevations: fetchedData.architecturalDocuments.elevations,
          adSections: fetchedData.architecturalDocuments.sections,
          adCeilingPlans: fetchedData.architecturalDocuments.ceilingPlans,
          adDetailsOfRampsEtc: fetchedData.architecturalDocuments.detailsOfRampsEtc,
          adScheduleDoorsWindows: fetchedData.architecturalDocuments.scheduleDoorsWindows,
          adScheduleFinishes: fetchedData.architecturalDocuments.scheduleFinishes,
          adArchitecturalInterior: fetchedData.architecturalDocuments.architecturalInterior,
          adSpecifications: fetchedData.architecturalDocuments.specifications,
          adCostEstimate: fetchedData.architecturalDocuments.costEstimate,
          adOthersDocuments: fetchedData.architecturalDocuments.othersDocuments,
          adOthersDocumentsDetails: fetchedData.architecturalDocuments.othersDocumentsDetails,
        });
      } else {
        console.warn("Failed to fetch initial data or data is empty for application:", unifiedApplicationNumber.value);
        // Fallback to local storage if backend fetch fails or returns no data
        tryLoadFromLocalStorage();
      }
    } catch (error) {
      console.error("Error fetching initial data:", error);
      // Fallback to local storage on fetch error
      tryLoadFromLocalStorage();
    }
  } else {
    console.log("No unified application number found. Checking local storage.");
    tryLoadFromLocalStorage();
  }
});


// Custom handleReset function to clear both the form and local storage
const customResetForm = () => {
  resetForm(); // Reset all fields managed by useForm
  // Manually reset other refs if any
  // No special refs like isEnterpriseOwned in this form, so resetForm should be sufficient for vee-validate fields.
  if (LOCAL_STORAGE_KEY.value) { // Ensure the key is available
    localStorage.removeItem(LOCAL_STORAGE_KEY.value); // Clear local storage
  }
  console.log("Architectural form has been reset and local storage cleared.");
};

// Handle form submission
const submitArchitecturalForm = handleSubmit(async (values) => {
  console.log("Architectural Permit Form Submitted:", values);

  // Group checkbox values into objects for backend JSON storage
  const architecturalFacilitiesData = {
    stairs: values.afStairs,
    walkways: values.afWalkways,
    corridors: values.afCorridors,
    doorEntranceThresholds: values.afDoorEntranceThresholds,
    washRoomsToilets: values.afWashRoomsToilets,
    liftsElevator: values.afLiftsElevator,
    ramps: values.afRamps,
    parkingAreas: values.afParkingAreas,
    switchControlsBuzzer: values.afSwitchControlsBuzzer,
    handrails: values.afHandrails,
    standaloneThresholds: values.afStandaloneThresholds,
    floorFinishes: values.afFloorFinishes,
    drinkingFountains: values.afDrinkingFountains,
    publicTelephones: values.afPublicTelephones,
    seatingAccommodations: values.afSeatingAccommodations,
    othersArchitectural: values.afOthersArchitectural,
  };

  const fireCodeConformanceData = {
    numWidthExitDoors: values.fccNumWidthExitDoors,
    widthCorridors: values.fccWidthCorridors,
    distanceFireExits: values.fccDistanceFireExits,
    accessPublicStreets: values.fccAccessPublicStreets,
    fireWalls: values.fccFireWalls,
    fireFightingSafety: values.fccFireFightingSafety,
    smokeDetectors: values.fccSmokeDetectors,
    emergencyLights: values.fccEmergencyLights,
    others: values.fccOthers,
  };

  const architecturalDocumentsData = {
    vicinityMap: values.adVicinityMap,
    siteDevelopmentPlan: values.adSiteDevelopmentPlan,
    perspective: values.adPerspective,
    floorPlans: values.adFloorPlans,
    elevations: values.adElevations,
    sections: values.adSections,
    ceilingPlans: values.adCeilingPlans,
    detailsOfRampsEtc: values.adDetailsOfRampsEtc,
    scheduleDoorsWindows: values.adScheduleDoorsWindows,
    scheduleFinishes: values.adScheduleFinishes,
    architecturalInterior: values.adArchitecturalInterior,
    specifications: values.adSpecifications,
    costEstimate: values.adCostEstimate,
    othersDocuments: values.adOthersDocuments,
  };


  // Prepare data for backend submission
  const dataToSend = {
    unifiedApplicationNumber: unifiedApplicationNumber.value, // Pass the application number
    ownerApplicantInfo: {
      lastName: values.lastName,
      firstName: values.firstName,
      mi: values.middleInitial, // Map back to 'mi' for backend
      tin: values.tin,
      address: {
        no: values.ownerAddressNo,
        street: values.ownerAddressStreet,
        barangay: values.ownerAddressBarangay,
        city: values.ownerAddressCity,
      },
      zip: values.ownerZip,
      phone: values.ownerPhone,
      email: values.ownerEmail,
    },
    locationOfInstallation: {
      lotNo: values.locationLotNo,
      blkNo: values.locationBlkNo,
      tctNo: values.locationTctNo,
      taxDecNo: values.locationTaxDecNo,
      street: values.locationStreet,
      barangay: values.locationBarangay,
      city: values.locationCity,
    },
    scopeOfWork: {
      scope: values.scope,
      scopeOtherDetails: values.scopeOtherDetails,
    },
    architecturalFacilities: architecturalFacilitiesData, // Send as object for JSON encoding
    siteOccupancy: {
      buildingFootPrint: values.soBuildingFootPrint,
      imperviousSurfaceArea: values.soImperviousSurfaceArea,
      unpavedSurfaceArea: values.soUnpavedSurfaceArea,
      others: values.soOthers,
    },
    fireCodeConformance: fireCodeConformanceData, // Send as object for JSON encoding
    buildingOwner: {
      signatureName: values.boSignatureName,
      date: values.boDate,
      address: values.boAddress,
      ctcNo: values.boCtcNo,
      dateIssued: values.boDateIssued,
      placeIssued: values.boPlaceIssued,
    },
    architecturalDocuments: architecturalDocumentsData, // Send as object for JSON encoding
    // Only send details if 'othersDocuments' checkbox is checked
    architecturalDocumentsDetails: values.adOthersDocumentsDetails,
  };

  try {
    const response = await fetch(
      "http://localhost/buildingpermitapplication/src/pages/Architect-Backend/architect.php",
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
      console.log("Architectural Permit Backend success:", result.message);
      // After successful submission, update local storage to reflect the latest saved data
      localStorage.setItem(LOCAL_STORAGE_KEY.value, JSON.stringify(formValues));
      alert("Architectural Permit Application Submitted Successfully!"); // Consider replacing with a custom modal UI
    } else {
      console.error("Architectural Permit Backend error:", result.message);
      alert("Error submitting Architectural Permit: " + result.message); // Consider replacing with a custom modal UI
    }
  } catch (error) {
    console.error("Network or fetch error for Architectural Permit:", error);
    alert("Could not connect to the server for Architectural Permit. Please try again."); // Consider replacing with a custom modal UI
  }
});
</script>

<style scoped>
/* Your existing styles */
/* Styles for plain input fields, typically used for official sections or static data */
.plain-input.v-text-field {
  --v-input-control-height: auto; /* Allow content to dictate height */
  --v-input-padding-top: 0;
  --v-input-padding-bottom: 0;
  padding-top: 0 !important;
  padding-bottom: 0 !important;
  margin-top: 0 !important;
  margin-bottom: 0 !important;
  border-bottom: 1px solid #ccc; /* Underline for fields */
}

/* Remove default Vuetify input underline/border for plain variant */
.plain-input.v-text-field .v-input__control {
  border-bottom: none !important;
}

.plain-input.v-text-field .v-field__overlay {
  display: none;
}

/* New styles for static display fields to mimic screenshot */
.static-field-group {
  margin-bottom: 16px; /* Spacing between static field groups */
}

.static-line-label {
  font-size: 0.75rem; /* Smaller font for labels, similar to screenshot */
  color: rgba(0, 0, 0, 0.6); /* Lighter color for labels */
  margin-bottom: 4px; /* Space between label and line */
}

.static-line {
  border-bottom: 1px solid #ccc; /* The underline */
  padding-bottom: 2px; /* Space between text and line */
  min-height: 24px; /* Ensure a minimum height for the line */
}

/* Styles for BOX 8 Progress Flow Table */
.progress-flow-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.85rem;
  text-align: center;
}

.progress-flow-table th,
.progress-flow-table td {
  border: 1px solid #000;
  padding: 8px 4px;
  vertical-align: middle;
}

.progress-flow-table th.static-th {
  background-color: #f0f0f0; /* Light background for headers */
  font-weight: bold;
}

.progress-flow-table td.static-td-label {
  text-align: left;
  padding-left: 10px;
  font-weight: bold;
}

.progress-flow-table thead th {
  padding: 8px 4px; /* Consistent padding for headers */
}

.progress-flow-table tbody tr:last-child td {
  border-bottom: 1px solid #000; /* Ensure last row has bottom border */
}

.progress-flow-table tbody tr td:last-child {
  border-right: 1px solid #000; /* Ensure last column has right border */
}
</style>
