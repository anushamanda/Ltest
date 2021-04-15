<template>
   <div class="m-2">
      <contentheader :trail="this.trail" model_name="project_dental" :reset_menu="true" @eventReset="reset"
                   :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                   :generate_menu="true" :disable_generate="this.disable_generate" @eventGenerate="generate">
      </contentheader>
      <br>
      <v-card>
          <v-container fluid v-show="showReportCriteria">
          <v-row>
              <v-col cols="12" md="3" sm="12">
                <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" placeholder="Select Accession Number" dusk="se-accession" clearable > </v-autocomplete>
              </v-col>
              <v-col cols="12" md="3" sm="12">
                <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" dusk="se-provenance1" clearable></v-autocomplete>
              </v-col>
              <v-col cols="12" md="3" sm="12">
                 <v-autocomplete v-model="form.p2" :items="items_provenance2" item-text="name" label="Provenance 2" placeholder="Select Provenance 2" dusk="se-provenance2"  clearable></v-autocomplete>
              </v-col>
          </v-row>
          <v-row>
             <v-col cols="12" md="3" sm="12">
               <v-autocomplete v-model="form.tooth"  :items="tooth_items" item-value="id" item-text="name" label="Tooth" placeholder="Select Tooth" multiple clearable chips deletable-chips clearable dusk="se-bone" clearable></v-autocomplete>
             </v-col>
               <v-col cols="12" md="3" sm="12">
               <v-autocomplete v-model="form.dc_id" :items="dentalCodeData" label="Dental code" placeholder="Select Dental Code" dusk="dental-codes" item-value="id"  item-text="description" multiple clearable chips deletable-chips  clearable>
                 <template v-slot:selection="data">
                     <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color"  @click="data.select">
                       {{ data.item.description}}
                     </v-chip>
                   </template>
                   <template v-slot:item="data">
                     <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item"></v-list-item-content></template>
                     <template v-else>
                       <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                       <v-list-item-content :background-color="data.item.color">
                         <v-list-item-title v-html="data.item.description"></v-list-item-title>
                       </v-list-item-content>
                     </template>
                   </template>
               </v-autocomplete>
             </v-col>
          </v-row>
          <v-row>
              <v-col cols="12" md="3" sm="12">
                <date v-model="form.request_date_start" label="Request Dates From" name="request_date_start" dusk="request-dates-from"></date>
              </v-col>
              <v-col cols="12" md="3" sm="12">
                <date v-model="form.request_date_end" label="Request Dates To" :minvalue="form.request_date_start" name="request_date_end" dusk="request-date-end"></date>
              </v-col>
          </v-row>
          <v-row>
              <v-col cols="12" md="3" sm="12">
                <date v-model="form.receive_date_start" label="Receive Dates From"  name="receive_date_start" dusk="receive-date-start"></date>
              </v-col>
              <v-col cols="12" md="3" sm="12">
                <date v-model="form.receive_date_end" label="Receive Dates To" :minvalue="form.receive_date_start" name="receive_date_end" dusk="receive-date-end"></date>
              </v-col>
          </v-row>
      </v-container>
      <div v-show="showTable" >
          <v-row>
              <v-col cols="9">
                  <v-btn-toggle v-model="toggle_multiple" dense multiple>
                     <v-btn dusk="excel">Excel</v-btn>
                     <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                       <template v-slot:activator="{ on }">
                       <v-btn v-on="on" dusk="column-visibility">Column Visibility<v-icon right dusk="collapse-button" >$dropdown</v-icon></v-btn>
                        </template>
                        <v-list>
                        <v-list-item v-for="(header, index) in headers" :key="index">
                       <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility" :dusk="header.text"></v-checkbox>
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
         <v-data-table :headers="columnVisibility" :items="dentalItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                      calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>
           <template v-slot:item.dc_id="{ item }">
             <a class="mx-1"
                   v-for="(dentalcodes, index) in item.dental_codes"
                   :key="index"
                   target="_blank"
               >{{ dentalcodes.description }}</a>
           </template>

           <template v-slot:item.measured="{ item }">
             <v-icon right :color="getIconColor(item.measured)" small>{{ getBooleanIcon(item.measured) }}</v-icon>
           </template>


           <template v-slot:item.clavicle_triage="{ item }">
             <v-icon right :color="getIconColor(item.clavicle_triage)" small>{{ getBooleanIcon(item.clavicle_triage) }}</v-icon>
           </template>

           <template v-slot:item.dna_sampled="{ item }">
             <v-icon
                 right
                 :color="getIconColor(item.dna_sampled)"
                 small
             >{{ getBooleanIcon(item.dna_sampled) }}</v-icon>
           </template>

           <template v-slot:item.isotope_sampled="{ item }">
             <v-icon
                 right
                 :color="getIconColor(item.isotope_sampled)"
                 small
             >{{ getBooleanIcon(item.isotope_sampled) }}</v-icon>
           </template>
         </v-data-table>
        <br>
      </div>

      </v-card>
      </div>
</template>
<script>
    import {mapGetters, mapState} from 'vuex';
    import { eventBus } from '../../../eventBus';
    import axios from "axios";
    export default {
        name: "project-dental-report",
            data() {
                return {
                  trail: [{text: 'Home', disabled: false, href: '/',},
                    {text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard'},
                    {text: 'Dental Report', disabled: true, href: '/dental',},
                  ],
                  form: {},
                  sending: false,
                  resultsFetched: false,
                  info: false,
                  showReportCriteria: true,
                  showNextStep: false,
                  totalSearchCount: 0,
                  resultData: [],
                  showTable: false,
                  disable_generate: true,
                  specimens: {},
                  loading: false,
                  dental_codes:[],
                  dentalCodeData:[],
                  selectedTeeth: null,
                  items_side: null,
                  items_side_all: ["Left", "Right", "Middle", "Unsided"],
                      headers: [
                        { text: "Key", value: "key", visibility: true },
                        { text: "Bone", value: "bone", visibility: true },
                        { text: "Side", value: "side", visibility: true },
                        { text: "Bone Group", value: "bone_group", visibility: true },
                        { text: "Individual Number", value: "individual_number", visibility: true },
                        { text: "DNA Sampled", value: "dna_sampled", visibility: true },
                        { text: "Mito Sequence Number", value: "mito_sequence_number", visibility: true},
                        { text: "Dental Code", value: "dc_id", visibility: true,width: "12rem"},
                        { text: "Associations", value: "associations", visibility: true },
                        { text: "Pathology", value: "pathologies", visibility: true },
                        { text: "Methods", value: "methods", visibility: true },
                        { text: "Measured", value: "measured", visibility: true },
                        { text: "Isotope Sampled", value: "isotope_sampled", visibility: true },
                        { text: "Clavicle Triage", value: "clavicle_triage", visibility: true },
                        { text: "Request Dates From", value: "request_date_start" },
                        { text: "Request Dates To", value: "request_date_end" },
                        { text: "Receive Dates From", value: "receive_date_start" },
                        { text: "Receive Dates To", value: "receive_date_end" },
                      ],
                  toggle_multiple: [],
                  searchResults: null,
                  items: [],
                  options: {},
                  search: "",
                  perPage:100,
                  skeletalElements:[]
                };
            },

            watch: {
                options: {
                  handler() {
                    this.generate()
                  },
                  deep: true,

                }
            },
            mounted() {
              this.form.bones = this.tooth_list;
               this.getDentalCodes();
              this.selectedTeeth = new Map();
              //
            },
            created() {
              this.items_side = this.items_side_all
              this.items_groupSide = this.items_side_all
            },
            methods: {
                reset() {
                   this.form = {};
                 this.showTable = false;
                },
              getDentalCodes(){
                  this.loading = true;
                  axios
                      .request({
                        url: '/api/dental/',
                        method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                      }).then(response=>{
                    this.dentalCodeData = response.data.data;
                    this.loading = false;
                  }).catch(error => {
                    this.loading = false;
                  })
              },
              getKey(item) {
                return `${item.accession_number ? item.accession_number : ''}:
                        ${item.provenance1 ? item.provenance1 : ''}:
                        ${item.provenance2 ? item.provenance2 : ''}:
                        ${item.designator ? item.designator : ''}`;

                },
              getBooleanIcon(item) {
                  return item === true ? "✔" : "";
                },
              getIconColor(item) {
                  return item === true ? "success" : "";
                },
              onExpand(val) {
                  this.showReportCriteria = val;
                },
              generate() {
                  if (!this.disable_generate) {
                    this.form.finalsearch = true;
                    eventBus.$emit('generate-loading', true);
                    this.showTable = false;
                    axios
                        .request({
                          url: '/api/reports/projects/' + this.project_id + '/dental',
                          method: "GET",
                          headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken},
                          params: {
                            an: this.form.an ? [this.form.an] : null,
                            p1: this.form.p1 ? [this.form.p1] : null,
                            p2: this.form.p2 ? [this.form.p2] : null,
                            sb_id: this.form.tooth ? this.form.tooth : null,
                            side: this.form.side_select ? this.form.side_select : null,
                            dc_id: this.form.dc_id ? this.form.dc_id : null,
                            measured: this.form.measured ? this.form.measured : null,
                            dna_sampled: this.form.dna_sampled ? this.form.dna_sampled : null,
                            clavicle_triage: this.form.clavicle_triage ? this.form.clavicle_triage : null,
                            page: this.options.page,
                            per_page: this.perPage
                          },
                        }).then(response => {
                      eventBus.$emit('generate-loading', false);
                      this.showTable = true;
                      this.skeletalElements = response.data.data;
                      this.specimens = response.data.data;
                      this.totalSearchCount = response.data.meta.total;
                    }).catch(error => {
                      console.log(error);
                      eventBus.$emit('generate-loading', false);
                    })
                  } else {
                    this.disable_generate = false;
                    eventBus.$emit('disable_generate', this.disable_generate);
                  }
              }

            },
            computed: {
                columnVisibility() {
                  return this.headers.filter(item => item.visibility === true);
                },
              dentalItems() {
                  const rows = [];
                  Object.values(this.skeletalElements).forEach(item =>
                      rows.push({
                        se_id: item.se_id,
                        key: this.getKey(item),
                        bone: this.getBone(item.sb_id).name,
                        side: item.side,
                        bone_group: item.bone_group,
                        individual_number: item.individual_number,
                        dna_sampled: item.dna_sampled,
                        mito_sequence_number: item.mito_sequence_number ? item.mito_sequence_number: "",
                        dc_id: item.dc_id ? item.dc_id : "",
                        dental_codes:item.dental_codes,
                        dentalCodeData: this.dentalCodeData,
                        measured: item.measured,
                        isotope_sampled: item.isotope_sampled ? item.isotope_sampled : "",
                        clavicle_triage: item.clavicle_triage,
                        request_date_start: item.request_date_start,
                        request_date_end: item.request_date_end,
                        receive_date_start: item.receive_date_start,
                        receive_date_end: item.receive_date_end
                      })
                );
                return rows;
              },
              ...mapState({
                  rowsPerPageItems: state => state.search.rowsPerPageItems,
                }),
              ...mapGetters({
                  items_accessions: 'getProjectAccessions',
                  items_provenance1: 'getProjectProvenance1',
                  items_provenance2: 'getProjectProvenance2',
                  items_bones: 'getBones',
                  project_id: 'theProjectId',
                  getBone: 'getBone',
                  bearerToken: 'bearerToken',
                }),
              tooth_items() {
                  this.tooth_list = this.$store.state.bones.filter(el => el.type === "Tooth");
                  return this.tooth_list;
                },

        },

    }
</script>
<style scoped>
</style>