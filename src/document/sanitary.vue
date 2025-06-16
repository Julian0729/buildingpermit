<template>
  <v-container>
    <h2 class="text-h4 text-center mb-8 text-blue-darken-3">
      SANITARY/PLUMBING PERMIT APPLICATION
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

          <h4 class="mt-6 mb-4">FIXTURE SCHEDULE</h4>
          <v-row>
            <v-col cols="12" md="6">
              <v-row
                v-for="(fixture, index) in fixtureList1"
                :key="index"
                dense
              >
                <v-col cols="3">
                  <v-text-field
                    v-model="form.fixtures[fixture.value].qty"
                    label="QTY"
                    type="text"
                    :rules="[rules.numericOnly]"
                    variant="outlined"
                    density="compact"
                    hide-details
                  />
                </v-col>
                <v-col cols="9">
                  <v-checkbox
                    :label="fixture.label"
                    v-model="form.fixtures[fixture.value].selected"
                    hide-details
                  />
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="12" md="6">
              <v-row
                v-for="(fixture, index) in fixtureList2"
                :key="index"
                dense
              >
                <v-col cols="3">
                  <v-text-field
                    v-model="form.fixtures[fixture.value].qty"
                    label="QTY"
                    type="text"
                    :rules="[rules.numericOnly]"
                    variant="outlined"
                    density="compact"
                    hide-details
                  />
                </v-col>
                <v-col cols="9">
                  <v-checkbox
                    :label="fixture.label"
                    v-model="form.fixtures[fixture.value].selected"
                    hide-details
                  />
                </v-col>
              </v-row>
            </v-col>
          </v-row>
          <v-row dense class="mt-4">
            <v-col cols="6">
              <v-text-field
                label="TOTAL FIXTURES"
                v-model="totalFixtures"
                readonly
                variant="filled"
                density="compact"
              />
            </v-col>
          </v-row>

          <h4 class="mt-6 mb-4">SYSTEM TYPE</h4>
          <v-row>
            <v-col cols="12" md="4">
              <v-checkbox
                label="WATER DISTRIBUTION SYSTEM"
                v-model="form.systemType.waterDistribution"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-checkbox
                label="SANITARY SEWER SYSTEM"
                v-model="form.systemType.sanitarySewer"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-checkbox
                label="STORM DRAINAGE SYSTEM"
                v-model="form.systemType.stormDrainage"
                hide-details
              />
            </v-col>
          </v-row>

          <v-row class="mt-6">
            <v-col cols="12" md="6">
              <h4 class="mb-3">WATER SUPPLY</h4>
              <v-checkbox
                label="SHALLOW WELL"
                v-model="form.waterSupply.shallowWell"
                hide-details
              />
              <v-checkbox
                label="DEEP WELL AND PUMP SET"
                v-model="form.waterSupply.deepWellPumpSet"
                hide-details
              />
              <v-checkbox
                label="CITY/MUNICIPAL WATER SYSTEM"
                v-model="form.waterSupply.cityMunicipalWaterSystem"
                hide-details
              />
              <v-checkbox
                label="OTHERS (Specify)"
                v-model="form.waterSupply.others"
                hide-details
              />
              <v-expand-transition>
                <v-text-field
                  v-if="form.waterSupply.others"
                  v-model="form.waterSupply.othersDetails"
                  label="Please specify details for 'OTHERS (Specify)'"
                  :rules="[rules.requiredIfWaterSupplyOthers]"
                  class="ml-8 mt-2"
                  clearable
                />
              </v-expand-transition>
            </v-col>

            <v-col cols="12" md="6">
              <h4 class="mb-3">SYSTEM DISPOSAL SYSTEM</h4>
              <v-checkbox
                label="WASTE WATER TREATMENT PLANT"
                v-model="form.systemDisposal.wasteWaterTreatmentPlant"
                hide-details
              />
              <v-checkbox
                label="SEPTIC VAULT/IMHOFF TANK"
                v-model="form.systemDisposal.septicVaultImhoffTank"
                hide-details
              />
              <v-checkbox
                label="SANITARY SEWER CONNECTION"
                v-model="form.systemDisposal.sanitarySewerConnection"
                hide-details
              />
              <v-checkbox
                label="SUB SURFACE SAND FILTER"
                v-model="form.systemDisposal.subSurfaceSandFilter"
                hide-details
              />
              <v-checkbox
                label="SURFACE DRAINAGE"
                v-model="form.systemDisposal.surfaceDrainage"
                hide-details
              />
              <v-checkbox
                label="STREET CANAL"
                v-model="form.systemDisposal.streetCanal"
                hide-details
              />
              <v-checkbox
                label="WATER COURSE"
                v-model="form.systemDisposal.waterCourse"
                hide-details
              />
            </v-col>
          </v-row>

          <v-row class="mt-6">
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.buildingDetails.numStorey"
                label="NUMBER OF STOREY OF BUILDING"
                type="text"
                :rules="[rules.numericOnly]"
                clearable
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.buildingDetails.totalArea"
                label="TOTAL AREA OF THE BUILDING/SUBDIVISION"
                type="text"
                :rules="[rules.numericAndDecimalOnly]"
                clearable
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.buildingDetails.proposedDateOfConstruction"
                label="PROPOSED DATE OF CONSTRUCTION"
                type="date"
                clearable
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.buildingDetails.totalCostOfInstallation"
                label="TOTAL COST OF INSTALLATION"
                type="text"
                :rules="[rules.numericAndDecimalOnly]"
                prefix="₱"
                clearable
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.buildingDetails.expectedDateOfCompletion"
                label="EXPECTED DATE OF COMPLETION"
                type="date"
                clearable
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.buildingDetails.preparedBy"
                label="PREPARED BY"
                clearable
              />
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >BOX 2 (TO BE ACCOMPLISHED BY THE BUILDING OFFICIAL)</v-card-title
        >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6">
              <h4 class="text-subtitle-1 mb-2">ACTION TAKEN</h4>
              <p class="text-body-2 mb-4">
                PERMIT IS HEREBY GRANTED TO INSTALL THE SANITARY/PLUMBING
                FIXTURE ENUMARATED HEREIN SUBJECT OT THE FOLLOWING CONDITIONS:
              </p>
              <ol class="text-body-2 pl-4">
                <li>
                  THAT THE PROPOSED INSTALLATION SHALL BE IN ACCORDANCE WITH
                  APPROVED PLANS FILED WITH THE OFFICE ANDIN CONFORMITY WITH THE
                  NATIONAL BUILDING CODE.
                </li>
                <li>
                  THAT A DULY LICENSED SANITARY ENGINEER/MASTER PLUMBER SHALL BE
                  ENGAGED TO UNDERTAKE THE INSTALLATION/ CONSTRUCTION OF THE
                  PROJECT.
                </li>
                <li>
                  THAT A CERTIFICATION OF COMPLETION DULY SIGNED BY THE SANITARY
                  ENGINEER/MASTER PLUMBER IN-CHARGE OF INSTALLATION SHALL BE
                  SUBMITTED NOT LATER THAN SEVEN (7) DAYS AFTER COMPLETION OF
                  THE INSTALLATION.
                </li>
                <li>
                  THAT A CERTIFICATE OF FINAL INSPECTION AND A CERTIFICATE OF
                  OCCUPANCY SHALL BE SECURED PRIOR TO THE ACTUAL OCCUPANCY OF
                  THE BUILDING.
                </li>
              </ol>
            </v-col>
            <v-col cols="12" md="6">
              <h4 class="text-subtitle-1 mb-2">APPROVED:</h4>
              <div class="text-center mt-8">
                <p class="text-overline mb-0">ALEXANDER N. CANING</p>
                <p class="text-caption">ACTING BUILDING OFFICIAL</p>
              </div>
              <div class="text-center mt-12">
                <p class="text-overline mb-0">DATE</p>
              </div>
            </v-col>
          </v-row>
          <p class="text-caption mt-4 font-weight-bold">
            NOTE: THIS PERMIT MAY BE CANCELLED OR REVOKED PURSUANT TO SECTIONS
            305 AND 306 OF THE NATIONAL BUILDING CODE
          </p>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >BOX 3 (TO BE ACCOMPLISHED BY THE RECEIVING AND RECORDING
          SECTION)</v-card-title
        >
        <v-card-text>
          <h4 class="mb-3">BUILDING DOCUMENTS</h4>
          <v-row>
            <v-col cols="12" md="6">
              <v-checkbox
                label="SANITARY/PLUMBING PLANS AND SPECIFICATION"
                v-model="form.buildingDocuments.plansAndSpecs"
                hide-details
              />
              <v-checkbox
                label="BILL OF MATERIALS"
                v-model="form.buildingDocuments.billOfMaterials"
                hide-details
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-checkbox
                label="COST ESTIMATES"
                v-model="form.buildingDocuments.costEstimates"
                hide-details
              />
              <v-checkbox
                label="OTHERS (Specify)"
                v-model="form.buildingDocuments.others"
                hide-details
              />
              <v-expand-transition>
                <v-text-field
                  v-if="form.buildingDocuments.others"
                  v-model="form.buildingDocuments.othersDetails"
                  label="Please specify details for 'OTHERS (Specify)'"
                  :rules="[rules.requiredIfBuildingDocsOthers]"
                  class="ml-8 mt-2"
                  clearable
                />
              </v-expand-transition>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >BOX 4 (TO BE ACCOMPLISHED BY THE DIVISION/SECTION
          CONCERNED)</v-card-title
        >
        <v-card-text>
          <v-table density="compact">
            <thead>
              <tr>
                <th class="text-left"></th>
                <th class="text-left">AMOUNT DUE</th>
                <th class="text-left">ASSESSED BY</th>
                <th class="text-left">O.R. NO.</th>
                <th class="text-left">DATE PAID</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in form.box4Entries" :key="index">
                <td>{{ item.label }}</td>
                <td>
                  <v-text-field
                    v-model="item.amountDue"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
                <td>
                  <v-text-field
                    v-model="item.assessedBy"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
                <td>
                  <v-text-field
                    v-model="item.orNo"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
                <td>
                  <v-text-field
                    v-model="item.datePaid"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
              </tr>
            </tbody>
          </v-table>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >BOX 5 (TO BE ACCOMPLISHED BY THE RECEIVING AND RECORDING
          SECTION)</v-card-title
        >
        <v-card-text>
          <h4 class="mb-3">PROGRESS FLOW</h4>
          <v-table density="compact">
            <thead>
              <tr>
                <th class="text-left"></th>
                <th class="text-left" colspan="2">IN</th>
                <th class="text-left" colspan="2">OUT</th>
                <th class="text-left">ACTION/REMARKS</th>
                <th class="text-left">PROCESSED BY</th>
              </tr>
              <tr>
                <th class="text-left"></th>
                <th class="text-left">TIME</th>
                <th class="text-left">DATE</th>
                <th class="text-left">TIME</th>
                <th class="text-left">DATE</th>
                <th class="text-left"></th>
                <th class="text-left"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in form.box5Entries" :key="index">
                <td>{{ item.label }}</td>
                <td>
                  <v-text-field
                    v-model="item.inTime"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
                <td>
                  <v-text-field
                    v-model="item.inDate"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
                <td>
                  <v-text-field
                    v-model="item.outTime"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
                <td>
                  <v-text-field
                    v-model="item.outDate"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
                <td>
                  <v-text-field
                    v-model="item.actionRemarks"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
                <td>
                  <v-text-field
                    v-model="item.processedBy"
                    readonly
                    variant="plain"
                    density="compact"
                    hide-details
                    class="plain-input"
                  ></v-text-field>
                </td>
              </tr>
            </tbody>
          </v-table>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >BOX 6 (DESIGN PROFESSIONAL PLANS AND SPECIFICATIONS)</v-card-title
        >
        <v-card-text>
          <div class="mt-4 text-right">
            <p
              class="text-overline mb-0 d-inline-block"
              style="min-width: 150px"
            >
              DATE
            </p>
          </div>
          <div class="mt-8 text-center">
            <p class="text-overline mb-0 mx-auto" style="min-width: 300px">
              SANITARY ENGINEER/MASTER PLUMBER
            </p>
            <p class="text-caption">(Signed and Sealed Over Printed Name)</p>
          </div>
          <v-row class="mt-6">
            <v-col cols="12">
              <v-text-field
                label="Address"
                v-model="form.box6.address"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row dense>
            <v-col cols="6">
              <v-text-field
                label="PRC No."
                v-model="form.box6.prcNo"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Validity"
                v-model="form.box6.validity"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row dense>
            <v-col cols="6">
              <v-text-field
                label="PTR No."
                v-model="form.box6.ptrNo"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Date Issued"
                v-model="form.box6.dateIssued"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row dense>
            <v-col cols="6">
              <v-text-field
                label="Issued at"
                v-model="form.box6.issuedAt"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="TIN"
                v-model="form.box6.tin"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >BOX 7 (SUPERVISOR/IN-CHARGE OF SANITARY/PLUMBING WORKS)</v-card-title
        >
        <v-card-text>
          <div class="mt-4 text-right">
            <p
              class="text-overline mb-0 d-inline-block"
              style="min-width: 150px"
            >
              DATE
            </p>
          </div>
          <div class="mt-8 text-center">
            <p class="text-overline mb-0 mx-auto" style="min-width: 300px">
              SANITARY ENGINEER/MASTER PLUMBER
            </p>
            <p class="text-caption">(Signed and Sealed Over Printed Name)</p>
          </div>
          <v-row class="mt-6">
            <v-col cols="12">
              <v-text-field
                label="Address"
                v-model="form.box7.address"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row dense>
            <v-col cols="6">
              <v-text-field
                label="PRC No."
                v-model="form.box7.prcNo"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Validity"
                v-model="form.box7.validity"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row dense>
            <v-col cols="6">
              <v-text-field
                label="PTR No."
                v-model="form.box7.ptrNo"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Date Issued"
                v-model="form.box7.dateIssued"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row dense>
            <v-col cols="6">
              <v-text-field
                label="Issued at"
                v-model="form.box7.issuedAt"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="TIN"
                v-model="form.box7.tin"
                readonly
                variant="plain"
                density="compact"
                hide-details
                class="plain-input"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="mb-6" elevation="2">
        <v-card-title class="text-h6 text-blue-darken-2"
          >BOX 8 (APPLICANT)</v-card-title
        >
        <v-card-text>
          <div class="mt-4 text-right">
            <p
              class="text-overline mb-0 d-inline-block"
              style="min-width: 150px"
            >
              Date
            </p>
          </div>
          <div class="mt-8 text-center">
            <p class="text-overline mb-0 mx-auto" style="min-width: 300px">
              (Signed and Sealed Over Printed Name)
            </p>
          </div>
          <v-row class="mt-6">
            <v-col cols="12" md="4">
              <v-text-field
                label="C.T.C. NO."
                v-model="form.box8.ctcNo"
                clearable
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                label="DATE ISSUED"
                v-model="form.box8.dateIssued"
                type="date"
                clearable
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                label="PLACE ISSUED"
                v-model="form.box8.placeIssued"
                clearable
              ></v-text-field>
            </v-col>
          </v-row>
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
      const initialFixtures = {};
      const fixtureNames = [
        'waterCloset', 'floorDrain', 'lavatories', 'kitchenSink', 'faucet',
        'showerHead', 'waterMeter', 'greaseTrap', 'bathTubs', 'slopSinks',
        'urinal', 'airconUnit', 'waterTankReservoir', 'bidet', 'laundryTrays',
        'dentalCuspidor', 'gasHeater', 'electricalHeater', 'waterBoiler',
        'drinkingFountain', 'barSink', 'sodaFountainSink', 'lavatorySink',
        'sterilizer', 'swimmingPool', 'othersFixture'
      ];

      fixtureNames.forEach(name => {
        initialFixtures[name] = { qty: null, selected: false };
      });

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
          fixtures: initialFixtures,
          systemType: {
            waterDistribution: false,
            sanitarySewer: false,
            stormDrainage: false,
          },
          waterSupply: {
            shallowWell: false,
            deepWellPumpSet: false,
            cityMunicipalWaterSystem: false,
            others: false,
            othersDetails: '',
          },
          systemDisposal: {
            wasteWaterTreatmentPlant: false,
            septicVaultImhoffTank: false,
            sanitarySewerConnection: false,
            subSurfaceSandFilter: false,
            surfaceDrainage: false,
            streetCanal: false,
            waterCourse: false,
          },
          buildingDetails: {
            numStorey: '',
            totalArea: '',
            proposedDateOfConstruction: '',
            totalCostOfInstallation: '',
            expectedDateOfCompletion: '',
            preparedBy: '',
          },
          buildingDocuments: {
            plansAndSpecs: false,
            billOfMaterials: false,
            costEstimates: false,
            others: false,
            othersDetails: '',
          },
          box4Entries: [ //
            { label: 'Application Fees', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
            { label: 'Permit Fees', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
            { label: 'Inspection Fees', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
            { label: 'Fines/Penalties', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
            { label: 'Other Charges', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
          ],
          box5Entries: [ //
            { label: 'NOTED', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
            { label: 'CHIEF-PROCESSING DIVISION/SECTION', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
            { label: 'RECEIVING AND RECORDING', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
            { label: 'GEODETIC (LINE AND GRADE)', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
            { label: 'SANITARY', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
          ],
          // NEW: Box 6 data
          box6: { //
            date: '', // This will be static text
            engineerName: '', // This will be static text
            address: '', //
            prcNo: '', //
            validity: '', //
            ptrNo: '', //
            dateIssued: '', //
            issuedAt: '', //
            tin: '', //
          },
          // NEW: Box 7 data
          box7: { //
            date: '', // This will be static text
            engineerName: '', // This will be static text
            address: '', //
            prcNo: '', //
            validity: '', //
            ptrNo: '', //
            dateIssued: '', //
            issuedAt: '', //
            tin: '', //
          },
          // NEW: Box 8 data
          box8: { //
            signedName: '', // This will be static text
            date: '', // This will be static text
            ctcNo: '', //
            dateIssued: '', //
            placeIssued: '', //
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
          requiredIfWaterSupplyOthers: value => {
            if (this.form.waterSupply.others) {
              return !!value || 'Please specify details for "OTHERS (Specify)".';
            }
            return true;
          },
          requiredIfBuildingDocsOthers: value => {
            if (this.form.buildingDocuments.others) {
              return !!value || 'Please specify details for "OTHERS (Specify)".';
            }
            return true;
          },
        },
        fixtureList1: [
          { label: 'WATER CLOSET', value: 'waterCloset' },
          { label: 'FLOOR DRAIN', value: 'floorDrain' },
          { label: 'LAVATORIES', value: 'lavatories' },
          { label: 'KITCHEN SINK', value: 'kitchenSink' },
          { label: 'FAUCET', value: 'faucet' },
          { label: 'SHOWER HEAD', value: 'showerHead' },
          { label: 'WATER METER', value: 'waterMeter' },
          { label: 'GREASE TRAP', value: 'greaseTrap' },
          { label: 'BATH TUBS', value: 'bathTubs' },
          { label: 'SLOP SINKS', value: 'slopSinks' },
          { label: 'URINAL', value: 'urinal' },
          { label: 'AIRCON UNIT', value: 'airconUnit' },
          { label: 'WATER TANK/RESERVOIR', value: 'waterTankReservoir' },
        ],
        fixtureList2: [
          { label: 'BIDET', value: 'bidet' },
          { label: 'LAUNDRY TRAYS', value: 'laundryTrays' },
          { label: 'DENTAL CUSPIDOR', value: 'dentalCuspidor' },
          { label: 'GAS HEATER', value: 'gasHeater' },
          { label: 'ELECTRICAL HEATER', value: 'electricalHeater' },
          { label: 'WATER BOILER', value: 'waterBoiler' },
          { label: 'DRINKING FOUNTAIN', value: 'drinkingFountain' },
          { label: 'BAR SINK', value: 'barSink' },
          { label: 'SODA FOUNTAIN SINK', value: 'sodaFountainSink' },
          { label: 'LAVATORY SINK', value: 'lavatorySink' },
          { label: 'STERILIZER', value: 'sterilizer' },
          { label: 'SWIMMING POOL', value: 'swimmingPool' },
          { label: 'OTHERS', value: 'othersFixture' },
        ],
      };
    },
    computed: {
      showOthersField() {
        return this.form.scope === 'othersScope';
      },
      totalFixtures() {
        let total = 0;
        for (const key in this.form.fixtures) {
          const qty = Number(this.form.fixtures[key].qty);
          if (!isNaN(qty)) {
            total += qty;
          }
        }
        return total;
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

        const initialFixtures = {};
        const fixtureNames = [
          'waterCloset', 'floorDrain', 'lavatories', 'kitchenSink', 'faucet',
          'showerHead', 'waterMeter', 'greaseTrap', 'bathTubs', 'slopSinks',
          'urinal', 'airconUnit', 'waterTankReservoir', 'bidet', 'laundryTrays',
          'dentalCuspidor', 'gasHeater', 'electricalHeater', 'waterBoiler',
          'drinkingFountain', 'barSink', 'sodaFountainSink', 'lavatorySink',
          'sterilizer', 'swimmingPool', 'othersFixture'
        ];
        fixtureNames.forEach(name => {
          initialFixtures[name] = { qty: null, selected: false };
        });
        this.form.fixtures = initialFixtures;

        this.form.systemType = {
          waterDistribution: false,
          sanitarySewer: false,
          stormDrainage: false,
        };

        this.form.waterSupply = {
          shallowWell: false,
          deepWellPumpSet: false,
          cityMunicipalWaterSystem: false,
          others: false,
          othersDetails: '',
        };
        this.form.systemDisposal = {
          wasteWaterTreatmentPlant: false,
          septicVaultImhoffTank: false,
          sanitarySewerConnection: false,
          subSurfaceSandFilter: false,
          surfaceDrainage: false,
          streetCanal: false,
          waterCourse: false,
        };
        this.form.buildingDetails = {
          numStorey: '',
          totalArea: '',
          proposedDateOfConstruction: '',
          totalCostOfInstallation: '',
          expectedDateOfCompletion: '',
          preparedBy: '',
        };
        this.form.buildingDocuments = {
          plansAndSpecs: false,
          billOfMaterials: false,
          costEstimates: false,
          others: false,
          othersDetails: '',
        };

        // Reset Box 4 data
        this.form.box4Entries = [ //
          { label: 'Application Fees', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
          { label: 'Permit Fees', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
          { label: 'Inspection Fees', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
          { label: 'Fines/Penalties', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
          { label: 'Other Charges', amountDue: '', assessedBy: '', orNo: '', datePaid: '' }, //
        ];

        // Reset Box 5 data
        this.form.box5Entries = [ //
          { label: 'NOTED', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
          { label: 'CHIEF-PROCESSING DIVISION/SECTION', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
          { label: 'RECEIVING AND RECORDING', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
          { label: 'GEODETIC (LINE AND GRADE)', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
          { label: 'SANITARY', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' }, //
        ];

        // Reset Box 6 data
        this.form.box6 = { //
          date: '', //
          engineerName: '', //
          address: '', //
          prcNo: '', //
          validity: '', //
          ptrNo: '', //
          dateIssued: '', //
          issuedAt: '', //
          tin: '', //
        };

        // Reset Box 7 data
        this.form.box7 = { //
          date: '', //
          engineerName: '', //
          address: '', //
          prcNo: '', //
          validity: '', //
          ptrNo: '', //
          dateIssued: '', //
          issuedAt: '', //
          tin: '', //
        };

        // Reset Box 8 data
        this.form.box8 = { //
          signedName: '', //
          date: '', //
          ctcNo: '', //
          dateIssued: '', //
          placeIssued: '', //
        };
      },
    },
  };
</script>

<style scoped>
  /* Styles for Box 2 to ensure static appearance */
  .v-card-text ol {
    list-style-type: decimal;
    margin-bottom: 1em;
  }

  .v-card-text ol li {
    margin-bottom: 0.5em;
  }

  .text-overline {
    border-bottom: 1px solid #ccc; /* Underline for signatures */
    display: inline-block;
    padding: 0 1em;
    min-width: 200px; /* Ensure space for signature */
  }

  /* Styles for table inputs in Box 4 and Box 5 to make them look like static text */
  .v-table .plain-input.v-text-field {
    --v-input-control-height: auto; /* Allow content to dictate height */
    --v-input-padding-top: 0;
    --v-input-padding-bottom: 0;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
  }

  .v-table .plain-input.v-text-field .v-input__control {
    min-height: unset !important; /* Remove minimum height */
  }

  .v-table .plain-input.v-text-field .v-field {
    padding-left: 0;
    padding-right: 0;
  }

  .v-table .plain-input.v-text-field .v-field__input {
    text-align: left; /* Align text as needed within the plain input */
    padding-left: 0;
    padding-right: 0;
    min-height: unset !important;
  }
</style>
