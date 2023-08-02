<template>
  <div class="fixed inset-0 flex items-center justify-center z-10">
    <div class="modal-overlay absolute inset-0 bg-white md:bg-gray-800 md:opacity-50 opacity-none"></div>

    <div class="modal-container bg-white w-full xs:w-11/12 md:max-w-md mx-auto rounded z-50 overflow-auto">
      <div class="modal-content py-4 text-left px-[2rem] xs:px-[8rem] md:px-[3rem]">
        <div v-if="isShowButton" class="flex justify-between items-center pb-3">
          <p class="text-2xl font-bold">{{ $route.name.slice(0, -4) }}</p>
          <button @click="back" class="modal-close cursor-pointer z-50">
            <svg
              class="fill-current w-10 h-10 text-gray-600 hover:text-gray-900"
              xmlns="http://www.w3.org/2000/svg"
              width="18"
              height="18"
              viewBox="0 0 18 18"
            >
              <path
                d="M6.293 6.293a1 1 0 011.414 0L9 7.586l1.293-1.293a1 1 0 111.414 1.414L10.414 9l1.293 1.293a1 1 0 01-1.414 1.414L9 10.414l-1.293 1.293a1 1 0 01-1.414-1.414L7.586 9 6.293 7.707a1 1 0 010-1.414z"
              ></path>
            </svg>
          </button>
        </div>

        <slot name="form"></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'LoginRegisterModal',
    computed: {
        isShowButton() {
            return this.$route.name !== 'SocialLogin';
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
.modal-overlay {
  z-index: -1;
}

.modal-container {
  max-height: 90vh;
}

.modal-content {
  max-height: 100%;
}
</style>
