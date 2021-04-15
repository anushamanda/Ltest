<template>
  <div class="m-2">
    <contentheader :title="heading" :help_menu="true"
                   :trail="(action.create) ? trail.create : trail.default" model_name="missingperson"
                   :missingperson= "(action.create) ? null : missingperson" :crud_action="action" @eventEdit="edit"  @eventSave="save">
    </contentheader>
    <br>
    <div>
      <v-row>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.suffix" :disabled="!this.editable" :loading="loading" label="suffix" color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.first_name" :disabled="!this.editable" :loading="loading" label="First Name" type="string" color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.middle_name" :disabled="!this.editable" :loading="loading" label="Middle Name" type="string" color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.last_name" :disabled="!this.editable" :loading="loading" label="Last Name" type="string" color="primary" ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.correct_name" :disabled="!this.editable" :loading="loading" label="Correct Name"   color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.country" :disabled="!this.editable" :loading="loading" label="Country"   color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.frs_xfile"  :disabled="!this.editable" :loading="loading" label="Frs xfile" color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.conflict"  :disabled="!this.editable" :loading="loading" label="Conflict "   color="primary" ></v-text-field>
        </v-col>
      </v-row>
      <v-row>

        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.serial_number" :disabled="!this.editable" :loading="loading" label="Serial Number" color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled  v-model="form.incident" :disabled="!this.editable" :loading="loading" label="Incident" color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled v-model="form.field_grave" :disabled="!this.editable" :loading="loading" label="Field Grave" color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled  v-model="form.temp_field_grave" :disabled="!this.editable" :loading="loading" label="Temp Field Grave" color="primary" ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled  v-model="form.priority_dpaa" :disabled="!this.editable" :loading="loading" label="Priority Dpaa" color="primary" ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-text-field disabled  v-model="form.priority_pcrb" :disabled="!this.editable" :loading="loading" label="Priority Pcrb" color="primary" ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="3" sm="12" >
          <v-switch :disabled="!this.editable" v-model="form.genealogy_request" :loading="loading" label="Genealogy Requested" color="primary" ></v-switch>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <date disabled  v-model="form.genealogy_request_date"  :loading="loading" label="Genealogy Request Date "   color="primary" ></date>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-switch :disabled="!this.editable" v-model="form.genealogy_sent"  :loading="loading" label="Genealogy Sent" color="primary" ></v-switch>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <date disabled v-model="form.genealogy_sent_date" :loading="loading" label="Genealogy Sent Date" color="primary" ></date>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="3" sm="12" >
          <v-switch :disabled="!this.editable" v-model="form.genealogy_receive" :loading="loading" label="Genealogy Receive" color="primary" ></v-switch>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <date disabled v-model="form.genealogy_receive_date"  :loading="loading" label="Receive Date "   color="primary" ></date>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <v-switch :disabled="!this.editable" v-model="form.genealogy_not_required" :loading="loading" label="Genealogy not Required" color="primary" ></v-switch>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
          <date disabled v-model="form.genealogy_not_required_date" :loading="loading" label="Not Required Date" color="primary" ></date>
        </v-col>
      </v-row>
    </div>
    <v-card flat>

      <v-stepper v-model="step" vertical>

        <v-stepper-step editable :complete="step > 1" step="1" >Case Information</v-stepper-step>
        <v-stepper-content step="1" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field disabled v-model="form.case_number" :disabled="!this.editable" :loading="loading" label="Case Number "   color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field disabled  v-model="form.case_status" :disabled="!this.editable" :loading="loading" label="Case Status" color="primary" ></v-text-field>
              </v-col>
              <v-col>
                <v-text-field disabled  v-model="form.lab_notes" :disabled="!this.editable" :loading="loading" label="Lab Notes" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field disabled  v-model="form.case_notes"  :disabled="!this.editable" :loading="loading" label="Case Notes" color="primary" ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field disabled v-model="form.case_manager" :disabled="!this.editable" :loading="loading" label="Case Manager" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.case_assign_date" :disabled="!this.editable" :loading="loading" label="Case Assign Date" color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.case_complete_date" :disabled="!this.editable" :loading="loading" label="Case Complete Date" color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.case_partial_date"  :loading="loading" label="Case Partial Date" color="primary" ></date>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.case_exhausted_all_resources_date" :disabled="!this.editable" :loading="loading" label="Case Exhausted All Resources Date" color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled  v-model="form.case_identification_date" :disabled="!this.editable" :loading="loading" label="Case Identification Date" color="primary" ></date>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
        <v-stepper-step editable :complete="step > 1" step="2" >Genealogy</v-stepper-step>
        <v-stepper-content step="2" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="12" sm="12" >
              <v-data-table :headers="columnVisibility" :items="gnnItems" calculate-widths="" :loading="loading" >
                <template v-slot:item.action="{ item }">
                  <v-icon color="primary" class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                  <MissingpersonCrud :missingpersons= item.mp_id ></MissingpersonCrud>
                </template>
              </v-data-table>
                <v-row></v-row>
                <v-row class="justify-center">
                  <v-btn title="Save" color="primary"  class="mr-2" @click="saveItem(item)"><v-icon class="mr-2">mdi-content-save</v-icon>Add</v-btn>
                  <MissingpersonCrud :missingpersons= missingpersons.id ></MissingpersonCrud>
                </v-row>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
        <v-stepper-step editable :complete="step > 2" step="3" >FRS and DNA Information</v-stepper-step>
        <v-stepper-content step="3" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.frs_request_mtdna_1"  :loading="loading" label="Frs Request Mtdna 1 "   color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.frs_request_mtdna_1_date"  :loading="loading" label="Frs Request Mtdna 1 Date "   color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.lab_receive_mtdna_1" :loading="loading" label="Lab Receive Mtdna 1" color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.lab_receive_mtdna_1_date" :loading="loading" label="Lab Receive Mtdna 1 date" color="primary" ></date>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.frs_request_mtdna_2"  :loading="loading" label="Frs Request Mtdna 2"   color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.frs_request_mtdna_2_date"  :loading="loading" label="Frs Request Mtdna 2 Date "   color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable"  v-model="form.lab_receive_request_mtdna_2" :loading="loading" label="Lab Receive Mtdna 2" color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.lab_receive_request_mtdna_2_date" :loading="loading" label="Lab Receive Mtdna 2 Date" color="primary" ></date>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.frs_request_mtdna_3"  :loading="loading" label="Frs Request Mtdna 3 "   color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.frs_request_mtdna_3_date"  :loading="loading" label="Frs Request Mtdna 3 Date "   color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable"  v-model="form.lab_receive_request_mtdna_3" :loading="loading" label="Lab Receive Mtdna 3" color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.lab_receive_request_mtdna_3_date" :loading="loading" label="Lab Receive Mtdna 3 Date" color="primary" ></date>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.frs_request_ystr_1"  :loading="loading" label="Frs Request Ystr 1 "   color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.frs_request_ystr_1_date"  :loading="loading" label="Frs Request Ystr 1 Date "   color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable"  v-model="form.lab_receive_request_ystr_1" :loading="loading" label="Lab Receive Request Ystr 1" color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.lab_receive_request_ystr_1_date" :loading="loading" label="Lab Receive Request Ystr 1 Date" color="primary" ></date>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.frs_request_ystr_2"  :loading="loading" label="Frs Request Ystr 2 "   color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.frs_request_ystr_2_date"  :loading="loading" label="Frs Request Ystr 2 Date "   color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable"  v-model="form.lab_receive_request_ystr_2" :loading="loading" label="Lab Receive Request Ystr 2" color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.lab_receive_request_ystr_2_date" :loading="loading" label="Lab Receive Request Ystr 2 Date" color="primary" ></date>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.frs_request_austr_1"  :loading="loading" label="Frs Request Austr 1 "   color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.frs_request_austr_1_date"  :loading="loading" label="Frs Request Austr 1 Date "   color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.lab_receive_request_austr_1" :loading="loading" label="Lab Receive Request Austr 1" color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.lab_receive_request_austr_1_date" :loading="loading" label="Lab Receive Request Austr 1 Date" color="primary" ></date>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.frs_request_austr_2"  :loading="loading" label="Frs Request Austr 2 "   color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.frs_request_austr_2_date"  :loading="loading" label="Frs Request Austr 2 Date "   color="primary" ></date>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-switch :disabled="!this.editable" v-model="form.lab_receive_request_austr_2" :loading="loading" label="Lab Receive Request Austr 2" color="primary" ></v-switch>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <date disabled v-model="form.lab_receive_request_austr_2_date" :loading="loading" label="Lab Receive Request Austr 2 Date" color="primary" ></date>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
      </v-stepper>
    </v-card>
    <v-card-actions>
      <v-row class="justify-center">
        <v-btn title="Save" color="primary" :disabled="!this.editable" class="mr-2" @click="save()"><v-icon class="mr-2">mdi-content-save</v-icon>Save</v-btn>
      </v-row>
    </v-card-actions>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import axios from 'axios';
import { changeObjectToArray } from "../../coraBaseModules";
import {eventBus} from "../../eventBus";
import MPCrud from "./MissingPersonsCrud";


export default {
  name: "MissingPerson",
  components: {MPCrud},
  props: {
    crud_action: {type: String, default: "View"},
    missingpersons: {type: Object},
    gnn : {type:Object},
    list_dcip_cases: {type: Object},
  },
  data() {
    return {
      trail: {
        'create': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Missing Persons', disabled: true, href: '/missingpersons'},],
        'default': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Missing Persons', disabled: true, href: '/missingpersons'},]
      },
      form: {},
      headers: [
        {text: 'Priority', value: 'priority', visibility: true},
        {text: 'Notes', value: 'notes', visibility: true},
        {text: 'Enclosed Documents', value: 'enclosed_documents', visibility: true},
        {text: 'Company', value: 'company', visibility: true},
        {text: 'Funded By', value: 'funded_by', visibility: true},
        {text: 'Request Date', value: 'request_date', visibility: true},
        {text: 'Receive Date', value: 'receive_date', visibility: true},
        {text: 'Actions', value: "action", visibility: true},

      ],
      step: 1,
      showForm: true,
      heading: '',
      dcip: {},
      // resultConfidence: [ 'Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled' ],
      loading: false,
      editable: false,
      editLab: false,
      // batchNumber: '',
      dcip_cases: [],
      read_only: true,
    };
  },
  created(){
    this.getDcip();
  },
  watch: {

  },
  methods: {
    expand(val) {
      this.showForm = val;
    },
    save() {
      this.loading = true;
      axios
          .request({
            url: "/api/missingpersons/" + this.missingpersons.id,
            method: "PUT",
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.$store.getters.bearerToken
            },
            data: this.form
          }).then(response => {
        this.dcip = response.data.data;
        this.id = response.data.data.id;
        this.loading = false;
        this.editable = false;
        this.editLab = false;
        this.setHeading();
        this.setFields();
        window.location.href = '/missingpersons/' + this.missingpersons.id;
        let payload = { 'text': 'Update successful', 'color': 'success', };
        eventBus.$emit('show-snackbar', payload);
      }).catch(error => {
        console.log(error);
        this.loading = false;
        this.snackbar=true;
        this.snackbar_text = 'MissingPerson Update unsuccessful. Please recheck your inputs.';
        this.snackbar_color = 'info';
      })
    },
    edit() {
      this.editable = true;
      if(this.batchNumber){
        this.editLab = false;
      }else{
        this.editLab = true;
      }
    },
    editItem(item) {
      let payload = { 'title': 'Edit Genealogy', 'action': 'Edit','item': item };
      eventBus.$emit('missing person crud dialog',payload);
    },
    saveItem(item) {
      let payload = { 'title': 'Create Genealogy', 'action': 'Create', 'item': item };
      eventBus.$emit('missing person crud dialog', payload);
    },
    getDcip() {
      this.loading = true;
      axios
          .request({
            url: "/api/missingpersons/" + this.missingpersons.id,
            method: "GET",
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.$store.getters.bearerToken
            },
          }).then(response => {
        this.dcip = response.data.data;
        this.id = response.data.data.id;
        console.log(this.dcip);
        this.setHeading();
        this.setFields();
        this.loading = false;
      }).catch(error => {
        console.log(error);
        this.loading = false;
      })
    },
    setHeading(){
      this.heading = "View MissingPerson - " + this.dcip.case_number;
    },
    setFields() {
      this.form = this.dcip;
      this.form.id = this.dcip.id;
      // this.form.id = this.dcip.id.toString()
    },
  },
  computed: {
    columnVisibility(){
      return this.headers.filter(item => item.visibility === true);
    },
    gnnItems() {
      const rows = [];
      Object.values(this.gnn).forEach(item =>
          rows.push({
            id: item.id,
            mp_id:this.missingpersons.id,
            priority: item.priority,
            notes:item.notes,
            enclosed_documents: item.enclosed_documents,
            company: item.company,
            funded_by:item.funded_by,
            receive_date:item.receive_date,
            request_date:item.request_date,
          })
      );
      return rows;
    },
    ...mapGetters({
      //getLabs: 'getLabs',
      project_id: 'theProjectId',
      user_id: 'theUserId',

      // getProject: 'getProjectById',
      // getBone: 'getBone',
    }),
    action() {
      const act = this.crud_action;
      return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
    },
    toolbarProps() {
      if (this.action.create || this.action.edit) {
        return { reset: true, save: {disabled: !this.edited} };
      } else if (this.action.view) {
        return { edit: true };
      } else {
        return {};
      }
    },

  }
}
</script>
<style scoped>
</style>