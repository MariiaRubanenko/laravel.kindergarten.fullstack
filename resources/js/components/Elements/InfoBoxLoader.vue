<template>
  <div class="page-loader" v-if="loading">
    <div class="cube"></div>
    <div class="cube"></div>
    <div class="cube"></div>
  </div>
</template>

<script>
export default {
  props: {
    loading: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss" scoped>
$colors: var(--green-light), var(--red-main), var(--orange);

// -----------------------------------------------------

.page-loader {
  display: flex;
  justify-content: center;
  align-items: center;
}

// -----------------------------------------------------

.cube {
  width: 1rem;
  height: 1rem;
  margin: 0.25rem;
  margin-right: 5px;

  @for $i from 1 through length($colors) {
    &:nth-child(#{$i}) {
      background-color: nth($colors, $i);
    }
  }

  &:first-child {
    animation: left 1s infinite;
  }

  &:last-child {
    animation: right 1s infinite 0.5s;
  }
}

// -----------------------------------------------------

@keyframes left {
  40% {
    transform: translateX(-30px);
  }
  50% {
    transform: translateX(0);
  }
}

@keyframes right {
  40% {
    transform: translateX(30px);
  }
  50% {
    transform: translateX(0);
  }
}
</style>
