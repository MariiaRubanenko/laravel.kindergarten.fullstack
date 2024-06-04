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
  width: 30px;
  height: 30px;
  margin-right: 10px;

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

@media (max-width: 450px) {
  .cube {
    width: 25px;
    height: 25px;
    margin-right: 8px;
  }
}

// -----------------------------------------------------

@keyframes left {
  40% {
    transform: translateX(-60px);
  }
  50% {
    transform: translateX(0);
  }
}

@keyframes right {
  40% {
    transform: translateX(60px);
  }
  50% {
    transform: translateX(0);
  }
}
</style>
