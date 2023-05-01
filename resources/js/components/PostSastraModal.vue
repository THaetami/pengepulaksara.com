<template>
<div v-if="show" class="overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-0 z-50 bottom-2 justify-center items-center h-full md:inset-0 flex xs:bg-black xs:bg-opacity-50">
    <div class="relative px-0 py-0 sl:py-[40px] lr:py-[110px] w-full max-w-2xl h-full">
        <div class="relative bg-white md:shadow dark:bg-gray-700 rounded-none md:rounded-sm">
            <div class="flex justify-between items-start p-0 md:border-b md:dark:border-gray-600">
                <button @click="$emit('close')" type="button" data-modal-toggle="defaultModal" class="buka text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="p-1 space-y-1">
                <div class="md:border md:border-slate-200 md:p-2 md:shadow-sm w-full">
                    <form-comp
                        @close="$emit('close')"
                    ></form-comp>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import FormComp from './FormSastraComp.vue'
export default {
    name: 'FromPost',
    props: ['show'],
    components: {
        FormComp
    }
}
</script>

<style scoped>

</style>
