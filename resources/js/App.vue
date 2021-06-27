<template>
    <div class="rounded-xl shadow-md border-2 border-fuchsia-600 p-10 bg-gradient-to-r from-green-700 to-blue-800 ">
     <div class="border-2 ring-2 hover:border-gray-500 bg-white rounded-xl shadow-md  py-8 px-8">
     <h4 class="text-center mb-8 animate-bounce"> LAW FIRM X</h4>
  
        <router-view/>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            prevRoute:null
        }
    },
 
    methods: {
        
    },



}
</script>
