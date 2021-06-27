<template>
  <div class="grid md:grid-cols-2 sm:grid-cols-2 gap-2">
 
    <SideBar />
    <div>


      <section
        class="py-8 px-8 mb-2 max-w-sm mx-auto space-y-2 sm:py-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6"
      >
   
        <header class="flex items-center justify-between">
          <router-link to="/clients/add">
            <button
              class="btn btn-primary hover:bg-light-blue-200 hover:text-light-blue-800 group flex items-center rounded-md bg-light-blue-100 text-light-blue-600 text-sm font-medium px-4 py-2"
            >
              <svg
                class="group-hover:text-light-blue-600 text-light-blue-500 mr-2"
                width="12"
                height="20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M6 5a1 1 0 011 1v3h3a1 1 0 110 2H7v3a1 1 0 11-2 0v-3H2a1 1 0 110-2h3V6a1 1 0 011-1z"
                />
              </svg>
              New
            </button>
          </router-link>
        </header>
   <form class="relative">
          <svg
            width="20"
            height="20"
            fill="currentColor"
            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
            />
          </svg>
          <input
            class="focus:border-light-blue-500 focus:ring-1 focus:ring-light-blue-500 focus:outline-none w-full text-sm text-black placeholder-gray-500 border border-gray-200 rounded-md py-2 pl-10"
            type="text"
            aria-label="Filter By Last Name"
            placeholder="Filter By Last Name"
             v-model="keyword"
          />
        </form>
      </section>
    
      <h4 class="text-center mb-4">All Clients</h4>
      <!--start skeleton-->
             <div v-show="loading" class="border border-blue-300 shadow rounded-md p-4 max-w-sm w-full mx-auto">
  <div class="animate-pulse flex space-x-4">
    <div class="rounded-full bg-blue-400 h-12 w-12"></div>
    <div class="flex-1 space-y-4 py-1">
      <div class="h-4 bg-blue-400 rounded w-3/4"></div>
      <div class="space-y-2">
        <div class="h-4 bg-blue-400 rounded"></div>
        <div class="h-4 bg-blue-400 rounded w-5/6"></div>
      </div>
    </div>
  </div>
</div>
<!-- end skeleton-->
      <div
        v-if="clients"
        v-for="(client, index) in clients"
        :key="index"
        class="py-8 px-8 mb-2 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-2 sm:py-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6"
      >
        <img
          alt=""
          class="w-12 h-12 ring-2 rounded-full bg-light-blue-100"
          loading="lazy"
          :src="getImage(client.profile_image)"
        />
        <div class="text-center space-y-2 sm:text-left">
          <div class="space-y-0.5">
            <p class="text-lg text-black font-semibold">
              {{ capitalize(client.first_name) }} {{ capitalize(client.last_name) }}
            </p>
            <p class="text-gray-500 font-medium">counsel: {{ capitalize(client.primary_counsel) }}</p>
          </div>
          <router-link :to="{ name: 'dashboard', params: { id: client.id } }">
            <button
              class="px-4 py-1 text-sm text-purple-600 font-semibold rounded-full border border-purple-200 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2"
            >
              Full Details
            </button>
          </router-link>
        </div>
      </div>

      <div v-else>
        <h4 class="text-center mt-4">No Clients Found</h4>
      </div>
    </div>
  </div>
</template>

<script>
import SideBar from "./SideBar";
import { debounce } from "lodash";
export default {
  name: "Clients",
  components: {
    SideBar,
  },
  data() {
    return {
      clients: [],
      keyword:null,
      loading:true
    };
  },
  created() {
      this.getClients();
      this.debounceSearch = debounce(this.search, 1000);
  },


  watch: {
    keyword() {
      if (!this.keyword)return;
      this.debounceSearch();
    },
  },

  methods: {
      capitalize(value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
  },

    search(){
      if (this.keyword){
      this.$axios
      .get(`/api/clients/search/${this.keyword}`)
      .then((response) => {
        this.clients = response.data;
        this.loading = false;
      })
      .catch(function (error) {
        console.error(error);
      });
      }else{
        this.getClients();
      }
    },
    getClients(){
this.$axios
      .get("/api/clients")
      .then((response) => {
        this.clients = response.data;
        this.loading = false;

      })
      .catch(function (error) {
        console.error(error);
      });
    },
    getImage(image){
      if(image)
      return `../storage/profile_images/${image}`;
      else
      return "../storage/profile_images/blank_pic.png";
    }
    

  },

};
</script>
