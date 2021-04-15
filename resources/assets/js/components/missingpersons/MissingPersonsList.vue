<template>
  <div  class="m-2">
    <contentheader :title="this.heading" :help_menu="true" :trail="(action.create) ? trail.create : trail.default" model_name="missingperson"
                   :crud_action="action" @eventNew="this.new">
    </contentheader>

    <br>
    <div>
      <v-row>
        <v-col cols="9">
          <v-btn-toggle v-model="toggle_multiple" dense multiple>
            <v-btn>Excel</v-btn>
            <v-btn>PDF</v-btn>
            <v-menu right offset-x :close-on-content-click="false" max-height="500px">
              <template v-slot:activator="{ on }">
                <v-btn v-on="on">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
              </template>
              <v-list>
                <v-list-item v-for="(header, index) in headers" :key="index">
                  <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"></v-checkbox>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-btn-toggle>
        </v-col>
        <v-spacer></v-spacer>
        <v-col cols="3">
          <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"></v-text-field>
        </v-col>
      </v-row>
      <v-data-table :headers="columnVisibility":items="dcipItems"  :items-per-page="perPage" :options.sync="options" calculate-widths="" :loading="loading"
                    class="elevation-1" multi-sort :search="search" :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }"
      >
        <template v-slot:item.case_number="{ item }">
          <a :href="encodedIsotopeBatchURI(item)" target="_blank">{{ item.case_number }}</a>
        </template>
      </v-data-table>


      <br>
    </div>
  </div>
</template>


<script>
import {mapGetters, mapState} from "vuex";
import axios from 'axios';

export default {
  name: "dcipsList",
  props: {
    heading: {type: String, default: "Missing Persons"},
    crud_action: {type: String, default: "List"},
    // specimen: { type: Object, default: null },
  },
  data() {
    return {
      trail: {
        'create': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Dcips ', disabled: false, href: "/missingpersons"},
          {text: 'New', disabled: true, href: "/"},],
        'default': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Dcips ', disabled: true, href:  "/missingpersons"},
        ],
      },
      headers: [
        {text: 'Case Number', value: 'case_number', visibility: true},
        {text: 'Conflict', value: 'conflict', visibility: true},
        {text: 'Incident', value: 'incident', visibility: true},
        {text: 'Case Status', value: 'case_status', visibility: true},
        {text: 'Full Name', value: 'full_name', visibility: true},
        {text: 'Correct Name', value: 'correct_name', visibility: true},
        {text: 'Priority Dpaa', value: 'priority_dpaa', visibility: true},
        {text: 'Priority Pcrb', value: 'priority_pcrb', visibility: true},
      ],
      perPage: 100,
      searchResults: null,
      totalSearchCount: 0,
      options:{},
      toggle_multiple: [],
      showReportCriteria: true,
      dcips: {},
      loading: false,
      search:'',
    };
  },
  created() {
    this.fetchDcipCases();
  },
  watch: {
    options: {
      handler () {
        this.fetchDcipCases();
      },
      deep: true,
    },
  },
  methods: {
    fetchDcipCases(){
      this.loading = true;
      axios
          .request({
            url: '/api/missingpersons' ,
            method: "GET",
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.$store.getters.bearerToken
            },
            params: {
              page: this.options.page,
              per_page: this.options.itemsPerPage
            }
          }).then(response => {
        this.loading = false;
        this.dcips = response.data.data;
        // this.totalSearchCount = response.data.meta.total;
        this.showTable = true;
      }).catch(error => {
        this.loading = false;
      })
    },
    encodedIsotopeBatchURI(item) {
      let url;

      url = "/missingpersons/" + item.id;

      return url;
    },
    new() {
      location.assign(`/missingpersons/create`);
    },
  },
  computed: {
    columnVisibility(){
      return this.headers.filter(item => item.visibility === true);
    },
    dcipItems() {
      const rows = [];
      Object.values(this.dcips).forEach(item =>
          rows.push({
            id: item.id,
            case_number: item.case_number,
            conflict:item.conflict,
            incident: item.incident,
            case_status: item.case_status,
            middle_name:item.middle_name,
            full_name: item.suffix +" " + item.first_name + " "+ item.middle_name +" "+ item.last_name,
            correct_name: item.correct_name,
            priority_dpaa: item.priority_dpaa,
            priority_pcrb: item.priority_pcrb,
            lab_project_manager_id: item.lab_project_manager_id,
            case_manager_id: item.case_manager_id,
            serial_number:item.serial_number,
            field_grave:item.field_grave,
            temp_field_grave:item.temp_field_grave,
            lab_notes:item.lab_notes,
            case_notes:item.case_notes,
            case_manager:item.case_manager,
            case_assign_date:item.case_assign_date,
            case_complete_date:item.case_complete_date,
            case_partial_date:item.case_partial_date,
            case_exhausted_all_resources_date:item.case_exhausted_all_resources_date,
            case_identification_date:item.case_identification_date,
            case_remains_in_lab_date:item.case_remains_in_lab_date,
            frs_request_mtdna_1:item.frs_request_mtdna_1,
            frs_request_mtdna_2:item.frs_request_mtdna_2,
            frs_request_mtdna_3:item.frs_request_mtdna_3,
            frs_request_ystr_1:item.frs_request_ystr_1,
            frs_request_ystr_2:item.frs_request_ystr_1,
            frs_request_austr_1:item.frs_request_austr_1,
            frs_request_austr_2:item.frs_request_austr_1,
            frs_request_mtdna_1_date:item.frs_request_mtdna_1_date,
            frs_request_mtdna_2_date:item.frs_request_mtdna_2_date,
            frs_request_mtdna_3_date:item.frs_request_mtdna_3_date,
            frs_request_ystr_1_date:item.frs_request_ystr_1_date,
            frs_request_ystr_2_date:item.frs_request_ystr_2_date,
            frs_request_austr_1_date:item.frs_request_austr_1_date,
            frs_request_austr_2_date:item.frs_request_austr_2_date,
            lab_receive_mtdna_1:item.lab_receive_mtdna_1,
            lab_receive_request_mtdna_2:item.lab_receive_request_mtdna_2,
            lab_receive_request_mtdna_3:item.lab_receive_request_mtdna_3,
            lab_receive_request_ystr_1:item.lab_receive_request_ystr_1,
            lab_receive_request_ystr_2:item.lab_receive_request_ystr_2,
            lab_receive_request_austr_1:item.lab_receive_request_austr_1,
            lab_receive_request_austr_2:item.lab_receive_request_austr_2,
            lab_receive_mtdna_1_date:item.lab_receive_mtdna_1_date,
            lab_receive_request_mtdna_2_date:item.lab_receive_request_mtdna_2_date,
            lab_receive_request_mtdna_3_date:item.lab_receive_request_mtdna_3_date,
            lab_receive_request_ystr_1_date:item.lab_receive_request_ystr_1_date,
            lab_receive_request_ystr_2_date:item.lab_receive_request_ystr_2_date,
            lab_receive_request_austr_1_date:item.lab_receive_request_austr_1_date,
            lab_receive_request_austr_2_date:item.lab_receive_request_austr_2_date,
            genealogy_request:item.genealogy_request,
            genealogy_sent:item.genealogy_sent,
            genealogy_receive:item.genealogy_receive,
            genealogy_not_required:item.genealogy_not_required,
            genealogy_request_date:item.genealogy_request_date,
            genealogy_sent_date:item.genealogy_sent_date,
            genealogy_receive_date:item.genealogy_receive_date,
            genealogy_not_required_date:item.genealogy_not_required_date
          })
      );

      return rows;
    },
    ...mapState({
      rowsPerPageItems: state => state.search.rowsPerPageItems,
    }),
    ...mapGetters({
      project_id: 'theProjectId'


    }),

    action() {
      const act = this.crud_action;
      return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
    },
    toolbarProps() {
      if (this.action.create || this.action.edit) {
        return { rese: true, save: {disabled: !this.edited} };
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