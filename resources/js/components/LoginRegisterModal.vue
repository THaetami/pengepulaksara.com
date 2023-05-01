<template>
    <div class="modal-mask" style="background-color: rgba(0, 0, 0, 0.5)">
        <div class="modal-wrapper">
            <div class="min-h-full md:min-h-12 bg-white md:bg-transparent flex justify-center py-0 md:py-12">
                <div class="container">
                    <div class="flex justify-between items-start p-0 md:dark:border-gray-600">
                    <div  @click="back" class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                    <slot name="form">

                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LoginRegisterModal',
    data() {
        return {
        }
    },
    methods: {
        back() {
            const page = localStorage.getItem('page');
            if (page) {
                const goBackPage = Math.max(0, parseInt(page) + 1);
                this.$router.go(-goBackPage);
            } else {
                this.$router.go(-1);
            }
            localStorage.removeItem('page');
        }
    }
}
</script>

<style scoped>

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: table;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}


.container{
  background: #fff;
  max-width: 350px;
  width: 100%;
  padding: 10px 30px;
  border-radius: 5px;
}

</style>
