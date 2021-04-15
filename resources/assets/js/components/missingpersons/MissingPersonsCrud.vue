<template>
  <v-dialog v-model="dialog" max-width="50%">
    <v-card>
      <v-card-title class="m-0 p-0">
        <v-toolbar dense>
          <v-btn icon><v-icon color="gray" class="p-2">mdi-skull</v-icon></v-btn>
          <v-spacer></v-spacer>
          <v-toolbar-title>{{title}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-progress-circular v-if="loading" :indeterminate="loading" color="primary"></v-progress-circular>
          <v-btn icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
        </v-toolbar>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="6"><v-text-field v-model="item.priority" label="Priority" :disabled="disabled"/></v-col>
          <v-col cols="6"><v-text-field v-model="item.enclosed_documents" label="Enclosed Documents" :disabled="disabled"/></v-col>
        </v-row>
        <v-row>
          <v-col cols="6"><v-text-field v-model="item.company" label="Company" :disabled="disabled"/></v-col>
          <v-col cols="6"><v-text-field v-model="item.funded_by" label="Funded By" :disabled="disabled"/></v-col>
        </v-row>
        <v-row>
          <v-col cols="12"><v-text-field v-model="item.notes" label="Notes" :disabled="disabled"/></v-col>
        </v-row>
        <v-row>
          <v-col cols="6"><date v-model="item.request_date" label="Request Date" :disabled="disabled"/></v-col>
          <v-col cols="6"><date v-model="item.receive_date" label="Receive Date" :disabled="disabled"/></v-col>
        </v-row>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions v-if="action.edit || action.create">
        <v-row align="center" justify="center" class="m-0 p-0">
          <v-btn color="primary" text @click="save"><v-icon class="p-2">mdi-content-save</v-icon>Save</v-btn>
          <v-btn color="primary" text @click="close"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
        </v-row>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import {mapGetters, mapState} from "vuex";
import {eventBus} from "../../eventBus";
import axios from "axios";

export default {
  name: "missingperson-crud",
  props: {
    default_crud_action: "Edit",
    default_title: "Modal title",
    missingpersons: {type: Object},
    type: String,
  },
  data() {
    return {
      loading: false,
      crud_action: "Edit",
      dialog: false,
      title: "Modal title",
      items: [],
      index: -1,
      item: { name: '', description: '', color: '#00FF00', category: '', type: 'Specimen', icon:'', project_id: 0, org: false, },
      defaultItem: { name: '', description: '', color: '#00FF00', category: '', type: 'Specimen', icon:'', project_id: 0, org: false, },
      menu: false,
      tag_type_items: ['Specimen', 'Dna', 'Isotope', 'Media'],
      colorPickerDialog: false,
      colorPicker: {
        color: '#00FF00',
        hideCanvas: false,
        hideInputs: false,
        hideModeSwitch: false,
        mode: 'rgba',
        modes: ['rgba', 'hsla', 'hexa'],
        showSwatches: true,
      },
    };
  },
  created() {
    this.defaultItem.project_id = this.item.project_id = this.theProject.id;
    eventBus.$on('missing person crud dialog', payload => {
      this.dialog = !this.dialog;
      this.title = (payload.title) ? payload.title : "No Modal Title";
      this.crud_action = (payload.action) ? payload.action : "Edit";
      this.item = (payload.item) ? payload.item : this.defaultItem;
      this.index = (payload.index) ? payload.index : this.index;
      this.colorPicker.color = this.item.color;
      console.log('tagCrud payload event: ' + JSON.stringify(payload));
      this.item.type = this.type;
    });
  },
  mounted() {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
  },
  watch: {
    dialog (val) {
      val || this.close()
    },
  },
  methods: {
    close() {
      console.log("tag crud close");
      this.title = "No Modal Title";
      this.crud_action = "Edit";
      this.item = this.defaultItem;
      this.index = -1;
      this.dialog = false;
    },
    save () {
      this.loading = true;
      let url = (this.action.create) ? '/api/geneologies' : '/api/geneologies/' + this.item.id;
      let method = (this.action.create) ? "POST" : "PUT";
      this.item.color = this.tag_color;
      console.log("Tag Item: " + JSON.stringify(this.item));
      axios
          .request({
            url: url,
            method: method,
            headers:{
              'Content-Type' : 'application/json',
              'Authorization' : this.$store.getters.bearerToken,
            },
            data:{
              id: this.item.id,
              org_id: this.theOrg.id,
              mp_id: this.missingpersons,
              project_id: (this.item.org) ? null : this.item.project_id,
              priority: this.item.priority,
              notes: this.item.notes,
              enclosed_documents: this.item.enclosed_documents,
              company: this.item.company,
              funded_by: this.item.funded_by,
              request_date: this.item.request_date,
              receive_date: this.item.receive_date,
            },
          })
          .then(response=>{
            this.loading = false;
            let payload = { 'text': 'Update successful', 'color': 'success', };
            eventBus.$emit('show-snackbar', payload);
            eventBus.$emit('refresh-list', { 'list': 'tags', } );
            eventBus.$emit('updateTagList');
            this.close();
          }).catch(error => {
        console.log(error.response);
        this.loading = false;
        let payload = { 'text': 'Update failed', 'color': 'error', };
        eventBus.$emit('show-snackbar', payload);
        this.close();
      })
    },
  },
  computed: {
    ...mapState({
      //
    }),
    ...mapGetters({
      theOrg: 'theOrg',
      theProject: 'theProject',
      projectlist: 'theUserProjects',
      projectsData: 'getProjectsIdNameArray',
      isOrgAdmin: 'isOrgAdmin',
    }),
    action() {
      const action = this.crud_action;
      return { list: action === "List", create: action === "Create", view: action === "View", edit: action === "Update" || action === "Edit" , delete: action === "Delete",};
    },
    disabled() {
      return this.action.delete;
    },
    tag_color: function () {
      return this.colorPicker.color;
    },
  },
}
</script>

<style scoped>
.v-text-field__slot { top: -5px; }
</style>