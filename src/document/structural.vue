<template>
  <v-container>
    <h2 class="text-h4 text-center mb-8 text-blue-darken-3">
      CIVIL/STRUCTURAL PERMIT APPLICATION
    </h2>

    <v-form v-model="valid" ref="form">
      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >Owner/Applicant Information</v-card-title
        >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="form.lastName"
                label="Last Name"
                :rules="[rules.required]"
                clearable
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="form.firstName"
                label="First Name"
                :rules="[rules.required]"
                clearable
              />
            </v-col>
            <v-col cols="12" md="2">
              <v-text-field
                v-model="form.mi"
                label="Middle Initial"
                maxlength="1"
                clearable
              />
            </v-col>
            <v-col cols="12" md="2">
              <v-text-field
                v-model="form.tin"
                label="TIN"
                type="text"
                :rules="[rules.numericOnly]"
                clearable
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="2">
              <v-text-field v-model="form.address.no" label="NO." clearable />
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="form.address.street"
                label="STREET"
                clearable
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="form.address.barangay"
                label="BARANGAY"
                clearable
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="form.address.city"
                label="CITY/MUNICIPALITY"
                :rules="[rules.required]"
                clearable
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="form.zip"
                label="ZIP CODE"
                type="text"
                :rules="[rules.required, rules.numericOnly]"
                clearable
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="form.phone"
                label="TELEPHONE NO."
                type="text"
                :rules="[rules.numericOnly]"
                clearable
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.email"
                label="Email Address"
                :rules="[rules.email]"
                clearable
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
                v-model="form.location.lotNo"
                label="LOT NO."
                type="text"
                :rules="[rules.numericOnly]"
                clearable
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="form.location.blkNo"
                label="BLK NO."
                type="text"
                :rules="[rules.numericOnly]"
                clearable
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.location.tctNo"
                label="TCT NO."
                clearable
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.location.taxDecNo"
                label="TAX DEC. NO."
                clearable
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.location.street"
                label="STREET"
                clearable
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.location.barangay"
                label="BARANGAY"
                clearable
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.location.city"
                label="CITY/MUNICIPALITY"
                :rules="[rules.required]"
                clearable
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
          <v-radio-group v-model="form.scope" :rules="[rules.required]" row>
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
                  v-model="form.scopeOtherDetails"
                  label="Please specify details for 'OTHERS (Specify)'"
                  :rules="[rules.requiredIfOthers]"
                  clearable
                />
              </v-col>
            </v-row>
          </v-expand-transition>
        </v-card-text>
      </v-card>

      <!-- NATURE OF CIVIL/STRUCTURAL WORKS -->
      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >NATURE OF CIVIL/STRUCTURAL WORKS:</v-card-title
        >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="4">
              <v-checkbox
                label="STAKING"
                v-model="form.natureOfCivilStructuralWorks.staking"
                hide-details
              />
              <v-checkbox
                label="EXCAVATION"
                v-model="form.natureOfCivilStructuralWorks.excavation"
                hide-details
              />
              <v-checkbox
                label="SOIL STABILIZATION"
                v-model="form.natureOfCivilStructuralWorks.soilStabilization"
                hide-details
              />
              <v-checkbox
                label="PILING WORKS"
                v-model="form.natureOfCivilStructuralWorks.pilingWorks"
                hide-details
              />
              <v-checkbox
                label="FOUNDATION"
                v-model="form.natureOfCivilStructuralWorks.foundation"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-checkbox
                label="ERECTION/LIFTING"
                v-model="form.natureOfCivilStructuralWorks.erectionLifting"
                hide-details
              />
              <v-checkbox
                label="CONCRETE FRAMING"
                v-model="form.natureOfCivilStructuralWorks.concreteFraming"
                hide-details
              />
              <v-checkbox
                label="STRUCTURAL STEEL FRAMING"
                v-model="form.natureOfCivilStructuralWorks.structuralSteelFraming"
                hide-details
              />
              <v-checkbox
                label="SLABS"
                v-model="form.natureOfCivilStructuralWorks.slabs"
                hide-details
              />
              <v-checkbox
                label="WALLS"
                v-model="form.natureOfCivilStructuralWorks.walls"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-checkbox
                label="PRESTRESS WORKS"
                v-model="form.natureOfCivilStructuralWorks.prestressWorks"
                hide-details
              />
              <v-checkbox
                label="MATERIAL TESTING"
                v-model="form.natureOfCivilStructuralWorks.materialTesting"
                hide-details
              />
              <v-checkbox
                label="STEEL TOWERS"
                v-model="form.natureOfCivilStructuralWorks.steelTowers"
                hide-details
              />
              <v-checkbox
                label="TANKS"
                v-model="form.natureOfCivilStructuralWorks.tanks"
                hide-details
              />
              <v-checkbox
                label="OTHERS (Specify)"
                v-model="form.natureOfCivilStructuralWorks.others"
                hide-details
              />
              <v-expand-transition>
                <v-text-field
                  v-if="form.natureOfCivilStructuralWorks.others"
                  v-model="form.natureOfCivilStructuralWorks.othersDetails"
                  label="Please specify details for 'OTHERS'"
                  :rules="[rules.requiredIfNatureOthers]"
                  clearable
                  class="mt-2"
                />
              </v-expand-transition>
            </v-col>
          </v-row>
          <h4 class="text-subtitle-1 mt-4 mb-2">PREPARED BY</h4>
          <!-- This will remain a v-text-field because it needs to be interactive -->
          <v-text-field
            v-model="form.buildingDetails.preparedBy"
            label="Prepared By"
            clearable
            variant="plain"
            density="compact"
            hide-details
            class="plain-input"
          />
        </v-card-text>
      </v-card>

      <!-- BOX 3 & BOX 4 - Reverted to Static Display -->
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
                <div class="static-line">{{ form.designProfessional.architectName }}</div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Date</div>
                <div class="static-line">{{ form.designProfessional.date }}</div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Address</div>
                <div class="static-line">{{ form.designProfessional.address }}</div>
              </div>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">IAPOA No.</div>
                    <div class="static-line">{{ form.designProfessional.iapoaNo }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Validity</div>
                    <div class="static-line">{{ form.designProfessional.iapoaValidity }}</div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">PRC No.</div>
                    <div class="static-line">{{ form.designProfessional.prcNo }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Validity</div>
                    <div class="static-line">{{ form.designProfessional.prcValidity }}</div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">PTR No</div>
                    <div class="static-line">{{ form.designProfessional.ptrNo }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Date Issued</div>
                    <div class="static-line">{{ form.designProfessional.ptrDateIssued }}</div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Issued at</div>
                    <div class="static-line">{{ form.designProfessional.issuedAt }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">TIN</div>
                    <div class="static-line">{{ form.designProfessional.tin }}</div>
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
                  ENGINEER (Signed and Sealed Over Printed Name)
                </div>
                <div class="static-line">{{ form.supervisorArchitectural.architectName }}</div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Date</div>
                <div class="static-line">{{ form.supervisorArchitectural.date }}</div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Address</div>
                <div class="static-line">{{ form.supervisorArchitectural.address }}</div>
              </div>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">APO No.</div>
                    <div class="static-line">{{ form.supervisorArchitectural.iapoaNo }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Validity</div>
                    <div class="static-line">{{ form.supervisorArchitectural.iapoaValidity }}</div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">PRC No.</div>
                    <div class="static-line">{{ form.supervisorArchitectural.prcNo }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Validity</div>
                    <div class="static-line">{{ form.supervisorArchitectural.prcValidity }}</div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">PTR No</div>
                    <div class="static-line">{{ form.supervisorArchitectural.ptrNo }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Date Issued</div>
                    <div class="static-line">{{ form.supervisorArchitectural.ptrDateIssued }}</div>
                  </div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Issued at</div>
                    <div class="static-line">{{ form.supervisorArchitectural.issuedAt }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">TIN</div>
                    <div class="static-line">{{ form.supervisorArchitectural.tin }}</div>
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
              <div class="static-field-group">
                <div class="static-line-label">
                  (Signature Over Printed Name)
                </div>
                <div class="static-line">{{ form.buildingOwner.signatureName }}</div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Date</div>
                <div class="static-line">{{ form.buildingOwner.date }}</div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Address</div>
                <div class="static-line">{{ form.buildingOwner.address }}</div>
              </div>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">C.T.C. No.</div>
                    <div class="static-line">{{ form.buildingOwner.ctcNo }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Date Issued</div>
                    <div class="static-line">{{ form.buildingOwner.dateIssued }}</div>
                  </div>
                </v-col>
              </v-row>
              <div class="static-field-group">
                <div class="static-line-label">Place Issued</div>
                <div class="static-line">{{ form.buildingOwner.placeIssued }}</div>
              </div>
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
                <div class="static-line">{{ form.lotOwner.signatureName }}</div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Date</div>
                <div class="static-line">{{ form.lotOwner.date }}</div>
              </div>
              <div class="static-field-group">
                <div class="static-line-label">Address</div>
                <div class="static-line">{{ form.lotOwner.address }}</div>
              </div>
              <v-row dense>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">C.T.C. No.</div>
                    <div class="static-line">{{ form.lotOwner.ctcNo }}</div>
                  </div>
                </v-col>
                <v-col cols="6">
                  <div class="static-field-group">
                    <div class="static-line-label">Date Issued</div>
                    <div class="static-line">{{ form.lotOwner.dateIssued }}</div>
                  </div>
                </v-col>
              </v-row>
              <div class="static-field-group">
                <div class="static-line-label">Place Issued</div>
                <div class="static-line">{{ form.lotOwner.placeIssued }}</div>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <!-- BOX 7: FIVE (5) SETS OF CIVIL/STRUCTURAL DOCUMENTS -->
      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2">BOX 7</v-card-title>
        <v-card-text>
          <div class="mb-4">
            <h4 class="text-subtitle-1 text-center font-weight-bold">
              TO BE ACCOMPLISHED BY THE PROCESSING AND EVALUATION DIVISION
            </h4>
          </div>
          <v-row no-gutters class="border-bottom-dark">
            <v-col cols="6" class="py-2 pl-4 pr-2 border-right-dark">
              <span class="font-weight-bold">RECEIVED BY:</span>
              <!-- This remains a v-text-field as it needs to be interactive -->
              <v-text-field
                v-model="form.box7ReceivedBy"
                label="Received By"
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              />
            </v-col>
            <v-col cols="6" class="py-2 pl-4">
              <span class="font-weight-bold">DATE:</span>
              <!-- This remains a v-text-field as it needs to be interactive -->
              <v-text-field
                v-model="form.box7DateReceived"
                label="Date"
                type="date"
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              />
            </v-col>
          </v-row>

          <v-row class="mt-4">
            <v-col cols="12">
              <h4 class="text-subtitle-1 mb-2 text-center font-weight-bold">
                FIVE (5) SETS OF CIVIL/STRUCTURAL DOCUMENTS
              </h4>
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="6">
              <v-checkbox
                label="CIVIL/STRUCTURAL DESIGNS COMPUTATIONS, PLANS AND SPECIFICATIONS"
                v-model="form.civilStructuralDocuments.designsComputations"
                hide-details
              />
              <v-checkbox
                label="BILL OF MATERIALS"
                v-model="form.civilStructuralDocuments.billOfMaterials"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-checkbox
                label="COST ESTIMATES"
                v-model="form.civilStructuralDocuments.costEstimates"
                hide-details
              />
              <v-checkbox
                label="OTHERS (Specify)"
                v-model="form.civilStructuralDocuments.others"
                hide-details
              />
              <v-expand-transition>
                <v-text-field
                  v-if="form.civilStructuralDocuments.others"
                  v-model="form.civilStructuralDocuments.othersDetails"
                  label="Please specify details for 'OTHERS'"
                  :rules="[rules.requiredIfCivilStructuralOthersDocuments]"
                  clearable
                  class="mt-2"
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
          <h4 class="text-subtitle-1 mb-2">ACTION TAKEN:</h4>
          <h5 class="text-subtitle-2 mb-2">
            PERMIT IS HEREBY ISSUED SUBJECT TO THE FOLLOWING:
          </h5>
          <ol class="ml-4">
            <li>
              That under Article 1723 of the Civil Code of the Philippines, the
              architect (and engineer) who drew up the plans and specifications
              for the building/structure is responsible for damages if within
              fifteen (15) years from the completion of the building/structure,
              the same should collapse due to defect in the plans or
              specifications or defects in the ground. The engineer or architect
              who supervises the construction shall be solidarily liable with
              the contractor should the edifice collapse due to defect in the
              construction or the use of inferior materials.
            </li>
            <li>
              That the proposed architectural works shall be in accordance with
              the architectural plans filed with this Office and in conformity
              with the latest Architectural Code of the Philippines, the
              National Building Code and its IRR.
            </li>
            <li>
              That prior to any construction activity, a duly accomplished
              prescribed "Notice of Construction" shall be submitted to the
              Office of the Building Official.
            </li>
            <li>
              That upon completion of the construction, the licensed full-time
              inspector and supervisor/in-charge of construction works shall
              submit the entry to the logbook duly signed and sealed to the
              building official including as-built plans and other documents,
              and shall also accomplish the Certificate of Completion stating
              that the architectural works conform to the provision of the
              Architectural Code, the National Building Code and its IRR.
            </li>
            <li>
              That this permit is null and void unless accompanied by the
              building permit.
            </li>
          </ol>

          <h4 class="text-subtitle-1 mt-4 mb-2">PERMIT ISSUED BY:</h4>
          <div class="static-field-group text-center">
            <!-- This remains a v-text-field as it needs to be interactive -->
            <v-text-field
              label="ALEXANDER N. CANING"
              v-model="form.permitIssuedBy.name"
              clearable
              variant="plain"
              density="compact"
              hide-details
              class="plain-input"
            />
            <div class="text-caption mt-1">BUILDING OFFICIAL</div>
            <div class="text-caption">(Signature Over Printed Name)</div>
            <!-- This remains a v-text-field as it needs to be interactive -->
            <v-text-field
              label="Date"
              v-model="form.permitIssuedBy.date"
              type="date"
              clearable
              variant="plain"
              density="compact"
              hide-details
              class="plain-input"
            />
          </div>
        </v-card-text>
      </v-card>

      <v-row class="mt-6">
        <v-col cols="12" class="d-flex justify-end">
          <v-btn
            color="grey-darken-1"
            variant="outlined"
            class="mr-4"
            @click="resetForm"
          >
            Reset Form
          </v-btn>
          <v-btn color="blue-darken-3" @click="submitForm">
            Download Form
          </v-btn>
        </v-col>
      </v-row>
    </v-form>

    <v-snackbar
      v-model="showMessage"
      :timeout="3000"
      :color="messageColor"
      top
      right
    >
      {{ statusMessage }}
      <template v-slot:actions>
        <v-btn color="white" variant="text" @click="showMessage = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-container>
</template>

<script>
  export default {
    data() {
      return {
        valid: false, // Overall form validity - still used for highlighting, but not blocking submit
        showMessage: false, // Controls visibility of the snackbar message
        statusMessage: '', // The message to display in the snackbar
        messageColor: '', // Color of the snackbar (e.g., 'success', 'error')
        form: {
          lastName: '',
          firstName: '',
          mi: '',
          tin: '',
          address: {
            no: '',
            street: '',
            barangay: '',
            city: '',
          },
          zip: '',
          phone: '',
          email: '',
          location: {
            lotNo: '',
            blkNo: '',
            tctNo: '',
            taxDecNo: '',
            street: '',
            barangay: '',
            city: '',
          },
          scope: '',
          scopeOtherDetails: '',
          natureOfCivilStructuralWorks: {
            staking: false,
            excavation: false,
            soilStabilization: false,
            pilingWorks: false,
            foundation: false,
            erectionLifting: false,
            concreteFraming: false,
            structuralSteelFraming: false,
            slabs: false,
            walls: false,
            prestressWorks: false,
            materialTesting: false,
            steelTowers: false,
            tanks: false,
            others: false,
            othersDetails: '',
          },
          // Added these for data consistency with other forms, if not explicitly removed by user
          siteOccupancy: {
            buildingFootPrint: '',
            imperviousSurfaceArea: '',
            unpavedSurfaceArea: '',
            others: '',
          },
          fireCodeConformance: {
            numWidthExitDoors: false,
            widthCorridors: false,
            distanceFireExits: false,
            accessPublicStreets: false,
            fireWalls: false,
            fireFightingSafety: false,
            smokeDetectors: false,
            emergencyLights: false,
            others: false,
          },
          designProfessional: {
            architectName: '',
            date: '',
            address: '',
            iapoaNo: '',
            iapoaValidity: '',
            prcNo: '',
            prcValidity: '',
            ptrNo: '',
            ptrDateIssued: '',
            issuedAt: '',
            tin: '',
          },
          supervisorArchitectural: { // Renamed from supervisorCivilStructural to match frontend text
            architectName: '', // Retaining architectName as field text suggests architect/engineer
            date: '',
            address: '',
            iapoaNo: '', // Assuming APO No. in frontend maps to this in backend for consistency
            iapoaValidity: '',
            prcNo: '',
            prcValidity: '',
            ptrNo: '',
            ptrDateIssued: '',
            issuedAt: '',
            tin: '',
          },
          buildingOwner: {
            signatureName: '',
            date: '',
            address: '',
            ctcNo: '',
            dateIssued: '',
            placeIssued: '',
          },
          lotOwner: {
            signatureName: '',
            date: '',
            address: '',
            ctcNo: '',
            dateIssued: '',
            placeIssued: '',
          },
          civilStructuralDocuments: {
            designsComputations: false,
            billOfMaterials: false,
            costEstimates: false,
            others: false,
            othersDetails: '',
          },
          // Added for Prepared By in "Nature of Civil/Structural Works" section
          buildingDetails: {
            numStorey: '',
            totalArea: '',
            proposedDateOfConstruction: '',
            totalCostOfInstallation: '',
            expectedDateOfCompletion: '',
            preparedBy: '', // Added this line
          },
          // New fields for data in Box 7 Received By and Date Received
          box7ReceivedBy: '',
          box7DateReceived: '',
          // New fields for data in Box 9 Permit Issued By
          permitIssuedBy: {
            name: '',
            date: '',
          },
        },
        rules: {
          required: value => !!value || 'This field is required.',
          email: value => {
            if (!value) return true;
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern.test(value) || 'Invalid e-mail.';
          },
          numericOnly: value => {
            if (value === null || value === '') return true;
            const pattern = /^[0-9]+$/;
            return pattern.test(value) || 'Only numbers are allowed.';
          },
          numericAndDecimalOnly: value => {
            if (value === null || value === '') return true;
            const pattern = /^[0-9]*(\.[0-9]+)?$/;
            return pattern.test(value) || 'Only numbers and decimals are allowed.';
          },
          requiredIfOthers: value => {
            if (this.form.scope === 'othersScope') {
              return !!value || 'Please specify details for "OTHERS (Specify)".';
            }
            return true;
          },
          requiredIfNatureOthers: value => {
            if (this.form.natureOfCivilStructuralWorks.others) {
              return !!value || 'Please specify details for "OTHERS" civil/structural works.';
            }
            return true;
          },
          requiredIfCivilStructuralOthersDocuments: value => {
            if (this.form.civilStructuralDocuments.others) {
              return !!value || 'Please specify details for "OTHERS" civil/structural documents.';
            }
            return true;
          },
        },
      };
    },
    computed: {
      showOthersField() {
        return this.form.scope === 'othersScope';
      },
    },
    watch: {
      form: {
        handler(newValue) {
          localStorage.setItem('structuralPermitForm', JSON.stringify(newValue));
          console.log('Form data saved to localStorage.');
        },
        deep: true, // Watch for changes inside nested objects
      },
    },
    mounted() {
      // Attempt to load unsaved draft from local storage first
      this.loadDraftFromLocalStorage();

      // If, after attempting to load a draft, the form is still empty (meaning no draft was found or loaded),
      // then load the last submitted data from the server.
      if (this.isFormEmpty(this.form)) {
        this.loadFormData(); // This method now focuses on loading from the server
      }
    },
    methods: {
      loadDraftFromLocalStorage() {
        const savedForm = localStorage.getItem('structuralPermitForm');
        if (savedForm) {
          try {
            const parsedForm = JSON.parse(savedForm);
            // Only load if the parsed form is not empty or default
            if (Object.keys(parsedForm).length > 0 && !this.isFormEmpty(parsedForm)) {
              this.form = parsedForm;
              this.statusMessage = 'Draft data loaded from your last session.';
              this.messageColor = 'info';
              this.showMessage = true;
            }
          } catch (e) {
            console.error("Error parsing localStorage data:", e);
            localStorage.removeItem('structuralPermitForm'); // Clear bad data
          }
        }
      },
      isFormEmpty(form) {
        // Create a comparison object based on the initial state
        const initialData = this.$options.data.apply(this);
        const defaultForm = initialData.form;
        
        // Deep compare only the fields that are expected to be filled by user
        // and ignore computed properties or initial UI states
        const fieldsToCheck = [
          'lastName', 'firstName', 'mi', 'tin', 'address', 'zip', 'phone', 'email',
          'location', 'scope', 'scopeOtherDetails', 'natureOfCivilStructuralWorks',
          'siteOccupancy', 'fireCodeConformance', 'designProfessional',
          'supervisorArchitectural', 'buildingOwner', 'lotOwner',
          'civilStructuralDocuments', 'box7ReceivedBy', 'box7DateReceived', 'permitIssuedBy'
        ];

        for (const field of fieldsToCheck) {
            if (JSON.stringify(form[field]) !== JSON.stringify(defaultForm[field])) {
                return false; // If any field is different, form is not empty
            }
        }
        return true; // All user-fillable fields match default, so it's empty
      },
      async loadFormData() {
        try {
          const response = await fetch('http://localhost/buildingpermitapplication/src/document/structural-backend/structural.php', {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
            },
          });
          const result = await response.json();

          if (result.success && result.data) {
            const loadedData = result.data;
            // Map the flat database structure back to your nested form object
            this.form.lastName = loadedData.last_name || '';
            this.form.firstName = loadedData.first_name || '';
            this.form.mi = loadedData.middle_initial || '';
            this.form.tin = loadedData.tin || '';
            this.form.address.no = loadedData.owner_address_no || '';
            this.form.address.street = loadedData.owner_address_street || '';
            this.form.address.barangay = loadedData.owner_address_barangay || '';
            this.form.address.city = loadedData.owner_address_city || '';
            this.form.zip = loadedData.zip_code || '';
            this.form.phone = loadedData.phone_number || '';
            this.form.email = loadedData.email_address || '';

            this.form.location.lotNo = loadedData.location_lot_no || '';
            this.form.location.blkNo = loadedData.location_blk_no || '';
            this.form.location.tctNo = loadedData.location_tct_no || '';
            this.form.location.taxDecNo = loadedData.location_tax_dec_no || '';
            this.form.location.street = loadedData.location_street || '';
            this.form.location.barangay = loadedData.location_barangay || '';
            this.form.location.city = loadedData.location_city || '';

            this.form.scope = loadedData.scope_of_work || '';
            this.form.scopeOtherDetails = loadedData.scope_other_details || '';

            // Nature of Civil/Structural Works mapping
            this.form.natureOfCivilStructuralWorks.staking = !!parseInt(loadedData.nature_staking);
            this.form.natureOfCivilStructuralWorks.excavation = !!parseInt(loadedData.nature_excavation);
            this.form.natureOfCivilStructuralWorks.soilStabilization = !!parseInt(loadedData.nature_soil_stabilization);
            this.form.natureOfCivilStructuralWorks.pilingWorks = !!parseInt(loadedData.nature_piling_works);
            this.form.natureOfCivilStructuralWorks.foundation = !!parseInt(loadedData.nature_foundation);
            this.form.natureOfCivilStructuralWorks.erectionLifting = !!parseInt(loadedData.nature_erection_lifting);
            this.form.natureOfCivilStructuralWorks.concreteFraming = !!parseInt(loadedData.nature_concrete_framing);
            this.form.natureOfCivilStructuralWorks.structuralSteelFraming = !!parseInt(loadedData.nature_structural_steel_framing);
            this.form.natureOfCivilStructuralWorks.slabs = !!parseInt(loadedData.nature_slabs);
            this.form.natureOfCivilStructuralWorks.walls = !!parseInt(loadedData.nature_walls);
            this.form.natureOfCivilStructuralWorks.prestressWorks = !!parseInt(loadedData.nature_prestress_works);
            this.form.natureOfCivilStructuralWorks.materialTesting = !!parseInt(loadedData.nature_material_testing);
            this.form.natureOfCivilStructuralWorks.steelTowers = !!parseInt(loadedData.nature_steel_towers);
            this.form.natureOfCivilStructuralWorks.tanks = !!parseInt(loadedData.nature_tanks);
            this.form.natureOfCivilStructuralWorks.others = !!parseInt(loadedData.nature_others);
            this.form.natureOfCivilStructuralWorks.othersDetails = loadedData.nature_others_details || '';

            // Site Occupancy
            this.form.siteOccupancy.buildingFootPrint = loadedData.site_building_foot_print || '';
            this.form.siteOccupancy.imperviousSurfaceArea = loadedData.site_impervious_surface_area || '';
            this.form.siteOccupancy.unpavedSurfaceArea = loadedData.site_unpaved_surface_area || '';
            this.form.siteOccupancy.others = loadedData.site_others || '';

            // Fire Code Conformance
            this.form.fireCodeConformance.numWidthExitDoors = !!parseInt(loadedData.fire_num_width_exit_doors);
            this.form.fireCodeConformance.widthCorridors = !!parseInt(loadedData.fire_width_corridors);
            this.form.fireCodeConformance.distanceFireExits = !!parseInt(loadedData.fire_distance_fire_exits);
            this.form.fireCodeConformance.accessPublicStreets = !!parseInt(loadedData.fire_access_public_streets);
            this.form.fireCodeConformance.fireWalls = !!parseInt(loadedData.fire_walls);
            this.form.fireCodeConformance.fireFightingSafety = !!parseInt(loadedData.fire_fighting_safety);
            this.form.fireCodeConformance.smokeDetectors = !!parseInt(loadedData.fire_smoke_detectors);
            this.form.fireCodeConformance.emergencyLights = !!parseInt(loadedData.fire_emergency_lights);
            this.form.fireCodeConformance.others = !!parseInt(loadedData.fire_others);

            // Box 3: Design Professional
            this.form.designProfessional.architectName = loadedData.design_prof_architect_name || '';
            this.form.designProfessional.date = loadedData.design_prof_date || '';
            this.form.designProfessional.address = loadedData.design_prof_address || '';
            this.form.designProfessional.iapoaNo = loadedData.design_prof_iapoa_no || '';
            this.form.designProfessional.iapoaValidity = loadedData.design_prof_iapoa_validity || '';
            this.form.designProfessional.prcNo = loadedData.design_prof_prc_no || '';
            this.form.designProfessional.prcValidity = loadedData.design_prof_prc_validity || '';
            this.form.designProfessional.ptrNo = loadedData.design_prof_ptr_no || '';
            this.form.designProfessional.ptrDateIssued = loadedData.design_prof_ptr_date_issued || '';
            this.form.designProfessional.issuedAt = loadedData.design_prof_issued_at || '';
            this.form.designProfessional.tin = loadedData.design_prof_tin || '';

            // Box 4: Supervisor / In-Charge of Architectural Works
            this.form.supervisorArchitectural.architectName = loadedData.supervisor_architectural_name || '';
            this.form.supervisorArchitectural.date = loadedData.supervisor_architectural_date || '';
            this.form.supervisorArchitectural.address = loadedData.supervisor_architectural_address || '';
            this.form.supervisorArchitectural.iapoaNo = loadedData.supervisor_architectural_iapoa_no || '';
            this.form.supervisorArchitectural.iapoaValidity = loadedData.supervisor_architectural_iapoa_validity || '';
            this.form.supervisorArchitectural.prcNo = loadedData.supervisor_architectural_prc_no || '';
            this.form.supervisorArchitectural.prcValidity = loadedData.supervisor_architectural_prc_validity || '';
            this.form.supervisorArchitectural.ptrNo = loadedData.supervisor_architectural_ptr_no || '';
            this.form.supervisorArchitectural.ptrDateIssued = loadedData.supervisor_architectural_ptr_date_issued || '';
            this.form.supervisorArchitectural.issuedAt = loadedData.supervisor_architectural_issued_at || '';
            this.form.supervisorArchitectural.tin = loadedData.supervisor_architectural_tin || '';

            // Box 5: Building Owner
            this.form.buildingOwner.signatureName = loadedData.building_owner_signature_name || '';
            this.form.buildingOwner.date = loadedData.building_owner_date || '';
            this.form.buildingOwner.address = loadedData.building_owner_address || '';
            this.form.buildingOwner.ctcNo = loadedData.building_owner_ctc_no || '';
            this.form.buildingOwner.dateIssued = loadedData.building_owner_date_issued || '';
            this.form.buildingOwner.placeIssued = loadedData.building_owner_place_issued || '';

            // Box 6: Lot Owner
            this.form.lotOwner.signatureName = loadedData.lot_owner_signature_name || '';
            this.form.lotOwner.date = loadedData.lot_owner_date || '';
            this.form.lotOwner.address = loadedData.lot_owner_address || '';
            this.form.lotOwner.ctcNo = loadedData.lot_owner_ctc_no || '';
            this.form.lotOwner.dateIssued = loadedData.lot_owner_date_issued || '';
            this.form.lotOwner.placeIssued = loadedData.lot_owner_place_issued || '';

            // Box 7: Civil/Structural Documents
            this.form.civilStructuralDocuments.designsComputations = !!parseInt(loadedData.doc_designs_computations);
            this.form.civilStructuralDocuments.billOfMaterials = !!parseInt(loadedData.doc_bill_of_materials);
            this.form.civilStructuralDocuments.costEstimates = !!parseInt(loadedData.doc_cost_estimates);
            this.form.civilStructuralDocuments.others = !!parseInt(loadedData.doc_others);
            this.form.civilStructuralDocuments.othersDetails = loadedData.doc_others_details || '';
            this.form.box7ReceivedBy = loadedData.box7_received_by || '';
            this.form.box7DateReceived = loadedData.box7_date_received || '';

            // Prepared By (from nature of civil/structural works section)
            this.form.buildingDetails.preparedBy = loadedData.building_prepared_by || '';


            // Box 9: Permit Issued By
            this.form.permitIssuedBy.name = loadedData.permit_issued_by_name || '';
            this.form.permitIssuedBy.date = loadedData.permit_issued_by_date || '';

            this.statusMessage = 'Previous submitted data loaded successfully.';
            this.messageColor = 'info';
            this.showMessage = true;
          } else {
            console.log('No previous submitted data found from server or error loading:', result.message);
            this.statusMessage = 'No previous submitted data found on server.';
            this.messageColor = 'info';
            this.showMessage = true;
          }
        } catch (error) {
          console.error('Error loading form data from server:', error);
          this.statusMessage = 'Error loading previous submitted data from server.';
          this.messageColor = 'error';
          this.showMessage = true;
        }
      },
      async submitForm() {
        // We will no longer block submission based on client-side validation results.
        // Instead, we perform validation to highlight issues, but proceed with submission.
        const { valid } = await this.$refs.form.validate(); // This still triggers visual feedback
        
        // You can add a warning message here if the form is not valid
        if (!valid) {
            this.statusMessage = 'Form has incomplete or invalid fields, but will attempt submission.';
            this.messageColor = 'warning';
            this.showMessage = true;
            console.log('Form is invalid according to frontend rules, but submitting anyway.');
        }


        // Proceed with submission regardless of frontend validation status
        try {
            const response = await fetch('http://localhost/buildingpermitapplication/src/document/structural-backend/structural.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify(this.form), // Send your form data as JSON
            });

            const result = await response.json();

            if (result.success) {
              this.statusMessage = result.message;
              this.messageColor = 'success';
              this.showMessage = true;
              console.log('Form submitted successfully:', result.message);
              localStorage.removeItem('structuralPermitForm'); // Clear local storage on successful submission
              this.resetForm(); // Reset form after successful submission
            } else {
              this.statusMessage = 'Submission failed: ' + result.message;
              this.messageColor = 'error';
              this.showMessage = true;
              console.error('Form submission failed:', result.message);
            }
          } catch (error) {
            this.statusMessage = 'An error occurred during submission. Please try again.';
            this.messageColor = 'error';
            this.showMessage = true;
            console.error('Error during form submission:', error);
          }
      },
      resetForm() {
        this.$refs.form.reset();
        this.$refs.form.resetValidation();

        // Deep reset for nested objects
        const initialData = this.$options.data.apply(this);
        this.form = JSON.parse(JSON.stringify(initialData.form)); // Deep copy initial state

        localStorage.removeItem('structuralPermitForm'); // Clear local storage on reset
        this.statusMessage = 'Form has been reset.';
        this.messageColor = 'info';
        this.showMessage = true;
      },
    },
  };
</script>

<style scoped>
  /* Styles for plain input fields, typically used for official sections or static data */
  .plain-input.v-text-field {
    --v-input-control-height: auto; /* Allow content to dictate height */
    --v-input-padding-top: 0;
    --v-input-padding-bottom: 0;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
  }

  /* Specific styling for plain variant text fields to ensure consistent appearance */
  .plain-input.v-text-field .v-input__control {
    min-height: unset !important;
    padding: 0 !important;
    margin: 0 !important;
  }

  .plain-input.v-text-field .v-field {
    padding: 0 !important; /* Remove all internal padding from v-field */
    border-bottom: 1px solid #ccc !important; /* Keep the desired underline */
    border-radius: 0 !important; /* No rounded corners */
    background-color: transparent !important; /* No background */
    box-shadow: none !important; /* No shadow */
  }

  /* Crucial: Hide all parts of the default Vuetify field appearance */
  .plain-input.v-text-field .v-field__overlay,
  .plain-input.v-text-field .v-field__outline,
  .plain-input.v-text-field .v-field__details,
  .plain-input.v-text-field .v-field__append-inner,
  .plain-input.v-text-field .v-field__prepend-inner,
  .plain-input.v-text-field .v-field__clearable {
    display: none !important;
  }

  /* Ensure the input itself takes full width and has desired text alignment */
  .plain-input.v-text-field .v-field__input {
    width: 100% !important; /* Make sure it spans the full width */
    text-align: left !important;
    padding: 0 0 2px 0 !important; /* Only bottom padding to match line aesthetic */
    min-height: unset !important;
    line-height: normal !important; /* Prevent extra line height */
    height: auto !important; /* Adjust height to content */
    opacity: 1 !important; /* Ensure text is always visible */
  }

  /* Style the label to always be above the line and appear static */
  .plain-input.v-text-field .v-label {
    top: 0 !important;
    left: 0 !important;
    transform: none !important;
    position: relative !important;
    opacity: 0.8 !important; /* Slightly more opaque than 0.6 for better readability */
    font-size: 0.75rem !important;
    color: rgba(0, 0, 0, 0.8) !important; /* Darker color for labels */
    margin-bottom: 4px !important; /* Space between label and line */
    pointer-events: none !important; /* Prevent label from capturing clicks */
  }

  /* Remove hover/focus effects */
  .plain-input.v-text-field .v-field:hover,
  .plain-input.v-text-field .v-field.v-field--active {
    background-color: transparent !important;
    cursor: text !important; /* Keep text cursor if editable */
  }
  .plain-input.v-text-field .v-field:before,
  .plain-input.v-text-field .v-field:after {
      display: none !important; /* Hide Vuetify's default before/after pseudo elements for borders/highlights */
  }

  /* For text fields within static-field-group, especially for signature lines */
  .static-field-group .v-text-field .v-label {
      top: 0 !important;
      left: 0 !important;
      transform: none !important;
      position: relative !important;
      opacity: 0.8 !important;
      font-size: 0.75rem !important;
      color: rgba(0, 0, 0, 0.8) !important;
      margin-bottom: 4px !important;
      pointer-events: none !important;
  }

  .static-field-group .v-text-field .v-field__input {
      padding-top: 0 !important;
      padding-bottom: 2px !important; /* Small padding above line */
      text-align: center !important; /* Center text if it's acting as a signature line */
  }

  .static-field-group .v-text-field .v-field {
      border-bottom: 1px solid #ccc !important;
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

  .border-bottom-dark {
    border-bottom: 1px solid #000;
  }

  .border-right-dark {
    border-right: 1px solid #000;
  }
</style>
