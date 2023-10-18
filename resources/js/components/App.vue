<template>
  <div class="container m-auto">
    <div class="row text-center">
      <h1>Laravel & Vue</h1>

      <!-- Add buttons for Products and Categories -->
      <div class="row">
        <div class="col-md-6">
          <router-link to="/category-list" class="btn btn-primary mx-2"
            >Categories List</router-link
          >
          <router-link to="/category-create" class="btn btn-primary mx-2"
            >Create Category</router-link
          >
        </div>
        <div class="col-md-6">
          <router-link to="/product-list" class="btn btn-primary mx-2"
            >Products List</router-link
          >
          <router-link to="/product-create" class="btn btn-primary mx-2"
            >Create Product</router-link
          >
        </div>
      </div>
    </div>

    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: "App",
};
</script>
