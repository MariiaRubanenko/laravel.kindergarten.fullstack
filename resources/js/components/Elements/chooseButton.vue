<template>
  <button :class="{ 'btn-choose': true, selected: selected }" type="button">
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "ChooseButton",
  props: {
    selected: Boolean,
  },
};
</script>

<style scoped>
.btn-choose {
  border-radius: 5px;
  flex: 3;
  display: block;
  margin-bottom: 0.5rem;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: var(--yellow-light-box);
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 5px;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-choose:hover {
  color: var(--yellow-light-box);
  background-color: rgba(129, 199, 46, 0.8);
  border-color: #81c72e;
}

.btn-choose:focus,
.btn-choose.focus {
  box-shadow: 0 0 0 0.2rem rgba(144, 214, 62, 0.5);
  outline: none;
}

.btn-choose.disabled,
.btn-choose:disabled {
  color: #81c72e;
  background-color: transparent;
}

.btn-choose:not(:disabled):not(.disabled):active,
.btn-choose:not(:disabled):not(.disabled).active,
.show > .btn-choose.dropdown-toggle {
  color: var(--yellow-light-box);
  background-color: #81c72e;
  border-color: #81c72e;
}

.btn-choose:not(:disabled):not(.disabled):active:focus,
.btn-choose:not(:disabled):not(.disabled).active:focus,
.show > .btn-choose.dropdown-toggle:focus {
  box-shadow: 0 0 0 0.2rem rgba(144, 214, 62, 0.5);
}

.selected {
  box-shadow: 0 0 0 0.2rem rgba(144, 214, 62, 0.5);
}
</style>
