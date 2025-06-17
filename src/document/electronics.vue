<template>
  <v-container>
    <h2 class="text-h4 text-center mb-8 text-blue-darken-3">
      ELECTRONICS PERMIT
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

      <!-- NATURE OF INSTALLATION WORKS/EQUIPMENT SYSTEM: -->
      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >NATURE OF INSTALLATION WORKS/EQUIPMENT SYSTEM:</v-card-title
        >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="4">
              <v-checkbox
                label="TELECOMMUNICATION SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.staking"
                hide-details
              />
              <v-checkbox
                label="BROADCASTING SYSTEM "
                v-model="form.natureOfCivilStructuralWorks.excavation"
                hide-details
              />
              <v-checkbox
                label=" TELEVISION SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.soilStabilization"
                hide-details
              />
              <v-checkbox
                label="INFORMATION TECHNOLOGY SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.pilingWorks"
                hide-details
              />
              <v-checkbox
                label="SECURITY AND ALARM SYSTEM ANY OTHER ELECTRONICS AND IT SYSTEMS, EQUIPMENT, APPARATUS, DEVICE AND/OR COMPONENT"
                v-model="form.natureOfCivilStructuralWorks.foundation"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-checkbox
                label="ELECTRONICS AND ALARM SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.erectionLifting"
                hide-details
              />
              <v-checkbox
                label="SOUND COMMUNICATION SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.concreteFraming"
                hide-details
              />
              <v-checkbox
                label="CENTRALIZED CLOCK SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.structuralSteelFraming"
                hide-details
              />
              <v-checkbox
                label="SOUND SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.slabs"
                hide-details
              />
              <v-checkbox
                label="ELECTRONICS CONTROL AND CONVEYOR SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.walls"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-checkbox
                label="ELECTRONICS COMPUTERIZED PROCESS CONTROLS AUTOMATION SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.prestressWorks"
                hide-details
              />
              <v-checkbox
                label="BUILDING AUTOMATION MANAGEMENT AND CONTROL SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.materialTesting"
                hide-details
              />
              <v-checkbox
                label="BUILDING WIRING UTILIZING COPPER CABLE FIBER OPTIC CABLE OR OTHER MEDIAL ELECTRONICS SYSTEM"
                v-model="form.natureOfCivilStructuralWorks.steelTowers"
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
          <v-text-field
            v-model="form.preparedBy"
            class="plain-input"
            hide-details
            label="Name"
          />
        </v-card-text>
      </v-card>

      <!-- BOX 3 & BOX 4 - Static Display -->
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
                  ENGINEER (Signed and Sealed Over Printed Name)
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
                    <div class="static-line-label">APO No.</div>
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
              <v-row>
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
            </v-col>
            <v-col cols="6" class="py-2 pl-4">
              <span class="font-weight-bold">DATE:</span>
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
                label="ELECTRONICS PLANS AND SPECIFI CATIONS"
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
            @click="resetForm"
          >
            Reset Form
          </v-btn>
          <v-btn color="blue-darken-3" @click="submitForm" :disabled="!valid">
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
        valid: false, // Overall form validity
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
          preparedBy: '', // Added preparedBy here
          natureOfCivilStructuralWorks: { // Corresponds to 'nature_' fields in DB
            staking: false, // -> nature_telecom
            excavation: false, // -> nature_broadcast
            soilStabilization: false, // -> nature_tv
            pilingWorks: false, // -> nature_it
            foundation: false, // -> nature_security_alarm
            erectionLifting: false, // -> nature_electronics_alarm
            concreteFraming: false, // -> nature_sound_comm
            structuralSteelFraming: false, // -> nature_central_clock
            slabs: false, // -> nature_sound_system
            walls: false, // -> nature_elec_control_conveyor
            prestressWorks: false, // -> nature_elec_comp_process_auto
            materialTesting: false, // -> nature_building_auto_mgmt_ctrl
            steelTowers: false, // -> nature_building_wiring_cable
            tanks: false,
            others: false,
            othersDetails: '',
          },
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
          supervisorArchitectural: {
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
          civilStructuralDocuments: { // Corresponds to 'doc_' fields in DB
            designsComputations: false, // -> doc_designs_comp
            billOfMaterials: false, // -> doc_bill_materials
            costEstimates: false,
            others: false,
            othersDetails: '',
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
          localStorage.setItem('electronicsPermitForm', JSON.stringify(newValue));
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
        const savedForm = localStorage.getItem('electronicsPermitForm'); // Changed key
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
            localStorage.removeItem('electronicsPermitForm'); // Clear bad data
          }
        }
      },
      isFormEmpty(form) {
        // Get a fresh instance of the default form state for comparison
        const defaultForm = this.$options.data.apply(this).form;
        // Stringify and compare to check for deep equality
        return JSON.stringify(form) === JSON.stringify(defaultForm);
      },
      async loadFormData() {
        try {
          const response = await fetch('http://localhost/buildingpermitapplication/src/document/electronics-backend/electronics.php', { // Changed URL
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
            this.form.mi = loadedData.mi || '';
            this.form.tin = loadedData.tin || '';
            this.form.address.no = loadedData.address_no || '';
            this.form.address.street = loadedData.address_street || '';
            this.form.address.barangay = loadedData.address_barangay || '';
            this.form.address.city = loadedData.address_city || '';
            this.form.zip = loadedData.zip || '';
            this.form.phone = loadedData.phone || '';
            this.form.email = loadedData.email || '';

            this.form.location.lotNo = loadedData.location_lot_no || '';
            this.form.location.blkNo = loadedData.location_blk_no || '';
            this.form.location.tctNo = loadedData.location_tct_no || '';
            this.form.location.taxDecNo = loadedData.location_tax_dec_no || '';
            this.form.location.street = loadedData.location_street || '';
            this.form.location.barangay = loadedData.location_barangay || '';
            this.form.location.city = loadedData.location_city || '';

            this.form.scope = loadedData.scope || '';
            this.form.scopeOtherDetails = loadedData.scope_other_details || '';
            this.form.preparedBy = loadedData.prepared_by || ''; // Map preparedBy

            // Nature of Installation Works/Equipment System Checkboxes - Using new shorter names
            this.form.natureOfCivilStructuralWorks.staking = !!parseInt(loadedData.nature_telecom);
            this.form.natureOfCivilStructuralWorks.excavation = !!parseInt(loadedData.nature_broadcast);
            this.form.natureOfCivilStructuralWorks.soilStabilization = !!parseInt(loadedData.nature_tv);
            this.form.natureOfCivilStructuralWorks.pilingWorks = !!parseInt(loadedData.nature_it);
            this.form.natureOfCivilStructuralWorks.foundation = !!parseInt(loadedData.nature_security_alarm);
            this.form.natureOfCivilStructuralWorks.erectionLifting = !!parseInt(loadedData.nature_electronics_alarm);
            this.form.natureOfCivilStructuralWorks.concreteFraming = !!parseInt(loadedData.nature_sound_comm);
            this.form.natureOfCivilStructuralWorks.structuralSteelFraming = !!parseInt(loadedData.nature_central_clock);
            this.form.natureOfCivilStructuralWorks.slabs = !!parseInt(loadedData.nature_sound_system);
            this.form.natureOfCivilStructuralWorks.walls = !!parseInt(loadedData.nature_elec_control_conveyor);
            this.form.natureOfCivilStructuralWorks.prestressWorks = !!parseInt(loadedData.nature_elec_comp_process_auto);
            this.form.natureOfCivilStructuralWorks.materialTesting = !!parseInt(loadedData.nature_building_auto_mgmt_ctrl);
            this.form.natureOfCivilStructuralWorks.steelTowers = !!parseInt(loadedData.nature_building_wiring_cable);
            this.form.natureOfCivilStructuralWorks.tanks = !!parseInt(loadedData.nature_tanks);
            this.form.natureOfCivilStructuralWorks.others = !!parseInt(loadedData.nature_others);
            this.form.natureOfCivilStructuralWorks.othersDetails = loadedData.nature_others_details || '';


            this.form.siteOccupancy.buildingFootPrint = loadedData.site_building_foot_print || '';
            this.form.siteOccupancy.imperviousSurfaceArea = loadedData.site_impervious_surface_area || '';
            this.form.siteOccupancy.unpavedSurfaceArea = loadedData.site_unpaved_surface_area || '';
            this.form.siteOccupancy.others = loadedData.site_others || '';

            this.form.fireCodeConformance.numWidthExitDoors = !!parseInt(loadedData.fire_num_width_exit_doors);
            this.form.fireCodeConformance.widthCorridors = !!parseInt(loadedData.fire_width_corridors);
            this.form.fireCodeConformance.distanceFireExits = !!parseInt(loadedData.fire_distance_fire_exits);
            this.form.fireCodeConformance.accessPublicStreets = !!parseInt(loadedData.fire_access_public_streets);
            this.form.fireCodeConformance.fireWalls = !!parseInt(loadedData.fire_walls);
            this.form.fireCodeConformance.fireFightingSafety = !!parseInt(loadedData.fire_fighting_safety);
            this.form.fireCodeConformance.smokeDetectors = !!parseInt(loadedData.fire_smoke_detectors);
            this.form.fireCodeConformance.emergencyLights = !!parseInt(loadedData.fire_emergency_lights);
            this.form.fireCodeConformance.others = !!parseInt(loadedData.fire_others);

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

            this.form.buildingOwner.signatureName = loadedData.building_owner_signature_name || '';
            this.form.buildingOwner.date = loadedData.building_owner_date || '';
            this.form.buildingOwner.address = loadedData.building_owner_address || '';
            this.form.buildingOwner.ctcNo = loadedData.building_owner_ctc_no || '';
            this.form.buildingOwner.dateIssued = loadedData.building_owner_date_issued || '';
            this.form.buildingOwner.placeIssued = loadedData.building_owner_place_issued || '';

            this.form.lotOwner.signatureName = loadedData.lot_owner_signature_name || '';
            this.form.lotOwner.date = loadedData.lot_owner_date || '';
            this.form.lotOwner.address = loadedData.lot_owner_address || '';
            this.form.lotOwner.ctcNo = loadedData.lot_owner_ctc_no || '';
            this.form.lotOwner.dateIssued = loadedData.lot_owner_date_issued || '';
            this.form.lotOwner.placeIssued = loadedData.lot_owner_place_issued || '';

            // Civil Structural Documents (Box 7) - Using new shorter names
            this.form.civilStructuralDocuments.designsComputations = !!parseInt(loadedData.doc_designs_comp);
            this.form.civilStructuralDocuments.billOfMaterials = !!parseInt(loadedData.doc_bill_materials);
            this.form.civilStructuralDocuments.costEstimates = !!parseInt(loadedData.doc_cost_estimates);
            this.form.civilStructuralDocuments.others = !!parseInt(loadedData.doc_others);
            this.form.civilStructuralDocuments.othersDetails = loadedData.doc_others_details || '';

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
        const { valid } = await this.$refs.form.validate();
        if (valid) {
          console.log('Form is valid and attempting submission:', this.form);
          try {
            const response = await fetch('http://localhost/buildingpermitapplication/src/document/electronics-backend/electronics.php', { // Changed URL
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
              localStorage.removeItem('electronicsPermitForm'); // Clear local storage on successful submission
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
        } else {
          this.statusMessage = 'Please fill in all required fields.';
          this.messageColor = 'warning';
          this.showMessage = true;
          console.log('Form is invalid. Please check the fields.');
        }
      },
      resetForm() {
        this.$refs.form.reset();
        this.$refs.form.resetValidation();
        // Manually reset specific fields or nested objects if `reset()` doesn't handle them fully
        // This is crucial to ensure a clean slate after submission or explicit reset.
        this.form = this.$options.data.apply(this).form; // Reset to initial data state
        localStorage.removeItem('electronicsPermitForm'); // Clear local storage on reset
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

  .border-bottom-dark {
    border-bottom: 1px solid #000;
  }

  .border-right-dark {
    border-right: 1px solid #000;
  }
</style>
