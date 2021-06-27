<template>
  <div>
    <div class="grid md:grid-cols-2 sm:grid-cols-2 gap-4">
      <SideBar />
      <div class="border-2 hover:border-blue-400 rounded-xl p-6">
        <div v-on:click="goBack()">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M10 19l-7-7m0 0l7-7m-7 7h18"
            />
          </svg>
        </div>
        <h4 class="text-center">Add client</h4>
        <div class="">
          <form @submit.prevent="addClient">
            <div class="form-group">
              <i>required fields are marked with <span class="required"></span></i>
            </div>
            <div class="form-group required">
              <label>First Name</label>
              <input
                required
                type="text"
                class="form-control"
                v-model="client.first_name"
              />
            </div>
            <div class="form-group required">
              <label>Last Name</label>
              <input
                required
                type="text"
                class="form-control"
                v-model="client.last_name"
              />
            </div>
            <div class="form-group required">
              <label>Email</label>
              <input required type="text" class="form-control" v-model="client.email" />
            </div>
            <div class="form-group required">
              <label>Primary Counsel</label>
              <input
                required
                type="text"
                class="form-control"
                v-model="client.primary_counsel"
              />
            </div>
            <div class="form-group required">
              <label>Case Details</label>
              <textarea rows="5" class="form-control" v-model="client.case_details">
              </textarea>
            </div>
            <div class="form-group required">
              <label>DOB</label>
              <input required type="date" class="form-control" v-model="client.dob" />
            </div>
            <div class="form-group">
              <label>Profile Image</label>
              <input
                type="file"
                ref="file"
                class="form-control"
                v-on:change="handleFile"
              />
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-primary">
                {{ btnText }}
              </button>
            </div>
            <div class="text-red-500">{{ error }}</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SideBar from "./SideBar";
export default {
  name: "AddClient",
  components: {
    SideBar,
  },
  data() {
    return {
      client: {},
      btnText: "Add Client",
      error:null,
    };
  },
  methods: {
    addClient() {
      // clear previous errors if any
      this.error = null;
      //create a form data and append all fields
      let formData = new FormData();
      formData.append("first_name", this.client.first_name);
      formData.append("last_name", this.client.last_name);
      formData.append("email", this.client.email);
      formData.append("primary_counsel", this.client.primary_counsel);
      formData.append("case_details", this.client.case_details);
      formData.append("dob", this.client.dob);
        //add the profile photo  to formdata if available
      if (this.client.profile_image)
        formData.append("profile_image", this.client.profile_image);

      this.btnText = "Processing..";
      //make a post request tp server 
      this.$axios
        .post("http://localhost:8000/api/clients/add", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          //if an error occured ,indicate it and terminate execution
          if(response.data.success == false){
          this.error = response.data.message;
          this.btnText = "Add Client";
          return;
          }
          //success 
          this.btnText = "Done";
          this.$router.push({ name: "clients" });
        })
        .catch(function (error) {
          console.error(error);
        });
    },
    handleFile() {
      this.client.profile_image = this.$refs.file.files[0];
    },
    goBack() {
      //go back to previous route
      this.$router.go(-1);
    },
  },
};
</script>

<style scoped>
.required:before {
  content: " *";
  color: red;
}
</style>
