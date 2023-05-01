<template>
    <header class="flex w-0 shrink-0 transition-opacity duration-200 xs:w-20 md:w-24 lg:max-w-none xl:-mr-4 xl:w-full xl:max-w-xs xl:justify-end">
        <div :class="{ 'bottom-0 backdrop-blur-md ': user }" class="fixed z-10 flex w-full flex-col justify-between border-t border-light-border bg-main-background py-0 dark:border-dark-border xs:top-0 xs:h-full xs:w-auto xs:border-0 bg-transparent xs:px-2 xs:py-3 xs:pt-2 md:px-4 xl:w-72">
            <div class="flex flex-col justify-center gap-2 xs:items-center xl:items-stretch">
                <div class="hidden lg:flex items-center">
                    <router-link :to="{name: 'HomePage'}" class="custom-button main-tab text-accent-blue transition hover:bg-light-primary/10 focus-visible:bg-accent-blue/10 focus-visible:!ring-accent-blue/80 dark:text-twitter-icon dark:hover:bg-dark-primary/10" aria-label="to home page">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" class="w-[3rem] h-[3rem] cls-ahad cls-isnani cls-salasatun cls-arbangatun cls-khomsatun" viewBox="0 0 1500 1500">
                            <logo-comp></logo-comp>
                        </svg>
                    </router-link>
                    <h1 class="text-blue-800 hidden xl:block text-lg select-none font-bold">Pengepulaksara</h1>
                </div>

                <div class="flex items-center justify-around xs:flex-col xs:justify-center xl:block">
                    <router-link v-if="user" :to="{name: 'HomePage'}" @click="this.$store.dispatch('getaddsastranotif', null)" class="group py-1 outline-none flex" aria-label="to home page">
                        <div class="custom-button flex items-center justify-center gap-4 self-start p-2 text-xl transition duration-200 group-hover:bg-light-primary/10 group-focus-visible:ring-2 group-focus-visible:ring-[#878a8c] dark:group-hover:bg-dark-primary/10 dark:group-focus-visible:ring-white xs:p-3 xl:pr-5">
                            <div class="flex">
                                <svg v-if="addsastranotif" xmlns="http://www.w3.org/2000/svg" class="fixed h-3 w-3 ml-[1.5rem]" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
                                    class="h-7 w-7 mt-1">
                                    <path d="M12 1.696L.622 8.807l1.06 1.696L3 9.679V19.5C3 20.881 4.119 22 5.5 22h13c1.381 0 2.5-1.119 2.5-2.5V9.679l1.318.824 1.06-1.696L12 1.696zM12 16.5c-1.933 0-3.5-1.567-3.5-3.5s1.567-3.5 3.5-3.5 3.5 1.567 3.5 3.5-1.567 3.5-3.5 3.5z"></path>
                                </svg>
                            </div>
                            <p class="hidden xl:block">Home</p>
                        </div>
                    </router-link>
                    <router-link :to="{name: 'SearchPage'}" class="group py-1 outline-none flex" aria-label="to search page">
                        <div class="custom-button flex items-center justify-center gap-4 self-start p-2 text-xl transition duration-200 group-hover:bg-light-primary/10 group-focus-visible:ring-2 group-focus-visible:ring-[#878a8c] dark:group-hover:bg-dark-primary/10 dark:group-focus-visible:ring-white xs:p-3 xl:pr-5">
                            <svg v-if="!user" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-7 w-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5"></path>
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-7 w-7">
                                <path d="M10.25 3.75c-3.59 0-6.5 2.91-6.5 6.5s2.91 6.5 6.5 6.5c1.795 0 3.419-.726 4.596-1.904 1.178-1.177 1.904-2.801 1.904-4.596 0-3.59-2.91-6.5-6.5-6.5zm-8.5 6.5c0-4.694 3.806-8.5 8.5-8.5s8.5 3.806 8.5 8.5c0 1.986-.682 3.815-1.824 5.262l4.781 4.781-1.414 1.414-4.781-4.781c-1.447 1.142-3.276 1.824-5.262 1.824-4.694 0-8.5-3.806-8.5-8.5z"></path>
                            </svg>
                            <p class="hidden xl:block">Explore</p>
                        </div>
                    </router-link>
                    <span v-if="user" class="py-1 outline-none flex cursor-not-allowed" href="/notifications">
                        <div class="custom-button flex items-center justify-center gap-4 self-start p-2 text-xl transition duration-200 group-hover:bg-light-primary/10 group-focus-visible:ring-2 group-focus-visible:ring-[#878a8c] dark:group-hover:bg-dark-primary/10 dark:group-focus-visible:ring-white xs:p-3 xl:pr-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"  stroke-width="1.5" aria-hidden="true" class="h-7 w-7"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                            </svg>
                            <p class="hidden xl:block">Notifications</p>
                        </div>
                    </span>
                    <router-link :to="{ name: 'SastraUser', params: { username: user.username }}" v-if="user" class="group py-1 outline-none hidden xs:flex group" aria-label="to profile page">
                        <div class="custom-button flex items-center justify-center gap-4 self-start p-2 text-xl transitionduration-200 group-hover:bg-light-primary/10 group-focus-visible:ring-2 group-focus-visible:ring-[#878a8c] dark:group-hover:bg-dark-primary/10 dark:group-focus-visible:ring-white xs:p-3 xl:pr-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-7 w-7"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                            </svg>
                            <p class="hidden xl:block">Profile</p>
                        </div>
                    </router-link>
                </div>

                <button v-if="user" @click="showPostSastraModal = true" aria-label="add sastra" class="custom-button main-tab accent-tab absolute right-4 -translate-y-[72px] bg-main-accent text-lg font-bold text-white outline-none transition hover:brightness-90 active:brightness-75 xs:static xs:translate-y-0 bg-blue-700 hover:text-red-700 rounded-full p-2 xl:w-11/12" type="button">
                    <svg class="fill-current block h-6 w-6 xl:hidden" viewBox="0 0 24 24" aria-hidden="true">
                        <g>
                            <path
                                d="M8.8 7.2H5.6V3.9c0-.4-.3-.8-.8-.8s-.7.4-.7.8v3.3H.8c-.4 0-.8.3-.8.8s.3.8.8.8h3.3v3.3c0 .4.3.8.8.8s.8-.3.8-.8V8.7H9c.4 0 .8-.3.8-.8s-.5-.7-1-.7zm15-4.9v-.1h-.1c-.1 0-9.2 1.2-14.4 11.7-3.8 7.6-3.6 9.9-3.3 9.9.3.1 3.4-6.5 6.7-9.2 5.2-1.1 6.6-3.6 6.6-3.6s-1.5.2-2.1.2c-.8 0-1.4-.2-1.7-.3 1.3-1.2 2.4-1.5 3.5-1.7.9-.2 1.8-.4 3-1.2 2.2-1.6 1.9-5.5 1.8-5.7z">
                            </path>
                        </g>
                    </svg>
                    <p @click="showPostSastraModal = true" class="hidden xl:block">Tweet</p>
                </button>
            </div>

            <div class="hidden sm:block relative">
                <div class="flex justify-center">
                    <div v-if="user" class="dropdown dropdown-top">
                        <button tabindex="0" class="custom-button main-tab dark-bg-tab flex w-full items-center justify-center xl:justify-between hover:bg-light-primary/10 active:bg-light-primary/20 dark:hover:bg-dark-primary/10 dark:active:bg-dark-primary/20"  type="button">
                            <div class="flex gap-0 xl:gap-3 truncate">
                                <div class="blur-picture xs:block hidden self-start pointer-events-none truncate text-start leading-5 md:block">
                                    <figure style="width: 40px;">
                                        <span class="box-sizing: border-box; display: block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative;">
                                            <span class="box-sizing: border-box; display: block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative;"></span>
                                            <img v-if="user.image" :src="'/storage/upload/' + user.image" class="rounded-full w-10 h-10" :alt="user.username">
                                            <no-image v-else></no-image>
                                        </span>
                                    </figure>
                                </div>
                                <div class="hidden truncate text-start leading-5 xl:block hover:text-red-600">
                                    <div class="flex items-center gap-1 truncate font-bold pointer-events-none start">
                                        <p class="truncate">{{ user.name }}</p>
                                    </div>
                                    <div class="truncate text-light-secondary dark:text-dark-secondary pointer-events-none">
                                        <p>@{{ user.username }}</p>
                                    </div>
                                </div>
                                <svg data-v-63081264="" xmln="http://www.w3.org/2000/svg hidden xl:block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="hidden h-6 w-6 xl:block hover:border-red-600"><path data-v-63081264="" stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path></svg>
                            </div>
                        </button>
                        <div tabindex="0" class="dropdown-content men mb-2 shadow bg-base-100 rounded-md hidden xs:block w-[15rem]">
                            <router-link v-if="user" :to="{name: 'ProfilePage'}" class="py-1 cursor-pointer hidden xs:block">
                                <span class="py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                </svg>
                                <span class="ml-2">Update Profile</span>
                                </span>
                            </router-link>
                            <router-link :to="{ name: 'SastraUser', params: { username: user.username }}"  class="py-1 cursor-pointer hidden xs:block md:hidden">
                                <span class="py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path d="M363.942,139.261c9.213-4.347,18.573-8.188,28.069-11.869c9.787-3.791,19.879-6.787,29.945-9.725    c10.167-2.968,20.49-5.563,30.868-7.686c10.374-2.121,20.739-4.007,31.191-5.711c10.274-1.674,20.631-2.771,30.962-4.026    c10.153-0.812,20.322-1.88,30.499-2.277c8.088-0.318,16.174-0.672,24.263-1.008c6.524-0.269,12.254-4.638,13.857-11.051    c1.767-7.063-2.143-14.538-8.93-17.149c-5.546-2.131-12.205-0.015-17.808,0.903c-9.021,1.479-18.024,2.944-26.986,4.753    c0.517-0.106,0.707-0.145-0.158,0.03c-3.246,0.662-1.855,0.379-0.594,0.123c-9.961,2.031-19.864,4.132-29.737,6.564    c-10.292,2.535-20.455,5.367-30.634,8.323c-20.214,5.872-39.98,13.435-59.255,21.865c-13.069,5.716-25.597,12.5-37.993,19.522    c-5.871,3.327-11.473,7.158-17.05,10.946c-4.175,2.836-8.309,5.911-12.124,9.251c0.313-0.121,0.614-0.225,0.927-0.348    C349.777,146.319,356.882,142.595,363.942,139.261z" />
                                                <path d="M342.268,134.661c8.258-6.207,16.704-12.039,25.424-17.58c15.14-9.62,31.078-17.653,47.309-25.244    c19.21-8.983,39.411-15.622,59.666-21.769c17.444-5.295,35.398-8.66,53.261-12.169c6.942-1.362,12.217-7.218,12.199-14.424    c-0.02-7.775-6.403-14.325-14.17-14.546c-2.53-0.073-4.819,0.675-7.176,1.452c-3.923,1.286-7.847,2.575-11.771,3.863    c-9.64,3.167-19.092,6.694-28.566,10.326c-19.902,7.624-39.209,17.058-57.766,27.516c-15.304,8.624-30.245,18.053-44.26,28.659    c-11.122,8.417-22.083,17.121-32.131,26.816c-4.821,4.653-9.629,9.322-14.118,14.3c-3.645,4.044-7.429,8.133-10.404,12.708    c0.572-0.68,1.148-1.342,1.777-1.971C327.716,145.972,335.047,140.089,342.268,134.661z" />
                                                <path d="M249.62,136.483c-8.742-5.508-17.697-10.515-26.806-15.381c-9.248-4.936-18.884-9.189-28.528-13.278    c-9.632-4.084-19.395-8.005-29.323-11.314c-10.138-3.379-20.263-6.628-30.527-9.607c-10.024-2.908-20.147-5.355-30.281-7.852    c-18.838-4.641-38.087-7.597-57.217-10.728c-3.384-0.554-6.632-0.78-9.901,0.559c-4.044,1.657-7.206,5.135-8.454,9.326    c-2.673,8.976,4.016,18.354,13.371,18.741c7.193,0.299,14.386,0.594,21.578,0.897c10.111,0.421,20.185,1.336,30.273,2.144    c10.394,0.832,20.926,2.119,31.215,3.798c10.359,1.69,20.666,3.434,30.95,5.538c20.726,4.242,41.269,9.782,61.166,16.998    c9.542,3.462,18.849,7.418,28.087,11.613c8.042,3.768,16.025,7.864,23.469,12.736c0.316,0.126,0.622,0.231,0.937,0.354    C263.458,145.607,256.535,140.836,249.62,136.483z" />
                                                <path d="M83.641,57.814c16.813,3.302,33.685,6.478,50.179,11.186c20.36,5.812,40.188,12.971,59.669,21.245    c9.762,4.147,19.21,9.043,28.603,13.954c6.421,3.359,12.794,6.929,18.924,10.79c16.837,10.607,33.379,21.975,47.713,35.866    c1.224,1.186,2.409,2.407,3.507,3.713c-4.696-7.225-11.062-13.506-17.02-19.678c-7.16-7.423-14.915-14.383-22.87-20.939    c-13.376-11.024-27.275-21.262-41.966-30.473c-18.299-11.475-37.273-21.747-57.018-30.516    c-9.712-4.312-19.487-8.263-29.408-12.067c-8.945-3.43-18.041-6.346-27.141-9.334c-3.299-1.081-6.789-2.622-10.312-2.638    c-4.776-0.02-9.366,2.397-12.069,6.333C68.591,43.754,73.538,55.828,83.641,57.814z" />
                                                <g>
                                                    <path d="M597.956,121.095c-6.069-0.215-12.345-0.321-18.652-0.321c-77.241,0-155.798,15.725-205.9,28.177v420.89     c49.157-20.861,135.302-53.093,226.234-66.951c7.11-1.083,12.362-7.196,12.362-14.388V135.639     C612,127.801,605.79,121.37,597.956,121.095z" />
                                                </g>
                                                <path d="M348.941,150.092c-15.606,7.017-29.248,10.282-42.941,10.282s-27.335-3.266-42.941-10.282l-2.806-1.331    c0,0.012,0,0.025,0,0.035c0.007,76.82,0.003,200.05,0.002,281.233l-0.002,139.81c0.592,2.189,11.018,13.238,45.747,13.238    c34.731,0,45.155-11.046,45.747-13.235V148.8c0-0.015,0-0.027,0-0.037L348.941,150.092z" />
                                                <g>
                                                    <path d="M14.044,121.095C6.208,121.37,0,127.801,0,135.639v352.86c0,7.191,5.252,13.305,12.362,14.388     c90.934,13.857,177.078,46.091,226.235,66.951l0.003-131.13c0.002-93.489,0.003-201.174-0.003-289.761     c-50.102-12.448-128.661-28.174-205.902-28.174C26.389,120.774,20.112,120.881,14.044,121.095z" />
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="ml-2">My Sastra</span>
                                </span>
                            </router-link>
                            <span @click="this.$emit('logoutModal')" class="py-1 cursor-pointer hidden xs:block">
                                <span class="py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="ml-2">Logout</span>
                                </span>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <post-sastra-modal
        :show="showPostSastraModal"
        @close="showPostSastraModal = false"
    ></post-sastra-modal>

</template>

<script>
import NoImage from './NoImage.vue'
import LogoComp from './LogoComp.vue'
import { mapGetters } from 'vuex';
import PostSastraModal from './PostSastraModal.vue';

export default {
    name: 'SidebarComp',
    emits: ['logoutModal'],
    components: {
        NoImage,
        LogoComp,
        PostSastraModal,
    },
    data() {
        return{
            showPostSastraModal: false
        }
    },
    computed: {
        ...mapGetters(['user','addsastranotif'])
    },
}
</script>
