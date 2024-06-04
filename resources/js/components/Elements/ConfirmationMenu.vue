<template>
  <div class="custom-modal" v-if="showModal">
    <div class="modal-content">
      <h4>{{ message }}</h4>
      <div class="text-center">
        <button class="btn btn-danger px-4" @click="confirm">
          {{ buttonConfirm }}
        </button>
        <button class="btn btn-primary px-4" @click="cancel">
          {{ buttonCancel }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showModal: {
      type: Boolean,
      required: true,
    },
    message: {
      type: String,
      default: "",
    },
    buttonConfirm: {
      type: String,
      default: "",
    },
    buttonCancel: {
      type: String,
      default: "",
    },
  },
  methods: {
    confirm() {
      this.$emit("confirm");
    },
    cancel() {
      this.$emit("cancel");
    },
  },
};
</script>

<style scoped>
.custom-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999; /* Задаем высокий z-index, чтобы модальное окно было поверх всего */
}

.modal-content {
  align-items: center;
  margin-left: calc(2rem + 32px);
  width: 50%;
  background-color: var(--yellow-light-box);
  border: 1px solid var(--green-light);
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  position: relative; /* Добавляем относительное позиционирование для корректной работы z-index */
  z-index: 99999; /* Задаем высокий z-index, чтобы модальное окно было поверх всего */
}

.modal-content h4 {
  text-align: center;
  margin-bottom: 10px;
}

.modal-content button {
  align-items: center;
  margin-right: 10px;
  margin-bottom: 0.5rem;
}
</style>
