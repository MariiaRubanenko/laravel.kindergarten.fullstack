<template>
  <div class="pb-2 select2-container">
    <select
      :id="id"
      :name="name"
      :disabled="disabled"
      :required="required"
    ></select>
  </div>
</template>

<script>
import $ from "jquery";
import "select2/dist/js/select2.full";
import "select2/dist/css/select2.min.css";
/* eslint-disable */
export default {
  name: "Select2",
  data() {
    return {
      select2: null,
    };
  },
  emits: ["update:modelValue"],
  props: {
    modelValue: [String, Array], // previously was `value: String`
    id: {
      type: String,
      default: "",
    },
    name: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    options: {
      type: Array,
      default: () => [],
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
    settings: {
      type: Object,
      default: () => {},
    },
  },
  watch: {
    options: {
      handler(val) {
        this.setOption(val);
      },
      deep: true,
    },
    modelValue: {
      handler(val) {
        this.setValue(val);
      },
      deep: true,
    },
  },
  methods: {
    setOption(val = []) {
      this.select2.empty();
      this.select2.select2({
        placeholder: this.placeholder,
        ...this.settings,
        data: val,
      });
      this.setValue(this.modelValue);
    },
    setValue(val) {
      if (val instanceof Array) {
        this.select2.val([...val]);
      } else {
        this.select2.val([val]);
      }
      this.select2.trigger("change");
    },
  },
  mounted() {
    this.select2 = $(this.$el)
      .find("select")
      .select2({
        placeholder: this.placeholder,
        ...this.settings,
        data: this.options,
      })
      .on("select2:select select2:unselect", (ev) => {
        this.$emit("update:modelValue", this.select2.val());
        this.$emit("select", ev["params"]["data"]);
      });
    this.setValue(this.modelValue);
  },
  beforeUnmount() {
    this.select2.select2("destroy");
  },
};
</script>

<style>
.select2-container {
  flex: 6;
  display: block;
}

@media (max-width: 450px) {
  .select2-container {
    width: 100%;
  }
}

.select2-container .select2-selection--single {
  padding: 0.375rem 0.75rem;
  height: calc(1.5em + 0.75rem + 2px);
  font-size: 1rem;
  font-weight: 400;
  color: #495057;
  background-color: var(--yellow-light-box);
  background-clip: padding-box;
  border: 1px solid var(--grey-border);
  border-radius: 5px;
}

/* Стилизация элементов списка */
.select2-container .select2-results__option {
  padding: 5px;
  background-color: var(--yellow-light-box);
}

/* Изменение цвета выделения при выборе */
.select2-container--focus .select2-selection--single {
  border-color: #a3e851;
  outline: none;
  box-shadow: 0 0 0 0.2rem rgba(107, 189, 13, 0.25);
}

/* Стилизация элементов списка при наведении */
.select2-container .select2-results__option:hover {
  background-color: rgba(129, 199, 46, 0.75);
  outline: none !important;
}

/* Стилизация элементов выбора в выпадающем списке при наведении */
.select2-container .select2-results__option--highlighted {
  background-color: #81c72e;
  outline: none;
}

/* Стилизация контейнера поля поиска */
.select2-container .select2-search--dropdown {
  background-color: var(--yellow-light-back);
}

/* Стилизация поля ввода */
.select2-container .select2-search__field {
  width: 100%;
  color: #495057;
  font-size: 1rem;
  font-weight: 400;
  background-color: var(--yellow-light-box);
  border-color: #a3e851;
  outline: none !important;
  box-shadow: 0 0 0 0.2rem rgba(107, 189, 13, 0.25);
  box-sizing: border-box;
}

/* Стилизация поля ввода при фокусе */
.select2-container .select2-search__field:focus {
  border-color: #a3e851;
  outline: none !important;
  box-shadow: 0 0 0 0.2rem rgba(107, 189, 13, 0.25);
}

/* Стилизация иконки открытия*/
.select2-container .select2-selection__arrow {
  margin-top: 5px;
  margin-right: 10px;
}

.select2-container--default
  .select2-results__option--highlighted[aria-selected] {
  background-color: rgba(129, 199, 46, 0.75);
}

.select2-container--default .select2-results__option[aria-selected="true"] {
  color: #495057;
  background-color: rgba(129, 199, 46);
}
</style>
