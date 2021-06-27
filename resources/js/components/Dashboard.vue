<template>
  <div class="grid md:grid-cols-2 sm:grid-cols-2 gap-2">
    <SideBar />
    <div>
      <div
        v-if="client"
        class="py-8 px-8 mb-2 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-2 sm:py-4 sm:items-center sm:space-y-0 sm:space-x-6"
      >
        <img
          alt=""
          class="w-40 h-40 ml-5 ring-2 rounded-full bg-light-blue-100"
          loading="lazy"
          :src="getImage(client.profile_image)"
        />
       
       
        <div class="text-c enter space-y-2 sm:text-left">
          <div class="space-y-0.5">
            <p class="text-lg text-black font-semibold">
              {{ capitalize(client.first_name) }} {{ capitalize(client.last_name) }}
            </p>
            <p class="text-gray-500 font-medium">Counsel: {{ capitalize(client.primary_counsel) }}</p>
               <p
              class="w-auto text-gray-500 font-medium rounded-full bg-yellow-300 px-2 opacity-80"
            >
              Email: {{ client.email }}
            </p>
              <p
              class="text-gray-500 font-medium rounded-full bg-yellow-300 px-2 opacity-80"
            >
              DOB: {{ client.dob }}
            </p>
            <p class=" text-gray-500 wrap font-medium rounded-full bg-yellow-300 px-2 opacity-80">
              Joined: {{ formatDate(client.created_at) }}
            </p>
          </div>
           <p class="text-gray-500 justify font-medium">Case: {{ client.case_details }}</p>
        
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
         capitalize(value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
  },
    formatDate(value) {
      if (value) {
        return moment(String(value)).format("MM-DD-YYYY");
      }
    },
      getImage(image){
    if(image)
      return `../../storage/profile_images/${image}`;
        else
      return "../../storage/profile_images/blank_pic.png";

    }
  },
};
</script>
