<template>
  <div class="m-2" id="Missing PersonInformation">
    <contentheader :title="this.heading" :help_menu="true" model_name="missing_person"></contentheader>
    <snackbar v-if="snackbar === true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>
    <br>
    <v-card>
      <v-progress-linear v-if="loading" :indeterminate="loading"/>
      <v-row >
        <v-col cols="12" md="3" sm="12" >
        <v-text-field
            v-model="form.case_number"
            label="Case Number"
        ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
        <v-text-field
              v-model="form.case_status"
              label="Case Status"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="3" sm="12" >
        <v-text-field
              v-model="form.serial_number"
              label="Serial Number"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col align="center"
               justify="center" dusk="save-btn">
          <v-btn title="Save" color="primary" class="mr-2" @click="save()"><v-icon class="mr-2">mdi-content-save</v-icon>Save</v-btn>
        </v-col>
      </v-row>
    </v-card>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import axios from 'axios';

export default {
  name: "MissingPersonsCreate",
  props: {
    heading: { type: String, default: " Create Missing Persons" },
    // crud_action: {type: String, default: "Create"},
  },
  data() {
    return {
      show_contentheader: this.contentheader,
      trail: {
        'create': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Missing Persons ', disabled: false, href: "/missingpersons"},
          {text: 'New', disabled: true, href: "/"},],
        'default': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Missing Persons ', disabled: false, href:  "/missingpersons"},
          {text: 'New', disabled: true, href: "/missingpersons/create"},],
      },
      form:{},
      rules:{
        required: value => !!value || 'Required.'
      },
      snackbar: false,
      snackbar_text:'',
      snackbar_color:'',
    }
  },
  created(){
  },
  mounted() {
  },
  methods: {
    save() {
      this.loading = true;
      axios.request({
        url: '/api/missingpersons',
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,
        },
        params:{
          org_id: this.theOrg.id,
          project_id: this.project_id,
          case_manager_id: this.theUser.id,
          lab_project_manager_id: this.theUser.id,
          case_number: this.form.case_number,
          conflict: this.form.conflict,
          serial_number: this.form.serial_number,
          case_status: this.form.case_status,
        },
      }).then(response => {
        let id = response.data.data.id;
        window.location.assign('/missingpersons/'+ id)
      }).catch(error => {
        this.snackbar=true;
        this.snackbar_text = 'Failed to Create Missing Persons. Please recheck your inputs.';
        this.snackbar_color = 'info';
      })
    }
  },
  computed:{
    ...mapGetters({
      getLabs: 'getLabs',
      project_id: 'theProjectId',
      theOrg: 'theOrg',
      theUser: 'theUser'
    }),
    labOptions () {
      let type = 'Isotope';
      return this.getLabs(type);
    },
    // action() {
    //   const act = this.crud_action;
    //   return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
    // },
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

<style>

</style>