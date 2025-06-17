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
            <v-col cols="6">
              <v-text-field
                v-if="form.fixtures.othersFixture.selected"
                v-model="form.fixtures.othersFixture.details"
                label="Specify Other Fixture Details"
                :rules="[rules.requiredIfOthersFixtureSelected]"
                clearable
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
          box4Entries: [
            { label: 'Application Fees', amountDue: '', assessedBy: '', orNo: '', datePaid: '' },
            { label: 'Permit Fees', amountDue: '', assessedBy: '', orNo: '', datePaid: '' },
            { label: 'Inspection Fees', amountDue: '', assessedBy: '', orNo: '', datePaid: '' },
            { label: 'Fines/Penalties', amountDue: '', assessedBy: '', orNo: '', datePaid: '' },
            { label: 'Other Charges', amountDue: '', assessedBy: '', orNo: '', datePaid: '' },
          ],
          box5Entries: [
            { label: 'NOTED', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' },
            { label: 'CHIEF-PROCESSING DIVISION/SECTION', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' },
            { label: 'RECEIVING AND RECORDING', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' },
            { label: 'GEODETIC (LINE AND GRADE)', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' },
            { label: 'SANITARY', inTime: '', inDate: '', outTime: '', outDate: '', actionRemarks: '', processedBy: '' },
          ],
          box6: {
            engineerName: '',
            date: '',
            address: '',
            prcNo: '',
            validity: '',
            ptrNo: '',
            dateIssued: '',
            issuedAt: '',
            tin: '',
          },
          box7: {
            engineerName: '',
            date: '',
            address: '',
            prcNo: '',
            validity: '',
            ptrNo: '',
            dateIssued: '',
            issuedAt: '',
            tin: '',
          },
          box8: {
            signedName: '',
            date: '',
            ctcNo: '',
            dateIssued: '',
            placeIssued: '',
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
          requiredIfOthersFixtureSelected: value => {
            if (this.form.fixtures.othersFixture.selected) {
              return !!value || 'Please specify details for "OTHERS" fixture.';
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
          if (this.form.fixtures[key].selected && this.form.fixtures[key].qty !== null) {
            const qty = Number(this.form.fixtures[key].qty);
            if (!isNaN(qty)) {
              total += qty;
            }
          }
        }
        return total;
      },
    },
    watch: {
      form: {
        handler(newValue) {
          localStorage.setItem('sanitaryPermitForm', JSON.stringify(newValue));
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
        const savedForm = localStorage.getItem('sanitaryPermitForm');
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
            localStorage.removeItem('sanitaryPermitForm'); // Clear bad data
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
          'location', 'scope', 'scopeOtherDetails', 'fixtures', 'systemType',
          'waterSupply', 'systemDisposal', 'buildingDetails', 'buildingDocuments',
          'box4Entries', 'box5Entries', 'box6', 'box7', 'box8'
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
          const response = await fetch('http://localhost/buildingpermitapplication/src/document/sanitary-backend/sanitary.php', {
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

            // Fixtures mapping
            for (const key in this.form.fixtures) {
                this.form.fixtures[key].qty = loadedData['fixture_' + key + '_qty'] || null;
                this.form.fixtures[key].selected = !!parseInt(loadedData['fixture_' + key + '_selected']);
            }
            this.form.fixtures.othersFixture.details = loadedData.fixture_othersFixture_details || '';
            // totalFixtures is a computed property, no direct mapping needed here

            // System Type
            this.form.systemType.waterDistribution = !!parseInt(loadedData.system_type_water_distribution);
            this.form.systemType.sanitarySewer = !!parseInt(loadedData.system_type_sanitary_sewer);
            this.form.systemType.stormDrainage = !!parseInt(loadedData.system_type_storm_drainage);

            // Water Supply
            this.form.waterSupply.shallowWell = !!parseInt(loadedData.water_supply_shallow_well);
            this.form.waterSupply.deepWellPumpSet = !!parseInt(loadedData.water_supply_deep_well_pump_set);
            this.form.waterSupply.cityMunicipalWaterSystem = !!parseInt(loadedData.water_supply_city_municipal_water_system);
            this.form.waterSupply.others = !!parseInt(loadedData.water_supply_others);
            this.form.waterSupply.othersDetails = loadedData.water_supply_others_details || '';

            // System Disposal
            this.form.systemDisposal.wasteWaterTreatmentPlant = !!parseInt(loadedData.system_disposal_waste_water_treatment_plant);
            this.form.systemDisposal.septicVaultImhoffTank = !!parseInt(loadedData.system_disposal_septic_vault_imhoff_tank);
            this.form.systemDisposal.sanitarySewerConnection = !!parseInt(loadedData.system_disposal_sanitary_sewer_connection);
            this.form.systemDisposal.subSurfaceSandFilter = !!parseInt(loadedData.system_disposal_sub_surface_sand_filter);
            this.form.systemDisposal.surfaceDrainage = !!parseInt(loadedData.system_disposal_surface_drainage);
            this.form.systemDisposal.streetCanal = !!parseInt(loadedData.system_disposal_street_canal);
            this.form.systemDisposal.waterCourse = !!parseInt(loadedData.system_disposal_water_course);

            // Building Details
            this.form.buildingDetails.numStorey = loadedData.building_num_storey || '';
            this.form.buildingDetails.totalArea = loadedData.building_total_area || '';
            this.form.buildingDetails.proposedDateOfConstruction = loadedData.building_proposed_date_of_construction || '';
            this.form.buildingDetails.totalCostOfInstallation = loadedData.building_total_cost_of_installation || '';
            this.form.buildingDetails.expectedDateOfCompletion = loadedData.building_expected_date_of_completion || '';
            this.form.buildingDetails.preparedBy = loadedData.building_prepared_by || '';

            // Building Documents
            this.form.buildingDocuments.plansAndSpecs = !!parseInt(loadedData.doc_plans_and_specs);
            this.form.buildingDocuments.billOfMaterials = !!parseInt(loadedData.doc_bill_of_materials);
            this.form.buildingDocuments.costEstimates = !!parseInt(loadedData.doc_cost_estimates);
            this.form.buildingDocuments.others = !!parseInt(loadedData.doc_others);
            this.form.buildingDocuments.othersDetails = loadedData.doc_others_details || '';

            // Box 4 Entries
            const box4Labels = ['Application Fees', 'Permit Fees', 'Inspection Fees', 'Fines/Penalties', 'Other Charges'];
            const box4DbKeys = ['application_fees', 'permit_fees', 'inspection_fees', 'fines_penalties', 'other_charges'];
            this.form.box4Entries = box4Labels.map((label, idx) => {
                const dbKey = box4DbKeys[idx];
                return {
                    label: label,
                    amountDue: loadedData['box4_' + dbKey + '_amount'] || '',
                    assessedBy: loadedData['box4_' + dbKey + '_assessed_by'] || '',
                    orNo: loadedData['box4_' + dbKey + '_or_no'] || '',
                    datePaid: loadedData['box4_' + dbKey + '_date_paid'] || '',
                };
            });

            // Box 5 Entries
            const box5Labels = ['NOTED', 'CHIEF-PROCESSING DIVISION/SECTION', 'RECEIVING AND RECORDING', 'GEODETIC (LINE AND GRADE)', 'SANITARY'];
            const box5DbKeys = ['noted', 'chief', 'receiving', 'geodetic', 'sanitary'];
            this.form.box5Entries = box5Labels.map((label, idx) => {
                const dbKey = box5DbKeys[idx];
                return {
                    label: label,
                    inTime: loadedData['box5_' + dbKey + '_in_time'] || '',
                    inDate: loadedData['box5_' + dbKey + '_in_date'] || '',
                    outTime: loadedData['box5_' + dbKey + '_out_time'] || '',
                    outDate: loadedData['box5_' + dbKey + '_out_date'] || '',
                    actionRemarks: loadedData['box5_' + dbKey + '_action_remarks'] || '',
                    processedBy: loadedData['box5_' + dbKey + '_processed_by'] || '',
                };
            });

            // Box 6
            this.form.box6.engineerName = loadedData.box6_engineer_name || '';
            this.form.box6.date = loadedData.box6_date || '';
            this.form.box6.address = loadedData.box6_address || '';
            this.form.box6.prcNo = loadedData.box6_prc_no || '';
            this.form.box6.validity = loadedData.box6_validity || '';
            this.form.box6.ptrNo = loadedData.box6_ptr_no || '';
            this.form.box6.dateIssued = loadedData.box6_date_issued || '';
            this.form.box6.issuedAt = loadedData.box6_issued_at || '';
            this.form.box6.tin = loadedData.box6_tin || '';

            // Box 7
            this.form.box7.engineerName = loadedData.box7_engineer_name || '';
            this.form.box7.date = loadedData.box7_date || '';
            this.form.box7.address = loadedData.box7_address || '';
            this.form.box7.prcNo = loadedData.box7_prc_no || '';
            this.form.box7.validity = loadedData.box7_validity || '';
            this.form.box7.ptrNo = loadedData.box7_ptr_no || '';
            this.form.box7.dateIssued = loadedData.box7_date_issued || '';
            this.form.box7.issuedAt = loadedData.box7_issued_at || '';
            this.form.box7.tin = loadedData.box7_tin || '';

            // Box 8
            this.form.box8.signedName = loadedData.box8_signed_name || '';
            this.form.box8.date = loadedData.box8_date || '';
            this.form.box8.ctcNo = loadedData.box8_ctc_no || '';
            this.form.box8.dateIssued = loadedData.box8_date_issued || '';
            this.form.box8.placeIssued = loadedData.box8_place_issued || '';

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
            const response = await fetch('http://localhost/buildingpermitapplication/src/document/sanitary-backend/sanitary.php', {
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
              localStorage.removeItem('sanitaryPermitForm'); // Clear local storage on successful submission
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

        // Reset nested objects and arrays to their initial empty states
        // This is crucial because Vue's `reset()` might not deeply reset nested data
        const initialData = this.$options.data.apply(this);
        this.form = JSON.parse(JSON.stringify(initialData.form)); // Deep copy initial state

        localStorage.removeItem('sanitaryPermitForm'); // Clear local storage on reset
        this.statusMessage = 'Form has been reset.';
        this.messageColor = 'info';
        this.showMessage = true;
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

  /* Styles for table inputs in Box 4 and Box 5 to make them look like interactive text fields */
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
    border-bottom: 1px solid #ccc; /* Ensure underline for these fields */
  }

  .v-table .plain-input.v-text-field .v-field__input {
    text-align: left; /* Align text as needed within the plain input */
    padding-left: 0;
    padding-right: 0;
    min-height: unset !important;
  }
</style>
