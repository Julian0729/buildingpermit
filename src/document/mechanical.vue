<template>
  <v-container>
    <h2 class="text-h4 text-center mb-8 text-blue-darken-3">
      MECHANICAL PERMIT
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

      <!-- INSTALLATION AND OPERATION OF: -->
      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >INSTALLATION AND OPERATION OF:</v-card-title
        >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="4">
              <v-checkbox
                label="BOILER"
                v-model="form.natureOfCivilStructuralWorks.staking"
                hide-details
              />
              <v-checkbox
                label="PRESSURE VESSEL"
                v-model="form.natureOfCivilStructuralWorks.excavation"
                hide-details
              />
              <v-checkbox
                label="INTERNAL COMBUSTION ENGINE"
                v-model="form.natureOfCivilStructuralWorks.soilStabilization"
                hide-details
              />
              <v-checkbox
                label="REFRIGERATION AND ICE MAKING"
                v-model="form.natureOfCivilStructuralWorks.pilingWorks"
                hide-details
              />
              <v-checkbox
                label="WINDOW TYPE AIRCONDITIONING "
                v-model="form.natureOfCivilStructuralWorks.foundation"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-checkbox
                label="CENTRAL AIRCONDITIONING"
                v-model="form.natureOfCivilStructuralWorks.erectionLifting"
                hide-details
              />
              <v-checkbox
                label="MECHANICAL VENTILATION"
                v-model="form.natureOfCivilStructuralWorks.concreteFraming"
                hide-details
              />
              <v-checkbox
                label="ESCALATOR"
                v-model="form.natureOfCivilStructuralWorks.structuralSteelFraming"
                hide-details
              />
              <v-checkbox
                label="FREIGHT ELEVATOR"
                v-model="form.natureOfCivilStructuralWorks.slabs"
                hide-details
              />
              <v-checkbox
                label="PASSENGER ELEVATOR"
                v-model="form.natureOfCivilStructuralWorks.walls"
                hide-details
              />
              <v-checkbox
                label=" CABLE CAR"
                v-model="form.natureOfCivilStructuralWorks.walls"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-checkbox
                label="DUMBWAITER"
                v-model="form.natureOfCivilStructuralWorks.prestressWorks"
                hide-details
              />
              <v-checkbox
                label="PUMPS"
                v-model="form.natureOfCivilStructuralWorks.materialTesting"
                hide-details
              />
              <v-checkbox
                label="COMPRESSED AIR, VACCUM, INSTITUTIONAL AND/OR INDUSTRIAL GAS"
                v-model="form.natureOfCivilStructuralWorks.steelTowers"
                hide-details
              />
              <v-checkbox
                label="PNEUMATIC TUBES, CONVEYORS AND/OR MONORAILS"
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
          <div class="static-line"></div>
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
              <v-text-field
                label="(Signature Over Printed Name)"
                v-model="form.buildingOwner.signatureName"
                class="plain-input"
                hide-details
              />
              <v-text-field
                label="Date"
                v-model="form.buildingOwner.date"
                class="plain-input"
                hide-details
              />
              <v-text-field
                label="Address"
                v-model="form.buildingOwner.address"
                class="plain-input"
                hide-details
              />
              <v-row>
                <v-col cols="6">
                  <v-text-field
                    label="C.T.C. No."
                    v-model="form.buildingOwner.ctcNo"
                    class="plain-input"
                    hide-details
                  />
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    label="Date Issued"
                    v-model="form.buildingOwner.dateIssued"
                    class="plain-input"
                    hide-details
                  />
                </v-col>
              </v-row>
              <v-text-field
                label="Place Issued"
                v-model="form.buildingOwner.placeIssued"
                class="plain-input"
                hide-details
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
                label="ELECTRICAL PLANS AND SPECIFI CATIONS"
                v-model="form.civilStructuralDocuments.designsComputations"
                hide-details
              />
              <v-checkbox
                label="SPECIAL FIXTURES AND EQUIPMENTS"
                v-model="form.civilStructuralDocuments.billOfMaterials"
                hide-details
              />
              <v-checkbox
                label="PRPOSED STARTING DATE OF CONSTRUCTION/INSTALLATION"
                v-model="form.civilStructuralDocuments.billOfMaterials"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-checkbox
                label="PRPOSED STARTING DATE OF CONSTRUCTION/INSTALLATION"
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
            Submit Application
          </v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-container>
</template>

<script>
  export default {
    data() {
      return {
        valid: false, // Overall form validity
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
          natureOfCivilStructuralWorks: { // Renamed from architecturalFacilities
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
          supervisorArchitectural: { // This would ideally be supervisorCivilStructural
            architectName: '', // Retaining architectName for now as fields are generic
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
          civilStructuralDocuments: { // New data properties for BOX 7 (Civil Structural)
            designsComputations: false,
            billOfMaterials: false,
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
          requiredIfCivilStructuralOthersDocuments: value => { // New rule for BOX 7 others
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
    methods: {
      async submitForm() {
        const { valid } = await this.$refs.form.validate();
        if (valid) {
          console.log('Form is valid and submitted:', this.form);
          // Add your form submission logic here (e.g., API call)
        } else {
          console.log('Form is invalid. Please check the fields.');
        }
      },
      resetForm() {
        this.$refs.form.reset();
        this.$refs.form.resetValidation();
        this.form.scopeOtherDetails = '';
        this.form.natureOfCivilStructuralWorks = {
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
        };
        this.form.siteOccupancy = {
          buildingFootPrint: '',
          imperviousSurfaceArea: '',
          unpavedSurfaceArea: '',
          others: '',
        };
        this.form.fireCodeConformance = {
          numWidthExitDoors: false,
          widthCorridors: false,
          distanceFireExits: false,
          accessPublicStreets: false,
          fireWalls: false,
          fireFightingSafety: false,
          smokeDetectors: false,
          emergencyLights: false,
          others: false,
        };
        this.form.buildingOwner = {
          signatureName: '',
          date: '',
          address: '',
          ctcNo: '',
          dateIssued: '',
          placeIssued: '',
        };
        this.form.civilStructuralDocuments = { // Reset new section
            designsComputations: false,
            billOfMaterials: false,
            costEstimates: false,
            others: false,
            othersDetails: '',
        };
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
