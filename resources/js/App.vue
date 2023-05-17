<template>
<div class="flex w-full justify-center gap-0 lg:gap-4">
    <sidebar-comp @logoutModal="showingLogoutModal"></sidebar-comp>

    <main-comp @logoutModal="showingLogoutModal"></main-comp>

    <aside class="md:flex top-0 w-96 flex-col gap-4 px-4 py-3 pt-1 hidden">
        <search-comp v-if="shouldShowInputSearch"></search-comp>
    </aside>
</div>

<footer-comp v-if="!user"></footer-comp>

<modal-master :show="showLogoutModal">
    <template #header>
        <h2 class="text-lg">Logout</h2>
    </template>
    <template #body>
        <p>
            You can always log back in at any time :)
        </p>
        <br>
    </template>
    <template #footer>
        <button class="justify-end p-2 pt-0 pb-0 rounded-md bg-yellow-400 hover:bg-yellow-600" style="font-weight: bold;" @click="showLogoutModal = false">Cancel</button>
        <button class="justify-end p-2 pt-0 pb-0 rounded-md bg-red-500 ml-1 hover:bg-red-800" style="font-weight: bold;" @click="logout()">Logout</button>
    </template>
</modal-master>


</template>

<script>
import SearchComp from './components/SearchComp.vue'
import SidebarComp from './components/SidebarComp.vue'
import MainComp from './components/MainComp.vue'
import FooterComp from './components/FooterComp.vue'
import { mapActions, mapGetters } from 'vuex'
import axios from 'axios'
import ModalMaster from './components/ModalMaster.vue';


export default {
    components: {
        SearchComp,
        SidebarComp,
        MainComp,
        FooterComp,
        ModalMaster,
    },
    data() {
        return {
            showLogoutModal: false,
        }
    },
    computed: {
        ...mapGetters(['user']),
        shouldShowInputSearch() {
            const excludedRoutes = ['SearchPage', 'LoginPage', 'RegisterPage'];
            return !excludedRoutes.includes(this.$route.name);
        }
    },
    created() {
        this.getUser()
    },
    methods: {
        showingLogoutModal() {
            this.showLogoutModal = true
        },
        ...mapActions(["getuser"]),
        async getUser() {
            try {
                const response = await axios.get('/api/user');
                this.getuser(response.data.data.user)
            } catch (error) {
                const { response, request } = error;
                if (response) {
                    const { message } = response.data;
                    console.log(message);
                    if (response.status === 401) {
                        this.$store.dispatch('getuser', null)
                        localStorage.removeItem('token')
                        // this.$router.push({ name: 'SearchPage' })
                    }
                } else if (request) {
                    console.log(request);
                } else {
                    console.log('Error', error.message);
                }
            }
        },
        async logout() {
            try{
                const response = await axios.delete('/api/authentications')
                this.$store.dispatch('getuser', null)
                localStorage.removeItem('token')
                this.$router.push({ name: 'SearchPage' })
                this.showLogoutModal = false
                console.log(response)
            } catch(error) {
                const { response, request } = error;
                if (response) {
                    const { message } = response.data;
                    console.log(message);
                } else if (request) {
                    console.log(request);
                } else {
                    console.log('Error', error.message);
                }
            }

        },
    }
}
</script>

