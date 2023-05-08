<template>
  <div data-app>
    <alert-time-out
      :redirect="redirectSessionFinished"
      @redirect="updateTimeOut($event)"
    />
    <alert
      :text="textAlert"
      :event="alertEvent"
      :show="showAlert"
      @show-alert="updateAlert($event)"
      class="mb-2"
    />
  <v-data-table
        :headers="headers"
        :items="recordsFiltered"
        sort-by="name"
        class="elevation-3 shadow p-3 mt-3"
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Instrumentos</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="1400px" persistent>
              <template v-slot:activator="{}">
                <v-row>
                  <v-col align="end">
                    <v-btn class="mb-2 btn-normal" @click="OpenAgreement" rounded>
                      Agregar
                    </v-btn>
                  </v-col>
                  <v-col
                    xs="6"
                    sm="6"
                    md="6"
                    class="d-none d-md-block d-lg-block"
                  >
                    <v-text-field
                      dense
                      label="Buscar"
                      outlined
                      type="text"
                      class=""
                      v-model="search"
                      @keyup="searchValue()"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </template>
              <v-card class="flexcard" height="200%" width="auto">
                <v-card-title>
                  <h1 class="mx-auto pt-3 mb-3 text-center black-secondary">
                    {{ formTitle }}
                  </h1>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <h5>Información del instrumento</h5>
                    <hr/>
                    <v-row>
                      <!-- Instrument type -->
                        <v-col cols="12" sm="12" md="6">
                          <base-select-search
                            label="Tipo de instrumento"
                            v-model.trim="$v.editedItem.type_instrument_name.$model"
                            :items="types"
                            item="type_instrument_name"
                            :validation="$v.editedItem.type_instrument_name"
                          />
                        </v-col>
                      <!-- Instrument type -->
                      <!-- Instrument Name -->
                      <v-col cols="12" sm="12" md="6">
                        <base-input
                          label="Nombre"
                          v-model="$v.editedItem.instrument_name.$model"
                          :validation="$v.editedItem.instrument_name"
                          validationTextType="default"
                        />
                      </v-col>
                      <!-- Instrument Name -->
                    </v-row>
                    <v-row>
                      <!-- Instrument:Entity -->
                      <v-col cols="12" sm="12" md="6">
                        <base-select-search
                            label="Entidad"
                            v-model.trim="$v.editedItem.entity_name.$model"
                            :items="entities"
                            item="entity_name"
                            :validation="$v.editedItem.entity_name"
                          />
                      </v-col>
                      <!-- Instrument:Entity -->
                      <!-- Instrument:Sector -->
                        <v-col cols="12" sm="12" md="6">
                          <base-select-search
                            label="Sector"
                            v-model.trim="$v.editedItem.sector_name.$model"
                            :items="sectors"
                            item="sector_name"
                            :validation="$v.editedItem.sector_name"
                          />
                        </v-col>
                        <!-- Instrument:Sector -->
                    </v-row>
                    <v-row>
                      <!-- Instrument description -->
                      <v-col cols="12" sm="12" md="12">
                        <v-textarea
                          label="Descripción del instrumento"
                          v-model="$v.editedItem.description.$model"
                          :validation="$v.editedItem.description"
                          auto-grow
                          outlined
                          rows="1"
                          row-height="15"
                          dense
                        ></v-textarea>
                      </v-col>
                      <!-- Instrument description -->
                    </v-row>
                    <v-row v-if="showExoneration">
                      <v-col align="start">
                        <v-btn
                          color="btn btn-normal mb-3 mt-3"
                          rounded
                          @click="openExonerationModal()"
                        >
                          Agregar detalle
                        </v-btn>
                        <v-btn
                          v-if="showSaveButton()"
                          color="btn-normal no-uppercase "
                          rounded
                          @click="saveExoneration()"
                        >
                          Guardar {{ editedItem.type_instrument_name }}
                        </v-btn>
                      </v-col>
                    </v-row>
                    <!-- Form -->
                    <v-row v-if="showExoneration">
                      <v-col cols="12" lg="12" md="12" xs="12">
                        <div class="table-responsive-md">
                          <table class="table table-responsive-md table-hover">
                            <thead v-if="editedItem.type_instrument_name == 'Convenio'">
                              <th>Elenco/Espacio</th>
                              <th>Fecha</th>
                              <th>Tarifa elenco</th>
                              <th>Horas</th>
                              <th>Monto elenco($)</th>
                              <th>Número de personas</th>
                              <th>Tarifa entrada($)</th>
                              <th>Monto entrada($)</th> 
                              <th class="text-center">Acciones</th>
                            </thead>
                            <thead v-if="editedItem.type_instrument_name != 'Convenio'">
                              <th>Concepto</th>
                              <th>Fecha</th>
                              <th>Valor</th>
                              <th>Monto ($)</th>
                              <th>Descripción</th>
                              <th class="text-center">Acciones</th>
                            </thead>
                            <tbody v-if="editedItem.type_instrument_name == 'Convenio'">
                              <tr
                                v-for="(exoneration, index) in editedItem.exonerations" :key="index"
                              >
                                <td>
                                  <p> {{ exoneration.service_place }}</p>
                                </td>
                                <td>
                                  <p>{{ exoneration.date }}</p>
                                </td>
                                <td>
                                    <p>{{ exoneration.tariff_hour }}
                                      {{ exoneration.not_charged_hour }}</p>
                                </td>
                                <td>
                                  <p>{{ exoneration.hour }}</p>
                                </td>
                                <td>
                                    <p>{{ exoneration.amount_hour }}</p>
                                </td>
                                <td>
                                  <p>{{ exoneration.people }}</p>
                                </td>
                                <td>
                                    <p>{{ exoneration.tariff_people }}
                                      {{ exoneration.not_charged_people }}</p>
                                </td>
                                <td>
                                  <p>{{ exoneration.amount_people }}</p>
                                </td>
                                <td class="text-center">
                                  <a
                                    @click="editItemExoneration(exoneration)"
                                    class="p-1 mr-1 text-center"
                                    ><span class="material-icons text-blue">
                                      edit
                                    </span></a
                                  >
                                </td>
                                <td class="text-center">
                                  <a
                                    @click="deleteItem(exoneration.id)"
                                    class="p-1 mr-1 text-center"
                                    ><span class="material-icons text-blue">
                                      delete
                                    </span></a
                                  >
                                </td>
                              </tr>
                              <tr v-if="noData()">
                                <td colspan="7" class="text-center">
                                  <p>Aun no se registró ninguna exoneración.</p>
                                </td>
                              </tr>
                            </tbody>
                            <tbody v-if="editedItem.type_instrument_name != 'Convenio'">
                              <tr
                                v-for="(exoneration, index) in editedItem.exonerations" :key="index"
                              >
                                <td>
                                  <p> {{ exoneration.concept }}</p>
                                </td>
                                <td>
                                  <p>{{ exoneration.date }}</p>
                                </td>
                                <td>
                                    <p>{{ exoneration.worth }}</p>
                                </td>
                                <td>
                                  <p>{{ exoneration.concept_amount }}</p>
                                </td>
                                <td>
                                    <p>{{ exoneration.exonerated_description }}</p>
                                </td>
                                <td class="text-center">
                                  <a
                                    @click="editItemExoneration(exoneration)"
                                    class="p-1 mr-1 text-center"
                                    ><span class="material-icons text-blue">
                                      edit
                                    </span></a
                                  >
                                </td>
                                <td class="text-center">
                                  <a
                                    @click="deleteItem(exoneration.id)"
                                    class="p-1 mr-1 text-center"
                                    ><span class="material-icons text-blue">
                                      delete
                                    </span></a
                                  >
                                </td>
                              </tr>
                              <tr v-if="noData()">
                                <td colspan="7" class="text-center">
                                  <p>Aun no se ha creado ningun registro.</p>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col align="center">
                        <v-btn
                          color="btn-normal no-uppercase mt-3"
                          rounded
                          @click="save()"
                        >
                          Guardar
                        </v-btn>
                        <v-btn
                          color="btn-normal-close no-uppercase mt-3"
                          rounded
                          @click="close"
                        >
                          Cancelar
                        </v-btn>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>
              </v-card>
            </v-dialog>

            <v-dialog v-model="dialogDelete" max-width="400px">
              <v-card class="h-100">
                <v-container>
                  <h3 class="black-secondary text-center mt-3 mb-3">
                    Eliminar registro
                  </h3>
                  <v-row>
                    <v-col align="center">
                      <v-btn
                        color="btn-normal no-uppercase mt-3 mb-3 pr-5 pl-5 mx-auto"
                        rounded
                        @click="deleteItemOfTable()"
                        >Confirmar</v-btn
                      >
                      <v-btn
                        color="btn-normal-close no-uppercase mt-3 mb-3"
                        rounded
                        @click="closeDelete"
                      >
                        Cancelar
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>
        <template v-slot:[`item.actions`]="{ item }">
          <v-icon
            small
            class="mr-2"
            @click="editItem(item)"
            title="Agregar exoneraciones y editar convenios"
          >
            mdi-pencil
          </v-icon>
          <v-icon
              small
              class="mr-2"
              @click="editItemDependence(item)"
              title="Agregar dependencias"
            >
              mdi-eye
            </v-icon>
        </template>
        <template v-slot:no-data>
          <a
            href="#"
            class="btn btn-normal-secondary no-decoration"
            @click="initialize"
          >
            Reiniciar
          </a>
        </template>
      </v-data-table>
    <!--form detail-->
    <template>
      <v-dialog v-model="dialogExoneration" max-width="1400px" persistent>
        <v-card class="flexcard" height="100%">
          <h1 class="black-secondary text-center mt-4 mb-4">
            Agregar detalle
          </h1>
          <v-card-text>
            <v-container>
              <v-row v-if="editedItem.type_instrument_name != 'Convenio'">
                <br />
                <h5>Información de: {{ editedItem.type_instrument_name }}</h5>
                <hr/>
                <!-- Concept != agreement -->
                <v-col cols="12" xs="12" sm="12" md="12">
                  <base-input
                    label="Concepto"
                    v-model.trim="$v.editedItem.concept.$model"
                    :validation="$v.editedItem.concept"
                    validationTextType="default"
                  />
                </v-col>
                <!-- Concept != agreement -->
                <!-- Value != agreement -->
                <v-col cols="12" xs="12" sm="12" md="4">
                  <base-input
                    label="Valor"
                    v-model.trim="$v.editedItem.worth.$model"
                    :validation="$v.editedItem.worth"
                    type="number"
                  />
                </v-col>
                <!-- Value != agreement -->
                <!-- Amount != agreement -->
                <v-col cols="12" xs="12" sm="12" md="4">
                  <base-input
                    label="Monto"
                    v-model.trim="$v.editedItem.concept_amount.$model"
                    :validation="$v.editedItem.concept_amount"
                    type="number"
                  />
                </v-col>
                <!-- Amount != agreement -->
                <!-- Date != agreement -->
                <v-col cols="12" sm="12" md="4">
                  <base-input
                    label="Fecha"
                    v-model="$v.editedItem.date.$model"
                    :validation="$v.editedItem.date"
                    validationTextType="none"
                    type="date"
                  />
                </v-col>
                <!-- Date != agreement -->
                <!-- Description != agreement -->
                <v-col cols="12" sm="12" md="12">
                  <v-textarea
                    label="Descripción"
                    v-model="$v.editedItem.exonerated_description.$model"
                    :validation="$v.editedItem.exonerated_description"
                    clearable
                    clear-icon="mdi-backspace"
                    auto-grow
                    outlined
                    rows="3"
                    dense
                  ></v-textarea>
                </v-col>
              </v-row>
              <v-row v-if="editedItem.type_instrument_name != 'Convenio'">
                <v-col align="center">
                  <v-btn
                    class="btn btn-normal mb-3 mt-1"
                    @click="addNewExoneration()"
                    >Guardar</v-btn
                  >
                  <v-btn
                    color="btn-normal-close mb-3 mt-1"
                    rounded
                    @click="closeExoneration"
                  >
                    Cancelar
                  </v-btn>
                </v-col>
              </v-row>
              <v-container v-if="editedItem.type_instrument_name == 'Convenio'">
                <h5>Información del espacio</h5>
                <hr/>
              </v-container>
              <v-row v-if="editedItem.type_instrument_name == 'Convenio'">
                <!-- Space: National -->
                <v-col cols="12" sm="12" md="6">
                  <base-select-search
                    label="Dirección Nacional"
                    v-model.trim="$v.editedItem.national_direction_name.$model"
                    :items="directions"
                    item="national_direction_name"
                    :validation="$v.editedItem.national_direction_name"
                    @change="changeDirection()"
                  />
                </v-col>
                <!-- Space: National -->
                <!-- Space: Place -->
                <v-col cols="12" sm="12" md="6">
                  <base-select-search
                    label="Dependencia"
                    v-model.trim="$v.editedItem.dependence_name.$model"
                    :items="dependences"
                    item="dependence_name"
                    :validation="$v.editedItem.dependence_name"
                    @change="changeDependence()"
                  />
                </v-col>
                <!-- Space: Place -->
              </v-row>
              <v-container v-if="editedItem.type_instrument_name == 'Convenio'">
                <br /><br />
                <h5>Información de la exoneración</h5>
                <hr/>
              </v-container>
              <v-checkbox
                    v-if="editedItem.type_instrument_name == 'Convenio'"
                    class="mb-3"
                    @click="hidden = !hidden"
                    label="Monto no tarifado"
                    >
              </v-checkbox>
              <v-row v-if="editedItem.type_instrument_name == 'Convenio'">
                <!-- Exoneracion: date -->
                <v-col cols="12" sm="12" md="6">
                  <base-input
                    label="Fecha de evento"
                    v-model="$v.editedItem.date.$model"
                    :validation="$v.editedItem.date"
                    validationTextType="none"
                    type="date"
                  />
                </v-col>
                <!-- Space: Place -->
                <v-col cols="12" sm="12" md="6">
                  <base-input
                      label="Espacio de servicio"
                      v-model.trim="$v.editedItem.service_place.$model"
                      :validation="$v.editedItem.service_place"
                      validationTextType="default"
                    />
                </v-col>
                  <!-- not Tariff Dependence-->
                  <v-col cols="12" xs="12" sm="12" md="4" v-show="hidden">
                    <base-input
                      label="Tarifa de dependencia"
                      v-model.trim="$v.editedItem.not_charged_hour.$model"
                      :validation="$v.editedItem.not_charged_hour"
                      validationTextType="none"
                    />
                  </v-col>
                  <!-- Space: Tariff Dependence-->
                  <v-col cols="12" sm="12" md="4" v-show="!hidden">
                    <base-select-search
                      @change="calculateExoneratedAmount()"
                      label="Tarifa de dependencia"
                      v-model.trim="$v.editedItem.tariff_hour.$model"
                      :items="tariffs"
                      item="type_charge"
                      :validation="$v.editedItem.tariff_hour"
                    />
                  </v-col>
                  <!-- Exoneracion: Exempted hours -->
                    <v-col cols="12" sm="12" md="4">
                      <base-input
                        label="Horas exoneradas"
                        v-model="$v.editedItem.hour.$model"
                        :validation="$v.editedItem.hour"
                        type="number"
                        validationTextType="none"
                      />
                    </v-col>
                  <!-- Exoneracion: exonerated amount -->
                    <v-col cols="12" sm="12" md="4">
                      <base-input
                        label="Monto"
                        v-model="$v.editedItem.amount_hour.$model"
                        :validation="$v.editedItem.amount_hour"
                        type="number"
                      />
                    </v-col>
                
                <!-- not Tariff People-->
                  <v-col cols="12" xs="12" sm="12" md="4" v-show="hidden">
                    <base-input
                      label="Tarifa de personas"
                      v-model.trim="$v.editedItem.not_charged_people.$model"
                      :validation="$v.editedItem.not_charged_people"
                      validationTextType="none"
                    />
                  </v-col>
                  <!-- Space: Tariff People-->
                  <v-col cols="12" sm="12" md="4" v-show="!hidden">
                    <base-select-search
                      @change="calculateExoneratedAmount()"
                      label="Tarifa de personas"
                      v-model.trim="$v.editedItem.tariff_people.$model"
                      :items="tariffs"
                      item="type_charge"
                      :validation="$v.editedItem.tariff_people"
                    />
                  </v-col>
                <!-- Exoneracion: number of people -->
                <v-col cols="12" sm="12" md="4">
                  <base-input
                    @change="calculateExoneratedAmount()"
                    label="Número de personas"
                    v-model="$v.editedItem.people.$model"
                    :validation="$v.editedItem.people"
                    type="number"
                    v-mask="'#####'"
                  />
                </v-col>
                <!-- Exoneracion: exonerated amount -->
                <v-col cols="12" sm="12" md="4">
                  <base-input
                    label="Monto"
                    v-model="$v.editedItem.amount_people.$model"
                    :validation="$v.editedItem.amount_people"
                    type="number"
                  />
                </v-col>
                <!-- Exoneracion: Exonerated description -->
                <v-col cols="12" sm="12" md="12">
                  <v-textarea
                    label="Descripción de la exoneración"
                    v-model="$v.editedItem.exonerated_description.$model"
                    :validation="$v.editedItem.exonerated_description"
                    clearable
                    clear-icon="mdi-backspace"
                    auto-grow
                    outlined
                    rows="3"
                    dense
                  ></v-textarea>
                </v-col>
              </v-row>
              <v-row v-if="editedItem.type_instrument_name == 'Convenio'">
                <v-col align="center">
                  <v-btn
                    class="btn btn-normal mb-3 mt-1"
                    @click="addNewExoneration()"
                    >Guardar</v-btn
                  >
                  <v-btn
                    color="btn-normal-close mb-3 mt-1"
                    rounded
                    @click="closeExoneration"
                  >
                    Cancelar
                  </v-btn>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
      </v-dialog>
    </template>

    <template>
              <v-dialog v-model="dialogDependence" max-width="900px" persistent>
                  <v-card class="flexcard auth" height="100%">
                    <h1 class="black-secondary text-center mt-4 mb-4">
                      Agregar dependencia
                    </h1>
                    <v-card-text>
                      <v-container>
                        <!-- Form -->
                        <v-row>
                          <!-- User Name -->
                          <v-col cols="12" sm="6" md="4">
                            <base-input
                              label="Nombre"
                              v-model="$v.editedItemD.instrument_name.$model"
                              :validation.sync="$v.editedItemD.instrument_name"
                              validationTextType="default"
                            />
                          </v-col>
                        </v-row>
                        <!-- Form -->
                        <br><br>
                        <v-data-table
                          :headers="headersDependence"
                          :items="recordsFiltered2"
                          sort-by="id"
                          class="elevation-3 shadow p-3 mt-3"
                        >
                          <template v-slot:top>
                            <v-toolbar flat>
                              <v-toolbar-title>Dependencias</v-toolbar-title>
                              <v-spacer></v-spacer>
                              <v-dialog v-model="dialogAdd" max-width="600px" persistent>
                                <template v-slot:activator="{ on, attrs }">
                                  <v-row>
                                    <v-col align="end">
                                      <v-btn
                                        class="mb-2 btn-normal no-uppercase"
                                        v-bind="attrs"
                                        v-on="on"
                                        rounded
                                        @click="$v.editedItemD.$reset()"
                                      >
                                        Agregar
                                      </v-btn>
                                    </v-col>
                                  </v-row>
                                </template>
                          
                                <v-card class="flexcard" height="100%">
                                  <h1 class="black-secondary text-center mt-4 mb-4">
                                    Agregar dependencia
                                  </h1>
                                  <v-card-text>
                                    <v-container>
                                      <!-- Form -->
                                      <v-row>
                                         <!-- Space: National -->
                                        <v-col cols="12" sm="12" md="6">
                                          <base-select-search
                                            label="Dirección Nacional"
                                            v-model.trim="$v.editedItemD.national_direction_name.$model"
                                            :items="directions"
                                            item="national_direction_name"
                                            :validation="$v.editedItemD.national_direction_name"
                                            @change="changeDirectionI()"
                                          />
                                        </v-col>
                                        <!-- Space: National -->
                                        <!-- Space: Place -->
                                        <v-col cols="12" sm="12" md="6">
                                          <base-select-search
                                            label="Dependencia"
                                            v-model.trim="$v.editedItemD.dependence_name.$model"
                                            :items="dependences"
                                            item="dependence_name"
                                            :validation="$v.editedItemD.dependence_name"
                                          />
                                        </v-col>
                                        <!-- Space: Place -->
                                      </v-row>
                                      <!-- Form -->
                                      <v-row>
                                        <v-col align="center">
                                          <v-btn
                                            color="btn-normal no-uppercase mt-3"
                                            rounded
                                            @click="saveDependence()"
                                          >
                                            Guardar
                                          </v-btn>
                                          <v-btn
                                            color="btn-normal-close no-uppercase mt-3"
                                            rounded
                                            @click="closeAdd"
                                          >
                                            Cancelar
                                          </v-btn>
                                        </v-col>
                                      </v-row>
                                    </v-container>
                                  </v-card-text>
                                </v-card>
                              </v-dialog>
                              <v-dialog v-model="dialogDelete" max-width="400px">
                                <v-card class="h-100">
                                  <v-container>
                                    <h3 class="black-secondary text-center mt-3 mb-3">
                                      Eliminar registro
                                    </h3>
                                    <v-row>
                                      <v-col align="center">
                                        <v-btn
                                          color="btn-normal no-uppercase mt-3 mb-3 pr-5 pl-5 mx-auto"
                                          rounded
                                          @click="deleteItemConfirm"
                                          >Confirmar</v-btn
                                        >
                                        <v-btn
                                          color="btn-normal-close no-uppercase mt-3 mb-3"
                                          rounded
                                          @click="closeDelete"
                                        >
                                          Cancelar
                                        </v-btn>
                                      </v-col>
                                    </v-row>
                                  </v-container>
                                </v-card>
                              </v-dialog>
                            </v-toolbar>
                          </template>
                          <template v-slot:[`item.actions`]="{ item }">
                            <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
                            <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
                          </template>
                          <template v-slot:no-data>
                            <a
                              href="#"
                              class="btn btn-normal-secondary no-decoration"
                              @click="initializeDependence"
                            >
                              Reiniciar
                            </a>
                          </template>
                        </v-data-table>
                        <v-row>
                          <v-col align="center">
                            <v-btn
                              color="btn-normal-close no-uppercase mt-3"
                              rounded
                              @click="closeDependence"
                            >
                              Cancelar
                            </v-btn>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card-text>
                  </v-card>
                </v-dialog>
    </template>
    <!--form detail-->
  </div>
</template>

<script>
import instrumentApi from "../apis/instrumentApi";
import entityApi from "../apis/entityApi";
import roleApi from "../apis/roleApi";
import typeApi from "../apis/typeApi";
import directionApi from "../apis/directionApi";
import dependenceApi from "../apis/dependenceApi";
import sectorApi from "../apis/sectorApi";
import tariffApi from "../apis/tariffApi";
import exonerationApi from "../apis/exonerationApi";
import instrumentDependenceApi from "../apis/instrumentDependenceApi";
import lib from "../libs/function";
import { required, minLength, maxLength } from "vuelidate/lib/validators";
import axios from "axios";
import BaseInput from "./base-components/BaseInput.vue";
import { title } from "process";

export default {
  components: { BaseInput},
  data: () => ({
    search: "",
    dialog: false,
    dialogAdd: false,
    dialogDependence : false,
    showExoneration: false,
    dialogExoneration: false,
    viewExonerations: false,
    hidden: false,
    showModal: false,
    dialogDelete: false,
    headers: [
      { text: "INSTRUMENTO", value: "instrument_name" },
      { text: "TIPO DE INSTRUMENTO", value: "type_instrument_name" },
      { text: "ENTIDAD", value: "entity_name" },
      { text: "SECTOR", value: "sector_name" },
      { text: "DESCRIPCIÓN", value: "description" },
      { text: "ACCIONES", value: "actions", sortable: false },
    ],
    headersDependence: [
        { text: "DEPENDENCIAS", value: "dependence_name" },
        { text: "ACCIONES", value: "actions", sortable: false },
      ],
    records: [],
    recordsFiltered: [],
    records2: [],
      recordsFiltered2: [],
    editedIndex: -1,
    editedItem: {
      instrument_name: "",
      description: "",
      type_instrument_name: "",
      entity_name: "",
      national_direction_name: "",
      dependence_name: "",
      national_direction_name_instrument: "",
      dependence_name_instrument: "",
      service_place: "",
      amount_hour: "",
      amount_people: "",
      exonerated_description: "",
      people: "",
      hour: "",
      date: "",
      tariff_hour: "",
      not_charged_hour: "",
      tariff_people: "",
      not_charged_people: "",
      sector_name: "",
      concept: "",
      worth: "",
      concept_amount: "",
    },
    defaultItem: {
      instrument_name: "",
      description: "",
      type_instrument_name: "",
      entity_name: "",
      national_direction_name: "",
      dependence_name: "",
      national_direction_name_instrument: "",
      dependence_name_instrument: "",
      service_place: "",
      amount_hour: "",
      amount_people: "",
      exonerated_description: "",
      people: "",
      hour: "",
      date: "",
      tariff_hour: "",
      not_charged_hour: "",
      tariff_people: "",
      not_charged_people: "",
      sector_name: "",
      concept: "",
      worth: "",
      concept_amount: "",
    },
    editedItemD: {
        instrument_name: "",
        national_direction_name: "",
        dependence_name: "",
      },
      defaultItemD: {
        instrument_name: "",
        national_direction_name: "",
        dependence_name: "",
      },
    textAlert: "",
    alertEvent: "success",
    showAlert: false,
    exonerations: [],
    types: [],
    entities: [],
    directions: [],
    places: [],
    tariffs: [],
    dependences: [],
    sectors: [],
    redirectSessionFinished: false,
    alertTimeOut: 0,
  }),

  //Validations
  validations: {
    editedItem: {
        instrument_name: {
        required,
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      type_instrument_name: {
        required,
      },
      description: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      entity_name: {
        required,
      },
      sector_name: {
        required,
      },
      national_direction_name: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      dependence_name: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      national_direction_name_instrument: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      dependence_name_instrument: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      service_place: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      tariff_hour: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      not_charged_hour: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      tariff_people: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      not_charged_people: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      people: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      amount_hour: {
        minLength: minLength(1),
      },
      amount_people: {
        minLength: minLength(1),
      },
      hour: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      date: {
        minLength: minLength(1),
      },
      exonerated_description: {
        minLength: minLength(1),
      },
      concept: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      worth: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      concept_amount: {
        minLength: minLength(1),
      },
    },
    editedItemD: {
      instrument_name: {
        required,
        minLength: minLength(1),
        maxLength: maxLength(500),
      },
      national_direction_name: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
      dependence_name: {
        minLength: minLength(1),
        maxLength: maxLength(150),
      },
    },
  },

  //Validations
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo registro" : "Editar registro";
    },
    isUsuarioRole() {
    return this.roles.some(role => role.name === 'Usuario');
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogExoneration(val) {
      val || this.closeExoneration();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    viewExonerations(val) {
      val || this.closeExoneration();
    },
    dialogAdd(val) {
      val || this.closeAdd();
    },
    dialogDependence(val) {
      val || this.closeDependence();
    },
  },

  created() {
    this.initialize();
    this.initializeDependence();
  },

  methods: {
    async initialize() {
      this.records = [];
      this.recordsFiltered = [];

      let requests = [
        instrumentApi.get(),
        typeApi.get(),
        entityApi.get(),
        directionApi.get(),
        dependenceApi.get(),
        tariffApi.get(),
        sectorApi.get(),
        roleApi.get(),
      ];
      let responses = await Promise.all(requests).catch((error) => {
        this.updateAlert(true, "No fue posible obtener los registros.", "fail");
        this.redirectSessionFinished = lib.verifySessionFinished(
          error.response.status,
          401
        );
      });

      this.records = responses[0].data.instruments;
      this.types = responses[1].data.types;
      this.entities = responses[2].data.entities;
      this.directions = responses[3].data.directions;
      this.dependences = responses[4].data.dependences;
      this.tariffs = responses[5].data.tariffs;
      this.sectors = responses[6].data.sectors;
      this.roles = responses[7].data.roles;

      this.recordsFiltered = this.records;
    },

    async initializeDependence() {
      this.$v.$reset();
      this.records2 = [];
      this.recordsFiltered2 = [];

      let requests = [
        instrumentDependenceApi.get(),
        directionApi.get(),
        dependenceApi.get(),
        instrumentApi.get(),
      ];

      const responses = await Promise.all(requests).catch((error) => {
        this.updateAlert(true, "No fue posible eliminar el registros.", "fail");
        this.redirectSessionFinished = lib.verifySessionFinished(
          error.response.status,
          419
        );
      });

      this.records2 = responses[0].data.instrumentDependences;
      this.directions = responses[1].data.directions;
      this.dependences = responses[2].data.dependences;
      this.instruments = responses[3].data.instruments;

      this.recordsFiltered2 = this.records2;
    },

    async calculateExoneratedAmount() {
      
    },

    OpenAgreement() {
      this.dialog = true;
      this.showExoneration = false;
      this.editedItem.instrument_name = "";
      this.editedItem.entity_name = "";
      this.editedItem.sector_name = "";
      this.editedItem.type_instrument_name = "";
      this.editedItem.national_direction_name_instrument = "";
      this.editedItem.dependence_name_instrument = "";
      this.editedItem.description = "";
    },

    async save() {
      this.$v.$touch();
      if (this.editedIndex > -1) {
        console.log(this.editedItem);
        const res = await instrumentApi
          .put(`/${this.editedItem.id}`, this.editedItem)
          .catch((error) => {
            this.updateAlert(
              true,
              "No fue posible modificar el registro.",
              "fail"
            );
            this.close();
            this.redirectSessionFinished = lib.verifySessionFinished(
              error.response.status,
              419
            );
          });

        if (res.data.status == "success") {
          this.updateAlert(
            true,
            "Registro modificado correctamente.",
            "success"
          );
          window.location.reload();
        }
      } else {
        const res = await instrumentApi
          .post(null, this.editedItem)
          .catch((error) => {
            this.updateAlert(true, "No fue posible crear el registro.", "fail");
            this.close();
          });

        if (res.data.status == "success") {
          this.updateAlert(
            true,
            "Registro almacenado correctamente.",
            "success"
          );
        }
      }
      this.close();
      this.initialize();
    },

    editItem(item) {
      this.dialog = true;
      this.showExoneration = true;
      this.editedIndex = this.recordsFiltered.indexOf(item);
      this.editedItem = Object.assign({}, item);

      this.$v.editedItem.type_instrument_name.$model = this.editedItem.type_instrument_name;
      this.$v.editedItem.entity_name.$model = this.editedItem.entity_name;
      this.$v.editedItem.sector_name.$model = this.editedItem.sector_name;
      this.$v.editedItem.national_direction_name_instrument.$model = this.editedItem.national_direction_name_instrument;
      this.$v.editedItem.dependence_name_instrument.$model = this.editedItem.dependence_name_instrument;

      this.clearFields();
    },

    editItemDependence(item) {
      this.editedIndex = this.recordsFiltered2.indexOf(item);
      this.editedItemD = Object.assign({}, item);
      this.dialogDependence = true;
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
      if (this.formTitle === "Editar registro") {
        window.location.reload();
      }
    },

    closeDependence() {
      this.dialogDependence = false;
      this.$nextTick(() => {
        this.editedItemD = Object.assign({}, this.defaultItemD);
        this.editedIndex = -1;
      });
    },

    closeAdd() {
      this.dialogAdd = false;
    },

    deleteItem(item) {
      this.editedIndex = this.recordsFiltered2.indexOf(item);
      this.editedItemD = Object.assign({}, item);
      this.dialogDelete = true;
    },

    async deleteItemConfirm() {
      const res = await instrumentDependenceApi
        .delete(`/${this.editedItemD.id}`)
        .catch((error) => {
          this.updateAlert(
            true,
            "No fue posible eliminar el registros.",
            "fail"
          );
          this.close();
          this.redirectSessionFinished = lib.verifySessionFinished(
            error.response.status,
            419
          );
        });

      if (res.data.status == "success") {
        this.redirectSessionFinished = lib.verifySessionFinished(
          res.status,
          200
        );
        this.updateAlert(true, "Registro eliminado.", "success");
      }

      this.initializeDependence();
      this.closeDelete();
    },


    viewExonerationItem(item) {
      this.viewExonerations = true;
      this.editedIndex = this.recordsFiltered.indexOf(item);
      this.editedItem = Object.assign({}, item);

      this.$v.editedItem.type_instrument_name.$model = this.editedItem.type_instrument_name;
      this.$v.editedItem.entity_name.$model = this.editedItem.entity_name;
      this.$v.editedItem.sector_name.$model = this.editedItem.sector_name;
      this.$v.editedItem.national_direction_name_instrument.$model = this.editedItem.national_direction_name_instrument;
      this.$v.editedItem.dependence_name_instrument.$model = this.editedItem.dependence_name_instrument;
    },

    closeViewExonerations() {
      this.viewExonerations = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeExoneration() {
      this.dialogExoneration = false;
    },

    openExonerationModal() {
      this.dialogExoneration = true;

      this.editedItem.national_direction_name = "";
      this.editedItem.dependence_name = "";
      this.editedItem.service_place = "";
      this.editedItem.tariff_hour = "";
      this.editedItem.not_charged_hour = "";
      this.editedItem.tariff_people = "";
      this.editedItem.not_charged_people = "";
      this.editedItem.people = "";
      this.editedItem.date = "";
      this.editedItem.amount_hour = 0;
      this.editedItem.amount_people = 0;
      this.editedItem.hour = "";
      this.editedItem.exonerated_description = "";
      this.editedItem.concept = "",
      this.editedItem.worth = "",
      this.editedItem.concept_amount = "",

      this.$v.editedItem.$reset();
    },

    clearFields() {
      this.editedItem.exonerations.splice(0);
    },

    showSaveButton() {
      return this.editedItem.exonerations.length > 0;
    },

    noData() {
      return this.editedItem.exonerations.length == 0;
    },

    async addNewExoneration() {
      this.$v.$touch();
      /* if (this.$v.$invalid) {
        this.updateAlert(true, "Campos obligatorios.", "fail");
        return;
      } */

      const selectedTariffHour = this.tariffs.find(tariff => tariff.type_charge === this.editedItem.tariff_hour)
      const tariffAmountHour = selectedTariffHour ? selectedTariffHour.amount : 0

      const selectedTariffPeople = this.tariffs.find(tariff => tariff.type_charge === this.editedItem.tariff_people)
      const tariffAmountPeople = selectedTariffPeople ? selectedTariffPeople.amount : 0

      const newExoneration = {
        exonerated_description: this.editedItem.exonerated_description,
        dependence_name: this.editedItem.dependence_name,
        hour: this.editedItem.hour,
        people: this.editedItem.people,
        date: this.editedItem.date,
        service_place: this.editedItem.service_place,
        tariff_hour: this.editedItem.tariff_hour,
        not_charged_hour: this.editedItem.not_charged_hour,
        tariff_people: this.editedItem.tariff_people,
        not_charged_people: this.editedItem.not_charged_people,
        amount_hour: this.editedItem.hour * (this.editedItem.not_charged_hour || tariffAmountHour),
        amount_people: this.editedItem.people * (this.editedItem.not_charged_people || tariffAmountPeople),
        concept: this.editedItem.concept,
        worth: this.editedItem.worth,
        concept_amount: this.editedItem.concept_amount,
      };

      this.editedItem.exonerations.push(newExoneration);
      this.$nextTick(() => {
        this.closeExoneration();
      });
    },

    async saveExoneration() {
      this.$v.$touch();
      /* if (this.$v.$invalid) {
        this.updateAlert(true, "Campos obligatorios.", "fail");
        return;
      } */

      const res = await exonerationApi
        .post(null, this.editedItem)
        .catch((error) => {
          this.updateAlert(true, "No fue posible crear el registro.", "fail");
        });

      if (res.data.status == "success") {
        this.updateAlert(true, "Registro almacenado correctamente.", "success");
      }

      this.close();
      //this.initialize();
      window.location.reload();
    },

    async saveDependence() {
      this.$v.$touch();
      if (this.editedIndex > -1) {
        console.log(this.editedItemD);
        const res = await userDependenceApi
          .put(`/${this.editedItemD.id}`, this.editedItemD)
          .catch((error) => {
            this.updateAlert(
              true,
              "No fue posible modificar el registro.",
              "fail"
            );
            this.close();
            this.redirectSessionFinished = lib.verifySessionFinished(
              error.response.status,
              419
            );
          });

        if (res.data.status == "success") {
          this.updateAlert(
            true,
            "Registro modificado correctamente.",
            "success"
          );
          window.location.reload();
        }
      } else {
        const res = await instrumentDependenceApi
          .post(null, this.editedItemD)
          .catch((error) => {
            this.updateAlert(true, "No fue posible crear el registro.", "fail");
            this.close();
          });

        if (res.data.status == "success") {
          this.updateAlert(
            true,
            "Registro almacenado correctamente.",
            "success"
          );
        }
      }
      this.closeAdd();
      this.initializeDependence();
    },

    editItemExoneration() {
      this.dialogExoneration = true;
      this.deleteItemOfTable();
    },

    deleteItem() {
      this.dialogDelete = true;
    },

    deleteItemOfTable() {
      this.editedItem.exonerations.splice(
        this.editedItem.exonerations.indexOf(this.exoneration),
        1
      );
      this.closeDelete();
    },

    closeDelete() {
      this.dialogDelete = false;
    },

    async changeDirection() {
      let { data } = await axios
        .get(
          "api/dependence/byDirectionName/" +
            this.editedItem.national_direction_name
        )
        .catch((error) => {
          this.$emit("update-alert", {
            show: true,
            message:
              "No fue posible obtener la información de las dependencias. ",
            type: "fail",
          });
        });
      this.dependences = data.dependences;
    },

    async changeDependence() {
      let { data } = await axios
        .get("api/tariff/byDependenceName/" + this.editedItem.dependence_name)
        .catch((error) => {
          this.$emit("update-alert", {
            show: true,
            message:
              "No fue posible obtener la información de las dependencias. ",
            type: "fail",
          });
        });
      this.tariffs = data.tariffs;
    },

    searchValue() {
      this.recordsFiltered = [];

      if (this.search != "") {
        this.records.forEach((record) => {
          let searchConcat = "";
          for (let i = 0; i < record.instrument_name.length; i++) {
            searchConcat += record.instrument_name[i].toUpperCase();
            if (
              searchConcat === this.search.toUpperCase() &&
              !this.recordsFiltered.some((rec) => rec == record)
            ) {
              this.recordsFiltered.push(record);
            }
          }
        });
        return;
      }

      this.recordsFiltered = this.records;
    },

    updateAlert(show = false, text = "Alerta", event = "success") {
      this.textAlert = text;
      this.alertEvent = event;
      this.showAlert = show;
    },

    updateTimeOut(event) {
      this.redirectSessionFinished = event;
    },

    async changeDirectionI() {
      let { data } = await axios
        .get(
          "api/dependence/byDirectionName/" +
          this.editedItemD.national_direction_name
        )
        .catch((error) => {
          this.$emit("update-alert", {
            show: true,
            message:
              "No fue posible obtener la información de las dependencias. ",
            type: "fail",
          });
        });
      this.dependences = data.dependences;
    },
  },
};
</script>