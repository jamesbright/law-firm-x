<template>
  <div>
    <div class="grid md:grid-cols-2 sm:grid-cols-2 gap-4">
      <SideBar />
      <div class="border-2 hover:border-blue-400 rounded-xl p-6">
        <h4 class="text-center">Add client</h4>
        <div class="">
          <form @submit.prevent="addClient">
          <div class="form-group">
          <i>required fields are marked with <span class="required"></span></i>
          </div>
            <div class="form-group  required">
              <label>First Name</label>
              <input required
                type="text"
                class="form-control"
                v-model="client.first_name"
              />
            </div>
            <div class="form-group required">
              <label>Last Name</label>
              <input required type="text" class="form-control" v-model="client.last_name" />
            </div>
            <div class="form-group required">
              <label>Email</label>
              <input required type="text" class="form-control" v-model="client.email" />
            </div>
            <div class="form-group required">
              <label>Primary Counsel</label>
              <input required type="text" class="form-control" v-model="client.primary_counsel" />
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
             Add Client</button>
            </div>
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
    };
  },
  methods: {
    addClient() {
      let formData = new FormData();
      formData.append("first_name", this.client.first_name);
      formData.append("last_name", this.client.last_name);
      formData.append("email", this.client.email);
      formData.append("primary_counsel", this.client.primary_counsel);
      formData.append("case_details", this.client.case_details);
      formData.append("dob", this.client.dob);
      formData.append("profile_image", this.client.profile_image);
      this.$axios
        .post("http://localhost:8000/api/add", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          console.log(response);
          this.$router.push({ name: "clients" });
        })
        .catch(function (error) {
          console.error(error);
        });
    },
    handleFile() {
      this.client.profile_image = this.$refs.file.files[0];
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
