<template>
  <div class="grid md:grid-cols-2 sm:grid-cols-2 gap-2">
    <SideBar />
    <div>
      <div
        v-if="client"
        class="py-8 px-8 mb-2 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-2 sm:py-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6"
      >
        <img
          alt=""
          class="w-12 h-12 ring-2 rounded-full bg-light-blue-100"
          loading="lazy"
          :src="client.profile_image"
        />
        <div class="text-center space-y-2 sm:text-left">
          <div class="space-y-0.5">
            <p class="text-lg text-black font-semibold">
              {{ client.first_name }} {{ client.last_name }}
            </p>
            <p class="text-gray-500 font-medium">Counsel: {{ client.primary_counsel }}</p>
            <p class="text-gray-500 font-medium">Case: {{ client.case_details }}</p>
            <p
              class="text-gray-500 font-medium rounded-full bg-yellow-300 px-2 opacity-80"
            >
              DOB: {{ client.dob }}
            </p>
            <p class="text-gray-500 font-medium rounded-full bg-yellow-300 px-2 opacity-80">
              Joined: {{ formatDate(client.created_at) }}
            </p>
          </div>
        </div>
      </div>

      <div v-else>
        <h4 class="text-center mt-4">No Client Found</h4>
      </div>
    </div>
  </div>
</template>

<script>
import SideBar from "./SideBar";

export default {
  name: "Dashboard",
  props: ["id"],
  components: {
    SideBar,
  },
  data() {
    return {
      client: [],
    };
  },
  mounted() {
    this.$axios
      .get(`http://localhost:8000/api/clients/get/${this.id}`)
      .then((response) => {
        this.client = response.data;
      })
      .catch(function (error) {
        console.error(error);
      });
  },
  methods: {
    formatDate(value) {
      if (value) {
        return moment(String(value)).format("MM-DD-YYYY");
      }
    },
  },
};
</script>
