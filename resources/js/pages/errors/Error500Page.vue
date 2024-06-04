<template>
  <div class="vertical-center">
    <div class="container-fluid">
      <div class="container">
        <div class="row justify-content-center">
          <div class="text-center">
            <h1>Error 500</h1>
            <router-link :to="`/`" class="button">
              <span class="text">{{ $t("Home") }}</span>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
