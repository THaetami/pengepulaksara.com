<template>
<main class="hover-animation flex min-h-screen w-full max-w-xl flex-col border-x-0 border-light-border pb-[18rem] dark:border-dark-border xs:border-x">
    <header-comp @showSidebar="showingSidebar"></header-comp>

    <router-view></router-view>
    <sastra-notif></sastra-notif>
</main>
<sidebar-modal :show="showSideBarModal" @close="showSideBarModal = false" @showLogoutModal="$emit('logoutModal')"></sidebar-modal>

</template>
<script>
import HeaderComp from './HeaderComp.vue'
import SastraNotif from './SastraNotif.vue'
import SidebarModal from './SidebarModal.vue'

export default {
    emits: ['logoutModal'],
    components: {
        HeaderComp,
        SastraNotif,
        SidebarModal
    },
    data() {
        return {
        showSideBarModal: false
        }
    },
    methods: {
        showingSidebar() {
            this.showSideBarModal = true
        }
    }
}
</script>
